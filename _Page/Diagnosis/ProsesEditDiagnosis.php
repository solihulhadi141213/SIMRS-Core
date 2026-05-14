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
        'id_diagnosis',
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
    $id_diagnosis    = validateAndSanitizeInput($_POST['id_diagnosis']);
    $id_kunjungan    = validateAndSanitizeInput($_POST['id_kunjungan']);
    $jenis_diagnosis = validateAndSanitizeInput($_POST['jenis_diagnosis']);
    $id_dokter       = validateAndSanitizeInput($_POST['id_dokter']);

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

    if (!in_array($status_kepastian, ['Provisional', 'Final'])) {
        $response['message'] = 'Status diagnosis tidak valid!';

        echo json_encode($response);
        exit;
    }

    if (!empty($status_kasus)) {
        $allowedKasus = ['Baru', 'Lama', 'Kambuh', 'Kronis'];

        if (!in_array($status_kasus, $allowedKasus)) {
            $response['message'] = 'Status kasus tidak valid!';

            echo json_encode($response);
            exit;
        }
    }

    if (!empty($icd_version) && !in_array($icd_version, ['ICD10', 'ICD11'])) {
        $response['message'] = 'Versi ICD tidak valid!';

        echo json_encode($response);
        exit;
    }

    // =====================================================
    // CEK DATA DIAGNOSIS
    // =====================================================
    $sqlDiagnosis = "
        SELECT id_diagnosis
        FROM diagnosis
        WHERE id_diagnosis = ? AND id_kunjungan = ?
        LIMIT 1
    ";

    $stmtDiagnosis = $Conn->prepare($sqlDiagnosis);
    $stmtDiagnosis->bind_param("ii", $id_diagnosis, $id_kunjungan);
    $stmtDiagnosis->execute();

    $resultDiagnosis = $stmtDiagnosis->get_result();
    $dataDiagnosis   = $resultDiagnosis->fetch_assoc();

    $stmtDiagnosis->close();

    if (empty($dataDiagnosis)) {
        $response['message'] = 'Data diagnosis tidak ditemukan!';

        echo json_encode($response);
        exit;
    }

    // =====================================================
    // AMBIL DATA DOKTER
    // =====================================================
    $sqlDokter = "
        SELECT
            kode,
            nama
        FROM dokter
        WHERE id_dokter = ?
        LIMIT 1
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
    $icd_kode      = '';
    $icd_deskripsi = '';

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
            LIMIT 1
        ";

        $stmtIcd = $Conn->prepare($sqlIcd);
        $stmtIcd->bind_param("i", $id_icd);
        $stmtIcd->execute();

        $resultIcd = $stmtIcd->get_result();
        $dataIcd   = $resultIcd->fetch_assoc();

        $stmtIcd->close();

        if (empty($dataIcd)) {
            $response['message'] = 'Data ICD tidak ditemukan!';

            echo json_encode($response);
            exit;
        }

        $icd_kode      = $dataIcd['kode'] ?? '';
        $icd_deskripsi = $dataIcd['long_des'] ?? '';
    } else {
        $icd_version = '';
    }

    // =====================================================
    // UPDATE DATA
    // =====================================================
    $sqlUpdate = "
        UPDATE diagnosis SET
            dokter_id = ?,
            dokter_kode = ?,
            dokter_nama = ?,
            jenis_diagnosis = ?,
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
        "isssssssssi",
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
        $id_diagnosis
    );

    $proses = $stmtUpdate->execute();
    $stmtUpdate->close();

    // =====================================================
    // RESPONSE
    // =====================================================
    if ($proses) {
        $response = [
            'status'       => 'success',
            'message'      => 'Data diagnosis berhasil diperbarui',
            'id_kunjungan' => $id_kunjungan
        ];
    } else {
        $response['message'] = 'Gagal memperbarui data diagnosis!';
    }

    echo json_encode($response);
?>
