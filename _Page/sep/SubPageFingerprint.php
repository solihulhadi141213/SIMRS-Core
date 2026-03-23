<?php
    date_default_timezone_set('UTC');
    include "../../_Config/Connection.php";
    include "../../_Config/SettingBridging.php";
    include "../../_Config/SimrsFunction.php";
    include "../../vendor/autoload.php";
    if(empty($_POST['TanggalPelayanan'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center text-danger">Tanggal Pelayanan Tidak Boleh Kosong!</div>';
        echo '</div>';
    }else{
        if(empty($_POST['noKartuPeserta'])){
            echo '<div class="row">';
            echo '  <div class="col-md-12 text-center text-danger">Nomor Kartu Tidak Boleh Kosong!</div>';
            echo '</div>';
        }else{
            $TanggalPelayanan=$_POST['TanggalPelayanan'];
            $noKartuPeserta=$_POST['noKartuPeserta'];
            $url="$url_vclaim/SEP/FingerPrint/Peserta/$noKartuPeserta/TglPelayanan/$TanggalPelayanan";
            $Response=BridgingServiceGet($consid,$secret_key,$user_key,$url);
            $JsonResponse =json_decode($Response, true);
            if(empty($JsonResponse["metaData"]["code"])){
                echo '<div class="row">';
                echo '  <div class="col-md-12 text-center text-danger">Response Gagal!</div>';
                echo '</div>';
            }else{
                if($JsonResponse["metaData"]["code"]!=="200"){
                    if(empty($JsonResponse["metaData"]["message"])){
                        echo '<div class="row">';
                        echo '  <div class="col-md-12 text-center text-danger">Response Gagal!</div>';
                        echo '</div>';
                    }else{
                        echo '<div class="row">';
                        echo '  <div class="col-md-12 text-center text-danger">Pesan: '.$JsonResponse["metaData"]["message"].'</div>';
                        echo '</div>';
                    }
                }else{
                    $string=$JsonResponse["response"];
                    $stringData =json_decode($string, true);
                    $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
                    $key="$consid$secret_key$timestamp";
                    //--masukan ke fungsi
                    $FileDeskripsi=stringDecrypt("$key", "$string");
                    $FileDekompresi=decompress("$FileDeskripsi");
                    //--konveris json to raw
                    $JsonData =json_decode($FileDekompresi, true);
                    if(empty($JsonData['status'])){
                        echo '<div class="row">';
                        echo '  <div class="col-md-12 text-center text-danger">Gagal Melakukan Deskripsi Data</div>';
                        echo '</div>';
                    }else{
                        echo '<div class="row">';
                        echo '  <div class="col-md-12">';
                        echo '      Status Finger Print';
                        echo '      <ol>';
                        echo '          <li>Kode : <code class="text-dark">'.$JsonData['kode'].'</code></li>';
                        echo '          <li>Status : <code class="text-dark">'.$JsonData['status'].'</code></li>';
                        echo '      </ol>';
                        echo '  </div>';
                        echo '</div>';
                    }
                }
            }
        }
    }
?>