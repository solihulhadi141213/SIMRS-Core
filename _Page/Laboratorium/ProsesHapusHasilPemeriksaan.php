<?php
    //Koneksi dan SessionLogin
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    $now=date('Y-m-d H:i');
    if(empty($_POST['id_rincian_lab'])){
        echo '<span class="text-danger">ID Hasil Pemeriksaan Tidak Boleh Kosong</span>';
    }else{
        $id_rincian_lab=$_POST['id_rincian_lab'];
        $HapusHasilPemeriksaan = mysqli_query($Conn, "DELETE FROM laboratorium_rincian WHERE id_rincian_lab='$id_rincian_lab'") or die(mysqli_error($Conn));
        if ($HapusHasilPemeriksaan) {
            $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Hapus Hasil Pemeriksaan Laboratorium","Laboratorium",$SessionIdAkses,$LogJsonFile);
            if($MenyimpanLog=="Berhasil"){
                echo '<span class="text-success" id="NotifikasiHapusHasilPemeriksaanBerhasil">Success</span>';
            }else{
                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
            }
        }else{
            echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menghapus Data Hasil Pemeriksaan!</span>';
        }
    }
?>