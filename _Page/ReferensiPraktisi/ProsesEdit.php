<?php
    // =========================================================================
    // HEADER JSON
    // =========================================================================
    header('Content-Type: application/json');

    // =========================================================================
    // TIMEZONE
    // =========================================================================
    date_default_timezone_set('Asia/Jakarta');

    // =========================================================================
    // CONNECTION, FUNCTION & SESSION
    // =========================================================================
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // =========================================================================
    // DEFAULT RESPONSE
    // =========================================================================
    $response = [
        'status'  => 'error',
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
    // TANGKAP DATA
    // =========================================================================
    $id_praktisi       = (int) ($_POST['id_praktisi'] ?? 0);

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
    // VALIDASI ID PRAKTISI
    // =========================================================================
    if (empty($id_praktisi)) {

        $response['message'] = 'ID Praktisi tidak valid.';

        echo json_encode($response);
        exit;
    }

    // =========================================================================
    // VALIDASI DATA PRAKTISI ADA
    // =========================================================================
    // Prepared Statement: verify that the practitioner record exists.
    $stmtCheck = mysqli_prepare($Conn, "
        SELECT *
        FROM praktisi
        WHERE id_praktisi=?
        LIMIT 1
    ");
    mysqli_stmt_bind_param($stmtCheck, 'i', $id_praktisi);
    mysqli_stmt_execute($stmtCheck);
    $queryCheck = mysqli_stmt_get_result($stmtCheck);

    if (mysqli_num_rows($queryCheck) == 0) {
        mysqli_stmt_close($stmtCheck);

        $response['message'] = 'Data praktisi tidak ditemukan.';

        echo json_encode($response);
        exit;
    }
    mysqli_stmt_close($stmtCheck);

    // =========================================================================
    // VALIDASI MANDATORY
    // =========================================================================
    if (empty($nama_praktisi)) {

        $response['message'] = 'Nama praktisi tidak boleh kosong.';

        echo json_encode($response);
        exit;
    }

    if (empty($nik_praktisi)) {

        $response['message'] = 'NIK praktisi tidak boleh kosong.';

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
    // Prepared Statement: check whether another practitioner uses this NIK.
    $stmtNik = mysqli_prepare($Conn, "
        SELECT id_praktisi
        FROM praktisi
        WHERE nik_praktisi=?
        AND id_praktisi != ?
        LIMIT 1
    ");
    mysqli_stmt_bind_param($stmtNik, 'si', $nik_praktisi, $id_praktisi);
    mysqli_stmt_execute($stmtNik);
    $queryNik = mysqli_stmt_get_result($stmtNik);

    if (mysqli_num_rows($queryNik) > 0) {
        mysqli_stmt_close($stmtNik);

        $response['message'] = 'NIK praktisi sudah digunakan.';

        echo json_encode($response);
        exit;
    }
    mysqli_stmt_close($stmtNik);

    // =========================================================================
    // VALIDASI DUPLIKAT EMAIL
    // =========================================================================
    if (!empty($email_praktisi)) {

        // Prepared Statement: check whether another practitioner uses this email.
        $stmtEmail = mysqli_prepare($Conn, "
            SELECT id_praktisi
            FROM praktisi
            WHERE email_praktisi=?
            AND id_praktisi != ?
            LIMIT 1
        ");
        mysqli_stmt_bind_param($stmtEmail, 'si', $email_praktisi, $id_praktisi);
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

        // Prepared Statement: check whether another record uses this practitioner ID.
        $stmtPractitioner = mysqli_prepare($Conn, "
            SELECT id_praktisi
            FROM praktisi
            WHERE id_practitioner=?
            AND id_praktisi != ?
            LIMIT 1
        ");
        mysqli_stmt_bind_param($stmtPractitioner, 'si', $id_practitioner, $id_praktisi);
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

            $response['message'] = 'ID akses tidak ditemukan.';

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

            $response['message'] = 'ID dokter tidak ditemukan.';

            echo json_encode($response);
            exit;
        }
        mysqli_stmt_close($stmtDokter);

    } else {

        $id_dokter = "NULL";
    }

    // =========================================================================
    // QUERY UPDATE
    // =========================================================================
    $id_practitioner_db = !empty($id_practitioner) ? $id_practitioner : null;
    $kontak_praktisi_db = !empty($kontak_praktisi) ? $kontak_praktisi : null;
    $email_praktisi_db = !empty($email_praktisi) ? $email_praktisi : null;
    $id_akses_db = $id_akses === "NULL" ? null : $id_akses;
    $id_dokter_db = $id_dokter === "NULL" ? null : $id_dokter;

    // Prepared Statement: update the practitioner record.
    $stmtUpdate = mysqli_prepare($Conn, "
        UPDATE praktisi SET

            id_practitioner = ?,
            tipe_praktisi   = ?,
            profesi_praktisi= ?,
            nama_praktisi   = ?,
            nik_praktisi    = ?,
            kontak_praktisi = ?,
            email_praktisi  = ?,
            id_akses        = ?,
            id_dokter       = ?

        WHERE id_praktisi=?
    ");
    mysqli_stmt_bind_param(
        $stmtUpdate,
        'sssssssiii',
        $id_practitioner_db,
        $tipe_praktisi,
        $profesi_praktisi,
        $nama_praktisi,
        $nik_praktisi,
        $kontak_praktisi_db,
        $email_praktisi_db,
        $id_akses_db,
        $id_dokter_db,
        $id_praktisi
    );
    $update = mysqli_stmt_execute($stmtUpdate);
    mysqli_stmt_close($stmtUpdate);

    // =========================================================================
    // RESULT
    // =========================================================================
    if ($update) {

        // Simpan Log
        $category_log = 'Referensi Tenaga Medis';
        $title_log    = 'Edit Praktisi';
        $logMetadata  = json_encode([
            'id_praktisi'       => $id_praktisi,
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
        $response['message'] = 'Data praktisi berhasil diperbarui.';

    } else {

        $response['message'] = 'Gagal memperbarui data praktisi.';
    }

    // =========================================================================
    // OUTPUT JSON
    // =========================================================================
    echo json_encode($response);
?>