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
        echo '<div class="modal-footer bg-success">';
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
?>
                <form action="javascript:void(0);" id="ProsesTambahEncounter">
                    <input type="hidden" name="GetIdPasien" id="GetIdPasien" value="<?php echo $id_pasien; ?>">
                    <input type="hidden" name="GetIdKunjungan" id="GetIdKunjungan" value="<?php echo $id_kunjungan; ?>">
                    <div class="modal-body border-0 pb-0 mb-4">
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
                                <label for="ActCode">Action Code</label>
                            </div>
                            <div class="col-md-8">
                                <select name="ActCode" id="ActCode" class="form-control">
                                    <option value="">Pilih</option>
                                    <option value="AMB">Ambulatory</option>
                                    <option value="EMER">Emergency</option>
                                    <option value="FLD">Field</option>
                                    <option value="HH">Home Health</option>
                                    <option value="IMP">Inpatient Encounter</option>
                                    <option value="ACUTE">Inpatient Acute</option>
                                    <option value="NONAC">Inpatient Non-Acute</option>
                                    <option value="OBSENC">Observation Encounter</option>
                                    <option value="PRENC">Pre-Admission</option>
                                    <option value="SS">Short Stay</option>
                                    <option value="VR">Virtual</option>
                                </select>
                                <a href="http://terminology.hl7.org/CodeSystem/v3-ActCode" class="text-success">
                                    <small>Referensi <i class="ti ti-new-window"></i></small>
                                </a>
                            </div>
                        </div>
                        <div class="row mb-3"> 
                            <div class="col-md-4">
                                <label for="ParticipationType">Participation Type</label>
                            </div>
                            <div class="col-md-8">
                                <select name="ParticipationType" id="ParticipationType" class="form-control">
                                    <option value="">Pilih</option>
                                    <option value="ADM">Admitter</option>
                                    <option value="ATND">Attender</option>
                                    <option value="CALLBCK">Callback Contact</option>
                                    <option value="CON">Consultant</option>
                                    <option value="DIS">Discharger</option>
                                    <option value="ESC">Escort</option>
                                    <option value="REF">Referrer</option>
                                </select>
                                <a href="https://terminology.hl7.org/5.1.0/CodeSystem-v3-ParticipationType.html" class="text-success">
                                    <small>Referensi <i class="ti ti-new-window"></i></small>
                                </a>
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
                                <label for="TanggalMulai">Arrived Start</label>
                            </div>
                            <div class="col-md-4">
                                <input type="date" class="form-control" name="TanggalMulai" id="TanggalMulai" value="<?php echo date('Y-m-d'); ?>">
                            </div>
                            <div class="col-md-4">
                                <input type="time" class="form-control" name="JamMulai" id="JamMulai" value="<?php echo date('H:i'); ?>">
                            </div>
                        </div>
                        <div class="row mb-3"> 
                            <div class="col-md-4">
                                <label for="TanggalSelesai">Arrived End</label>
                            </div>
                            <div class="col-md-4">
                                <input type="date" class="form-control" name="TanggalSelesai" id="TanggalSelesai" value="<?php echo date('Y-m-d'); ?>">
                            </div>
                            <div class="col-md-4">
                                <input type="time" class="form-control" name="JamSelesai" id="JamSelesai" value="<?php echo date('H:i'); ?>">
                            </div>
                        </div>
                        <div class="row mb-3"> 
                            <div class="col-md-4">
                                <label for="IdLocation">Location</label>
                            </div>
                            <div class="col-md-8">
                                <select name="IdLocation" id="IdLocation" class="form-control">
                                    <option value="">Pilih</option>
                                    <?php
                                        $query = mysqli_query($Conn, "SELECT*FROM referensi_location ORDER BY nama ASC");
                                        while ($data = mysqli_fetch_array($query)) {
                                            if(!empty($data['id_location'])){
                                                $id_location= $data['id_location'];
                                                $nama= $data['nama'];
                                                echo '<option value="'.$id_location.'">'.$nama.'</option>';
                                            }
                                            
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3"> 
                            <div class="col-md-4">
                                <label for="serviceProvider">Service Provider</label>
                            </div>
                            <div class="col-md-8">
                                <select name="serviceProvider" id="serviceProvider" class="form-control">
                                    <option value="">Pilih</option>
                                    <?php
                                        $query = mysqli_query($Conn, "SELECT*FROM referensi_organisasi ORDER BY nama ASC");
                                        while ($data = mysqli_fetch_array($query)) {
                                            if(!empty($data['ID_Org'])){
                                                $ID_Org= $data['ID_Org'];
                                                $NamaOrganisasi= $data['nama'];
                                                echo '<option value="'.$ID_Org.'">'.$NamaOrganisasi.'</option>';
                                            }
                                            
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3"> 
                            <div class="col-md-12" id="NotifikasiTambahEncounter">
                                <span class="text-primary">Pastikan Data Encounter Sudah Sesuai!</span>
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