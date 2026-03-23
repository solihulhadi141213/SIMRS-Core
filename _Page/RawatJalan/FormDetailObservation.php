<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Menangkap id_observation
    if(empty($_POST['id_observation'])){
        echo '<div class="row">';
        echo '<div class="col-md-12 text-center"><span class="text-danger">ID Encounter Tidak Boleh Kosong!</span></div>';
        echo '</div>';
    }else{
        $id_observation=$_POST['id_observation'];
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
                    $response=ObservationById($baseurl_satusehat,$Token,$id_observation);
                    $json_decode =json_decode($response, true);
                    if(empty($json_decode['id'])){
                        echo '<div class="row">';
                        echo '  <div class="col-md-12 text-danger text-center">';
                        echo '      ID Observation Tidak Ditemukan';
                        echo '  </div>';
                        echo '</div>';
                    }else{
                        if(!empty($json_decode['id'])){
                            echo '<div class="row mb-3">';
                            echo '  <div class="col-md-4"><dt>ID Observation</dt></div>';
                            echo '  <div class="col-md-8 text-left"><small>'.$json_decode['id'].'</small></div>';
                            echo '</div>';
                        }
                        if(!empty($json_decode['resourceType'])){
                            echo '<div class="row mb-3">';
                            echo '  <div class="col-md-4"><dt>Resource Type</dt></div>';
                            echo '  <div class="col-md-8 text-left"><small>'.$json_decode['resourceType'].'</small></div>';
                            echo '</div>';
                        }
                        if(!empty($json_decode['meta'])){
                            echo '<div class="row mb-3">';
                            echo '  <div class="col-md-12 mb-2"><dt>Metadata</dt></div>';
                            echo '  <div class="col-md-12 text-left">';
                            if(!empty($json_decode['meta']['lastUpdated'])){
                                echo '<div class="row mb-2">';
                                echo '  <div class="col-md-4"><span>Last Update</span></div>';
                                echo '  <div class="col-md-8 text-left"><small>'.$json_decode['meta']['lastUpdated'].'</small></div>';
                                echo '</div>';
                            }
                            if(!empty($json_decode['meta']['versionId'])){
                                echo '<div class="row mb-2">';
                                echo '  <div class="col-md-4"><span>Version ID</span></div>';
                                echo '  <div class="col-md-8 text-left"><small>'.$json_decode['meta']['versionId'].'</small></div>';
                                echo '</div>';
                            }
                            echo '  </div>';
                            echo '</div>';
                        }
                        if(!empty($json_decode['subject'])){
                            echo '<div class="row mb-3">';
                            echo '  <div class="col-md-12 mb-2"><dt>Subject</dt></div>';
                            echo '  <div class="col-md-12 text-left">';
                            if(!empty($json_decode['subject']['display'])){
                                echo '<div class="row mb-2">';
                                echo '  <div class="col-md-4">Display</div>';
                                echo '  <div class="col-md-8 text-left"><small>'.$json_decode['subject']['display'].'</small></div>';
                                echo '</div>';
                            }
                            if(!empty($json_decode['subject']['reference'])){
                                echo '<div class="row mb-2">';
                                echo '  <div class="col-md-4">Referense</div>';
                                echo '  <div class="col-md-8 text-left"><small>'.$json_decode['subject']['reference'].'</small></div>';
                                echo '</div>';
                            }
                            echo '  </div>';
                            echo '</div>';
                        }
                        if(!empty($json_decode['encounter'])){
                            echo '<div class="row mb-3">';
                            echo '  <div class="col-md-12 mb-2"><dt>Encounter</dt></div>';
                            echo '  <div class="col-md-12 text-left">';
                            if(!empty($json_decode['encounter']['display'])){
                                echo '<div class="row mb-2">';
                                echo '  <div class="col-md-4">Display</div>';
                                echo '  <div class="col-md-8 text-left"><small>'.$json_decode['encounter']['display'].'</small></div>';
                                echo '</div>';
                            }
                            if(!empty($json_decode['encounter']['reference'])){
                                echo '<div class="row mb-2">';
                                echo '  <div class="col-md-4">Reference</div>';
                                echo '  <div class="col-md-8 text-left"><small>'.$json_decode['encounter']['reference'].'</small></div>';
                                echo '</div>';
                            }
                            echo '  </div>';
                            echo '</div>';
                        }
                        if(!empty($json_decode['category'])){
                            echo '<div class="row mb-3">';
                            echo '  <div class="col-md-12"><dt>Category</dt></div>';
                            echo '  <div class="col-md-12 text-left">';
                            $category=$json_decode['category'];
                            if(!empty(count($category))){
                                $no=1;
                                foreach($category as $ValueCategory){
                                    $coding=$ValueCategory['coding'];
                                    if(!empty(count($coding))){
                                        foreach($coding as $Valuecoding){
                                            $code=$Valuecoding['code'];
                                            $display=$Valuecoding['display'];
                                            $system=$Valuecoding['system'];
                                            echo '<div class="row mb-2">';
                                            echo '  <div class="col-md-4">Code</div>';
                                            echo '  <div class="col-md-8 text-left"><small>'.$code.'</small></div>';
                                            echo '</div>';
                                            echo '<div class="row mb-2">';
                                            echo '  <div class="col-md-4">Display</div>';
                                            echo '  <div class="col-md-8 text-left"><small>'.$display.'</small></div>';
                                            echo '</div>';
                                            echo '<div class="row mb-2">';
                                            echo '  <div class="col-md-4">System</div>';
                                            echo '  <div class="col-md-8 text-left"><small>'.$system.'</small></div>';
                                            echo '</div>';
                                            $no++;
                                        }
                                    }
                                }
                            }
                            echo '  </div>';
                            echo '</div>';
                        }
                        if(!empty($json_decode['clinicalStatus']['coding'])){
                            echo '<div class="row mb-3">';
                            echo '  <div class="col-md-12"><dt>Clinical Status</dt></div>';
                            echo '  <div class="col-md-12 text-left">';
                            $clinicalStatus=$json_decode['clinicalStatus']['coding'];
                            if(!empty(count($clinicalStatus))){
                                $no=1;
                                foreach($clinicalStatus as $ValueClinicalStatus){
                                    $code=$ValueClinicalStatus['code'];
                                    $display=$ValueClinicalStatus['display'];
                                    $system=$ValueClinicalStatus['system'];
                                    echo '<div class="row mb-2">';
                                    echo '  <div class="col-md-4">Code</div>';
                                    echo '  <div class="col-md-8 text-left"><small>'.$code.'</small></div>';
                                    echo '</div>';
                                    echo '<div class="row mb-2">';
                                    echo '  <div class="col-md-4">Display</div>';
                                    echo '  <div class="col-md-8 text-left"><small>'.$display.'</small></div>';
                                    echo '</div>';
                                    echo '<div class="row mb-2">';
                                    echo '  <div class="col-md-4">System</div>';
                                    echo '  <div class="col-md-8 text-left"><small>'.$system.'</small></div>';
                                    echo '</div>';
                                }
                            }
                            echo '  </div>';
                            echo '</div>';
                        }
                        if(!empty($json_decode['code']['coding'])){
                            echo '<div class="row mb-3">';
                            echo '  <div class="col-md-12"><dt>Jenis Pemeriksaan</dt></div>';
                            echo '  <div class="col-md-12 text-left">';
                            $CodeCoding=$json_decode['code']['coding'];
                            if(!empty(count($CodeCoding))){
                                $no=1;
                                foreach($CodeCoding as $ValueCodeCoding){
                                    $code=$ValueCodeCoding['code'];
                                    $display=$ValueCodeCoding['display'];
                                    $system=$ValueCodeCoding['system'];
                                    echo '<div class="row mb-2">';
                                    echo '  <div class="col-md-4">Code</div>';
                                    echo '  <div class="col-md-8 text-left"><small>'.$code.'</small></div>';
                                    echo '</div>';
                                    echo '<div class="row mb-2">';
                                    echo '  <div class="col-md-4">Display</div>';
                                    echo '  <div class="col-md-8 text-left"><small>'.$display.'</small></div>';
                                    echo '</div>';
                                    echo '<div class="row mb-2">';
                                    echo '  <div class="col-md-4">System</div>';
                                    echo '  <div class="col-md-8 text-left"><small>'.$system.'</small></div>';
                                    echo '</div>';
                                }
                            }
                            echo '  </div>';
                            echo '</div>';
                        }
                        if(!empty($json_decode['valueQuantity'])){
                            echo '<div class="row mb-3">';
                            echo '  <div class="col-md-12"><dt>Quantity</dt></div>';
                            echo '  <div class="col-md-12 text-left">';
                            $valueQuantity=$json_decode['valueQuantity'];
                            if(!empty($json_decode['valueQuantity']['code'])){
                                echo '<div class="row mb-2">';
                                echo '  <div class="col-md-4">Code</div>';
                                echo '  <div class="col-md-8 text-left"><small>'.$json_decode['valueQuantity']['code'].'</small></div>';
                                echo '</div>';
                            }
                            if(!empty($json_decode['valueQuantity']['system'])){
                                echo '<div class="row mb-2">';
                                echo '  <div class="col-md-4">System</div>';
                                echo '  <div class="col-md-8 text-left"><small>'.$json_decode['valueQuantity']['system'].'</small></div>';
                                echo '</div>';
                            }
                            if(!empty($json_decode['valueQuantity']['unit'])){
                                echo '<div class="row mb-2">';
                                echo '  <div class="col-md-4">Unit</div>';
                                echo '  <div class="col-md-8 text-left"><small>'.$json_decode['valueQuantity']['unit'].'</small></div>';
                                echo '</div>';
                            }
                            if(!empty($json_decode['valueQuantity']['value'])){
                                echo '<div class="row mb-2">';
                                echo '  <div class="col-md-4">Value</div>';
                                echo '  <div class="col-md-8 text-left"><small>'.$json_decode['valueQuantity']['value'].'</small></div>';
                                echo '</div>';
                            }
                            echo '  </div>';
                            echo '</div>';
                        }
                        if(!empty($json_decode['interpretation'])){
                            echo '<div class="row mb-3">';
                            echo '  <div class="col-md-12"><dt>Interpretation</dt></div>';
                            echo '  <div class="col-md-12 text-left">';
                            $interpretation=$json_decode['interpretation'];
                            foreach($interpretation as $Valueinterpretation){
                                if(!empty($Valueinterpretation['coding'])){
                                    $interpretationcoding=$Valueinterpretation['coding'];
                                    foreach($interpretationcoding as $ValueinterpretationCoding){
                                        if(!empty($ValueinterpretationCoding['code'])){
                                            echo '<div class="row mb-2">';
                                            echo '  <div class="col-md-4">Code</div>';
                                            echo '  <div class="col-md-8 text-left"><small>'.$ValueinterpretationCoding['code'].'</small></div>';
                                            echo '</div>';
                                        }
                                        if(!empty($ValueinterpretationCoding['display'])){
                                            echo '<div class="row mb-2">';
                                            echo '  <div class="col-md-4">Display</div>';
                                            echo '  <div class="col-md-8 text-left"><small>'.$ValueinterpretationCoding['display'].'</small></div>';
                                            echo '</div>';
                                        }
                                        if(!empty($ValueinterpretationCoding['system'])){
                                            echo '<div class="row mb-2">';
                                            echo '  <div class="col-md-4">System</div>';
                                            echo '  <div class="col-md-8 text-left"><small>'.$ValueinterpretationCoding['system'].'</small></div>';
                                            echo '</div>';
                                        }
                                    }
                                }
                            }
                            echo '  </div>';
                            echo '</div>';
                        }
                        if(!empty($json_decode['valueCodeableConcept']['coding'])){
                            echo '<div class="row mb-3">';
                            echo '  <div class="col-md-12"><dt>Value Codeable Concept</dt></div>';
                            echo '  <div class="col-md-12 text-left">';
                            $valueCodeableConcept=$json_decode['valueCodeableConcept']['coding'];
                            foreach($valueCodeableConcept as $valueCodeableConcept2){
                                if(!empty($valueCodeableConcept2['code'])){
                                    echo '<div class="row mb-2">';
                                    echo '  <div class="col-md-4">Code</div>';
                                    echo '  <div class="col-md-8 text-left"><small>'.$valueCodeableConcept2['code'].'</small></div>';
                                    echo '</div>';
                                }
                                if(!empty($valueCodeableConcept2['display'])){
                                    echo '<div class="row mb-2">';
                                    echo '  <div class="col-md-4">Display</div>';
                                    echo '  <div class="col-md-8 text-left"><small>'.$valueCodeableConcept2['display'].'</small></div>';
                                    echo '</div>';
                                }
                                if(!empty($valueCodeableConcept2['system'])){
                                    echo '<div class="row mb-2">';
                                    echo '  <div class="col-md-4">System</div>';
                                    echo '  <div class="col-md-8 text-left"><small>'.$valueCodeableConcept2['system'].'</small></div>';
                                    echo '</div>';
                                }
                            }
                            echo '  </div>';
                            echo '</div>';
                        }
                    }
                }
            }
        }
    }
?>