<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap ID Organisasi
    if(empty($_POST['ID_Org'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-danger text-center">';
        echo '      ID Organisasi Tidak Boleh Kosong!';
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
            $ID_Org=$_POST['ID_Org'];
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
                $response=organizationById($baseurl_satusehat,$Token,$ID_Org);
                $JsonData =json_decode($response, true);
                if(empty($JsonData['id'])){
                    echo $response;
                }else{
                    $id=$JsonData['id'];
                    $active=$JsonData['active'];
                    $lastUpdated=$JsonData['meta']['lastUpdated'];
                    $versionId=$JsonData['meta']['versionId'];
                    $name=$JsonData['name'];
                    $resourceType=$JsonData['resourceType'];
                    if(!empty($JsonData['type'])){
                        $type=$JsonData['type'];
                        $JumlahType=count($type);
                    }else{
                        $type="";
                        $JumlahType=0;
                    }
                    if(!empty($JsonData['telecom'])){
                        $telecom=$JsonData['telecom'];
                        $JumlahTelcom=count($telecom);
                    }else{
                        $telecom="";
                        $JumlahTelcom=0;
                    }
                    $identifier=$JsonData['identifier'];
                    $JumlahIdentifier=count($identifier);
                    
                    
                    //Format Last Update
                    $strtotime=strtotime($lastUpdated);
                    $lastUpdated=date('d/m/Y H:i:s',$strtotime);
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-4"><dt>ID ORganization</dt></div>';
                    echo '  <div class="col-md-8 text-right"><small>'.$id.'</small></div>';
                    echo '</div>';
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-4"><dt>Active</dt></div>';
                    echo '  <div class="col-md-8 text-right"><small>'.$active.'</small></div>';
                    echo '</div>';
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-4"><dt>LastUpdated</dt></div>';
                    echo '  <div class="col-md-8 text-right"><small>'.$lastUpdated.'</small></div>';
                    echo '</div>';
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-4"><dt>Version ID</dt></div>';
                    echo '  <div class="col-md-8 text-right"><small>'.$versionId.'</small></div>';
                    echo '</div>';
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-4"><dt>Name</dt></div>';
                    echo '  <div class="col-md-8 text-right"><small>'.$name.'</small></div>';
                    echo '</div>';
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-4"><dt>Resource Type</dt></div>';
                    echo '  <div class="col-md-8 text-right"><small>'.$resourceType.'</small></div>';
                    echo '</div>';
                    if(!empty($JumlahIdentifier)){
                        foreach($identifier as $value_identifier){
                            if(!empty($value_identifier['use'])){
                                $identifier_use=$value_identifier['use'];
                            }else{
                                $identifier_use="";
                            }
                            if(!empty($value_identifier['value'])){
                                $identifier_value=$value_identifier['value'];
                            }else{
                                $identifier_value="";
                            }
                            echo '<div class="row mb-3">';
                            echo '  <div class="col-md-4"><dt>'.$identifier_use.'</dt></div>';
                            echo '  <div class="col-md-8 text-right"><small>'.$identifier_value.'</small></div>';
                            echo '</div>';
                        }
                    }
                    if(!empty($JumlahTelcom)){
                        foreach($telecom as $value_telecom){
                            $telcom_system=$value_telecom['system'];
                            $telcom_use=$value_telecom['use'];
                            $telcom_value=$value_telecom['value'];
                            echo '<div class="row mb-3">';
                            echo '  <div class="col-md-4"><dt>'.$telcom_system.'</dt></div>';
                            echo '  <div class="col-md-8 text-right"><small>'.$telcom_value.' ('.$telcom_use.')</small></div>';
                            echo '</div>';
                        }
                    }
                    if(!empty($type)){
                        $code = $type[0]["coding"][0]["code"];
                        $display = $type[0]["coding"][0]["display"];
                        $system = $type[0]["coding"][0]["system"];
                        echo '<div class="row mb-3">';
                        echo '  <div class="col-md-4"><dt>Type Coding</dt></div>';
                        echo '  <div class="col-md-8 text-right"><small>'.$display.' ('.$code.')</small></div>';
                        echo '</div>';
                        echo '<div class="row mb-3">';
                        echo '  <div class="col-md-4"><dt>System</dt></div>';
                        echo '  <div class="col-md-8 text-right"><small>'.$system.'</small></div>';
                        echo '</div>';
                    }
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-12">';
                    echo '      <a href="index.php?Page=Referensi&Sub=DetailOrganizationSatuSehat&id='.$ID_Org.'" class="btn btn-sm btn-outline-dark btn-block"><i class="ti ti-more"></i> Selengkapnya</a>';
                    echo '  </div>';
                    echo '</div>';
                }
            }
        }
    }
?>