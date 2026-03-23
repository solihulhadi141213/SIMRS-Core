<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Menangkap id_encounter
    if(empty($_POST['id_encounter'])){
        echo '<div class="row">';
        echo '<div class="col-md-12 text-center"><span class="text-danger">ID Encounter Tidak Boleh Kosong!</span></div>';
        echo '</div>';
    }else{
        $id_encounter=$_POST['id_encounter'];
        $SettingSatuSehat=getDataDetail($Conn,' setting_satusehat','status','Active','id_setting_satusehat');
        $Token=GenerateTokenSatuSehat($Conn);
        $baseurl_satusehat=getDataDetail($Conn,'setting_satusehat','status','Active','baseurl');
        if(empty($SettingSatuSehat)){
            echo '<div class="row">';
            echo '  <div class="col-md-12 text-danger text-center">';
            echo '      Tidak Ada Setting Satu Sehat Yang Aktif!';
            echo '  </div>';
            echo '</div>';
        }else{
            if(empty($Token)){
                echo '<div class="row">';
                echo '  <div class="col-md-12 text-danger text-center">';
                echo '      Gagal Melakukan Generate Token!';
                echo '  </div>';
                echo '</div>';
            }else{
                if(empty($baseurl_satusehat)){
                    echo '<div class="row">';
                    echo '  <div class="col-md-12 text-danger text-center">';
                    echo '      Tidak Ada Base URL Satu Sehat!';
                    echo '  </div>';
                    echo '</div>';
                }else{
                    $response=EncounterById($baseurl_satusehat,$Token,$id_encounter);
                    $json_decode =json_decode($response, true);
                    include "../../_Page/RawatJalan/EncounterById.php";
                }
            }
        }
    }
?>