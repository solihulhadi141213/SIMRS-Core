<?php
    //Connection
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    //Variabel
    if(empty($_POST['tanggal_setting'])){
        $tanggal_setting = date("Y-m-d");
    }else{
        $tanggal_setting = $_POST['tanggal_setting'];
    }
    if(empty($_POST['nama_font'])){
        $nama_font ="";
    }else{
        $nama_font = $_POST['nama_font'];
    }
    if(empty($_POST['ukuran_font'])){
        $ukuran_font ="";
    }else{
        $ukuran_font = $_POST['ukuran_font'];
    }
    if(empty($_POST['warna_font'])){
        $warna_font ="";
    }else{
        $warna_font = $_POST['warna_font'];
    }
    if(empty($_POST['satuan'])){
        $satuan ="";
    }else{
        $satuan = $_POST['satuan'];
    }
    if(empty($_POST['panjang_x'])){
        $panjang_x ="";
    }else{
        $panjang_x = $_POST['panjang_x'];
    }
    if(empty($_POST['lebar_y'])){
        $lebar_y ="";
    }else{
        $lebar_y = $_POST['lebar_y'];
    }
    if(empty($_POST['margin_atas'])){
        $margin_atas ="";
    }else{
        $margin_atas = $_POST['margin_atas'];
    }
    if(empty($_POST['margin_bawah'])){
        $margin_bawah ="";
    }else{
        $margin_bawah = $_POST['margin_bawah'];
    }
    if(empty($_POST['margin_kiri'])){
        $margin_kiri ="";
    }else{
        $margin_kiri = $_POST['margin_kiri'];
    }
    if(empty($_POST['margin_kanan'])){
        $margin_kanan ="";
    }else{
        $margin_kanan = $_POST['margin_kanan'];
    }
    if(empty($_POST['tampilkan_kode_obat'])){
        $tampilkan_kode_obat ="";
    }else{
        $tampilkan_kode_obat = $_POST['tampilkan_kode_obat'];
    }
    if(empty($_POST['tampilkan_nama_obat'])){
        $tampilkan_nama_obat ="";
    }else{
        $tampilkan_nama_obat = $_POST['tampilkan_nama_obat'];
    }
    if(empty($_POST['tampilkan_harga_obat'])){
        $tampilkan_harga_obat ="";
    }else{
        $tampilkan_harga_obat = $_POST['tampilkan_harga_obat'];
    }
    if(empty($_POST['ukuran_barcode'])){
        $ukuran_barcode ="";
    }else{
        $ukuran_barcode = $_POST['ukuran_barcode'];
    }
    //apakah setting sudah ada
    $query_hapus_setting = mysqli_query($Conn, "DELETE FROM setting_cetak_label WHERE id_akses='$SessionIdAkses'");
    if($query_hapus_setting){
        //Simpan Setting
        $query_simpan_setting = mysqli_query($Conn, "INSERT INTO setting_cetak_label (
            id_akses, 
            tanggal_setting, 
            nama_font, 
            ukuran_font, 
            warna_font, 
            satuan, 
            panjang_x, 
            lebar_y, 
            margin_atas, 
            margin_bawah, 
            margin_kiri, 
            margin_kanan, 
            tampilkan_kode_obat, 
            tampilkan_nama_obat, 
            tampilkan_harga_obat, 
            ukuran_barcode
        ) VALUES (
            '$SessionIdAkses', 
            '$tanggal_setting', 
            '$nama_font', 
            '$ukuran_font', 
            '$warna_font', 
            '$satuan', 
            '$panjang_x', 
            '$lebar_y', 
            '$margin_atas', 
            '$margin_bawah', 
            '$margin_kiri', 
            '$margin_kanan', 
            '$tampilkan_kode_obat', 
            '$tampilkan_nama_obat', 
            '$tampilkan_harga_obat', 
            '$ukuran_barcode'
        )");
        if($query_simpan_setting){
            echo "<span class='text-success' id='NotifikasiSimpanSettingLabelBerhasil'>Berhasil</span>";
            $_SESSION['NotifikasiSwal']="Simpan Setting Label Berhasil";
        }else{
            echo "<span class='text-danger'>Simpan Pengaturan Gagal!!</span>";
        }
    }
?>