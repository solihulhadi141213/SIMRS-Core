<?php
    //Setting Time Data
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    $TanggalSekarang=date('Y-m-d');
    //Mencari No Antrian yang di panggil
    $QryAtrianPanggil = mysqli_query($Conn,"SELECT * FROM antrian WHERE tanggal_kunjungan='$TanggalSekarang' AND status='Panggil'")or die(mysqli_error($Conn));
    $DataAntrianPanggil = mysqli_fetch_array($QryAtrianPanggil);
    if(empty($DataAntrianPanggil['no_antrian'])){
        $no_antrian="00";
        $kodebooking ="None";
        $nama_dokter ="No data";
        $kodepoli ="None";
        $namapoli ="None";
    }else{
        $no_antrian = $DataAntrianPanggil['no_antrian'];
        $no_antrian = sprintf("%02d", $no_antrian);
        $kodebooking = $DataAntrianPanggil['kodebooking'];
        $nama_dokter = $DataAntrianPanggil['nama_dokter'];
        $kodepoli = $DataAntrianPanggil['kodepoli'];
        $namapoli = $DataAntrianPanggil['namapoli'];
    }
    echo "<span id='PanggilNoAntrian'>$no_antrian</span><br>";
    echo "<span id='PanggilKodeBooking'>$kodebooking</span><br>";
    echo "<span id='PanggilNamaDokter'>$nama_dokter</span><br>";
    echo "<span id='PanggiKodePoli'>$kodepoli</span><br>";
    echo "<span id='PanggilNamaPoli'>$namapoli</span><br>";
?>