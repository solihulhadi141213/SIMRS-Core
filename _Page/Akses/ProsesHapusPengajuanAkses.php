<?php
    //Koneksi dan SessionLogin
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    $now=date('Y-m-d H:i');
    if(empty($_POST['id_akses_pengajuan'])){
        echo '<i id="Notifikasi">ID Pengajuan Tidak Boleh Kosong!</i>';
    }else{
        $id_akses_pengajuan=$_POST['id_akses_pengajuan'];
        //Buka File
        $foto=getDataDetail($Conn,'akses_pengajuan','id_akses_pengajuan',$id_akses_pengajuan,'foto');
        //Proses hapus Pengajuan Akses
        $HapusPengajuanAkses = mysqli_query($Conn, "DELETE FROM akses_pengajuan WHERE id_akses_pengajuan='$id_akses_pengajuan'") or die(mysqli_error($Conn));
        if($HapusPengajuanAkses) {
            $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Hapus Pengajuan Akses","Akses",$SessionIdAkses,$LogJsonFile);
            //Hapus File
            $UrlGambar="../../assets/images/PengajuanAkses/$foto";
            if(file_exists("$UrlGambar")){
                unlink($UrlGambar);
            }
            echo '<span class="text-success" id="NotifikasiHapusPengajuanAksesBerhasil">Success</span>';
        }else{
            echo '<span class="text-danger">Hapus Referensi Akses Gagal!</span>';
        }
    }
?>