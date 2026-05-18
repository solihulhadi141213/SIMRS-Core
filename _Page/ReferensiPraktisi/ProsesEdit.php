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
    // ESCAPE STRING
    // =========================================================================
    $nama_praktisi    = mysqli_real_escape_string($Conn, $nama_praktisi);
    $nik_praktisi     = mysqli_real_escape_string($Conn, $nik_praktisi);
    $kontak_praktisi  = mysqli_real_escape_string($Conn, $kontak_praktisi);
    $email_praktisi   = mysqli_real_escape_string($Conn, $email_praktisi);
    $id_practitioner  = mysqli_real_escape_string($Conn, $id_practitioner);
    $tipe_praktisi    = mysqli_real_escape_string($Conn, $tipe_praktisi);
    $profesi_praktisi = mysqli_real_escape_string($Conn, $profesi_praktisi);

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
    $queryCheck = mysqli_query($Conn, "
        SELECT *
        FROM praktisi
        WHERE id_praktisi='$id_praktisi'
        LIMIT 1
    ");

    if (mysqli_num_rows($queryCheck) == 0) {

        $response['message'] = 'Data praktisi tidak ditemukan.';

        echo json_encode($response);
        exit;
    }

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
    $queryNik = mysqli_query($Conn, "
        SELECT id_praktisi
        FROM praktisi
        WHERE nik_praktisi='$nik_praktisi'
        AND id_praktisi != '$id_praktisi'
        LIMIT 1
    ");

    if (mysqli_num_rows($queryNik) > 0) {

        $response['message'] = 'NIK praktisi sudah digunakan.';

        echo json_encode($response);
        exit;
    }

    // =========================================================================
    // VALIDASI DUPLIKAT EMAIL
    // =========================================================================
    if (!empty($email_praktisi)) {

        $queryEmail = mysqli_query($Conn, "
            SELECT id_praktisi
            FROM praktisi
            WHERE email_praktisi='$email_praktisi'
            AND id_praktisi != '$id_praktisi'
            LIMIT 1
        ");

        if (mysqli_num_rows($queryEmail) > 0) {

            $response['message'] = 'Email praktisi sudah digunakan.';

            echo json_encode($response);
            exit;
        }
    }

    // =========================================================================
    // VALIDASI DUPLIKAT ID PRACTITIONER
    // =========================================================================
    if (!empty($id_practitioner)) {

        $queryPractitioner = mysqli_query($Conn, "
            SELECT id_praktisi
            FROM praktisi
            WHERE id_practitioner='$id_practitioner'
            AND id_praktisi != '$id_praktisi'
            LIMIT 1
        ");

        if (mysqli_num_rows($queryPractitioner) > 0) {

            $response['message'] = 'ID Practitioner sudah digunakan.';

            echo json_encode($response);
            exit;
        }
    }

    // =========================================================================
    // VALIDASI ID AKSES
    // =========================================================================
    if (!empty($id_akses)) {

        $id_akses = (int) $id_akses;

        $queryAkses = mysqli_query($Conn, "
            SELECT id_akses
            FROM akses
            WHERE id_akses='$id_akses'
            LIMIT 1
        ");

        if (mysqli_num_rows($queryAkses) == 0) {

            $response['message'] = 'ID akses tidak ditemukan.';

            echo json_encode($response);
            exit;
        }

    } else {

        $id_akses = "NULL";
    }

    // =========================================================================
    // VALIDASI ID DOKTER
    // =========================================================================
    if (!empty($id_dokter)) {

        $id_dokter = (int) $id_dokter;

        $queryDokter = mysqli_query($Conn, "
            SELECT id_dokter
            FROM dokter
            WHERE id_dokter='$id_dokter'
            LIMIT 1
        ");

        if (mysqli_num_rows($queryDokter) == 0) {

            $response['message'] = 'ID dokter tidak ditemukan.';

            echo json_encode($response);
            exit;
        }

    } else {

        $id_dokter = "NULL";
    }

    // =========================================================================
    // QUERY UPDATE
    // =========================================================================
    $update = mysqli_query($Conn, "
        UPDATE praktisi SET

            id_practitioner = ".(!empty($id_practitioner) ? "'$id_practitioner'" : "NULL").",
            tipe_praktisi   = '$tipe_praktisi',
            profesi_praktisi= '$profesi_praktisi',
            nama_praktisi   = '$nama_praktisi',
            nik_praktisi    = '$nik_praktisi',
            kontak_praktisi = ".(!empty($kontak_praktisi) ? "'$kontak_praktisi'" : "NULL").",
            email_praktisi  = ".(!empty($email_praktisi) ? "'$email_praktisi'" : "NULL").",
            id_akses        = $id_akses,
            id_dokter       = $id_dokter

        WHERE id_praktisi='$id_praktisi'
    ");

    // =========================================================================
    // RESULT
    // =========================================================================
    if ($update) {

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