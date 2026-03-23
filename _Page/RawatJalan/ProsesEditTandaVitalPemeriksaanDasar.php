<?php
    //Time Zone
    date_default_timezone_set('Asia/Jakarta');
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    //Time Now Tmp
    $now=date('Y-m-d H:i:s');
    //Validasi id_kunjungan tidak boleh kosong
    if(empty($_POST['IdKunjunganTandaVital'])){
        echo '<small class="text-danger">ID Kunjungan tidak boleh kosong</small>';
    }else{
        $id_kunjungan=$_POST['IdKunjunganTandaVital'];
        //Validasi Data Tidak Wajib
        if(empty($_POST['denyut_jantung'])){
            $denyut_jantung="";
        }else{
            $denyut_jantung=$_POST['denyut_jantung'];
        }
        if(empty($_POST['pernapasan'])){
            $pernapasan="";
        }else{
            $pernapasan=$_POST['pernapasan'];
        }
        if(empty($_POST['sistole'])){
            $sistole="";
        }else{
            $sistole=$_POST['sistole'];
        }
        if(empty($_POST['diastole'])){
            $diastole="";
        }else{
            $diastole=$_POST['diastole'];
        }
        if(empty($_POST['suhu'])){
            $suhu="";
        }else{
            $suhu=$_POST['suhu'];
        }
        if(empty($_POST['SpO2'])){
            $SpO2="";
        }else{
            $SpO2=$_POST['SpO2'];
        }
        if(empty($_POST['tinggi_badan'])){
            $tinggi_badan="";
        }else{
            $tinggi_badan=$_POST['tinggi_badan'];
        }
        if(empty($_POST['berat_badan'])){
            $berat_badan="";
        }else{
            $berat_badan=$_POST['berat_badan'];
        }
        $TandaVital=Array (
            "denyut_jantung" => $denyut_jantung,
            "pernapasan" => $pernapasan,
            "sistole" => $sistole,
            "diastole" => $diastole,
            "suhu" => $suhu,
            "SpO2" => $SpO2,
            "tinggi_badan" => $tinggi_badan,
            "berat_badan" => $berat_badan
        );
        $TandaVital= json_encode($TandaVital);
        $UpdatePemeriksaanFisik= mysqli_query($Conn,"UPDATE pemeriksaan_fisik SET 
            tanda_vital='$TandaVital'
        WHERE id_kunjungan='$id_kunjungan'") or die(mysqli_error($Conn));
        if($UpdatePemeriksaanFisik){
            $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Update Tanda Vital","Kunjungan",$SessionIdAkses,$LogJsonFile);
            if($MenyimpanLog=="Berhasil"){
                echo '<span class="text-success" id="NotifikasiEditTandaVitalBerhasil">Success</span>';
            }else{
                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
            }
        }else{
            echo '<span class="text-danger">Terjadi kesalahan pada saat melakukan update pemeriksaan Fisik!</span><br>';
        }
    }
?>
