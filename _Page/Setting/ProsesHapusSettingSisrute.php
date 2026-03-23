<?php
    //Koneksi dan SessionLogin
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    $now=date('Y-m-d H:i');
    if(empty($_POST['id_setting_sisrute'])){
        echo '<span class="text-danger">ID Setting Tidak Boleh Kosong!</span>';
    }else{
        $id_setting_sisrute=$_POST['id_setting_sisrute'];
        //Proses hapus Setting SIRS Online
        $HapusSetting = mysqli_query($Conn, "DELETE FROM setting_sisrute WHERE id_setting_sisrute='$id_setting_sisrute'") or die(mysqli_error($Conn));
        if($HapusSetting){
            $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Hapus Setting SISRUTE","Setting",$SessionIdAkses,$LogJsonFile);
            if($MenyimpanLog=="Berhasil"){
                $_SESSION['NotifikasiSwal']="Hapus Setting Berhasil";
                echo '<span class="text-success" id="NotifikasiHapusSettingSisruteBerhasil">Success</span>';
            }else{
                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
            }
        }else{
            echo '<span class="text-danger">Hapus Setting Sisrute Gagal!</span>';
        }
    }
?>