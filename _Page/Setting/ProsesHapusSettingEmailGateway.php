<?php
    //Koneksi dan SessionLogin
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $now=date('Y-m-d H:i');
    if(empty($_POST['id_setting_email_gateway'])){
        echo '<span class="text-danger">ID Setting Tidak Boleh Kosong!</span>';
    }else{
        $id_setting_email_gateway=$_POST['id_setting_email_gateway'];
        //Proses hapus Setting Satu Sehat
        $HapusSetting = mysqli_query($Conn, "DELETE FROM setting_email_gateway WHERE id_setting_email_gateway='$id_setting_email_gateway'") or die(mysqli_error($Conn));
        if($HapusSetting){
            $LogJsonFile="../../_Page/Log/Log.json";
            $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Hapus Setting Email Gateway","Setting",$SessionIdAkses,$LogJsonFile);
            if($MenyimpanLog=="Berhasil"){
                $_SESSION['NotifikasiSwal']="Hapus Setting Berhasil";
                echo '<span class="text-success" id="NotifikasiHapusSettingEmailGatewayBerhasil">Success</span>';
            }else{
                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
            }
        }else{
            echo '<span class="text-danger">Hapus Setting Email Gateway Gagal!</span>';
        }
    }
?>