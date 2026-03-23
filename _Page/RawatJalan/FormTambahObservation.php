<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap id_kunjungan
    if(empty($_POST['id_kunjungan'])){
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
        $id_kunjungan=$_POST['id_kunjungan'];
        $id_pasien=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'id_pasien');
        $id_encounter=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'id_encounter');
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
                <form action="javascript:void(0);" id="ProsesTambahObservation">
                    <input type="hidden" name="GetIdKunjungan" id="GetIdKunjungan" value="<?php echo $id_kunjungan; ?>">
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
                                <input type="text" readonly class="form-control" name="id_observation" id="id_observation" value="">
                                <small>
                                    <input type="checkbox" checked name="GenerateIdObservation" id="GenerateIdObservation" value="Ya"> 
                                    <label for="GenerateIdObservation">Generate ID Obsertvation</label>
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
                                                $id_ihs_practitioner= $data['id_ihs_practitioner'];
                                                $nama= $data['nama'];
                                                echo '<option value="'.$id_ihs_practitioner.'">'.$nama.'</option>';
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
                                    <option value="">Pilih</option>
                                    <option value="social-history">Social History</option>
                                    <option value="vital-signs">Vital Signs</option>
                                    <option value="imaging">Imaging</option>
                                    <option value="laboratory">Laboratory</option>
                                    <option value="procedure">Procedure</option>
                                    <option value="survey">Survey</option>
                                    <option value="exam">Exam</option>
                                    <option value="therapy">Therapy</option>
                                    <option value="activity">Activity</option>
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
                                    <option value="">Pilih</option>
                                    <option value="8867-4|Heart rate">Denyut Jantung (Heart rate)</option>
                                    <option value="8480-6|Systolic blood pressure">Tekanan darah sistole (Systolic blood pressure)</option>
                                    <option value="8462-4|Diastolic blood pressure">Tekanan darah diastole (Diastolic blood pressure)</option>
                                    <option value="8310-5|Body temperature">Suhu Tubuh (Body temperature)</option>
                                    <option value="9279-1|Respiratory rate">Pernapasan (Respiratory rate)</option>
                                    <option value="67775-7|Level of responsiveness">Tingkat Kesadaran (Level of responsiveness)</option>
                                </select>
                            </div>
                        </div>
                        <div id="FormLanjutanObservation"></div>
                        <div class="row mb-3"> 
                            <div class="col-md-4">
                                <label for="interpertasi">Interpertasi</label>
                            </div>
                            <div class="col-md-8">
                                <select name="interpertasi" id="interpertasi" class="form-control">
                                    <option selected value="">Pilih</option>
                                    <option value="A">Abnormal</option>
                                    <option value="AA">Critical abnormal</option>
                                    <option value="H">High</option>
                                    <option value="H>">Significantly high</option>
                                    <option value="HH">Critical high</option>
                                    <option value="LL">Critical low</option>
                                    <option value="L">Low</option>
                                    <option value="L<">Significantly low</option>
                                    <option value="N">Normal</option>
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
                                    <option value="">Pilih</option>
                                    <option value="registered">Registered</option>
                                    <option value="preliminary">Preliminary</option>
                                    <option value="final">Final</option>
                                    <option value="amended">Amended</option>
                                    <option value="corrected">Corrected</option>
                                    <option value="cancelled">Cancelled</option>
                                    <option value="entered-in-error">Entered in Error</option>
                                    <option value="unknown">Unknown</option>
                                </select>
                                <a href="http://hl7.org/fhir/R4/codesystem-observation-status.html#observation-status-registered" target="_blank" class="text-success">
                                    <small>Referensi <i class="ti ti-new-window"></i></small>
                                </a>
                            </div>
                        </div>
                        <div class="row mb-3"> 
                            <div class="col-md-12" id="NotifikasiTambahObservation">
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