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
                <form action="javascript:void(0);" id="ProsesTambahProcedure">
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
                                <label for="tanggal_mulai">Waktu Mulai</label>
                            </div>
                            <div class="col-md-4">
                                <input type="date" class="form-control" name="tanggal_mulai" id="tanggal_mulai" value="<?php echo date('Y-m-d'); ?>">
                            </div>
                            <div class="col-md-4">
                                <input type="time" class="form-control" name="waktu_mulai" id="waktu_mulai" value="<?php echo date('H:i'); ?>">
                            </div>
                        </div>
                        <div class="row mb-3"> 
                            <div class="col-md-4">
                                <label for="tanggal_mulai">Waktu Selesai</label>
                            </div>
                            <div class="col-md-4">
                                <input type="date" class="form-control" name="tanggal_selesai" id="tanggal_selesai" value="<?php echo date('Y-m-d'); ?>">
                            </div>
                            <div class="col-md-4">
                                <input type="time" class="form-control" name="waktu_selesai" id="waktu_selesai" value="<?php echo date('H:i'); ?>">
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
                                <label for="category">Category</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="category" id="category" list="CategoryList" placeholder="Code|Display">
                                <datalist id="CategoryList">
                                    <option value="103693007|Diagnostic procedure">
                                </datalist>
                                <a href="http://snomed.info/sct" target="_blank" class="text-success">
                                    <small>http://snomed.info/sct<i class="ti ti-new-window"></i></small>
                                </a>
                            </div>
                        </div>
                        <div class="row mb-3"> 
                            <div class="col-md-4">
                                <label for="code_procedure">Procedure</label><br>
                                <small>
                                    <input type="radio" name="ReferensiProcedur" id="ReferensiProcedurBPJS" value="BPJS"> <label for="ReferensiProcedurBPJS">Bridging BPJS</label><br>
                                    <input type="radio" checked name="ReferensiProcedur" id="ReferensiProcedurSIMRS" value="SIMRS"> <label for="ReferensiProcedurSIMRS">Simrs</label><br>
                                </small>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="code_procedure" id="code_procedure" list="code_procedure_list" placeholder="Contoh: 87.44|Routine chest x-ray, so described">
                                <datalist id="code_procedure_list">
                                    <option value="87.44|Routine chest x-ray, so described">
                                </datalist>
                                <small>
                                    Format: Code|Description
                                </small>
                            </div>
                        </div>
                        <div class="row mb-3"> 
                            <div class="col-md-4">
                                <label for="reasonCode">Reason Code</label><br>
                                <small>
                                    <input type="radio" name="ReferensiDiagnostic" id="ReferensiDiagnosticBpjs" value="BPJS"> <label for="ReferensiDiagnosticBpjs">Bridging BPJS</label><br>
                                    <input type="radio" checked name="ReferensiDiagnostic" id="ReferensiDiagnosticSIMRS" value="SIMRS"> <label for="ReferensiDiagnosticSIMRS">Simrs</label><br>
                                </small>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="reasonCode" id="reasonCode" list="reasonCodeList" placeholder="Contoh: A15.0|Tuberculosis of lung">
                                <datalist id="reasonCodeList">
                                    <option value="A15.0|Tuberculosis of lung, confirmed by sputum microscopy with or without culture">
                                </datalist>
                                <small>Code ICD-10|Description</small>
                            </div>
                        </div>
                        <div class="row mb-3"> 
                            <div class="col-md-4">
                                <label for="bodySite">Body Site</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="bodySite" id="bodySite" list="bodySiteList" placeholder="Code|Display">
                                <datalist id="bodySiteList">
                                    <option value="103693007|Diagnostic procedure">
                                </datalist>
                                <a href="http://snomed.info/sct" target="_blank" class="text-success">
                                    <small>http://snomed.info/sct<i class="ti ti-new-window"></i></small>
                                </a>
                            </div>
                        </div>
                        <div class="row mb-3"> 
                            <div class="col-md-4">
                                <label for="status">Procedure Status</label>
                            </div>
                            <div class="col-md-8">
                                <select name="status" id="status" class="form-control">
                                    <option value="">Pilih</option>
                                    <option value="preparation">Persiapan</option>
                                    <option value="in-progress">Berlangsung</option>
                                    <option value="not-done">Tidak dilakukan</option>
                                    <option value="on-hold">Tertahan</option>
                                    <option value="stopped">Berhenti</option>
                                    <option value="completed">Selesai</option>
                                    <option value="entered-in-error">Salah masuk</option>
                                    <option value="unknown">Tidak diketahui</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3"> 
                            <div class="col-md-4">
                                <label for="note">Catatan</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="note" id="note">
                            </div>
                        </div>
                        <div class="row mb-3"> 
                            <div class="col-md-12" id="NotifikasiTambahProcedure">
                                <span class="text-primary">Pastikan Data Procedure Sudah Sesuai!</span>
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