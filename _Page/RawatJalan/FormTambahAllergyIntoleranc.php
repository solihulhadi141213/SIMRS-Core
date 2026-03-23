<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['id_kunjungan'])){
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-center text-danger">';
        echo '          ID Kunjungan Tidak Boleh Kosong!';
        echo '      </div>';
        echo '  </div>';
    }else{
        $id_kunjungan=$_POST['id_kunjungan'];
        //Apakah Ada ID Encounter
        $id_encounter=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'id_encounter');
        if(empty($id_encounter)){
            echo '  <div class="row">';
            echo '      <div class="col-md-12 text-center text-danger">';
            echo '          Sebelum menambahkan data alergi, anda harus membuat ID encounter untuk kunjungan ini!';
            echo '      </div>';
            echo '  </div>';
        }else{
            //Buka Setting Satu Sehat
            $organization_id=getDataDetail($Conn,'setting_satusehat','status','Active','organization_id');
            $id_pasien=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'id_pasien');
            $nama=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'nama');
?>
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
            <input type="text" readonly name="nama" id="nama" class="form-control" value="<?php echo $nama; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="clinicalStatus">Status Klinis</label><br>
        </div>
        <div class="col-md-8">
            <ul>
                <li>
                    <input type="radio" name="clinicalStatus" id="clinicalStatus_active" value="active"> 
                    <label for="clinicalStatus_active">Active</label>
                </li>
                <li>
                    <input type="radio" name="clinicalStatus" id="clinicalStatus_inactive" value="inactive"> 
                    <label for="clinicalStatus_inactive">Inactive</label>
                </li>
                <li>
                    <input type="radio" name="clinicalStatus" id="clinicalStatus_resolved" value="resolved"> 
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
                    <input type="radio" name="verificationStatus" id="verificationStatus_unconfirmed" value="unconfirmed"> 
                    <label for="verificationStatus_unconfirmed">Unconfirmed</label>
                </li>
                <li>
                    <input type="radio" name="verificationStatus" id="verificationStatus_confirmed" value="confirmed"> 
                    <label for="verificationStatus_confirmed">Confirmed</label>
                </li>
                <li>
                    <input type="radio" name="verificationStatus" id="clinicalStatus_refuted" value="refuted"> 
                    <label for="clinicalStatus_refuted">Refuted</label>
                </li>
                <li>
                    <input type="radio" name="verificationStatus" id="clinicalStatus_entered_in_error" value="entered-in-error"> 
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
                    <input type="radio" name="category" id="category_food" value="food"> 
                    <label for="category_food">Food</label>
                </li>
                <li>
                    <input type="radio" name="category" id="category_medication" value="medication"> 
                    <label for="category_medication">Medication</label>
                </li>
                <li>
                    <input type="radio" name="category" id="category_environment" value="environment"> 
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
                        <input type="text" class="form-control" id="KeywordPencarianAlergy" name="KeywordPencarianAlergy" list="ListKodeAlergi" placeholder="Ketik Nama/Code">
                        <datalist id="ListKodeAlergi">

                        </datalist>
                        <button type="button" class="btn btn-sm btn-secondary" id="TambahFormCodeAlergi">
                            <i class="ti ti-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div id="MultiFormCodeAlergy">
                <!-- Multi Form Kontak Dokter -->
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="keterangan_alergi">Keterangan</label>
        </div>
        <div class="col-md-8">
            <input type="text" class="form-control" name="keterangan_alergi" id="keterangan_alergi" placeholder="ex: Alergi bahan gluten, khususnya ketika makan roti gandum">
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
                        echo '<option value="'.$id_ihs_practitioner.'">'.$nama_nakes.'</option>';
                    }
                ?>
            </select>
        </div>
    </div>
<?php }} ?>

<script>
    $(document).ready(function(){
        var no =1;
        //Multi Form Kontak Dokter
        $('#TambahFormCodeAlergi').click(function(){
            var KeywordPencarianAlergy=$('#KeywordPencarianAlergy').val(); 
            if(KeywordPencarianAlergy!==""){
                no++;
                $('#MultiFormCodeAlergy').append('<div class="row mb-3" id="BarisKodeAlergi'+no+'"><div class="col-md-12 mb-2 input-group"><input type="text" readonly class="form-control" id="code_alergi[]" name="code_alergi[]" value="'+KeywordPencarianAlergy+'"><button type="button" class="btn btn-sm btn-outline-danger HapusFormCodeAlergi" id="'+no+'"><i class="ti ti-close"></i></button></div></div>');
            }
        });
        $(document).on('click', '.HapusFormCodeAlergi', function(){
            var button_id = $(this).attr("id"); 
            $('#BarisKodeAlergi'+button_id+'').remove();
        });
        //Ketika Kode Alergi Di ketik
        $('#KeywordPencarianAlergy').keyup(function(){
            var KeywordPencarianAlergy=$('#KeywordPencarianAlergy').val(); 
            $('#ListKodeAlergi').html("Loading...");
            $.ajax({
                type 	    : 'POST',
                url 	    : '_Page/RawatJalan/ListKodeAlergi.php',
                data        : {keyword: KeywordPencarianAlergy},
                success     : function(data){
                    $('#ListKodeAlergi').html(data);
                }
            });
        });
    });
</script>