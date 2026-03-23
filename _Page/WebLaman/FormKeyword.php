<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingKoneksiWeb.php";
    include "../../_Config/WebFunction.php";
    if(empty($_POST['keyword_by'])){
        echo '<input type="text" class="form-control" name="keyword" id="keyword" placeholder="Kata Kunci">';
        echo '<small>Kata Kunci</small>';
    }else{
        $keyword_by=$_POST['keyword_by'];
        if($keyword_by=="tanggal"){
            echo '<input type="date" class="form-control" name="keyword" id="keyword" placeholder="Kata Kunci">';
            echo '<small>Kata Kunci</small>';
        }else{
            echo '<input type="text" class="form-control" name="keyword" id="keyword" placeholder="Kata Kunci">';
            echo '<small>Kata Kunci</small>';
        }
    }
?>