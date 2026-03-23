<?php
    //Koneksi dan SessionLogin
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    if(empty($_POST['id_kunjungan'])){
        echo '<i class="text-danger">ID Kunjungan Tidak dapat ditangkap pada saat proses hapus data</i>';
    }else{
        $id_kunjungan=$_POST['id_kunjungan'];
        $HapusOperasi = mysqli_query($Conn, "DELETE FROM operasi WHERE id_kunjungan='$id_kunjungan'") or die(mysqli_error($Conn));
        if($HapusOperasi){
            echo '<div id="NotifikasiHapusOperasiBerhasil" class="text-primary">Success</div>';
            echo '<div id="UrlBackOperasi" class="text-primary">index.php?Page=RawatJalan&Sub=Operasi&ms_sub=FormOperasi&id='.$id_kunjungan.'</div>';
            $_SESSION['NotifikasiSwal']="Hapus Operasi Berhasil";
        }else{
            echo '<i class="text-danger">Proses hapus gagal!!</i>';
        }
    }
?>