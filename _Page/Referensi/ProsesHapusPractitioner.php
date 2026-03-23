<?php
    //Koneksi dan SessionLogin
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    $now=date('Y-m-d H:i');
    if(empty($_POST['id_practitioner'])){
        echo '<span class="text-danger">ID Practitioner Tidak Boleh Kosong</span>';
    }else{
        $id_practitioner=$_POST['id_practitioner'];
        $HapusPractitioner = mysqli_query($Conn, "DELETE FROM referensi_practitioner WHERE id_practitioner='$id_practitioner'") or die(mysqli_error($Conn));
        if($HapusPractitioner) {
            $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Hapus Practitioner","Referensi",$SessionIdAkses,$LogJsonFile);
            if($MenyimpanLog=="Berhasil"){
                echo '<span class="text-success" id="NotifikasiHapusPractitionerBerhasil">Success</span>';
            }else{
                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
            }
        }else{
            echo '<span class="text-danger">Hapus Practitioner Gagal!</span>';
        }
    }
?>