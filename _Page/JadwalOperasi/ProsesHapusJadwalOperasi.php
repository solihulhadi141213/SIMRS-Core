<?php
    //koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    //Tangkap id_operasi
    if(empty($_POST['id_operasi'])){
        echo '<div class="text-danger">ID Operasi Tidak Dapat Ditangkap Oleh Sistem</div>';
    }else{
        $id_operasi=$_POST['id_operasi'];
        //Hapus data jadwal_operasi berdasarkan id_operasi
        $QryHapusJadwalOperasi = mysqli_query($Conn,"DELETE FROM jadwal_operasi WHERE id_operasi='$id_operasi'")or die(mysqli_error($Conn));
        if($QryHapusJadwalOperasi){
            $_SESSION['NotifikasiSwal']="Hapus Jadwal Operasi Berhasil";
            echo '<div class="text-success" id="NotifikasiHapusJadwalOperasiBerhasil">Success</div>';
        }else{
            echo '<div class="text-danger">Data Gagal Dihapus</div>';
        }
    }
?>