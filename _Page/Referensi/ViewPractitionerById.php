<?php
    ini_set("display_errors","off");
    if(!empty($JsonData['resourceType'])){
        echo '<div class="row mb-3">';
        echo '  <div class="col col-md-4"><dt>Resource Type</dt></div>';
        echo '  <div class="col col-md-8 text-left"><span>'.$JsonData['resourceType'].'</span></div>';
        echo '</div>';
    }
    if(!empty($JsonData['id'])){
        echo '<div class="row mb-3">';
        echo '  <div class="col col-md-4"><dt>ID</dt></div>';
        echo '  <div class="col col-md-8 text-left"><span>'.$JsonData['id'].'</span></div>';
        echo '</div>';
    }
    if(!empty($JsonData['name'])){
        echo '<div class="row mb-3">';
        echo '  <div class="col col-md-4"><dt>Nama</dt></div>';
        $name=$JsonData['name'];
        echo '  <div class="col col-md-8 text-left">';
        if(!empty(count($name))){
            echo '<ul>';
            foreach($name as $value_entry){  
                echo '<li>';
                if(!empty($value_entry['text'])){
                    echo ''.$value_entry['text'].'';
                }
                if(!empty($value_entry['use'])){
                    echo '('.$value_entry['use'].')';
                }
                echo '</li>';
            }
            echo '</ul>';
        }else{
            echo 'Tidak Ada';
        }
        echo '  </div>';
        echo '</div>';
    }
    if(!empty($JsonData['birthDate'])){
        echo '<div class="row mb-3">';
        echo '  <div class="col col-md-4"><dt>Birth Date</dt></div>';
        echo '  <div class="col col-md-8 text-left"><span>'.$JsonData['birthDate'].'</span></div>';
        echo '</div>';
    }
    if(!empty($JsonData['gender'])){
        echo '<div class="row mb-3">';
        echo '  <div class="col col-md-4"><dt>Gender</dt></div>';
        echo '  <div class="col col-md-8 text-left"><span>'.$JsonData['gender'].'</span></div>';
        echo '</div>';
    }
    if(!empty($JsonData['meta'])){
        echo '<div class="row mb-3">';
        echo '  <div class="col-md-12"><dt>Meta</dt></div>';
        echo '  <div class="col-md-12 text-left">';
        if(!empty($JsonData['meta']['lastUpdated'])){
            $lastUpdated=$JsonData['meta']['lastUpdated'];
            $strtotime=strtotime($lastUpdated);
            $lastUpdated=date('d/m/Y H:i:s',$strtotime);
            echo '<div class="row">';
            echo '  <div class="col col-md-4">Last Update</div>';
            echo '  <div class="col col-md-8"><small>'.$lastUpdated.'</small></div>';
            echo '</div>';
        }
        if(!empty($JsonData['meta']['versionId'])){
            $versionId=$JsonData['meta']['versionId'];
            echo '<div class="row">';
            echo '  <div class="col col-md-4">Version ID</div>';
            echo '  <div class="col col-md-8"><small>'.$versionId.'</small></div>';
            echo '</div>';
        }
        echo '  </div>';
        echo '</div>';
    }
    
    
    
    if(!empty($JsonData['address'])){
        $address=$JsonData['address'];
        $Jumlahaddress=count($address);
        if(!empty($Jumlahaddress)){
            foreach($address as $value_entry){
                $city=$value_entry['city'];
                $country=$value_entry['country'];
                
                $postalCode=$value_entry['postalCode'];
                $alamat_use=$value_entry['use'];
                echo '<div class="row mb-3">';
                echo '  <div class="col-md-4"><dt>Alamat</dt></div>';
                echo '  <div class="col-md-8 text-left"><small>'.$city.' ('.$country.')</small></div>';
                echo '</div>';
                if(!empty($value_entry['line'])){
                    $line=$value_entry['line'];
                    foreach($line as $value_line){
                        echo '<div class="row mb-3">';
                        echo '  <div class="col-md-4"><dt></dt></div>';
                        echo '  <div class="col-md-8 text-left"><small>Line: '.$value_line.'</small></div>';
                        echo '</div>';
                    }
                }
                echo '<div class="row mb-3">';
                echo '  <div class="col-md-4"><dt></dt></div>';
                echo '  <div class="col-md-8 text-left"><small>Postal Code: '.$postalCode.'</small></div>';
                echo '</div>';
                echo '<div class="row mb-3">';
                echo '  <div class="col-md-4"><dt></dt></div>';
                echo '  <div class="col-md-8 text-left"><small>Use: '.$alamat_use.'</small></div>';
                echo '</div>';
                if(!empty($value_entry['extension'])){
                    $extension=$value_entry['extension'];
                    foreach($extension as $value_extension){
                        if(!empty($value_extension['extension'])){
                            $extension2=$value_extension['extension'];
                            foreach($extension2 as $value_extension2){
                                $extension2_url=$value_extension2['url'];
                                $extension2_valueCode=$value_extension2['valueCode'];
                                echo '<div class="row mb-3">';
                                echo '  <div class="col-md-4"><dt></dt></div>';
                                echo '  <div class="col-md-8 text-left"><small>'.$extension2_url.' : '.$extension2_valueCode.'</small></div>';
                                echo '</div>';
                            }
                        }
                        if(!empty($value_extension['url'])){
                            $url=$value_extension['url'];
                            echo '<div class="row mb-3">';
                            echo '  <div class="col-md-4"><dt></dt></div>';
                            echo '  <div class="col-md-8 text-left"><small>URL: '.$url.'</small></div>';
                            echo '</div>';
                        }
                    }

                }
                
            }
        }
    }
    if(!empty($JsonData['identifier'])){
        $identifier=$JsonData['identifier'];
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
            if(!empty($value_identifier['system'])){
                $identifier_system=$value_identifier['system'];
                if($identifier_system=="https://fhir.kemkes.go.id/id/nakes-his-number"){
                    $IdentifyName="HIS";
                }else{
                    if($identifier_system=="https://fhir.kemkes.go.id/id/nik"){
                        $IdentifyName="NIK";
                    }else{
                        $IdentifyName="None";
                    }
                }
            }else{
                $identifier_system="";
                $IdentifyName="None";
            }
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-4"><dt>'.$IdentifyName.'</dt></div>';
            echo '  <div class="col-md-8 text-left"><small>'.$identifier_value.' ('.$identifier_use.')</small></div>';
            echo '</div>';
        }
    }
    if(!empty($JsonData['telecom'])){
        $telecom=$JsonData['telecom'];
        foreach($telecom as $value_telecom){
            $telcom_system=$value_telecom['system'];
            $telcom_use=$value_telecom['use'];
            $telcom_value=$value_telecom['value'];
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-4"><dt>'.$telcom_system.' ('.$telcom_use.')</dt></div>';
            echo '  <div class="col-md-8 text-left"><small>'.$telcom_value.'</small></div>';
            echo '</div>';
        }
    }
    if(!empty(count($JsonData['qualification']))){
        echo '<div class="row mb-3">';
        echo '  <div class="col-md-4"><dt>Qualification</dt></div>';
        echo '  <div class="col-md-8 text-left">';
        $qualification=$JsonData['qualification'];
        $no=1;
        foreach($qualification as $value_qualification){
            if(!empty($value_qualification['issuer'])){
                if(!empty($value_qualification['issuer']['display'])){
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-12 text-left">';
                    echo '      <small>'.$no.'. '.$value_qualification['issuer']['display'].'</small>';
                    echo '  </div>';
                    if(!empty($value_qualification['issuer']['reference'])){
                        echo '<div class="col-md-12 text-left">';
                        echo '  <div class="row">';
                        echo '      <div class="col-md-4 text-left"><small>ID Organization</small></div>';
                        echo '      <div class="col-md-8 text-left"><small>'.$value_qualification['issuer']['reference'].'</small></div>';
                        echo '  </div>';
                        echo '</div>';
                    }
                    if(!empty($value_qualification['period']['start'])){
                        echo '<div class="col-md-12 text-left">';
                        echo '  <div class="row">';
                        echo '      <div class="col-md-4 text-left"><small>Period Start</small></div>';
                        echo '      <div class="col-md-8 text-left"><small>'.$value_qualification['period']['start'].'</small></div>';
                        echo '  </div>';
                        echo '</div>';
                    }
                    if(!empty($value_qualification['period']['end'])){
                        echo '<div class="col-md-12 text-left">';
                        echo '  <div class="row">';
                        echo '      <div class="col-md-4 text-left"><small>Period End</small></div>';
                        echo '      <div class="col-md-8 text-left"><small>'.$value_qualification['period']['end'].'</small></div>';
                        echo '  </div>';
                        echo '</div>';
                    }
                    echo '</div>';
                }
                
            }
            $no++;
        }
        echo '  </div>';
        echo '</div>';
    }
?>