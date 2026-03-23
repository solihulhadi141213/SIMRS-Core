<?php
    //Pengaturan waktu
    date_default_timezone_set('Asia/Jakarta');
    //Koneksi dan akses
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    $now=date('Y-m-d H:i');
    $updatetime=date('Y-m-d H:i');
    //Validasi kelengkapan data
    if(empty($_POST['PutIdKonsultasi'])){
        echo '<span class="text-danger">ID Konsultasi Tidak Boleh Kosong!</span>';
    }else{
        if(empty($_POST['diagnosa_kerja'])){
            $diagnosa_kerja="";
        }else{
            $diagnosa_kerja=$_POST['diagnosa_kerja'];
            $diagnosa_kerja= addslashes($diagnosa_kerja);
            $diagnosa_kerja = str_replace(array("\r","\n"),"",$diagnosa_kerja);
        }
        if(empty($_POST['ikhtisar_klinis'])){
            $ikhtisar_klinis="";
        }else{
            $ikhtisar_klinis=$_POST['ikhtisar_klinis'];
            $ikhtisar_klinis= addslashes($ikhtisar_klinis);
            $ikhtisar_klinis = str_replace(array("\r","\n"),"",$ikhtisar_klinis);
        }
        if(empty($_POST['konsul_diminta'])){
            $konsul_diminta="";
        }else{
            $konsul_diminta=$_POST['konsul_diminta'];
            $konsul_diminta= addslashes($konsul_diminta);
            $konsul_diminta = str_replace(array("\r","\n"),"",$konsul_diminta);
        }
        $id_konsultasi=$_POST['PutIdKonsultasi'];
        $PermintaanKonsultasiArray = array(
            "diagnosa_kerja"=>"$diagnosa_kerja",
            "ikhtisar_klinis"=>"$ikhtisar_klinis",
            "konsul_diminta"=>"$konsul_diminta"
        );
        $JsonPermintaanKonsultasi = json_encode($PermintaanKonsultasiArray);
        //Simpan Data Ke Database
        $UpdatePermintaanKonsultasi= mysqli_query($Conn,"UPDATE konsultasi SET 
            permintaan_konsultasi='$JsonPermintaanKonsultasi'
        WHERE id_konsultasi='$id_konsultasi'") or die(mysqli_error($Conn));
        if($UpdatePermintaanKonsultasi){
            $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Update Permintaan Konsultasi","Kunjungan",$SessionIdAkses,$LogJsonFile);
            if($MenyimpanLog=="Berhasil"){
                echo '<span class="text-success" id="NotifikasiPermintaanKonsultasiBerhasil">Success</span>';
            }else{
                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
            }
        }else{
            echo '<span class="text-danger">Terjadi Kesalahan Pada Saat menyimpan Data Konsultasi</span>';
        }
    }
?>