<?php
    date_default_timezone_set('UTC');
    include "../../_Config/Connection.php";
    include "../../_Config/SettingBridging.php";
    include "../../_Config/SimrsFunction.php";
    include "../../vendor/autoload.php";
    if(empty($_POST['KodeJenisPelayanan'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center text-danger">Kode Jenis Pelayanan Tidak Boleh Kosong!</div>';
        echo '</div>';
    }else{
        if(empty($_POST['RealTglSep'])){
            echo '<div class="row">';
            echo '  <div class="col-md-12 text-center text-danger">Tanggal Pelayanan Tidak Boleh Kosong!</div>';
            echo '</div>';
        }else{
            if(empty($_POST['sep'])){
                echo '<div class="row">';
                echo '  <div class="col-md-12 text-center text-danger">Nomor SEP Tidak Boleh Kosong!</div>';
                echo '</div>';
            }else{
                $JenisPelayanan=$_POST['KodeJenisPelayanan'];
                $TglSep=$_POST['RealTglSep'];
                $sep=$_POST['sep'];
                $url="$url_vclaim/LPK/TglMasuk/TglSep/JnsPelayanan/$JenisPelayanan";
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
                        echo "$JsonResponse";
                    }
                }
            }
        }
    }
?>