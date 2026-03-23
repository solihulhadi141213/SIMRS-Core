<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    $WaktuLog=date('Y-m-d H:i:s');
    if(empty($_POST['id_nakes_terinfeksi'])){
        echo '<span class="text-danger">ID Nakes Terinfeksi Tidak Boleh Kosong!</span>';
    }else{
        $id_nakes_terinfeksi=$_POST['id_nakes_terinfeksi'];
        $HapusNakesTerinfeksi = mysqli_query($Conn, "DELETE FROM nakes_terinfeksi WHERE id_nakes_terinfeksi='$id_nakes_terinfeksi'") or die(mysqli_error($Conn));
        if($HapusNakesTerinfeksi){
            $MenyimpanLog=getSaveLog($Conn,$WaktuLog,$SessionNama,"Hapus data nakes terinfeksi","Nakes",$SessionIdAkses,$LogJsonFile);
            if($MenyimpanLog=="Berhasil"){
                echo '<span class="text-success" id="NotifikasiHapusNakesTerinfeksiBerhasil">Success</span>';
            }else{
                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
            }
        }else{
            echo '<span class="text-danger">Hapus Data Nakes Terinfeksi Gagal!</span>';
        }
    }
?>