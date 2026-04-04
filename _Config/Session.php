<?php
    // Session Start (opsional, masih dipakai untuk notifikasi swal)
    session_start();

    // Inisialisasi variabel session user
    $SessionIdAkses          = "";
    $SessionIdAksesPengajuan = "";
    $SessionTanggal          = "";
    $SessionNama             = "";
    $SessionEmail            = "";
    $SessionKontak           = "";
    $SessionNik              = "";
    $SessionIhs              = "";
    $SessionPassword         = "";
    $SessionAkses            = "";
    $SessionGambar           = "";
    $SessionUpdatetime       = "";
    $SessionDateExpired      = "";
    $SessionToken            = "";

    // Ambil cookie
    $CookieIdAkses = $_COOKIE['id_akses'] ?? "";
    $CookieToken   = $_COOKIE['login_token'] ?? "";

    // Jika cookie tersedia
    if (!empty($CookieIdAkses) && !empty($CookieToken)) {

        $id_akses = $CookieIdAkses;
        $token    = $CookieToken;

        // Validasi token
        $stmtLogin = mysqli_prepare(
            $Conn,
            "SELECT id_akses_login, expired_at 
             FROM akses_login 
             WHERE id_akses = ? 
             AND login_token = ?
             LIMIT 1"
        );

        mysqli_stmt_bind_param($stmtLogin, "is", $id_akses, $token);
        mysqli_stmt_execute($stmtLogin);

        $resultLogin = mysqli_stmt_get_result($stmtLogin);
        $DataAksesLogin = mysqli_fetch_array($resultLogin, MYSQLI_ASSOC);

        mysqli_stmt_close($stmtLogin);

        // Jika token ditemukan
        if (!empty($DataAksesLogin['id_akses_login'])) {

            $expired_at   = $DataAksesLogin['expired_at'];
            $utc          = new DateTime('now', new DateTimeZone('UTC'));
            $DateSekarang = $utc->format('Y-m-d H:i:s');

            // Validasi token belum expired
            if ($expired_at >= $DateSekarang) {

                // Perpanjang masa aktif token 1 jam
                $expired_second = 60 * 60;
                $utcNew = new DateTime($DateSekarang, new DateTimeZone('UTC'));
                $utcNew->modify("+{$expired_second} seconds");
                $date_expired_new = $utcNew->format('Y-m-d H:i:s');

                // Update expired token di database
                $stmtUpdateToken = mysqli_prepare(
                    $Conn,
                    "UPDATE akses_login 
                     SET expired_at = ? 
                     WHERE id_akses = ?"
                );

                mysqli_stmt_bind_param(
                    $stmtUpdateToken,
                    "si",
                    $date_expired_new,
                    $id_akses
                );

                $UpdateToken = mysqli_stmt_execute($stmtUpdateToken);

                mysqli_stmt_close($stmtUpdateToken);

                // Update masa berlaku cookie juga
                if ($UpdateToken) {

                    $cookieOptions = [
                        'expires'  => time() + $expired_second,
                        'path'     => '/',
                        'secure'   => false,
                        'httponly' => true,
                        'samesite' => 'Lax'
                    ];

                    setcookie("id_akses", $id_akses, $cookieOptions);
                    setcookie("login_token", $token, $cookieOptions);

                    // Ambil data user
                    $stmtSessionAkses = mysqli_prepare(
                        $Conn,
                        "SELECT * 
                         FROM akses 
                         WHERE id_akses = ?
                         LIMIT 1"
                    );

                    mysqli_stmt_bind_param(
                        $stmtSessionAkses,
                        "i",
                        $id_akses
                    );

                    mysqli_stmt_execute($stmtSessionAkses);

                    $resultSessionAkses = mysqli_stmt_get_result($stmtSessionAkses);
                    $DataSessionAkses = mysqli_fetch_array(
                        $resultSessionAkses,
                        MYSQLI_ASSOC
                    );

                    mysqli_stmt_close($stmtSessionAkses);

                    if (!empty($DataSessionAkses['nama'])) {

                        $SessionIdAkses          = $DataSessionAkses['id_akses'];
                        $SessionIdAksesPengajuan = $DataSessionAkses['id_akses_pengajuan'];
                        $SessionTanggal          = $DataSessionAkses['tanggal'];
                        $SessionNama             = $DataSessionAkses['nama'];
                        $SessionEmail            = $DataSessionAkses['email'];
                        $SessionKontak           = $DataSessionAkses['kontak'];
                        $SessionNik              = $DataSessionAkses['nik'];
                        $SessionIhs              = $DataSessionAkses['ihs'];
                        $SessionPassword         = $DataSessionAkses['password'];
                        $SessionAkses            = $DataSessionAkses['akses'];
                        $SessionGambar           = $DataSessionAkses['gambar'];
                        $SessionUpdatetime       = $DataSessionAkses['updatetime'];
                        $SessionDateExpired      = $date_expired_new;
                        $SessionToken            = $token;
                    }

                }

            } else {

                // Jika token expired hapus cookie
                setcookie("id_akses", "", time() - 3600, "/");
                setcookie("login_token", "", time() - 3600, "/");

            }

        } else {

            // Jika token tidak valid hapus cookie
            setcookie("id_akses", "", time() - 3600, "/");
            setcookie("login_token", "", time() - 3600, "/");

        }

    }
?>