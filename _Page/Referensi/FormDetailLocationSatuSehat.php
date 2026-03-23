<?php
    ini_set("display_errors","off");
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap ID Location
    if(empty($_POST['id_location'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-danger text-center">';
        echo '      ID Location Tidak Boleh Kosong!';
        echo '  </div>';
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
            $id_location=$_POST['id_location'];
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
                $response=locationById($baseurl_satusehat,$Token,$id_location);
                $JsonData =json_decode($response, true);
                if(empty($JsonData['id'])){
                    echo $response;
                }else{
                    $address=$JsonData['address'];
                        $address_city=$address['city'];
                        $address_country=$address['country'];
                        $address_line=$address['line']['0'];
                        $address_postalCode=$address['postalCode'];
                        $address_use=$address['use'];
                    $description=$JsonData['description'];
                    $id=$JsonData['id'];
                    $identifier=$JsonData['identifier'];
                    $identifier_system=$identifier['0']['system'];
                    $identifier_value=$identifier['0']['value'];
                    $managingOrganization=$JsonData['managingOrganization'];
                        $managingOrganization_reference=$managingOrganization['reference'];
                    $meta=$JsonData['meta'];
                        $meta_lastUpdated=$meta['lastUpdated'];
                        $meta_versionId=$meta['versionId'];
                    $mode=$JsonData['mode'];
                    $name=$JsonData['name'];
                    $physicalType=$JsonData['physicalType'];
                    $physicalType_coding=$physicalType['coding'];
                    $resourceType=$JsonData['resourceType'];
                    $status=$JsonData['status'];
                    $telecom=$JsonData['telecom'];
                    //Format Last Update
                    $strtotime=strtotime($meta_lastUpdated);
                    $lastUpdated=date('d/m/Y H:i:s',$strtotime);
                    //Menampilklan Data
                    if(!empty($JsonData['id'])){
                        echo '<div class="row mb-3">';
                        echo '  <div class="col-md-4"><dt>ID Location</dt></div>';
                        echo '  <div class="col-md-8 text-left"><small>'.$id.'</small></div>';
                        echo '</div>';
                    }
                    if(!empty($JsonData['status'])){
                        echo '<div class="row mb-3">';
                        echo '  <div class="col-md-4"><dt>Status</dt></div>';
                        echo '  <div class="col-md-8 text-left"><small>'.$JsonData['status'].'</small></div>';
                        echo '</div>';
                    }
                    if(!empty($JsonData['name'])){
                        echo '<div class="row mb-3">';
                        echo '  <div class="col-md-4"><dt>Name</dt></div>';
                        echo '  <div class="col-md-8 text-left"><small>'.$name.'</small></div>';
                        echo '</div>';
                    }
                    if(!empty($JsonData['description'])){
                        echo '<div class="row mb-3">';
                        echo '  <div class="col-md-4"><dt>Deskripsi</dt></div>';
                        echo '  <div class="col-md-8 text-left"><small>'.$description.'</small></div>';
                        echo '</div>';
                    }
                    if(!empty($address_city)){
                        echo '<div class="row mb-3">';
                        echo '  <div class="col-md-4"><dt>Address</dt></div>';
                        echo '  <div class="col-md-8 text-left"><small>City: '.$address_city.'</small></div>';
                        echo '</div>';
                    }
                    if(!empty($address_country)){
                        echo '<div class="row mb-3">';
                        echo '  <div class="col-md-4"><dt></dt></div>';
                        echo '  <div class="col-md-8 text-left"><small>Country:'.$address_country.'</small></div>';
                        echo '</div>';
                    }
                    if(!empty($address_line)){
                        echo '<div class="row mb-3">';
                        echo '  <div class="col-md-4"><dt></dt></div>';
                        echo '  <div class="col-md-8 text-left"><small>Line:'.$address_line.'</small></div>';
                        echo '</div>';
                    }
                    if(!empty($address_postalCode)){
                        echo '<div class="row mb-3">';
                        echo '  <div class="col-md-4"><dt></dt></div>';
                        echo '  <div class="col-md-8 text-left"><small>Postal Code: '.$address_postalCode.'</small></div>';
                        echo '</div>';
                    }
                    if(!empty($address_use)){
                        echo '<div class="row mb-3">';
                        echo '  <div class="col-md-4"><dt>Use</dt></div>';
                        echo '  <div class="col-md-8 text-left"><small>'.$address_use.'</small></div>';
                        echo '</div>';
                    }
                    if(!empty($identifier_system)){
                        echo '<div class="row mb-3">';
                        echo '  <div class="col-md-4"><dt>Identifier</dt></div>';
                        echo '  <div class="col-md-8 text-left"><small>System: '.$identifier_system.'</small></div>';
                        echo '</div>';
                    }
                    if(!empty($managingOrganization_reference)){
                        echo '<div class="row mb-3">';
                        echo '  <div class="col-md-4"><dt>Organization</dt></div>';
                        echo '  <div class="col-md-8 text-left"><small>'.$managingOrganization_reference.'</small></div>';
                        echo '</div>';
                    }
                    if(!empty($meta_lastUpdated)){
                        echo '<div class="row mb-3">';
                        echo '  <div class="col-md-4"><dt>Lastupdate</dt></div>';
                        echo '  <div class="col-md-8 text-left"><small>'.$meta_lastUpdated.'</small></div>';
                        echo '</div>';
                    }
                    if(!empty($meta_versionId)){
                        echo '<div class="row mb-3">';
                        echo '  <div class="col-md-4"><dt>Version ID</dt></div>';
                        echo '  <div class="col-md-8 text-left"><small>'.$meta_versionId.'</small></div>';
                        echo '</div>';
                    }
                    if(!empty($mode)){
                        echo '<div class="row mb-3">';
                        echo '  <div class="col-md-4"><dt>Mode</dt></div>';
                        echo '  <div class="col-md-8 text-left"><small>'.$mode.'</small></div>';
                        echo '</div>';
                    }
                    $JumlahphysicalType=count($physicalType_coding);
                    if(!empty($JumlahphysicalType)){
                        foreach($physicalType_coding as $value_physicalType){
                            $physicalType_coding_code=$value_physicalType['code'];
                            $physicalType_coding_display=$value_physicalType['display'];
                            $physicalType_coding_system=$value_physicalType['system'];
                            echo '<div class="row mb-3">';
                            echo '  <div class="col-md-4"><dt>Physical Type</dt></div>';
                            echo '  <div class="col-md-8 text-left"><small>'.$physicalType_coding_display.' ('.$physicalType_coding_code.')</small></div>';
                            echo '</div>';
                        }
                    }
                    $JumlahTelcom=count($telecom);
                    if(!empty($JumlahTelcom)){
                        echo '<div class="row mb-3">';
                        echo '  <div class="col-md-4"><dt>Telcom</dt></div>';
                        echo '  <div class="col-md-8 text-left">';
                            foreach($telecom as $value_telecom){
                                $telcom_system=$value_telecom['system'];
                                $telcom_use=$value_telecom['use'];
                                $telcom_value=$value_telecom['value'];
                                echo '<small>'.$telcom_system.': '.$telcom_value.' ('.$telcom_use.')</small><br>';
                            }
                        echo '  </div>';
                        echo '</div>';
                    }
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-4"><dt>RAW</dt></div>';
                    echo '  <div class="col-md-12 text-left">';
                    echo '      <textarea class="form-control">'.$response.'</textarea>';
                    echo '  </div>';
                    echo '</div>';
                }
            }
        }
    }
?>