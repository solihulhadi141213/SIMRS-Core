<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
                <?php
                    if(empty($_GET['id'])){
                        echo '<div class="row mb-3">';
                        echo '  <div class="col-md-12">';
                        echo '      <div class="card">';
                        echo '          <div class="card-body text-danger">';
                        echo '              ID Organisasi Tidak Boleh Kosong!';
                        echo '          </div>';
                        echo '      </div>';
                        echo '  </div>';
                        echo '</div>';
                    }else{
                        //Setting Koneksi
                        $SettingSatuSehat=getDataDetail($Conn,' setting_satusehat','status','Active','id_setting_satusehat');
                        if(empty($SettingSatuSehat)){
                            echo '<div class="row mb-3">';
                            echo '  <div class="col-md-12">';
                            echo '      <div class="card">';
                            echo '          <div class="card-body text-danger">';
                            echo '              Tidak Ada Setting Satu Sehat Yang Aktif!';
                            echo '          </div>';
                            echo '      </div>';
                            echo '  </div>';
                            echo '</div>';
                        }else{
                            //Buka Detail Organisasi
                            $ID_Org=$_GET['id'];
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
                                    
                                    if(!empty($JsonData['telecom'])){
                                        $telecom=$JsonData['telecom'];
                                        $JumlahTelcom=count($telecom);
                                    }else{
                                        $telecom="";
                                        $JumlahTelcom=0;
                                    }
                                    if(!empty($JsonData['type'])){
                                        $type=$JsonData['type'];
                                        $JumlahType=count($type);
                                    }else{
                                        $type="";
                                        $JumlahType=0;
                                    }
                                    if(!empty($JsonData['identifier'])){
                                        $identifier=$JsonData['identifier'];
                                        $JumlahIdentifier=count($identifier);
                                    }else{
                                        $identifier="";
                                        $JumlahIdentifier=0;
                                    }
                                    //Format Last Update
                                    $strtotime=strtotime($lastUpdated);
                                    $lastUpdated=date('d/m/Y H:i:s',$strtotime);
                ?>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-12 mb-2">
                                            <h4><i class="ti ti-info-alt"></i> Detail Organisasi Satu Sehat</h4>
                                            Berikut ini adalah informasi detail organisasi yang diambil dari service Satu Sehat
                                        </div>
                                        <div class="col-md-12">
                                            <a href="index.php?Page=Referensi&Sub=Organization" class="btn btn-sm btn-secondary btn-block">
                                                <i class="ti ti-angle-left"></i> Kembali
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body bg-light">
                                    <?php 
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
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-12 mb-2">
                                            <h4><i class="ti ti-align-left"></i> Sub Organisasi Satu Sehat</h4>
                                            Apabila Ditemukan Sub Organisasi Dari Data Satu Sehat Maka Akan Ditampilkan Disini
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body bg-light">
                                    <?php
                                        $ResponsePartof=organizationSearchBy($baseurl_satusehat,$Token,'partof',$ID_Org);
                                        $JsonDataPartOf =json_decode($ResponsePartof, true);
                                        if(empty($JsonDataPartOf['entry'])){
                                            echo '<span class="text-danger">Hasil Pencarian Tidak Ditemukan!</span>';
                                        }else{
                                            if(empty($JsonDataPartOf['total'])){
                                                echo '<span class="text-danger">Hasil Pencarian Tidak Ditemukan!</span>';
                                            }else{
                                                if(empty($JsonDataPartOf['entry'])){
                                                    echo '<span class="text-danger">Hasil Pencarian Tidak Ditemukan!</span>';
                                                }else{
                                                    $entry=$JsonDataPartOf['entry'];
                                                    $link=$JsonDataPartOf['link'];
                                                    $resourceType=$JsonDataPartOf['resourceType'];
                                                    $total=$JsonDataPartOf['total'];
                                                    $type=$JsonDataPartOf['type'];
                                                    $JumlahEntry=count($entry);
                                                    $JumlahLink=count($link);
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
                                    ?>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-12 mb-2">
                                            <h4><i class="ti ti-map-alt"></i> Location</h4>
                                            Apabila Di Dalam Organization Terhubung Dengan Location Maka Akan Ditampilkan Di Sini
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body bg-light">
                                    <?php
                                        $ResponseOrganizationLocation=organizationLocation($baseurl_satusehat,$Token,$ID_Org);
                                        if(empty($ResponseOrganizationLocation)){
                                            echo '<span class="text-danger">Tidak Ada Koneksi Satu Sehat</span>';
                                            echo '<span class="text-danger">'.$ResponseOrganizationLocation.'</span>';
                                        }else{
                                            $JsonDataOrganizationLocation =json_decode($ResponseOrganizationLocation, true);
                                            if(empty($JsonDataOrganizationLocation['entry'])){
                                                echo '<span class="text-danger">Tidak Ada Data Entry Location</span>';
                                            }else{
                                                if(empty($JsonDataOrganizationLocation['total'])){
                                                    echo '<span class="text-danger">Hasil Pencarian Tidak Ditemukan!</span>';
                                                }else{
                                                    $entry=$JsonDataOrganizationLocation['entry'];
                                                    $JumlahEntry=count($entry);
                                                    if(!empty($JumlahEntry)){
                                                        foreach($entry as $value_entry){
                                                            $fullUrl=$value_entry['fullUrl'];
                                                            $resource=$value_entry['resource'];
                                                            $description=$resource['description'];
                                                            $name=$resource['name'];
                                                            $id=$resource['id'];
                                                            echo '<div class="row">';
                                                            echo '  <div class="col-md-12">';
                                                            echo '      <div class="card">';
                                                            echo '          <div class="card-header">';
                                                            echo '              <dt>';
                                                            echo '                  <a href="javascript:void(0);" class="text-success"  data-toggle="modal" data-target="#ModalDetailLocationSatuSehat" data-id="'.$id.'" title="Lihat Detail Location Di Satu Sehat">';
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
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php }}}} ?>
            </div>
        </div>
    </div>
</div>