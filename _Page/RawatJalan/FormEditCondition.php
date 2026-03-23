<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap id_kunjungan_condition
    if(empty($_POST['id_kunjungan_condition'])){
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
        $id_kunjungan_condition=$_POST['id_kunjungan_condition'];
        $id_kunjungan=getDataDetail($Conn,"kunjungan_condition",'id_kunjungan_condition',$id_kunjungan_condition,'id_kunjungan');
        $id_pasien=getDataDetail($Conn,"kunjungan_condition",'id_kunjungan_condition',$id_kunjungan_condition,'id_pasien');
        $id_encounter=getDataDetail($Conn,"kunjungan_condition",'id_kunjungan_condition',$id_kunjungan_condition,'id_encounter');
        $id_ihs=getDataDetail($Conn,"kunjungan_condition",'id_kunjungan_condition',$id_kunjungan_condition,'id_ihs');
        $id_condition=getDataDetail($Conn,"kunjungan_condition",'id_kunjungan_condition',$id_kunjungan_condition,'id_condition');
        $category=getDataDetail($Conn,"kunjungan_condition",'id_kunjungan_condition',$id_kunjungan_condition,'category');
        $clinicalStatus=getDataDetail($Conn,"kunjungan_condition",'id_kunjungan_condition',$id_kunjungan_condition,'clinicalStatus');
        $code_system=getDataDetail($Conn,"kunjungan_condition",'id_kunjungan_condition',$id_kunjungan_condition,'code_system');
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
                <form action="javascript:void(0);" id="ProsesEditCondition">
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
                                <label for="id_condition">ID Condition</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="id_condition" id="id_condition" value="<?php echo "$id_condition"; ?>">
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
                                    <option <?php if($clinicalStatus==""){echo "selected";} ?> value="">Pilih</option>
                                    <option <?php if($clinicalStatus=="active"){echo "selected";} ?> value="active">Active</option>
                                    <option <?php if($clinicalStatus=="recurrence"){echo "selected";} ?> value="recurrence">Recurrence</option>
                                    <option <?php if($clinicalStatus=="relapse"){echo "selected";} ?> value="relapse">Relapse</option>
                                    <option <?php if($clinicalStatus=="inactive"){echo "selected";} ?> value="inactive">Inactive</option>
                                    <option <?php if($clinicalStatus=="remission"){echo "selected";} ?> value="remission">Remission</option>
                                    <option <?php if($clinicalStatus=="resolved"){echo "selected";} ?> value="resolved">Resolved</option>
                                    <option <?php if($clinicalStatus=="unknown"){echo "selected";} ?> value="unknown">Unknown</option>
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
                                    <option <?php if($category==""){echo "selected";} ?> value="">Pilih</option>
                                    <option <?php if($category=="problem-list-item"){echo "selected";} ?> value="problem-list-item">Problem List Item</option>
                                    <option <?php if($category=="encounter-diagnosis"){echo "selected";} ?> value="encounter-diagnosis">Encounter Diagnosis</option>
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
                                <input type="text" class="form-control" name="coding_system" id="coding_system" list="CodeSystemList" placeholder="Kode-Description" value="<?php echo $code_system;?>">
                                <datalist id="CodeSystemList">
                                    <option value="test-123">
                                </datalist>
                                <small>
                                    Contoh: K35.8-Acute appendicitis, other and unspecified
                                </small>
                            </div>
                        </div>
                        <div class="row mb-3"> 
                            <div class="col-md-12" id="NotifikasiEditCondition">
                                <span class="text-primary">Pastikan Data Condition Sudah Sesuai!</span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-success">
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