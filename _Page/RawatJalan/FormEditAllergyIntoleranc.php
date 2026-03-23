<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $SettingSatuSehat=getDataDetail($Conn,' setting_satusehat','status','Active','id_setting_satusehat');
    $Token=GenerateTokenSatuSehat($Conn);
    $baseurl_satusehat=getDataDetail($Conn,'setting_satusehat','status','Active','baseurl');
    $organization_id=getDataDetail($Conn,'setting_satusehat','status','Active','organization_id');
    if(empty($_POST['id_kunjungan'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center text-danger">';
        echo '      ID Kunjungan Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_kunjungan=$_POST['id_kunjungan'];
        //Buka data Raw Dari Database
        $raw=getDataDetail($Conn,'kunjungan_alergi','id_kunjungan',$id_kunjungan,'raw');
        $id_pasien=getDataDetail($Conn,'kunjungan_alergi','id_kunjungan',$id_kunjungan,'id_pasien');
        $id_encounter=getDataDetail($Conn,'kunjungan_alergi','id_kunjungan',$id_kunjungan,'id_encounter');
        $id_allergy=getDataDetail($Conn,'kunjungan_alergi','id_kunjungan',$id_kunjungan,'id_allergy');
        if(empty($raw)){
            echo '<div class="row">';
            echo '  <div class="col-md-12 text-center text-danger">';
            echo '      <code>Tidak ada data raw dari database SIMRS</code>';
            echo '  </div>';
            echo '</div>';
        }else{
            $json_decode =json_decode($raw, true);
            if(empty($raw)){
                echo '<div class="row mb-3">';
                echo '  <div class="col-md-12 text-center text-danger">';
                echo '      <code>Tidak Ditemukan ID Satu Sehat Untuk Resource Ini</code>';
                echo '  </div>';
                echo '</div>';
            }else{
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
                $text=$json_decode['code']['text'];
                $JumlahAlergen=count($JenisAlergi);
                $identifier=$json_decode['identifier'];
                $encounter_display=$json_decode['encounter']['display'];
                $encounter_reference=$json_decode['encounter']['reference'];
                $recorder_reference=$json_decode['recorder']['reference'];
                $category=$json_decode['category'][0];
                //Cari id_practitioner
                $explode=explode('/',$recorder_reference);
                $id_practitioner=$explode[1];
?>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="id_allergy">ID. Allergy</label>
        </div>
        <div class="col-md-8">
            <input type="text" readonly name="id_allergy" id="id_allergy" class="form-control" value="<?php echo $id_allergy; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="id_pasien">No.RM</label>
        </div>
        <div class="col-md-8">
            <input type="text" readonly name="id_pasien" id="id_pasien" class="form-control" value="<?php echo $id_pasien; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="id_kunjungan">ID Kunjungan</label>
        </div>
        <div class="col-md-8">
            <input type="text" readonly name="id_kunjungan" id="id_kunjungan" class="form-control" value="<?php echo $id_kunjungan; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="id_encounter">ID Encounter</label>
        </div>
        <div class="col-md-8">
            <input type="text" readonly name="id_encounter" id="id_encounter" class="form-control" value="<?php echo $id_encounter; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="organization_id">ID Organization</label>
        </div>
        <div class="col-md-8">
            <input type="text" readonly name="organization_id" id="organization_id" class="form-control" value="<?php echo $organization_id; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="nama">Nama Pasien</label>
        </div>
        <div class="col-md-8">
            <input type="text" readonly name="nama" id="nama" class="form-control" value="<?php echo $patient_display; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="clinicalStatus">Status Klinis</label><br>
        </div>
        <div class="col-md-8">
            <ul>
                <li>
                    <input type="radio" <?php if($clinicalStatus_coding_code=="active"){echo "checked";} ?> name="clinicalStatus" id="clinicalStatus_active" value="active"> 
                    <label for="clinicalStatus_active">Active</label>
                </li>
                <li>
                    <input type="radio" <?php if($clinicalStatus_coding_code=="inactive"){echo "checked";} ?> name="clinicalStatus" id="clinicalStatus_inactive" value="inactive"> 
                    <label for="clinicalStatus_inactive">Inactive</label>
                </li>
                <li>
                    <input type="radio" <?php if($clinicalStatus_coding_code=="resolved"){echo "checked";} ?> name="clinicalStatus" id="clinicalStatus_resolved" value="resolved"> 
                    <label for="clinicalStatus_resolved">Resolved</label>
                </li>
            </ul>
            
            <div id="accordion" role="tablist" aria-multiselectable="true">
                <div class="accordion-panel">
                    <div class="accordion-heading" role="tab" id="headingOne">
                        <h3 class="card-title accordion-title">
                            <a class="accordion-msg waves-effect waves-dark scale_active text-info" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Lihat Penjelasannya Disini
                            </a>
                        </h3>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                        <div class="accordion-content accordion-desc">
                            <p>
                                <dt>Keterangan :</dt>
                                <ol>
                                    <li>
                                        Active (Subjek saat ini mengalami atau dalam risiko reaksi terhadap suatu zat)
                                    </li>
                                    <li>
                                        Active (Subjek saat ini tidak berisiko reaksi terhadap suatu zat)
                                    </li>
                                    <li>
                                        Active (Reaksi pada zat telah dikaji ulang secara klinis melalui pengujian atau paparan 
                                        ulang dan dianggap sudah tidak ada lagi. Paparan ulang dapat bersifat tidak sengaja, tidak terencana, 
                                        atau di luar dari tatanan klinis)
                                    </li>
                                </ol>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="verificationStatus">Status Verifikasi</label><br>
        </div>
        <div class="col-md-8">
            <ul>
                <li>
                    <input type="radio" <?php if($verificationStatus_code=="unconfirmed"){echo "checked";} ?> name="verificationStatus" id="verificationStatus_unconfirmed" value="unconfirmed"> 
                    <label for="verificationStatus_unconfirmed">Unconfirmed</label>
                </li>
                <li>
                    <input type="radio" <?php if($verificationStatus_code=="confirmed"){echo "checked";} ?> name="verificationStatus" id="verificationStatus_confirmed" value="confirmed"> 
                    <label for="verificationStatus_confirmed">Confirmed</label>
                </li>
                <li>
                    <input type="radio" <?php if($verificationStatus_code=="refuted"){echo "checked";} ?> name="verificationStatus" id="clinicalStatus_refuted" value="refuted"> 
                    <label for="clinicalStatus_refuted">Refuted</label>
                </li>
                <li>
                    <input type="radio" <?php if($verificationStatus_code=="entered-in-error"){echo "checked";} ?> name="verificationStatus" id="clinicalStatus_entered_in_error" value="entered-in-error"> 
                    <label for="clinicalStatus_entered_in_error">Entered in Error</label>
                </li>
            </ul>

            <div id="accordion" role="tablist" aria-multiselectable="true">
                <div class="accordion-panel">
                    <div class="accordion-heading" role="tab" id="headingTwo">
                        <h3 class="card-title accordion-title">
                            <a class="accordion-msg waves-effect waves-dark scale_active text-info" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                Lihat Penjelasannya Disini
                            </a>
                        </h3>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo">
                        <div class="accordion-content accordion-desc">
                            <p>
                                <dt>Keterangan :</dt>
                                <ol>
                                    <li>
                                        Unconfirmed 
                                        (Belum terkonfirmasi secara klinis.Tingkat kepastian rendah tentang kecenderungan reaksi terhadap suatu zat.)
                                    </li>
                                    <li>
                                        Confirmed 
                                        (Terkonfirmasi secara klinis. Tingkat kepastian yang tinggi tentang kecenderungan reaksi 
                                        pada suatu zat yang dapat dibuktikan secara klinis melalui tes atau rechallenge)
                                    </li>
                                    <li>
                                        Refuted 
                                        (Disangkal atau tidak terbukti. Reaksi terhadap suatu zat disangkal atau tidak 
                                        terbukti berdasarkan bukti klinis. Hal ini dapat termasuk/tidak termasuk pengujian)
                                    </li>
                                    <li>
                                        Entered in Error 
                                        (Pernyataan yang dimasukkan sebagai error atau tidak valid)
                                    </li>
                                </ol>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="category">Kategori zat atau allergen</label><br>
        </div>
        <div class="col-md-8">
            <ul>
                <li>
                    <input type="radio" <?php if($category=="food"){echo "checked";} ?> name="category" id="category_food" value="food"> 
                    <label for="category_food">Food</label>
                </li>
                <li>
                    <input type="radio" <?php if($category=="medication"){echo "checked";} ?> name="category" id="category_medication" value="medication"> 
                    <label for="category_medication">Medication</label>
                </li>
                <li>
                    <input type="radio" <?php if($category=="environment"){echo "checked";} ?> name="category" id="category_environment" value="environment"> 
                    <label for="category_environment">Environment</label>
                </li>
            </ul>
            <div id="accordion" role="tablist" aria-multiselectable="true">
                <div class="accordion-panel">
                    <div class="accordion-heading" role="tab" id="headingTree">
                        <h3 class="card-title accordion-title">
                            <a class="accordion-msg waves-effect waves-dark scale_active text-info" data-toggle="collapse" data-parent="#accordion" href="#collapseTree" aria-expanded="true" aria-controls="collapseTree">
                                Lihat Penjelasannya Disini
                            </a>
                        </h3>
                    </div>
                    <div id="collapseTree" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTree">
                        <div class="accordion-content accordion-desc">
                            <p>
                                <dt>Keterangan :</dt>
                                <ol>
                                    <li>
                                        Food (Segala zat atau substansi yang dikonsumsi untuk nutrisi bagi tubuh)
                                    </li>
                                    <li>
                                        Medication (Substansi yang diberikan untuk mencapai efek fisiologis / Obat)
                                    </li>
                                    <li>
                                        Environment (Setiap substansi yang berasal atau ditemukan dari lingkungan, termasuk 
                                        substansi yang tidak dikategorikan sebagai makanan, medikasi/obat, dan biologis)
                                    </li>
                                    <li>
                                        Biologic (Sediaan yang disintesis dari organisme hidup atau produknya, terutama 
                                        manusia atau protein hewan, seperti hormon atau antitoksin, yang digunakan sebagai agen diagnostik, 
                                        preventif, atau terapeutik. Contoh obat biologis meliputi: vaksin; ekstrak alergi, yang digunakan untuk 
                                        diagnosis dan pengobatan (misalnya, suntikan alergi); terapi gen; terapi seluler. Ada produk biologis lain, 
                                        seperti jaringan, yang biasanya tidak terkait dengan alergi.)
                                    </li>
                                </ol>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="code">Jenis zat atau allergen</label><br>
        </div>
        <div class="col-md-8">
            <div class="row mb-4">
                <div class="col-md-12">
                    Cari nama jenis zat alergen sesuai referensi (Format: Code-Display)
                    <div class="input-group">
                        <input type="text" class="form-control" id="KeywordPencarianAlergyEdit" name="KeywordPencarianAlergyEdit" list="ListKodeAlergiEdit" placeholder="Ketik Nama/Code">
                        <datalist id="ListKodeAlergiEdit">

                        </datalist>
                        <button type="button" class="btn btn-sm btn-secondary" id="TambahFormCodeAlergiEdit">
                            <i class="ti ti-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div id="MultiFormCodeAlergyEdit">
                <!-- Multi Form Kontak Dokter -->
                <?php
                    $no=1;
                    foreach($JenisAlergi as $ListJenisAlergen){
                        $JenisAlergi_system=$ListJenisAlergen['system'];
                        $JenisAlergi_code=$ListJenisAlergen['code'];
                        $JenisAlergi_display=$ListJenisAlergen['display'];
                        echo '<div class="row mb-3" id="BarisKodeAlergiEdit'.$no.'">';
                        echo '  <div class="col-md-12 mb-2 input-group">';
                        echo '      <input type="text" readonly class="form-control" id="code_alergi_edit[]" name="code_alergi_edit[]" value="'.$JenisAlergi_code.'-'.$JenisAlergi_display.'">';
                        echo '      <button type="button" class="btn btn-sm btn-outline-danger HapusFormCodeAlergiEdit" id="'.$no.'">';
                        echo '          <i class="ti ti-close"></i>';
                        echo '      </button>';
                        echo '  </div>';
                        echo '</div>';
                        $no++;
                    }
                ?>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="keterangan_alergi">Keterangan</label>
        </div>
        <div class="col-md-8">
            <input type="text" class="form-control" name="keterangan_alergi" id="keterangan_alergi" placeholder="ex: Alergi bahan gluten, khususnya ketika makan roti gandum" value="<?php echo $text; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="id_ihs_practitioner">Practitioner/Nakes</label>
        </div>
        <div class="col-md-8">
            <select name="id_ihs_practitioner" id="id_ihs_practitioner" class="form-control">
                <option value="">Pilih</option>
                <?php
                    $query = mysqli_query($Conn, "SELECT*FROM referensi_practitioner");
                    while ($data = mysqli_fetch_array($query)) {
                        $id_ihs_practitioner= $data['id_ihs_practitioner'];
                        $nama_nakes= $data['nama'];
                        if($id_practitioner==$id_ihs_practitioner){
                            echo '<option selected value="'.$id_ihs_practitioner.'">'.$nama_nakes.'</option>';
                        }else{
                            echo '<option value="'.$id_ihs_practitioner.'">'.$nama_nakes.'</option>';
                        }
                    }
                ?>
            </select>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            var no =1;
            //Multi Form Kontak Dokter
            $('#TambahFormCodeAlergiEdit').click(function(){
                var KeywordPencarianAlergyEdit=$('#KeywordPencarianAlergyEdit').val(); 
                if(KeywordPencarianAlergyEdit!==""){
                    no++;
                    $('#MultiFormCodeAlergyEdit').append('<div class="row mb-3" id="BarisKodeAlergiEdit'+no+'"><div class="col-md-12 mb-2 input-group"><input type="text" readonly class="form-control" id="code_alergi_edit[]" name="code_alergi_edit[]" value="'+KeywordPencarianAlergyEdit+'"><button type="button" class="btn btn-sm btn-outline-danger HapusFormCodeAlergiEdit" id="'+no+'"><i class="ti ti-close"></i></button></div></div>');
                }
            });
            $(document).on('click', '.HapusFormCodeAlergiEdit', function(){
                var button_id = $(this).attr("id"); 
                $('#BarisKodeAlergiEdit'+button_id+'').remove();
            });
            //Ketika Kode Alergi Di ketik
            $('#KeywordPencarianAlergyEdit').keyup(function(){
                var KeywordPencarianAlergyEdit=$('#KeywordPencarianAlergyEdit').val(); 
                $('#ListKodeAlergiEdit').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/ListKodeAlergi.php',
                    data        : {keyword: KeywordPencarianAlergyEdit},
                    success     : function(data){
                        $('#ListKodeAlergiEdit').html(data);
                    }
                });
            });
        });
    </script>
<?php
            }
        }
    }
?>