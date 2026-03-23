<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingKoneksiWeb.php";
    include "../../_Config/WebFunction.php";
    $Url=urlService('Delete Footer Menu');
    $updatetime=date('Y-m-d H:i');
    //Validasi Form Data
    if(empty($_POST['id_web_menu'])){
        echo '<span class="text-danger">ID Footer Menu Tidak Boleh Kosong</span>';
    }else{
        $id_web_menu=$_POST['id_web_menu'];
        $KirimData = array(
            'api_key' => $api_key,
            'id_web_menu' => $id_web_menu
        );
        $Metode="POST";
        $Response=GetResponseApis($Url,$KirimData,$Metode);
        if(empty($Response)){
            echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Koneksi ke Website</span>';
        }else{
            $JsonData=$Response;
            if(!empty($JsonData['metadata']['massage'])){
                $massage=$JsonData['metadata']['massage'];
            }else{
                $massage="";
            }
            if(!empty($JsonData['metadata']['code'])){
                $code=$JsonData['metadata']['code'];
            }else{
                $code="";
            }
            if($code==200){
                echo '<span class="text-success" id="NotifikasiHapusFooterMenuBerhasil">Success</span>';
            }else{
                echo '<span class="text-danger">'.$massage.'</span>';
            }
        }
    }
?>