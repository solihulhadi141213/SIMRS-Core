<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $now=date('Y-m-d H:i');
    //Validasi id_referensi_alergi
    if(empty($_POST['id_referensi_alergi'])){
        echo '<span class="text-danger">ID Referensi Tidak Boleh Kosong</span>';
    }else{
        $id_referensi_alergi=$_POST['id_referensi_alergi'];
        $HapusAlergi = mysqli_query($Conn, "DELETE FROM referensi_alergi WHERE id_referensi_alergi='$id_referensi_alergi'") or die(mysqli_error($Conn));
        if($HapusAlergi){
            $JsonUrl="../../_Page/Log/Log.json";
            $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Hapus Referensi Alergi","Referensi Alergi",$SessionIdAkses,$JsonUrl);
            if($MenyimpanLog=="Berhasil"){
                echo '<span class="text-success" id="NotifikasiHapusAlergiBerhasil">Success</span>';
            }else{
                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
            }
        }else{
            echo '<span class="text-danger">Hapus Data Referensi Alergi Gagal!</span>';
        }
    }
?>