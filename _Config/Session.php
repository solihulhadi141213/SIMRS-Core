<?php
    session_start();
    if(empty($_SESSION['id_akses'])){
        header('Location:Login.php');
    }else{
        if(empty($_SESSION['email'])){
            header('Location:Login.php');
        }else{
            $SessionIdAkses=$_SESSION['id_akses'];
            //panggil dari database
            $QuerySessionAkses = mysqli_query($Conn,"SELECT * FROM akses WHERE id_akses='$SessionIdAkses'")or die(mysqli_error($Conn));
            $DataSessionAkses = mysqli_fetch_array($QuerySessionAkses);
            if(empty($DataSessionAkses['nama'])){
                header('Location:Login.php');
            }else{
                //rincian profile user
                $SessionTanggal= $DataSessionAkses['tanggal'];
                $SessionNama= $DataSessionAkses['nama'];
                $SessionEmail= $DataSessionAkses['email'];
                $SessionKontak= $DataSessionAkses['kontak'];
                $SessionPassword= $DataSessionAkses['password'];
                $SessionAkses= $DataSessionAkses['akses'];
                $SessionGambar= $DataSessionAkses['gambar'];
                $SessionUpdatetime= $DataSessionAkses['updatetime'];
            }
        }
    }
?>