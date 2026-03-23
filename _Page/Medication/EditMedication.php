<?php
    include "_Config/SimrsFunction.php";
    $organization_id=getDataDetail($Conn,'setting_satusehat','status','Active','organization_id');
    //Setting
    $SettingSatuSehat=getDataDetail($Conn,' setting_satusehat','status','Active','id_setting_satusehat');
    $kfa_url=getDataDetail($Conn,'setting_satusehat','status','Active','kfa_url');
    if(empty($_GET['id_obat_medication'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center text-danger">';
        echo '      ID Medication Tidak Boleh Kosong';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_obat_medication=$_GET['id_obat_medication'];
        if (!ctype_digit($id_obat_medication)) {
            echo '<div class="row">';
            echo '  <div class="col-md-12 text-center text-danger">';
            echo '      ID Medication Tidak Valid';
            echo '  </div>';
            echo '</div>';
        }else{
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
                    $id_obat=getDataDetail($Conn,' obat_medication','id_obat_medication',$id_obat_medication,'id_obat');
                    $id_medication=getDataDetail($Conn,' obat_medication','id_obat_medication',$id_obat_medication,'id_medication');
                    $kode=getDataDetail($Conn,' obat_medication','id_obat_medication',$id_obat_medication,'kode');
                    $nama=getDataDetail($Conn,' obat_medication','id_obat_medication',$id_obat_medication,'nama');
                    $raw_medication=getDataDetail($Conn,' obat_medication','id_obat_medication',$id_obat_medication,'raw_medication');
                    $id_akses=getDataDetail($Conn,' obat_medication','id_obat_medication',$id_obat_medication,'id_akses');
                    $updatetime=getDataDetail($Conn,' obat_medication','id_obat_medication',$id_obat_medication,'updatetime');
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
                    //explode manufacturer
                    $explode_manufacturer=explode('/',$manufacturer);
                    $id_ord_manufacturer=$explode_manufacturer['1'];
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
                    //Detail Obat
                    $nama=getDataDetail($Conn,'obat','id_obat',$id_obat,'nama');
                    $kode=getDataDetail($Conn,'obat','id_obat',$id_obat,'kode');
                    $kelompok=getDataDetail($Conn,'obat','id_obat',$id_obat,'kelompok');
                    $kategori=getDataDetail($Conn,'obat','id_obat',$id_obat,'kategori');
                    $satuan=getDataDetail($Conn,'obat','id_obat',$id_obat,'satuan');
                    $isi=getDataDetail($Conn,'obat','id_obat',$id_obat,'isi');
                    $stok=getDataDetail($Conn,'obat','id_obat',$id_obat,'stok');
                    $harga=getDataDetail($Conn,'obat','id_obat',$id_obat,'harga');
                    $stok_min=getDataDetail($Conn,'obat','id_obat',$id_obat,'stok_min');
                    $keterangan=getDataDetail($Conn,'obat','id_obat',$id_obat,'keterangan');
                    $tanggal=getDataDetail($Conn,'obat','id_obat',$id_obat,'tanggal');
                    $updatetime=getDataDetail($Conn,'obat','id_obat',$id_obat,'updatetime');
                    $HargaBeli = "Rp " . number_format($harga, 0, ',', '.');
                    $strtotime1=strtotime($tanggal);
                    $strtotime2=strtotime($updatetime);
                    $TanggalInput=date('d/m/Y H:i',$strtotime1);
                    $UpdateTime=date('d/m/Y H:i',$strtotime2);
?>
<div class="row">
    <div class="col-md-12">
        <form action="javascript:void(0);" id="ProsesEditMedication">
            <div class="card table-card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-10 mb-2">
                            <h4 class="card-title">
                                <i class="ti ti-pencil"></i> Edit Medication
                            </h4>
                        </div>
                        <div class="col-md-2 mb-2">
                            <a href="index.php?Page=Medication" class="btn btn-sm btn-block btn-secondary btn-round">
                                <i class="ti ti-angle-left text-white"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3 sub-title">
                        <div class="col-md-8 mb-3"><dt>A. Detail Informasi Obat/Alkes</dt></div>
                        <!-- <div class="col-md-4 mb-3 text-right">
                            <a href="javascript:void(0);" class="text-success" data-toggle="modal" data-target="#ModalPilihObat2">
                                <i class="ti ti-new-window"></i> Ganti Item Obat
                            </a>
                        </div> -->
                        <div class="col-md-12 mb-3">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="identifier_system">ID Obat Medication</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" readonly id="id_obat_medication" name="id_obat_medication" class="form-control" value="<?php echo "$id_obat_medication "; ?>">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="identifier_value">ID Medication</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" readonly id="id_medication" name="id_medication" class="form-control" value="<?php echo "$id_medication"; ?>">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="id_obat">ID Obat</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" readonly id="id_obat" name="id_obat" class="form-control" value="<?php echo "$id_obat "; ?>">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="kode">Kode Obat/Alkes</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" readonly id="kode" name="kode" class="form-control" value="<?php echo "$kode"; ?>">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="nama">Nama Obat/Alkes</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text"readonly id="nama" name="nama" class="form-control" value="<?php echo "$nama"; ?>">
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row mb-3 sub-title">
                        <div class="col-md-12 mb-3"><dt>B. Identifier</dt></div>
                        <div class="col-md-12 mb-3">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="identifier_system">ID Organization</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" id="identifier_system" name="identifier_system" class="form-control" value="<?php echo "$organization_id"; ?>">
                                    <small>Organization ID Sesuai IHS induk</small>
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
                                    <input type="text" id="identifier_value" name="identifier_value" class="form-control" value="<?php echo "$kode"; ?>">
                                    <small>Kode Obat/Alkes</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3 sub-title">
                        <div class="col-md-8 mb-3">
                            <dt>C. Coding System</dt>
                        </div>
                        <div class="col-md-4 mb-3 text-right">
                            <a href="javascript:void(0);" class="text-success" data-toggle="modal" data-target="#ModalPencarianKfa2" data-id="<?php echo "$id_obat"; ?>">
                                <i class="ti ti-new-window"></i> Pilih Referensi KFA
                            </a>
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
                                    <input type="text" id="code_coding_code" name="code_coding_code" class="form-control" value="<?php echo "$coding_code"; ?>">
                                    <small>Kode sesuai KFA</small>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="code_coding_display">Display</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" id="code_coding_display" name="code_coding_display" class="form-control" value="<?php echo "$coding_display"; ?>">
                                    <small>Nama Obat/Alkes sesuai KFA</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3 sub-title">
                        <div class="col-md-12 mb-3">
                            <dt>D. Status</dt>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="status">Status Ketersediaan</label>
                                </div>
                                <div class="col-md-8">
                                    <select name="status" id="status" class="form-control">
                                        <option <?php if($status==""){echo "selected";} ?> value="">Pilih</option>
                                        <option <?php if($status=="active"){echo "selected";} ?> value="active">Obat tersedia untuk digunakan</option>
                                        <option <?php if($status=="inactive"){echo "selected";} ?> value="inactive">Obat tidak tersedia</option>
                                        <option <?php if($status=="entered-in-error"){echo "selected";} ?> value="entered-in-error">Obat yang dimasukkan salah</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3 sub-title">
                        <div class="col-md-8 mb-3">
                            <dt>E. Manufacturer</dt>
                        </div>
                        <div class="col-md-4 mb-3 text-right">
                            <a href="javascript:void(0);" class="text-success" data-toggle="modal" data-target="#ModalCariOrganization">
                                <i class="ti ti-new-window"></i> ID Org Manufacturer
                            </a>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="manufacturer">Manufacturer</label><br>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" id="manufacturer" name="manufacturer" class="form-control" value="<?php echo "$id_ord_manufacturer"; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3 sub-title">
                        <div class="col-md-8 mb-3">
                            <dt>E. Medication Form</dt>
                        </div>
                        <div class="col-md-4 mb-3 text-right">
                            <a href="javascript:void(0);" class="text-success" data-toggle="modal" data-target="#ModalCariMedicationForm">
                                <i class="ti ti-new-window"></i> Referensi Medication Form
                            </a>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="form_coding_system">System</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" id="form_coding_system" name="form_coding_system" class="form-control" value="<?php echo $form_coding_system;?>">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="form_coding_code">Code</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" id="form_coding_code" name="form_coding_code" class="form-control" value="<?php echo "$form_coding_code"; ?>">
                                    <small>Kode sediaan obat (Dosage Form) sesuai KFA</small>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="form_coding_display">Display</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" id="form_coding_display" name="form_coding_display" class="form-control" value="<?php echo "$form_coding_display"; ?>">
                                    <small>Bentuk sediaan obat (Dosage Form)</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3 sub-title">
                        <div class="col-md-8 mb-3">
                            <dt>F. Ingredient</dt>
                        </div>
                        <div class="col-md-4 mb-3 text-right">
                            <a href="javascript:void(0);" class="text-success" data-toggle="modal" data-target="#ModalTambahIngredient">
                                <i class="ti ti-plus"></i> Add Ingredient
                            </a>
                        </div>
                        <div class="col-md-12 mb-3">
                            Wajib diisi apabila data yang dikirimkan adalah obat racikan
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="row" id="FormMultiIngredient">
                                <!-- Form Ingridient di tampilkan disini -->
                                <?php 
                                    if(!empty(count($ingredient))){ 
                                        $IdRow=1;
                                        foreach($ingredient as $ingredient_list){
                                            $isActive=$ingredient_list['isActive'];
                                            $itemCodeableConcept_code=$ingredient_list['itemCodeableConcept']['coding']['0']['code'];
                                            $itemCodeableConcept_display=$ingredient_list['itemCodeableConcept']['coding']['0']['display'];
                                            $itemCodeableConcept_system=$ingredient_list['itemCodeableConcept']['coding']['0']['system'];
                                            $numerator_value=$ingredient_list['strength']['numerator']['value'];
                                            $numerator_code=$ingredient_list['strength']['numerator']['code'];
                                            $denominator_value=$ingredient_list['strength']['denominator']['value'];
                                            $denominator_code=$ingredient_list['strength']['denominator']['code'];
                                ?>
                                            <div class="col-4 mb-3" id="BarisIngridient<?php echo $IdRow; ?>">
                                                <input type="hidden" name="itemCodeableConceptDisplay[]" value="<?php echo "$itemCodeableConcept_display"; ?>">
                                                <input type="hidden" name="itemCodeableConceptCode[]" value="<?php echo "$itemCodeableConcept_code"; ?>">
                                                <input type="hidden" name="isActive[]" value="<?php echo "$isActive"; ?>">
                                                <input type="hidden" name="strength_numerator_value[]" value="<?php echo "$numerator_value"; ?>">
                                                <input type="hidden" name="strength_numerator_code[]" value="<?php echo "$numerator_code"; ?>">
                                                <input type="hidden" name="strength_denominator_value[]" value="<?php echo "$denominator_value"; ?>">
                                                <input type="hidden" name="strength_denominator_code[]" value="<?php echo "$denominator_code"; ?>">
                                                <small>
                                                    <ul>
                                                        <li>Name : <code><?php echo "$itemCodeableConcept_display"; ?></code></li>
                                                        <li>Code : <code><?php echo "$itemCodeableConcept_code"; ?></code></li>
                                                        <li>Is Active : <code><?php echo "$isActive"; ?></code></li>
                                                        <li>Numerator : <code><?php echo "$numerator_value $numerator_code"; ?></code></li>
                                                        <li>Denominator : <code><?php echo "$denominator_value $denominator_code"; ?></code></li>
                                                    </ul>
                                                    <a href="javascript:void(0);" id="HapusBarisIngridient<?php echo $IdRow; ?>" class="text-danger HapusBarisIngridient" value="<?php echo $IdRow; ?>">
                                                        <i class="ti ti-close"></i> Hapus
                                                    </a>
                                                </small>
                                            </div>
                                            <script>
                                                $('#HapusBarisIngridient<?php echo $IdRow; ?>').click(function(){
                                                    $('#BarisIngridient<?php echo $IdRow; ?>').remove();
                                                });
                                            </script>
                                <?php 
                                            $IdRow++;
                                        }
                                    } 
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3 sub-title">
                        <div class="col-md-4 mb-3">
                            <dt>G. Extension</dt>
                        </div>
                        <div class="col-md-8 mb-3">
                            <small>
                                Informasi apakah obat yang diresepkan atau dikeluarkan merupakan obat non-racikan, obat racikan 
                                dengan instruksi berikan dalam dosis demikian/ d.t.d, atau obat racikan non-d.t.d.
                            </small>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="extension_type">Extension Type</label>
                                </div>
                                <div class="col-md-8">
                                    <select name="extension_type" id="extension_type" class="form-control">
                                        <option <?php if($valueCodeableConcept_coding_code==""){echo "selected";} ?> value="">Pilih</option>
                                        <option <?php if($valueCodeableConcept_coding_code=="NC"){echo "selected";} ?> value="NC">Obat Non Racikan</option>
                                        <option <?php if($valueCodeableConcept_coding_code=="SD"){echo "selected";} ?> value="SD">Obat racikan dengan instruksi berikan dalam dosis demikian/d.t.d</option>
                                        <option <?php if($valueCodeableConcept_coding_code=="EP"){echo "selected";} ?> value="EP">Obat racikan non-d.t.d</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="extension_url">Extension URL</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" id="extension_url" name="extension_url" class="form-control" value="<?php echo $extension_url; ?>">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="extension_system">Extension System</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" id="extension_system" name="extension_system" class="form-control" value="<?php echo $valueCodeableConcept_coding_system; ?>">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="extension_code">Code</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" id="extension_code" name="extension_code" class="form-control" value="<?php echo $valueCodeableConcept_coding_code; ?>">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="extension_display">Display</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" id="extension_display" name="extension_display" class="form-control" value="<?php echo $valueCodeableConcept_coding_display; ?>">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12" id="NotifikasiEditMedication">
                                    Pastikan Data Medication Yang Anda Input Sudah Benar
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-md btn-primary btn-round mb-3 ml-3">
                        <i class="ti ti-save"></i> Update Medication
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php }}}} ?>