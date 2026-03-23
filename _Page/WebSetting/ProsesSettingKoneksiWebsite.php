<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    $updatetime=date('Y-m-d H:i');
    //Validasi Form Data
    if(empty($_POST['api_key'])){
        echo '<span class="text-danger">API Key Tidak Boleh Kosong</span>';
    }else{
        if(empty($_POST['base_url_service'])){
            echo '<span class="text-danger">Base URL Tidak Boleh Kosong</span>';
        }else{
            $api_key=$_POST['api_key'];
            $base_url_service=$_POST['base_url_service'];
            //Cek Apakah Data Setting Web Info Sudah Ada
            $Qry = mysqli_query($Conn,"SELECT * FROM setting_web")or die(mysqli_error($Conn));
            $Data = mysqli_fetch_array($Qry);
            if(!empty($Data['id_setting_web'])){
                //Apabila Sudah Ada Lakukan Proses Update
                $UpdateSettingWeb= mysqli_query($Conn,"UPDATE setting_web SET 
                    api_key='$api_key',
                    base_url_service='$base_url_service',
                    last_update='$updatetime'
                ") or die(mysqli_error($Conn)); 
                if($UpdateSettingWeb){
                    $_SESSION['NotifikasiSwal']="Setting Koneksi Website";
                    echo '<span class="text-danger" id="NotifikasiSettingKoneksiWebsiteBerhasil">Success</span>';
                }else{
                    echo '<span class="text-danger">Update Setting Koneksi Gagal</span>';
                }
            }else{
                //Apabila Belum Ada Lakukan Insert
                $SqlSettingKoneksi = "INSERT INTO setting_web (
                    api_key, 
                    base_url_service,
                    last_update
                ) VALUES (
                    '$api_key',
                    '$base_url_service',
                    '$updatetime'
                )";
                $SimpanSettingKoneksi = mysqli_query($Conn, $SqlSettingKoneksi);
                if($SimpanSettingKoneksi){
                    $_SESSION['NotifikasiSwal']="Setting Koneksi Website";
                    echo '<span class="text-success" id="NotifikasiSettingKoneksiWebsiteBerhasil">Success</span>';
                }else{
                    echo '<span class="text-danger">Insert Setting Koneksi Gagal</span>';
                }
            }
        }
    }
?>