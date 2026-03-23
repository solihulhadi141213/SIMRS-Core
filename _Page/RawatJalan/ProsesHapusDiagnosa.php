<?php
    //Koneksi dan SessionLogin
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    if(empty($_POST['id_diagnosis_pasien'])){
        echo '<i class="text-danger">ID Diagnosa Pasien Tidak dapat ditangkap pada saat proses hapus data</i>';
    }else{
        $id_diagnosis_pasien=$_POST['id_diagnosis_pasien'];
        $HapusDiagnosa = mysqli_query($Conn, "DELETE FROM diagnosis_pasien WHERE id_diagnosis_pasien='$id_diagnosis_pasien'") or die(mysqli_error($Conn));
        if($HapusDiagnosa){
            echo '<div id="NotfikasiHapusDiagnosaBerhasil" class="text-primary">Success</div>';
        }else{
            echo '<i class="text-danger">Proses hapus gagal!!</i>';
        }
    }
?>