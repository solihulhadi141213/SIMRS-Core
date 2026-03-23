<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Menangkap ID_PATIENT
    if(empty($_POST['id_patient'])){
        echo '<div class="row">';
        echo '<div class="col-md-12 text-center"><span class="text-danger">ID IHS Pasien Tidak Boleh Kosong</span></div>';
        echo '</div>';
    }else{
        $id_patient=$_POST['id_patient'];
        //Setting Koneksi
        $SettingSatuSehat=getDataDetail($Conn,' setting_satusehat','status','Active','id_setting_satusehat');
        if(empty($SettingSatuSehat)){
            echo '<div class="row">';
            echo '  <div class="col-md-12 text-danger text-center">';
            echo '      Tidak Ada Setting Satu Sehat Yang Aktif!';
            echo '  </div>';
            echo '</div>';
        }else{
            //1. Generate Token
            $Token=GenerateTokenSatuSehat($Conn);
            if(empty($Token)){
                echo '<div class="row">';
                echo '  <div class="col-md-12 text-danger text-center">';
                echo '      Terjadi Kesalahan Pada Saat Melakukan Generate Token';
                echo '  </div>';
                echo '</div>';
            }else{
                $baseurl_consent_satusehat=getDataDetail($Conn,' setting_satusehat','status','Active','consent_url');
                $response=GetConsent($baseurl_consent_satusehat,$Token,$id_patient);
                if(empty($response)){
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-12 text-center"><span class="text-danger">Tidak ada response dari Satu Sehat</span></div>';
                    echo '</div>';
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-6">URL</div>';
                    echo '  <div class="col-md-6 text-right">'.$baseurl_consent_satusehat.'</div>';
                    echo '</div>';
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-6">Token</div>';
                    echo '  <div class="col-md-6 text-right">'.$Token.'</div>';
                    echo '</div>';
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-6">ID Patient</div>';
                    echo '  <div class="col-md-6 text-right">'.$id_patient.'</div>';
                    echo '</div>';
                }else{
                    $json_decode =json_decode($response, true);
                    if(empty($json_decode['id'])){
                        echo '<div class="row">';
                        echo '  <div class="col-md-12 text-center"><span class="text-danger">Data Pasien Tidak Ditemukan</span></div>';
                        echo '</div>';
                        echo '<div class="row">';
                        echo '  <div class="col-md-12"><textarea class="form-control">'.$response.'</textarea></div>';
                        echo '</div>';
                    }else{
                        $id=$json_decode['id'];
                        $resourceType=$json_decode['resourceType'];
                        $status=$json_decode['status'];
                        $scope_coding=$json_decode['scope']['coding'];
                        $patient_reference=$json_decode['patient']['reference'];
                        echo '<div class="row mb-3">';
                        echo '  <div class="col-md-6">ID</div>';
                        echo '  <div class="col-md-6 text-right">'.$id.'</div>';
                        echo '</div>';
                        echo '<div class="row mb-3">';
                        echo '  <div class="col-md-6">Resource Type</div>';
                        echo '  <div class="col-md-6 text-right">'.$resourceType.'</div>';
                        echo '</div>';
                        echo '<div class="row mb-3">';
                        echo '  <div class="col-md-6">Status</div>';
                        echo '  <div class="col-md-6 text-right">'.$status.'</div>';
                        echo '</div>';
                        echo '<div class="row mb-3">';
                        echo '  <div class="col-md-6">Scope</div>';
                        echo '  <div class="col-md-6 text-right">';
                                foreach($scope_coding as $value_scope_coding){
                                    $scope_coding_code=$value_scope_coding['code'];
                                    $scope_coding_system=$value_scope_coding['system'];
                                    echo '  <ul>';
                                    echo '      <li><a href="'.$scope_coding_system.'" target="_blank" class="text-primary">'.$scope_coding_code.'</a></li>';
                                    echo '  </ul>';
                                }
                        echo '  </div>';
                        echo '</div>';
                        echo '<div class="row mb-3">';
                        echo '  <div class="col-md-6">Patient Reference</div>';
                        echo '  <div class="col-md-6 text-right">'.$patient_reference.'</div>';
                        echo '</div>';
                    }
                }
            }
        }
    }
?>