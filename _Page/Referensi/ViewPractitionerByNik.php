<?php
ini_set("display_errors","off");
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
            $resourceType=$JsonData['resourceType'];
            $total=$JsonData['total'];
            $type=$JsonData['type'];
            $JumlahEntry=count($entry);
            if(!empty($JumlahEntry)){
                foreach($entry as $value_entry){
                    $fullUrl=$value_entry['fullUrl'];
                    $resource=$value_entry['resource'];
                    $address=$resource['address'];
                    $birthDate=$resource['birthDate'];
                    $gender=$resource['gender'];
                    $name=$resource['name'];
                    $qualification=$resource['qualification'];
                    $telecom=$resource['telecom'];
                    $id=$resource['id'];
                    $identifier=$resource['identifier'];
                    $lastUpdated=$resource['meta']['lastUpdated'];
                    $versionId=$resource['meta']['versionId'];
                    $resourceType=$resource['resourceType'];
                    //Nama Alias dan Gelar
                    $JumlahNama=count($name);
                    echo '<div class="row">';
                    echo '  <div class="col-md-12">';
                    echo '      <div class="card">';
                    echo '          <div class="card-header">';
                    echo '              <dt>';
                    echo '                  <a href="javascript:void(0);" class="text-success"  data-toggle="modal" data-target="#ModalDetailPractitioner" data-id="'.$id.'" title="Lihat Data ID Di Satu Sehat">';
                    echo '                      '.$id.' <i class="ti-new-window"></i>';
                    echo '                  </a>';
                    echo '              </dt>';
                    if(!empty($JumlahNama)){
                        foreach($name as $value_entry){
                            $text=$value_entry['text'];
                            $use=$value_entry['use'];
                            echo '      <small>Nama: '.$text.' ('.$use.')</small><br>';
                        }
                    }
                    echo '              <small>Gender: '.$gender.'</small><br>';
                    echo '              <small>Brith Date: '.$birthDate.'</small><br>';
                    echo '              <small>Last Update: '.$lastUpdated.'</small><br>';
                    echo '              <small>Version ID: '.$versionId.'</small><br>';
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