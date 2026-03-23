<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $now=date('Y-m-d H:i:s');
    $milisecond=strtotime($now);
    $organization_id=getDataDetail($Conn,'setting_satusehat','status','Active','organization_id');
    //Setting
    $SettingSatuSehat=getDataDetail($Conn,' setting_satusehat','status','Active','id_setting_satusehat');
    $kfa_url=getDataDetail($Conn,'setting_satusehat','status','Active','kfa_url');
    $Token=GenerateTokenSatuSehat($Conn);
    //Tangkap id_kunjungan
    if(empty($_POST['GetIdObat'])){
        echo '<div class="row mb-3">';
        echo '  <div class="col-md-12 text-danger text-center">';
        echo '      ID Obat Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        $GetIdObat=$_POST['GetIdObat'];
        //Explode
        $explode=explode('|',$GetIdObat);
        $id_obat=$explode[0];
        $kfa_code=$explode[1];
        //Buka Data KFA
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
                    <div class="row mb-3 sub-title">
                        <div class="col-md-12 mb-3">
                            <dt>B. Identifier</dt>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="identifier_system">ID Organization</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" readonly id="identifier_system" name="identifier_system" class="form-control" value="<?php echo "$organization_id"; ?>">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="identifier_use">Use</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" readonly id="identifier_use" name="identifier_use" class="form-control" value="official">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="identifier_value">value</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" readonly id="identifier_value" name="identifier_value" class="form-control" value="<?php echo "$milisecond-$id_obat"; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3 sub-title">
                        <div class="col-md-12 mb-3">
                            <dt>C. Coding System (Item Obat)</dt>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="code_coding_system">System</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" id="code_coding_system" name="code_coding_system" class="form-control" value="http://sys-ids.kemkes.go.id/kfa">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="code_coding_code">Code</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" id="code_coding_code" name="code_coding_code" class="form-control" value="<?php echo "$kfa_code"; ?>">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="code_coding_display">Display</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" id="code_coding_display" name="code_coding_display" class="form-control" value="<?php echo "$name"; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3 sub-title">
                        <div class="col-md-12 mb-3">
                            <dt>D. Status & Manufacturer</dt>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="status">Status</label>
                                </div>
                                <div class="col-md-8">
                                    <select name="status" id="status" class="form-control">
                                        <option value="">Pilih</option>
                                        <option value="active">Obat tersedia untuk digunakan</option>
                                        <option value="inactive">Obat tidak tersedia</option>
                                        <option value="entered-in-error">Obat yang dimasukkan salah</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="manufacturer">Manufacturer</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" id="manufacturer" name="manufacturer" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3 sub-title">
                        <div class="col-md-12 mb-3">
                            <dt>D. Medication Form</dt>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="form_coding_system">System</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" id="form_coding_system" name="form_coding_system" class="form-control" value="http://terminology.kemkes.go.id/CodeSystem/medication-form">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="form_coding_code">Code</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" id="form_coding_code" name="form_coding_code" class="form-control" value="<?php echo "$dosage_form_code"; ?>">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="form_coding_display">Display</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" id="form_coding_display" name="form_coding_display" class="form-control" value="<?php echo "$dosage_form_name"; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3 sub-title">
                        <div class="col-md-12 mb-3">
                            <dt>E. Ingredient</dt>
                        </div>
                        <div class="col-md-12 mb-3">
                            <dt>E.1 Item Codeable Concept</dt>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="itemCodeableConcept_coding_system">System</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" id="itemCodeableConcept_coding_system" name="itemCodeableConcept_coding_system" class="form-control" value="http://sys-ids.kemkes.go.id/kfa">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="itemCodeableConcept_coding_code">Code</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" id="itemCodeableConcept_coding_code" name="itemCodeableConcept_coding_code" class="form-control">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="itemCodeableConcept_coding_display">Display</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" id="itemCodeableConcept_coding_display" name="itemCodeableConcept_coding_display" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <dt>E.2 Ingredient strength</dt>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="ingredient_isActive">Is Active?</label>
                                </div>
                                <div class="col-md-8">
                                    <select name="ingredient_isActive" id="ingredient_isActive" class="form-control">
                                        <option value="">Pilih</option>
                                        <option <?php if($active==true){echo "selected";} ?> value="true">True</option>
                                        <option value="false">False</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <dt>E.2.1 Numerator</dt>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="numerator_value">Value</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" id="numerator_value" name="numerator_value" class="form-control" value="">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="numerator_system">System</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" id="numerator_system" name="numerator_system" class="form-control" value="http://unitsofmeasure.org">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="numerator_code">Code</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" id="numerator_code" name="numerator_code" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <dt>E.2.2 Denominator</dt>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="denominator_value">Value</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" id="denominator_value" name="denominator_value" class="form-control" value="">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="denominator_system">System</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" id="denominator_system" name="denominator_system" class="form-control" value="http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="denominator_code">Code</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" id="denominator_code" name="denominator_code" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
<?php 
                }
            }
        }
    }
?>