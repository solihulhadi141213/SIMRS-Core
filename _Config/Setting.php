<?php
    //panggil dari database
    $QryPersonalisasiSetting = mysqli_query($Conn,"SELECT * FROM setting WHERE id_personalisasi='1'")or die(mysqli_error($Conn));
    $DataPersonalisasiSetting = mysqli_fetch_array($QryPersonalisasiSetting);
    //rincian profile user
    $judul_tab= $DataPersonalisasiSetting['judul_tab'];
    $judul_halaman= $DataPersonalisasiSetting['judul_halaman'];
    $warna= $DataPersonalisasiSetting['warna'];
    $favicon= $DataPersonalisasiSetting['favicon'];
    if(empty($DataPersonalisasiSetting['logo'])){
        $logo="noimage.jpg";
    }else{
        $logo= $DataPersonalisasiSetting['logo'];
    }
    $jenis_font= $DataPersonalisasiSetting['jenis_font'];
    $warna_font= $DataPersonalisasiSetting['warna_font'];
    $ukuran_font= $DataPersonalisasiSetting['ukuran_font'];
    $panjang_x= $DataPersonalisasiSetting['panjang_x'];
    $lebar_y= $DataPersonalisasiSetting['lebar_y'];
?>