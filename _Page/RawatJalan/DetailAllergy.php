<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $SettingSatuSehat=getDataDetail($Conn,' setting_satusehat','status','Active','id_setting_satusehat');
    $Token=GenerateTokenSatuSehat($Conn);
    $baseurl_satusehat=getDataDetail($Conn,'setting_satusehat','status','Active','baseurl');
    if(empty($_POST['id_kunjungan'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center text-danger">';
        echo '      ID Kunjungan Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_kunjungan=$_POST['id_kunjungan'];
        //Buka Data Antrian Berdasarkan Kunjungan
        $id_encounter=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'id_encounter');
        if(empty($id_encounter)){
            echo '<div class="row">';
            echo '  <div class="col-md-12 text-center text-danger">';
            echo '      <code>Kunjungan Ini Tidak Memiliki Data Encounter!</code>';
            echo '  </div>';
            echo '</div>';
        }else{
            //Buka Data Alergi Dari database
            $id_allergy=getDataDetail($Conn,"kunjungan_alergi",'id_kunjungan',$id_kunjungan,'id_allergy');
            if(empty($id_allergy)){
                echo '<div class="row mb-3 subtitle">';
                echo '  <div class="col-md-12 mb-3 text-center">';
                echo '      Tidak Ada Informasi Allergy Intolerance Pada Database SIMRS Yang Terhubung Dengan Kunjungan Ini.';
                echo '      Silahkan Tambah/Buat Informasi Allergy Intolerance Tersebut Terlebih Dulu';
                echo '  </div>';
                echo '  <div class="col-md-12">';
                echo '      <button type="button" class="btn btn-sm btn-block btn-outline-primary" data-toggle="modal" data-target="#ModalTambahAllergyIntoleranc" data-id="'.$id_kunjungan.'">';
                echo '          <i class="ti ti-plus"></i> Tambah';
                echo '      </button>';
                echo '  </div>';
                echo '</div>';
            }else{
                echo '<div class="row mb-3">';
                echo '  <div class="col-md-12 mb-2">';
                echo '      <button type="button" class="btn btn-sm btn-block btn-outline-primary" data-toggle="modal" data-target="#ModalEditAllergyIntoleranc" data-id="'.$id_kunjungan.'">';
                echo '          <i class="ti ti-pencil"></i> Edit';
                echo '      </button>';
                echo '  </div>';
                echo '</div>';
                $id_kunjungan_alergi=getDataDetail($Conn,"kunjungan_alergi",'id_kunjungan',$id_kunjungan,'id_kunjungan_alergi');
                $id_allergy=getDataDetail($Conn,"kunjungan_alergi",'id_kunjungan',$id_kunjungan,'id_allergy');
                $id_allergy=getDataDetail($Conn,"kunjungan_alergi",'id_kunjungan',$id_kunjungan,'id_allergy');
                $id_encounter=getDataDetail($Conn,"kunjungan_alergi",'id_kunjungan',$id_kunjungan,'id_encounter');
                $DataRawSimrs=getDataDetail($Conn,"kunjungan_alergi",'id_kunjungan',$id_kunjungan,'raw');
                $id_akses_petugas=getDataDetail($Conn,"kunjungan_alergi",'id_kunjungan',$id_kunjungan,'id_akses');
                $NamaPetugas=getDataDetail($Conn,"akses",'id_akses',$id_akses_petugas,'nama');
                $updatetime=getDataDetail($Conn,"kunjungan_alergi",'id_kunjungan',$id_kunjungan,'updatetime');
                echo '<div class="row mb-3 ml-3 sub-title">';
                echo '  <div class="col-md-12 mb-3">';
                echo '      A. Detail Informasi Dari SIMRS';
                echo '  </div>';
                echo '  <div class="col-md-12 mb-3">';
                echo '      <ol>';
                echo '          <li>ID Alergi SIMRS: <code>'.$id_kunjungan_alergi.'</code></li>';
                echo '          <li>ID Alergi Satu Sehat: <code>'.$id_allergy.'</code></li>';
                echo '          <li>ID Encounter : <code>'.$id_encounter.'</code></li>';
                echo '          <li>Petugas Entry : <code>'.$NamaPetugas.'</code></li>';
                echo '          <li>Update : <code>'.$updatetime.'</code></li>';
                echo '          <li>RAW : <textarea class="form-control">'.$DataRawSimrs.'</textarea></li>';
                echo '      </ol>';
                echo '  </div>';
                echo '</div>';
                echo '<div class="row mb-3 ml-3 sub-title">';
                echo '  <div class="col-md-12 mb-3">';
                echo '      B. Detail Informasi Dari Satu Sehat';
                echo '  </div>';
                echo '  <div class="col-md-12 mb-3">';
                //Buka data Alergi dari satu sehat
                $response=AllergyIntoleranceById($baseurl_satusehat,$Token,$id_allergy);
                if(empty($response)){
                    echo '<div class="row">';
                    echo '  <div class="col-md-12 text-center text-danger">';
                    echo '      <code>Tidak ada response dari satu sehat!</code>';
                    echo '  </div>';
                    echo '</div>';
                    echo '<div class="row">';
                    echo '  <div class="col-md-12 text-center text-danger">';
                    echo '      <code>Silahkan Reload Halaman Ini Untuk Mengulang Request Data</code>';
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
                        echo '          <li class="mb-3">Data Raw : <textarea class="form-control">'.$response.'</textarea></li>';
                        echo '      </ol>';
                        echo '  </div>';
                        echo '</div>';
                    }
                }
                echo '  </div>';
                echo '</div>';
            }
        }
    }
?>