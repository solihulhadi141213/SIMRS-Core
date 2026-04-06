<?php
    /*
    ======================================================
    FILE : GoogleCallback.php
    FUNGSI : Menerima response login dari Google OAuth
    ======================================================
    */

    // Mulai session
    session_start();

    // Koneksi dan function aplikasi
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/SettingGeneral.php";

    // Zona waktu
    date_default_timezone_set("Asia/Jakarta");


    // CEK AUTHORIZATION CODE
    if(empty($_GET['code'])){
        die("Authorization code tidak ditemukan");
    }
    $code = $_GET['code'];

    // AMBIL GOOGLE CREDENTIAL YANG AKTIF
    $status = 1;
    $stmt = $Conn->prepare("SELECT * FROM setting_google WHERE status=?");
    $stmt->bind_param("i",$status);
    $stmt->execute();
    $cred = $stmt->get_result()->fetch_assoc();
    if(!$cred){
        die("Credential Google tidak ditemukan");
    }
    $client_id     = $cred['client_id'];
    $client_secret = $cred['client_secret'];
    $redirect_uri  = $base_url . "/_Page/Login/GoogleCallback.php";

    // TUKAR AUTHORIZATION CODE MENJADI ACCESS TOKEN
    $token_url = "https://oauth2.googleapis.com/token";

    $post = [
        "code"          => $code,
        "client_id"     => $client_id,
        "client_secret" => $client_secret,
        "redirect_uri"  => $redirect_uri,
        "grant_type"    => "authorization_code"
    ];

    $options = [
        "http" => [
            "header"  => "Content-Type: application/x-www-form-urlencoded",
            "method"  => "POST",
            "content" => http_build_query($post)
        ]
    ];

    $context  = stream_context_create($options);
    $response = file_get_contents($token_url,false,$context);
    $token    = json_decode($response,true);
    if(empty($token['access_token'])){
        die("Gagal mengambil access token dari Google");
    }

    $access_token = $token['access_token'];

    // AMBIL DATA USER GOOGLE
    $user_info = file_get_contents("https://www.googleapis.com/oauth2/v2/userinfo?access_token=".$access_token);
    $user      = json_decode($user_info,true);
    if(empty($user['email'])){
        die("Gagal mengambil data user Google");
    }
    $email = $user['email'];
    $nama  = $user['name'];

    // CEK USER DI DATABASE APLIKASI
    $stmt = $Conn->prepare("SELECT * FROM akses WHERE email=?");
    $stmt->bind_param("s",$email);
    $stmt->execute();
    $DataAkses = $stmt->get_result()->fetch_assoc();
    if(!$DataAkses){
        die("Email Google tidak terdaftar pada sistem.");
    }
    $id_akses = $DataAkses['id_akses'];

    // HAPUS TOKEN LOGIN LAMA
    $deleteTokenStmt = $Conn->prepare("DELETE FROM akses_login WHERE id_akses = ?");
    $deleteTokenStmt->bind_param("i", $id_akses);
    $deleteTokenStmt->execute();

    // BUAT TOKEN LOGIN BARU
    $utc             = new DateTime('now', new DateTimeZone('UTC'));
    $current_utc     = $utc->format('Y-m-d H:i:s');
    $expired_seconds = 60 * 60;
    $date_expired    = date('Y-m-d H:i:s',strtotime($current_utc) + $expired_seconds);
    $token           = generateStrongCode(36);
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
        die("Gagal menyimpan token login!");
        exit;
    }

    // COOKIE LOGIN
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

    // REDIRECT KE HALAMAN UTAMA
    header("Location: ../../index.php");
    exit;

?>