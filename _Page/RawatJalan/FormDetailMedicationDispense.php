<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap id_kunjungan_med_dis
    if(empty($_POST['id_kunjungan_med_dis'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center text-danger mb-3">';
        echo '      ID Medication Dispense Tidak Boleh Kosong.';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_kunjungan_med_dis=$_POST['id_kunjungan_med_dis'];
        //Buka data Medication Dispense
        $id_kunjungan=getDataDetail($Conn,"kunjungan_med_dis",'id_kunjungan_med_dis',$id_kunjungan_med_dis,'id_kunjungan');
        $id_pasien=getDataDetail($Conn,"kunjungan_med_dis",'id_kunjungan_med_dis',$id_kunjungan_med_dis,'id_pasien');
        $id_resep=getDataDetail($Conn,"kunjungan_med_dis",'id_kunjungan_med_dis',$id_kunjungan_med_dis,'id_resep');
        $id_item_resep=getDataDetail($Conn,"kunjungan_med_dis",'id_kunjungan_med_dis',$id_kunjungan_med_dis,'id_item_resep');
        $id_medication_dis=getDataDetail($Conn,"kunjungan_med_dis",'id_kunjungan_med_dis',$id_kunjungan_med_dis,'id_medication_dis');
        $raw_med_dis=getDataDetail($Conn,"kunjungan_med_dis",'id_kunjungan_med_dis',$id_kunjungan_med_dis,'raw_med_dis');
        $id_akses=getDataDetail($Conn,"kunjungan_med_dis",'id_kunjungan_med_dis',$id_kunjungan_med_dis,'id_akses');
        $updatetime=getDataDetail($Conn,"kunjungan_med_dis",'id_kunjungan_med_dis',$id_kunjungan_med_dis,'updatetime');
        $strtotime=strtotime($updatetime);
        $updatetime=date('d/m/Y H:i:s',$strtotime);
        //Buka Nama Petugas
        $NamaPetugas=getDataDetail($Conn,"akses",'id_akses',$id_akses,'nama');
        //Buka Data RAW
        $data_array = json_decode($raw_med_dis, true);
        $resourceType=$data_array['resourceType'];
        $identifier=$data_array['identifier'];
        $status=$data_array['status'];
        $category=$data_array['category'];
        $medicationReference=$data_array['medicationReference'];
        $subject=$data_array['subject'];
        $context=$data_array['context'];
        $performer=$data_array['performer'];
        $location=$data_array['location'];
        $authorizingPrescription=$data_array['authorizingPrescription'];
        $quantity=$data_array['quantity'];
        $daysSupply=$data_array['daysSupply'];
        $whenPrepared=$data_array['whenPrepared'];
        $whenHandedOver=$data_array['whenHandedOver'];
        $dosageInstruction=$data_array['dosageInstruction'];
        $newJsonString = json_encode($data_array, JSON_PRETTY_PRINT);
?>
    <div class="row">
        <div class="col-md-12 accordion-block">
            <div id="accordion" role="tablist" aria-multiselectable="true">
                <div class="accordion-panel active">
                    <div class="accordion-heading" role="tab" id="HeadingDetailMedicationDispense1">
                        <h3 class="card-title accordion-title">
                            <a class="accordion-msg waves-effect waves-dark scale_active collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse_medication_dispense1" aria-expanded="false" aria-controls="collapse_medication_dispense1">
                                <dt>A. Informasi Medication Dispense</dt>
                            </a>
                        </h3>
                    </div>
                    <div id="collapse_medication_dispense1" class="panel-collapse in collapse show" role="tabpanel" aria-labelledby="HeadingDetailMedicationDispense1" style="">
                        <div class="accordion-content accordion-desc">
                            <div class="row mb-3 ml-2">
                                <div class="col-md-4">A.1 ID.Medication Dispense</div>
                                <div class="col-md-8">
                                    <code class="text text-secondary"><?php echo "$id_medication_dis"; ?></code>
                                </div>
                            </div>
                            <div class="row mb-3 ml-2">
                                <div class="col-md-4">A.2 ID.Pasien</div>
                                <div class="col-md-8">
                                    <code class="text text-secondary"><?php echo "$id_pasien"; ?></code>
                                </div>
                            </div>
                            <div class="row mb-3 ml-2">
                                <div class="col-md-4">A.3 ID.Kunjungan</div>
                                <div class="col-md-8">
                                    <code class="text text-secondary"><?php echo "$id_kunjungan"; ?></code>
                                </div>
                            </div>
                            <div class="row mb-3 ml-2">
                                <div class="col-md-4">A.4 ID.Resep</div>
                                <div class="col-md-8">
                                    <code class="text text-secondary"><?php echo "$id_resep"; ?></code>
                                </div>
                            </div>
                            <div class="row mb-3 ml-2">
                                <div class="col-md-4">A.5 ID.Item Resep</div>
                                <div class="col-md-8">
                                    <code class="text text-secondary"><?php echo "$id_item_resep"; ?></code>
                                </div>
                            </div>
                            <div class="row mb-3 ml-2">
                                <div class="col-md-4">A.6 Petugas</div>
                                <div class="col-md-8">
                                    <code class="text text-secondary"><?php echo "$NamaPetugas"; ?></code>
                                </div>
                            </div>
                            <div class="row mb-3 ml-2">
                                <div class="col-md-4">A.7 Update</div>
                                <div class="col-md-8">
                                    <code class="text text-secondary"><?php echo "$updatetime"; ?></code>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-heading" role="tab" id="HeadingDetailMedicationRequest2">
                        <h3 class="card-title accordion-title">
                            <a class="accordion-msg waves-effect waves-dark scale_active collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse_medication_dispense2" aria-expanded="false" aria-controls="collapse_medication_dispense2">
                                <dt>B. Medication Dispense (Local)</dt>
                            </a>
                        </h3>
                    </div>
                    <div id="collapse_medication_dispense2" class="panel-collapse in collapse" role="tabpanel" aria-labelledby="HeadingDetailMedicationRequest2" style="">
                        <div class="accordion-content accordion-desc">
                            <div class="row mb-3 ml-2">
                                <div class="col-md-12">
                                    <ul>
                                        <li class="mb-3">
                                            B.1 Resource Type : 
                                            <code class="text-secondary"><?php echo "$resourceType"; ?></code>
                                        </li>
                                        <li class="mb-3">
                                            B.2 Identifier
                                            <ol class="mt-3">
                                                <li class="mb-3">
                                                    Identifier 1
                                                    <ol>
                                                        <li>System : <code class="text-secondary"><?php echo $identifier['0']['system']; ?></code></li>
                                                        <li>Use : <code class="text-secondary"><?php echo $identifier['0']['use']; ?></code></li>
                                                        <li>Value : <code class="text-secondary"><?php echo $identifier['0']['value']; ?></code></li>
                                                    </ol>
                                                </li>
                                                <li class="mb-3">
                                                    Identifier 2
                                                    <ol>
                                                        <li>System : <code class="text-secondary"><?php echo $identifier['1']['system']; ?></code></li>
                                                        <li>Use : <code class="text-secondary"><?php echo $identifier['1']['use']; ?></code></li>
                                                        <li>Value : <code class="text-secondary"><?php echo $identifier['1']['value']; ?></code></li>
                                                    </ol>
                                                </li>
                                            </ol>
                                        </li>
                                        <li class="mb-3">
                                            B.3 Status : 
                                            <code class="text-secondary"><?php echo "$status"; ?></code>
                                        </li>
                                        <li class="mb-3">
                                            B.4 Category : 
                                            <ol>
                                                <li>System : <code class="text-secondary"><?php echo $category['coding']['0']['system']; ?></code></li>
                                                <li>Code : <code class="text-secondary"><?php echo $category['coding']['0']['code']; ?></code></li>
                                                <li>Display : <code class="text-secondary"><?php echo $category['coding']['0']['display']; ?></code></li>
                                            </ol>
                                        </li>
                                        <li class="mb-3">
                                            B.5 Medication Reference : 
                                            <ol>
                                                <li>Referense : <code class="text-secondary"><?php echo $medicationReference['reference']; ?></code></li>
                                                <li>Display : <code class="text-secondary"><?php echo $medicationReference['display']; ?></code></li>
                                            </ol>
                                        </li>
                                        <li class="mb-3">
                                            B.6 Subject : 
                                            <ol>
                                                <li>Referense : <code class="text-secondary"><?php echo $subject['reference']; ?></code></li>
                                                <li>Display : <code class="text-secondary"><?php echo $subject['display']; ?></code></li>
                                            </ol>
                                        </li>
                                        <li class="mb-3">
                                            B.7 Context : 
                                            <code class="text-secondary"><?php echo $context['reference']; ?></code>
                                        </li>
                                        <li class="mb-3">
                                            B.8 Performer : 
                                            <ol>
                                                <li>Referense : <code class="text-secondary"><?php echo $performer['0']['actor']['reference']; ?></code></li>
                                                <li>Display : <code class="text-secondary"><?php echo $performer['0']['actor']['display']; ?></code></li>
                                            </ol>
                                        </li>
                                        <li class="mb-3">
                                            B.9 Location : 
                                            <ol>
                                                <li>Referense : <code class="text-secondary"><?php echo $location['reference']; ?></code></li>
                                                <li>Display : <code class="text-secondary"><?php echo $location['display']; ?></code></li>
                                            </ol>
                                        </li>
                                        <li class="mb-3">
                                            B.10 Authorizing Prescription : 
                                            <ol>
                                                <li>Referense : <code class="text-secondary"><?php echo $authorizingPrescription['0']['reference']; ?></code></li>
                                            </ol>
                                        </li>
                                        <li class="mb-3">
                                            B.11 Quantity : 
                                            <ol>
                                                <li>System : <code class="text-secondary"><?php echo $quantity['system']; ?></code></li>
                                                <li>Code : <code class="text-secondary"><?php echo $quantity['code']; ?></code></li>
                                                <li>Value : <code class="text-secondary"><?php echo $quantity['value']; ?></code></li>
                                            </ol>
                                        </li>
                                        <li class="mb-3">
                                            B.12 Days Supply : 
                                            <ol>
                                                <li>Value : <code class="text-secondary"><?php echo $daysSupply['value']; ?></code></li>
                                                <li>Unit : <code class="text-secondary"><?php echo $daysSupply['unit']; ?></code></li>
                                                <li>System : <code class="text-secondary"><?php echo $daysSupply['system']; ?></code></li>
                                                <li>Code : <code class="text-secondary"><?php echo $daysSupply['code']; ?></code></li>
                                            </ol>
                                        </li>
                                        <li class="mb-3">
                                            B.13 When Prepared & Handed Over: 
                                            <ol>
                                                <li>When Prepared : <code class="text-secondary"><?php echo $whenPrepared; ?></code></li>
                                                <li>When Handed Over : <code class="text-secondary"><?php echo $whenHandedOver; ?></code></li>
                                            </ol>
                                        </li>
                                        <li class="mb-3">
                                            B.14 Dosage Instruction : 
                                            <ol>
                                                <li>Sequence : <code class="text-secondary"><?php echo $dosageInstruction['0']['sequence']; ?></code></li>
                                                <li>Text : <code class="text-secondary"><?php echo $dosageInstruction['0']['text']; ?></code></li>
                                                <li>
                                                    Timing Repeat : 
                                                    <ol>
                                                        <li>Frequency : <code class="text-secondary"><?php echo $dosageInstruction['0']['timing']['repeat']['frequency']; ?></code></li>
                                                        <li>Period : <code class="text-secondary"><?php echo $dosageInstruction['0']['timing']['repeat']['period']; ?></code></li>
                                                        <li>Period Unit : <code class="text-secondary"><?php echo $dosageInstruction['0']['timing']['repeat']['periodUnit']; ?></code></li>
                                                    </ol>
                                                </li>
                                                <li>
                                                    Dose And Rate : 
                                                    <ol>
                                                        <li>System : <code class="text-secondary"><?php echo $dosageInstruction['0']['doseAndRate']['0']['type']['coding']['0']['system']; ?></code></li>
                                                        <li>Code : <code class="text-secondary"><?php echo $dosageInstruction['0']['doseAndRate']['0']['type']['coding']['0']['code']; ?></code></li>
                                                        <li>Display : <code class="text-secondary"><?php echo $dosageInstruction['0']['doseAndRate']['0']['type']['coding']['0']['display']; ?></code></li>
                                                    </ol>
                                                </li>
                                                <li>
                                                    Dose Quantity : 
                                                    <ol>
                                                        <li>Value : <code class="text-secondary"><?php echo $dosageInstruction['0']['doseAndRate']['0']['doseQuantity']['value']; ?></code></li>
                                                        <li>Unit : <code class="text-secondary"><?php echo $dosageInstruction['0']['doseAndRate']['0']['doseQuantity']['unit']; ?></code></li>
                                                        <li>System : <code class="text-secondary"><?php echo $dosageInstruction['0']['doseAndRate']['0']['doseQuantity']['system']; ?></code></li>
                                                        <li>Code : <code class="text-secondary"><?php echo $dosageInstruction['0']['doseAndRate']['0']['doseQuantity']['code']; ?></code></li>
                                                    </ol>
                                                </li>
                                            </ol>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="row mb-3 ml-2">
                                <div class="col-md-12">
                                    <label for="RawDataMedicationDispenseLocal">Raw Data</label>
                                    <textarea name="RawDataMedicationDispenseLocal" id="RawDataMedicationDispenseLocal" class="form-control"><?php echo "$newJsonString"; ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-heading" role="tab" id="HeadingDetailMedicationDispense3">
                        <h3 class="card-title accordion-title">
                            <a class="accordion-msg waves-effect waves-dark scale_active collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse_medication_dispense3" aria-expanded="false" aria-controls="collapse_medication_dispense3" id="ShowDetailMedicationDispense">
                                <dt>C. Medication Dispense (Satu Sehat)</dt>
                            </a>
                        </h3>
                    </div>
                    <div id="collapse_medication_dispense3" class="panel-collapse in collapse" role="tabpanel" aria-labelledby="HeadingDetailMedicationDispense3" style="">
                        <div class="accordion-content accordion-desc">
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-sm btn-block btn-outline-secondary" id="ButtonGetDetailMedicationDispense" value="<?php echo "$id_medication_dis"; ?>">
                                        <i class="ti ti-reload"></i> Reload
                                    </button>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12" id="DetailMedicationDispenseSatuSehat">
                                    <div class="row">
                                        <div class="col-md-12 text-center">Belum ada data yang ditampilkan</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<script>
    $('#ShowDetailMedicationDispense').click(function(){
        $('#DetailMedicationDispenseSatuSehat').html("Loading...");
        var id_medication_dis =$('#ButtonGetDetailMedicationDispense').val();
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/RawatJalan/DetailMedicationDispenseSatuSehat.php',
            data        : {id_medication_dis: id_medication_dis},
            success     : function(data){
                $('#DetailMedicationDispenseSatuSehat').html(data);
            }
        });
    });
    $('#ButtonGetDetailMedicationDispense').click(function(){
        $('#DetailMedicationDispenseSatuSehat').html("Loading...");
        var id_medication_dis =$('#ButtonGetDetailMedicationDispense').val();
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/RawatJalan/DetailMedicationDispenseSatuSehat.php',
            data        : {id_medication_dis: id_medication_dis},
            success     : function(data){
                $('#DetailMedicationDispenseSatuSehat').html(data);
            }
        });
    });
</script>