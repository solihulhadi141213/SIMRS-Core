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
        $organization_id=getDataDetail($Conn,'setting_satusehat','status','Active','organization_id');
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
        $whenPrepared_tanggal = date("Y-m-d", strtotime($whenPrepared));
        $whenPrepared_jam = date("H:i", strtotime($whenPrepared));
        $whenHandedOver=$data_array['whenHandedOver'];
        $whenHandedOver_tanggal = date("Y-m-d", strtotime($whenHandedOver));
        $whenHandedOver_jam = date("H:i", strtotime($whenHandedOver));
        $dosageInstruction=$data_array['dosageInstruction'];
        $newJsonString = json_encode($data_array, JSON_PRETTY_PRINT);
?>
    <input type="hidden" name="id_medication_dis" class="form-control" value="<?php echo $id_medication_dis; ?>">
    <div class="row mb-4 sub-title">
        <div class="col-md-12 mb-3">
            <dt>A. Informasi Pasien</dt>
        </div>
        <div class="col-md-12">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label>A.1.No.RM</label>
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
                    <input type="text" name="encounter_reference" class="form-control" value="<?php echo $context['reference']; ?>">
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
                    <label for="PilihIdResepMedicationDispense">B.1.Pilih Id Resep</label>
                </div>
                <div class="col-md-8">
                    <select name="id_resep" id="PilihIdResepMedicationDispense" class="form-control">
                        <option value="">Pilih</option>
                        <?php
                            $query = mysqli_query($Conn, "SELECT*FROM resep WHERE id_kunjungan='$id_kunjungan'");
                            while ($data = mysqli_fetch_array($query)) {
                                $IdResepList= $data['id_resep'];
                                $TanggalResepList= $data['tanggal_resep'];
                                if($id_resep==$IdResepList){
                                    echo '<option selected value="'.$IdResepList.'">ID.'.$IdResepList.' ('.$TanggalResepList.')</option>';
                                }else{
                                    echo '<option value="'.$IdResepList.'">ID.'.$IdResepList.' ('.$TanggalResepList.')</option>';
                                }
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div id="ValidasiResepMedicationDispense">
                <!-- Informasi Validasi Resep Disini -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="identifier_system_dispense1">B.1.1.Identifier System (1)</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="identifier_system1" id="identifier_system_dispense1" class="form-control" value="http://sys-ids.kemkes.go.id/prescription/<?php echo $organization_id;?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="identifier_use_dispense1">B.1.2.Identifier Use (1)</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" readonly name="identifier_use1" id="identifier_use_dispense1" class="form-control" value="official">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="identifier_value_dispense1">B.1.3.Identifier Value (1)</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="identifier_value1" id="identifier_value_dispense1" class="form-control" value="<?php echo $IdResepList; ?>">
                        <small>ID Induk Resep Obat</small>
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
                    <label for="PilihItemResepMedicationDispense">C.1.Pilih Item Resep</label>
                </div>
                <div class="col-md-8">
                    <select name="id_item_resep" id="PilihItemResepMedicationDispense" class="form-control">
                        <?php
                            $DataObat=getDataDetail($Conn,"resep",'id_resep',$id_resep,'obat');
                            $JsonItemObat =json_decode($DataObat, true);
                            //Buka List Obat
                            foreach($JsonItemObat as $ListObat){
                                $IdItemObatLit=$ListObat['id'];
                                $IdObatList=$ListObat['id_obat'];
                                $NamaObatList=$ListObat['nama_obat'];
                                //Pecah ID Item Resep Dari Raw Data
                                $explode=explode('-',$id_item_resep);
                                $id_item_resep_2=$explode['1'];
                                if(empty($id_item_resep)){
                                    echo '<option selected value="">Pilih</option>';
                                }else{
                                    echo '<option value="">Pilih</option>';
                                }
                                if($id_item_resep_2==$IdItemObatLit){
                                    echo '<option selected value="'.$id_resep.'-'.$IdItemObatLit.'-'.$IdObatList.'">'.$NamaObatList.'</option>';
                                }else{
                                    echo '<option value="'.$id_resep.'-'.$IdItemObatLit.'-'.$IdObatList.'">'.$NamaObatList.'</option>';
                                }
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div id="ValidasiItemResepMedicationDispense">
                <!-- Informasi Validasi Resep Disini -->
                <?php
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-4">';
                    echo '      <label for="identifier_system_dispense2">C.1.1.Identifier System (2)</label>';
                    echo '  </div>';
                    echo '  <div class="col-md-8">';
                    echo '      <input type="text" name="identifier_system2" id="identifier_system_dispense2" class="form-control" value="http://sys-ids.kemkes.go.id/prescription/'.$organization_id.'">';
                    echo '  </div>';
                    echo '</div>';
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-4">';
                    echo '      <label for="identifier_use_dispense2">C.1.2.Identifier Use (2)</label>';
                    echo '  </div>';
                    echo '  <div class="col-md-8">';
                    echo '      <input type="text" name="identifier_use2" id="identifier_use_dispense2" class="form-control" value="official">';
                    echo '  </div>';
                    echo '</div>';
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-4">';
                    echo '      <label for="identifier_value_dispense2">C.1.2.Identifier Value (2)</label>';
                    echo '  </div>';
                    echo '  <div class="col-md-8">';
                    echo '      <input type="text" name="identifier_value2" id="identifier_value_dispense2" class="form-control" value="'.$id_item_resep.'">';
                    echo '      <small>ID Item Resep Obat</small>';
                    echo '  </div>';
                    echo '</div>';
                ?>
            </div>
        </div>
    </div>
    <div class="row mb-4 sub-title">
        <div class="col-md-12 mb-3">
            <dt>D. Status Resep</dt>
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
                        <option <?php if($status=="preparation"){echo "selected";} ?> value="preparation">Persiapan</option>
                        <option <?php if($status=="in-progress"){echo "selected";} ?> value="in-progress">Dalam Proses</option>
                        <option <?php if($status=="cancelled"){echo "selected";} ?> value="cancelled">Dibatalkan</option>
                        <option <?php if($status=="on-hold"){echo "selected";} ?> value="on-hold">Tertahan</option>
                        <option <?php if($status=="completed"){echo "selected";} ?> value="completed">Lengkap</option>
                        <option <?php if($status=="entered-in-error"){echo "selected";} ?> value="entered-in-error">Salah</option>
                        <option <?php if($status=="stopped"){echo "selected";} ?> value="stopped">Dihentikan</option>
                        <option <?php if($status=="declined"){echo "selected";} ?> value="declined">Ditolak</option>
                        <option <?php if($status=="unknown"){echo "selected";} ?> value="unknown">Tidak Dikethaui</option>
                    </select>
                    <small>
                        Berkaitan dengan kode spesifik yang menunjukkan status 
                        pengobatan saat ini yang umumnya akan berupa status aktif atau komplit.
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
                    <label for="MedicationDismpenseCategory">E.1.Pilih Kategori</label>
                </div>
                <div class="col-md-8">
                    <select name="MedicationDismpenseCategory" id="MedicationDismpenseCategory" class="form-control">
                        <option <?php if($category['coding']['0']['code']==""){echo "selected";} ?> value="">Pilih</option>
                        <option <?php if($category['coding']['0']['code']=="inpatient"){echo "selected";} ?> value="inpatient">Pemberian obat untuk diadministrasikan atau dikonsumsi saat rawat inap (Inpatient)</option>
                        <option <?php if($category['coding']['0']['code']=="outpatient"){echo "selected";} ?> value="outpatient">Pemberian obat untuk diadministra sikan atau dikonsumsi saat rawat jalan(Outpatient)</option>
                        <option <?php if($category['coding']['0']['code']=="community"){echo "selected";} ?> value="community">Pemberian obat untuk diadministrasikan atau dikonsumsi dirumah(Community)</option>
                        <option <?php if($category['coding']['0']['code']=="discharge"){echo "selected";} ?> value="discharge">Pemberian obat yang dibuat ketika pasien dipulangkan dari faskes (Discharge)</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-12 mb-3">
            <?php
                echo '<div class="row mb-3">';
                echo '  <div class="col-md-4">';
                echo '      <label for="MedicationDispenseCategorySystem">E.1.1 System</label>';
                echo '  </div>';
                echo '  <div class="col-md-8">';
                echo '      <input type="text" name="MedicationDispenseCategorySystem" id="MedicationDispenseCategorySystem" class="form-control" value="'.$category['coding']['0']['system'].'">';
                echo '  </div>';
                echo '</div>';
                echo '<div class="row mb-3">';
                echo '  <div class="col-md-4">';
                echo '      <label for="MedicationDispenseCategoryCode">E.1.2 Code</label>';
                echo '  </div>';
                echo '  <div class="col-md-8">';
                echo '      <input type="text" name="MedicationDispenseCategoryCode" id="MedicationDispenseCategoryCode" class="form-control" value="'.$category['coding']['0']['code'].'">';
                echo '  </div>';
                echo '</div>';
                echo '<div class="row mb-3">';
                echo '  <div class="col-md-4">';
                echo '      <label for="MedicationDispenseCategoryDisplay">E.1.3 Display</label>';
                echo '  </div>';
                echo '  <div class="col-md-8">';
                echo '      <input type="text" name="MedicationDispenseCategoryDisplay" id="MedicationDispenseCategoryDisplay" class="form-control" value="'.$category['coding']['0']['display'].'">';
                echo '      <small id="MedicationDispenseCategoryKeterangan"></small>';
                echo '  </div>';
                echo '</div>';
            ?>
        </div>
    </div>
    <div class="row mb-4 sub-title">
        <div class="col-md-12 mb-3">
            <dt>F. Medication Reference</dt>
            <small>
                Berkaitan dengan sediaan obat yang diberikan kepada pasien
                yang merujuk pada Medication.id yang didapat setelah
                mengirimkan resource Medication.<br>
                Medication.id yang direferensi merupakan data Medication yang
                terkait proses pengeluaran obat, bukan Medication id yang
                digunakan dalam MedicationRequest
            </small>
        </div>
        <div class="col-md-12 mb-3">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="MedicationDispenseReferense">F.1.Referense</label><br>
                </div>
                <div class="col-md-8">
                    <input type="text" name="medicationReference_reference" id="MedicationDispenseReferense" class="form-control" value="<?php echo $medicationReference['reference']; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="MedicationDispenseReferenseDisplay">F.2.Display</label><br>
                </div>
                <div class="col-md-8">
                    <input type="text" name="medicationReference_display" id="MedicationDispenseReferenseDisplay" class="form-control" value="<?php echo $medicationReference['display']; ?>">
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-4 sub-title">
        <div class="col-md-12 mb-3">
            <dt>G. Subject (IHS Pasien)</dt>
        </div>
        <div class="col-md-12 mb-3">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="MedicationDispenseSubjectReference">F.1.Reference</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="MedicationDispenseSubjectReference" id="MedicationDispenseSubjectReference" class="form-control" value="<?php echo $subject['reference']; ?>">
                    <small>
                        Subject Reference Diisi dengan format: Patient/{id ihs pasien}
                    </small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="MedicationDispenseSubjectDisplay">F.2.Display</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="MedicationDispenseSubjectDisplay" id="MedicationDispenseSubjectDisplay" class="form-control" value="<?php echo $subject['display']; ?>">
                    <small>Nama lengkap pasien sesuai IHS</small>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-4 sub-title">
        <div class="col-md-12 mb-3">
            <dt>H. Performer</dt>
        </div>
        <div class="col-md-12 mb-3">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="MedicationDispensePerformer">H.1.Pilih Nakes</label>
                </div>
                <div class="col-md-8">
                    <select name="MedicationDispensePerformer" id="MedicationDispensePerformer" class="form-control">
                        <option value="">Pilih</option>
                        <?php
                            //Explode Performer
                            $IdPractitioner=$performer['0']['actor']['reference'];
                            $explode2=explode('/',$IdPractitioner);
                            $IdPractitionerPure=$explode2['1'];
                            $query = mysqli_query($Conn, "SELECT*FROM referensi_practitioner");
                            while ($data = mysqli_fetch_array($query)) {
                                $id_ihs_practitioner= $data['id_ihs_practitioner'];
                                $nama_nakes= $data['nama'];
                                if($IdPractitionerPure==$id_ihs_practitioner){
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
        <div class="col-md-12 mb-3">
            <?php
                echo '<div class="row mb-3">';
                echo '  <div class="col-md-4">';
                echo '      <label for="MedicationDispensePerformerReferense">H.2.Reference</label>';
                echo '  </div>';
                echo '  <div class="col-md-8">';
                echo '      <input type="text" name="MedicationDispensePerformerReferense" id="MedicationDispensePerformerReferense" class="form-control" value="Practitioner/'.$IdPractitionerPure.'">';
                echo '      <small>Performer Reference diisi dengan format : Practitioner/{id practitioner}</small>';
                echo '  </div>';
                echo '</div>';
                echo '<div class="row mb-3">';
                echo '  <div class="col-md-4">';
                echo '      <label for="MedicationDispensePerformerDisplay">H.3.Display</label>';
                echo '  </div>';
                echo '  <div class="col-md-8">';
                echo '      <input type="text" name="MedicationDispensePerformerDisplay" id="MedicationDispensePerformerDisplay" class="form-control" value="'.$performer['0']['actor']['display'].'">';
                echo '      <small>Nama lengkap practitioner sesuai IHS</small>';
                echo '  </div>';
                echo '</div>';
            ?>
        </div>
    </div>
    <div class="row mb-4 sub-title">
        <div class="col-md-12 mb-3">
            <dt>I. Location</dt>
            <small>
                Lokasi di mana obat diberikan. Referensi ke resource Location melalui Location.id
            </small>
        </div>
        <div class="col-md-12 mb-3">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="MedicationDispenseLocation">I.1.Pilih Location</label>
                </div>
                <div class="col-md-8">
                    <select name="MedicationDispenseLocation" id="MedicationDispenseLocation" class="form-control">
                        <option value="">Pilih</option>
                        <?php
                            $explode3=explode('/',$location['reference']);
                            $IdLocation=$explode3['1'];
                            $query = mysqli_query($Conn, "SELECT*FROM referensi_location");
                            while ($data = mysqli_fetch_array($query)) {
                                $id_location= $data['id_location'];
                                $NamaLocation= $data['nama'];
                                if($IdLocation==$id_location){
                                    echo '<option selected value="'.$id_location.'">'.$NamaLocation.'</option>';
                                }else{
                                    echo '<option value="'.$id_location.'">'.$NamaLocation.'</option>';
                                }
                            }
                        ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-12 mb-3">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="MedicationDispenseLocationReferense">I.2.Reference</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="MedicationDispenseLocationReferense" id="MedicationDispenseLocationReferense" class="form-control" value="<?php echo $location['reference']; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="MedicationDispenseLocationDisplay">I.2.Display</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="MedicationDispenseLocationDisplay" id="MedicationDispenseLocationDisplay" class="form-control" value="<?php echo $location['display']; ?>">
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-4 sub-title">
        <div class="col-md-12 mb-3">
            <dt>J. Authorizing Prescription</dt>
            <small>
                Referensi ke ID Medication Request yang terkait melalui
                Medication Request.id
            </small>
        </div>
        <div class="col-md-12 mb-3">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="MedicationDispenseAuthorizingPrescription">J.1.Medication Request</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="MedicationDispenseAuthorizingPrescription" id="MedicationDispenseAuthorizingPrescription" class="form-control" value="<?php echo $authorizingPrescription['0']['reference']; ?>">
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-4 sub-title">
        <div class="col-md-12 mb-3">
            <dt>K. Quantity</dt>
            <small>
                Jumlah obat yang dikeluarkan dalam bentuk numerical
            </small>
        </div>
        <div class="col-md-12 mb-3">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="MedicationDispenseQuantitySystem">K.1.System</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="MedicationDispenseQuantitySystem" id="MedicationDispenseQuantitySystem" class="form-control" value="<?php echo $quantity['system']; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="MedicationDispenseQuantityValue">K.2.Value</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="MedicationDispenseQuantityValue" id="MedicationDispenseQuantityValue" class="form-control" value="<?php echo $quantity['value']; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="MedicationDispenseQuantityCode">K.3.Code</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="MedicationDispenseQuantityCode" id="MedicationDispenseQuantityCode" list="orderableDrugFormList" class="form-control" value="<?php echo $quantity['code']; ?>">
                    <datalist id="orderableDrugFormList">
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
                                    echo '<option value="'.$UnitCode.'">';
                                }
                            }
                        ?>
                    </datalist>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-4 sub-title">
        <div class="col-md-12 mb-3">
            <dt>L. Day Supply</dt>
            <small>
                Jumlah pengobatan yang dinyatakan dalam satuan hari.
            </small>
        </div>
        <div class="col-md-12 mb-3">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="MedicationDispenseDaysSupplySystem">L.1.System</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="MedicationDispenseDaysSupplySystem" id="MedicationDispenseDaysSupplySystem" class="form-control" value="http://unitsofmeasure.org">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="MedicationDispenseDaysSupplyValue">L.2.Value</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="MedicationDispenseDaysSupplyValue" id="MedicationDispenseDaysSupplyValue" class="form-control" value="<?php echo $daysSupply['value']; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="MedicationDispenseDaysSupplyUnit">L.3.Unit</label>
                </div>
                <div class="col-md-8">
                    <select id="MedicationDispenseDaysSupplyUnit" name="MedicationDispenseDaysSupplyUnit" class="form-control" value="<?php echo $daysSupply['unit']; ?>">
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
        </div>
    </div>
    <div class="row mb-4 sub-title">
        <div class="col-md-12 mb-3">
            <dt>M. Waktu</dt>
        </div>
        <div class="col-md-12 mb-3">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="MedicationDispenseWhenPrepared">M.1.When Prepared</label><br>
                    <small>Berkaitan dengan waktu tanggal & jam kapan obat dikemas dan dicek</small>
                </div>
                <div class="col-md-4">
                    <input type="date" name="MedicationDispenseWhenPreparedTanggal" id="MedicationDispenseWhenPreparedTanggal" class="form-control" value="<?php echo $whenPrepared_tanggal; ?>">
                    <small>Tanggal</small>
                </div>
                <div class="col-md-4">
                    <input type="time" name="MedicationDispenseWhenPreparedJam" id="MedicationDispenseWhenPreparedJam" class="form-control" value="<?php echo $whenPrepared_jam; ?>">
                    <small>Tanggal</small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="MedicationDispenseWhenHandedOver">M.2.When Prepared</label><br>
                    <small>Berisikan data waktu pemberian obat kepada pasien atau penanggung jawab pasien</small>
                </div>
                <div class="col-md-4">
                    <input type="date" name="MedicationDispenseWhenHandedOverTanggal" id="MedicationDispenseWhenHandedOverTanggal" class="form-control" value="<?php echo $whenHandedOver_tanggal; ?>">
                    <small>Tanggal</small>
                </div>
                <div class="col-md-4">
                    <input type="time" name="MedicationDispenseWhenHandedOverJam" id="MedicationDispenseWhenHandedOverJam" class="form-control" value="<?php echo $whenHandedOver_jam; ?>">
                    <small>Tanggal</small>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-4 sub-title">
        <div class="col-md-12 mb-3">
            <dt>N. Dosage Instruction</dt>
        </div>
        <div class="col-md-12 mb-3">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="MedicationDispenseDosageInstructionSequence">N.1.Sequence</label><br>
                </div>
                <div class="col-md-8">
                    <input type="text" name="MedicationDispenseDosageInstructionSequence" id="MedicationDispenseDosageInstructionSequence" class="form-control" value="<?php echo $dosageInstruction['0']['sequence']; ?>">
                    <small>
                        Urutan aturan pemakaian dari obat. Apabila dalam peresepan aturan
                        pakai akan selalu sama dari awal sampai akhir, maka cukup
                        menuliskan 1 paket aturan pakai dengan nilai sequence=1.
                    </small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="MedicationDispenseDosageInstructionText">N.2.Text</label><br>
                </div>
                <div class="col-md-8">
                    <input type="text" name="MedicationDispenseDosageInstructionText" id="MedicationDispenseDosageInstructionText" class="form-control" value="<?php echo $dosageInstruction['0']['text']; ?>">
                    <small>
                        Aturan pakai obat dalam bentuk naratif
                    </small>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-4 sub-title">
        <div class="col-md-12 mb-3">
            <dt>O. Timing Repeat</dt>
        </div>
        <div class="col-md-12 mb-3">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="MedicationDispenseDosageInstructionTimingRepeatFrequency">O.1.Frequency</label><br>
                </div>
                <div class="col-md-8">
                    <input type="text" name="MedicationDispenseDosageInstructionTimingRepeatFrequency" id="MedicationDispenseDosageInstructionTimingRepeatFrequency" class="form-control" value="<?php echo $dosageInstruction['0']['timing']['repeat']['frequency']; ?>">
                    <small>
                        Frekuensi pengulangan dalam jangka
                        waktu (period) tertentu
                    </small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="MedicationDispenseDosageInstructionTimingRepeatPeriod">O.2.Period</label><br>
                </div>
                <div class="col-md-8">
                    <input type="text" name="MedicationDispenseDosageInstructionTimingRepeatPeriod" id="MedicationDispenseDosageInstructionTimingRepeatPeriod" class="form-control" value="<?php echo $dosageInstruction['0']['timing']['repeat']['period']; ?>">
                    <small>
                        Jangka waktu/durasi waktu dimana repetisi akan terjadi
                    </small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="MedicationDispenseDosageInstructionTimingRepeatPeriodUnit">O.3.Unit</label><br>
                </div>
                <div class="col-md-8">
                    <select id="MedicationDispenseDosageInstructionTimingRepeatPeriodUnit" name="MedicationDispenseDosageInstructionTimingRepeatPeriodUnit" class="form-control">
                        <option <?php if($dosageInstruction['0']['timing']['repeat']['periodUnit']==""){echo "selected";} ?> value="">Pilih</option>
                        <option <?php if($dosageInstruction['0']['timing']['repeat']['periodUnit']=="ms"){echo "selected";} ?> value="ms">milliseconds</option>
                        <option <?php if($dosageInstruction['0']['timing']['repeat']['periodUnit']==""){echo "selected";} ?> value="s">second</option>
                        <option <?php if($dosageInstruction['0']['timing']['repeat']['periodUnit']=="s"){echo "selected";} ?> value="min">minutes</option>
                        <option <?php if($dosageInstruction['0']['timing']['repeat']['periodUnit']=="h"){echo "selected";} ?> value="h">hours</option>
                        <option <?php if($dosageInstruction['0']['timing']['repeat']['periodUnit']=="d"){echo "selected";} ?> value="d">days</option>
                        <option <?php if($dosageInstruction['0']['timing']['repeat']['periodUnit']=="w"){echo "selected";} ?> value="w">weeks</option>
                        <option <?php if($dosageInstruction['0']['timing']['repeat']['periodUnit']=="m"){echo "selected";} ?> value="m">months</option>
                        <option <?php if($dosageInstruction['0']['timing']['repeat']['periodUnit']=="a"){echo "selected";} ?> value="a">years</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-4 sub-title">
        <div class="col-md-12 mb-3">
            <dt>P. Dose & Rate</dt>
        </div>
        <div class="col-md-12 mb-3">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="MedicationDispenseDosageInstructionDoseAndRateTypeCodingSystem">P.1.Type Coding System</label><br>
                </div>
                <div class="col-md-8">
                    <input type="text" name="MedicationDispenseDosageInstructionDoseAndRateTypeCodingSystem" id="MedicationDispenseDosageInstructionDoseAndRateTypeCodingSystem" class="form-control" value="<?php echo $dosageInstruction['0']['doseAndRate']['0']['type']['coding']['0']['system']; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="MedicationDispenseDosageInstructionDoseAndRateTypeCodingCode">P.2.Code</label><br>
                </div>
                <div class="col-md-8">
                    <select id="MedicationDispenseDosageInstructionDoseAndRateTypeCodingCode" name="MedicationDispenseDosageInstructionDoseAndRateTypeCodingCode" class="form-control">
                        <option <?php if($dosageInstruction['0']['doseAndRate']['0']['type']['coding']['0']['code']==""){echo "selected";} ?> value="">Pilih</option>
                        <option <?php if($dosageInstruction['0']['doseAndRate']['0']['type']['coding']['0']['code']=="calculated"){echo "selected";} ?> value="calculated">Dosis yang ditentukan dihitung oleh sistem atau yang meresepkan obat</option>
                        <option <?php if($dosageInstruction['0']['doseAndRate']['0']['type']['coding']['0']['code']=="ordered"){echo "selected";} ?> value="ordered">Dosis yang ditentukan seperti yang diminta oleh peresep obat</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="MedicationDispenseDosageInstructionDoseAndRateDoseQuantitySystem">P.3.Dose Quantity System</label><br>
                </div>
                <div class="col-md-8">
                    <input type="text" name="MedicationDispenseDosageInstructionDoseAndRateDoseQuantitySystem" id="MedicationDispenseDosageInstructionDoseAndRateDoseQuantitySystem" class="form-control" value="<?php echo $dosageInstruction['0']['doseAndRate']['0']['doseQuantity']['system']; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="MedicationDispenseDosageInstructionDoseAndRateDoseQuantityValue">P.4.Dose Quantity Value</label><br>
                </div>
                <div class="col-md-8">
                    <input type="text" name="MedicationDispenseDosageInstructionDoseAndRateDoseQuantityValue" id="MedicationDispenseDosageInstructionDoseAndRateDoseQuantityValue" class="form-control" value="<?php echo $dosageInstruction['0']['doseAndRate']['0']['doseQuantity']['value']; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="MedicationDispenseDosageInstructionDoseAndRateDoseQuantityUnit">P.5.Dose Quantity Unit</label><br>
                </div>
                <div class="col-md-8">
                    <select name="MedicationDispenseDosageInstructionDoseAndRateDoseQuantityUnit" id="MedicationDispenseDosageInstructionDoseAndRateDoseQuantityUnit" class="form-control">
                        <option value="">Pilih</option>
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
                                    if($dosageInstruction['0']['doseAndRate']['0']['doseQuantity']['unit']==$UnitCode){
                                        echo '<option selected value="'.$UnitCode.'">'.$UnitCode.'</option>';
                                    }else{
                                        echo '<option value="'.$UnitCode.'">'.$UnitCode.'</option>';
                                    }
                                }
                            }
                        ?>
                    </select>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<script>
    $(document).ready(function(){
        //Kondisi Ketika Pilih Resep
        $('#PilihIdResepMedicationDispense').change(function(){
            var id_resep=$('#PilihIdResepMedicationDispense').val();
            $.ajax({
                type 	    : 'POST',
                url 	    : '_Page/RawatJalan/JsonDataResep.php',
                data        : {id_resep: id_resep},
                success: function(data) {
                    // Mengurai JSON yang diterima dari server (data)
                    var json_data = JSON.parse(data);

                    // Mengambil nilai variabel dari data JSON
                    var idDokter = json_data.id_dokter;
                    var identifierSystem = json_data.identifier_system;
                    var identifierUse = json_data.identifier_use;
                    var identifierValue = json_data.identifier_value;

                    // Mengisi nilai ke dalam elemen HTML
                    $('#identifier_system_dispense1').val(identifierSystem);
                    $('#identifier_use_dispense1').val(identifierUse);
                    $('#identifier_value_dispense1').val(identifierValue);
                }
            });
            $('#PilihItemResepMedicationDispense').html('<option value="">Loading...</option>'); 
            $.ajax({
                type 	    : 'POST',
                url 	    : '_Page/RawatJalan/ListItemObat.php',
                data        : {id_resep: id_resep},
                success     : function(data){
                    $('#PilihItemResepMedicationDispense').html(data);
                }
            });
        });
        //Kondisi Ketika Pilih item Resep
        $('#PilihItemResepMedicationDispense').change(function(){
            var id_item_resep=$('#PilihItemResepMedicationDispense').val();
            $.ajax({
                type 	    : 'POST',
                url 	    : '_Page/RawatJalan/JsonDataItemResep.php',
                data        : {id_item_resep: id_item_resep},
                success     : function(data){
                    // Mengurai JSON yang diterima dari server (data)
                    var json_data = JSON.parse(data);

                    // Mengambil nilai variabel dari data JSON
                    var identifier_system = json_data.identifier_system;
                    var identifier_use = json_data.identifier_use;
                    var identifier_value = json_data.identifier_value;
                    var medicationReference_reference = json_data.medicationReference_reference;
                    var medicationReference_display = json_data.medicationReference_display;
                    var IdMedicationRequest = json_data.IdMedicationRequest;
                    var QuantityValue = json_data.QuantityValue;
                    var QuantityUnit = json_data.QuantityUnit;
                    var expectedSupplyDurationValue = json_data.expectedSupplyDurationValue;
                    var expectedSupplyDurationUnit = json_data.expectedSupplyDurationUnit;
                    var expectedSupplyDurationCode = json_data.expectedSupplyDurationCode;
                    var MedicationDispenseDosageInstructionSequence = json_data.MedicationDispenseDosageInstructionSequence;
                    var MedicationDispenseDosageInstructionText = json_data.MedicationDispenseDosageInstructionText;
                    //Timing Repeat
                    var MedicationDispenseDosageInstructionTimingRepeatFrequency = json_data.MedicationDispenseDosageInstructionTimingRepeatFrequency;
                    var MedicationDispenseDosageInstructionTimingRepeatPeriod = json_data.MedicationDispenseDosageInstructionTimingRepeatPeriod;
                    var MedicationDispenseDosageInstructionTimingRepeatPeriodUnit = json_data.MedicationDispenseDosageInstructionTimingRepeatPeriodUnit;
                    //Dose And Rate
                    var MedicationDispenseDosageInstructionDoseAndRateTypeCodingCode = json_data.MedicationDispenseDosageInstructionDoseAndRateTypeCodingCode;
                    var MedicationDispenseDosageInstructionDoseAndRateDoseQuantityValue = json_data.MedicationDispenseDosageInstructionDoseAndRateDoseQuantityValue;
                    var MedicationDispenseDosageInstructionDoseAndRateDoseQuantityUnit = json_data.MedicationDispenseDosageInstructionDoseAndRateDoseQuantityUnit;
                    // Mengisi nilai ke dalam elemen HTML
                    $('#identifier_system_dispense2').val(identifier_system);
                    $('#identifier_use_dispense2').val(identifier_use);
                    $('#identifier_value_dispense2').val(identifier_value);
                    $('#MedicationDispenseReferense').val(medicationReference_reference);
                    $('#MedicationDispenseReferenseDisplay').val(medicationReference_display);
                    $('#MedicationDispenseAuthorizingPrescription').val(IdMedicationRequest);
                    $('#MedicationDispenseQuantityValue').val(QuantityValue);
                    $('#MedicationDispenseQuantityCode').val(QuantityUnit);
                    //Duration
                    $('#MedicationDispenseDaysSupplyValue').val(expectedSupplyDurationValue);
                    $('#MedicationDispenseDaysSupplyUnit').val(expectedSupplyDurationUnit);
                    //Sequance
                    $('#MedicationDispenseDosageInstructionSequence').val(MedicationDispenseDosageInstructionSequence);
                    $('#MedicationDispenseDosageInstructionText').val(MedicationDispenseDosageInstructionText);
                    //Timing Repeat
                    $('#MedicationDispenseDosageInstructionTimingRepeatFrequency').val(MedicationDispenseDosageInstructionTimingRepeatFrequency);
                    $('#MedicationDispenseDosageInstructionTimingRepeatPeriod').val(MedicationDispenseDosageInstructionTimingRepeatPeriod);
                    $('#MedicationDispenseDosageInstructionTimingRepeatPeriodUnit').val(MedicationDispenseDosageInstructionTimingRepeatPeriodUnit);
                    //Dose And Rate
                    $('#MedicationDispenseDosageInstructionDoseAndRateTypeCodingCode').val(MedicationDispenseDosageInstructionDoseAndRateTypeCodingCode);
                    $('#MedicationDispenseDosageInstructionDoseAndRateDoseQuantityValue').val(MedicationDispenseDosageInstructionDoseAndRateDoseQuantityValue);
                    $('#MedicationDispenseDosageInstructionDoseAndRateDoseQuantityUnit').val(MedicationDispenseDosageInstructionDoseAndRateDoseQuantityUnit);
                }
            });
        });
        //Kondisi Ketika Pilih MedicationDispenseCategory
        $('#MedicationDismpenseCategory').change(function(){
            var MedicationDismpenseCategory=$('#MedicationDismpenseCategory').val();
            $.ajax({
                type 	    : 'POST',
                url 	    : '_Page/RawatJalan/JsonDataMedicationDispenseCategory.php',
                data        : {MedicationDismpenseCategory: MedicationDismpenseCategory},
                success     : function(data){
                    // Mengurai JSON yang diterima dari server (data)
                    var json_data = JSON.parse(data);

                    // Mengambil nilai variabel dari data JSON
                    var category_system = json_data.category_system;
                    var category_code = json_data.category_code;
                    var category_display = json_data.category_display;
                    var category_keterangan = json_data.category_keterangan;
                    // Mengisi nilai ke dalam elemen HTML
                    $('#MedicationDispenseCategorySystem').val(category_system);
                    $('#MedicationDispenseCategoryCode').val(category_code);
                    $('#MedicationDispenseCategoryDisplay').val(category_display);
                    $('#MedicationDispenseCategoryKeterangan').html(category_keterangan);
                }
            });
        });
        //Kondisi Ketika Pilih MedicationDispenseCategory
        $('#MedicationDispensePerformer').change(function(){
            var MedicationDispensePerformer=$('#MedicationDispensePerformer').val();
            $.ajax({
                type 	    : 'POST',
                url 	    : '_Page/RawatJalan/JsonDataMedicationDispensePerformer.php',
                data        : {MedicationDispensePerformer: MedicationDispensePerformer},
                success     : function(data){
                    // Mengurai JSON yang diterima dari server (data)
                    var json_data = JSON.parse(data);

                    // Mengambil nilai variabel dari data JSON
                    var MedicationDispensePerformerReferense = json_data.MedicationDispensePerformerReferense;
                    var MedicationDispensePerformerDisplay = json_data.MedicationDispensePerformerDisplay;
                    // Mengisi nilai ke dalam elemen HTML
                    $('#MedicationDispensePerformerReferense').val(MedicationDispensePerformerReferense);
                    $('#MedicationDispensePerformerDisplay').val(MedicationDispensePerformerDisplay);
                }
            });
        });
        //Kondisi Ketika Pilih MedicationDispenseLocation
        $('#MedicationDispenseLocation').change(function(){
            var MedicationDispenseLocation=$('#MedicationDispenseLocation').val();
            $.ajax({
                type 	    : 'POST',
                url 	    : '_Page/RawatJalan/JsonMedicationDispenseLocation.php',
                data        : {MedicationDispenseLocation: MedicationDispenseLocation},
                success     : function(data){
                    // Mengurai JSON yang diterima dari server (data)
                    var json_data = JSON.parse(data);
                    // Mengambil nilai variabel dari data JSON
                    var MedicationDispenseLocationReferense = json_data.MedicationDispenseLocationReferense;
                    var MedicationDispenseLocationDisplay = json_data.MedicationDispenseLocationDisplay;
                    // Mengisi nilai ke dalam elemen HTML
                    $('#MedicationDispenseLocationReferense').val(MedicationDispenseLocationReferense);
                    $('#MedicationDispenseLocationDisplay').val(MedicationDispenseLocationDisplay);
                }
            });
        });
    });
</script>