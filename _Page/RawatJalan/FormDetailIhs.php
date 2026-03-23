<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Menangkap id_ihs
    if(empty($_POST['id_ihs'])){
        echo '<div class="row">';
        echo '<div class="col-md-12 text-center"><span class="text-danger">ID IHS Tidak Boleh Kosong</span></div>';
        echo '</div>';
    }else{
        //Setting Koneksi
        $SettingSatuSehat=getDataDetail($Conn,' setting_satusehat','status','Active','id_setting_satusehat');
        if(empty($SettingSatuSehat)){
            echo '<div class="row">';
            echo '  <div class="col-md-12 text-danger text-center">';
            echo '      Tidak Ada Setting Satu Sehat Yang Aktif!';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_ihs=$_POST['id_ihs'];
            //1. Generate Token
            $Token=GenerateTokenSatuSehat($Conn);
            if(empty($Token)){
                echo '<div class="row">';
                echo '  <div class="col-md-12 text-danger text-center">';
                echo '      Terjadi Kesalahan Pada Saat Melakukan Generate Token';
                echo '  </div>';
                echo '</div>';
            }else{
                //Inisiasi BaseURL
                $baseurl_satusehat=getDataDetail($Conn,'setting_satusehat','status','Active','baseurl');
                $response=PatientById($baseurl_satusehat,$Token,$id_ihs);
                if(empty($response)){
                    echo '<div class="row">';
                    echo '  <div class="col-md-12 text-center"><span class="text-danger">Terjadi Kesalahan Konseksi Dengan Server Satu Sehat</span></div>';
                    echo '</div>';
                }else{
                    // echo "$response";
                    //json_decode
                    $json_decode =json_decode($response, true);
                    if(empty($json_decode['id'])){
                        echo '<div class="row">';
                        echo '  <div class="col-md-12 text-center"><span class="text-danger">Data Pasien Tidak Ditemukan</span></div>';
                        echo '  <div class="col-md-12 text-center"><span class="text-danger">'.$response.' '.$Token.'</span></div>';
                        echo '</div>';
                    }else{
                        if(!empty($json_decode['active'])){
                            echo '<div class="row mb-3">';
                            echo '  <div class="col-md-4"><dt>Active</dt></div>';
                            echo '  <div class="col-md-8 text-left"><small>'.$json_decode['active'].'</small></div>';
                            echo '</div>';
                        }
                        if(!empty($json_decode['id'])){
                            echo '<div class="row mb-3">';
                            echo '  <div class="col-md-4"><dt>ID IHS/Pasien</dt></div>';
                            echo '  <div class="col-md-8 text-left"><small>'.$json_decode['id'].'</small></div>';
                            echo '</div>';
                        }
                        if(!empty($json_decode['identifier'])){
                            $identifier=$json_decode['identifier'];
                            if(!empty(count($identifier))){
                                $no=1;
                                foreach($identifier as $value_identifier){
                                    $system=$value_identifier['system'];
                                    $use=$value_identifier['use'];
                                    $value=$value_identifier['value'];
                                    echo '<div class="row mb-3">';
                                    echo '  <div class="col-md-4"><dt>Identifier '.$no.'</dt></div>';
                                    echo '  <div class="col-md-8 text-left"><small>'.$system.'<br>'.$value.'('.$use.')</small></div>';
                                    echo '</div>';
                                    $no++;
                                }
                            }
                        }
                        if(!empty($json_decode['link'])){
                            $link=$json_decode['link'];
                            if(!empty(count($link))){
                                $no=1;
                                foreach($link as $ValueLink){
                                    $other=$ValueLink['other'];
                                    $reference=$other['reference'];
                                    $type=$ValueLink['type'];
                                    echo '<div class="row mb-3">';
                                    echo '  <div class="col-md-4"><dt>Link '.$no.'</dt></div>';
                                    echo '  <div class="col-md-8 text-left"><small>'.$reference.'<br>'.$type.'</small></div>';
                                    echo '</div>';
                                    $no++;
                                }
                            }
                        }
                        if(!empty($json_decode['meta'])){
                            if(!empty($json_decode['meta']['lastUpdated'])){
                                echo '<div class="row mb-3">';
                                echo '  <div class="col-md-4"><dt>Last Update</dt></div>';
                                echo '  <div class="col-md-8 text-left"><small>'.$json_decode['meta']['lastUpdated'].'</small></div>';
                                echo '</div>';
                            }
                            if(!empty($json_decode['meta']['versionId'])){
                                echo '<div class="row mb-3">';
                                echo '  <div class="col-md-4"><dt>Version ID</dt></div>';
                                echo '  <div class="col-md-8 text-left"><small>'.$json_decode['meta']['versionId'].'</small></div>';
                                echo '</div>';
                            }
                        }
                        if(!empty($json_decode['resourceType'])){
                            echo '<div class="row mb-3">';
                            echo '  <div class="col-md-4"><dt>Resource Type</dt></div>';
                            echo '  <div class="col-md-8 text-left"><small>'.$json_decode['resourceType'].'</small></div>';
                            echo '</div>';
                        }
                    }
                }
            }
        }
    }
?>