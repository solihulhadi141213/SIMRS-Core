<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['id_kunjungan'])){
        echo '<div class="modal-body">';
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-center text-danger">';
        echo '          ID Kunjungan Tidak Boleh Kosong!';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
        echo '<div class="modal-footer">';
        echo '  <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">';
        echo '      <i class="ti ti-close"></i> Tutup';
        echo '  </div>';
        echo '</div>';
    }else{
        $tanggal=date('Y-m-d');
        $jam=date('H:i');
        $id_kunjungan=$_POST['id_kunjungan'];
        //Buka Detail Pasien
        $id_pasien=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'id_pasien');
        $nama=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'nama');
?>
    <div class="modal-body">
        <div class="row mb-4">
            <div class="col-md-12 mb-2">
                <dt>A. Informasi Pasien & Kunjungan</dt>
            </div>
            <div class="col-md-4 mb-2">A.1 ID.Kunjungan</div>
            <div class="col-md-8 mb-2">
                <input type="text" readonly name="id_kunjungan" id="id_kunjungan" class="form-control" value="<?php echo "$id_kunjungan"; ?>">
            </div>
            <div class="col-md-4 mb-2">A.2 No.RM</div>
            <div class="col-md-8 mb-2">
                <input type="text" readonly name="id_pasien" id="id_pasien" class="form-control" value="<?php echo "$id_pasien"; ?>">
            </div>
            <div class="col-md-4 mb-2">A.3 Nama Pasien</div>
            <div class="col-md-8 mb-2">
                <input type="text" readonly name="nama_pasien" id="nama_pasien" class="form-control" value="<?php echo "$nama"; ?>">
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-12 mb-2">
                <dt>B. Tanggal & Waktu Pencatatan</dt>
            </div>
            <div class="col-md-4 mb-2">B.1 Tanggal</div>
            <div class="col-md-8 mb-2">
                <input type="date" readonly name="tanggal" id="tanggal" class="form-control" value="<?php echo "$tanggal"; ?>">
            </div>
            <div class="col-md-4 mb-2">B.2 Jam</div>
            <div class="col-md-8 mb-2">
                <input type="time" readonly name="jam" id="jam" class="form-control" value="<?php echo "$jam"; ?>">
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-12 mb-2">
                <dt>C. Tanggal & Waktu Wawancara</dt>
            </div>
            <div class="col-md-4 mb-2">C.1 Tanggal</div>
            <div class="col-md-8 mb-2">
                <input type="date" name="tanggal_wawancara" id="tanggal_wawancara" class="form-control" value="<?php echo "$tanggal"; ?>">
            </div>
            <div class="col-md-4 mb-2">C.2 Jam</div>
            <div class="col-md-8 mb-2">
                <input type="time" name="jam_wawancara" id="jam_wawancara" class="form-control" value="<?php echo "$jam"; ?>">
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-12 mb-2">
                <dt>D. Informasi Petugas & Objek</dt>
            </div>
            <div class="col-md-4 mb-2">D.1 Petugas Entry</div>
            <div class="col-md-8 mb-2">
                <input type="text" name="petugas_entry" id="petugas_entry" class="form-control" value="<?php echo "$SessionNama"; ?>">
            </div>
            <div class="col-md-4 mb-2">D.2 Penanya</div>
            <div class="col-md-8 mb-2">
                <input type="text" name="penanya" id="penanya" class="form-control">
            </div>
            <div class="col-md-4 mb-2">D.2 Objek </div>
            <div class="col-md-8 mb-2">
                <input type="text" name="objek" id="objek" class="form-control">
                <small>Pihak yang diwawancarai</small>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-12 mb-2">
                <dt>E. Psikologi</dt>
            </div>
            <div class="col-md-12 mb-2">
                <div class="row mb-2">
                    <div class="col-md-4 mb-2">E.1 Status Psikologi</div>
                    <div class="col-md-8 mb-2">
                        <select name="status_psikologi" id="status_psikologi" class="form-control">
                            <option value="">Pilih</option>
                            <option value="1.Tidak ada kelainan">1.Tidak ada kelainan</option>
                            <option value="2.Cemas">2.Cemas</option>
                            <option value="3.Takut">3.Takut</option>
                            <option value="4.Takut">4.Marah</option>
                            <option value="5.Sedih">5.Sedih</option>
                            <option value="6.Lain-lain">6.Lain-lain</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4 mb-2">E.2 Keterangan</div>
                    <div class="col-md-8 mb-2">
                        <textarea name="keterangan_psikologi" id="keterangan_psikologi" class="form-control"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-12 mb-2">
                <dt>F. Sosial</dt>
            </div>
            <div class="col-md-12 mb-2">
                <div class="row mb-2">
                    <div class="col-md-4 mb-2">F.1 Pendidikan</div>
                    <div class="col-md-8 mb-2">
                        <select name="pendidikan" id="pendidikan" class="form-control">
                            <option value="">Pilih</option>
                            <option value="Tidak Sekolah">Tidak Sekolah</option>
                            <option value="Pra TK">Pra TK</option>
                            <option value="TK">TK</option>
                            <option value="SD">SD</option>
                            <option value="SMP">SMP</option>
                            <option value="SMA">SMA</option>
                            <option value="D1">D1</option>
                            <option value="D2">D2</option>
                            <option value="D3">D3</option>
                            <option value="S1">S1</option>
                            <option value="S2">S2</option>
                            <option value="S3">S3</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4 mb-2">F.2 Profesi</div>
                    <div class="col-md-8 mb-2">
                        <input type="text" name="profesi" id="profesi" class="form-control">
                        <small>Gambaran pekerjaan secara spesifik</small>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4 mb-2">F.3 Lokasi Kerja</div>
                    <div class="col-md-8 mb-2">
                        <input type="text" name="tempat_kerja" id="tempat_kerja" class="form-control">
                        <small>Penejelasan lokasi kerja/nama perusahaan</small>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4 mb-2">F.4 Penghasilan</div>
                    <div class="col-md-8 mb-2">
                        <input type="text" name="penghasilan" id="penghasilan" class="form-control">
                        <small>Penghasilan akumulasi bruto keluarga per bulan</small>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4 mb-2">F.5 Suku</div>
                    <div class="col-md-8 mb-2">
                        <input type="text" name="suku" id="suku" class="form-control">
                        <small>Lebih dari 1 pisahkan dengan koma (,)</small>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4 mb-2">F.6 Bahasa</div>
                    <div class="col-md-8 mb-2">
                        <input type="text" name="bahasa" id="bahasa" class="form-control">
                        <small>Lebih dari 1 pisahkan dengan koma (,)</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-12 mb-2">
                <dt>G. Agama</dt>
            </div>
            <div class="col-md-12 mb-2">
                <div class="row mb-2">
                    <div class="col-md-4 mb-2">G.1 Agama</div>
                    <div class="col-md-8 mb-2">
                        <select name="agama" id="agama" class="form-control">
                            <option value="">Pilih</option>
                            <option value="Islam">Islam</option>
                            <option value="Kristen Protestan">Kristen Protestan</option>
                            <option value="Katolik">Katolik</option>
                            <option value="Hindu">Hindu</option>
                            <option value="Buddha">Buddha</option>
                            <option value="Khonghucu">Khonghucu</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4 mb-2">G.2 Nilai</div>
                    <div class="col-md-8 mb-2">
                        <textarea name="nilai" id="nilai" class="form-control"></textarea>
                        <small>Nilai keagamaan yang dianut keluarga/individu</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12" id="NotifikasiTambahPsikosos">
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