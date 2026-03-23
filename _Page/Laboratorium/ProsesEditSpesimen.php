<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    $now=date('Y-m-d H:i');
    //Tangkap id_laboratorium_sample
    if(empty($_POST['id_laboratorium_sample'])){
        echo '<span class="text-danger">ID Spesimen Tidak Boleh Kosong!</span>';
    }else{
        $id_laboratorium_sample=$_POST['id_laboratorium_sample'];
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
        //Menyimpan data
        $UpdateSpesimen= mysqli_query($Conn,"UPDATE laboratorium_sample SET 
            waktu_pengambilan='$WaktuPengambilan',
            sumber='$sumber',
            lokasi_pengambilan='$lokasi_pengambilan',
            jumlah_sample='$jumlah_sample',
            volume_sample='$volume_sample',
            metode='$metode',
            kondisi='$kondisi',
            waktu_fiksasi='$waktu_fiksasi',
            cairan_fiksasi='$cairan_fiksasi',
            volume_fiksasi='$volume_fiksasi',
            petugas_sample='$petugas_sample',
            petugas_pengantar='$petugas_pengantar',
            petugas_penerima='$petugas_penerima',
            status='$status'
        WHERE id_laboratorium_sample='$id_laboratorium_sample'") or die(mysqli_error($Conn));
        if($UpdateSpesimen){
            //menyimpan Log
            $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Tambah Spesimen Pemeriksaan","Laboratorium",$SessionIdAkses,$LogJsonFile);
            if($MenyimpanLog=="Berhasil"){
                $_SESSION['NotifikasiSwal']="Edit Spesimen Berhasil";
                echo '<span class="text-success" id="NotifikasiEditSpesimenBerhasil">Success</span>';
            }else{
                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
            }
        }else{
            echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Data!</span>';
        }
    }
?>