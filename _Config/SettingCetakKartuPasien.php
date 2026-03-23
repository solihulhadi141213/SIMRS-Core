<?php
    //Setting Kartu Pasien
    $QrySettingkArtuPasien = mysqli_query($Conn,"SELECT * FROM setting_cetak_kartu WHERE id_akses='$SessionIdAkses'")or die(mysqli_error($Conn));
    $DataSettingKartuPasien = mysqli_fetch_array($QrySettingkArtuPasien);
    if(empty($DataSettingKartuPasien['id_setting_cetak'])){
        $IdSettingKartuPasien="";
        $TanggalSettingKartuPasien=date('Y-m-d');
        $NamaFornSettingKartuPasien="Times New Roman";
        $UkuranFornSettingKartuPasien="12pt";
        $WarnaFornSettingKartuPasien="#000";
        $PanjangSettingKartuPasien="150mm";
        $LebarSettingKartuPasien="80mm";
        $MarginAtasSettingKartuPasien="2mm";
        $MarginBawahKartuPasien="2mm";
        $MarginKiriKartuPasien="2mm";
        $MarginKananKartuPasien="2mm";
        $LogoKartuPasien="Ya";
        $PanjangLogoKartuPasien="30mm";
        $LebarLogoKartuPasien="25mm";
        $BarcodeKartuPasien="Ya";
        $UkuranBarcodeKartuPasien="25";
        $FotoKartuPasien="Ya";
        $PanjangFotoKartuPasien="25mm";
        $LebarFotoKartuPasien="25mm";
        $KutipanBawahKartuPasien="Ya";
        $IsiKutipanKartuPasien="Bawa Kartu ini ke dokter untuk pemeriksaan";
    }else{
        $IdSettingKartuPasien=$DataSettingKartuPasien['id_setting_cetak'];
        $TanggalSettingKartuPasien=$DataSettingKartuPasien['tanggal_setting'];
        $NamaFornSettingKartuPasien=$DataSettingKartuPasien['nama_font'];
        $UkuranFornSettingKartuPasien=$DataSettingKartuPasien['ukuran_font'];
        $WarnaFornSettingKartuPasien=$DataSettingKartuPasien['warna_font'];
        $PanjangSettingKartuPasien=$DataSettingKartuPasien['panjang_x'];
        $LebarSettingKartuPasien=$DataSettingKartuPasien['lebar_y'];
        $MarginAtasSettingKartuPasien=$DataSettingKartuPasien['margin_atas'];
        $MarginBawahKartuPasien=$DataSettingKartuPasien['margin_bawah'];
        $MarginKiriKartuPasien=$DataSettingKartuPasien['margin_kiri'];
        $MarginKananKartuPasien=$DataSettingKartuPasien['margin_kanan'];
        $LogoKartuPasien=$DataSettingKartuPasien['tampilkan_logo'];
        $PanjangLogoKartuPasien=$DataSettingKartuPasien['panjang_logo'];
        $LebarLogoKartuPasien=$DataSettingKartuPasien['lebar_logo'];
        $BarcodeKartuPasien=$DataSettingKartuPasien['tampilkan_barcode'];
        $UkuranBarcodeKartuPasien=$DataSettingKartuPasien['ukuran_barcode'];
        $FotoKartuPasien=$DataSettingKartuPasien['tampilkan_foto'];
        $PanjangFotoKartuPasien=$DataSettingKartuPasien['panjang_foto'];
        $LebarFotoKartuPasien=$DataSettingKartuPasien['lebar_foto'];
        $KutipanBawahKartuPasien=$DataSettingKartuPasien['kutipan_bawah'];
        $IsiKutipanKartuPasien=$DataSettingKartuPasien['isi_kutipan'];
    }
    
?>