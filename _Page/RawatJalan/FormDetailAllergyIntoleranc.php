<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $SettingSatuSehat=getDataDetail($Conn,' setting_satusehat','status','Active','id_setting_satusehat');
    $Token=GenerateTokenSatuSehat($Conn);
    $baseurl_satusehat=getDataDetail($Conn,'setting_satusehat','status','Active','baseurl');
    if(empty($_POST['id'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center text-danger">';
        echo '      ID Alergi Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_allergy=$_POST['id'];
        //Buka data Alergi dari satu sehat
        $response=AllergyIntoleranceById($baseurl_satusehat,$Token,$id_allergy);
        if(empty($response)){
            echo '<div class="row">';
            echo '  <div class="col-md-12 text-center text-danger">';
            echo '      <code>Tidak ada response dari satu sehat!</code>';
            echo '  </div>';
            echo '</div>';
        }else{
            $json_decode =json_decode($response, true);
            if(empty($json_decode['id'])){
                echo '<div class="row mb-3">';
                echo '  <div class="col-md-12 text-center text-danger">';
                echo '      <code>Data tidak ditemukan pada satu sehat!</code>';
                echo '  </div>';
                echo '</div>';
                echo '<div class="row">';
                echo '  <div class="col-md-12">';
                echo '      <textarea class="form-control">'.$response.'</textarea>';
                echo '  </div>';
                echo '</div>';
            }else{
                $id=$json_decode['id'];
                $resourceType=$json_decode['resourceType'];
                $recordedDate=$json_decode['recordedDate'];
                $category=$json_decode['category'];
                $patient_display=$json_decode['patient']['display'];
                $patient_reference=$json_decode['patient']['reference'];
                $clinicalStatus_coding_code=$json_decode['clinicalStatus']['coding']['0']['code'];
                $clinicalStatus_coding_display=$json_decode['clinicalStatus']['coding']['0']['display'];
                $clinicalStatus_coding_system=$json_decode['clinicalStatus']['coding']['0']['system'];
                $verificationStatus_code=$json_decode['verificationStatus']['coding']['0']['code'];
                $verificationStatus_display=$json_decode['verificationStatus']['coding']['0']['display'];
                $verificationStatus_system=$json_decode['verificationStatus']['coding']['0']['system'];
                $JenisAlergi=$json_decode['code']['coding'];
                $JumlahAlergen=count($JenisAlergi);
                $identifier=$json_decode['identifier'];
                $encounter_display=$json_decode['encounter']['display'];
                $encounter_reference=$json_decode['encounter']['reference'];
                $recorder_reference=$json_decode['recorder']['reference'];
                echo '<div class="row mb-3">';
                echo '  <div class="col-md-12">';
                echo '      <ol>';
                echo '          <li class="mb-3">Resource Type : <code class="text-secondary">'.$resourceType.'</code></li>';
                echo '          <li class="mb-3">ID Alergy : <code class="text-secondary">'.$id.'</code></li>';
                echo '          <li class="mb-3">';
                echo '              Pasien :';
                echo '              <ul>';
                echo '                  <li>- ID IHS : <code class="text-secondary">'.$patient_reference.'</code></li>';
                echo '                  <li>- Nama Pasien: <code class="text-secondary">'.$patient_display.'</code></li>';
                echo '              </ul>';
                echo '          </li>';
                echo '          <li class="mb-3">';
                echo '              Kunjungan/Encounter :';
                echo '              <ul>';
                echo '                  <li>- Display: <code class="text-secondary">'.$encounter_reference.'</code></li>';
                echo '                  <li>- Reference: <code class="text-secondary">'.$encounter_display.'</code></li>';
                echo '              </ul>';
                echo '          </li>';
                echo '          <li class="mb-3">';
                echo '              Identifier :';
                echo '              <ul>';
                                    foreach($identifier as $list_identifier){
                                        $identifier_system=$list_identifier['system'];
                                        $identifier_use=$list_identifier['use'];
                                        $identifier_value=$list_identifier['value'];
                                        echo '<li>- <a href="'.$identifier_system.'" title="'.$identifier_system.'" target="_blank"><code class="text-secondary">'.$identifier_use.' ('.$identifier_value.')</code></a></li>';
                                    }
                echo '              </ul>';
                echo '          </li>';
                echo '          <li class="mb-3">';
                echo '              Kategori :';
                                    foreach($category as $KategoriList){
                                        echo '<code class="text-secondary">';
                                        echo "$KategoriList,";
                                        echo '</code>';
                                    }
                echo '          </li>';
                if(!empty($JenisAlergi)){
                    echo '          <li class="mb-3">';
                    echo '              Jenis Alergen :';
                    echo '              <ul>';
                                        foreach($JenisAlergi as $ListAlergen){
                                            $code_coding_code=$ListAlergen['code'];
                                            $code_coding_display=$ListAlergen['display'];
                                            $code_coding_system=$ListAlergen['system'];
                                            echo '<li>- <a href="'.$code_coding_system.'" title="'.$code_coding_system.'" target="_blank"><code class="text-secondary">'.$code_coding_display.' ('.$code_coding_code.')</code></a></li>';
                                        }
                    echo '              </ul>';
                    echo '          </li>';
                }
                echo '          <li class="mb-3">';
                echo '              Clinical Status :';
                echo '              <ul>';
                echo '                  <li>- Display: <code class="text-secondary">'.$clinicalStatus_coding_display.'</code></li>';
                echo '                  <li>- System: <code class="text-secondary">'.$clinicalStatus_coding_system.'</code></li>';
                echo '              </ul>';
                echo '          </li>';
                echo '          <li class="mb-3">';
                echo '              Verification  Status :';
                echo '              <ul>';
                echo '                  <li>- Display: <code class="text-secondary">'.$verificationStatus_display.'</code></li>';
                echo '                  <li>- System: <code class="text-secondary">'.$verificationStatus_system.'</code></li>';
                echo '              </ul>';
                echo '          </li>';
                echo '          <li class="mb-3">Practitioner : <code class="text-secondary">'.$recorder_reference.'</code></li>';
                echo '          <li class="mb-3">Recorded Date : <code class="text-secondary">'.$recordedDate.'</code></li>';
                echo '      </ol>';
                echo '  </div>';
                echo '</div>';
                echo '<div class="row">';
                echo '  <div class="col-md-12">';
                echo '      <label>Raw Data</label>';
                echo '      <textarea class="form-control">'.$response.'</textarea>';
                echo '  </div>';
                echo '</div>';
            }
        }
    }
?>