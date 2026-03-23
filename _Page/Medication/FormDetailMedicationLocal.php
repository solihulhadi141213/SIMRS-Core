<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap id_obat_medication
    if(empty($_POST['id_obat_medication'])){
        echo '<div class="row mb-3">';
        echo '  <div class="col-md-12 text-center text-danger">';
        echo '      ID Medication Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_obat_medication=$_POST['id_obat_medication'];
        //Buka Informasi Detail Medication
        $id_obat=getDataDetail($Conn,' obat_medication','id_obat_medication',$id_obat_medication,'id_obat');
        $id_medication=getDataDetail($Conn,' obat_medication','id_obat_medication',$id_obat_medication,'id_medication');
        $kode=getDataDetail($Conn,' obat_medication','id_obat_medication',$id_obat_medication,'kode');
        $nama=getDataDetail($Conn,' obat_medication','id_obat_medication',$id_obat_medication,'nama');
        $raw_medication=getDataDetail($Conn,' obat_medication','id_obat_medication',$id_obat_medication,'raw_medication');
        $id_akses=getDataDetail($Conn,' obat_medication','id_obat_medication',$id_obat_medication,'id_akses');
        $updatetime=getDataDetail($Conn,' obat_medication','id_obat_medication',$id_obat_medication,'updatetime');
        //Nama Petugas
        $NamaPetugas=getDataDetail($Conn,' akses','id_akses',$id_akses,'nama');
        //Decode Raw Data
        $data = json_decode($raw_medication, true);
        $resourceType=$data['resourceType'];
        $meta=$data['meta'];
        $profile=$meta['profile'][0];
        $identifier=$data['identifier'];
        $identifier_system=$identifier['0']['system'];
        $identifier_use=$identifier['0']['use'];
        $identifier_value=$identifier['0']['value'];
        $code=$data['code'];
        $coding=$code['coding'];
        $coding_system=$coding['0']['system'];
        $coding_code=$coding['0']['code'];
        $coding_display=$coding['0']['display'];
        $status=$data['status'];
        $manufacturer=$data['manufacturer']['reference'];
        $form_coding=$data['form']['coding'];
        $form_coding_system=$form_coding['0']['system'];
        $form_coding_code=$form_coding['0']['code'];
        $form_coding_display=$form_coding['0']['display'];
        $ingredient=$data['ingredient'];
        $extension=$data['extension'];
        $extension_url=$extension['0']['url'];
        $extension_url_valueCodeableConcept=$extension['0']['valueCodeableConcept'];
        $valueCodeableConcept_coding=$extension_url_valueCodeableConcept['coding'];
        $valueCodeableConcept_coding_system=$valueCodeableConcept_coding['0']['system'];
        $valueCodeableConcept_coding_code=$valueCodeableConcept_coding['0']['code'];
        $valueCodeableConcept_coding_display=$valueCodeableConcept_coding['0']['display'];
        //Change $raw_medication to beauty
        $raw_medication=$raw_medication;
        $newJsonString = json_encode($data, JSON_PRETTY_PRINT);

?>
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
                        <div class="col-md-4">1. ID Obat :</div>
                        <div class="col-md-8 text-right">
                            <code class="text-secondary"><?php echo "$id_obat"; ?></code>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">2. ID Medication :</div>
                        <div class="col-md-8 text-right">
                            <code class="text-secondary"><?php echo "$id_medication"; ?></code>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">3. Kode Obat :</div>
                        <div class="col-md-8 text-right">
                            <code class="text-secondary"><?php echo "$kode"; ?></code>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">4. Nama Obat :</div>
                        <div class="col-md-8 text-right">
                            <code class="text-secondary"><?php echo "$nama"; ?></code>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">5. Petugas :</div>
                        <div class="col-md-8 text-right">
                            <code class="text-secondary"><?php echo "$NamaPetugas"; ?></code>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">6. Updatetime :</div>
                        <div class="col-md-8 text-right">
                            <code class="text-secondary"><?php echo "$updatetime"; ?></code>
                        </div>
                    </div>
                </div>
            </div>
            <div class="accordion-panel">
                    <div class="accordion-heading" role="tab" id="headingTwo">
                        <h3 class="card-title accordion-title">
                            <a class="accordion-msg waves-effect waves-dark scale_active" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                <dt>B. Service Response</dt>
                            </a>
                        </h3>
                    </div>
                </div>
                <div id="collapseTwo" class="panel-collapse in collapse" role="tabpanel" aria-labelledby="headingTwo" style="">
                    <div class="accordion-content accordion-desc">
                        <div class="row mb-3">
                            <div class="col-md-4">1. Resource Type :</div>
                            <div class="col-md-8 text-right"><code class="text-secondary"><?php echo "$resourceType"; ?></code></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">2. Profile :</div>
                            <div class="col-md-8 text-right"><code class="text-secondary"><?php echo "$profile"; ?></code></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">3. Identifier</div>
                            <div class="col-md-12">
                                <ol>
                                    <li><code class="text-secondary"><?php echo "$identifier_system"; ?></code></li>
                                    <li><code class="text-secondary"><?php echo "$identifier_use"; ?></code></li>
                                    <li><code class="text-secondary"><?php echo "$identifier_value"; ?></code></li>
                                </ol>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">4. Code Coding</div>
                            <div class="col-md-12">
                                <ol>
                                    <li><code class="text-secondary"><?php echo "$coding_system"; ?></code></li>
                                    <li><code class="text-secondary"><?php echo "$coding_code"; ?></code></li>
                                    <li><code class="text-secondary"><?php echo "$coding_display"; ?></code></li>
                                </ol>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">5. Satatus</div>
                            <div class="col-md-8 text-right"><code class="text-secondary"><?php echo "$status"; ?></code></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">6. Manufacturer</div>
                            <div class="col-md-8 text-right"><code class="text-secondary"><?php echo "$manufacturer"; ?></code></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">7. Form Coding</div>
                            <div class="col-md-12">
                                <ol>
                                    <li><code class="text-secondary"><?php echo "$form_coding_system"; ?></code></li>
                                    <li><code class="text-secondary"><?php echo "$form_coding_code"; ?></code></li>
                                    <li><code class="text-secondary"><?php echo "$form_coding_display"; ?></code></li>
                                </ol>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">8. Ingredient</div>
                            <div class="col-md-12">
                                <ol>
                                    <li><code class="text-secondary"><?php echo "$form_coding_system"; ?></code></li>
                                    <li><code class="text-secondary"><?php echo "$form_coding_code"; ?></code></li>
                                    <li><code class="text-secondary"><?php echo "$form_coding_display"; ?></code></li>
                                </ol>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">9. Extension</div>
                            <div class="col-md-12">
                                <ol>
                                    <li><code class="text-secondary"><?php echo "$extension_url"; ?></code></li>
                                    <li><code class="text-secondary"><?php echo "$valueCodeableConcept_coding_system"; ?></code></li>
                                    <li><code class="text-secondary"><?php echo "$valueCodeableConcept_coding_display"; ?></code></li>
                                    <li><code class="text-secondary"><?php echo "$valueCodeableConcept_coding_code"; ?></code></li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="accordion-panel">
                    <div class="accordion-heading" role="tab" id="headingTree">
                        <h3 class="card-title accordion-title">
                            <a class="accordion-msg waves-effect waves-dark scale_active" data-toggle="collapse" data-parent="#accordion" href="#collapseTree" aria-expanded="true" aria-controls="collapseTree">
                                <dt>C. Data Raw</dt>
                            </a>
                        </h3>
                    </div>
                </div>
                <div id="collapseTree" class="panel-collapse in collapse" role="tabpanel" aria-labelledby="headingTree" style="">
                    <div class="accordion-content accordion-desc">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <textarea class="form-control">
                                    <?php echo "$newJsonString"; ?>
                                </textarea>
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
?>