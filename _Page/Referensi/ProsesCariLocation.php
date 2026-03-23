<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $now=date('Y-m-d H:i:s');
    if(empty($_POST['KeywordLocation'])){
        echo '<span class="text-danger">Kata Kunci Tidak Boleh Kosong!</span>';
    }else{
        $KeywordLocation=$_POST['KeywordLocation'];
        //Inisiasi Setting
        $SettingSatuSehat=getDataDetail($Conn,' setting_satusehat','status','Active','id_setting_satusehat');
        if(empty($SettingSatuSehat)){
            echo '<span class="text-danger">Tidak Ada Setting Satu Sehat Yang Aktif!</span>';
        }else{
            $Token=GenerateTokenSatuSehat($Conn);
            if(empty($Token)){
                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Melakukan Generate Token!</span>';
            }else{
                //Inisiasi BaseURL
                $baseurl_satusehat=getDataDetail($Conn,'setting_satusehat','status','Active','baseurl');
                $SearchBy="name";
                //Pencarian Berdasarkan Nama
                $response=locationSearchByName($baseurl_satusehat,$Token,$KeywordLocation);
                $JsonData =json_decode($response, true);
                if(empty($JsonData['entry'])){
                    echo '<span class="text-danger">Hasil Pencarian Tidak Ditemukan.</span>';
                    echo '<textarea class="form-control">'.$response.'</textarea>';
                }else{
                    if(empty($JsonData['total'])){
                        echo '<span class="text-danger">Hasil Pencarian Tidak Ditemukan!</span>';
                    }else{
                        if(empty($JsonData['entry'])){
                            echo '<span class="text-danger">Hasil Pencarian Tidak Ditemukan!</span>';
                        }else{
                            $entry=$JsonData['entry'];
                            $JumlahEntry=count($entry);
                            if(!empty($JumlahEntry)){
                                if(!empty($JsonData['resourceType'])){
                                    $resourceType=$JsonData['resourceType'];
                                    echo '<div class="row mb-3">';
                                    echo '  <div class="col-md-4"><dt>Resource Type</dt></div>';
                                    echo '  <div class="col-md-8"><small>'.$resourceType.'</small></div>';
                                    echo '</div>';
                                }
                                if(!empty($JsonData['total'])){
                                    $total=$JsonData['total'];
                                    echo '<div class="row mb-3">';
                                    echo '  <div class="col-md-4"><dt>Total</dt></div>';
                                    echo '  <div class="col-md-8"><small>'.$total.'</small></div>';
                                    echo '</div>';
                                }
                                if(!empty($JsonData['type'])){
                                    $type=$JsonData['type'];
                                    echo '<div class="row mb-3">';
                                    echo '  <div class="col-md-4"><dt>Type</dt></div>';
                                    echo '  <div class="col-md-8"><small>'.$type.'</small></div>';
                                    echo '</div>';
                                }
                                foreach($entry as $value_entry){
                                    $fullUrl=$value_entry['fullUrl'];
                                    $resource=$value_entry['resource'];
                                    if(empty($resource['id'])){
                                        $id="";
                                    }else{
                                        $id=$resource['id'];
                                    }
                                    if(empty($resource['description'])){
                                        $description="";
                                    }else{
                                        $description=$resource['description'];
                                    }
                                    if(empty($resource['name'])){
                                        $name="";
                                    }else{
                                        $name=$resource['name'];
                                    }
                                    echo '<div class="row">';
                                    echo '  <div class="col-md-12">';
                                    echo '      <div class="card">';
                                    echo '          <div class="card-header">';
                                    echo '              <dt>';
                                    echo '                  <a href="javascript:void(0);" class="text-success"  data-toggle="modal" data-target="#ModalDetailLocationSatuSehat" data-id="'.$id.'" title="Lihat Data ID Di Satu Sehat">';
                                    echo '                      '.$name.' <i class="ti-new-window"></i>';
                                    echo '                  </a>';
                                    echo '              </dt>';
                                    echo '              <small>'.$id.'</small><br>';
                                    echo '              <small>'.$description.'</small><br>';
                                    echo '          </div>';
                                    echo '      </div>';
                                    echo '  </div>';
                                    echo '</div>';
                                }
                            }
                        }
                    }
                }
            }
        }
    }
?>