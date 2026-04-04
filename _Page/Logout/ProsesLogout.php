<?php
    // Zona waktu
    date_default_timezone_set('Asia/Jakarta');

    // Koneksi dan function
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // Ambil data dari cookie
    $CookieIdAkses = $_COOKIE['id_akses'] ?? "";
    $CookieToken   = $_COOKIE['login_token'] ?? "";

    // Jika cookie tersedia, hapus token dari database
    if (!empty($CookieIdAkses) && !empty($CookieToken)) {

        $stmtDelete = mysqli_prepare(
            $Conn,
            "DELETE FROM akses_login 
             WHERE id_akses = ? 
             AND login_token = ?"
        );

        mysqli_stmt_bind_param(
            $stmtDelete,
            "is",
            $CookieIdAkses,
            $CookieToken
        );

        mysqli_stmt_execute($stmtDelete);
        mysqli_stmt_close($stmtDelete);
    }

    // Hapus cookie browser
    $cookieOptions = [
        'expires'  => time() - 3600,
        'path'     => '/',
        'secure'   => isset($_SERVER['HTTPS']),
        'httponly' => true,
        'samesite' => 'Lax'
    ];

    setcookie("id_akses", "", $cookieOptions);
    setcookie("login_token", "", $cookieOptions);

    // Hapus session jika masih ada
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    session_unset();
    session_destroy();

    // Redirect ke login
    header("Location: ../../login.php");
    exit;
?>