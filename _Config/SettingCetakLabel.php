<?php
    //Setting Kartu Pasien
    $QrySettingLabel = mysqli_query($Conn,"SELECT * FROM setting_cetak_label WHERE id_akses='$SessionIdAkses'")or die(mysqli_error($Conn));
    $DataSettingLabel = mysqli_fetch_array($QrySettingLabel);
    if(empty($DataSettingLabel['id_setting_cetak_label'])){
        $IdSettingCetakLabel="";
        $TanggalSettingLabel=date('Y-m-d');
        $NamaFontSettingLabel="Times New Roman";
        $UkuranFontSettingLabel="8pt";
        $WarnaFontSettingLabel="#000";
        $SatuanSettingLabel="mm";
        $PanjangSettingLabel="80";
        $LebarSettingLabel="20";
        $MarginAtasSettingLabel="1";
        $MarginBawahLabel="1";
        $MarginKiriLabel="1";
        $MarginKananLabel="1";
        $KodeObatLabel="Ya";
        $NamaObatLabel="Ya";
        $HargaObatLabel="Ya";
        $UkuranBarcodeLabel="25";
    }else{
        $IdSettingCetakLabel=$DataSettingLabel['id_setting_cetak_label'];
        $TanggalSettingLabel=$DataSettingLabel['tanggal_setting'];
        $NamaFontSettingLabel=$DataSettingLabel['nama_font'];
        $UkuranFontSettingLabel=$DataSettingLabel['ukuran_font'];
        $WarnaFontSettingLabel=$DataSettingLabel['warna_font'];
        $SatuanSettingLabel=$DataSettingLabel['satuan'];
        $PanjangSettingLabel=$DataSettingLabel['panjang_x'];
        $LebarSettingLabel=$DataSettingLabel['lebar_y'];
        $MarginAtasSettingLabel=$DataSettingLabel['margin_atas'];
        $MarginBawahLabel=$DataSettingLabel['margin_bawah'];
        $MarginKiriLabel=$DataSettingLabel['margin_kiri'];
        $MarginKananLabel=$DataSettingLabel['margin_kanan'];
        $KodeObatLabel=$DataSettingLabel['tampilkan_kode_obat'];
        $NamaObatLabel=$DataSettingLabel['tampilkan_nama_obat'];
        $HargaObatLabel=$DataSettingLabel['tampilkan_harga_obat'];
        $UkuranBarcodeLabel=$DataSettingLabel['ukuran_barcode'];
    }
    
?>