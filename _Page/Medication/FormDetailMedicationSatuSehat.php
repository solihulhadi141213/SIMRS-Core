<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap id_medication
    if(empty($_POST['id_medication'])){
        echo '<div class="row mb-3">';
        echo '  <div class="col-md-12 text-center text-danger">';
        echo '      ID Medication Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_medication=$_POST['id_medication'];
        $kode=getDataDetail($Conn,' obat_medication','id_medication',$id_medication,'kode');
        //Setting
        $SettingSatuSehat=getDataDetail($Conn,' setting_satusehat','status','Active','id_setting_satusehat');
        $baseurl=getDataDetail($Conn,'setting_satusehat','status','Active','baseurl');
        $Token=GenerateTokenSatuSehat($Conn);
        if(empty($SettingSatuSehat)){
            echo '<div class="row">';
            echo '  <div class="col-md-12 text-center text-danger">';
            echo '      Tidak ada setting satu sehat yang aktiv';
            echo '  </div>';
            echo '</div>';
        }else{
            if(empty($Token)){
                echo '<div class="row">';
                echo '  <div class="col-md-12 text-center text-danger">';
                echo '      Generate Token Gagal!';
                echo '  </div>';
                echo '</div>';
            }else{
                $GetDetailMedication=GetDetailMedication($baseurl,$Token,$id_medication);
                if(empty($GetDetailMedication)){
                    echo '  <div class="row">';
                    echo '      <div class="col-md-12 text-center text-danger">';
                    echo '          Tidak ada response dari satu sehat';
                    echo '      </div>';
                    echo '  </div>';
                }else{
                    $data = json_decode($GetDetailMedication, true);
                    if(empty($data['id'])){
                        echo '  <div class="row">';
                        echo '      <div class="col-md-12 text-center text-danger">';
                        echo '          Tidak ada informasi medication';
                        echo '      </div>';
                        echo '  </div>';
                        echo '  <div class="row">';
                        echo '      <div class="col-md-12 text-center text-danger">';
                        echo '          Response <textarea class="form-control">'.$GetDetailMedication.'</textarea>';
                        echo '      </div>';
                        echo '  </div>';
                    }else{
                        $id=$data['id'];
                        //code_coding
                        $code_coding=$data['code']['coding'];
                        $code_coding_code=$code_coding['0']['code'];
                        $code_coding_display=$code_coding['0']['display'];
                        $code_coding_system=$code_coding['0']['system'];
                        // extension
                        $extension=$data['extension'];
                        $extension_url=$extension['0']['url'];
                        $valueCodeableConcept=$extension['0']['valueCodeableConcept']['coding'];
                        $valueCodeableConcept_system=$valueCodeableConcept['0']['system'];
                        $valueCodeableConcept_code=$valueCodeableConcept['0']['code'];
                        $valueCodeableConcept_display=$valueCodeableConcept['0']['display'];
                        //form_coding
                        $form_coding=$data['form']['coding'];
                        $form_coding_system=$form_coding['0']['system'];
                        $form_coding_code=$form_coding['0']['code'];
                        $form_coding_display=$form_coding['0']['display'];
                        //identifier
                        $identifier=$data['identifier'];
                        $identifier_system=$identifier['0']['system'];
                        $identifier_use=$identifier['0']['use'];
                        $identifier_value=$identifier['0']['value'];
                        //ingredient
                        if(!empty($data['ingredient'])){
                            $ingredient=$data['ingredient'];
                            $ingredient_count=count($data['ingredient']);
                        }else{
                            $ingredient="";
                            $ingredient_count="";
                        }
                        //manufacturer_reference
                        $manufacturer_reference=$data['manufacturer']['reference'];
                        //meta
                        $meta_lastUpdated=$data['meta']['lastUpdated'];
                        $meta_profile=$data['meta']['profile']['0'];
                        $meta_versionId=$data['meta']['versionId'];
                        //resourceType
                        $resourceType=$data['resourceType'];
                        //status
                        $status=$data['status'];
?>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div id="accordion" role="tablist" aria-multiselectable="true">
                                    <div class="accordion-panel">
                                        <div class="accordion-heading" role="tab" id="headingOne">
                                            <h3 class="card-title accordion-title">
                                                <a class="accordion-msg waves-effect waves-dark scale_active" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                    <dt>A. Informasi Medication</dt>
                                                </a>
                                            </h3>
                                        </div>
                                    </div>
                                    <div id="collapseOne" class="panel-collapse in collapse show" role="tabpanel" aria-labelledby="headingOne" style="">
                                        <div class="accordion-content accordion-desc">
                                            <div class="row mb-3">
                                                <div class="col-md-4">1. Resource Type</div>
                                                <div class="col-md-8 text-right"><code class="text-secondary"><?php echo $resourceType;?></code></div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">2. Status</div>
                                                <div class="col-md-8 text-right"><code class="text-secondary"><?php echo $status;?></code></div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">3. Manufacturer</div>
                                                <div class="col-md-8 text-right"><code class="text-secondary"><?php echo $manufacturer_reference;?></code></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-panel">
                                        <div class="accordion-heading" role="tab" id="headingTwo">
                                            <h3 class="card-title accordion-title">
                                                <a class="accordion-msg waves-effect waves-dark scale_active" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                                    <dt>B. Identifier</dt>
                                                </a>
                                            </h3>
                                        </div>
                                    </div>
                                    <div id="collapseTwo" class="panel-collapse in collapse" role="tabpanel" aria-labelledby="headingTwo" style="">
                                        <div class="accordion-content accordion-desc">
                                            <div class="row mb-3">
                                                <div class="col-md-4">1. Use</div>
                                                <div class="col-md-8 text-right"><code class="text-secondary"><?php echo $identifier_use;?></code></div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">2. Value</div>
                                                <div class="col-md-8 text-right"><code class="text-secondary"><?php echo $identifier_value;?></code></div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">3. System</div>
                                                <div class="col-md-8 text-right"><code class="text-secondary"><?php echo $identifier_system;?></code></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-panel">
                                        <div class="accordion-heading" role="tab" id="headingTree2">
                                            <h3 class="card-title accordion-title">
                                                <a class="accordion-msg waves-effect waves-dark scale_active" data-toggle="collapse" data-parent="#accordion" href="#collapseTree2" aria-expanded="true" aria-controls="collapseTree2">
                                                    <dt>C. Code Coding</dt>
                                                </a>
                                            </h3>
                                        </div>
                                    </div>
                                    <div id="collapseTree2" class="panel-collapse in collapse" role="tabpanel" aria-labelledby="headingTree2" style="">
                                        <div class="accordion-content accordion-desc">
                                            <div class="row mb-3">
                                                <div class="col-md-4">1. Code</div>
                                                <div class="col-md-8 text-right"><code class="text-secondary"><?php echo $code_coding_code;?></code></div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">3. Display</div>
                                                <div class="col-md-8 text-right"><code class="text-secondary"><?php echo $code_coding_display;?></code></div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">2. System</div>
                                                <div class="col-md-8 text-right"><code class="text-secondary"><?php echo $code_coding_system;?></code></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-panel">
                                        <div class="accordion-heading" role="tab" id="headingFour">
                                            <h3 class="card-title accordion-title">
                                                <a class="accordion-msg waves-effect waves-dark scale_active" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
                                                    <dt>D. Form Coding</dt>
                                                </a>
                                            </h3>
                                        </div>
                                    </div>
                                    <div id="collapseFour" class="panel-collapse in collapse" role="tabpanel" aria-labelledby="headingFour" style="">
                                        <div class="accordion-content accordion-desc">
                                            <div class="row mb-3">
                                                <div class="col-md-4">1. Code</div>
                                                <div class="col-md-8 text-right"><code class="text-secondary"><?php echo $form_coding_code;?></code></div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">2. Display</div>
                                                <div class="col-md-8 text-right"><code class="text-secondary"><?php echo $form_coding_display;?></code></div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">3. System</div>
                                                <div class="col-md-8 text-right"><code class="text-secondary"><?php echo $form_coding_system;?></code></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-panel">
                                        <div class="accordion-heading" role="tab" id="headingFive">
                                            <h3 class="card-title accordion-title">
                                                <a class="accordion-msg waves-effect waves-dark scale_active" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="true" aria-controls="collapseFive">
                                                    <dt>E. Extension</dt>
                                                </a>
                                            </h3>
                                        </div>
                                    </div>
                                    <div id="collapseFive" class="panel-collapse in collapse" role="tabpanel" aria-labelledby="headingFive" style="">
                                        <div class="accordion-content accordion-desc">
                                            <div class="row mb-3">
                                                <div class="col-md-4">1. URL</div>
                                                <div class="col-md-8 text-right"><code class="text-secondary"><?php echo $extension_url;?></code></div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">2. Code</div>
                                                <div class="col-md-8 text-right"><code class="text-secondary"><?php echo $valueCodeableConcept_code;?></code></div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">3. Display</div>
                                                <div class="col-md-8 text-right"><code class="text-secondary"><?php echo $valueCodeableConcept_display;?></code></div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">4. System</div>
                                                <div class="col-md-8 text-right"><code class="text-secondary"><?php echo $valueCodeableConcept_system;?></code></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-panel">
                                        <div class="accordion-heading" role="tab" id="headingSeven">
                                            <h3 class="card-title accordion-title">
                                                <a class="accordion-msg waves-effect waves-dark scale_active" data-toggle="collapse" data-parent="#accordion" href="#collapseSeven" aria-expanded="true" aria-controls="collapseSeven">
                                                    <dt>F. Ingridient</dt>
                                                </a>
                                            </h3>
                                        </div>
                                    </div>
                                    <div id="collapseSeven" class="panel-collapse in collapse" role="tabpanel" aria-labelledby="headingSeven" style="">
                                        <div class="accordion-content accordion-desc">
                                            <?php
                                                if(!empty($ingredient_count)){
                                                    echo '<div class="row">';
                                                    echo '  <div class="col col-md-12">';
                                                    echo '      <ol>';
                                                                $no=1;
                                                                foreach($ingredient as $ingredient_list){
                                                                    $isActive=$ingredient_list['isActive'];
                                                                    $itemCodeableConcept_code=$ingredient_list['itemCodeableConcept']['coding']['0']['code'];
                                                                    $itemCodeableConcept_display=$ingredient_list['itemCodeableConcept']['coding']['0']['display'];
                                                                    $itemCodeableConcept_system=$ingredient_list['itemCodeableConcept']['coding']['0']['system'];
                                                                    $numerator_value=$ingredient_list['strength']['numerator']['value'];
                                                                    $numerator_code=$ingredient_list['strength']['numerator']['code'];
                                                                    $denominator_value=$ingredient_list['strength']['denominator']['value'];
                                                                    $denominator_code=$ingredient_list['strength']['denominator']['code'];
                                                                    echo '<li>';
                                                                    echo '  '.$itemCodeableConcept_display.'';
                                                                    echo '  <ul>';
                                                                    echo '      <li>is Active : <code>'.$isActive.'</code></li>';
                                                                    echo '      <li>Kode : <code>'.$itemCodeableConcept_code.'</code></li>';
                                                                    echo '      <li>System : <code>'.$itemCodeableConcept_system.'</code></li>';
                                                                    echo '      <li>Numerator : <code>'.$numerator_value.' '.$numerator_code.'</code></li>';
                                                                    echo '      <li>Denominator : <code>'.$denominator_value.' '.$denominator_code.'</code></li>';
                                                                    echo '  </ul>';
                                                                    echo '</li>';
                                                                }
                                                    echo '      </ol>';
                                                    echo '  </div>';
                                                    echo '</div>';
                                                }else{
                                                    echo '<div class="row">';
                                                    echo '  <div class="col col-md-12 text-danger text-center">';
                                                    echo '      Tidak ada informasi ingredient';
                                                    echo '  </div>';
                                                    echo '</div>';
                                                }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="accordion-panel">
                                        <div class="accordion-heading" role="tab" id="headingSix">
                                            <h3 class="card-title accordion-title">
                                                <a class="accordion-msg waves-effect waves-dark scale_active" data-toggle="collapse" data-parent="#accordion" href="#collapseSix" aria-expanded="true" aria-controls="collapseSix">
                                                    <dt>G. Meta</dt>
                                                </a>
                                            </h3>
                                        </div>
                                    </div>
                                    <div id="collapseSix" class="panel-collapse in collapse" role="tabpanel" aria-labelledby="headingSix" style="">
                                        <div class="accordion-content accordion-desc">
                                            <div class="row mb-3">
                                                <div class="col-md-4">1. Update</div>
                                                <div class="col-md-8 text-right"><code class="text-secondary"><?php echo $meta_lastUpdated;?></code></div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">2. Profile</div>
                                                <div class="col-md-8 text-right"><code class="text-secondary"><?php echo $meta_profile;?></code></div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">3. Version</div>
                                                <div class="col-md-8 text-right"><code class="text-secondary"><?php echo $meta_versionId;?></code></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3 mt-4">
                            <div class="col-md-12">
                                <a href="index.php?Page=Medication&Sub=DetailMedication&kode=<?php echo $kode; ?>" class="btn btn-block btn-sm btn-outline-secondary">
                                    Lihat Selengkapnya <i class="ti ti-more"></i>
                                </a>
                            </div>
                        </div>
<?php 
                    }
                }
            }
        }
    } 
?>