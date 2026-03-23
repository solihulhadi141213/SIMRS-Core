<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    //Validasi Form Data
    if(empty($_POST['NamaGroupAkses'])){
        echo '<span class="text-danger">Akses Group Tidak Boleh Kosong</span>';
    }else{
        $NamaGroupAkses=$_POST['NamaGroupAkses'];
        $aksesibilitas=$_POST['aksesibilitas'];
        $ProfileSekolah=$_POST['ProfileSekolah'];
        $Personalisasi=$_POST['Personalisasi'];
        $ValidasiAksesGroup=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akses_ijin WHERE akses='$NamaGroupAkses'"));
        //Apabila data akses grup belum ada maka input
        if(empty($ValidasiAksesGroup)){
            $entry="INSERT INTO akses_ijin (
                akses,
                aksesibilitas,
                ProfileSekolah,
                Personalisasi
            ) VALUES (
                '$NamaGroupAkses',
                '$aksesibilitas',
                '$ProfileSekolah',
                '$Personalisasi'
            )";
            $Input=mysqli_query($Conn, $entry);
            if($Input){
                //Catat Log Aktivitas
                $WaktuLog=date('Y-m-d H:i');
                $nama_log="Input Setting Akses $NamaGroupAkses";
                $kategori_log="Setting Akses";
                include "../../_Config/Log.php";
                echo '<i id="Notifikasi">Setting Akses Berhasil</i>';
            }else{
                echo '<i id="Notifikasi">Setting Akses Gagal</i>';
            }
        }else{
            //Apabila sudah ada maka update
            $Update = mysqli_query($Conn,"UPDATE akses_ijin SET 
                aksesibilitas='$aksesibilitas',
                ProfileSekolah='$ProfileSekolah',
                Personalisasi='$Personalisasi'
            WHERE akses='$NamaGroupAkses'") or die(mysqli_error($Conn)); 
            if($Update){
                //Catat Log Aktivitas
                $WaktuLog=date('Y-m-d H:i');
                $nama_log="Update Setting Akses $NamaGroupAkses";
                $kategori_log="Setting Akses";
                include "../../_Config/Log.php";
                echo '<i id="Notifikasi">Setting Akses Berhasil</i>';
            }else{
                echo '<i id="Notifikasi">Setting Akses Gagal</i>';
            }
        }
    }
    
    
?>