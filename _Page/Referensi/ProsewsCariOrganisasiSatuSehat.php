<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $now=date('Y-m-d H:i:s');
    if(empty($_POST['KywordOrganization'])){
        echo '<span class="text-danger">Kata Kunci Tidak Boleh Kosong!</span>';
    }else{
        $KywordOrganization=$_POST['KywordOrganization'];
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
                //Pencarian Berdasarkan Nama Dan Part OF
                $response=organizationSearchBy($baseurl_satusehat,$Token,$SearchBy,$KywordOrganization);
                $JsonData =json_decode($response, true);
                if(empty($JsonData['entry'])){
                    echo '<span class="text-danger">Hasil Pencarian Tidak Ditemukan!</span>';
                }else{
                    if(empty($JsonData['total'])){
                        echo '<span class="text-danger">Hasil Pencarian Tidak Ditemukan!</span>';
                    }else{
                        if(empty($JsonData['entry'])){
                            echo '<span class="text-danger">Hasil Pencarian Tidak Ditemukan!</span>';
                        }else{
                            $entry=$JsonData['entry'];
                            $link=$JsonData['link'];
                            $resourceType=$JsonData['resourceType'];
                            $total=$JsonData['total'];
                            $type=$JsonData['type'];
                            $JumlahEntry=count($entry);
                            $JumlahLink=count($link);
                            echo '<div class="row mb-3">';
                            echo '  <div class="col-md-4"><dt>Resource Type</dt></div>';
                            echo '  <div class="col-md-8"><small>'.$resourceType.'</small></div>';
                            echo '</div>';
                            echo '<div class="row mb-3">';
                            echo '  <div class="col-md-4"><dt>Total</dt></div>';
                            echo '  <div class="col-md-8"><small>'.$total.'</small></div>';
                            echo '</div>';
                            echo '<div class="row mb-3">';
                            echo '  <div class="col-md-4"><dt>Type</dt></div>';
                            echo '  <div class="col-md-8"><small>'.$type.'</small></div>';
                            echo '</div>';
                            if(!empty($JumlahEntry)){
                                foreach($entry as $value_entry){
                                    $fullUrl=$value_entry['fullUrl'];
                                    $resource=$value_entry['resource'];
                                    $active=$resource['active'];
                                    $id=$resource['id'];
                                    $identifier=$resource['identifier'];
                                    $lastUpdated=$resource['meta']['lastUpdated'];
                                    $versionId=$resource['meta']['versionId'];
                                    $name=$resource['name'];
                                    $resourceType=$resource['resourceType'];
                                    if(empty($resource['telecom'])){
                                        $telecom="";
                                    }else{
                                        $telecom=$resource['telecom'];
                                    }
                                    if(empty($resource['type'])){
                                        $type="";
                                    }else{
                                        $type=$resource['type'];
                                    }
                                    echo '<div class="row">';
                                    echo '  <div class="col-md-12">';
                                    echo '      <div class="card">';
                                    echo '          <div class="card-header">';
                                    echo '              <dt>';
                                    echo '                  <a href="javascript:void(0);" class="text-success"  data-toggle="modal" data-target="#ModalDetailOrgId" data-id="'.$id.'" title="Lihat Data ID Di Satu Sehat">';
                                    echo '                      '.$name.' <i class="ti-new-window"></i>';
                                    echo '                  </a>';
                                    echo '              </dt>';
                                    echo '              <small>'.$id.'</small><br>';
                                    echo '              <small>'.$lastUpdated.'</small><br>';
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