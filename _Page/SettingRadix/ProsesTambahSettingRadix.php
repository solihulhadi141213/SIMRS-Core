<?php
    // Header JSON
    header('Content-Type: application/json');

    // Zona Waktu
    date_default_timezone_set('Asia/Jakarta');

    // Koneksi, Function dan Session
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    $response = [
        'status' => 'error',
        'message' => 'Terjadi kesalahan.'
    ];

    // Validasi Sesi Akses
    if (empty($SessionIdAkses)) {
        $response['message'] = 'Sesi akses berakhir, silakan login ulang.';
        echo json_encode($response);
        exit;
    }

    // Validasi Metode Pengiriman Data
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $response['message'] = 'Metode request tidak valid.';
        echo json_encode($response);
        exit;
    }

    // Buat Variabel
    $setting_name = trim($_POST['nama_setting_radix'] ?? '');
    $base_url     = trim($_POST['url_radix'] ?? '');
    $username     = trim($_POST['username'] ?? '');
    $password     = trim($_POST['password'] ?? '');
    $status       = isset($_POST['status']) ? 1 : 0;
    $creat_at     = date('Y-m-d H:i:s');
    $token        = null;
    $expired_at   = null;

    // Validasi Mandatori
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

        // Validasi Duplikat
        $stmtCheck = mysqli_prepare(
            $Conn,
            "SELECT id_setting_radix FROM setting_radix WHERE setting_name = ?"
        );

        if (!$stmtCheck) {
            throw new Exception('Gagal menyiapkan validasi data.');
        }

        mysqli_stmt_bind_param($stmtCheck, "s", $setting_name);
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

        // Jika Status 1 maka Non aktifkan Yang lain
        if ($status === 1) {
            $stmtNonAktif = mysqli_prepare(
                $Conn,
                "UPDATE setting_radix SET status = 0"
            );

            if (!$stmtNonAktif) {
                throw new Exception('Gagal menyiapkan update status.');
            }

            if (!mysqli_stmt_execute($stmtNonAktif)) {
                mysqli_stmt_close($stmtNonAktif);
                throw new Exception('Gagal menonaktifkan profil lain.');
            }

            mysqli_stmt_close($stmtNonAktif);
        }

        // Insert Data
        $stmtInsert = mysqli_prepare(
            $Conn,
            "INSERT INTO setting_radix (
                setting_name,
                base_url,
                username,
                password,
                token,
                creat_at,
                expired_at,
                status
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
        );

        if (!$stmtInsert) {
            throw new Exception('Gagal menyiapkan query insert.');
        }

        mysqli_stmt_bind_param(
            $stmtInsert,
            "sssssssi",
            $setting_name,
            $base_url,
            $username,
            $password,
            $token,
            $creat_at,
            $expired_at,
            $status
        );

        if (!mysqli_stmt_execute($stmtInsert)) {
            mysqli_stmt_close($stmtInsert);
            throw new Exception('Gagal menyimpan data setting Radix.');
        }

        mysqli_stmt_close($stmtInsert);
        mysqli_commit($Conn);

        $response['status'] = 'success';
        $response['message'] = 'Data setting Radix berhasil disimpan.';
    } catch (Exception $e) {
        mysqli_rollback($Conn);
        $response['message'] = $e->getMessage();
    }

    echo json_encode($response);
?>
