<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['id_konsultasi'])){
        echo '<div class="modal-body">';
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-center text-danger">';
        echo '          ID Konsultasi Tidak Boleh Kosong!';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
        echo '<div class="modal-footer">';
        echo '  <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">';
        echo '      <i class="ti ti-close"></i> Tutup';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_konsultasi=$_POST['id_konsultasi'];
        //Buka Detail
        $id_pasien=getDataDetail($Conn,"konsultasi",'id_konsultasi',$id_konsultasi,'id_pasien');
        $id_kunjungan=getDataDetail($Conn,"konsultasi",'id_konsultasi',$id_konsultasi,'id_kunjungan');
        $id_akses=getDataDetail($Conn,"konsultasi",'id_konsultasi',$id_konsultasi,'id_akses');
        $petugas_entry=getDataDetail($Conn,"konsultasi",'id_konsultasi',$id_konsultasi,'petugas_entry');
        $tanggal_entry=getDataDetail($Conn,"konsultasi",'id_konsultasi',$id_konsultasi,'tanggal_entry');
        $tanggal_permintaan=getDataDetail($Conn,"konsultasi",'id_konsultasi',$id_konsultasi,'tanggal_permintaan');
        $tanggal_jawaban=getDataDetail($Conn,"konsultasi",'id_konsultasi',$id_konsultasi,'tanggal_jawaban');
        $dokter_asal=getDataDetail($Conn,"konsultasi",'id_konsultasi',$id_konsultasi,'dokter_asal');
        $dokter_tujuan=getDataDetail($Conn,"konsultasi",'id_konsultasi',$id_konsultasi,'dokter_tujuan');
        $status_konsultasi=getDataDetail($Conn,"konsultasi",'id_konsultasi',$id_konsultasi,'status_konsultasi');
        //Format Waktu
        $strtotime1=strtotime($tanggal_permintaan);
        $FormatTanggalPermintaan=date('Y-m-d',$strtotime1);
        $FormatTJamPermintaan=date('H:i',$strtotime1);
        //Json Decode
        $JsonDokterAsal=json_decode($dokter_asal, true);
        $JsonDokterTujuan=json_decode($dokter_tujuan, true);
        //Buka Dokter Asal
        $IdUnitAsal=$JsonDokterAsal['unit']['id_unit'];
        $NamaUnitAsal=$JsonDokterAsal['unit']['nama'];
        $IdDokterAsal=$JsonDokterAsal['id_dokter'];
        $NamaDokterAsal=$JsonDokterAsal['nama'];
        $TtdDokterAsal=$JsonDokterAsal['ttd'];
        //Buka Dokter Tujuan
        $IdUnitTujuan=$JsonDokterTujuan['unit']['id_unit'];
        $NamaUnitTujuan=$JsonDokterTujuan['unit']['nama'];
        $IdDokterTujuan=$JsonDokterTujuan['id_dokter'];
        $NamaDokterTujuan=$JsonDokterTujuan['nama'];
        $TtdDokterTujuan=$JsonDokterTujuan['ttd'];
?>
    <input type="hidden" readonly name="id_konsultasi" id="id_konsultasi" class="form-control" value="<?php echo "$id_konsultasi"; ?>">
    <div class="modal-body">
        <div class="row mb-4">
            <div class="col-md-12 mb-2">
                <dt>A. Informasi Pasien & Kunjungan</dt>
            </div>
            <div class="col-md-12">
                <div class="row mb-2">
                    <div class="col col-md-4">A.1 ID.Kunjungan</div>
                    <div class="col col-md-8">
                        <input type="text" readonly name="id_kunjungan" id="id_kunjungan" class="form-control" value="<?php echo "$id_kunjungan"; ?>">
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col col-md-4">A.2 No.RM</div>
                    <div class="col col-md-8">
                        <input type="text" readonly name="id_pasien" id="id_pasien" class="form-control" value="<?php echo "$id_pasien"; ?>">
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col col-md-4">A.3 Petugas Entry</div>
                    <div class="col col-md-8">
                        <input type="text" name="petugas_entry" id="petugas_entry" class="form-control" value="<?php echo "$petugas_entry"; ?>">
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-12 mb-2">
                <dt>B. Tgl/Jam Konsultasi</dt>
            </div>
            <div class="col-md-12">
                <div class="row mb-2">
                    <div class="col col-md-4 mb-2">B.1 Tanggal</div>
                    <div class="col col-md-8 mb-2">
                        <input type="date" name="tanggal_permintaan" id="tanggal_permintaan" class="form-control" value="<?php echo $FormatTanggalPermintaan; ?>">
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col col-md-4 mb-2">B.2 Jam</div>
                    <div class="col col-md-8 mb-2">
                        <input type="time" name="jam_permintaan" id="jam_permintaan" class="form-control" value="<?php echo $FormatTJamPermintaan; ?>">
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-12 mb-2">
                <dt>C. Asal Permintaan Konsultasi</dt>
            </div>
            <div class="col-md-12">
                <div class="row mb-2">
                    <div class="col col-md-4 mb-2">B.3 Unit Asal</div>
                    <div class="col col-md-8 mb-2">
                        <input type="text" name="unit_asal" id="unit_asal" class="form-control" list="ListOrganization" value="<?php echo "$IdUnitAsal-$NamaUnitAsal"; ?>">
                        <small>Referensi Organization (ex: ID-Nama Organisasi)</small>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col col-md-4 mb-2">B.5 Dokter</div>
                    <div class="col col-md-8 mb-2">
                        <select name="id_dokter_asal" id="id_dokter_asal" class="form-control">
                            <option value="">Pilih</option>
                            <?php
                                $query = mysqli_query($Conn, "SELECT * FROM dokter ORDER BY nama ASC");
                                while ($data = mysqli_fetch_array($query)) {
                                    $id_dokter= $data['id_dokter'];
                                    $NamaDokter= $data['nama'];
                                    if($IdDokterAsal==$data['id_dokter']){
                                        echo '<option selected value="'.$id_dokter.'">'.$NamaDokter.'</option>';
                                    }else{
                                        echo '<option value="'.$id_dokter.'">'.$NamaDokter.'</option>';
                                    }
                                }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-12 mb-2">
                <dt>D. Tujuan Konsultasi</dt>
            </div>
            <div class="col-md-12">
                <div class="row mb-2">
                    <div class="col col-md-4 mb-2">B.3 Unit Tujuan</div>
                    <div class="col col-md-8 mb-2">
                        <input type="text" name="unit_tujuan" id="unit_tujuan" class="form-control" list="ListOrganization" value="<?php echo "$IdUnitTujuan-$NamaUnitTujuan"; ?>">
                        <small>Referensi Organization (ex: ID-Nama Organisasi)</small>
                        <datalist id="ListOrganization">
                            <?php 
                                $query = mysqli_query($Conn, "SELECT * FROM referensi_organisasi ORDER BY nama ASC");
                                while ($data = mysqli_fetch_array($query)) {
                                    $id_referensi_organisasi = $data['id_referensi_organisasi'];
                                    $NamaOrganisasi= $data['nama'];
                                    echo '<option value="'.$id_referensi_organisasi .'-'.$NamaOrganisasi .'">';
                                }
                            ?>
                        </datalist>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col col-md-4 mb-2">B.5 Dokter</div>
                    <div class="col col-md-8 mb-2">
                        <select name="id_dokter_tujuan" id="id_dokter_tujuan" class="form-control">
                            <option value="">Pilih</option>
                            <?php
                                $query = mysqli_query($Conn, "SELECT * FROM dokter ORDER BY nama ASC");
                                while ($data = mysqli_fetch_array($query)) {
                                    $id_dokter= $data['id_dokter'];
                                    $NamaDokter= $data['nama'];
                                    if($IdDokterTujuan==$data['id_dokter']){
                                        echo '<option selected value="'.$id_dokter.'">'.$NamaDokter.'</option>';
                                    }else{
                                        echo '<option value="'.$id_dokter.'">'.$NamaDokter.'</option>';
                                    }
                                }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-12 mb-2">
                <dt>E. Status Konsultasi</dt>
            </div>
            <div class="col-md-12">
                <ol>
                    <li>
                        <input type="radio" <?php if($status_konsultasi=="Pending"){echo "checked";} ?> name="status_konsultasi" id="StatusKonsultasi1" value="Pending"> 
                        <label for="StatusKonsultasi1">Pending</label>
                    </li>
                    <li>
                        <input type="radio" <?php if($status_konsultasi=="Konsul Ulang"){echo "checked";} ?> name="status_konsultasi" id="StatusKonsultasi2" value="Konsul Ulang"> 
                        <label for="StatusKonsultasi2">Konsul Ulang</label>
                    </li>
                    <li>
                        <input type="radio" <?php if($status_konsultasi=="Konsul Selesai"){echo "checked";} ?> name="status_konsultasi" id="StatusKonsultasi3" value="Konsul Selesai"> 
                        <label for="StatusKonsultasi3">Konsul Selesai</label>
                    </li>
                    <li>
                        <input type="radio" <?php if($status_konsultasi=="Konsul Bersama"){echo "checked";} ?> name="status_konsultasi" id="StatusKonsultasi4" value="Konsul Bersama"> 
                        <label for="StatusKonsultasi4">Konsul Bersama</label>
                    </li>
                    <li>
                        <input type="radio" <?php if($status_konsultasi=="Alih Rawat"){echo "checked";} ?> name="status_konsultasi" id="StatusKonsultasi4" value="Alih Rawat"> 
                        <label for="StatusKonsultasi4">Alih Rawat</label>
                    </li>
                </ol>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12" id="NotifikasiEditKonsuiltasi">
                <span class="text-primary">Pastikan informasi sudah terisi dengan lengkap dan benar.</span>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-sm btn-primary mr-3">
            <i class="ti ti-save"></i> Simpan
        </button>
        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">
            <i class="ti ti-close"></i> Tutup
        </button>
    </div>
<?php } ?>
