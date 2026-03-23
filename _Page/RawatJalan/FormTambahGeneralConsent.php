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
        $_SESSION['UrlBackGeneralConsent']="index.php?Page=RawatJalan&Sub=DetailKunjungan&id=$id_kunjungan";
        //Buka Detail Pasien
        $id_pasien=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'id_pasien');
        $nama=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'nama');
?>
    <div class="row mb-3">
        <div class="col-md-12 mb-2">
            <dt>1. Informasi Pasien & Kunjungan</dt>
        </div>
        <div class="col-md-4 mb-2">1.1 ID.Kunjungan</div>
        <div class="col-md-8 mb-2">
            <input type="text" name="id_kunjungan" id="id_kunjungan" class="form-control" value="<?php echo "$id_kunjungan"; ?>">
        </div>
        <div class="col-md-4 mb-2">1.2 No.RM</div>
        <div class="col-md-8 mb-2">
            <input type="text" name="id_pasien" id="id_pasien" class="form-control" value="<?php echo "$id_pasien"; ?>">
        </div>
        <div class="col-md-4 mb-2">1.3 Nama Pasien</div>
        <div class="col-md-8 mb-2">
            <input type="text" name="nama_pasien" id="nama_pasien" class="form-control" value="<?php echo "$nama"; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12 mb-2">
            <dt>2. Tanggal & Waktu</dt>
        </div>
        <div class="col-md-4 mb-2">2.1 Tanggal</div>
        <div class="col-md-8 mb-2">
            <input type="date" name="tanggal" id="tanggal" class="form-control" value="<?php echo "$tanggal"; ?>">
        </div>
        <div class="col-md-4 mb-2">2.2 Jam</div>
        <div class="col-md-8 mb-2">
            <input type="time" name="jam" id="jam" class="form-control" value="<?php echo "$jam"; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12 mb-2">
            <dt>3. Penanggung Jawab</dt>
        </div>
        <div class="col-md-4 mb-2">3.1 Nama</div>
        <div class="col-md-8 mb-2">
            <input type="text" name="nama_penanggung_jawab" id="nama_penanggung_jawab" class="form-control">
        </div>
        <div class="col-md-4 mb-2">3.2 NIK</div>
        <div class="col-md-8 mb-2">
            <input type="text" name="nik_penanggung_jawab" id="nik_penanggung_jawab" class="form-control">
        </div>
        <div class="col-md-4 mb-2">3.3 Kontak/HP</div>
        <div class="col-md-8 mb-2">
            <input type="text" name="nomor_kontak" id="nomor_kontak" class="form-control">
        </div>
        <div class="col-md-4 mb-2">3.4 Alamat</div>
        <div class="col-md-8 mb-2">
            <input type="text" name="alamat" id="alamat" class="form-control">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12 mb-2">
            <dt>4. Saksi/Petugas RS</dt>
        </div>
        <div class="col-md-4 mb-2">4.1 Nama</div>
        <div class="col-md-8 mb-2">
            <input type="text" name="nama_petugas" id="nama_petugas" class="form-control" value="<?php echo $SessionNama; ?>">
        </div>
        <div class="col-md-4 mb-2">4.2 NIK</div>
        <div class="col-md-8 mb-2">
            <input type="text" name="nik_petugas" id="nik_petugas" class="form-control">
        </div>
        <div class="col-md-4 mb-2">4.3 Kontak/HP</div>
        <div class="col-md-8 mb-2">
            <input type="text" name="nomor_kontak_petugas" id="nomor_kontak_petugas" class="form-control" value="<?php echo $SessionKontak; ?>">
        </div>
        <div class="col-md-4 mb-2">4.4 Alamat</div>
        <div class="col-md-8 mb-2">
            <input type="text" name="alamat_petugas" id="alamat_petugas" class="form-control">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12 mb-2">
            <dt>5. Persetujuan Pasien</dt>
        </div>
        <div class="col-md-12 mb-2">
            <ol>
                <li>
                    Pernyataan pasien<br>
                    <span>
                        Pernyataan pasien yang menyatakan persetujuan atau tidak atas pelayanan RS.
                    </span><br>
                    <small>
                        <input type="radio" checked name="PernyataanPasien" id="PernyataanPasienYa" value="Ya">
                        <label for="PernyataanPasienYa">Ya</label>
                        <input type="radio" name="PernyataanPasien" id="PernyataanPasienTidak" value="Tidak">
                        <label for="PernyataanPasienTidak">Tidak</label>
                    </small>
                </li>
                <li>
                    Informasi Ketentuan Pembayaran<br>
                    <span>
                        Penjelasan dari petugas RS mengenai ketentuan pembayaran pelayanan RS.
                    </span><br>
                    <small>
                        <input type="radio" checked name="InformasiPembayaran" id="InformasiPembayaranSetuju" value="Setuju">
                        <label for="InformasiPembayaranSetuju">Setuju</label>
                        <input type="radio" name="InformasiPembayaran" id="InformasiPembayaranTidak" value="Tidak">
                        <label for="InformasiPembayaranTidak">Tidak</label>
                    </small>
                </li>
                <li>
                    Informasi tentang Hak dan Kewajiban Pasien<br>
                    <span>
                    Penjelasan dari petugas RS mengenai hak dan kewajiban pasien
                    </span><br>
                    <small>
                        <input type="radio" checked name="InformasiHakDanKewajiban" id="InformasiHakDanKewajibanSetuju" value="Setuju">
                        <label for="InformasiHakDanKewajibanSetuju">Setuju</label>
                        <input type="radio" name="InformasiHakDanKewajiban" id="InformasiHakDanKewajibanTidak" value="Tidak">
                        <label for="InformasiHakDanKewajibanTidak">Tidak</label>
                    </small>
                </li>
                <li>
                    Informasi tentang Tata Tertib RS<br>
                    <span>
                    Penjelasan dari petugas RS mengenai tata tertib RS
                    </span><br>
                    <small>
                        <input type="radio" checked name="InformasiTataTertib" id="InformasiTataTertibSetuju" value="Setuju">
                        <label for="InformasiTataTertibSetuju">Setuju</label>
                        <input type="radio" name="InformasiTataTertib" id="InformasiTataTertibTidak" value="Tidak">
                        <label for="InformasiTataTertibTidak">Tidak</label>
                    </small>
                </li>
                <li>
                    Kebutuhan Penterjemah Bahasa<br>
                    <span>
                    Penjelasan dari petugas RS mengenai kebutuhan akan penterjemah bahasa
                    </span><br>
                    <small>
                        <input type="radio" checked name="KebutuhanPenterjemah" id="KebutuhanPenterjemahYa" value="Ya">
                        <label for="KebutuhanPenterjemahYa">Ya</label>
                        <input type="radio" name="KebutuhanPenterjemah" id="KebutuhanPenterjemahTidak" value="Tidak">
                        <label for="KebutuhanPenterjemahTidak">Tidak</label>
                    </small>
                </li>
                <li>
                    Kebutuhan Rohaniawan<br>
                    <span>
                        Penjelasan dari petugas RS mengenai kebutuhan akan rohaniawan
                    </span><br>
                    <small>
                        <input type="radio" checked name="KebutuhanRohaniawan" id="KebutuhanRohaniawanYa" value="Ya">
                        <label for="KebutuhanRohaniawanYa">Ya</label>
                        <input type="radio" name="KebutuhanRohaniawan" id="KebutuhanRohaniawanTidak" value="Tidak">
                        <label for="KebutuhanRohaniawanTidak">Tidak</label>
                    </small>
                </li>
                <li>
                    Pelepasan Informasi / Kerahasiaan Informasi<br>
                    <span>
                    Penjelasan dari petugas RS mengenai konsekuensi pelepasan informasi terkait data-data pasien
                    </span><br>
                    <small>
                        <input type="radio" checked name="PelepasanInformasi" id="PelepasanInformasiSetuju" value="Setuju">
                        <label for="PelepasanInformasiSetuju">Setuju</label>
                        <input type="radio" name="PelepasanInformasi" id="PelepasanInformasiTidak" value="Tidak">
                        <label for="PelepasanInformasiTidak">Tidak</label>
                    </small>
                    <li>
                        Hasil Pemeriksaan Penunjang dapat Diberikan kepada Pihak Penjamin<br>
                        <span>
                        Hasil pembacaan dari hasil pemeriksaan penunjang yang diberikan kepada pihak penjamin
                        </span><br>
                        <small>
                            <input type="radio" checked name="HasilPemeriksaanPenunjang" id="HasilPemeriksaanPenunjangSetuju" value="Setuju">
                            <label for="HasilPemeriksaanPenunjangSetuju">Setuju</label>
                            <input type="radio" name="HasilPemeriksaanPenunjang" id="HasilPemeriksaanPenunjangTidak" value="Tidak">
                            <label for="HasilPemeriksaanPenunjangTidak">Tidak</label>
                        </small>
                    </li>
                    <li>
                        Hasil Pemeriksaan Penunjang dapat Diakses oleh Peserta Didik<br>
                        <span>
                        Hasil pemeriksaan penunjang yang dapat diinformasikan/diakses kepada peserta didik
                        </span><br>
                        <small>
                            <input type="radio" checked name="HasilPemeriksaanPenunjang2" id="HasilPemeriksaanPenunjangSetuju2" value="Setuju">
                            <label for="HasilPemeriksaanPenunjangSetuju2">Setuju</label>
                            <input type="radio" name="HasilPemeriksaanPenunjang2" id="HasilPemeriksaanPenunjangTidak2" value="Tidak">
                            <label for="HasilPemeriksaanPenunjangTidak2">Tidak</label>
                        </small>
                    </li>
                    <li>
                        Fasyankes tertentu dalam rangka rujukan<br>
                        <span>
                        Persetujuan terkait dengan informasi pasien yang diberikan kepada fasyankes yang akan dituju
                        </span><br>
                        <small>
                            <input type="radio" checked name="FasyankesRujukan" id="FasyankesRujukanSetuju" value="Setuju">
                            <label for="FasyankesRujukanSetuju">Setuju</label>
                            <input type="radio" name="FasyankesRujukan" id="FasyankesRujukanTidak" value="Tidak">
                            <label for="FasyankesRujukanTidak">Tidak</label>
                        </small>
                    </li>
                </li>
            </ol>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12" id="NotifikasiTambahGeneralConsent">
            <span class="text-primary">Pastikan informasi <i>General Consent</i> sudah terisi dengan lengkap dan benar.</span>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <button type="submit" class="btn btn-sm btn-block btn-primary">
                <i class="ti ti-save"></i> Simpan
            </button>
        </div>
    </div>
<?php } ?>