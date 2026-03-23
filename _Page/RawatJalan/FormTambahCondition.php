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
                <form action="javascript:void(0);" id="ProsesTambahCondition">
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
                                <label for="id_condition">ID.Condition</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" readonly class="form-control" name="id_condition" id="id_condition" value="">
                                <small>
                                    <input type="checkbox" checked name="GenerateIdCondition" id="GenerateIdCondition" value="Ya"> 
                                    <label for="GenerateIdCondition">Generate ID Condition</label>
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
                                <label for="tanggal_kunjungan">Tanggal Kunjungan</label>
                            </div>
                            <div class="col-md-8">
                                <input type="date" class="form-control" name="tanggal_kunjungan" id="tanggal_kunjungan" value="<?php echo "$TanggalKunjungan"; ?>">
                            </div>
                        </div>
                        <div class="row mb-3"> 
                            <div class="col-md-4">
                                <label for="clinicalStatus">Clinical Status</label>
                            </div>
                            <div class="col-md-8">
                                <select name="clinicalStatus" id="clinicalStatus" class="form-control">
                                    <option value="">Pilih</option>
                                    <option value="active">Active</option>
                                    <option value="recurrence">Recurrence</option>
                                    <option value="relapse">Relapse</option>
                                    <option value="inactive">Inactive</option>
                                    <option value="remission">Remission</option>
                                    <option value="resolved">Resolved</option>
                                    <option value="unknown">Unknown</option>
                                </select>
                                <a href="https://terminology.hl7.org/5.2.0/CodeSystem-condition-clinical.html" target="_blank" class="text-success">
                                    <small>Referensi <i class="ti ti-new-window"></i></small>
                                </a>
                            </div>
                        </div>
                        <div class="row mb-3"> 
                            <div class="col-md-4">
                                <label for="category">Kategori</label>
                            </div>
                            <div class="col-md-8">
                                <select name="category" id="category" class="form-control">
                                    <option value="">Pilih</option>
                                    <option value="problem-list-item">Problem List Item</option>
                                    <option value="encounter-diagnosis">Encounter Diagnosis</option>
                                </select>
                                <a href="http://terminology.hl7.org/CodeSystem/condition-category" target="_blank" class="text-success">
                                    <small>Referensi <i class="ti ti-new-window"></i></small>
                                </a>
                            </div>
                        </div>
                        <div class="row mb-3"> 
                            <div class="col-md-4">
                                <label for="coding_system">Diagnosa</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="coding_system" id="coding_system" list="CodeSystemList" placeholder="Kode-Description">
                                <datalist id="CodeSystemList">
                                    <option value="test-123">
                                </datalist>
                                <small>
                                    Contoh: K35.8-Acute appendicitis, other and unspecified
                                </small>
                            </div>
                        </div>
                        <div class="row mb-3"> 
                            <div class="col-md-12" id="NotifikasiTambahCondition">
                                <span class="text-primary">Pastikan Data Condition Sudah Sesuai!</span>
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