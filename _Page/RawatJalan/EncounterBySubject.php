<?php
    if(empty($json_decode['entry'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center"><span class="text-danger">Data Encounter Tidak Ditemukan</span></div>';
        echo '</div>';
    }else{
        if(empty($json_decode['total'])){
            echo '<div class="row">';
            echo '  <div class="col-md-12 text-center"><span class="text-danger">Data Encounter Tidak Ditemukan</span></div>';
            echo '</div>';
        }else{
            $entry=$json_decode['entry'];
            if(!empty(count($entry))){
                $no=1;
                foreach($entry as $ValueEntry){
                    if(!empty($ValueEntry['resource']['id'])){
                        echo '<div class="row mb-3">';
                        echo '  <div class="col-md-12"><dt>'.$ValueEntry['resource']['id'].'</dt></div>';
                        if(!empty($ValueEntry['resource']['subject']['display'])){
                            if(!empty($ValueEntry['resource']['subject']['reference'])){
                                echo '  <div class="col-md-12 text-left"><small>Nama: '.$ValueEntry['resource']['subject']['display'].'<br>ID: '.$ValueEntry['resource']['subject']['reference'].'</small></div>';
                            }
                        }
                        echo '</div>';
                    }else{
                        if(!empty($ValueEntry['resource']['resourceType'])){
                            echo '  <div class="col-md-12 text-left"><small>Type: '.$ValueEntry['resource']['resourceType'].'</small></div>';
                        }
                    }
                }
            }
        }
    }
?>