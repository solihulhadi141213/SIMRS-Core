<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    $now=date('Y-m-d H:i');
    if(empty($_POST['GetIdRad'])){
        echo '<span class="text-danger">ID Radiolofi Tidak Boleh Kosong</span>';
    }else{
        if(empty($_POST['klinis'])){
            echo '<span class="text-danger">Silahkan Isi Klinis Pasien Atau Pilih Tombol Kembali Untuk Membatalkan Pengisian</span>';
        }else{
            $id_rad=$_POST['GetIdRad'];
            $klinis=$_POST['klinis'];
            //Update Data Radiologi
            $UpdateRadiologi = mysqli_query($Conn,"UPDATE radiologi SET 
                klinis='$klinis'
            WHERE id_rad='$id_rad'") or die(mysqli_error($Conn)); 
            if($UpdateRadiologi){
                //menyimpan Log
                $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Update Radiologi","Radiologi",$SessionIdAkses,$LogJsonFile);
                if($MenyimpanLog=="Berhasil"){
                    $_SESSION['NotifikasiSwal']="Pengisian Klinis Pasien Berhasil";
                    echo '<input type="hidden" name="GetBackUrl" id="GetBackUrl" value="index.php?Page=Radiologi&Sub=DetailRadiologi&id='.$id_rad.'">';
                    echo '<span class="text-success" id="NotifikasiPengisianKlinisPasienBerhasil">Success</span>';
                }else{
                    echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                }
            }else{
                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Data!</span>';
            }
        }
    }
?>