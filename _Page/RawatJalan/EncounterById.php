<?php
    if(empty($json_decode['id'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center"><span class="text-danger">Data Pasien Tidak Ditemukan</span></div>';
        echo '</div>';
    }else{
        if(!empty($json_decode['id'])){
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-4"><dt>ID Encounter</dt></div>';
            echo '  <div class="col-md-8 text-left"><small>'.$json_decode['id'].'</small></div>';
            echo '</div>';
        }
        if(!empty($json_decode['subject']['display'])){
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-4"><dt>Nama Pasien</dt></div>';
            echo '  <div class="col-md-8 text-left"><small>'.$json_decode['subject']['display'].'</small></div>';
            echo '</div>';
        }
        if(!empty($json_decode['subject']['reference'])){
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-4"><dt>ID IHS</dt></div>';
            echo '  <div class="col-md-8 text-left"><small>'.$json_decode['subject']['reference'].'</small></div>';
            echo '</div>';
        }
        if(!empty($json_decode['identifier'])){
            $identifier=$json_decode['identifier'];
            if(!empty(count($identifier))){
                $no=1;
                foreach($identifier as $value_identifier){
                    $system=$value_identifier['system'];
                    $value=$value_identifier['value'];
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-4"><dt>Identifier</dt></div>';
                    echo '  <div class="col-md-8 text-left"><small>'.$value.'<br>'.$system.'</small></div>';
                    echo '</div>';
                    $no++;
                }
            }
        }
        if(!empty($json_decode['location'])){
            $location=$json_decode['location'];
            if(!empty(count($location))){
                $no=1;
                foreach($location as $ValueLocation){
                    $reference=$ValueLocation['location']['reference'];
                    $display=$ValueLocation['location']['display'];
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-4"><dt>Location</dt></div>';
                    echo '  <div class="col-md-8 text-left"><small>'.$display.'<br>'.$reference.'</small></div>';
                    echo '</div>';
                    $no++;
                }
            }
        }
        if(!empty($json_decode['participant'])){
            $participant=$json_decode['participant'];
            if(!empty(count($participant))){
                $no=1;
                foreach($participant as $Valueparticipant){
                    $individual=$Valueparticipant['individual'];
                    $individualdisplay=$individual['display'];
                    $individualreference=$individual['reference'];
                    $type=$Valueparticipant['type'];
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-4"><dt>Participant</dt></div>';
                    echo '  <div class="col-md-8 text-left"><small>'.$individualdisplay.'<br>'.$individualreference.'</small></div>';
                    echo '</div>';
                    if(!empty(count($type))){
                        foreach($type as $ValueType){
                            if(!empty(count($ValueType['coding']))){
                                $coding=$ValueType['coding'];
                                foreach($coding as $ValueCoding){
                                    $code=$ValueCoding['code'];
                                    $display=$ValueCoding['display'];
                                    $system=$ValueCoding['system'];
                                    echo '<div class="row mb-3">';
                                    echo '  <div class="col-md-4"><dt>Participant Coding</dt></div>';
                                    echo '  <div class="col-md-8 text-left"><small>'.$display.' ('.$code.')<br>'.$system.'</small></div>';
                                    echo '</div>';
                                }
                            }
                        }
                    }
                    $no++;
                }
            }
        }

        if(!empty($json_decode['class'])){
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-4"><dt>Class</dt></div>';
            echo '  <div class="col-md-8 text-left">';
            echo '      <small>';
                            if(!empty($json_decode['class']['code'])){
                                echo 'Code: '.$json_decode['class']['code'].'<br>';
                            }
                            if(!empty($json_decode['class']['display'])){
                                echo 'Display: '.$json_decode['class']['display'].'<br>';
                            }
                            if(!empty($json_decode['class']['system'])){
                                echo 'Sistem: '.$json_decode['class']['system'].'<br>';
                            }
            echo '      </small>';
            echo '  </div>';
            echo '</div>';
        }
        if(!empty($json_decode['period'])){
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-4"><dt>Periode</dt></div>';
            echo '  <div class="col-md-8 text-left">';
            echo '      <small>';
                            if(!empty($json_decode['period']['start'])){
                                echo 'Start: '.$json_decode['period']['start'].'<br>';
                            }
                            if(!empty($json_decode['period']['end'])){
                                echo 'End: '.$json_decode['period']['end'].'<br>';
                            }
            echo '      </small>';
            echo '  </div>';
            echo '</div>';
        }
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
        if(!empty($json_decode['serviceProvider']['reference'])){
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-4"><dt>Service Provider</dt></div>';
            echo '  <div class="col-md-8 text-left"><small>'.$json_decode['serviceProvider']['reference'].'</small></div>';
            echo '</div>';
        }
        if(!empty($json_decode['statusHistory'])){
            $statusHistory=$json_decode['statusHistory'];
            if(!empty(count($statusHistory))){
                $no=1;
                foreach($statusHistory as $ValueHistory){
                    $period=$ValueHistory['period'];
                    $end=$period['end'];
                    $start=$period['start'];
                    $status=$ValueHistory['status'];
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-4"><dt>Status History</dt></div>';
                    echo '  <div class="col-md-8 text-left"><small>'.$start.'(Start)<br>'.$end.' (End)<br>Status: '.$status.'</small></div>';
                    echo '</div>';
                    $no++;
                }
            }
        }
        if(!empty($json_decode['status'])){
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-4"><dt>Status</dt></div>';
            echo '  <div class="col-md-8 text-left"><small>'.$json_decode['status'].'</small></div>';
            echo '</div>';
        }
    }
?>