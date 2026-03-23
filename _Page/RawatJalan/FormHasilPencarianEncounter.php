<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Menangkap Dasar Pencarian Encounter
    if(empty($_POST['DasarPencarianEncounter'])){
        echo '<div class="row">';
        echo '<div class="col-md-12 text-center"><span class="text-danger">Anda Harus Memilih Dasar Pencarian Terlebih Dulu</span></div>';
        echo '</div>';
    }else{
        //Apabila Keyword Encounter Kosong
        if(empty($_POST['keyword_encounter'])){
            echo '<div class="row">';
            echo '<div class="col-md-12 text-center"><span class="text-danger">Anda Harus Keyword Pencarian Terlebih Dulu</span></div>';
            echo '</div>';
        }else{
            $DasarPencarianEncounter=$_POST['DasarPencarianEncounter'];
            $keyword_encounter=$_POST['keyword_encounter'];
            //Setting Koneksi
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
                        if($DasarPencarianEncounter=="ID Encounter"){
                            $response=EncounterById($baseurl_satusehat,$Token,$keyword_encounter);
                            $json_decode =json_decode($response, true);
                            include "../../_Page/RawatJalan/EncounterById.php";
                        }else{
                            if($DasarPencarianEncounter=="Subject"){
                                $response=EncounterBySubject($baseurl_satusehat,$Token,$keyword_encounter);
                                $json_decode =json_decode($response, true);
                                include "../../_Page/RawatJalan/EncounterBySubject.php";
                            }else{
                                echo '<div class="row">';
                                echo '  <div class="col-md-12 text-danger text-center">';
                                echo '      Dasar Pencarian Tidak Valid!';
                                echo '  </div>';
                                echo '</div>';
                            }
                        }
                    }
                }
            }
        }
    }
?>