<?php
    //Koneksi dan SessionLogin
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    $now=date('Y-m-d H:i');
    if(empty($_POST['id_setting_satusehat'])){
        echo '<span class="text-danger">ID Setting Tidak Boleh Kosong!</span>';
    }else{
        $id_setting_satusehat=$_POST['id_setting_satusehat'];
        //Proses hapus Setting Satu Sehat
        $HapusSetting = mysqli_query($Conn, "DELETE FROM setting_satusehat WHERE id_setting_satusehat='$id_setting_satusehat'") or die(mysqli_error($Conn));
        if($HapusSetting){
            $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Hapus Setting Satu Sehat","Setting",$SessionIdAkses,$LogJsonFile);
            if($MenyimpanLog=="Berhasil"){
                $_SESSION['NotifikasiSwal']="Hapus Setting Berhasil";
                echo '<span class="text-success" id="NotifikasiHapusSettingSatuSehatBerhasil">Success</span>';
            }else{
                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
            }
        }else{
            echo '<span class="text-danger">Hapus Setting Satu Sehat Gagal!</span>';
        }
    }
?>