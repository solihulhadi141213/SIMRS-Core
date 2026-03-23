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
                <input type="date" readonly name="tanggal_entry" id="tanggal_entry" class="form-control" value="<?php echo "$tanggal"; ?>">
            </div>
            <div class="col-md-4 mb-2">B.2 Jam</div>
            <div class="col-md-8 mb-2">
                <input type="time" readonly name="jam_entry" id="jam_entry" class="form-control" value="<?php echo "$jam"; ?>">
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-12 mb-2">
                <dt>C. Tanggal & Waktu Periksa</dt>
            </div>
            <div class="col-md-4 mb-2">C.1 Tanggal</div>
            <div class="col-md-8 mb-2">
                <input type="date" name="tanggal_periksa" id="tanggal_periksa" class="form-control" value="<?php echo "$tanggal"; ?>">
            </div>
            <div class="col-md-4 mb-2">C.2 Jam</div>
            <div class="col-md-8 mb-2">
                <input type="time" name="jam_periksa" id="jam_periksa" class="form-control" value="<?php echo "$jam"; ?>">
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-12 mb-2">
                <dt>D. Informasi Petugas</dt>
            </div>
            <div class="col-md-4 mb-2">D.1 Petugas Entry</div>
            <div class="col-md-8 mb-2">
                <input type="text" name="petugas_entry" id="petugas_entry" class="form-control" value="<?php echo "$SessionNama"; ?>">
            </div>
            <div class="col-md-4 mb-2">D.2 Pemeriksa</div>
            <div class="col-md-8 mb-2">
                <input type="text" name="pemeriksa" id="pemeriksa" class="form-control">
            </div>
            <div class="col-md-4 mb-2">D.2 Dokter </div>
            <div class="col-md-8 mb-2">
                <input type="text" name="dokter" id="dokter" class="form-control">
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-12 mb-2">
                <dt>E. Decubitus</dt>
            </div>
            <div class="col-md-12 mb-2">
                <div class="row mb-2">
                    <div class="col-md-4 mb-2">E.1 Status Decubitus</div>
                    <div class="col-md-8 mb-2">
                        <select name="status_decubitus" id="status_decubitus" class="form-control">
                            <option value="">Pilih</option>
                            <option value="Ya">Ya</option>
                            <option value="Tidak">Tidak</option>
                        </select>
                        <small>Risiko Luka Decubitus</small>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4 mb-2">E.2 Keterangan</div>
                    <div class="col-md-8 mb-2">
                        <textarea readonly name="keterangan_decubitus" id="keterangan_decubitus" class="form-control"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-12 mb-2">
                <dt>F. Batuk</dt>
            </div>
            <div class="col-md-12 mb-2">
                <ol>
                    <li>
                        <input type="checkbox" name="batuk1" id="batuk1" value="Ya">
                        <label for="batuk1">Riwayat demam</label>
                    </li>
                    <li>
                        <input type="checkbox" name="batuk2" id="batuk2" value="Ya">
                        <label for="batuk2">Berkeringat pada malam hari tanpa aktivitas</label>
                    </li>
                    <li>
                        <input type="checkbox" name="batuk3" id="batuk3" value="Ya">
                        <label for="batuk3">Riwayat berpergian dari daerah wabah</label>
                    </li>
                    <li>
                        <input type="checkbox" name="batuk4" id="batuk4" value="Ya">
                        <label for="batuk4">Riwayat pemakaian obat jangka panjang</label>
                    </li>
                    <li>
                        <input type="checkbox" name="batuk5" id="batuk5" value="Ya">
                        <label for="batuk5">Riwayat BB turun tanpa sebab yang diketahui</label>
                    </li>
                </ol>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-12 mb-2">
                <dt>G. Gizi</dt>
            </div>
            <div class="col-md-12 mb-2">
                <div class="row mb-2">
                    <div class="col-md-12 mb-2">
                        <ol>
                            <li>
                                <input type="checkbox" name="gizi1" id="gizi1" value="Ya">
                                <label for="gizi1">Penurunan BB dalam waktu 6 bulan terakhir</label>
                                <input readonly type="number" min="0" step="0.01" name="gizi1a" id="gizi1a" class="form-control">
                                <label for="gizi1a">Jumlah rata-rata penurunan (Kg)</label>
                            </li>
                            <li>
                                <input type="checkbox" name="gizi2" id="gizi2" value="Ya">
                                <label for="gizi2">Penurunan asupan makanan karena nafsu makan berkurang</label>
                                <input readonly type="text" name="gizi2a" id="gizi2a" class="form-control">
                                <label for="gizi2a">Keterangan/Alasan</label>
                            </li>
                            <li>
                                <input type="checkbox" name="gizi3" id="gizi3" value="Ya">
                                <label for="gizi3">Gejala gastrointestinal</label>
                                <input readonly type="text" name="gizi3a" id="gizi3a" class="form-control">
                                <label for="gizi3a">Sebutkan (mual,muntah, diare, anorexia)</label>
                            </li>
                            <li>
                                <input type="checkbox" name="gizi4" id="gizi4" value="Ya">
                                <label for="gizi4">Faktor pemberat (komorbid)</label>
                                <input readonly type="text" name="gizi4a" id="gizi4a" class="form-control">
                                <label for="gizi3a">Keterangan/Sebutkan</label>
                            </li>
                            <li>
                                <input type="checkbox" name="gizi5" id="gizi5" value="Ya">
                                <label for="gizi5">Penurunan kapasitas fungsional</label>
                                <input readonly type="text" name="gizi5a" id="gizi5a" class="form-control">
                                <label for="gizi5a">Keterangan/Jelaskan</label>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12" id="NotifikasiTambahScreening">
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