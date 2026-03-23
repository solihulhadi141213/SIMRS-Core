<?php
    //Kode Akses Tidak Boleh Kosong
    if(empty($_POST['kode_akses'])){
        echo 'Kode Akses Tidak Boleh Kosong';
    }else{
        $kode_akses=$_POST['kode_akses'];
        //Buka Data Setting
        $settingsFile="setting-koneksi.json";
        if(!file_exists($settingsFile)) {
            echo 'File Setting Tidak Ditemukan';
        }else{
            $settingsData = json_decode(file_get_contents($settingsFile), true);
            $base_url_monitor=$settingsData['base-url-monitor'];
            $access_key=$settingsData['access-key'];
            //Susun URL
            echo "$base_url_monitor/index.php?kode=$kode_akses";
        }
    }
?>