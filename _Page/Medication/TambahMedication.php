<?php
    include "_Config/SimrsFunction.php";
    $organization_id=getDataDetail($Conn,'setting_satusehat','status','Active','organization_id');
    //Setting
    $SettingSatuSehat=getDataDetail($Conn,' setting_satusehat','status','Active','id_setting_satusehat');
    $kfa_url=getDataDetail($Conn,'setting_satusehat','status','Active','kfa_url');
    if(empty($_GET['id'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center text-danger">';
        echo '      ID Obat Tidak Boleh Kosong';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_obat=$_GET['id'];
        if (!ctype_digit($id_obat)) {
            echo '<div class="row">';
            echo '  <div class="col-md-12 text-center text-danger">';
            echo '      ID Obat Tidak Valid';
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
                    if(!empty($_GET['kfa_code'])){
                        $kfa_code=$_GET['kfa_code'];
                        if (!ctype_digit($kfa_code)) {
                            $ValidasiKfaCode="Tidak Valid";
                        }else{
                            //Buka Detail KFA
                            $GetDetailKfa=GetDetailKfa($kfa_url,$Token,$kfa_code);
                            if(empty($GetDetailKfa)){
                                $ValidasiKfaCode="No Response";
                            }else{
                                //Parameter Validasi
                                $ValidasiKfaCode="Valid";
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
                                //controlled_drug
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
                                $active_ingredients=$result['active_ingredients'];
                                $active_ingredients_count=count($active_ingredients);
                            }
                        }
                    }else{
                        $kfa_code="";
                        $ValidasiKfaCode="Valid";
                        $name="";
                        $manufacturer="";
                        $dosage_form_code="";
                        $dosage_form_name="";
                        $active_ingredients="";
                        $active_ingredients_count="";
                    }
                    if($ValidasiKfaCode=="Tidak Valid"){
                        echo '<div class="row">';
                        echo '  <div class="col-md-12 text-center text-danger">';
                        echo '      Kode KFA Tidak Valid';
                        echo '  </div>';
                        echo '</div>';
                    }else{
                        if($ValidasiKfaCode=="No Response"){
                            echo '<div class="row">';
                            echo '  <div class="col-md-12 text-center text-danger">';
                            echo '      Tidak ada response dari satu sehat, silahkan kembali';
                            echo '  </div>';
                            echo '</div>';
                        }else{
?>
<div class="row">
    <div class="col-md-12">
        <form action="javascript:void(0);" id="ProsesTambahMedication">
            <div class="card table-card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-10 mb-2">
                            <h4 class="card-title">
                                <i class="ti ti-pencil"></i> Tambah Medication
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
                        <div class="col-md-4 mb-3 text-right">
                            <a href="javascript:void(0);" class="text-success" data-toggle="modal" data-target="#ModalPilihObat">
                                <i class="ti ti-new-window"></i> Ganti Item Obat 
                            </a>
                        </div>
                        <?php
                            echo '  <div class="col-md-4">';
                            echo '      <ul class="ml-3">';
                            echo '          <li>Nama : <code class="text-secondary">'.$nama.'</code></li>';
                            echo '          <li>Kode : <code class="text-secondary" id="GetKodeObat">'.$kode.'</code></li>';
                            echo '          <li>Kategori : <code class="text-secondary">'.$kategori.'</code></li>';
                            echo '      </ul>';
                            echo '  </div>';
                            echo '  <div class="col-md-4">';
                            echo '      <ul class="ml-3">';
                            echo '          <li>Kelompok : <code class="text-secondary">'.$kelompok.'</code></li>';
                            echo '          <li>Kategori : <code class="text-secondary">'.$kategori.'</code></li>';
                            echo '          <li>Satuan : <code class="text-secondary">'.$satuan.'</code></li>';
                            echo '      </ul>';
                            echo '  </div>';
                            echo '  <div class="col-md-4">';
                            echo '      <ul class="ml-3">';
                            echo '          <li>Stok : <code class="text-secondary">'.$stok.' '.$satuan.'</code></li>';
                            echo '          <li>Harga : <code class="text-secondary">'.$HargaBeli.'</code></li>';
                            echo '          <li>Update : <code class="text-secondary">'.$UpdateTime.'</code></li>';
                            echo '      </ul>';
                            echo '  </div>';
                        ?>
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
                            <dt>C. Pilih Referensi KFA</dt>
                        </div>
                        <div class="col-md-4 mb-3 text-right">
                            <a href="javascript:void(0);" class="text-success" data-toggle="modal" data-target="#ModalPencarianKfa" data-id="<?php echo "$id_obat"; ?>">
                                <i class="ti ti-new-window"></i> Pilih Referensi KFA
                            </a>
                        </div>
                        <div class="col-md-12 mb-3">
                            <?php
                                if(!empty($_GET['kfa_code'])){
                                    echo '<div class="row ml-3">';
                                    echo '  <div class="col-md-4">';
                                    echo '      <ul>';
                                    echo '          <li>Name : <code class="text-secondary">'.$name.'</code></li>';
                                    echo '          <li>KFA Code : <code class="text-secondary">'.$kfa_code.'</code></li>';
                                    echo '          <li>NIE : <code class="text-secondary">'.$nie.'</code></li>';
                                    echo '      </ul>';
                                    echo '  </div>';
                                    echo '  <div class="col-md-4">';
                                    echo '      <ul>';
                                    echo '          <li>State : <code class="text-secondary">'.$state.'</code></li>';
                                    echo '          <li>Update : <code class="text-secondary">'.$updated_at.'</code></li>';
                                    echo '          <li>Active : <code class="text-secondary">'.$active.'</code></li>';
                                    echo '      </ul>';
                                    echo '  </div>';
                                    echo '  <div class="col-md-4">';
                                    echo '      <ul>';
                                    echo '          <li>Dosage Code : <code class="text-secondary">'.$dosage_form_code.'</code></li>';
                                    echo '          <li>Dosage Name : <code class="text-secondary">'.$dosage_form_name.'</code></li>';
                                    echo '          <li>Manufacture : <code class="text-secondary" id="ManufacturerForm">'.$manufacturer.'</code></li>';
                                    echo '          <li><a href="javascript:void(0);" class="text-success" data-toggle="modal" data-target="#ModalDetailIngridient" data-id="'.$kfa_code.'"><small>Referensi Ingredient..</small></a></li>';
                                    echo '      </ul>';
                                    echo '  </div>';
                                    echo '</div>';
                                }else{
                                    echo '<div class="row">';
                                    echo '  <div class="col-md-12 text-center text-danger">';
                                    echo '      Belum Ada Referensi KFA yang dipilih';
                                    echo '  </div>';
                                    echo '</div>';
                                }
                            ?>
                        </div>
                    </div>
                    <div class="row mb-3 sub-title">
                        <div class="col-md-12 mb-3">
                            <dt>C. Coding System</dt>
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
                                    <small>Kode sesuai KFA</small>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="code_coding_display">Display</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" id="code_coding_display" name="code_coding_display" class="form-control" value="<?php echo "$name"; ?>">
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
                                        <option value="">Pilih</option>
                                        <option value="active">Obat tersedia untuk digunakan</option>
                                        <option value="inactive">Obat tidak tersedia</option>
                                        <option value="entered-in-error">Obat yang dimasukkan salah</option>
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
                                    <input type="text" id="manufacturer" name="manufacturer" class="form-control">
                                    <small><?php echo "$manufacturer"; ?></small>
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
                                    <input type="text" id="form_coding_system" name="form_coding_system" class="form-control" value="http://terminology.kemkes.go.id/CodeSystem/medication-form">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="form_coding_code">Code</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" id="form_coding_code" name="form_coding_code" class="form-control" value="<?php echo "$dosage_form_code"; ?>">
                                    <small>Kode sediaan obat (Dosage Form) sesuai KFA</small>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="form_coding_display">Display</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" id="form_coding_display" name="form_coding_display" class="form-control" value="<?php echo "$dosage_form_name"; ?>">
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
                                        <option value="">Pilih</option>
                                        <option value="NC">Obat Non Racikan</option>
                                        <option value="SD">Obat racikan dengan instruksi berikan dalam dosis demikian/d.t.d</option>
                                        <option value="EP">Obat racikan non-d.t.d</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="extension_url">Extension URL</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" id="extension_url" name="extension_url" class="form-control" value="https://fhir.kemkes.go.id/r4/StructureDefinition/MedicationType">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="extension_system">Extension System</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" id="extension_system" name="extension_system" class="form-control" value="http://terminology.kemkes.go.id/CodeSystem/medication-type">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="extension_code">Code</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" id="extension_code" name="extension_code" class="form-control">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="extension_display">Display</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" id="extension_display" name="extension_display" class="form-control">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12" id="NotifikasiTambahMedication">
                                    Pastikan Data Medication Yang Anda Input Sudah Benar
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-md btn-primary btn-round mb-3 ml-3">
                        <i class="ti ti-check"></i> Creat Medication
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php }}}}}} ?>