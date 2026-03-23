<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Menangkap resourceId
    if(empty($_POST['resourceId'])){
        echo '<div class="row">';
        echo '<div class="col-md-12 text-center"><span class="text-danger">ID Composition Tidak Boleh Kosong!</span></div>';
        echo '</div>';
    }else{
        $resourceId=$_POST['resourceId'];
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
                    $response=ProcedureById($baseurl_satusehat,$Token,$resourceId);
                    $json_decode =json_decode($response, true);
                    if(empty($json_decode['id'])){
                        echo '<div class="row">';
                        echo '  <div class="col-md-12 text-danger text-center">';
                        echo '      ID Procedure Tidak Ditemukan';
                        echo '  </div>';
                        echo '</div>';
                    }else{
                        if(!empty($json_decode['id'])){
                            echo '<div class="row mb-3">';
                            echo '  <div class="col-md-4"><dt>ID Procedure</dt></div>';
                            echo '  <div class="col-md-8 text-left"><small>'.$json_decode['id'].'</small></div>';
                            echo '</div>';
                        }
                        if(!empty($json_decode['resourceType'])){
                            echo '<div class="row mb-3">';
                            echo '  <div class="col-md-4"><dt>Resource Type</dt></div>';
                            echo '  <div class="col-md-8 text-left"><small>'.$json_decode['resourceType'].'</small></div>';
                            echo '</div>';
                        }
                        if(!empty($json_decode['status'])){
                            echo '<div class="row mb-3">';
                            echo '  <div class="col-md-4"><dt>Status</dt></div>';
                            echo '  <div class="col-md-8 text-left"><small>'.$json_decode['status'].'</small></div>';
                            echo '</div>';
                        }
                        if(!empty($json_decode['subject'])){
                            echo '<div class="row mb-3">';
                            echo '  <div class="col-md-4"><dt>Subject/Patient</dt></div>';
                            echo '  <div class="col-md-8 text-left"></div>';
                            if(!empty($json_decode['subject']['display'])){
                                echo '  <div class="col-md-4"><small>Display</small></div>';
                                echo '  <div class="col-md-8 text-left"><small>'.$json_decode['subject']['display'].'</small></div>';
                            }
                            if(!empty($json_decode['subject']['reference'])){
                                echo '  <div class="col-md-4"><small>Reference</small></div>';
                                echo '  <div class="col-md-8 text-left"><small>'.$json_decode['subject']['reference'].'</small></div>';
                            }
                            echo '</div>';
                        }
                        if(!empty($json_decode['encounter'])){
                            echo '<div class="row mb-3">';
                            echo '  <div class="col-md-4"><dt>Encounter</dt></div>';
                            echo '  <div class="col-md-8 text-left"></div>';
                            if(!empty($json_decode['encounter']['display'])){
                                echo '  <div class="col-md-4"><small>Display</small></div>';
                                echo '  <div class="col-md-8 text-left"><small>'.$json_decode['encounter']['display'].'</small></div>';
                            }
                            if(!empty($json_decode['encounter']['reference'])){
                                echo '  <div class="col-md-4"><small>Reference</small></div>';
                                echo '  <div class="col-md-8 text-left"><small>'.$json_decode['encounter']['reference'].'</small></div>';
                            }
                            echo '</div>';
                        }
                        if(!empty($json_decode['performedPeriod'])){
                            echo '<div class="row mb-3">';
                            echo '  <div class="col-md-4"><dt>Performed Period</dt></div>';
                            echo '  <div class="col-md-8 text-left"></div>';
                            if(!empty($json_decode['performedPeriod']['start'])){
                                echo '  <div class="col-md-4"><small>Start</small></div>';
                                echo '  <div class="col-md-8 text-left"><small>'.$json_decode['performedPeriod']['start'].'</small></div>';
                            }
                            if(!empty($json_decode['performedPeriod']['end'])){
                                echo '  <div class="col-md-4"><small>End</small></div>';
                                echo '  <div class="col-md-8 text-left"><small>'.$json_decode['performedPeriod']['end'].'</small></div>';
                            }
                            echo '</div>';
                        }
                        if(!empty($json_decode['performer'])){
                            echo '<div class="row mb-3">';
                            echo '  <div class="col-md-8"><dt>Performer</dt></div>';
                            echo '  <div class="col-md-4 text-left"></div>';
                            $performer=$json_decode['performer'];
                            foreach($performer as $ValueAuthor){
                                if(!empty($ValueAuthor['actor']['display'])){
                                    echo '  <div class="col-md-4"><small>Display</small></div>';
                                    echo '  <div class="col-md-8 text-left"><small>'.$ValueAuthor['actor']['display'].'</small></div>';
                                }
                                if(!empty($ValueAuthor['actor']['reference'])){
                                    echo '  <div class="col-md-4"><small>Reference</small></div>';
                                    echo '  <div class="col-md-8 text-left"><small>'.$ValueAuthor['actor']['reference'].'</small></div>';
                                }
                            }
                            echo '</div>';
                        }
                        if(!empty($json_decode['category']['text'])){
                            echo '<div class="row mb-3">';
                            echo '  <div class="col-md-4"><dt>Category</dt></div>';
                            echo '  <div class="col-md-8"><small>'.$json_decode['category']['text'].'</small></div>';
                            $coding=$json_decode['category']['coding'];
                            foreach($coding as $CategoryCoding){
                                if(!empty($CategoryCoding['code'])){
                                    echo '  <div class="col-md-4"><small>Code</small></div>';
                                    echo '  <div class="col-md-8 text-left"><small>'.$CategoryCoding['code'].'</small></div>';
                                }
                                if(!empty($CategoryCoding['display'])){
                                    echo '  <div class="col-md-4"><small>Display</small></div>';
                                    echo '  <div class="col-md-8 text-left"><small>'.$CategoryCoding['display'].'</small></div>';
                                }
                                if(!empty($CategoryCoding['system'])){
                                    echo '  <div class="col-md-4"><small>System</small></div>';
                                    echo '  <div class="col-md-8 text-left"><small>'.$CategoryCoding['system'].'</small></div>';
                                }
                            }
                            echo '</div>';
                        }
                        if(!empty($json_decode['bodySite'])){
                            echo '<div class="row mb-3">';
                            echo '  <div class="col-md-4"><dt>Body Site</dt></div>';
                            echo '  <div class="col-md-8"></div>';
                            $bodySite=$json_decode['bodySite'];
                            foreach($bodySite as $bodySiteValue){
                                if(!empty($bodySiteValue['coding'])){
                                    $BodySiteCoding=$bodySiteValue['coding'];
                                    foreach($BodySiteCoding as $BodySiteCodingValue){
                                        if(!empty($BodySiteCodingValue['code'])){
                                            echo '  <div class="col-md-4"><small>Code</small></div>';
                                            echo '  <div class="col-md-8 text-left"><small>'.$BodySiteCodingValue['code'].'</small></div>';
                                        }
                                        if(!empty($BodySiteCodingValue['display'])){
                                            echo '  <div class="col-md-4"><small>Display</small></div>';
                                            echo '  <div class="col-md-8 text-left"><small>'.$BodySiteCodingValue['display'].'</small></div>';
                                        }
                                        if(!empty($BodySiteCodingValue['system'])){
                                            echo '  <div class="col-md-4"><small>System</small></div>';
                                            echo '  <div class="col-md-8 text-left"><small>'.$BodySiteCodingValue['system'].'</small></div>';
                                        }
                                    }
                                }
                            }
                            echo '</div>';
                        }
                        if(!empty($json_decode['code'])){
                            echo '<div class="row mb-3">';
                            echo '  <div class="col-md-4"><dt>Code</dt></div>';
                            echo '  <div class="col-md-8"></div>';
                            if(!empty($json_decode['code']['coding'])){
                                $codevaluecoding=$json_decode['code']['coding'];
                                foreach($codevaluecoding as $codevaluecodinglist){
                                    if(!empty($codevaluecodinglist['code'])){
                                        echo '  <div class="col-md-4"><small>Code</small></div>';
                                        echo '  <div class="col-md-8 text-left"><small>'.$codevaluecodinglist['code'].'</small></div>';
                                    }
                                    if(!empty($codevaluecodinglist['display'])){
                                        echo '  <div class="col-md-4"><small>Display</small></div>';
                                        echo '  <div class="col-md-8 text-left"><small>'.$codevaluecodinglist['display'].'</small></div>';
                                    }
                                    if(!empty($codevaluecodinglist['system'])){
                                        echo '  <div class="col-md-4"><small>System</small></div>';
                                        echo '  <div class="col-md-8 text-left"><small>'.$codevaluecodinglist['system'].'</small></div>';
                                    }
                                }
                            }
                            echo '</div>';
                        }
                        if(!empty($json_decode['reasonCode'])){
                            echo '<div class="row mb-3">';
                            echo '  <div class="col-md-4"><dt>Reason Code</dt></div>';
                            echo '  <div class="col-md-8"></div>';
                            if(!empty($json_decode['reasonCode'])){
                                $reasonCode=$json_decode['reasonCode'];
                                foreach($reasonCode as $reasonCodelist){
                                    if(!empty($reasonCodelist['coding'])){
                                        $ResonCodeCoding=$reasonCodelist['coding'];
                                        foreach($ResonCodeCoding as $ResonCodeCodingList){
                                            if(!empty($ResonCodeCodingList['code'])){
                                                echo '  <div class="col-md-4"><small>Code</small></div>';
                                                echo '  <div class="col-md-8 text-left"><small>'.$ResonCodeCodingList['code'].'</small></div>';
                                            }
                                            if(!empty($ResonCodeCodingList['display'])){
                                                echo '  <div class="col-md-4"><small>Display</small></div>';
                                                echo '  <div class="col-md-8 text-left"><small>'.$ResonCodeCodingList['display'].'</small></div>';
                                            }
                                            if(!empty($ResonCodeCodingList['system'])){
                                                echo '  <div class="col-md-4"><small>System</small></div>';
                                                echo '  <div class="col-md-8 text-left"><small>'.$ResonCodeCodingList['system'].'</small></div>';
                                            }
                                        }
                                    }
                                }
                            }
                            echo '</div>';
                        }
                        if(!empty($json_decode['meta'])){
                            echo '<div class="row mb-3">';
                            echo '  <div class="col-md-12 mb-2"><dt>Meta</dt></div>';
                            echo '  <div class="col-md-12 text-left">';
                            $meta=$json_decode['meta'];
                            if(!empty($meta['lastUpdated'])){
                                echo '<div class="row mb-2">';
                                echo '  <div class="col-md-4"><small>Last Update</small></div>';
                                echo '  <div class="col-md-8 text-left"><small>'.$meta['lastUpdated'].'</small></div>';
                                echo '</div>';
                            }
                            if(!empty($meta['versionId'])){
                                echo '<div class="row mb-2">';
                                echo '  <div class="col-md-4"><small>Version ID</small></div>';
                                echo '  <div class="col-md-8 text-left"><small>'.$meta['versionId'].'</small></div>';
                                echo '</div>';
                            }
                            echo '  </div>';
                            echo '</div>';
                        }
                        if(!empty($json_decode['note'])){
                            $note=$json_decode['note'];
                            foreach($note as $notelist){
                                $text=$notelist['text'];
                                echo '<div class="row mb-3">';
                                echo '  <div class="col-md-4"><dt>Note-Text</dt></div>';
                                echo '  <div class="col-md-8 text-left"><small>'.$notelist['text'].'</small></div>';
                                echo '</div>';
                            }
                        }
                    }
                }
            }
        }
    }
?>