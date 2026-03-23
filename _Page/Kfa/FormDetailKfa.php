<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap kfa_code
    if(empty($_POST['kfa_code'])){
        echo '<div class="row mb-3">';
        echo '  <div class="col-md-12 text-center text-danger">';
        echo '      Kode KFA Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        $kfa_code=$_POST['kfa_code'];
        //Setting
        $SettingSatuSehat=getDataDetail($Conn,' setting_satusehat','status','Active','id_setting_satusehat');
        $kfa_url=getDataDetail($Conn,'setting_satusehat','status','Active','kfa_url');
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
                $GetDetailKfa=GetDetailKfa($kfa_url,$Token,$kfa_code);
                if(empty($GetDetailKfa)){
                    echo '  <div class="row">';
                    echo '      <div class="col-md-12 text-center text-danger">';
                    echo '          Tidak ada response dari satu sehat';
                    echo '      </div>';
                    echo '  </div>';
                }else{
                    $data = json_decode($GetDetailKfa, true);
                    $search_code=$data['search_code'];
                    $search_identifier=$data['search_identifier'];
                    $result=$data['result'];
                    $name=$result['name'];
                    $kfa_code=$result['kfa_code'];
                    $active=$result['active'];
                    $state=$result['state'];
                    $image=$result['image'];
                    $updated_at=$result['updated_at'];
                    //farmalkes_type
                    $farmalkes_type=$result['farmalkes_type'];
                    $farmalkes_type_code=$farmalkes_type['code'];
                    $farmalkes_type_name=$farmalkes_type['name'];
                    $farmalkes_type_group=$farmalkes_type['group'];
                    //ucum
                    $ucum=$result['ucum'];
                    $ucum_name=$ucum['name'];
                    $ucum_cs_code=$ucum['cs_code'];
                    //uom
                    $uom=$result['uom'];
                    $uom_name=$uom['name'];
                    //dosage_form
                    $dosage_form=$result['dosage_form'];
                    $dosage_form_code=$dosage_form['code'];
                    $dosage_form_name=$dosage_form['name'];
                    //dosage_form
                    $controlled_drug=$result['controlled_drug'];
                    $controlled_drug_code=$controlled_drug['code'];
                    $controlled_drug_name=$controlled_drug['name'];
                    //rute_pemberian
                    $rute_pemberian=$result['rute_pemberian'];
                    $rute_pemberian_code=$rute_pemberian['code'];
                    $rute_pemberian_name=$rute_pemberian['name'];
                    //atc_l1
                    $atc_l1=$result['atc_l1'];
                    $atc_l1_code=$atc_l1['code'];
                    $atc_l1_name=$atc_l1['name'];
                    $atc_l1_level=$atc_l1['level'];
                    $atc_l1_comment=$atc_l1['comment'];
                    $atc_l1_parent_code=$atc_l1['parent_code'];
                    //atc_l2
                    $atc_l2=$result['atc_l2'];
                    $atc_l2_code=$atc_l2['code'];
                    $atc_l2_name=$atc_l2['name'];
                    $atc_l2_level=$atc_l2['level'];
                    $atc_l2_comment=$atc_l2['comment'];
                    $atc_l2_parent_code=$atc_l2['parent_code'];
                    //atc_l3
                    $atc_l3=$result['atc_l3'];
                    $atc_l3_code=$atc_l3['code'];
                    $atc_l3_name=$atc_l3['name'];
                    $atc_l3_level=$atc_l3['level'];
                    $atc_l3_comment=$atc_l3['comment'];
                    $atc_l3_parent_code=$atc_l3['parent_code'];
                    //atc_l4
                    $atc_l4=$result['atc_l4'];
                    $atc_l4_code=$atc_l4['code'];
                    $atc_l4_name=$atc_l4['name'];
                    $atc_l4_level=$atc_l4['level'];
                    $atc_l4_comment=$atc_l4['comment'];
                    $atc_l4_parent_code=$atc_l4['parent_code'];
                    //atc_l5
                    $atc_l5=$result['atc_l5'];
                    $atc_l5_code=$atc_l5['code'];
                    $atc_l5_name=$atc_l5['name'];
                    $atc_l5_level=$atc_l5['level'];
                    $atc_l5_comment=$atc_l5['comment'];
                    $atc_l5_parent_code=$atc_l5['parent_code'];
                    //Lainnya
                    $description=$result['description'];
                    $indication=$result['indication'];
                    $warning=$result['warning'];
                    $side_effect=$result['side_effect'];
                    $produksi_buatan=$result['produksi_buatan'];
                    $nie=$result['nie'];
                    $nama_dagang=$result['nama_dagang'];
                    $manufacturer=$result['manufacturer'];
                    $registrar=$result['registrar'];
                    $generik=$result['generik'];
                    //Json prety
                    $newJsonString = json_encode($data, JSON_PRETTY_PRINT);


?>
    <div class="row mb-3">
        <div class="col-md-12">
            <div id="accordion" role="tablist" aria-multiselectable="true">
                <div class="accordion-panel">
                    <div class="accordion-heading" role="tab" id="headingOne">
                        <h3 class="card-title accordion-title">
                            <a class="accordion-msg waves-effect waves-dark scale_active collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                <dt>A. Informasi Umum</dt>
                            </a>
                        </h3>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse show" role="tabpanel" aria-labelledby="headingOne" style="">
                        <div class="accordion-content accordion-desc">
                            <ol>
                                <li class="mb-2">
                                    Search Code : <code class="text-secondary"><?php echo $search_code; ?></code>
                                </li>
                                <li class="mb-2">
                                    Search Identifier : <code class="text-secondary"><?php echo $search_identifier; ?></code>
                                </li>
                                <li class="mb-2">
                                    Name : <code class="text-secondary"><?php echo $name; ?></code>
                                </li>
                                <li class="mb-2">
                                    KFA Code : <code class="text-secondary"><?php echo $kfa_code; ?></code>
                                </li>
                                <li class="mb-2">
                                    Active : <code class="text-secondary"><?php echo $active; ?></code>
                                </li>
                                <li class="mb-2">
                                    State : <code class="text-secondary"><?php echo $state; ?></code>
                                </li>
                                <li class="mb-2">
                                    Produk Buatan : <code class="text-secondary"><?php echo $produksi_buatan; ?></code>
                                </li>
                                <li class="mb-2">
                                    NIE : <code class="text-secondary"><?php echo $nie; ?></code>
                                </li>
                                <li class="mb-2">
                                    Nama Dagang : <code class="text-secondary"><?php echo $nama_dagang; ?></code>
                                </li>
                                <li class="mb-2">
                                    Manufacturer : <code class="text-secondary"><?php echo $manufacturer; ?></code>
                                </li>
                                <li class="mb-2">
                                    Registrar : <code class="text-secondary"><?php echo $registrar; ?></code>
                                </li>
                                <li class="mb-2">
                                    Generik : <code class="text-secondary"><?php echo $generik; ?></code>
                                </li>
                                <li class="mb-2">
                                    Updated At : <code class="text-secondary"><?php echo $updated_at; ?></code>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="accordion-panel">
                <div class="accordion-heading" role="tab" id="headingTwo">
                    <h3 class="card-title accordion-title">
                        <a class="accordion-msg waves-effect waves-dark scale_active collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            <dt>B. Farmalkes Type</dt>
                        </a>
                    </h3>
                </div>
                <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                    <div class="accordion-content accordion-desc">
                        <ol>
                            <li class="mb-2">
                                Code : <code class="text-secondary"><?php echo $farmalkes_type_code; ?></code>
                            </li>
                            <li class="mb-2">
                                Name : <code class="text-secondary"><?php echo $farmalkes_type_name; ?></code>
                            </li>
                            <li class="mb-2">
                                Group : <code class="text-secondary"><?php echo $farmalkes_type_group; ?></code>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="accordion-panel">
                <div class=" accordion-heading" role="tab" id="headingThree">
                    <h3 class="card-title accordion-title">
                        <a class="accordion-msg waves-effect waves-dark scale_active collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            <dt>C. UCUM</dt>
                        </a>
                    </h3>
                </div>
                <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                    <div class="accordion-content accordion-desc">
                        <ol>
                            <li class="mb-2">
                                Name : <code class="text-secondary"><?php echo $ucum_name; ?></code>
                            </li>
                            <li class="mb-2">
                                CS Code : <code class="text-secondary"><?php echo $ucum_cs_code; ?></code>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="accordion-panel">
                <div class=" accordion-heading" role="tab" id="headingFour">
                    <h3 class="card-title accordion-title">
                        <a class="accordion-msg waves-effect waves-dark scale_active collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                            <dt>D. UOM & Dosage Form</dt>
                        </a>
                    </h3>
                </div>
                <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
                    <div class="accordion-content accordion-desc">
                        <ol>
                            <li class="mb-2">
                                Name : <code class="text-secondary"><?php echo $uom_name; ?></code>
                            </li>
                            <li class="mb-2">
                                Dosage Code : <code class="text-secondary"><?php echo $dosage_form_code; ?></code>
                            </li>
                            <li class="mb-2">
                                Dosage Name : <code class="text-secondary"><?php echo $dosage_form_name; ?></code>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="accordion-panel">
                <div class=" accordion-heading" role="tab" id="headingFive">
                    <h3 class="card-title accordion-title">
                        <a class="accordion-msg waves-effect waves-dark scale_active collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                            <dt>E. Rute Pemberian</dt>
                        </a>
                    </h3>
                </div>
                <div id="collapseFive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFive">
                    <div class="accordion-content accordion-desc">
                        <ol>
                            <li class="mb-2">
                                Name : <code class="text-secondary"><?php echo $rute_pemberian_name; ?></code>
                            </li>
                            <li class="mb-2">
                                Code : <code class="text-secondary"><?php echo $rute_pemberian_code; ?></code>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="accordion-panel">
                <div class=" accordion-heading" role="tab" id="headingSix">
                    <h3 class="card-title accordion-title">
                        <a class="accordion-msg waves-effect waves-dark scale_active collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                            <dt>F. ATC</dt>
                        </a>
                    </h3>
                </div>
                <div id="collapseSix" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSix">
                    <div class="accordion-content accordion-desc">
                        <ol>
                            <li class="mb-2">
                                <dt class="mb-2">ATC l1</dt>
                                <ul>
                                    <li class="mb-2">
                                        Code : <code class="text-secondary"><?php echo $atc_l1_code; ?></code>
                                    </li>
                                    <li class="mb-2">
                                        Name : <code class="text-secondary"><?php echo $atc_l1_name; ?></code>
                                    </li>
                                    <li class="mb-2">
                                        Level : <code class="text-secondary"><?php echo $atc_l1_level; ?></code>
                                    </li>
                                    <li class="mb-2">
                                        Comment : <code class="text-secondary"><?php echo $atc_l1_comment; ?></code>
                                    </li>
                                    <li class="mb-2">
                                        Parent Code : <code class="text-secondary"><?php echo $atc_l1_parent_code; ?></code>
                                    </li>
                                </ul>
                            </li>
                            <li class="mb-2">
                                <dt class="mb-2">ATC l2</dt>
                                <ul>
                                    <li class="mb-2">
                                        Code : <code class="text-secondary"><?php echo $atc_l2_code; ?></code>
                                    </li>
                                    <li class="mb-2">
                                        Name : <code class="text-secondary"><?php echo $atc_l2_name; ?></code>
                                    </li>
                                    <li class="mb-2">
                                        Level : <code class="text-secondary"><?php echo $atc_l2_level; ?></code>
                                    </li>
                                    <li class="mb-2">
                                        Comment : <code class="text-secondary"><?php echo $atc_l2_comment; ?></code>
                                    </li>
                                    <li class="mb-2">
                                        Parent Code : <code class="text-secondary"><?php echo $atc_l2_parent_code; ?></code>
                                    </li>
                                </ul>
                            </li>
                            <li class="mb-2">
                                <dt class="mb-2">ATC l3</dt>
                                <ul>
                                    <li class="mb-2">
                                        Code : <code class="text-secondary"><?php echo $atc_l3_code; ?></code>
                                    </li>
                                    <li class="mb-2">
                                        Name : <code class="text-secondary"><?php echo $atc_l3_name; ?></code>
                                    </li>
                                    <li class="mb-2">
                                        Level : <code class="text-secondary"><?php echo $atc_l3_level; ?></code>
                                    </li>
                                    <li class="mb-2">
                                        Comment : <code class="text-secondary"><?php echo $atc_l3_comment; ?></code>
                                    </li>
                                    <li class="mb-2">
                                        Parent Code : <code class="text-secondary"><?php echo $atc_l3_parent_code; ?></code>
                                    </li>
                                </ul>
                            </li>
                            <li class="mb-2">
                                <dt class="mb-2">ATC l4</dt>
                                <ul>
                                    <li class="mb-2">
                                        Code : <code class="text-secondary"><?php echo $atc_l4_code; ?></code>
                                    </li>
                                    <li class="mb-2">
                                        Name : <code class="text-secondary"><?php echo $atc_l4_name; ?></code>
                                    </li>
                                    <li class="mb-2">
                                        Level : <code class="text-secondary"><?php echo $atc_l4_level; ?></code>
                                    </li>
                                    <li class="mb-2">
                                        Comment : <code class="text-secondary"><?php echo $atc_l4_comment; ?></code>
                                    </li>
                                    <li class="mb-2">
                                        Parent Code : <code class="text-secondary"><?php echo $atc_l4_parent_code; ?></code>
                                    </li>
                                </ul>
                            </li>
                            <li class="mb-2">
                                <dt class="mb-2">ATC l5</dt>
                                <ul>
                                    <li class="mb-2">
                                        Code : <code class="text-secondary"><?php echo $atc_l5_code; ?></code>
                                    </li>
                                    <li class="mb-2">
                                        Name : <code class="text-secondary"><?php echo $atc_l5_name; ?></code>
                                    </li>
                                    <li class="mb-2">
                                        Level : <code class="text-secondary"><?php echo $atc_l5_level; ?></code>
                                    </li>
                                    <li class="mb-2">
                                        Comment : <code class="text-secondary"><?php echo $atc_l5_comment; ?></code>
                                    </li>
                                    <li class="mb-2">
                                        Parent Code : <code class="text-secondary"><?php echo $atc_l5_parent_code; ?></code>
                                    </li>
                                </ul>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="accordion-panel">
                <div class=" accordion-heading" role="tab" id="headingSeven">
                    <h3 class="card-title accordion-title">
                        <a class="accordion-msg waves-effect waves-dark scale_active collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                            <dt>G. Deskripsi</dt>
                        </a>
                    </h3>
                </div>
                <div id="collapseSeven" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSeven">
                    <div class="accordion-content accordion-desc">
                        <ol>
                            <li class="mb-2">
                                Description : <br>
                                <code class="text-secondary"><?php echo $description; ?></code>
                            </li>
                            <li class="mb-2">
                                Indication : <br>
                                <code class="text-secondary"><?php echo $indication; ?></code>
                            </li>
                            <li class="mb-2">
                                Warning : <br>
                                <code class="text-secondary"><?php echo $warning; ?></code>
                            </li>
                            <li class="mb-2">
                                Side Effect : <br>
                                <code class="text-secondary"><?php echo $side_effect; ?></code>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="accordion-panel">
                <div class=" accordion-heading" role="tab" id="headingEight">
                    <h3 class="card-title accordion-title">
                        <a class="accordion-msg waves-effect waves-dark scale_active collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                            <dt>H. RAW</dt>
                        </a>
                    </h3>
                </div>
                <div id="collapseEight" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingEight">
                    <div class="accordion-content accordion-desc">
                        <div class="row mb-3 mt-3">
                            <div class="col-md-12">
                                <textarea class="form-control"cols="30" rows="10"><?php echo "$newJsonString"; ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php }}}} ?>