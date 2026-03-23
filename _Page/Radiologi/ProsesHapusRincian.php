<?php
    //KONEKSI KE DATABASE
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    $now=date('Y-m-d H:i');
    if(empty($_POST['id_rincian'])){
        echo '<span class="text-danger">ID Rincian Tidak Boleh Kosong</span>';
    }else{
        $id_rincian=$_POST['id_rincian'];
        $HapusRincianRadiologi = mysqli_query($Conn, "DELETE from radiologi_rincian WHERE id_rincian='$id_rincian'") or die(mysqli_error($Conn));
        if ($HapusRincianRadiologi) {
            //menyimpan Log
            $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Hapus Rincian Radiologi","Radiologi",$SessionIdAkses,$LogJsonFile);
            if($MenyimpanLog=="Berhasil"){
                $_SESSION['NotifikasiSwal']="Hapus Rincian Radiologi Berhasil";
                echo '<span class="text-success" id="NotifikasiHapusRincianBerhasil">Success</span>';
            }else{
                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
            }
        }else{
            echo '<span class="text-danger">Hapus Rincian Gagal!</span>';
        }
    }
?>