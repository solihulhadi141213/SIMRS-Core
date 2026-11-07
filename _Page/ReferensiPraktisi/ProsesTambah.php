<?php
    // Header JSON
    header('Content-Type: application/json');

    // Timezone
    date_default_timezone_set('Asia/Jakarta');

    // Connection, Function & Session
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // Default Response
    $response = [
        'status' => 'error',
        'message' => 'Terjadi kesalahan.'
    ];

    // =========================================================================
    // VALIDASI SESSION
    // =========================================================================
    if (empty($SessionIdAkses)) {
        $response['message'] = 'Sesi akses berakhir, silakan login ulang.';
        echo json_encode($response);
        exit;
    }

    // =========================================================================
    // VALIDASI METHOD
    // =========================================================================
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $response['message'] = 'Metode request tidak valid.';
        echo json_encode($response);
        exit;
    }

    // =========================================================================
    // TANGKAP & VALIDASI INPUT
    // =========================================================================
    $nama_praktisi     = trim($_POST['nama_praktisi'] ?? '');
    $nik_praktisi      = trim($_POST['nik_praktisi'] ?? '');
    $kontak_praktisi   = trim($_POST['kontak_praktisi'] ?? '');
    $email_praktisi    = trim($_POST['email_praktisi'] ?? '');
    $id_practitioner   = trim($_POST['id_practitioner'] ?? '');
    $tipe_praktisi     = trim($_POST['tipe_praktisi'] ?? '');
    $profesi_praktisi  = trim($_POST['profesi_praktisi'] ?? '');
    $id_akses          = trim($_POST['id_akses'] ?? '');
    $id_dokter         = trim($_POST['id_dokter'] ?? '');

    // =========================================================================
    // VALIDASI REQUIRED
    // =========================================================================
    if (empty($nama_praktisi)) {
        $response['message'] = 'Nama praktisi tidak boleh kosong.';
        echo json_encode($response);
        exit;
    }

    if (empty($nik_praktisi)) {
        $response['message'] = 'NIK/KTP praktisi tidak boleh kosong.';
        echo json_encode($response);
        exit;
    }

    if (empty($tipe_praktisi)) {
        $response['message'] = 'Tipe praktisi tidak boleh kosong.';
        echo json_encode($response);
        exit;
    }

    if (empty($profesi_praktisi)) {
        $response['message'] = 'Profesi praktisi tidak boleh kosong.';
        echo json_encode($response);
        exit;
    }

    // =========================================================================
    // VALIDASI EMAIL
    // =========================================================================
    if (!empty($email_praktisi)) {

        if (!filter_var($email_praktisi, FILTER_VALIDATE_EMAIL)) {
            $response['message'] = 'Format email tidak valid.';
            echo json_encode($response);
            exit;
        }
    }

    // =========================================================================
    // VALIDASI DUPLIKAT NIK
    // =========================================================================
    // Prepared Statement: check whether the practitioner NIK is already used.
    $stmtNik = mysqli_prepare($Conn, "
        SELECT id_praktisi 
        FROM praktisi 
        WHERE nik_praktisi=?
        LIMIT 1
    ");
    mysqli_stmt_bind_param($stmtNik, 's', $nik_praktisi);
    mysqli_stmt_execute($stmtNik);
    $queryNik = mysqli_stmt_get_result($stmtNik);

    if (mysqli_num_rows($queryNik) > 0) {
        mysqli_stmt_close($stmtNik);
        $response['message'] = 'NIK praktisi sudah terdaftar.';
        echo json_encode($response);
        exit;
    }
    mysqli_stmt_close($stmtNik);

    // =========================================================================
    // VALIDASI DUPLIKAT EMAIL
    // =========================================================================
    if (!empty($email_praktisi)) {

        // Prepared Statement: check whether the practitioner email is already used.
        $stmtEmail = mysqli_prepare($Conn, "
            SELECT id_praktisi 
            FROM praktisi 
            WHERE email_praktisi=?
            LIMIT 1
        ");
        mysqli_stmt_bind_param($stmtEmail, 's', $email_praktisi);
        mysqli_stmt_execute($stmtEmail);
        $queryEmail = mysqli_stmt_get_result($stmtEmail);

        if (mysqli_num_rows($queryEmail) > 0) {
            mysqli_stmt_close($stmtEmail);
            $response['message'] = 'Email praktisi sudah digunakan.';
            echo json_encode($response);
            exit;
        }
        mysqli_stmt_close($stmtEmail);
    }

    // =========================================================================
    // VALIDASI DUPLIKAT ID PRACTITIONER
    // =========================================================================
    if (!empty($id_practitioner)) {

        // Prepared Statement: check whether the practitioner ID is already used.
        $stmtPractitioner = mysqli_prepare($Conn, "
            SELECT id_praktisi 
            FROM praktisi 
            WHERE id_practitioner=?
            LIMIT 1
        ");
        mysqli_stmt_bind_param($stmtPractitioner, 's', $id_practitioner);
        mysqli_stmt_execute($stmtPractitioner);
        $queryPractitioner = mysqli_stmt_get_result($stmtPractitioner);

        if (mysqli_num_rows($queryPractitioner) > 0) {
            mysqli_stmt_close($stmtPractitioner);
            $response['message'] = 'ID Practitioner sudah digunakan.';
            echo json_encode($response);
            exit;
        }
        mysqli_stmt_close($stmtPractitioner);
    }

    // =========================================================================
    // VALIDASI ID AKSES
    // =========================================================================
    if (!empty($id_akses)) {

        $id_akses = (int) $id_akses;

        // Prepared Statement: validate the selected access record.
        $stmtAkses = mysqli_prepare($Conn, "
            SELECT id_akses 
            FROM akses 
            WHERE id_akses=?
            LIMIT 1
        ");
        mysqli_stmt_bind_param($stmtAkses, 'i', $id_akses);
        mysqli_stmt_execute($stmtAkses);
        $queryAkses = mysqli_stmt_get_result($stmtAkses);

        if (mysqli_num_rows($queryAkses) == 0) {
            mysqli_stmt_close($stmtAkses);
            $response['message'] = 'ID akses tidak valid.';
            echo json_encode($response);
            exit;
        }
        mysqli_stmt_close($stmtAkses);
    } else {
        $id_akses = "NULL";
    }

    // =========================================================================
    // VALIDASI ID DOKTER
    // =========================================================================
    if (!empty($id_dokter)) {

        $id_dokter = (int) $id_dokter;

        // Prepared Statement: validate the selected doctor record.
        $stmtDokter = mysqli_prepare($Conn, "
            SELECT id_dokter 
            FROM dokter 
            WHERE id_dokter=?
            LIMIT 1
        ");
        mysqli_stmt_bind_param($stmtDokter, 'i', $id_dokter);
        mysqli_stmt_execute($stmtDokter);
        $queryDokter = mysqli_stmt_get_result($stmtDokter);

        if (mysqli_num_rows($queryDokter) == 0) {
            mysqli_stmt_close($stmtDokter);
            $response['message'] = 'ID dokter tidak valid.';
            echo json_encode($response);
            exit;
        }
        mysqli_stmt_close($stmtDokter);
    } else {
        $id_dokter = "NULL";
    }

    // =========================================================================
    // INSERT DATA
    // =========================================================================
    $id_practitioner_db = !empty($id_practitioner) ? $id_practitioner : null;
    $kontak_praktisi_db = !empty($kontak_praktisi) ? $kontak_praktisi : null;
    $email_praktisi_db = !empty($email_praktisi) ? $email_praktisi : null;
    $id_akses_db = $id_akses === "NULL" ? null : $id_akses;
    $id_dokter_db = $id_dokter === "NULL" ? null : $id_dokter;

    // Prepared Statement: insert the new practitioner.
    $stmtInsert = mysqli_prepare($Conn, "
        INSERT INTO praktisi (
            id_practitioner,
            tipe_praktisi,
            profesi_praktisi,
            nama_praktisi,
            nik_praktisi,
            kontak_praktisi,
            email_praktisi,
            id_akses,
            id_dokter
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");
    mysqli_stmt_bind_param(
        $stmtInsert,
        'sssssssii',
        $id_practitioner_db,
        $tipe_praktisi,
        $profesi_praktisi,
        $nama_praktisi,
        $nik_praktisi,
        $kontak_praktisi_db,
        $email_praktisi_db,
        $id_akses_db,
        $id_dokter_db
    );
    $insert = mysqli_stmt_execute($stmtInsert);
    mysqli_stmt_close($stmtInsert);

    // =========================================================================
    // INSERT RESULT
    // =========================================================================
    if ($insert) {

        // Simpan Log
        $category_log = 'Referensi Tenaga Medis';
        $title_log    = 'Tambah Praktisi';
        $logMetadata  = json_encode([
            'nama_praktisi'     => $nama_praktisi,
            'nik_praktisi'      => $nik_praktisi,
            'tipe_praktisi'     => $tipe_praktisi,
            'profesi_praktisi'  => $profesi_praktisi,
            'kontak_praktisi'   => $kontak_praktisi,
            'email_praktisi'    => $email_praktisi,
            'id_practitioner'   => $id_practitioner,
            'id_akses'          => $id_akses,
            'id_dokter'         => $id_dokter
        ]);
        SaveLog($Conn, $SessionIdAkses, $SessionNama, $title_log, $category_log, $logMetadata);

        $response['status'] = 'success';
        $response['message'] = 'Data praktisi berhasil disimpan.';

    } else {

        $response['message'] = 'Gagal menyimpan data praktisi.';
    }

    // =========================================================================
    // OUTPUT JSON
    // =========================================================================
    echo json_encode($response);
?>