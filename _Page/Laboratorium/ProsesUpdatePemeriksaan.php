<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    $now=date('Y-m-d H:i');
    if(empty($_POST['id_permintaan'])){
        echo '<span class="text-danger">ID Permintaan Tidak Boleh Kosong</span>';
    }else{
        $id_permintaan=$_POST['id_permintaan'];
        if(empty($_POST['tanggal_pendaftaran'])){
            $tanggal_pendaftaran="";
        }else{
            $tanggal_pendaftaran=$_POST['tanggal_pendaftaran'];
        }
        if(empty($_POST['jam_pendaftaran'])){
            $jam_pendaftaran="";
        }else{
            $jam_pendaftaran=$_POST['jam_pendaftaran'];
        }
        $waktu_pendaftaran="$tanggal_pendaftaran $jam_pendaftaran";
        if(empty($_POST['tanggal_pengambilan_sample'])){
            $tanggal_pengambilan_sample="";
        }else{
            $tanggal_pengambilan_sample=$_POST['tanggal_pengambilan_sample'];
        }
        if(empty($_POST['jam_pengambilan_sample'])){
            $jam_pengambilan_sample="";
        }else{
            $jam_pengambilan_sample=$_POST['jam_pengambilan_sample'];
        }
        $pengambilan_sample="$tanggal_pengambilan_sample $jam_pengambilan_sample";
        if(empty($_POST['tanggal_pemeriksaan_sample'])){
            $tanggal_pemeriksaan_sample="";
        }else{
            $tanggal_pemeriksaan_sample=$_POST['tanggal_pemeriksaan_sample'];
        }
        if(empty($_POST['jam_pemeriksaan_sample'])){
            $jam_pemeriksaan_sample="";
        }else{
            $jam_pemeriksaan_sample=$_POST['jam_pemeriksaan_sample'];
        }
        $pemeriksaan_sample="$tanggal_pemeriksaan_sample $jam_pemeriksaan_sample";
        if(empty($_POST['tanggal_keluar_hasil'])){
            $tanggal_keluar_hasil="";
        }else{
            $tanggal_keluar_hasil=$_POST['tanggal_keluar_hasil'];
        }
        if(empty($_POST['jam_keluar_hasil'])){
            $jam_keluar_hasil="";
        }else{
            $jam_keluar_hasil=$_POST['jam_keluar_hasil'];
        }
        $keluar_hasil="$tanggal_keluar_hasil $jam_keluar_hasil";
        if(empty($_POST['tanggal_hasil_diserahkan'])){
            $tanggal_hasil_diserahkan="";
        }else{
            $tanggal_hasil_diserahkan=$_POST['tanggal_hasil_diserahkan'];
        }
        if(empty($_POST['jam_hasil_diserahkan'])){
            $jam_hasil_diserahkan="";
        }else{
            $jam_hasil_diserahkan=$_POST['jam_hasil_diserahkan'];
        }
        $hasil_diserahkan="$tanggal_hasil_diserahkan $jam_hasil_diserahkan";
        if(empty($_POST['metode_penyerahan'])){
            $metode_penyerahan="";
        }else{
            $metode_penyerahan=$_POST['metode_penyerahan'];
        }
        if(empty($_POST['interpertasi_hasil'])){
            $interpertasi_hasil="";
        }else{
            $interpertasi_hasil=$_POST['interpertasi_hasil'];
        }
        if(empty($_POST['dokter_interpertasi'])){
            $dokter_interpertasi="";
        }else{
            $dokter_interpertasi=$_POST['dokter_interpertasi'];
        }
        if(empty($_POST['dokter_validator'])){
            $dokter_validator="";
        }else{
            $dokter_validator=$_POST['dokter_validator'];
        }
        if(empty($_POST['petugas_analis'])){
            $petugas_analis="";
        }else{
            $petugas_analis=$_POST['petugas_analis'];
        }
        $UpdatePemeriksaan= mysqli_query($Conn,"UPDATE laboratorium_pemeriksaan SET 
            waktu_pendaftaran='$waktu_pendaftaran',
            pengambilan_sample='$pengambilan_sample',
            pemeriksaan_sample='$pemeriksaan_sample',
            keluar_hasil='$keluar_hasil',
            hasil_diserahkan='$hasil_diserahkan',
            metode_penyerahan='$metode_penyerahan',
            interpertasi_hasil='$interpertasi_hasil',
            dokter_interpertasi='$dokter_interpertasi',
            dokter_validator='$dokter_validator',
            petugas_analis='$petugas_analis'
        WHERE id_permintaan='$id_permintaan'") or die(mysqli_error($Conn));
        if($UpdatePemeriksaan){
            //menyimpan Log
            $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Update Informasi Pemeriksaan","Laboratorium",$SessionIdAkses,$LogJsonFile);
            if($MenyimpanLog=="Berhasil"){
                $_SESSION['NotifikasiSwal']="Update Informasi Pemeriksaan Berhasil";
                echo '<span class="text-success" id="NotifikasiUpdatePemeriksaanBerhasil">Success</span>';
            }else{
                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
            }
        }else{
            echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Data!</span>';
        }
    }
?>