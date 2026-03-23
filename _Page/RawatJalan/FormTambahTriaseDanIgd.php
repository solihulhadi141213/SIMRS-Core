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
        $noRujukan=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'noRujukan');
        $rujukan_dari=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'rujukan_dari');
?>
    <div class="modal-body">
        <div class="row mb-3">
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
        <div class="row mb-3">
            <div class="col-md-12 mb-2">
                <dt>B. Tanggal & Waktu Pencatatan</dt>
            </div>
            <div class="col-md-4 mb-2">B.1 Tanggal</div>
            <div class="col-md-8 mb-2">
                <input type="date" name="tanggal_catat" id="tanggal_catat" class="form-control" value="<?php echo "$tanggal"; ?>">
            </div>
            <div class="col-md-4 mb-2">B.2 Jam</div>
            <div class="col-md-8 mb-2">
                <input type="time" name="jam_catat" id="jam_catat" class="form-control" value="<?php echo "$jam"; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12 mb-2">
                <dt>C. Tanggal & Waktu Pasien Masuk</dt>
            </div>
            <div class="col-md-4 mb-2">C.1 Tanggal</div>
            <div class="col-md-8 mb-2">
                <input type="date" name="tanggal_masuk" id="tanggal_masuk" class="form-control" value="<?php echo "$tanggal"; ?>">
            </div>
            <div class="col-md-4 mb-2">C.2 Jam</div>
            <div class="col-md-8 mb-2">
                <input type="time" name="jam_masuk" id="jam_masuk" class="form-control" value="<?php echo "$jam"; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12 mb-2">
                <dt>D. Sarana Transportasi</dt>
            </div>
            <div class="col-md-4 mb-2">D.1 Kategori</div>
            <div class="col-md-8 mb-2">
                <select name="sarana_transportasi" id="sarana_transportasi" class="form-control">
                    <option value="">Pilih</option>
                    <option value="Ambulans">Ambulans</option>
                    <option value="Mobil">Mobil</option>
                    <option value="Motor">Motor</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
            </div>
            <div class="col-md-4 mb-2">D.2 Keterangan</div>
            <div class="col-md-8 mb-2">
                <input type="text" readonly name="keterangan_sarana_transportasi" id="keterangan_sarana_transportasi" class="form-control">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12 mb-2">
                <dt>E. Surat Pengantar Rujukan</dt>
                <small>Apabila pada pendaftaran kunjungan terdapat data rujukan maka sistem akan mengisi form ini secara otomatis</small>
            </div>
            <div class="col-md-4 mb-2">E.1 Ada/Tidak</div>
            <div class="col-md-8 mb-2">
                <select name="surat_rujukan" id="surat_rujukan" class="form-control">
                    <option value="Pilih">Pilih</option>
                    <option <?php if(!empty($noRujukan)){echo "selected";} ?> value="Ada">Ada</option>
                    <option <?php if(empty($noRujukan)){echo "selected";} ?> value="Tidak">Tidak</option>
                </select>
            </div>
            <div class="col-md-4 mb-2">E.2 Asal Rujukan</div>
            <div class="col-md-8 mb-2">
                <input type="text" <?php if(empty($noRujukan)){echo "readonly";} ?> name="asal_rujukan" id="asal_rujukan" class="form-control" value="<?php echo $rujukan_dari;?>">
            </div>
            <div class="col-md-4 mb-2">E.3 Nomor Surat</div>
            <div class="col-md-8 mb-2">
                <input type="text" <?php if(empty($noRujukan)){echo "readonly";} ?> name="no_surat_rujukan" id="no_surat_rujukan" class="form-control" value="<?php echo $noRujukan;?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12 mb-2">
                <dt>F. Kondisi Pasien Tiba</dt>
            </div>
            <div class="col-md-4 mb-2">F.1 Kategori</div>
            <div class="col-md-8 mb-2">
                <select name="kategori_kondisi_pasien" id="kategori_kondisi_pasien" class="form-control">
                    <option value="Pilih">Pilih</option>
                    <option value="Resusitasi">Resusitasi</option>
                    <option value="Emergency">Emergency</option>
                    <option value="Urgent">Urgent</option>
                    <option value="Less Urgent">Less Urgent</option>
                    <option value="Non Urgent">Non Urgent</option>
                    <option value="Death on Arrival">Death on Arrival</option>
                </select>
            </div>
            <div class="col-md-4 mb-2">F.2 Penjelasan</div>
            <div class="col-md-8 mb-2">
                <input type="text" name="penjelasan_kondisi_pasien" id="penjelasan_kondisi_pasien" class="form-control" value="">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12 mb-2">
                <dt>G. Pengantar Pasien</dt>
            </div>
            <div class="col-md-4 mb-2">G.1 Nama</div>
            <div class="col-md-8 mb-2">
                <input type="text" name="nama_pengantar_pasien" id="nama_pengantar_pasien" class="form-control" value="">
            </div>
            <div class="col-md-4 mb-2">G.2 No.Kontak</div>
            <div class="col-md-8 mb-2">
                <input type="text" name="kontak_pengantar_pasien" id="kontak_pengantar_pasien" class="form-control" value="">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12 mb-2">
                <dt>H. Asesmen Nyeri</dt>
            </div>
            <div class="col-md-4 mb-2">H.1 Ada/Tidak</div>
            <div class="col-md-8 mb-2">
                <select name="asesmen_nyeri" id="asesmen_nyeri" class="form-control">
                    <option value="Pilih">Pilih</option>
                    <option value="Ada">Ada</option>
                    <option value="Tidak">Tidak</option>
                </select>
            </div>
        </div>
        <div id="FormAsesmenNyeri"></div>
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12 mb-2">
                        <dt>I. Kajian Risiko Jatuh</dt>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-12 mb-2">
                        I.1 MFS <i>(Morse Fall Scale)</i>
                    </div>
                    <div class="col-md-12 mb-2">
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <small>Riwayat jatuh: baru saja atau dalam 3 bulan</small>
                            </div>
                            <div class="col-md-8">
                                <select name="resikoi_jatuh_mfs1" id="resikoi_jatuh_mfs1" class="form-control">
                                    <option value="0">Tidak (0)</option>
                                    <option value="25">Ya (25)</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <small>Diagnosis Lain</small>
                            </div>
                            <div class="col-md-8">
                                <select name="resikoi_jatuh_mfs2" id="resikoi_jatuh_mfs2" class="form-control">
                                    <option value="0">Tidak (0)</option>
                                    <option value="15">Ya (15)</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <small>Bantuan Berjalan</small>
                            </div>
                            <div class="col-md-8">
                                <select name="resikoi_jatuh_mfs3" id="resikoi_jatuh_mfs3" class="form-control">
                                    <option value="0">Tidak Ada (0)</option>
                                    <option value="15">Tongkat/alat bantu (15)</option>
                                    <option value="30">Furnitur (30)</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <small>Heparin Lock</small>
                            </div>
                            <div class="col-md-8">
                                <select name="resikoi_jatuh_mfs4" id="resikoi_jatuh_mfs4" class="form-control">
                                    <option value="0">Tidak (0)</option>
                                    <option value="20">Ya (20)</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <small>Cara Berjalan/Berpindah</small>
                            </div>
                            <div class="col-md-8">
                                <select name="resikoi_jatuh_mfs5" id="resikoi_jatuh_mfs5" class="form-control">
                                    <option value="0">Normal (0)</option>
                                    <option value="10">Lemah (10)</option>
                                    <option value="20">Terganggu (20)</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <small>Status Mental</small>
                            </div>
                            <div class="col-md-8">
                                <select name="resikoi_jatuh_mfs6" id="resikoi_jatuh_mfs6" class="form-control">
                                    <option value="0">Mengetahui kemampuan diri (0)</option>
                                    <option value="15">Lupa Keterbatasan (15)</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <small>Skor/Kategori</small>
                            </div>
                            <div class="col-md-8" id="resikoi_jatuh_mfs_skor_kategori"></div>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-12 mb-2">
                        I.2 HDS <i>(Humpty Dumpty Scale)</i>
                    </div>
                    <div class="col-md-12 mb-2">
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <small>Umur</small>
                            </div>
                            <div class="col-md-8">
                                <select name="resikoi_jatuh_hds1" id="resikoi_jatuh_hds1" class="form-control">
                                    <option value="">Pilih</option>
                                    <option value="4">< 3 tahun (4)</option>
                                    <option value="3">3-7 tahun (3)</option>
                                    <option value="2">7-13 tahun (2)</option>
                                    <option value="1">13-18 tahun (1)</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <small>Jenis Kelamin</small>
                            </div>
                            <div class="col-md-8">
                                <select name="resikoi_jatuh_hds2" id="resikoi_jatuh_hds2" class="form-control">
                                    <option value="">Pilih</option>
                                    <option value="2">Laki-laki (2)</option>
                                    <option value="1">Perempuan (1)</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <small>Diagnosis</small>
                            </div>
                            <div class="col-md-8">
                                <select name="resikoi_jatuh_hds3" id="resikoi_jatuh_hds3" class="form-control">
                                    <option value="">Pilih</option>
                                    <option value="4">Kelainan neurologi (4)</option>
                                    <option value="3">Gangguan oksigenasi (3)</option>
                                    <option value="2">Kelemahan fisik/kelainan psikis (2)</option>
                                    <option value="1">Ada diagnosis tambahan (1)</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <small>Gangguan kognitif</small>
                            </div>
                            <div class="col-md-8">
                                <select name="resikoi_jatuh_hds4" id="resikoi_jatuh_hds4" class="form-control">
                                    <option value="">Pilih</option>
                                    <option value="3">Tidak memahami keterbatasan (3)</option>
                                    <option value="2">Lupa keterbatasan (2)</option>
                                    <option value="1">Orientasi terhadap kelemahan (1)</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <small>Faktor lingkungan</small>
                            </div>
                            <div class="col-md-8">
                                <select name="resikoi_jatuh_hds5" id="resikoi_jatuh_hds5" class="form-control">
                                    <option value="">Pilih</option>
                                    <option value="4">Riwayat jatuh dari tempat tidur (4)</option>
                                    <option value="3">Pasien menggunakan alat bantu (3)</option>
                                    <option value="2">Pasien berada di tempat tidur (2)</option>
                                    <option value="1">Pasien berada di luar area ruang perawatan (1)</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <small>Respon terhadap obat</small>
                            </div>
                            <div class="col-md-8">
                                <select name="resikoi_jatuh_hds6" id="resikoi_jatuh_hds6" class="form-control">
                                    <option value="">Pilih</option>
                                    <option value="3">Kurang dari 24 jam (3)</option>
                                    <option value="2">Kurang dari 48 jam (2)</option>
                                    <option value="1">Lebih dari 48 jam (1)</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <small>Penggunaan obat</small>
                            </div>
                            <div class="col-md-8">
                                <select name="resikoi_jatuh_hds7" id="resikoi_jatuh_hds7" class="form-control">
                                    <option value="">Pilih</option>
                                    <option value="3">Penggunaan obat sedative (3)</option>
                                    <option value="2">Hiponotik, barbitural, fenotazin, antidepresan, laksatif/diuretik, narotik/metadon (2)</option>
                                    <option value="1">Pengobatan lain (1)</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <small>Skor/Kategori</small>
                            </div>
                            <div class="col-md-8" id="resikoi_jatuh_hds_skor_kategori"></div>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-12 mb-2">
                        I.3 EPFRA <i>(Edmonson Psychiatric Fall Risk Assessment)</i>
                    </div>
                    <div class="col-md-12 mb-2">
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <small>Umur</small>
                            </div>
                            <div class="col-md-8">
                                <select name="resikoi_jatuh_epfra1" id="resikoi_jatuh_epfra1" class="form-control">
                                    <option value="">Pilih</option>
                                    <option value="8">< 50 tahun (8)</option>
                                    <option value="10">3-7 tahun (10)</option>
                                    <option value="26">7-13 tahun (26)</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <small>Status Mental</small>
                            </div>
                            <div class="col-md-8">
                                <select name="resikoi_jatuh_epfra2" id="resikoi_jatuh_epfra2" class="form-control">
                                    <option value="">Pilih</option>
                                    <option value="-4">Sadar Penuh Dan Orientasi Waktu Baik (-4)</option>
                                    <option value="13">Agitasi (Cemas) (13)</option>
                                    <option value="12">Sering Bingung (12)</option>
                                    <option value="14">Bingung dan Disorientasi (14)</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <small>Eliminasi</small>
                            </div>
                            <div class="col-md-8">
                                <select name="resikoi_jatuh_epfra3" id="resikoi_jatuh_epfra3" class="form-control">
                                    <option value="">Pilih</option>
                                    <option value="8">Mandiri untuk BAB dan BAK (8)</option>
                                    <option value="12">Memakai kateter/ostomy (12)</option>
                                    <option value="10">BAB dan BAK dengan Bantuan (10)</option>
                                    <option value="12">Gangguan Eliminasi (12)</option>
                                    <option value="12">Inkontinesia tetapi bisa ambulasi mandiri (12)</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <small>Medikasi</small>
                            </div>
                            <div class="col-md-8">
                                <select name="resikoi_jatuh_epfra4" id="resikoi_jatuh_epfra4" class="form-control">
                                    <option value="">Pilih</option>
                                    <option value="10">Tidak ada pengobatan yang diberikan(10)</option>
                                    <option value="10">Obat-obatan jantung (10)</option>
                                    <option value="8">Obat psikiatri (8)</option>
                                    <option value="12">Meningkatnya dosis obat yang dikonsumsi (12)</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <small>Diagnosis</small>
                            </div>
                            <div class="col-md-8">
                                <select name="resikoi_jatuh_epfra5" id="resikoi_jatuh_epfra5" class="form-control">
                                    <option value="">Pilih</option>
                                    <option value="10">Bipolar / Gangguan Scizo Affective (10)</option>
                                    <option value="8">Penyalah gunaan zat terlarang dan alkohol (8)</option>
                                    <option value="10">Gangguan depresi mayor (10)</option>
                                    <option value="12">Dimensia/Delirium (12)</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <small>Ambulasi/Keseimbangan</small>
                            </div>
                            <div class="col-md-8">
                                <select name="resikoi_jatuh_epfra6" id="resikoi_jatuh_epfra6" class="form-control">
                                    <option value="">Pilih</option>
                                    <option value="7">Ambulasi Mandiri (7)</option>
                                    <option value="8">Penggunaan Alat Bantu (8)</option>
                                    <option value="10">Vertigo (10)</option>
                                    <option value="8">Langkah stabil dan Menyadari Kemampuan (8)</option>
                                    <option value="15">Langkah stabil dan  Tidak Menyadari Kemampuan (15)</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <small>Nutrisi</small>
                            </div>
                            <div class="col-md-8">
                                <select name="resikoi_jatuh_epfra7" id="resikoi_jatuh_epfra7" class="form-control">
                                    <option value="">Pilih</option>
                                    <option value="12">Sedikit mendapatkan asupan makanan/minum (12)</option>
                                    <option value="0">Nafsu Makan Baik (0)</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <small>Gangguan Tidur</small>
                            </div>
                            <div class="col-md-8">
                                <select name="resikoi_jatuh_epfra8" id="resikoi_jatuh_epfra8" class="form-control">
                                    <option value="">Pilih</option>
                                    <option value="8">Tidak Ada Gangguan Tidur(8)</option>
                                    <option value="12">Ada Gangguan Tidur (12)</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <small>Riwayat Jatuh</small>
                            </div>
                            <div class="col-md-8">
                                <select name="resikoi_jatuh_epfra9" id="resikoi_jatuh_epfra9" class="form-control">
                                    <option value="">Pilih</option>
                                    <option value="8">Tidak Ada Riwayat Jatuh(8)</option>
                                    <option value="14">Ada Riwayat Jatuh Dalam 3 Bulan (14)</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <small>Skor/Kategori</small>
                            </div>
                            <div class="col-md-8" id="resikoi_jatuh_epfra_skor_kategori"></div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        I.4 Pemeriksa
                    </div>
                    <div class="col-md-8">
                        <input type="text" id="nakes_resiko_jatuh" name="nakes_resiko_jatuh" class="form-control">
                        <small>Nama Nakes Yang Memeriksa Resiko Jatuh</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4 mb-2">
                <dt>J. Kesadaran</dt>
            </div>
            <div class="col-md-8 mb-2">
                <select name="kesadaran_pasien" id="kesadaran_pasien" class="form-control">
                    <option value="">Pilih</option>
                    <option value="0.Sadar Baik">Sadar Baik</option>
                    <option value="1.Berespon Dengan Kata-Kata">Berespon Dengan Kata-Kata</option>
                    <option value="2.Hanya Berespon Jika Dirangsang">Hanya Berespon Jika Dirangsang</option>
                    <option value="3.Pasien Tidak Sadar">Pasien Tidak Sadar</option>
                    <option value="4.Gelisah Atau Bingung">Gelisah Atau Bingung</option>
                    <option value="5.Acute Confusional States">Acute Confusional States</option>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12" id="NotifikasiTambahTriaseDanIgd">
                <span class="text-primary">Pastikan informasi triase dan IGD sudah terisi dengan lengkap dan benar.</span>
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