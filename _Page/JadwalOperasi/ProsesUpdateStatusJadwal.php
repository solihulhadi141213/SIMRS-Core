<?php
    //datetime zone
    date_default_timezone_set('Asia/Jakarta');
    //include Connection.php
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap data dari form
    if(empty($_POST['id_operasi'])){
        echo '<span class="text-danger">ID Operasi tidak bisa ditangkap oleh sistem</span>';
    }else{
        if(empty($_POST['terlaksana'])){
            $terlaksana=0;
        }else{
            $terlaksana=$_POST['terlaksana'];
        }
        //Buat variabel
        $id_operasi=$_POST['id_operasi'];
        //Query untuk menambahkan data ke tabel jadwal_operasi
        $UpdateJadwalOperasi = mysqli_query($Conn,"UPDATE jadwal_operasi SET 
            terlaksana='$terlaksana'
        WHERE id_operasi='$id_operasi'") or die(mysqli_error($Conn)); 
        //Cek query
        if(!$UpdateJadwalOperasi){
            echo '<span class="text-danger">Update Status Data Gagal</span>';
        }else{
            $_SESSION['NotifikasiSwal']="Update Status Jadwal Operasi Berhasil";
            echo '<span class="text-success" id="NotifikasiUpdateJadwalOperasiBerhasil">Success</span><br>';
        }
    }
?>