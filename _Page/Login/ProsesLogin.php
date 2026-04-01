<?php
    // Set header agar selalu mengembalikan JSON
    header('Content-Type: application/json');

     // Tambahkan beberapa header keamanan
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: DENY');
    header('X-XSS-Protection: 1; mode=block');

    // Session, Koneksi dan Function
    session_start();
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";

    // Validasi Email Tidak Boleh Kosong
    if (empty($_POST["email"])) {
        $response = [
            'status' => 'error',
            'message' => 'Email Tidak Boleh Kosong!'
        ];
        echo json_encode($response);
        exit;
    }

    if (empty($_POST["password"])) {
        $response = [
            'status' => 'error',
            'message' => 'Password Tidak Boleh Kosong!'
        ];
        echo json_encode($response);
        exit;
    }

    if (empty($_POST["captcha"])) {
        $response = [
            'status' => 'error',
            'message' => 'Kode Captcha Tidak Boleh Kosong!'
        ];
        echo json_encode($response);
        exit;
    }

    if (empty($_POST["id_captcha"])) {
        $response = [
            'status' => 'error',
            'message' => 'ID Captcha Tidak Boleh Kosong!'
        ];
        echo json_encode($response);
        exit;
    }


    // Ambil Input
    $email      = trim($_POST["email"]);
    $password   = trim($_POST["password"]);
    $captcha    = trim($_POST["captcha"]);
    $id_captcha = trim($_POST["id_captcha"]);

    // Proses Validasi Captcha
    $utc = new DateTime('now', new DateTimeZone('UTC'));
    $current_utc = $utc->format('Y-m-d H:i:s');

    // Cari captcha berdasarkan id dan pastikan belum expired
    $queryCaptcha = $Conn->prepare("
        SELECT code_captcha 
        FROM captcha 
        WHERE id_captcha = ? 
        AND expired_at >= ?
        LIMIT 1
    ");
    $queryCaptcha->bind_param("ss", $id_captcha, $current_utc);
    $queryCaptcha->execute();
    $resultCaptcha = $queryCaptcha->get_result();
    $DataCaptcha = $resultCaptcha->fetch_assoc();

    // Jika captcha tidak ditemukan / sudah expired
    if (!$DataCaptcha) {
        $response = [
            'status' => 'error',
            'message' => 'Captcha tidak valid atau sudah kedaluwarsa!'
        ];
        echo json_encode($response);
        exit;
    }

    // Verifikasi captcha dengan hash
    if (!password_verify($captcha, $DataCaptcha['code_captcha'])) {
        $response = [
            'status' => 'error',
            'message' => 'Kode captcha yang Anda masukkan salah!'
        ];
        echo json_encode($response);
        exit;
    }

    // Hapus captcha setelah berhasil diverifikasi (sekali pakai)
    $deleteCaptcha = $Conn->prepare("
        DELETE FROM captcha 
        WHERE id_captcha = ?
    ");
    $deleteCaptcha->bind_param("s", $id_captcha);
    $deleteCaptcha->execute();

    // Validasi Format Email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response = [
            'status' => 'error',
            'message' => 'Format Email Tidak Valid!'
        ];
        echo json_encode($response);
        exit;
    }

    // Validasi Email
    $queryEmail = $Conn->prepare("SELECT * FROM akses WHERE email = ?");
    $queryEmail->bind_param("s", $email);
    $queryEmail->execute();
    $resultEmail = $queryEmail->get_result();
    $DataEmail = $resultEmail->fetch_assoc();

    if (!$DataEmail) {
        $response = [
            'status' => 'error',
            'message' => 'Email Yang Anda Gunakan Tidak Valid!'
        ];
        echo json_encode($response);
        exit;
    }

    // Validasi Password dan Email
    $queryAkses = $Conn->prepare("SELECT * FROM akses WHERE email = ? AND password = ?");
    $passwordHash = md5($password); // Menggunakan MD5 sesuai alur, rekomendasi: ubah ke password_hash
    $queryAkses->bind_param("ss", $email, $passwordHash);
    $queryAkses->execute();
    $resultAkses = $queryAkses->get_result();
    $DataAkses = $resultAkses->fetch_assoc();

    if (!$DataAkses) {
        $response = [
            'status' => 'error',
            'message' => 'Email Dan Password Yang Anda Gunakan Tidak Valid!'
        ];
        echo json_encode($response);
        exit;
    }
    $id_akses = $DataAkses['id_akses'];

    // Hapus token lama
    $deleteTokenStmt = $Conn->prepare("DELETE FROM akses_login WHERE id_akses = ?");
    $deleteTokenStmt->bind_param("i", $id_akses);
    $deleteTokenStmt->execute();

    // Buat token baru dengan durasi 1 jam
    $timestamp_now   = date('Y-m-d H:i:s');
    $expired_seconds = 60 * 60;
    $date_expired    = date('Y-m-d H:i:s', strtotime($timestamp_now) + $expired_seconds);
    $token           = generateStrongCode(36);
    $insertTokenStmt = $Conn->prepare("INSERT INTO akses_login (id_akses, login_token, creat_at, expired_at) VALUES (?, ?, ?, ?)");
    $insertTokenStmt->bind_param("isss", $id_akses, $token, $timestamp_now, $date_expired);

    if (!$insertTokenStmt->execute()) {
        $response = [
            'status' => 'error',
            'message' => 'Terjadi Kesalahan Pada Saat Menyimpan Token!!'
        ];
        echo json_encode($response);
        exit;
    }


    // Login Berhasil
    $id_akses     = $DataAkses["id_akses"];
    $WaktuLog     = date('Y-m-d H:i');
    $Nama         = htmlspecialchars($DataAkses["nama"], ENT_QUOTES, 'UTF-8');
    $nama_log     = "Login Berhasil";
    $kategori_log = "Login";

    // Set Session
    $_SESSION["id_akses"]       = $id_akses;
    $_SESSION["token"]          = $token;
    $_SESSION['NotifikasiSwal'] = "Login Berhasil";

    // Response Login Berhasil
    $response = [
        'status' => 'success',
        'message' => 'Login Berhasil'
    ];
    echo json_encode($response);
    exit;
?>
