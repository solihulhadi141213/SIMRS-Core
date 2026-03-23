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
        echo '<div class="modal-footer">';
        echo '  <div class="row">';
        echo '      <div class="col-md-12">';
        echo '          <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">';
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
            echo '<div class="modal-footer">';
            echo '  <div class="row">';
            echo '      <div class="col-md-12">';
            echo '          <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">';
            echo '              <i class="ti-close"></i> Tutup';
            echo '          </button>';
            echo '      </div>';
            echo '  </div>';
        }else{
            //Buka Data Pasien
            $nama=getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'nama');
            //Format Tanggal Kunjungan
            $TanggalEntry=date('Y-m-d');
            $JamEntry=date('H:i');
?>
            <div class="modal-body border-0 pb-0 mb-4">
                <div class="row mb-3"> 
                    <div class="col-md-4">
                        <label for="id_pasien">No.RM</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" readonly class="form-control" name="id_pasien" id="id_pasien" value="<?php echo "$id_pasien"; ?>">
                    </div>
                </div>
                <div class="row mb-3"> 
                    <div class="col-md-4">
                        <label for="id_kunjungan">ID.Kunjungan</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" readonly class="form-control" name="id_kunjungan" id="id_kunjungan" value="<?php echo "$id_kunjungan"; ?>">
                    </div>
                </div>
                <div class="row mb-3"> 
                    <div class="col-md-4">
                        <label for="nama">Nama pasien</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" readonly class="form-control" name="nama_pasien" id="nama_pasien" value="<?php echo "$nama"; ?>">
                    </div>
                </div>
                <div class="row mb-3"> 
                    <div class="col-md-4">
                        <label for="petugas_entry">Nama Petugas</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" readonly class="form-control" name="petugas_entry" id="petugas_entry" value="<?php echo "$SessionNama"; ?>">
                    </div>
                </div>
                <div class="row mb-3"> 
                    <div class="col-md-4">
                        <label for="tanggal">Tanggal Entry</label>
                    </div>
                    <div class="col-md-8">
                        <input type="date" class="form-control" name="tanggal" id="tanggal" value="<?php echo "$TanggalEntry"; ?>">
                    </div>
                </div>
                <div class="row mb-3"> 
                    <div class="col-md-4">
                        <label for="tanggal">Jam Entry</label>
                    </div>
                    <div class="col-md-8">
                        <input type="time" class="form-control" name="jam" id="jam" value="<?php echo "$JamEntry"; ?>">
                    </div>
                </div>
                <div class="row mb-3"> 
                    <div class="col-md-4">
                        <label for="kategori">Kategori</label>
                    </div>
                    <div class="col-md-8">
                        <select name="kategori" id="kategori" class="form-control">
                            <option value="">Pilih</option>
                            <option value="1.Diagnosis Awal">1.Diagnosa Awal</option>
                            <option value="2.Diagnosis Kerja">2.Diagnosis Kerja</option>
                            <option value="3.Diagnosis Banding">3.Diagnosis Banding</option>
                            <option value="4.Diagnosis Akhir">4.Diagnosis Akhir</option>
                            <option value="4.1.Diagnosis Akhir (Primer)">4.1.Diagnosis Akhir (Primer)</option>
                            <option value="4.2.Diagnosis Akhir (Sekunder)">4.2.Diagnosis Akhir (Sekunder)</option>
                            <option value="5.Diagnosis Eksjuvantibus">5.Diagnosis Eksjuvantibus</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3"> 
                    <div class="col-md-4">
                        <label for="referensi">Referensi</label>
                    </div>
                    <div class="col-md-8">
                        <select name="referensi" id="referensi" class="form-control">
                            <option value="">Pilih</option>
                            <option value="BPJS">BPJS</option>
                            <option value="SIMRS">SIMRS</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3"> 
                    <div class="col-md-4">
                        <label for="diagnosa">Diagnosa</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="diagnosa" id="diagnosa" list="DiagnosaList" placeholder="Kode-Description">
                        <datalist id="DiagnosaList">
                            <?php
                                $QryDiagnosa = mysqli_query($Conn, "SELECT * FROM diagnosis_pasien ORDER BY id_diagnosis_pasien DESC LIMIT 20");
                                while ($DataDiagnosa = mysqli_fetch_array($QryDiagnosa)) {
                                    $kode= $DataDiagnosa['kode'];
                                    $diagnosis= $DataDiagnosa['diagnosis'];
                                    echo '<option value="'.$kode.'|'.$diagnosis.'">';
                                }
                            ?>
                        </datalist>
                        <small>
                            Contoh: K35.8|Acute appendicitis, other and unspecified
                        </small>
                    </div>
                </div>
                <div class="row mb-3"> 
                    <div class="col-md-12" id="NotifikasiTambahDiagnosa">
                        <span class="text-primary">Pastikan Data Diagnosa Sudah Sesuai!</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-sm btn-primary mr-2">
                            <i class="ti-save"></i> Simpan
                        </button>
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                            <i class="ti-close"></i> Tutup
                        </button>
                    </div>
                </div>
            </div>
<?php 
        }
    } 
?>