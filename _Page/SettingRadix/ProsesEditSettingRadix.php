<?php
    header('Content-Type: application/json');

    date_default_timezone_set('Asia/Jakarta');

    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    $response = [
        'status' => 'error',
        'message' => 'Terjadi kesalahan.'
    ];

    if (empty($SessionIdAkses)) {
        $response['message'] = 'Sesi akses berakhir, silakan login ulang.';
        echo json_encode($response);
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $response['message'] = 'Metode request tidak valid.';
        echo json_encode($response);
        exit;
    }

    $id_setting_radix = (int) ($_POST['id_setting_radix'] ?? 0);
    $setting_name     = trim($_POST['nama_setting_radix'] ?? '');
    $base_url         = trim($_POST['url_radix'] ?? '');
    $username         = trim($_POST['username'] ?? '');
    $password         = trim($_POST['password'] ?? '');
    $status           = isset($_POST['status']) ? 1 : 0;

    if (empty($id_setting_radix)) {
        $response['message'] = 'ID setting Radix tidak valid.';
        echo json_encode($response);
        exit;
    }

    if (empty($setting_name)) {
        $response['message'] = 'Profil pengaturan tidak boleh kosong.';
        echo json_encode($response);
        exit;
    }

    if (empty($base_url)) {
        $response['message'] = 'URL endpoint tidak boleh kosong.';
        echo json_encode($response);
        exit;
    }

    if (!filter_var($base_url, FILTER_VALIDATE_URL)) {
        $response['message'] = 'Format URL endpoint tidak valid.';
        echo json_encode($response);
        exit;
    }

    if (empty($username)) {
        $response['message'] = 'Username tidak boleh kosong.';
        echo json_encode($response);
        exit;
    }

    if (empty($password)) {
        $response['message'] = 'Password tidak boleh kosong.';
        echo json_encode($response);
        exit;
    }

    try {
        $stmtExist = mysqli_prepare(
            $Conn,
            "SELECT id_setting_radix FROM setting_radix WHERE id_setting_radix = ?"
        );

        if (!$stmtExist) {
            throw new Exception('Gagal menyiapkan validasi data.');
        }

        mysqli_stmt_bind_param($stmtExist, "i", $id_setting_radix);
        mysqli_stmt_execute($stmtExist);
        $resultExist = mysqli_stmt_get_result($stmtExist);

        if (!$resultExist || mysqli_num_rows($resultExist) === 0) {
            mysqli_stmt_close($stmtExist);
            $response['message'] = 'Data setting Radix tidak ditemukan.';
            echo json_encode($response);
            exit;
        }
        mysqli_stmt_close($stmtExist);

        $stmtCheck = mysqli_prepare(
            $Conn,
            "SELECT id_setting_radix
             FROM setting_radix
             WHERE setting_name = ?
             AND id_setting_radix != ?"
        );

        if (!$stmtCheck) {
            throw new Exception('Gagal menyiapkan validasi duplikasi data.');
        }

        mysqli_stmt_bind_param($stmtCheck, "si", $setting_name, $id_setting_radix);
        mysqli_stmt_execute($stmtCheck);
        $resultCheck = mysqli_stmt_get_result($stmtCheck);

        if ($resultCheck && mysqli_num_rows($resultCheck) > 0) {
            mysqli_stmt_close($stmtCheck);
            $response['message'] = 'Nama profil sudah digunakan.';
            echo json_encode($response);
            exit;
        }
        mysqli_stmt_close($stmtCheck);

        mysqli_begin_transaction($Conn);

        if ($status === 1) {
            $stmtNonAktif = mysqli_prepare(
                $Conn,
                "UPDATE setting_radix
                 SET status = 0
                 WHERE id_setting_radix != ?"
            );

            if (!$stmtNonAktif) {
                throw new Exception('Gagal menyiapkan update status.');
            }

            mysqli_stmt_bind_param($stmtNonAktif, "i", $id_setting_radix);

            if (!mysqli_stmt_execute($stmtNonAktif)) {
                mysqli_stmt_close($stmtNonAktif);
                throw new Exception('Gagal menonaktifkan profil lain.');
            }

            mysqli_stmt_close($stmtNonAktif);
        }

        $stmtUpdate = mysqli_prepare(
            $Conn,
            "UPDATE setting_radix SET
                setting_name = ?,
                base_url = ?,
                username = ?,
                password = ?,
                status = ?
             WHERE id_setting_radix = ?"
        );

        if (!$stmtUpdate) {
            throw new Exception('Gagal menyiapkan query update.');
        }

        mysqli_stmt_bind_param(
            $stmtUpdate,
            "ssssii",
            $setting_name,
            $base_url,
            $username,
            $password,
            $status,
            $id_setting_radix
        );

        if (!mysqli_stmt_execute($stmtUpdate)) {
            mysqli_stmt_close($stmtUpdate);
            throw new Exception('Gagal memperbarui data setting Radix.');
        }

        mysqli_stmt_close($stmtUpdate);
        mysqli_commit($Conn);

        $response['status'] = 'success';
        $response['message'] = 'Data setting Radix berhasil diperbarui.';
    } catch (Exception $e) {
        mysqli_rollback($Conn);
        $response['message'] = $e->getMessage();
    }

    echo json_encode($response);
?>
