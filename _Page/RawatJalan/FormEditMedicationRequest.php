<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap id_item_resep
    if(empty($_POST['id_item_resep'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center text-danger mb-3">';
        echo '      ID Kunjungan Tidak Boleh Kosong.';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_item_resep=$_POST['id_item_resep'];
        //Buka data Medication Request
        $id_kunjungan_med_req=getDataDetail($Conn,"kunjungan_med_req",'id_item_resep',$id_item_resep,'id_kunjungan_med_req');
        if(empty($id_kunjungan_med_req)){
            echo '<div class="row">';
            echo '  <div class="col-md-12 text-center text-danger mb-3">';
            echo '      ID Medication Request Tidak Ditemukan';
            echo '  </div>';
            echo '</div>';
        }else{
            $organization_id=getDataDetail($Conn,'setting_satusehat','status','Active','organization_id');
            $id_kunjungan=getDataDetail($Conn,"kunjungan_med_req",'id_item_resep',$id_item_resep,'id_kunjungan');
            $id_pasien=getDataDetail($Conn,"kunjungan_med_req",'id_item_resep',$id_item_resep,'id_pasien');
            $id_resep=getDataDetail($Conn,"kunjungan_med_req",'id_item_resep',$id_item_resep,'id_resep');
            $id_medication_req=getDataDetail($Conn,"kunjungan_med_req",'id_item_resep',$id_item_resep,'id_medication_req');
            $raw_med_req=getDataDetail($Conn,"kunjungan_med_req",'id_item_resep',$id_item_resep,'raw_med_req');
            $id_akses=getDataDetail($Conn,"kunjungan_med_req",'id_item_resep',$id_item_resep,'id_akses');
            $updatetime=getDataDetail($Conn,"kunjungan_med_req",'id_item_resep',$id_item_resep,'updatetime');
            //Buka Nama Petugas
            $NamaPetugas=getDataDetail($Conn,"akses",'id_akses',$id_akses,'nama');
            //Buka data RAW
            $data_array = json_decode($raw_med_req, true);
            $resourceType=$data_array['resourceType'];
            $identifier=$data_array['identifier'];
            //identifier1
            $identifier_system1=$identifier['0']['system'];
            $identifier_use1=$identifier['0']['use'];
            $identifier_value1=$identifier['0']['value'];

            //identifier2
            $identifier_system2=$identifier['1']['system'];
            $identifier_use2=$identifier['1']['use'];
            $identifier_value2=$identifier['1']['value'];
            //Status & Intent
            $status=$data_array['status'];
            $intent=$data_array['intent'];
            //Category
            $category=$data_array['category'];
            $category_coding=$category['0']['coding'];
            $category_coding_system=$category_coding['0']['system'];
            $category_coding_code=$category_coding['0']['code'];
            $category_coding_display=$category_coding['0']['display'];
            if($category_coding_code=="inpatient"){
                $category_keterangan="Peresepan untuk diadministr asikan atau dikonsumsi saat rawat inap";
            }else{
                if($category_coding_code=="outpatient"){
                    $category_keterangan="Peresepan untuk diadministr asikan atau dikonsumsi saat rawat  jalan (cth. IGD, poliklinik rawat jalan, bedah rawat jalan, dll)";
                }else{
                    if($category_coding_code=="community"){
                        $category_keterangan="Peresepan untuk diadministr asikan atau dikonsumsi di rumah (long term care atau nursing home, atau hospices)";
                    }else{
                        if($category_coding_code=="discharge"){
                            $category_keterangan="Peresepan obat yang dibuat ketika pasien dipulangkan dari fasilitas kesehatan";
                        }else{
                            $category_keterangan="";
                        }
                    }
                }
            }
            //priority
            $priority=$data_array['priority'];
            //medicationReference
            $medicationReference=$data_array['medicationReference'];
            $medicationReference_reference=$medicationReference['reference'];
            $medicationReference_reference=str_replace("Medication/", "", $medicationReference_reference);;
            $medicationReference_display=$medicationReference['display'];
            //Subject
            $subject=$data_array['subject'];
            $subject_reference=$subject['reference'];
            $subject_display=$subject['display'];
            //Encounter
            $encounter=$data_array['encounter'];
            $encounter_reference=$encounter['reference'];
            //authoredOn
            $authoredOn=$data_array['authoredOn'];
            //requester
            $requester=$data_array['requester'];
            $requester_reference=$requester['reference'];
            $requester_display=$requester['display'];
            //reasonCode
            $reasonCode=$data_array['reasonCode'];
            $reasonCode_coding=$reasonCode['0']['coding'];
            $reasonCode_coding_system=$reasonCode_coding['0']['system'];
            $reasonCode_coding_code=$reasonCode_coding['0']['code'];
            $reasonCode_coding_display=$reasonCode_coding['0']['display'];
            //course Of Therapy Type
            $courseOfTherapyType=$data_array['courseOfTherapyType'];
            $courseOfTherapyType_coding=$courseOfTherapyType['coding'];
            $courseOfTherapyType_coding_system=$courseOfTherapyType_coding['0']['system'];
            $courseOfTherapyType_coding_code=$courseOfTherapyType_coding['0']['code'];
            $courseOfTherapyType_coding_display=$courseOfTherapyType_coding['0']['display'];
            if($courseOfTherapyType_coding_code=="continuous"){
                $courseOfTherapyType_coding_keterangan="Pengobatan yang diharapkan berlanjut hingga permintaan selanjutnya dan pasien harus diasumsikan mengonsums inya kecuali jika dihentikan secara eksplisit";
            }else{
                if($courseOfTherapyType_coding_code=="acute"){
                    $courseOfTherapyType_coding_keterangan="Pengobatan pasien yang diharapkan dikonsumsi pada durasi pemberian tertentu dan tidak diberikan lagi";
                }else{
                    if($courseOfTherapyType_coding_code=="seasonal"){
                        $courseOfTherapyType_coding_keterangan="Pengobatan yang diharapkan digunakan pada waktu tertentu pada waktu yang telah dijadwalkan dalam setahun";
                    }else{
                        $courseOfTherapyType_coding_keterangan="";
                    }
                }
            }
            //Dosage Instruction
            $dosageInstruction=$data_array['dosageInstruction'];
            $dosageInstruction_sequence=$dosageInstruction['0']['sequence'];
            $dosageInstruction_text=$dosageInstruction['0']['text'];
            $additionalInstruction=$dosageInstruction['0']['additionalInstruction'];
            $additionalInstruction_text=$additionalInstruction['0']['text'];
            $patientInstruction=$dosageInstruction['0']['patientInstruction'];
            $timing=$dosageInstruction['0']['timing'];
            $repeat=$timing['repeat'];
            $frequency=$repeat['frequency'];
            $period=$repeat['period'];
            $periodUnit=$repeat['periodUnit'];
            $route=$dosageInstruction['0']['route'];
            //route_coding
            $route_coding=$route['coding'];
            $route_coding_system=$route_coding['0']['system'];
            $route_coding_code=$route_coding['0']['code'];
            $route_coding_display=$route_coding['0']['display'];
            //doseAndRate
            $doseAndRate=$dosageInstruction['0']['doseAndRate'];
            $doseAndRate_type=$doseAndRate['0']['type'];
            $doseAndRate_type_coding=$doseAndRate_type['coding'];
            $doseAndRate_type_coding_system=$doseAndRate_type_coding['0']['system'];
            $doseAndRate_type_coding_code=$doseAndRate_type_coding['0']['code'];
            $doseAndRate_type_coding_display=$doseAndRate_type_coding['0']['display'];
            //doseQuantity
            $doseQuantity=$doseAndRate['0']['doseQuantity'];
            $doseQuantity_value=$doseQuantity['value'];
            $doseQuantity_unit=$doseQuantity['unit'];
            $doseQuantity_system=$doseQuantity['system'];
            $doseQuantity_code=$doseQuantity['code'];
            $dosageInstruction_patientInstruction=$dosageInstruction['0']['patientInstruction'];
            //dispenseRequest
            $dispenseRequest=$data_array['dispenseRequest'];
            $dispenseInterval=$dispenseRequest['dispenseInterval'];
            $validityPeriod=$dispenseRequest['validityPeriod'];
            $numberOfRepeatsAllowed=$dispenseRequest['numberOfRepeatsAllowed'];
            $quantity=$dispenseRequest['quantity'];
            $expectedSupplyDuration=$dispenseRequest['expectedSupplyDuration'];
            $performer=$dispenseRequest['performer'];
            //dispenseInterval
            $dispenseInterval_value=$dispenseInterval['value'];
            $dispenseInterval_unit=$dispenseInterval['unit'];
            $dispenseInterval_system=$dispenseInterval['system'];
            $dispenseInterval_code=$dispenseInterval['code'];
            //validityPeriod
            $validityPeriod_start=$validityPeriod['start'];
            $validityPeriod_end=$validityPeriod['end'];
            $validityPeriod_start = date("Y-m-d", strtotime($validityPeriod_start));
            $validityPeriod_end = date("Y-m-d", strtotime($validityPeriod_end));
            //quantity
            $quantity_value=$quantity['value'];
            $quantity_unit=$quantity['unit'];
            $quantity_system=$quantity['system'];
            $quantity_code=$quantity['code'];
            //expectedSupplyDuration
            $expectedSupplyDuration_value=$expectedSupplyDuration['value'];
            $expectedSupplyDuration_unit=$expectedSupplyDuration['unit'];
            $expectedSupplyDuration_system=$expectedSupplyDuration['system'];
            $expectedSupplyDuration_code=$expectedSupplyDuration['code'];
            //performer
            $performer_reference=$performer['reference'];
?>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="id_medication_req">ID Medication Request</label>
        </div>
        <div class="col-md-8">
            <input type="text" readonly name="id_medication_req" id="id_medication_req" class="form-control" value="<?php echo $id_medication_req; ?>">
        </div>
    </div>
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
                    <input type="text" readonly name="id_pasien" class="form-control" value="<?php echo $id_pasien; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="id_kunjungan">A.2.ID Kunjungan</label>
                </div>
                <div class="col-md-8">
                    <input type="text" readonly name="id_kunjungan" class="form-control" value="<?php echo $id_kunjungan; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="encounter_reference">A.3.ID Encounter</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="encounter_reference" class="form-control" value="<?php echo "$encounter_reference"; ?>">
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
                    <label for="PilihIdResepEdit">B.1.Pilih Id Resep</label>
                </div>
                <div class="col-md-8">
                    <select name="id_resep" id="PilihIdResepEdit" class="form-control">
                        <option value="">Pilih</option>
                        <?php
                            $query = mysqli_query($Conn, "SELECT*FROM resep WHERE id_kunjungan='$id_kunjungan'");
                            while ($data = mysqli_fetch_array($query)) {
                                $iDResepList= $data['id_resep'];
                                $tanggal_resep= $data['tanggal_resep'];
                                if($iDResepList==$id_resep){
                                    echo '<option selected value="'.$id_resep.'">ID.'.$id_resep.' ('.$tanggal_resep.')</option>';
                                }else{
                                    echo '<option value="'.$id_resep.'">ID.'.$id_resep.' ('.$tanggal_resep.')</option>';
                                }
                                
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div id="ValidasiIdResep1Edit">
                <!-- Informasi Validasi Resep Disini -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="identifier_system1">B.1.1.Identifier System (1)</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="identifier_system1" id="identifier_system1" class="form-control" value="http://sys-ids.kemkes.go.id/prescription/<?php echo $organization_id;?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="identifier_use1">B.1.2.Identifier Use (1)</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="identifier_use1" id="identifier_use1" class="form-control" value="official">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="identifier_value1">B.1.3.Identifier Value (1)</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="identifier_value1" id="identifier_value1" class="form-control" value="<?php echo $id_resep;?>">
                    </div>
                </div>
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
                    <label for="PilihItemResepEdit">C.1.Pilih Item Resep</label>
                </div>
                <div class="col-md-8">
                    <select name="id_item_resep" id="PilihItemResepEdit" class="form-control">
                        <option value="">Pilih</option>
                        <?php
                            $DataObat=getDataDetail($Conn,"resep",'id_resep',$id_resep,'obat');
                            $JsonDecodeObat =json_decode($DataObat, true);
                            //Buka List Obat
                            foreach($JsonDecodeObat as $ListObat){
                                $id=$ListObat['id'];
                                $id_obat=$ListObat['id_obat'];
                                $nama_obat=$ListObat['nama_obat'];
                                if($id_item_resep=="$id_resep-$id-$id_obat"){
                                    echo '<option selected value="'.$id_resep.'-'.$id.'-'.$id_obat.'">'.$nama_obat.'</option>';
                                }else{
                                    echo '<option value="'.$id_resep.'-'.$id.'-'.$id_obat.'">'.$nama_obat.'</option>';
                                }
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div id="ValidasiIdResep2Edit">
                <!-- Informasi Validasi Resep Disini -->
                <?php
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-4">';
                    echo '      <label for="identifier_system2">C.1.1.Identifier System (2)</label>';
                    echo '  </div>';
                    echo '  <div class="col-md-8">';
                    echo '      <input type="text" name="identifier_system2" id="identifier_system2" class="form-control" value="http://sys-ids.kemkes.go.id/prescription/'.$organization_id.'">';
                    echo '  </div>';
                    echo '</div>';
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-4">';
                    echo '      <label for="identifier_use2">C.1.2.Identifier Use (2)</label>';
                    echo '  </div>';
                    echo '  <div class="col-md-8">';
                    echo '      <input type="text" name="identifier_use2" id="identifier_use2" class="form-control" value="official">';
                    echo '  </div>';
                    echo '</div>';
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-4">';
                    echo '      <label for="identifier_value2">C.1.2.Identifier Value (2)</label>';
                    echo '  </div>';
                    echo '  <div class="col-md-8">';
                    echo '      <input type="text" name="identifier_value2" id="identifier_value2" class="form-control" value="'.$id.'">';
                    echo '  </div>';
                    echo '</div>';
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-4">';
                    echo '      <label for="medicationReference_reference">C.2.Medication Reference</label>';
                    echo '  </div>';
                    echo '  <div class="col-md-8">';
                    echo '      <input type="text" name="medicationReference_reference" id="medicationReference_reference" class="form-control" value="'.$medicationReference_reference.'">';
                    echo '  </div>';
                    echo '</div>';
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-4">';
                    echo '      <label for="medicationReference_display">C.3.Medication Display</label>';
                    echo '  </div>';
                    echo '  <div class="col-md-8">';
                    echo '      <input type="text" name="medicationReference_display" id="medicationReference_display" class="form-control" value="'.$medicationReference_display.'">';
                    echo '  </div>';
                    echo '</div>';
                ?>
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
                        <option <?php if($status==""){echo "selected";} ?> value="">Pilih</option>
                        <option <?php if($status=="active"){echo "selected";} ?> value="active">Aktif</option>
                        <option <?php if($status=="on-hold"){echo "selected";} ?> value="on-hold">Tertahan</option>
                        <option <?php if($status=="cancelled"){echo "selected";} ?> value="cancelled">Dibatalkan</option>
                        <option <?php if($status=="completed"){echo "selected";} ?> value="completed">Komplit</option>
                        <option <?php if($status=="entered-in-error"){echo "selected";} ?> value="entered-in-error">Salah</option>
                        <option <?php if($status=="cancelled"){echo "selected";} ?> value="cancelled">Dibatalkan</option>
                        <option <?php if($status=="stopped"){echo "selected";} ?> value="stopped">Dihentikan</option>
                        <option <?php if($status=="draft"){echo "selected";} ?> value="draft">Draft/butuh verifikasi</option>
                        <option <?php if($status=="unknown"){echo "selected";} ?> value="unknown">Tidak diketahui</option>
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
                        <option <?php if($intent==""){echo "selected";} ?> value="">Pilih</option>
                        <option <?php if($intent=="proposal"){echo "selected";} ?> value="proposal">Proposal</option> 
                        <option <?php if($intent=="plan"){echo "selected";} ?> value="plan">Plan</option>
                        <option <?php if($intent=="order"){echo "selected";} ?> value="order">Order</option>
                        <option <?php if($intent=="original-order"){echo "selected";} ?> value="original-order">Original-Order</option>
                        <option <?php if($intent=="reflex-order"){echo "selected";} ?> value="reflex-order">Reflex-Order</option>
                        <option <?php if($intent=="filler-order"){echo "selected";} ?> value="filler-order">Filler-Order</option>
                        <option <?php if($intent=="instance-order"){echo "selected";} ?> value="instance-order">Instance-Order</option>
                        <option <?php if($intent=="unknown"){echo "selected";} ?> value="unknown">Unknown</option>
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
                        <option <?php if($priority==""){echo "selected";} ?> value="">Pilih</option>
                        <option <?php if($priority=="routine"){echo "selected";} ?> value="routine">Routine (Prioritas normal)</option>
                        <option <?php if($priority=="urgent"){echo "selected";} ?> value="urgent">Urgent (Permintaan yang harus dilakukan lebih prioritas Routine)</option>
                        <option <?php if($priority=="asap"){echo "selected";} ?> value="asap">Asap (Permintaan yang harus dilakukan lebih prioritas Urgent)</option>
                        <option <?php if($priority=="stat"){echo "selected";} ?> value="stat">Stat (Permintaan yang harus dilakukan diberikan saat itu juga)</option>
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
                    <input type="text" name="numberOfRepeatsAllowed" id="numberOfRepeatsAllowed" class="form-control" value="<?php echo "$numberOfRepeatsAllowed"; ?>">
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
                        <option <?php if($category_coding_code==""){echo "selected";} ?> value="">Pilih</option>
                        <option <?php if($category_coding_code=="inpatient"){echo "selected";} ?> value="inpatient">Inpatient</option>
                        <option <?php if($category_coding_code=="outpatient"){echo "selected";} ?> value="outpatient">Outpatient</option>
                        <option <?php if($category_coding_code=="community"){echo "selected";} ?> value="community">Community</option>
                        <option <?php if($category_coding_code=="discharge"){echo "selected";} ?> value="discharge">Discharge</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-12 mb-3" id="ValidasiKategoriMedicationRequest">
            <?php
                echo '<div class="row mb-3">';
                echo '  <div class="col-md-4">';
                echo '      <label for="MedicationRequestCategorySystem">E.1.1 System</label>';
                echo '  </div>';
                echo '  <div class="col-md-8">';
                echo '      <input type="text" name="MedicationRequestCategorySystem" id="MedicationRequestCategorySystem" class="form-control" value="'. $category_coding_system.'">';
                echo '  </div>';
                echo '</div>';
                echo '<div class="row mb-3">';
                echo '  <div class="col-md-4">';
                echo '      <label for="MedicationRequestCategoryCode">E.1.2 Code</label>';
                echo '  </div>';
                echo '  <div class="col-md-8">';
                echo '      <input type="text" name="MedicationRequestCategoryCode" id="MedicationRequestCategoryCode" class="form-control" value="'. $category_coding_code.'">';
                echo '  </div>';
                echo '</div>';
                echo '<div class="row mb-3">';
                echo '  <div class="col-md-4">';
                echo '      <label for="MedicationRequestCategoryDisplay">E.1.3 Display</label>';
                echo '  </div>';
                echo '  <div class="col-md-8">';
                echo '      <input type="text" name="MedicationRequestCategoryDisplay" id="MedicationRequestCategoryDisplay" class="form-control" value="'. $category_coding_display.'">';
                echo '      <small>'.$category_keterangan.'</small>';
                echo '  </div>';
                echo '</div>';
            ?>
        </div>
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
                    <input type="text" name="MedicationRequestSubjectReference" id="MedicationRequestSubjectReference" class="form-control" value="<?php echo "$subject_reference"; ?>">
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
                    <input type="text" name="MedicationRequestSubjectDisplay" id="MedicationRequestSubjectDisplay" class="form-control" value="<?php echo "$subject_display"; ?>">
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
                    <label for="MedicationRequestRequesteredit">F.1.Pilih Nakes</label>
                </div>
                <div class="col-md-8">
                    <select name="MedicationRequestRequester" id="MedicationRequestRequesteredit" class="form-control">
                        <option value="">Pilih</option>
                        <?php
                            $query = mysqli_query($Conn, "SELECT*FROM referensi_practitioner");
                            while ($data = mysqli_fetch_array($query)) {
                                $id_ihs_practitioner= $data['id_ihs_practitioner'];
                                $nama_nakes= $data['nama'];
                                if("Practitioner/$id_ihs_practitioner"==$requester_reference){
                                    echo '<option selected value="'.$id_ihs_practitioner.'">'.$nama_nakes.'</option>';
                                }else{
                                    echo '<option value="'.$id_ihs_practitioner.'">'.$nama_nakes.'</option>';
                                }
                                
                            }
                        ?>
                    </select>
                    <small>
                        Tenaga kesehatan (Practitioner) yang membuat peresepan
                    </small>
                </div>
            </div>
        </div>
        <div class="col-md-12 mb-3" id="ValidasiRequesterMedicationRequestEdit">
            <?php
                echo '<div class="row mb-3">';
                echo '  <div class="col-md-4">';
                echo '      <label for="requester_referense">F.1.1.Reference</label>';
                echo '  </div>';
                echo '  <div class="col-md-8">';
                echo '      <input type="text" name="requester_referense" id="requester_referense" class="form-control" value="'.$requester_reference.'">';
                echo '      <small>Requester Reference diisi dengan format : Practitioner/{id practitioner}</small>';
                echo '  </div>';
                echo '</div>';
                echo '<div class="row mb-3">';
                echo '  <div class="col-md-4">';
                echo '      <label for="requester_display">F.1.2.Display</label>';
                echo '  </div>';
                echo '  <div class="col-md-8">';
                echo '      <input type="text" name="requester_display" id="requester_display" class="form-control" value="'.$requester_display.'">';
                echo '      <small>Nama lengkap practitioner sesuai IHS</small>';
                echo '  </div>';
                echo '</div>';
            ?>
        </div>
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
                    <select name="MedicationRequestReferenceDiagnose" id="MedicationRequestReferenceDiagnoseEdit" class="form-control">
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
                        <input type="text" name="MedicationRequestKeywordDiagnosa" id="MedicationRequestKeywordDiagnosaEdit" class="form-control" placeholder="ex: E10.9">
                        <button type="button" class="btn btn-sm btn-secondary" id="PencarianMeedicationRequestDiagnosaListEdit">
                            <i class="ti ti-search"></i> Cari
                        </button>
                    </div>
                    <div class="row">
                        <div class="col-md-12" id="MeedicationRequestDiagnosaListEdit">

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
                    <input type="text" class="form-control" name="MedicationRequestreasonCode_code" id="MedicationRequestreasonCode_code" value="<?php echo "$reasonCode_coding_code" ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="MedicationRequestreasonCode_display">G.5.Reson Code Display</label>
                </div>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="MedicationRequestreasonCode_display" id="MedicationRequestreasonCode_display" value="<?php echo "$reasonCode_coding_display" ?>">
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
                    <label for="MedicationRequestCourseOfTherapyTypeEdit">I.1.Pilih Course Of Therapy</label>
                </div>
                <div class="col-md-8">
                    <select name="MedicationRequestCourseOfTherapyType" id="MedicationRequestCourseOfTherapyTypeEdit" class="form-control">
                        <option <?php if($courseOfTherapyType_coding_code==""){echo "selected";} ?> value="">Pilih</option>
                        <option <?php if($courseOfTherapyType_coding_code=="continuous"){echo "selected";} ?> value="continuous">Continuing long term therapy</option>
                        <option <?php if($courseOfTherapyType_coding_code=="acute"){echo "selected";} ?> value="acute">Short course (acute) therapy</option>
                        <option <?php if($courseOfTherapyType_coding_code=="seasonal"){echo "selected";} ?> value="seasonal">Seasonal</option>
                    </select>
                </div>
            </div>
            <div id="ValidasicourseOfTherapyTypeEdit">
                <?php
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-4">';
                    echo '      <label for="courseOfTherapyType_system">I.2.System</label>';
                    echo '  </div>';
                    echo '  <div class="col-md-8">';
                    echo '      <input type="text" name="courseOfTherapyType_system" id="courseOfTherapyType_system" class="form-control" value="'. $courseOfTherapyType_coding_system.'">';
                    echo '  </div>';
                    echo '</div>';
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-4">';
                    echo '      <label for="courseOfTherapyType_code">I.3.Code</label>';
                    echo '  </div>';
                    echo '  <div class="col-md-8">';
                    echo '      <input type="text" name="courseOfTherapyType_code" id="courseOfTherapyType_code" class="form-control" value="'. $courseOfTherapyType_coding_code.'">';
                    echo '  </div>';
                    echo '</div>';
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-4">';
                    echo '      <label for="courseOfTherapyType_display">I.4.Display</label>';
                    echo '  </div>';
                    echo '  <div class="col-md-8">';
                    echo '      <input type="text" name="courseOfTherapyType_display" id="courseOfTherapyType_display" class="form-control" value="'. $courseOfTherapyType_coding_display.'">';
                    echo '      <small>'.$courseOfTherapyType_coding_keterangan.'</small>';
                    echo '  </div>';
                    echo '</div>';
                ?>
            </div>
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
                    <input type="text" class="form-control" name="dosageInstruction_sequence" id="dosageInstruction_sequence" value="<?php echo "$dosageInstruction_sequence"; ?>">
                    <small>Urutan aturan pemakaian dari obat.</small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="dosageInstruction_text">J.2.Text</label>
                </div>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="dosageInstruction_text" id="dosageInstruction_text" value="<?php echo "$dosageInstruction_text"; ?>">
                    <small>Aturan pakai obat dalam bentuk naratif</small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="dosageInstruction_additionalInstruction">J.3.Additional Instruction</label>
                </div>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="dosageInstruction_additionalInstruction" id="dosageInstruction_additionalInstruction" value="<?php echo "$additionalInstruction_text"; ?>">
                    <small>Berkaitan dengan instruksi tambahan bagi pasien mengenai bagaimana penggunaan obat</small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="patientInstruction">J.4.Patient Instruction</label>
                </div>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="patientInstruction" id="patientInstruction" value="<?php echo "$patientInstruction"; ?>">
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
                    <input type="text" class="form-control" name="timing_repeat_frequency" id="timing_repeat_frequency" value="<?php echo "$frequency"; ?>">
                    <small>Frekuensi pengulangan dalam jangka waktu (period) tertentu</small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="timing_repeat_period">K.1.Period</label>
                </div>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="timing_repeat_period" id="timing_repeat_period" value="<?php echo "$period"; ?>">
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
                                    if($periodUnit=="$ucum_code"){
                                        echo '<option selected value="'.$ucum_code.'">'.$ucum_display.'</option>';
                                    }else{
                                        echo '<option value="'.$ucum_code.'">'.$ucum_display.'</option>';
                                    }
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
                    <label for="PilihDosageInstructionRoutEdit">L.1.Pilih Rout</label>
                </div>
                <div class="col-md-8">
                    <select class="form-control" name="PilihDosageInstructionRout" id="PilihDosageInstructionRoutEdit">
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
                                    if($route_coding_code==$rout_code){
                                        echo '<option selected value="'.$rout_code.'">'.$rout_display.'</option>';
                                    }else{
                                        echo '<option value="'.$rout_code.'">'.$rout_display.'</option>';
                                    }
                                }
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div id="ValidasiDosageInstructionRoutEdit">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="DosageInstructionRoutSystem">L.2.Route System</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="DosageInstructionRoutSystem" id="DosageInstructionRoutSystem" class="form-control" value="<?php echo $route_coding_system;?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="DosageInstructionRoutCode">L.3.Route Code</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="DosageInstructionRoutCode" id="DosageInstructionRoutCode" class="form-control" value="<?php echo $route_coding_code;?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="DosageInstructionRoutDisplay">L.4.Route Display</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="DosageInstructionRoutDisplay" id="DosageInstructionRoutDisplay" class="form-control" value="<?php echo $route_coding_display;?>">
                    </div>
                </div>
            </div>
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
                    <label for="DoseAndRateTypeEdit">M.1.Dose And Rate Type</label>
                </div>
                <div class="col-md-8">
                    <select class="form-control" name="DoseAndRateType" id="DoseAndRateTypeEdit">
                        <option <?php if($doseAndRate_type_coding_code==""){echo "selected";} ?> value="">Pilih</option>
                        <option <?php if($doseAndRate_type_coding_code=="calculated"){echo "selected";} ?> value="calculated">Calculated</option>
                        <option <?php if($doseAndRate_type_coding_code=="ordered"){echo "selected";} ?> value="ordered">Ordered</option>
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
                    <label for="DoseAndRateTypeCodeEdit">M.1.2.Dose And Rate Code</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="DoseAndRateTypeCode" id="DoseAndRateTypeCodeEdit" class="form-control" value="<?php echo $doseAndRate_type_coding_code; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="DoseAndRateTypeDisplayEdit">M.1.3.Dose And Rate Display</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="DoseAndRateTypeDisplay" id="DoseAndRateTypeDisplayEdit" class="form-control" value="<?php echo $doseAndRate_type_coding_display; ?>">
                    <small id="DoseAndRateTypeKeteranganEdit"></small>
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
                    <input type="text" name="DoseQuantityValue" id="DoseQuantityValue" class="form-control" value="<?php echo $doseQuantity_value; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="DoseQuantityUnitEdit">M.2.2 Dose Quantity Unit</label>
                </div>
                <div class="col-md-8">
                    <select class="form-control" name="DoseQuantityUnit" id="DoseQuantityUnitEdit">
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
                                    if($doseQuantity_unit==$UnitCode){
                                        echo '<option selected value="'.$UnitCode.'">'.$UnitDisplay.'</option>';
                                    }else{
                                        echo '<option value="'.$UnitCode.'">'.$UnitDisplay.'</option>';
                                    }
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
                    <label for="DoseQuantityCodeEdit">M.2.4 Dose Quantity Code</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="DoseQuantityCode" id="DoseQuantityCodeEdit" class="form-control" value="<?php echo $doseQuantity_code; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="DoseQuantityDisplayEdit">M.2.5 Dose Quantity Display</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="DoseQuantityDisplay" id="DoseQuantityDisplayEdit" class="form-control" value="<?php echo $doseQuantity_code; ?>">
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
                    <input type="text" name="dispenseIntervalValue" id="dispenseIntervalValue" class="form-control" value="<?php echo "$dispenseInterval_value"; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="dispenseIntervalUnitEdit">O.2.Dispense Interval Unit</label>
                </div>
                <div class="col-md-8">
                    <select name="dispenseIntervalUnit" id="dispenseIntervalUnitEdit" class="form-control">
                        <option <?php if($dispenseInterval_unit==""){echo "selected";} ?> value="">Pilih</option>
                        <option <?php if($dispenseInterval_unit=="ms"){echo "selected";} ?> value="ms">milliseconds</option>
                        <option <?php if($dispenseInterval_unit=="s"){echo "selected";} ?> value="s">second</option>
                        <option <?php if($dispenseInterval_unit=="min"){echo "selected";} ?> value="min">minutes</option>
                        <option <?php if($dispenseInterval_unit=="h"){echo "selected";} ?> value="h">hours</option>
                        <option <?php if($dispenseInterval_unit=="d"){echo "selected";} ?> value="d">days</option>
                        <option <?php if($dispenseInterval_unit=="w"){echo "selected";} ?> value="w">weeks</option>
                        <option <?php if($dispenseInterval_unit=="m"){echo "selected";} ?> value="m">months</option>
                        <option <?php if($dispenseInterval_unit=="1"){echo "selected";} ?> value="a">years</option>
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
                    <label for="dispenseIntervalCodeEdit">O.4.Dispense Interval Code</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="dispenseIntervalCode" id="dispenseIntervalCodeEdit" class="form-control" value="<?php echo $dispenseInterval_code; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="dispenseIntervalDisplayEdit">O.5.Dispense Interval Display</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="dispenseIntervalDisplay" id="dispenseIntervalDisplayEdit" class="form-control" value="<?php echo $dispenseInterval_code; ?>">
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
                    <input type="date" name="validityPeriod_start" id="validityPeriod_start" class="form-control" value="<?php echo $validityPeriod_start; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="validityPeriod_end">P.2.Validity Period End</label>
                </div>
                <div class="col-md-8">
                    <input type="date" name="validityPeriod_end" id="validityPeriod_end" class="form-control" value="<?php echo $validityPeriod_end; ?>">
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
                    <input type="text" name="quantity_value" id="quantity_value" class="form-control" value="<?php echo "$quantity_value"; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="pilih_quantity_unit_edit">Q.2 Quantity Unit</label>
                </div>
                <div class="col-md-8">
                    <select class="form-control" name="pilih_quantity_unit" id="pilih_quantity_unit_edit">
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
                                    if($quantity_unit==$UnitDisplay){
                                        echo '<option selected value="'.$UnitCode.'">'.$UnitDisplay.'</option>';
                                    }else{
                                        echo '<option value="'.$UnitCode.'">'.$UnitDisplay.'</option>';
                                    }
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
                    <label for="quantity_code_edit">Q.4.Quantity Code</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="quantity_code" id="quantity_code_edit" class="form-control" value="<?php echo "$quantity_code"; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="quantity_display_edit">Q.5.Quantity Display</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="quantity_display" id="quantity_display_edit" class="form-control" value="<?php echo "$quantity_code"; ?>">
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
                    <input type="text" name="expectedSupplyDurationValue" id="expectedSupplyDurationValue" class="form-control" value="<?php echo "$expectedSupplyDuration_value"; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="expectedSupplyDurationUnitEdit">R.2 Expected Duration Unit</label>
                </div>
                <div class="col-md-8">
                    <select name="expectedSupplyDurationUnit" id="expectedSupplyDurationUnitEdit" class="form-control">
                        <option <?php if($expectedSupplyDuration_code==""){echo "selected";} ?> value="">Pilih</option>
                        <option <?php if($expectedSupplyDuration_code=="ms"){echo "selected";} ?> value="ms">milliseconds</option>
                        <option <?php if($expectedSupplyDuration_code=="s"){echo "selected";} ?> value="s">second</option>
                        <option <?php if($expectedSupplyDuration_code=="min"){echo "selected";} ?> value="min">minutes</option>
                        <option <?php if($expectedSupplyDuration_code=="h"){echo "selected";} ?> value="h">hours</option>
                        <option <?php if($expectedSupplyDuration_code=="d"){echo "selected";} ?> value="d">days</option>
                        <option <?php if($expectedSupplyDuration_code=="w"){echo "selected";} ?> value="w">weeks</option>
                        <option <?php if($expectedSupplyDuration_code=="m"){echo "selected";} ?> value="m">months</option>
                        <option <?php if($expectedSupplyDuration_code=="a"){echo "selected";} ?> value="a">years</option>
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
                    <label for="expectedSupplyDurationCodeEdit">R.4.Expected Duration Code</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="expectedSupplyDurationCode" id="expectedSupplyDurationCodeEdit" class="form-control" value="<?php echo "$expectedSupplyDuration_code"; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="expectedSupplyDurationDisplayEdit">R.5.Expected Duration Display</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="expectedSupplyDurationDisplay" id="expectedSupplyDurationDisplayEdit" class="form-control" value="<?php echo $expectedSupplyDuration_code; ?>">
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
                                    if($performer_reference=="Organization/$ID_Org"){
                                        echo '<option selected value="'.$ID_Org.'">'.$NamaOrganisasi.'</option>';
                                    }else{
                                        echo '<option value="'.$ID_Org.'">'.$NamaOrganisasi.'</option>';
                                    }
                                }
                            }
                        ?>
                    </select>
                </div>
            </div>
        </div>
    </div>
<?php }} ?>
<script>
    $(document).ready(function(){
        //Kondisi Ketika Pilih Resep
        $('#PilihIdResepEdit').change(function(){
            var id_resep=$('#PilihIdResepEdit').val();
            $('#ValidasiIdResep1Edit').html('Loading...'); 
            $.ajax({
                type 	    : 'POST',
                url 	    : '_Page/RawatJalan/ValidasiIdResep1.php',
                data        : {id_resep: id_resep},
                success     : function(data){
                    $('#ValidasiIdResep1Edit').html(data);
                }
            });
            $('#PilihItemResepEdit').html('<option value="">Loading...</option>'); 
            $.ajax({
                type 	    : 'POST',
                url 	    : '_Page/RawatJalan/ListItemObat.php',
                data        : {id_resep: id_resep},
                success     : function(data){
                    $('#PilihItemResepEdit').html(data);
                }
            });
            if(id_resep==""){
                $('#ValidasiIdResep2Edit').html(''); 
            }
        });
        //Kondisi Ketika Pilih item Resep
        $('#PilihItemResepEdit').change(function(){
            var id_item_resep=$('#PilihItemResepEdit').val();
            $('#ValidasiIdResep2Edit').html('Loading...'); 
            $.ajax({
                type 	    : 'POST',
                url 	    : '_Page/RawatJalan/ValidasiIdResep2.php',
                data        : {id_item_resep: id_item_resep},
                success     : function(data){
                    $('#ValidasiIdResep2Edit').html(data);
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
        $('#MedicationRequestRequesteredit').change(function(){
            var Requester=$('#MedicationRequestRequesteredit').val(); 
            $('#ValidasiRequesterMedicationRequestEdit').html('<div class="row mb-3"><div class="col-md-12 text-center">Loading...</div></div>');
            $.ajax({
                type 	    : 'POST',
                url 	    : '_Page/RawatJalan/ValidasiRequesterMedicationRequest.php',
                data        : {Requester: Requester},
                success     : function(data){
                    $('#ValidasiRequesterMedicationRequestEdit').html(data);
                }
            });
        });
        //Kondisi Ketika Dilakukan Pencarian Diagnosa
        $('#PencarianMeedicationRequestDiagnosaListEdit').click(function(){
            var Referensi=$('#MedicationRequestReferenceDiagnoseEdit').val();
            var Keyword=$('#MedicationRequestKeywordDiagnosaEdit').val();
            $('#MeedicationRequestDiagnosaListEdit').html('<div class="row mb-3"><div class="col-md-12 text-center">Loading...</div></div>');
            $.ajax({
                type 	    : 'POST',
                url 	    : '_Page/RawatJalan/MedicationRequestDiagnosaList.php',
                data        : {Referensi: Referensi, Keyword: Keyword},
                success     : function(data){
                    $('#MeedicationRequestDiagnosaListEdit').html(data);
                }
            });
        });
        //Kondisi Ketika MedicationRequestCourseOfTherapyType dipilih
        $('#MedicationRequestCourseOfTherapyTypeEdit').change(function(){
            var MedicationRequestCourseOfTherapyType=$('#MedicationRequestCourseOfTherapyTypeEdit').val(); 
            $('#ValidasicourseOfTherapyTypeEdit').html('<div class="row mb-3"><div class="col-md-12 text-center">Loading...</div></div>');
            $.ajax({
                type 	    : 'POST',
                url 	    : '_Page/RawatJalan/ValidasicourseOfTherapyType.php',
                data        : {MedicationRequestCourseOfTherapyType: MedicationRequestCourseOfTherapyType},
                success     : function(data){
                    $('#ValidasicourseOfTherapyTypeEdit').html(data);
                }
            });
        });
        //Kondisi Ketika PilihDosageInstructionRout dipilih
        $('#PilihDosageInstructionRoutEdit').change(function(){
            var PilihDosageInstructionRout=$('#PilihDosageInstructionRoutEdit').val(); 
            $('#ValidasiDosageInstructionRoutEdit').html('<div class="row mb-3"><div class="col-md-12 text-center">Loading...</div></div>');
            $.ajax({
                type 	    : 'POST',
                url 	    : '_Page/RawatJalan/ValidasiDosageInstructionRout.php',
                data        : {PilihDosageInstructionRout: PilihDosageInstructionRout},
                success     : function(data){
                    $('#ValidasiDosageInstructionRoutEdit').html(data);
                }
            });
        });
        //Kondisi Ketika DoseAndRateType dipilih
        $('#DoseAndRateTypeEdit').change(function(){
            var DoseAndRateType=$('#DoseAndRateTypeEdit').val(); 
            if(DoseAndRateType==""){
                $('#DoseAndRateTypeCodeEdit').val("");
                $('#DoseAndRateTypeDisplayEdit').val("");
                $('#DoseAndRateTypeKeteranganEdit').html("");
            }else{
                if(DoseAndRateType=="calculated"){
                    $('#DoseAndRateTypeCodeEdit').val("calculated");
                    $('#DoseAndRateTypeDisplayEdit').val("Calculated");
                    $('#DoseAndRateTypeKeteranganEdit').html("Dosis yang ditentukan dihitung oleh sistem atau yang meresepkan obat");
                }else{
                    if(DoseAndRateType=="ordered"){
                        $('#DoseAndRateTypeCodeEdit').val("ordered");
                        $('#DoseAndRateTypeDisplayEdit').val("Ordered");
                        $('#DoseAndRateTypeKeteranganEdit').html("Dosis yang ditentukan seperti yang diminta peresep obat");
                    }
                }
            }
        });
        //Kondisi Ketika DoseQuantityUnitEdit dipilih
        $('#DoseQuantityUnitEdit').change(function(){
            var data_code=$('#DoseQuantityUnitEdit').val(); 
            var data_display = $(this).find('option:selected').text();
            //Tempel
            $('#DoseQuantityCodeEdit').val(data_code);
            $('#DoseQuantityDisplayEdit').val(data_display);
        });
        //Kondisi Ketika dispenseIntervalUnitEdit dipilih
        $('#dispenseIntervalUnitEdit').change(function(){
            var data_code=$('#dispenseIntervalUnitEdit').val(); 
            var data_display = $(this).find('option:selected').text();
            //Tempel
            $('#dispenseIntervalCodeEdit').val(data_code);
            $('#dispenseIntervalDisplayEdit').val(data_display);
        });
        //Kondisi Ketika pilih_quantity_unit_edit dipilih
        $('#pilih_quantity_unit_edit').change(function(){
            var quantity_code=$('#pilih_quantity_unit_edit').val(); 
            var quantity_display = $(this).find('option:selected').text();
            //Tempel
            $('#quantity_code_edit').val(quantity_code);
            $('#quantity_display_edit').val(quantity_display);
        });
        //Kondisi Ketika expectedSupplyDurationUnitEdit dipilih
        $('#expectedSupplyDurationUnitEdit').change(function(){
            var expectedSupplyDurationCode=$('#expectedSupplyDurationUnitEdit').val(); 
            var expectedSupplyDurationDisplay = $(this).find('option:selected').text();
            //Tempel
            $('#expectedSupplyDurationCodeEdit').val(expectedSupplyDurationCode);
            $('#expectedSupplyDurationDisplayEdit').val(expectedSupplyDurationDisplay);
        });
    });
</script>