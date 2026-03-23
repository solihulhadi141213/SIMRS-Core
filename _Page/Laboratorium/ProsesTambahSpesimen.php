<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    $now=date('Y-m-d H:i');
    //Tangkap id_permintaan
    if(empty($_POST['id_lab'])){
        echo '<span class="text-danger">ID Lab Tidak Boleh Kosong!</span>';
    }else{
        $id_lab=$_POST['id_lab'];
        //Menangkap variabel lainnya
        if(empty($_POST['tanggal_pengambilan'])){
            $tanggal_pengambilan=$_POST['tanggal_pengambilan'];
        }else{
            $tanggal_pengambilan=$_POST['tanggal_pengambilan'];
        }
        if(empty($_POST['waktu_pengambilan'])){
            $waktu_pengambilan=$_POST['waktu_pengambilan'];
        }else{
            $waktu_pengambilan=$_POST['waktu_pengambilan'];
        }
        $WaktuPengambilan="$tanggal_pengambilan $waktu_pengambilan";
        if(empty($_POST['sumber'])){
            $sumber=$_POST['sumber'];
        }else{
            $sumber=$_POST['sumber'];
        }
        if(empty($_POST['lokasi_pengambilan'])){
            $lokasi_pengambilan=$_POST['lokasi_pengambilan'];
        }else{
            $lokasi_pengambilan=$_POST['lokasi_pengambilan'];
        }
        if(empty($_POST['jumlah_sample'])){
            $jumlah_sample=$_POST['jumlah_sample'];
        }else{
            $jumlah_sample=$_POST['jumlah_sample'];
        }
        if(empty($_POST['volume_sample'])){
            $volume_sample=$_POST['volume_sample'];
        }else{
            $volume_sample=$_POST['volume_sample'];
        }
        if(empty($_POST['metode'])){
            $metode=$_POST['metode'];
        }else{
            $metode=$_POST['metode'];
        }
        if(empty($_POST['kondisi'])){
            $kondisi=$_POST['kondisi'];
        }else{
            $kondisi=$_POST['kondisi'];
        }
        if(empty($_POST['tanggal_fiksasi'])){
            $tanggal_fiksasi=$_POST['tanggal_fiksasi'];
        }else{
            $tanggal_fiksasi=$_POST['tanggal_fiksasi'];
        }
        if(empty($_POST['jam_fiksasi'])){
            $jam_fiksasi=$_POST['jam_fiksasi'];
        }else{
            $jam_fiksasi=$_POST['jam_fiksasi'];
        }
        $waktu_fiksasi="$tanggal_fiksasi $jam_fiksasi";
        if(empty($_POST['cairan_fiksasi'])){
            $cairan_fiksasi=$_POST['cairan_fiksasi'];
        }else{
            $cairan_fiksasi=$_POST['cairan_fiksasi'];
        }
        if(empty($_POST['volume_fiksasi'])){
            $volume_fiksasi=$_POST['volume_fiksasi'];
        }else{
            $volume_fiksasi=$_POST['volume_fiksasi'];
        }
        if(empty($_POST['petugas_sample'])){
            $petugas_sample=$_POST['petugas_sample'];
        }else{
            $petugas_sample=$_POST['petugas_sample'];
        }
        if(empty($_POST['petugas_pengantar'])){
            $petugas_pengantar=$_POST['petugas_pengantar'];
        }else{
            $petugas_pengantar=$_POST['petugas_pengantar'];
        }
        if(empty($_POST['petugas_penerima'])){
            $petugas_penerima=$_POST['petugas_penerima'];
        }else{
            $petugas_penerima=$_POST['petugas_penerima'];
        }
        if(empty($_POST['status'])){
            $status=$_POST['status'];
        }else{
            $status=$_POST['status'];
        }
        //Validasi duplikat data
        $ValidasiDuplikatData=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM laboratorium_sample WHERE id_lab='$id_lab' AND waktu_pengambilan='$WaktuPengambilan'"));
        if(!empty($ValidasiDuplikatData)){
            echo '<span class="text-danger">Data Tersebut Sudah Ada, Bedakan Waktu Pengambilan</span>';
        }else{
            //Menyimpan data
            $entry="INSERT INTO laboratorium_sample (
                id_lab,
                waktu_pengambilan,
                sumber,
                lokasi_pengambilan,
                jumlah_sample,
                volume_sample,
                metode,
                kondisi,
                waktu_fiksasi,
                cairan_fiksasi,
                volume_fiksasi,
                petugas_sample,
                petugas_pengantar,
                petugas_penerima,
                status
            )VALUES (
                '$id_lab',
                '$WaktuPengambilan',
                '$sumber',
                '$lokasi_pengambilan',
                '$jumlah_sample',
                '$volume_sample',
                '$metode',
                '$kondisi',
                '$waktu_fiksasi',
                '$cairan_fiksasi',
                '$volume_fiksasi',
                '$petugas_sample',
                '$petugas_pengantar',
                '$petugas_penerima',
                '$status'
            )";
            $hasil=mysqli_query($Conn, $entry);
            if($hasil){
                //menyimpan Log
                $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Tambah Spesimen Pemeriksaan","Laboratorium",$SessionIdAkses,$LogJsonFile);
                if($MenyimpanLog=="Berhasil"){
                    $_SESSION['NotifikasiSwal']="Tambah Spesimen Berhasil";
                    echo '<span class="text-success" id="NotifikasiTambahSpesimenBerhasil">Success</span>';
                }else{
                    echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                }
            }else{
                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Data!</span>';
            }
        }
    }
?>