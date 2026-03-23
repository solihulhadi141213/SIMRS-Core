<?php
    //Koneksi dan SessionLogin
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    $now=date('Y-m-d H:i');
    if(empty($_POST['id_laboratorium_parameter'])){
        echo '<span class="text-danger">ID Parameter Tidak Boleh Kosong</span>';
    }else{
        $id_laboratorium_parameter=$_POST['id_laboratorium_parameter'];
        $HapusParameter = mysqli_query($Conn, "DELETE FROM laboratorium_parameter WHERE id_laboratorium_parameter='$id_laboratorium_parameter'") or die(mysqli_error($Conn));
        if ($HapusParameter) {
            $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Hapus Parameter Laboratorium","Laboratorium",$SessionIdAkses,$LogJsonFile);
            if($MenyimpanLog=="Berhasil"){
                echo '<span class="text-success" id="NotifikasiHapusParameterBerhasil">Success</span>';
            }else{
                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
            }
        }else{
            echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menghapus Data Parameter!</span>';
        }
    }
?>