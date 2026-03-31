<?php
    // Session Start
    session_start();

    // Inisiaslisasi Variabel Session
    $SessionIdAkses          = "";
    $SessionIdAksesPengajuan = "";
    $SessionTanggal          = "";
    $SessionNama             = "";
    $SessionEmail            = "";
    $SessionKontak           = "";
    $SessionPassword         = "";
    $SessionAkses            = "";
    $SessionGambar           = "";
    $SessionUpdatetime       = "";
    $SessionDateExpired      = "";

    // Jika Session id_akses & token Ada
    if(!empty($_SESSION['id_akses']) && !empty($_SESSION['token'])){
       
        $SessionIdAkses = $_SESSION['id_akses'];
        $SessionToken   = $_SESSION['token'];

        // Cek validitas token
        // Gunakan prepared statement untuk mencegah SQL injection
        $stmtLogin = mysqli_prepare($Conn, "SELECT id_akses_login, expired_at FROM akses_login WHERE id_akses=? AND login_token=?");
        mysqli_stmt_bind_param($stmtLogin, "ss", $SessionIdAkses, $SessionToken);
        mysqli_stmt_execute($stmtLogin);
        $resultLogin = mysqli_stmt_get_result($stmtLogin);
        $DataAksesLogin = mysqli_fetch_array($resultLogin, MYSQLI_ASSOC);
        mysqli_stmt_close($stmtLogin);
        
        //Apabila id_akses_login ditemukan
        if(!empty($DataAksesLogin['id_akses_login'])){
           $SessionDateExpired = $DataAksesLogin['expired_at'];

            //Validasi Apakah Token Masih Berlaku Atau Tidak
            $DateSekarang=date('Y-m-d H:i:s');
            if($SessionDateExpired>=$DateSekarang){

                // Jika Masih Aktif, Perpanjang masa berlaku Token
                $expired_milisecond=1000*60*60;
                $now=date('Y-m-d H:i:s');
                $date_expired_new=calculateExpirationTimeFromDateTime($now, $expired_milisecond);

                //Update Token Yang Ada
                $stmtUpdateToken = mysqli_prepare($Conn, "UPDATE akses_login SET expired_at=? WHERE id_akses=?");
                mysqli_stmt_bind_param($stmtUpdateToken, "ss", $date_expired_new, $SessionIdAkses);
                $UpdateToken = mysqli_stmt_execute($stmtUpdateToken);
                mysqli_stmt_close($stmtUpdateToken);
                if($UpdateToken){

                    //Buka Data User Dari Tabel akses
                    $stmtSessionAkses = mysqli_prepare($Conn, "SELECT id_akses, id_akses_pengajuan, tanggal, nama, email, kontak, password, akses, gambar, updatetime FROM akses WHERE id_akses=?");
                    mysqli_stmt_bind_param($stmtSessionAkses, "s", $SessionIdAkses);
                    mysqli_stmt_execute($stmtSessionAkses);
                    $resultSessionAkses = mysqli_stmt_get_result($stmtSessionAkses);
                    $DataSessionAkses = mysqli_fetch_array($resultSessionAkses, MYSQLI_ASSOC);
                    mysqli_stmt_close($stmtSessionAkses);
                    if(!empty($DataSessionAkses['nama'])){
                        //rincian profile user
                        $SessionIdAkses          = $DataSessionAkses['id_akses'];
                        $SessionIdAksesPengajuan = $DataSessionAkses['id_akses_pengajuan'];
                        $SessionTanggal          = $DataSessionAkses['tanggal'];
                        $SessionNama             = $DataSessionAkses['nama'];
                        $SessionEmail            = $DataSessionAkses['email'];
                        $SessionKontak           = $DataSessionAkses['kontak'];
                        $SessionPassword         = $DataSessionAkses['password'];
                        $SessionAkses            = $DataSessionAkses['akses'];
                        $SessionGambar           = $DataSessionAkses['gambar'];
                        $SessionUpdatetime       = $DataSessionAkses['updatetime'];
                    }
                    
                }
            }
        }
    }
?>
