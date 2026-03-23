<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    //Koneksi ke database
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/FungsiSirsOnline.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    $WaktuLog=date('Y-m-d H:i:s');
    //Buka Pengaturan SIRS Online
    $x_id_rs=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','id_rs');
    $url_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','url_sirs_online');
    $password_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','password_sirs_online');
    //Buat Variabel
    if(empty($_POST['id_sirs_online_task'])){
        echo '<span class="text-danger">ID Laporan Tidak Boleh Kosong!</span>';
    }else{
        $id_sirs_online_task=$_POST['id_sirs_online_task'];
        $HapusLaporanOksigen = mysqli_query($Conn, "DELETE FROM sirs_online_task WHERE id_sirs_online_task='$id_sirs_online_task'") or die(mysqli_error($Conn));
        if($HapusLaporanOksigen){
            $MenyimpanLog=getSaveLog($Conn,$WaktuLog,$SessionNama,"Hapus Laporan Oksigen","Oksigen SIRS Online",$SessionIdAkses,$LogJsonFile);
            if($MenyimpanLog=="Berhasil"){
                echo '<span class="text-success" id="NotifikasiHapusOksigenBerhasil">Success</span>';
            }else{
                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
            }
        }else{
            echo '<span class="text-danger">Terjadi kesalahan pada saat menghapus data oksigen!</span>';
        }
    }
?>