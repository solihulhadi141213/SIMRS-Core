<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap id_diagnosis_pasien
    if(empty($_POST['id_diagnosis_pasien'])){
        echo '<div class="modal-body">';
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-danger text-center">';
        echo '          ID Diagnosa Tidak Boleh Kosong!';
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
        $id_diagnosis_pasien=$_POST['id_diagnosis_pasien'];
        //Buka Detail Diagnosa
        $id_diagnosis_pasien=getDataDetail($Conn,"diagnosis_pasien",'id_diagnosis_pasien',$id_diagnosis_pasien,'id_diagnosis_pasien');
        $id_kunjungan=getDataDetail($Conn,"diagnosis_pasien",'id_diagnosis_pasien',$id_diagnosis_pasien,'id_kunjungan');
        $id_pasien=getDataDetail($Conn,"diagnosis_pasien",'id_diagnosis_pasien',$id_diagnosis_pasien,'id_pasien');
        $nama_pasien=getDataDetail($Conn,"diagnosis_pasien",'id_diagnosis_pasien',$id_diagnosis_pasien,'nama_pasien');
        $tanggal=getDataDetail($Conn,"diagnosis_pasien",'id_diagnosis_pasien',$id_diagnosis_pasien,'tanggal');
        $petugas_entry=getDataDetail($Conn,"diagnosis_pasien",'id_diagnosis_pasien',$id_diagnosis_pasien,'petugas_entry');
        $kategori=getDataDetail($Conn,"diagnosis_pasien",'id_diagnosis_pasien',$id_diagnosis_pasien,'kategori');
        $kode=getDataDetail($Conn,"diagnosis_pasien",'id_diagnosis_pasien',$id_diagnosis_pasien,'kode');
        $diagnosis=getDataDetail($Conn,"diagnosis_pasien",'id_diagnosis_pasien',$id_diagnosis_pasien,'diagnosis');
        $referensi=getDataDetail($Conn,"diagnosis_pasien",'id_diagnosis_pasien',$id_diagnosis_pasien,'referensi');
        //Format Tanggal
        $strtotime=strtotime($tanggal);
        $FormatTanggal=date('Y-m-d',$strtotime);
        $FormatJam=date('H:i',$strtotime);
?>
        <div class="modal-body border-0 pb-0 mb-4">
            <input type="hidden" class="form-control" name="id_diagnosis_pasien" id="id_diagnosis_pasien" value="<?php echo "$id_diagnosis_pasien"; ?>">
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
                    <input type="text" readonly class="form-control" name="nama_pasien" id="nama_pasien" value="<?php echo "$nama_pasien"; ?>">
                </div>
            </div>
            <div class="row mb-3"> 
                <div class="col-md-4">
                    <label for="petugas_entry">Nama Petugas</label>
                </div>
                <div class="col-md-8">
                    <input type="text" readonly class="form-control" name="petugas_entry" id="petugas_entry" value="<?php echo "$petugas_entry"; ?>">
                </div>
            </div>
            <div class="row mb-3"> 
                <div class="col-md-4">
                    <label for="tanggal">Tanggal Entry</label>
                </div>
                <div class="col-md-8">
                    <input type="date" class="form-control" name="tanggal" id="tanggal" value="<?php echo "$FormatTanggal"; ?>">
                </div>
            </div>
            <div class="row mb-3"> 
                <div class="col-md-4">
                    <label for="tanggal">Jam Entry</label>
                </div>
                <div class="col-md-8">
                    <input type="time" class="form-control" name="jam" id="jam" value="<?php echo "$FormatJam"; ?>">
                </div>
            </div>
            <div class="row mb-3"> 
                <div class="col-md-4">
                    <label for="kategori">Kategori</label>
                </div>
                <div class="col-md-8">
                    <select name="kategori" id="kategori" class="form-control">
                        <option <?php if($kategori==""){echo "selected";} ?> value="">Pilih</option>
                        <option <?php if($kategori=="1.Diagnosis Awal"){echo "selected";} ?> value="1.Diagnosis Awal">1.Diagnosa Awal</option>
                        <option <?php if($kategori=="2.Diagnosis Kerja"){echo "selected";} ?> value="2.Diagnosis Kerja">2.Diagnosis Kerja</option>
                        <option <?php if($kategori=="3.Diagnosis Banding"){echo "selected";} ?> value="3.Diagnosis Banding">3.Diagnosis Banding</option>
                        <option <?php if($kategori=="4.Diagnosis Akhir"){echo "selected";} ?> value="4.Diagnosis Akhir">4.Diagnosis Akhir</option>
                        <option <?php if($kategori=="4.1.Diagnosis Akhir (Primer)"){echo "selected";} ?> value="4.1.Diagnosis Akhir (Primer)">4.1.Diagnosis Akhir (Primer)</option>
                        <option <?php if($kategori=="4.2.Diagnosis Akhir (Sekunder)"){echo "selected";} ?> value="4.2.Diagnosis Akhir (Sekunder)">4.2.Diagnosis Akhir (Sekunder)</option>
                        <option <?php if($kategori=="5Diagnosis Eksjuvantibus"){echo "selected";} ?> value="5.Diagnosis Eksjuvantibus">5.Diagnosis Eksjuvantibus</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3"> 
                <div class="col-md-4">
                    <label for="referensi">Referensi</label>
                </div>
                <div class="col-md-8">
                    <select name="referensi" id="referensi" class="form-control">
                        <option <?php if($referensi==""){echo "selected";} ?> value="">Pilih</option>
                        <option <?php if($referensi=="BPJS"){echo "selected";} ?> value="BPJS">BPJS</option>
                        <option <?php if($referensi=="SIMRS"){echo "selected";} ?> value="SIMRS">SIMRS</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3"> 
                <div class="col-md-4">
                    <label for="diagnosa">Diagnosa</label>
                </div>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="diagnosa" id="diagnosa" list="DiagnosaList" placeholder="Kode-Description" value="<?php echo "$kode|$diagnosis"; ?>">
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
                <div class="col-md-12" id="NotifikasiEditDiagnosa">
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
<?php } ?>