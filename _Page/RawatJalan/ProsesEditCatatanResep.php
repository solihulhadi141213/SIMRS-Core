<?php
    //Pengaturan waktu
    date_default_timezone_set('Asia/Jakarta');
    //Koneksi dan akses
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $now=date('Y-m-d H:i');
    $updatetime=date('Y-m-d H:i');
    //Validasi kelengkapan data
    if(empty($_POST['id_resep'])){
        echo '<span class="text-danger">ID Resep Tidak Boleh Kosong!</span>';
    }else{
        $id_resep=$_POST['id_resep'];
        //Variabel Tidak wajib
        if(empty($_POST['CatatanResep'])){
            $CatatanResep="";
        }else{
            $CatatanResep=$_POST['CatatanResep'];
        }
        $UpdateResep= mysqli_query($Conn,"UPDATE resep SET 
            catatan='$CatatanResep'
        WHERE id_resep='$id_resep'") or die(mysqli_error($Conn));
        if($UpdateResep){
            $LogJsonFile="../../_Page/Log/Log.json";
            $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Edit Resep Obat","Kunjungan",$SessionIdAkses,$LogJsonFile);
            if($MenyimpanLog=="Berhasil"){
                echo '<span class="text-success" id="NotifikasiEditCatatanResepBerhasil">Success</span>';
            }else{
                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
            }
        }else{
            echo '<span class="text-danger">Terjadi kesalahan pada saat update data!</span><br>';
        }
    }
?>