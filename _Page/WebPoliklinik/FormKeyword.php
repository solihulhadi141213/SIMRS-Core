<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingKoneksiWeb.php";
    include "../../_Config/WebFunction.php";
    include "../../_Page/WebPoliklinik/WebPoliklinikFunction.php";
    $UrlInfo=urlService('Info Poliklinik');
    //Get Data keyword_by
    if(empty($_POST['keyword_by'])){
        echo '<input type="text" class="form-control" name="keyword" id="keyword" placeholder="Kata Kunci">';
        echo '<small>Kata Kunci</small>';
    }else{
        $keyword_by=$_POST['keyword_by'];
        if($keyword_by=="last_update"){
            echo '<input type="date" class="form-control" name="keyword" id="keyword" placeholder="Kata Kunci">';
            echo '<small>Kata Kunci</small>';
        }else{
            if($keyword_by=="status"){
                echo '<select class="form-control" name="keyword" id="keyword">';
                echo '  <option value="">Semua</option>';
                $JdonDataInfo=GetInfoPoliklinik($api_key,$UrlInfo);
                $massage=$JdonDataInfo['metadata']['massage'];
                if($massage=="Berhasil"){
                    $list_kolom=$JdonDataInfo['response']['list_status'];
                    foreach ($list_kolom as $value){
                        $list_status=$value['status'];
                        echo '  <option value="'.$list_status.'">'.$list_status.'</option>';
                    }
                }
                echo '</select>';
                echo '<small>Kata Kunci</small>';
            }else{
                echo '<input type="text" class="form-control" name="keyword" id="keyword" placeholder="Kata Kunci">';
                echo '<small>Kata Kunci</small>';
            }
        }
    }
?>