<?php
    date_default_timezone_set('UTC');
    include "../../_Config/Connection.php";
    include "../../_Config/SettingBridging.php";
    include "../../_Config/SimrsFunction.php";
    include "../../vendor/autoload.php";
    if(empty($_POST['sep'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center text-danger">Tidak Ada Nomor SEP Untuk Dilakukan Pencarian SEP Internal</div>';
        echo '</div>';
    }else{
        $sep=$_POST['sep'];
        $url="$url_vclaim/SEP/Internal/$sep";
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
                $CountSepInternal=$JsonResponse["response"]["count"];
            }
        }
    }
?>