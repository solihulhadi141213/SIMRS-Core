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
            echo '          Sebelum menambahkan data medication, anda harus membuat ID encounter untuk kunjungan ini!';
            echo '      </div>';
            echo '  </div>';
        }else{
            //Buka Setting Satu Sehat
            $organization_id=getDataDetail($Conn,'setting_satusehat','status','Active','organization_id');
            $id_pasien=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'id_pasien');
            $nama=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'nama');
            //Cek apakah kunjungan tersebut sudah punya resep
            $JumlahResep=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM resep WHERE id_kunjungan='$id_kunjungan'"));
            if(empty($JumlahResep)){
                echo '  <div class="row">';
                echo '      <div class="col-md-12 text-center text-danger">';
                echo '          Untuk membuat data medication request, anda harus membuat resep terlebih dulu';
                echo '      </div>';
                echo '  </div>';
            }else{
                $id_ihs=getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'id_ihs');
?>
    <div class="row mb-4 sub-title">
        <div class="col-md-12 mb-3">
            <dt>A. Informasi Pasien</dt>
        </div>
        <div class="col-md-12">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="id_pasien">A.1.No.RM</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="id_pasien" class="form-control" value="<?php echo $id_pasien; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="id_kunjungan">A.2.ID Kunjungan</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="id_kunjungan" class="form-control" value="<?php echo $id_kunjungan; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="encounter_reference">A.3.ID Encounter</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="encounter_reference" class="form-control" value="<?php echo "Encounter/$id_encounter"; ?>">
                    <small>
                        ID Encounter diisi dengan format : Encounter/{id encounter}
                    </small>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-4 sub-title">
        <div class="col-md-12 mb-3">
            <dt>B. Resep</dt>
            <small>
                Pastikan kunjungan pasien sudah dilengkapi dengan data resep. Pembuatan resep ada di tab terapi/tindakan
            </small>
        </div>
        <div class="col-md-12">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="PilihIdResep">B.1.Pilih Id Resep</label>
                </div>
                <div class="col-md-8">
                    <select name="id_resep" id="PilihIdResep" class="form-control">
                        <option value="">Pilih</option>
                        <?php
                            $query = mysqli_query($Conn, "SELECT*FROM resep WHERE id_kunjungan='$id_kunjungan'");
                            while ($data = mysqli_fetch_array($query)) {
                                $id_resep= $data['id_resep'];
                                $tanggal_resep= $data['tanggal_resep'];
                                echo '<option value="'.$id_resep.'">ID.'.$id_resep.' ('.$tanggal_resep.')</option>';
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div id="ValidasiIdResep1">
                <!-- Informasi Validasi Resep Disini -->
            </div>
        </div>
    </div>
    <div class="row mb-4 sub-title">
        <div class="col-md-12 mb-3">
            <dt>C. Item Resep</dt>
        </div>
        <div class="col-md-12 mb-3">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="PilihItemResep">C.1.Pilih Item Resep</label>
                </div>
                <div class="col-md-8">
                    <select name="id_item_resep" id="PilihItemResep" class="form-control">
                        <option value="">Pilih</option>
                    </select>
                </div>
            </div>
            <div id="ValidasiIdResep2">
                <!-- Informasi Validasi Resep Disini -->
            </div>
        </div>
    </div>
    <div class="row mb-4 sub-title">
        <div class="col-md-12 mb-3">
            <dt>D. Informasi Resep</dt>
        </div>
        <div class="col-md-12 mb-3">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="status">D.1.Status Resep</label><br>
                    <a href="https://hl7.org/FHIR/codesystem-medicationrequest-status.html" target="_blank" class="text-info">
                        <small><i class="ti ti-info-alt"></i> Referensi</small>
                    </a>
                </div>
                <div class="col-md-8">
                    <select name="status" id="status" class="form-control">
                        <option value="">Pilih</option>
                        <option value="active">Aktif</option>
                        <option value="on-hold">Tertahan</option>
                        <option value="cancelled">Dibatalkan</option>
                        <option value="completed">Komplit</option>
                        <option value="entered-in-error">Salah</option>
                        <option value="cancelled">Dibatalkan</option>
                        <option value="stopped">Dihentikan</option>
                        <option value="draft">Draft/butuh verifikasi</option>
                        <option value="unknown">Tidak diketahui</option>
                    </select>
                    <small>
                        Berkaitan dengan kode spesifik yang menunjukkan status 
                        pengobatan saat ini yang umumnya akan berupa status aktif atau komplit.
                    </small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="intent">D.2.Intent</label><br>
                    <a href="https://hl7.org/FHIR/codesystem-medicationrequest-intent.html" target="_blank" class="text-info">
                        <small><i class="ti ti-info-alt"></i> Referensi</small>
                    </a>
                </div>
                <div class="col-md-8">
                    <select name="intent" id="intent" class="form-control">
                        <option value="">Pilih</option>
                        <option value="proposal">Proposal</option>
                        <option value="plan">Plan</option>
                        <option value="order">Order</option>
                        <option value="original-order">Original-Order</option>
                        <option value="reflex-order">Reflex-Order</option>
                        <option value="filler-order">Filler-Order</option>
                        <option value="instance-order">Instance-Order</option>
                        <option value="unknown">Unknown</option>
                    </select>
                    <small>
                        Berkaitan dengan tujuan pengobatan yang diresepkan apakah usulan, 
                        rencana, atau rencana pengobatan asli.
                    </small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="priority">D.3.Priority</label>
                </div>
                <div class="col-md-8">
                    <select name="priority" id="priority" class="form-control">
                        <option value="">Pilih</option>
                        <option value="routine">Routine (Prioritas normal)</option>
                        <option value="urgent">Urgent (Permintaan yang harus dilakukan lebih prioritas Routine)</option>
                        <option value="asap">Asap (Permintaan yang harus dilakukan lebih prioritas Urgent)</option>
                        <option value="stat">Stat (Permintaan yang harus dilakukan diberikan saat itu juga)</option>
                    </select>
                    <small>
                        Mengindikasikan seberapa cepat permintaan pengobatan sebaiknya ditangani terkait dengan permintaan lainnya
                    </small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="authoredOn">D.4.Authored On</label>
                </div>
                <div class="col-md-8">
                    <input type="date" class="form-control" id="authoredOn" name="authoredOn" value="<?php echo date('Y-m-d'); ?>">
                    <small></small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="numberOfRepeatsAllowed">D.5.Number Of Repeats Allowed</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="numberOfRepeatsAllowed" id="numberOfRepeatsAllowed" class="form-control" value="0">
                    <small>
                        Berapa kali resep obat dapat diulang (iter). Angka yang tertulis merupakan jumlah resep boleh diulang diluar resep asli.
                    </small>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-4 sub-title">
        <div class="col-md-12 mb-3">
            <dt>E. Kategori</dt>
            <small>Berkaitan dengan tipe permintaan pengobatan, seperti pengobatan yang diberikan/dikonsumsi pada rawat inap atau rawat jalan</small>
        </div>
        <div class="col-md-12 mb-3">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="MedicationRequestCategory">E.1.Pilih Kategori</label>
                </div>
                <div class="col-md-8">
                    <select name="MedicationRequestCategory" id="MedicationRequestCategory" class="form-control">
                        <option value="">Pilih</option>
                        <option value="inpatient">Inpatient</option>
                        <option value="outpatient">Outpatient</option>
                        <option value="community">Community</option>
                        <option value="discharge">Discharge</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-12 mb-3" id="ValidasiKategoriMedicationRequest"></div>
    </div>
    <div class="row mb-4 sub-title">
        <div class="col-md-12 mb-3">
            <dt>F. Subject (IHS Pasien)</dt>
        </div>
        <div class="col-md-12 mb-3">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="MedicationRequestSubjectReference">F.1.Reference</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="MedicationRequestSubjectReference" id="MedicationRequestSubjectReference" class="form-control" value="Patient/<?php echo "$id_ihs"; ?>">
                    <small>
                        Subject Reference Diisi dengan format: Patient/{id ihs pasien}
                    </small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="MedicationRequestSubjectDisplay">F.2.Display</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="MedicationRequestSubjectDisplay" id="MedicationRequestSubjectDisplay" class="form-control" value="<?php echo "$nama"; ?>">
                    <small>Nama lengkap pasien sesuai IHS</small>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-4 sub-title">
        <div class="col-md-12 mb-3">
            <dt>G. Requester</dt>
        </div>
        <div class="col-md-12 mb-3">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="MedicationRequestRequester">F.1.Pilih Nakes</label>
                </div>
                <div class="col-md-8">
                    <select name="MedicationRequestRequester" id="MedicationRequestRequester" class="form-control">
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
                    <small>
                        Tenaga kesehatan (Practitioner) yang membuat peresepan
                    </small>
                </div>
            </div>
        </div>
        <div class="col-md-12 mb-3" id="ValidasiRequesterMedicationRequest"></div>
    </div>
    <div class="row mb-4 sub-title">
        <div class="col-md-12 mb-3">
            <dt>H. Reson Code</dt>
            <small>
                Berkaitan dengan alasan atau indikasi untuk meminta atau tidak meminta pengobatan yang merujuk pada ICD 10 Thn 2010
            </small>
        </div>
        <div class="col-md-12 mb-3">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="MedicationRequestReferenceDiagnose">G.1.Data Resource</label>
                </div>
                <div class="col-md-8">
                    <select name="MedicationRequestReferenceDiagnose" id="MedicationRequestReferenceDiagnose" class="form-control">
                        <option value="">Pilih</option>
                        <option value="BPJS">Referensi BPJS</option>
                        <option value="SIMRS">Database SIMRS</option>
                    </select>
                    <small>
                        Pilih sumber data ICD 10
                    </small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="MedicationRequestKeywordDiagnosa">G.2.Kata Kunci</label>
                </div>
                <div class="col-md-8">
                    <div class="input-group">
                        <input type="text" name="MedicationRequestKeywordDiagnosa" id="MedicationRequestKeywordDiagnosa" class="form-control" placeholder="ex: E10.9">
                        <button type="button" class="btn btn-sm btn-secondary" id="PencarianMeedicationRequestDiagnosaList">
                            <i class="ti ti-search"></i> Cari
                        </button>
                    </div>
                    <div class="row">
                        <div class="col-md-12" id="MeedicationRequestDiagnosaList">

                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="MedicationRequestreasonCode_system">G.3.Reson Code System</label>
                </div>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="MedicationRequestreasonCode_system" id="MedicationRequestreasonCode_system" value="http://hl7.org/fhir/sid/icd-10">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="MedicationRequestreasonCode_code">G.4.Reson Code Code</label>
                </div>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="MedicationRequestreasonCode_code" id="MedicationRequestreasonCode_code" value="">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="MedicationRequestreasonCode_display">G.5.Reson Code Display</label>
                </div>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="MedicationRequestreasonCode_display" id="MedicationRequestreasonCode_display" value="">
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-4 sub-title">
        <div class="col-md-12 mb-3">
            <dt>I. Course Of Therapy Type</dt>
            <small>
                Mendeskripsikan keseluruhan pola pemberian obat pada pasien
            </small>
        </div>
        <div class="col-md-12 mb-3">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="MedicationRequestCourseOfTherapyType">I.1.Pilih Course Of Therapy</label>
                </div>
                <div class="col-md-8">
                    <select name="MedicationRequestCourseOfTherapyType" id="MedicationRequestCourseOfTherapyType" class="form-control">
                        <option value="">Pilih</option>
                        <option value="continuous">Continuing long term therapy</option>
                        <option value="acute">Short course (acute) therapy</option>
                        <option value="seasonal">Seasonal</option>
                    </select>
                </div>
            </div>
            <div id="ValidasicourseOfTherapyType"></div>
        </div>
    </div>
    <div class="row mb-4 sub-title">
        <div class="col-md-12 mb-3">
            <dt>J. Dosage Instruction</dt>
        </div>
        <div class="col-md-12 mb-3">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="dosageInstruction_sequence">J.1.Sequence</label>
                </div>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="dosageInstruction_sequence" id="dosageInstruction_sequence" value="1">
                    <small>Urutan aturan pemakaian dari obat.</small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="dosageInstruction_text">J.2.Text</label>
                </div>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="dosageInstruction_text" id="dosageInstruction_text" value="">
                    <small>Aturan pakai obat dalam bentuk naratif</small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="dosageInstruction_additionalInstruction">J.3.Additional Instruction</label>
                </div>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="dosageInstruction_additionalInstruction" id="dosageInstruction_additionalInstruction">
                    <small>Berkaitan dengan instruksi tambahan bagi pasien mengenai bagaimana penggunaan obat</small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="patientInstruction">J.4.Patient Instruction</label>
                </div>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="patientInstruction" id="patientInstruction">
                    <small>Instruksi aturan pakai dengan orientasi pasiens</small>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-4 sub-title">
        <div class="col-md-12 mb-3">
            <dt>K. Timing Repeat</dt>
            <small>Aturan kapan suatu obat harus dikonsumsi.</small>
        </div>
        <div class="col-md-12 mb-3">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="timing_repeat_frequency">K.1.Frequency</label>
                </div>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="timing_repeat_frequency" id="timing_repeat_frequency" value="1">
                    <small>Frekuensi pengulangan dalam jangka waktu (period) tertentu</small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="timing_repeat_period">K.1.Period</label>
                </div>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="timing_repeat_period" id="timing_repeat_period" value="1">
                    <small>Jangka waktu/durasi waktu dimana repetisi akan terjadi</small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="timing_repeat_periodUnit">K.1.Unit</label>
                </div>
                <div class="col-md-8">
                    <select class="form-control" name="timing_repeat_periodUnit" id="timing_repeat_periodUnit">
                        <?php
                            echo '<option value="">Pilih</option>';
                            $ucum_file="../../assets/referensi_json/ucum_med_ind_strength.json";
                            $jsonContent = file_get_contents($ucum_file);
                            $data = json_decode($jsonContent, true);
                            if(!empty(count($data['list']))){
                                $ucum_list=$data['list'];
                                foreach($ucum_list as $show_ucum){
                                    $ucum_system=$show_ucum['system'];
                                    $ucum_code=$show_ucum['code'];
                                    $ucum_display=$show_ucum['display'];
                                    echo '<option value="'.$ucum_code.'">'.$ucum_display.'</option>';
                                }
                            }
                        ?>
                    </select>
                    <small>Unit dari period dalam UCUM</small>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-4 sub-title">
        <div class="col-md-12 mb-3">
            <dt>L. Route</dt>
            <small>Berkaitan dengan cara/rute yang digunakan untuk memasukkan obat ke dalam tubuh pasien</small>
        </div>
        <div class="col-md-12 mb-3">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="PilihDosageInstructionRout">L.1.Pilih Rout</label>
                </div>
                <div class="col-md-8">
                    <select class="form-control" name="PilihDosageInstructionRout" id="PilihDosageInstructionRout">
                        <?php
                            echo '<option value="">Pilih</option>';
                            $rout_file="../../assets/referensi_json/dosageInstruction_route.json";
                            $jsonContent = file_get_contents($rout_file);
                            $data = json_decode($jsonContent, true);
                            if(!empty(count($data['list']))){
                                $rout_list=$data['list'];
                                foreach($rout_list as $show_rout){
                                    $rout_system=$show_rout['system'];
                                    $rout_code=$show_rout['code'];
                                    $rout_display=$show_rout['display'];
                                    echo '<option value="'.$rout_code.'">'.$rout_display.'</option>';
                                }
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div id="ValidasiDosageInstructionRout"></div>
        </div>
    </div>
    <div class="row mb-4 sub-title">
        <div class="col-md-12 mb-3">
            <dt>M. Dose And Rate</dt>
            <small>Berkaitan dengan jenis atau laju pengobatan yang diresepkan</small>
        </div>
        <div class="col-md-12 mb-3">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="DoseAndRateType">M.1.Dose And Rate Type</label>
                </div>
                <div class="col-md-8">
                    <select class="form-control" name="DoseAndRateType" id="DoseAndRateType">
                        <option value="">Pilih</option>
                        <option value="calculated">Calculated</option>
                        <option value="ordered">Ordered</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="DoseAndRateTypeSystem">M.1.1.Dose And Rate System</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="DoseAndRateTypeSystem" id="DoseAndRateTypeSystem" class="form-control" value="http://terminology.hl7.org/CodeSystem/dose-rate-type">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="DoseAndRateTypeCode">M.1.2.Dose And Rate Code</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="DoseAndRateTypeCode" id="DoseAndRateTypeCode" class="form-control">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="DoseAndRateTypeDisplay">M.1.3.Dose And Rate Display</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="DoseAndRateTypeDisplay" id="DoseAndRateTypeDisplay" class="form-control">
                    <small id="DoseAndRateTypeKeterangan"></small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="DoseQuantity">M.2.Dose Quantity</label><br>
                </div>
                <div class="col-md-8">
                    <small>Jumlah obat yang diberikan dalam 1 kali resep</small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="DoseQuantityValue">M.2.1 Dose Quantity Value</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="DoseQuantityValue" id="DoseQuantityValue" class="form-control">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="DoseQuantityUnit">M.2.2 Dose Quantity Unit</label>
                </div>
                <div class="col-md-8">
                    <select class="form-control" name="DoseQuantityUnit" id="DoseQuantityUnit">
                        <?php
                            echo '<option value="">Pilih</option>';
                            $UnitFile="../../assets/referensi_json/orderableDrugForm.json";
                            $JsonContentUnit = file_get_contents($UnitFile);
                            $DataUnit = json_decode($JsonContentUnit, true);
                            if(!empty(count($DataUnit['list']))){
                                $InitList=$DataUnit['list'];
                                foreach($InitList as $ShowUnit){
                                    $UnitSystem=$ShowUnit['system'];
                                    $UnitCode=$ShowUnit['code'];
                                    $UnitDisplay=$ShowUnit['display'];
                                    echo '<option value="'.$UnitCode.'">'.$UnitDisplay.'</option>';
                                }
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="DoseQuantitySystem">M.2.3 Dose Quantity System</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="DoseQuantitySystem" id="DoseQuantitySystem" class="form-control" value="http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="DoseQuantityCode">M.2.4 Dose Quantity Code</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="DoseQuantityCode" id="DoseQuantityCode" class="form-control" value="">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="DoseQuantityDisplay">M.2.5 Dose Quantity Display</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="DoseQuantityDisplay" id="DoseQuantityDisplay" class="form-control" value="">
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-4 sub-title">
        <div class="col-md-12 mb-3">
            <dt>O. Dispense Interval</dt>
            <small>Berkaitan dengan periode waktu minimal yang harus dilakukan antara pengeluaran obat</small>
        </div>
        <div class="col-md-12 mb-3">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="dispenseIntervalValue">O.1.Dispense Interval Value</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="dispenseIntervalValue" id="dispenseIntervalValue" class="form-control" value="">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="dispenseIntervalUnit">O.2.Dispense Interval Unit</label>
                </div>
                <div class="col-md-8">
                    <select name="dispenseIntervalUnit" id="dispenseIntervalUnit" class="form-control">
                        <option value="">Pilih</option>
                        <option value="ms">milliseconds</option>
                        <option value="s">second</option>
                        <option value="min">minutes</option>
                        <option value="h">hours</option>
                        <option value="d">days</option>
                        <option value="w">weeks</option>
                        <option value="m">months</option>
                        <option value="a">years</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="dispenseIntervalSystem">O.3.Dispense Interval System</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="dispenseIntervalSystem" id="dispenseIntervalSystem" class="form-control" value="http://unitsofmeasure.org">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="dispenseIntervalCode">O.4.Dispense Interval Code</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="dispenseIntervalCode" id="dispenseIntervalCode" class="form-control" value="">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="dispenseIntervalDisplay">O.5.Dispense Interval Display</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="dispenseIntervalDisplay" id="dispenseIntervalDisplay" class="form-control" value="">
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-4 sub-title">
        <div class="col-md-12 mb-3">
            <dt>P. Validity Period</dt>
            <small>Periode waktu peresepan obat valid</small>
        </div>
        <div class="col-md-12 mb-3">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="validityPeriod_start">P.1.Validity Period Start</label>
                </div>
                <div class="col-md-8">
                    <input type="date" name="validityPeriod_start" id="validityPeriod_start" class="form-control" value="">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="validityPeriod_end">P.2.Validity Period End</label>
                </div>
                <div class="col-md-8">
                    <input type="date" name="validityPeriod_end" id="validityPeriod_end" class="form-control" value="">
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-4 sub-title">
        <div class="col-md-12 mb-3">
            <dt>Q. Quantity</dt>
            <small>Jumlah obat yang diberikan dalam 1 kali resep</small>
        </div>
        <div class="col-md-12 mb-3">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="quantity_value">Q.1.Quantity Value</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="quantity_value" id="quantity_value" class="form-control" value="">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="pilih_quantity_unit">Q.2 Quantity Unit</label>
                </div>
                <div class="col-md-8">
                    <select class="form-control" name="pilih_quantity_unit" id="pilih_quantity_unit">
                        <?php
                            echo '<option value="">Pilih</option>';
                            $UnitFile="../../assets/referensi_json/orderableDrugForm.json";
                            $JsonContentUnit = file_get_contents($UnitFile);
                            $DataUnit = json_decode($JsonContentUnit, true);
                            if(!empty(count($DataUnit['list']))){
                                $InitList=$DataUnit['list'];
                                foreach($InitList as $ShowUnit){
                                    $UnitSystem=$ShowUnit['system'];
                                    $UnitCode=$ShowUnit['code'];
                                    $UnitDisplay=$ShowUnit['display'];
                                    echo '<option value="'.$UnitCode.'">'.$UnitDisplay.'</option>';
                                }
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="quantity_system">Q.3.Quantity System</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="quantity_system" id="quantity_system" class="form-control" value="http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="quantity_code">Q.4.Quantity Code</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="quantity_code" id="quantity_code" class="form-control" value="">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="quantity_display">Q.5.Quantity Display</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="quantity_display" id="quantity_display" class="form-control" value="">
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-4 sub-title">
        <div class="col-md-12 mb-3">
            <dt>R. Expected Supply Duration</dt>
            <small>Mengidentifikasi periode waktu selama produk yang diberikan diharapkan digunakan atau lamanya waktu pengeluaran yang diharapkan.</small>
        </div>
        <div class="col-md-12 mb-3">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="expectedSupplyDurationValue">R.1.Expected Duration Value</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="expectedSupplyDurationValue" id="expectedSupplyDurationValue" class="form-control" value="">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="expectedSupplyDurationUnit">R.2 Expected Duration Unit</label>
                </div>
                <div class="col-md-8">
                    <select name="expectedSupplyDurationUnit" id="expectedSupplyDurationUnit" class="form-control">
                        <option value="">Pilih</option>
                        <option value="ms">milliseconds</option>
                        <option value="s">second</option>
                        <option value="min">minutes</option>
                        <option value="h">hours</option>
                        <option value="d">days</option>
                        <option value="w">weeks</option>
                        <option value="m">months</option>
                        <option value="a">years</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="expectedSupplyDurationSystem">R.3.Expected Duration System</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="expectedSupplyDurationSystem" id="expectedSupplyDurationSystem" class="form-control" value="http://unitsofmeasure.org">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="expectedSupplyDurationCode">R.4.Expected Duration Code</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="expectedSupplyDurationCode" id="expectedSupplyDurationCode" class="form-control" value="">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="expectedSupplyDurationDisplay">R.5.Expected Duration Display</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="expectedSupplyDurationDisplay" id="expectedSupplyDurationDisplay" class="form-control" value="">
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-4 sub-title">
        <div class="col-md-12 mb-3">
            <dt>S. Performer</dt>
            <small>Organisasi yang ditunjuk untuk melakukan dispensing obat</small>
        </div>
        <div class="col-md-12 mb-3">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="performer_reference">S.1 Performer Reference</label>
                </div>
                <div class="col-md-8">
                    <select name="performer_reference" id="performer_reference" class="form-control">
                        <option value="">Pilih</option>
                        <?php
                            $JumlahOrganisasi=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM referensi_organisasi"));
                            if(!empty($JumlahOrganisasi)){
                                $QryOrganisasi = mysqli_query($Conn, "SELECT*FROM referensi_organisasi WHERE ID_Org!='' ORDER BY id_referensi_organisasi DESC");
                                while ($DataOrganisasi = mysqli_fetch_array($QryOrganisasi)) {
                                    $id_referensi_organisasi= $DataOrganisasi['id_referensi_organisasi'];
                                    $NamaOrganisasi= $DataOrganisasi['nama'];
                                    $IdentifierOrganisasi= $DataOrganisasi['identifier'];
                                    $ID_Org= $DataOrganisasi['ID_Org'];
                                    echo '<option value="'.$ID_Org.'">'.$NamaOrganisasi.'</option>';
                                }
                            }
                        ?>
                    </select>
                </div>
            </div>
        </div>
    </div>
<?php }}} ?>

<script>
    $(document).ready(function(){
        //Kondisi Ketika Pilih Resep
        $('#PilihIdResep').change(function(){
            var id_resep=$('#PilihIdResep').val();
            $('#ValidasiIdResep1').html('Loading...'); 
            $.ajax({
                type 	    : 'POST',
                url 	    : '_Page/RawatJalan/ValidasiIdResep1.php',
                data        : {id_resep: id_resep},
                success     : function(data){
                    $('#ValidasiIdResep1').html(data);
                }
            });
            $('#PilihItemResep').html('<option value="">Loading...</option>'); 
            $.ajax({
                type 	    : 'POST',
                url 	    : '_Page/RawatJalan/ListItemObat.php',
                data        : {id_resep: id_resep},
                success     : function(data){
                    $('#PilihItemResep').html(data);
                }
            });
            if(id_resep==""){
                $('#ValidasiIdResep2').html(''); 
            }
        });
        //Kondisi Ketika Pilih item Resep
        $('#PilihItemResep').change(function(){
            var id_item_resep=$('#PilihItemResep').val();
            $('#ValidasiIdResep2').html('Loading...'); 
            $.ajax({
                type 	    : 'POST',
                url 	    : '_Page/RawatJalan/ValidasiIdResep2.php',
                data        : {id_item_resep: id_item_resep},
                success     : function(data){
                    $('#ValidasiIdResep2').html(data);
                }
            });
        });
        //Kondisi Ketika Diagnosis Diketik
        $('#reasonCode_coding_keyup').keyup(function(){
            var keyword=$('#reasonCode_coding_keyup').val(); 
            var referensi=$('#ReferensiResonCode').val(); 
            $('#list_reasonCode_coding').html('<option value="Loading...">');
            $.ajax({
                type 	    : 'POST',
                url 	    : '_Page/RawatJalan/ListResonCode.php',
                data        : {keyword: keyword, referensi: referensi},
                success     : function(data){
                    $('#list_reasonCode_coding').html(data);
                }
            });
        });
        //Kondisi Ketika Category Dipilih (MedicationRequestCategory)
        $('#MedicationRequestCategory').change(function(){
            var category=$('#MedicationRequestCategory').val(); 
            $('#ValidasiKategoriMedicationRequest').html('<div class="row mb-3"><div class="col-md-12 text-center">Loading...</div></div>');
            $.ajax({
                type 	    : 'POST',
                url 	    : '_Page/RawatJalan/ValidasiKategoriMedicationRequest.php',
                data        : {category: category},
                success     : function(data){
                    $('#ValidasiKategoriMedicationRequest').html(data);
                }
            });
        });
        //Kondisi Ketika requester (practitioner) dipilih
        $('#MedicationRequestRequester').change(function(){
            var Requester=$('#MedicationRequestRequester').val(); 
            $('#ValidasiRequesterMedicationRequest').html('<div class="row mb-3"><div class="col-md-12 text-center">Loading...</div></div>');
            $.ajax({
                type 	    : 'POST',
                url 	    : '_Page/RawatJalan/ValidasiRequesterMedicationRequest.php',
                data        : {Requester: Requester},
                success     : function(data){
                    $('#ValidasiRequesterMedicationRequest').html(data);
                }
            });
        });
        //Kondisi Ketika Dilakukan Pencarian Diagnosa
        $('#PencarianMeedicationRequestDiagnosaList').click(function(){
            var Referensi=$('#MedicationRequestReferenceDiagnose').val();
            var Keyword=$('#MedicationRequestKeywordDiagnosa').val();
            $('#MeedicationRequestDiagnosaList').html('<div class="row mb-3"><div class="col-md-12 text-center">Loading...</div></div>');
            $.ajax({
                type 	    : 'POST',
                url 	    : '_Page/RawatJalan/MedicationRequestDiagnosaList.php',
                data        : {Referensi: Referensi, Keyword: Keyword},
                success     : function(data){
                    $('#MeedicationRequestDiagnosaList').html(data);
                }
            });
        });
        //Kondisi Ketika MedicationRequestCourseOfTherapyType dipilih
        $('#MedicationRequestCourseOfTherapyType').change(function(){
            var MedicationRequestCourseOfTherapyType=$('#MedicationRequestCourseOfTherapyType').val(); 
            $('#ValidasicourseOfTherapyType').html('<div class="row mb-3"><div class="col-md-12 text-center">Loading...</div></div>');
            $.ajax({
                type 	    : 'POST',
                url 	    : '_Page/RawatJalan/ValidasicourseOfTherapyType.php',
                data        : {MedicationRequestCourseOfTherapyType: MedicationRequestCourseOfTherapyType},
                success     : function(data){
                    $('#ValidasicourseOfTherapyType').html(data);
                }
            });
        });
        //Kondisi Ketika PilihDosageInstructionRout dipilih
        $('#PilihDosageInstructionRout').change(function(){
            var PilihDosageInstructionRout=$('#PilihDosageInstructionRout').val(); 
            $('#ValidasiDosageInstructionRout').html('<div class="row mb-3"><div class="col-md-12 text-center">Loading...</div></div>');
            $.ajax({
                type 	    : 'POST',
                url 	    : '_Page/RawatJalan/ValidasiDosageInstructionRout.php',
                data        : {PilihDosageInstructionRout: PilihDosageInstructionRout},
                success     : function(data){
                    $('#ValidasiDosageInstructionRout').html(data);
                }
            });
        });
        //Kondisi Ketika DoseAndRateType dipilih
        $('#DoseAndRateType').change(function(){
            var DoseAndRateType=$('#DoseAndRateType').val(); 
            if(DoseAndRateType==""){
                $('#DoseAndRateTypeCode').val("");
                $('#DoseAndRateTypeDisplay').val("");
                $('#DoseAndRateTypeKeterangan').html("");
            }else{
                if(DoseAndRateType=="calculated"){
                    $('#DoseAndRateTypeCode').val("calculated");
                    $('#DoseAndRateTypeDisplay').val("Calculated");
                    $('#DoseAndRateTypeKeterangan').html("Dosis yang ditentukan dihitung oleh sistem atau yang meresepkan obat");
                }else{
                    if(DoseAndRateType=="ordered"){
                        $('#DoseAndRateTypeCode').val("ordered");
                        $('#DoseAndRateTypeDisplay').val("Ordered");
                        $('#DoseAndRateTypeKeterangan').html("Dosis yang ditentukan seperti yang diminta peresep obat");
                    }
                }
            }
        });
        //Kondisi Ketika DoseQuantityUnit dipilih
        $('#DoseQuantityUnit').change(function(){
            var data_code=$('#DoseQuantityUnit').val(); 
            var data_display = $(this).find('option:selected').text();
            //Tempel
            $('#DoseQuantityCode').val(data_code);
            $('#DoseQuantityDisplay').val(data_display);
        });
        //Kondisi Ketika dispenseIntervalUnit dipilih
        $('#dispenseIntervalUnit').change(function(){
            var data_code=$('#dispenseIntervalUnit').val(); 
            var data_display = $(this).find('option:selected').text();
            //Tempel
            $('#dispenseIntervalCode').val(data_code);
            $('#dispenseIntervalDisplay').val(data_display);
        });
        //Kondisi Ketika pilih_quantity_unit dipilih
        $('#pilih_quantity_unit').change(function(){
            var quantity_code=$('#pilih_quantity_unit').val(); 
            var quantity_display = $(this).find('option:selected').text();
            //Tempel
            $('#quantity_code').val(quantity_code);
            $('#quantity_display').val(quantity_display);
        });
        //Kondisi Ketika expectedSupplyDurationUnit dipilih
        $('#expectedSupplyDurationUnit').change(function(){
            var expectedSupplyDurationCode=$('#expectedSupplyDurationUnit').val(); 
            var expectedSupplyDurationDisplay = $(this).find('option:selected').text();
            //Tempel
            $('#expectedSupplyDurationCode').val(expectedSupplyDurationCode);
            $('#expectedSupplyDurationDisplay').val(expectedSupplyDurationDisplay);
        });
    });
</script>