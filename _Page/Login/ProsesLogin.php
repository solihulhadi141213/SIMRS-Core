<?php
    // Set header agar selalu mengembalikan JSON
    header('Content-Type: application/json');

    // Tambahkan beberapa header keamanan
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: DENY');
    header('X-XSS-Protection: 1; mode=block');

    // Start session
    session_start();

    // Zona waktu
    date_default_timezone_set('Asia/Jakarta');

    // Connection dan function
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";

    // ==========================
    // VALIDASI INPUT
    // ==========================
    if (empty($_POST["email"])) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Email Tidak Boleh Kosong!'
        ]);
        exit;
    }

    if (empty($_POST["password"])) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Password Tidak Boleh Kosong!'
        ]);
        exit;
    }

    if (empty($_POST["captcha"])) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Kode Captcha Tidak Boleh Kosong!'
        ]);
        exit;
    }

    if (empty($_POST["id_captcha"])) {
        echo json_encode([
            'status' => 'error',
            'message' => 'ID Captcha Tidak Boleh Kosong!'
        ]);
        exit;
    }

    $email      = trim($_POST["email"]);
    $password   = trim($_POST["password"]);
    $captcha    = trim($_POST["captcha"]);
    $id_captcha = trim($_POST["id_captcha"]);

    // ==========================
    // VALIDASI CAPTCHA
    // ==========================
    $utc = new DateTime('now', new DateTimeZone('UTC'));
    $current_utc = $utc->format('Y-m-d H:i:s');

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

    if (!$DataCaptcha) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Captcha tidak valid atau sudah kedaluwarsa!'
        ]);
        exit;
    }

    if (!password_verify($captcha, $DataCaptcha['code_captcha'])) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Kode captcha salah!'
        ]);
        exit;
    }

    // ==========================
    // VALIDASI FORMAT EMAIL
    // ==========================
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Format Email Tidak Valid!'
        ]);
        exit;
    }

    // ==========================
    // AMBIL USER BERDASARKAN EMAIL
    // ==========================
    $queryAkses = $Conn->prepare("
        SELECT * 
        FROM akses 
        WHERE email = ?
        LIMIT 1
    ");

    $queryAkses->bind_param("s", $email);
    $queryAkses->execute();

    $resultAkses = $queryAkses->get_result();
    $DataAkses = $resultAkses->fetch_assoc();

    if (!$DataAkses) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Email tidak ditemukan!'
        ]);
        exit;
    }

    // ==========================
    // VERIFIKASI PASSWORD HASH
    // ==========================
    if (!password_verify($password, $DataAkses['password'])) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Password yang Anda gunakan salah!'
        ]);
        exit;
    }

    $id_akses = $DataAkses['id_akses'];

    // Hapus captcha sekali pakai
    $deleteCaptcha = $Conn->prepare("DELETE FROM captcha WHERE id_captcha = ?");
    $deleteCaptcha->bind_param("s", $id_captcha);
    $deleteCaptcha->execute();


    // ==========================
    // HAPUS TOKEN LAMA
    // ==========================
    $deleteTokenStmt = $Conn->prepare("
        DELETE FROM akses_login 
        WHERE id_akses = ?
    ");
    $deleteTokenStmt->bind_param("i", $id_akses);
    $deleteTokenStmt->execute();

    // ==========================
    // GENERATE TOKEN BARU
    // ==========================
    $expired_seconds = 60 * 60; // 1 jam
    $date_expired = date(
        'Y-m-d H:i:s',
        strtotime($current_utc) + $expired_seconds
    );

    $token = generateStrongCode(36);

    $insertTokenStmt = $Conn->prepare("
        INSERT INTO akses_login (
            id_akses,
            login_token,
            creat_at,
            expired_at
        ) VALUES (?, ?, ?, ?)
    ");

    $insertTokenStmt->bind_param(
        "isss",
        $id_akses,
        $token,
        $current_utc,
        $date_expired
    );

    if (!$insertTokenStmt->execute()) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Gagal menyimpan token login!'
        ]);
        exit;
    }

    // ==========================
    // COOKIE LOGIN
    // ==========================
    $cookieOptions = [
        'expires'  => time() + $expired_seconds,
        'path'     => '/',
        'secure'   => isset($_SERVER['HTTPS']),
        'httponly' => true,
        'samesite' => 'Lax'
    ];

    setcookie("id_akses", $id_akses, $cookieOptions);
    setcookie("login_token", $token, $cookieOptions);

    $_SESSION['NotifikasiSwal'] = "Login Berhasil";

    echo json_encode([
        'status' => 'success',
        'message' => 'Login Berhasil'
    ]);
    exit;
?>