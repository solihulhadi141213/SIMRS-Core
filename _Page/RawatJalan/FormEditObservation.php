<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap id_kunjungan_observation
    if(empty($_POST['id_kunjungan_observation'])){
        echo '<div class="modal-body">';
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-danger text-center">';
        echo '          Data Kunjungan Tidak Boleh Kosong!';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
        echo '<div class="modal-footer bg-primary">';
        echo '  <div class="row">';
        echo '      <div class="col-md-12">';
        echo '          <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">';
        echo '              <i class="ti-close"></i> Tutup';
        echo '          </button>';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_kunjungan_observation=$_POST['id_kunjungan_observation'];
        $id_pasien=getDataDetail($Conn,"kunjungan_observation",'id_kunjungan_observation',$id_kunjungan_observation,'id_pasien');
        $id_encounter=getDataDetail($Conn,"kunjungan_observation",'id_kunjungan_observation',$id_kunjungan_observation,'id_encounter');
        $id_kunjungan=getDataDetail($Conn,"kunjungan_observation",'id_kunjungan_observation',$id_kunjungan_observation,'id_kunjungan');
        $id_observation=getDataDetail($Conn,"kunjungan_observation",'id_kunjungan_observation',$id_kunjungan_observation,'id_observation');
        $id_ihs_practitioner=getDataDetail($Conn,"kunjungan_observation",'id_kunjungan_observation',$id_kunjungan_observation,'id_ihs_practitioner');
        $category=getDataDetail($Conn,"kunjungan_observation",'id_kunjungan_observation',$id_kunjungan_observation,'category');
        $observation_code=getDataDetail($Conn,"kunjungan_observation",'id_kunjungan_observation',$id_kunjungan_observation,'observation_code');
        $status=getDataDetail($Conn,"kunjungan_observation",'id_kunjungan_observation',$id_kunjungan_observation,'status');
        $tipe_value=getDataDetail($Conn,"kunjungan_observation",'id_kunjungan_observation',$id_kunjungan_observation,'tipe_value');
        $raw_value=getDataDetail($Conn,"kunjungan_observation",'id_kunjungan_observation',$id_kunjungan_observation,'raw_value');
        $raw_interpertation=getDataDetail($Conn,"kunjungan_observation",'id_kunjungan_observation',$id_kunjungan_observation,'raw_interpertation');
        if(!empty($raw_interpertation)){
            $DecodeRawInterpertation = json_decode($raw_interpertation, true);
            foreach($DecodeRawInterpertation as $valueinterpretation_coding){
                $interpretation_coding = $valueinterpretation_coding['coding'];
                foreach($interpretation_coding as $valueinterpretation_code){
                    if(!empty($valueinterpretation_code['code'])){
                        $valueinterpretation_coding_code=$valueinterpretation_code['code'];
                    }else{
                        $valueinterpretation_coding_code="";
                    }
                }
            }
        }else{
            $valueinterpretation_coding_code="";
        }
        
        $tanggal_kunjungan=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'tanggal');
        //Apabila Id Kunjungan Tidak Valid
        if(empty($id_pasien)){
            echo '<div class="modal-body">';
            echo '  <div class="row">';
            echo '      <div class="col-md-12 text-danger text-center">';
            echo '          ID Kunjungan Tidak Valid!';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
            echo '<div class="modal-footer bg-success">';
            echo '  <div class="row">';
            echo '      <div class="col-md-12">';
            echo '          <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">';
            echo '              <i class="ti-close"></i> Tutup';
            echo '          </button>';
            echo '      </div>';
            echo '  </div>';
        }else{
            //Buka Data Pasien
            $id_ihs=getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'id_ihs');
            $nama=getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'nama');
            if(empty($id_ihs)){
                echo '<div class="modal-body">';
                echo '  <div class="row">';
                echo '      <div class="col-md-12 text-danger text-center">';
                echo '          Pasien Tidak Memiliki ID IHS.<br>Silahkan Tambahkan Data Pasien Ke Satu Sehat Terlebih Dulu..';
                echo '      </div>';
                echo '  </div>';
                echo '</div>';
                echo '<div class="modal-footer bg-success">';
                echo '  <div class="row">';
                echo '      <div class="col-md-12">';
                echo '          <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">';
                echo '              <i class="ti-close"></i> Tutup';
                echo '          </button>';
                echo '      </div>';
                echo '  </div>';
            }else{
                //Format Tanggal Kunjungan
                $strtotime=strtotime($tanggal_kunjungan);
                $TanggalKunjungan=date('Y-m-d', $strtotime);
?>
                <form action="javascript:void(0);" id="ProsesEditObservation">
                    <input type="hidden" name="GetIdKunjungan" id="GetIdKunjungan" value="<?php echo $id_kunjungan; ?>">
                    <input type="hidden" name="id_kunjungan_observation" id="id_kunjungan_observation" value="<?php echo $id_kunjungan_observation; ?>">
                    <div class="modal-body border-0 pb-0 mb-4">
                        <div class="row mb-3"> 
                            <div class="col-md-4">
                                <label for="id_pasien">No.RM</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="id_pasien" id="id_pasien" value="<?php echo "$id_pasien"; ?>">
                            </div>
                        </div>
                        <div class="row mb-3"> 
                            <div class="col-md-4">
                                <label for="id_observation">ID.Observation</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="id_observation" id="id_observation" value="<?php echo $id_observation; ?>">
                                <small>
                                    <input type="checkbox" checked name="UpdateObservationResource" id="UpdateObservationResource" value="Ya"> 
                                    <label for="UpdateObservationResource">Update Observation Resource</label>
                                </small>
                            </div>
                        </div>
                        <div class="row mb-3"> 
                            <div class="col-md-4">
                                <label for="id_ihs">ID IHS</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="id_ihs" id="id_ihs" value="<?php echo "$id_ihs"; ?>">
                            </div>
                        </div>
                        <div class="row mb-3"> 
                            <div class="col-md-4">
                                <label for="nama">Patient Name</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="nama" id="nama" value="<?php echo "$nama"; ?>">
                            </div>
                        </div>
                        <div class="row mb-3"> 
                            <div class="col-md-4">
                                <label for="id_encounter">ID Encounter</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="id_encounter" id="id_encounter" value="<?php echo "$id_encounter"; ?>">
                            </div>
                        </div>
                        <div class="row mb-3"> 
                            <div class="col-md-4">
                                <label for="tanggal_kunjungan">Tanggal Pemeriksaan</label>
                            </div>
                            <div class="col-md-8">
                                <input type="date" class="form-control" name="tanggal_kunjungan" id="tanggal_kunjungan" value="<?php echo "$TanggalKunjungan"; ?>">
                            </div>
                        </div>
                        <div class="row mb-3"> 
                            <div class="col-md-4">
                                <label for="IdPractitioner">ID Practitioner</label>
                            </div>
                            <div class="col-md-8">
                                <select name="IdPractitioner" id="IdPractitioner" class="form-control">
                                    <option value="">Pilih</option>
                                    <?php
                                        $query = mysqli_query($Conn, "SELECT*FROM referensi_practitioner ORDER BY nama ASC");
                                        while ($data = mysqli_fetch_array($query)) {
                                            if(!empty($data['id_ihs_practitioner'])){
                                                $id_ihs_practitioner_list= $data['id_ihs_practitioner'];
                                                $nama= $data['nama'];
                                                if($id_ihs_practitioner==$id_ihs_practitioner_list){
                                                    echo '<option selected value="'.$id_ihs_practitioner_list.'">'.$nama.'</option>';
                                                }else{
                                                    echo '<option value="'.$id_ihs_practitioner_list.'">'.$nama.'</option>';
                                                }
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3"> 
                            <div class="col-md-4">
                                <label for="category">Kategori</label>
                            </div>
                            <div class="col-md-8">
                                <select name="category" id="category" class="form-control">
                                    <option <?php if($category==""){echo "selected";} ?> value="">Pilih</option>
                                    <option <?php if($category=="social-history"){echo "selected";} ?> value="social-history">Social History</option>
                                    <option <?php if($category=="vital-signs"){echo "selected";} ?> value="vital-signs">Vital Signs</option>
                                    <option <?php if($category=="imaging"){echo "selected";} ?> value="imaging">Imaging</option>
                                    <option <?php if($category=="laboratory"){echo "selected";} ?> value="laboratory">Laboratory</option>
                                    <option <?php if($category=="procedure"){echo "selected";} ?> value="procedure">Procedure</option>
                                    <option <?php if($category=="survey"){echo "selected";} ?> value="survey">Survey</option>
                                    <option <?php if($category=="exam"){echo "selected";} ?> value="exam">Exam</option>
                                    <option <?php if($category=="therapy"){echo "selected";} ?> value="therapy">Therapy</option>
                                    <option <?php if($category=="activity"){echo "selected";} ?> value="activity">Activity</option>
                                </select>
                                <a href="https://terminology.hl7.org/5.2.0/CodeSystem-observation-category.html" target="_blank" class="text-success">
                                    <small>Referensi <i class="ti ti-new-window"></i></small>
                                </a>
                            </div>
                        </div>
                        
                        <div class="row mb-3"> 
                            <div class="col-md-4">
                                <label for="CodeSystemLoinc">Jenis Pemeriksaan</label>
                            </div>
                            <div class="col-md-8">
                                <select class="form-control" name="CodeSystemLoinc" id="CodeSystemLoinc">
                                    <option <?php if($observation_code==""){echo "selected";} ?> value="">Pilih</option>
                                    <option <?php if($observation_code=="8867-4"){echo "selected";} ?> value="8867-4|Heart rate">Denyut Jantung (Heart rate)</option>
                                    <option <?php if($observation_code=="8480-6"){echo "selected";} ?> value="8480-6|Systolic blood pressure">Tekanan darah sistole (Systolic blood pressure)</option>
                                    <option <?php if($observation_code=="8462-4"){echo "selected";} ?> value="8462-4|Diastolic blood pressure">Tekanan darah diastole (Diastolic blood pressure)</option>
                                    <option <?php if($observation_code=="8310-5"){echo "selected";} ?> value="8310-5|Body temperature">Suhu Tubuh (Body temperature)</option>
                                    <option <?php if($observation_code=="9279-1"){echo "selected";} ?> value="9279-1|Respiratory rate">Pernapasan (Respiratory rate)</option>
                                    <option <?php if($observation_code=="67775-7"){echo "selected";} ?> value="67775-7|Level of responsiveness">Tingkat Kesadaran (Level of responsiveness)</option>
                                </select>
                            </div>
                        </div>
                        <div id="FormLanjutanObservationEdit">
                            <?php
                                if($tipe_value=="valueQuantity"){
                                    if(!empty($raw_value)){
                                        $DecodeRawValue = json_decode($raw_value, true);
                                        $RawValue_value=$DecodeRawValue['value'];
                                        $RawValue_unit=$DecodeRawValue['unit'];
                                        $RawValue_code=$DecodeRawValue['code'];
                                    }
                                    echo '<div class="row mb-3">';
                                    echo '  <div class="col-md-4">';
                                    echo '      <label for="tipe_value">TipeData</label>';
                                    echo '  </div>';
                                    echo '  <div class="col-md-8">';
                                    echo '      <input type="text" class="form-control" name="tipe_value" id="tipe_value" value="'.$tipe_value.'">';
                                    echo '  </div>';
                                    echo '</div>';
                                    echo '<div class="row mb-3">';
                                    echo '  <div class="col-md-4">';
                                    echo '      <label for="value">Value</label>';
                                    echo '  </div>';
                                    echo '  <div class="col-md-8">';
                                    echo '      <input type="text" class="form-control" name="value" id="value" value="'.$RawValue_value.'">';
                                    echo '  </div>';
                                    echo '</div>';
                                    echo '<div class="row mb-3">';
                                    echo '  <div class="col-md-4">';
                                    echo '      <label for="unit">Unit</label>';
                                    echo '  </div>';
                                    echo '  <div class="col-md-8">';
                                    echo '      <input type="text" class="form-control" name="unit" id="unit" value="'.$RawValue_unit.'">';
                                    echo '  </div>';
                                    echo '</div>';
                                    echo '<div class="row mb-3">';
                                    echo '  <div class="col-md-4">';
                                    echo '      <label for="CodeUnit">Code Unit</label>';
                                    echo '  </div>';
                                    echo '  <div class="col-md-8">';
                                    echo '      <input type="text" class="form-control" name="CodeUnit" id="CodeUnit" value="'.$RawValue_code.'">';
                                    echo '  </div>';
                                    echo '</div>';
                                }else{
                                    if(!empty($raw_value)){
                                        $DecodeRawValue = json_decode($raw_value, true);
                                        $valueCodeableConcept=$DecodeRawValue['coding'];
                                        foreach($valueCodeableConcept as $valueCodeableConcept2){
                                            if(!empty($valueCodeableConcept2['code'])){
                                                $valueCodeableConceptCode=$valueCodeableConcept2['code'];
                                            }else{
                                                $valueCodeableConceptCode=$valueCodeableConcept2['code'];
                                            }
                                        }
                                    }else{
                                        $valueCodeableConceptCode=$valueCodeableConcept2['code'];
                                    }
                                    echo '<div class="row mb-3">';
                                    echo '  <div class="col-md-4">';
                                    echo '      <label for="tipe_value">TipeData</label>';
                                    echo '  </div>';
                                    echo '  <div class="col-md-8">';
                                    echo '      <input type="text" class="form-control" name="tipe_value" id="tipe_value" value="'.$tipe_value.'">';
                                    echo '  </div>';
                                    echo '</div>';
                                    echo '<div class="row mb-3">';
                                    echo '  <div class="col-md-4">';
                                    echo '      <label for="value">Value</label>';
                                    echo '  </div>';
                                    echo '  <div class="col-md-8">';
                                    echo '      <select class="form-control" name="value" id="value">';
                                    if($valueCodeableConceptCode=="TK000001"){
                                        echo '          <option selected value="TK000001|Alert">Sadar Baik</option>';
                                    }else{
                                        echo '          <option value="TK000001|Alert">Sadar Baik</option>';
                                    }
                                    if($valueCodeableConceptCode=="TK000002"){
                                        echo '          <option selected value="TK000002|Voice">Berespon dengan kata-kata</option>';
                                    }else{
                                        echo '          <option value="TK000002|Voice">Berespon dengan kata-kata</option>';
                                    }
                                    if($valueCodeableConceptCode=="TK000003"){
                                        echo '          <option selected value="TK000003|Pain">Hanya berespons jika dirangsang nyeri</option>';
                                    }else{
                                        echo '          <option value="TK000003|Pain">Hanya berespons jika dirangsang nyeri</option>';
                                    }
                                    if($valueCodeableConceptCode=="TK000004"){
                                        echo '          <option selected value="TK000004|Unresponsive">Pasien Tidak Sadar</option>';
                                    }else{
                                        echo '          <option value="TK000004|Unresponsive">Pasien Tidak Sadar</option>';
                                    }
                                    if($valueCodeableConceptCode=="TK000005"){
                                        echo '          <option selected value="TK000005|Gelisah">Pasien Tidak Sadar</option>';
                                    }else{
                                        echo '          <option value="TK000005|Gelisah">Pasien Tidak Sadar</option>';
                                    }
                                    if($valueCodeableConceptCode=="TK000006"){
                                        echo '          <option selected value="TK000006|Acute Confusional States">Acute Confusional States</option>';
                                    }else{
                                        echo '          <option value="TK000006|Acute Confusional States">Acute Confusional States</option>';
                                    }
                                    echo '      </select>';
                                    echo '  </div>';
                                    echo '</div>';
                                }
                            ?>
                        </div>
                        <div class="row mb-3"> 
                            <div class="col-md-4">
                                <label for="interpertasi">Interpertasi</label>
                            </div>
                            <div class="col-md-8">
                                <select name="interpertasi" id="interpertasi" class="form-control">
                                    <option <?php if($valueinterpretation_coding_code==""){echo "selected";} ?> selected value="">Pilih</option>
                                    <option <?php if($valueinterpretation_coding_code=="A"){echo "selected";} ?> value="A">Abnormal</option>
                                    <option <?php if($valueinterpretation_coding_code=="AA"){echo "selected";} ?> value="AA">Critical abnormal</option>
                                    <option <?php if($valueinterpretation_coding_code=="H"){echo "selected";} ?> value="H">High</option>
                                    <option <?php if($valueinterpretation_coding_code=="H>"){echo "selected";} ?> value="H>">Significantly high</option>
                                    <option <?php if($valueinterpretation_coding_code=="HH"){echo "selected";} ?> value="HH">Critical high</option>
                                    <option <?php if($valueinterpretation_coding_code=="LL"){echo "selected";} ?> value="LL">Critical low</option>
                                    <option <?php if($valueinterpretation_coding_code=="L"){echo "selected";} ?> value="L">Low</option>
                                    <option <?php if($valueinterpretation_coding_code=="L<"){echo "selected";} ?> value="L<">Significantly low</option>
                                    <option <?php if($valueinterpretation_coding_code=="N"){echo "selected";} ?> value="N">Normal</option>
                                </select>
                                <small>
                                    <a href="http://terminology.hl7.org/CodeSystem/v3-ObservationInterpretation" target="_blank" class="text-success">
                                        <small>Referensi <i class="ti ti-new-window"></i></small>
                                    </a>
                                </small>
                            </div>
                        </div>
                        <div class="row mb-3"> 
                            <div class="col-md-4">
                                <label for="ObservationStatus">Observation Status</label>
                            </div>
                            <div class="col-md-8">
                                <select name="ObservationStatus" id="ObservationStatus" class="form-control">
                                    <option <?php if($status==""){echo "selected";} ?> value="">Pilih</option>
                                    <option <?php if($status=="registered"){echo "selected";} ?> value="registered">Registered</option>
                                    <option <?php if($status=="preliminary"){echo "selected";} ?> value="preliminary">Preliminary</option>
                                    <option <?php if($status=="final"){echo "selected";} ?> value="final">Final</option>
                                    <option <?php if($status=="amended"){echo "selected";} ?> value="amended">Amended</option>
                                    <option <?php if($status=="corrected"){echo "selected";} ?> value="corrected">Corrected</option>
                                    <option <?php if($status=="cancelled"){echo "selected";} ?> value="cancelled">Cancelled</option>
                                    <option <?php if($status=="entered-in-error"){echo "selected";} ?> value="entered-in-error">Entered in Error</option>
                                    <option <?php if($status=="unknown"){echo "selected";} ?> value="unknown">Unknown</option>
                                </select>
                                <a href="http://hl7.org/fhir/R4/codesystem-observation-status.html#observation-status-registered" target="_blank" class="text-success">
                                    <small>Referensi <i class="ti ti-new-window"></i></small>
                                </a>
                            </div>
                        </div>
                        <div class="row mb-3"> 
                            <div class="col-md-12" id="NotifikasiEditObservation">
                                <span class="text-primary">Pastikan Data Observation Sudah Sesuai!</span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-primary">
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-sm btn-inverse mr-2">
                                    <i class="ti-save"></i> Simpan
                                </button>
                                <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">
                                    <i class="ti-close"></i> Tutup
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
<?php 
            }
        }
    } 
?>