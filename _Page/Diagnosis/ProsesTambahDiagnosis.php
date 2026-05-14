<?php
    header('Content-Type: application/json; charset=utf-8');

    // =====================================================
    // CONNECTION, FUNCTION & SESSION
    // =====================================================
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // =====================================================
    // RESPONSE DEFAULT
    // =====================================================
    $response = [
        'status'  => 'error',
        'message' => 'Terjadi kesalahan'
    ];

    // =====================================================
    // VALIDASI SESSION
    // =====================================================
    if (empty($SessionIdAkses)) {

        $response['message'] = 'Sesi akses sudah berakhir!';

        echo json_encode($response);
        exit;
    }

    // =====================================================
    // VALIDASI INPUT MANDATORY
    // =====================================================
    $required = [
        'id_kunjungan',
        'jenis_diagnosis',
        'id_dokter',
        'status_kepastian'
    ];

    foreach ($required as $field) {

        if (empty($_POST[$field])) {

            $response['message'] = 'Data wajib tidak lengkap!';

            echo json_encode($response);
            exit;
        }
    }

    // =====================================================
    // SANITASI INPUT
    // =====================================================
    $id_kunjungan     = validateAndSanitizeInput($_POST['id_kunjungan']);
    $jenis_diagnosis  = validateAndSanitizeInput($_POST['jenis_diagnosis']);
    $id_dokter        = validateAndSanitizeInput($_POST['id_dokter']);

    $diagnosis_text   = trim($_POST['diagnosis_text'] ?? '');
    $status_kasus     = trim($_POST['status_kasus'] ?? '');
    $icd_version      = trim($_POST['icd_version'] ?? '');
    $id_icd           = trim($_POST['id_icd'] ?? '');
    $status_kepastian = trim($_POST['status_kepastian'] ?? '');

    // =====================================================
    // VALIDASI ENUM
    // =====================================================
    $allowedDiagnosis = [
        'Admission',
        'Provisional',
        'Primary',
        'Secondary',
        'Working',
        'Differential',
        'Final'
    ];

    if (!in_array($jenis_diagnosis, $allowedDiagnosis)) {

        $response['message'] = 'Kategori diagnosis tidak valid!';

        echo json_encode($response);
        exit;
    }

    // =====================================================
    // VALIDASI STATUS KEPASTIAN
    // =====================================================
    if (!in_array($status_kepastian, ['Provisional', 'Final'])) {

        $response['message'] = 'Status diagnosis tidak valid!';

        echo json_encode($response);
        exit;
    }

    // =====================================================
    // VALIDASI STATUS KASUS
    // =====================================================
    if (!empty($status_kasus)) {

        $allowedKasus = ['Baru', 'Lama', 'Kambuh', 'Kronis'];

        if (!in_array($status_kasus, $allowedKasus)) {

            $response['message'] = 'Status kasus tidak valid!';

            echo json_encode($response);
            exit;
        }
    }

    // =====================================================
    // AMBIL DATA KUNJUNGAN + PASIEN
    // =====================================================
    $sqlKunjungan = "
        SELECT 
            id_pasien
        FROM kunjungan
        WHERE id_kunjungan = ?
    ";

    $stmtKunjungan = $Conn->prepare($sqlKunjungan);
    $stmtKunjungan->bind_param("i", $id_kunjungan);
    $stmtKunjungan->execute();

    $resultKunjungan = $stmtKunjungan->get_result();
    $dataKunjungan   = $resultKunjungan->fetch_assoc();

    $stmtKunjungan->close();

    if (empty($dataKunjungan)) {

        $response['message'] = 'Data kunjungan tidak ditemukan!';

        echo json_encode($response);
        exit;
    }

    $id_pasien = $dataKunjungan['id_pasien'];

    // =====================================================
    // AMBIL DATA DOKTER
    // =====================================================
    $sqlDokter = "
        SELECT 
            kode,
            nama
        FROM dokter
        WHERE id_dokter = ?
    ";

    $stmtDokter = $Conn->prepare($sqlDokter);
    $stmtDokter->bind_param("i", $id_dokter);
    $stmtDokter->execute();

    $resultDokter = $stmtDokter->get_result();
    $dataDokter   = $resultDokter->fetch_assoc();

    $stmtDokter->close();

    if (empty($dataDokter)) {

        $response['message'] = 'Data dokter tidak ditemukan!';

        echo json_encode($response);
        exit;
    }

    $dokter_kode = $dataDokter['kode'] ?? '';
    $dokter_nama = $dataDokter['nama'] ?? '';

    // =====================================================
    // DEFAULT ICD
    // =====================================================
    $icd_kode       = '';
    $icd_deskripsi  = '';

    // =====================================================
    // AMBIL DATA ICD
    // =====================================================
    if (!empty($id_icd)) {

        $sqlIcd = "
            SELECT
                kode,
                long_des
            FROM icd
            WHERE id_icd = ?
        ";

        $stmtIcd = $Conn->prepare($sqlIcd);
        $stmtIcd->bind_param("i", $id_icd);
        $stmtIcd->execute();

        $resultIcd = $stmtIcd->get_result();
        $dataIcd   = $resultIcd->fetch_assoc();

        $stmtIcd->close();

        if (!empty($dataIcd)) {

            $icd_kode      = $dataIcd['kode'] ?? '';
            $icd_deskripsi = $dataIcd['long_des'] ?? '';
        }
    }

    // =====================================================
    // CEK DATA DIAGNOSIS EXIST
    // =====================================================
    $sqlCheck = "
        SELECT 
            id_diagnosis
        FROM diagnosis
        WHERE 
            id_kunjungan = ?
            AND jenis_diagnosis = ?
        LIMIT 1
    ";

    $stmtCheck = $Conn->prepare($sqlCheck);
    $stmtCheck->bind_param("is", $id_kunjungan, $jenis_diagnosis);
    $stmtCheck->execute();

    $resultCheck = $stmtCheck->get_result();
    $dataCheck   = $resultCheck->fetch_assoc();

    $stmtCheck->close();

    // =====================================================
    // JIKA DATA SUDAH ADA -> UPDATE
    // =====================================================
    if (!empty($dataCheck)) {

        $id_diagnosis = $dataCheck['id_diagnosis'];

        $sqlUpdate = "
            UPDATE diagnosis SET
                dokter_id = ?,
                dokter_kode = ?,
                dokter_nama = ?,
                icd_version = ?,
                icd_kode = ?,
                icd_deskripsi = ?,
                diagnosis_text = ?,
                status_kasus = ?,
                status_kepastian = ?
            WHERE id_diagnosis = ?
        ";

        $stmtUpdate = $Conn->prepare($sqlUpdate);

        $stmtUpdate->bind_param(
            "issssssssi",
            $id_dokter,
            $dokter_kode,
            $dokter_nama,
            $icd_version,
            $icd_kode,
            $icd_deskripsi,
            $diagnosis_text,
            $status_kasus,
            $status_kepastian,
            $id_diagnosis
        );

        $proses = $stmtUpdate->execute();

        $stmtUpdate->close();

    } else {

        // =================================================
        // INSERT DATA BARU
        // =================================================
        $datetime_creat = date('Y-m-d H:i:s');

        $sqlInsert = "
            INSERT INTO diagnosis (
                id_kunjungan,
                id_pasien,
                dokter_id,
                dokter_kode,
                dokter_nama,
                jenis_diagnosis,
                icd_version,
                icd_kode,
                icd_deskripsi,
                diagnosis_text,
                status_kasus,
                status_kepastian,
                datetime_creat,
                petugas_id,
                petugas_nama
            ) VALUES (
                ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
            )
        ";

        $stmtInsert = $Conn->prepare($sqlInsert);

        $stmtInsert->bind_param(
            "iiissssssssssis",
            $id_kunjungan,
            $id_pasien,
            $id_dokter,
            $dokter_kode,
            $dokter_nama,
            $jenis_diagnosis,
            $icd_version,
            $icd_kode,
            $icd_deskripsi,
            $diagnosis_text,
            $status_kasus,
            $status_kepastian,
            $datetime_creat,
            $SessionIdAkses,
            $SessionNama
        );

        $proses = $stmtInsert->execute();

        $stmtInsert->close();
    }

    // =====================================================
    // RESPONSE
    // =====================================================
    if ($proses) {

        $response = [
            'status'        => 'success',
            'message'       => 'Data diagnosis berhasil disimpan',
            'id_kunjungan'  => $id_kunjungan
        ];

    } else {

        $response['message'] = 'Gagal menyimpan data diagnosis!';
    }

    // =====================================================
    // OUTPUT JSON
    // =====================================================
    echo json_encode($response);
?>