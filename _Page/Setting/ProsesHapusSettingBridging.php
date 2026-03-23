<?php
    //Koneksi dan SessionLogin
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $now=date('Y-m-d H:i');
    if(empty($_POST['id_bridging'])){
        echo '<span class="text-danger">ID Setting Tidak Boleh Kosong!</span>';
    }else{
        $id_bridging=$_POST['id_bridging'];
        //Proses hapus Setting Satu Sehat
        $HapusSetting = mysqli_query($Conn, "DELETE FROM bridging WHERE id_bridging='$id_bridging'") or die(mysqli_error($Conn));
        if($HapusSetting){
            $LogJsonFile="../../_Page/Log/Log.json";
            $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Hapus Setting Bridging","Setting",$SessionIdAkses,$LogJsonFile);
            if($MenyimpanLog=="Berhasil"){
                $_SESSION['NotifikasiSwal']="Hapus Setting Berhasil";
                echo '<span class="text-success" id="NotifikasiHapusSettingBridgingBerhasil">Success</span>';
            }else{
                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
            }
        }else{
            echo '<span class="text-danger">Hapus Setting Bridging Gagal!</span>';
        }
    }
?>