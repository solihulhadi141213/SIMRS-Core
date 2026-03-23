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
        $id_pasien=getDataDetail($Conn,"general_consent",'id_kunjungan',$id_kunjungan,'id_pasien');
        $id_akses=getDataDetail($Conn,"general_consent",'id_kunjungan',$id_kunjungan,'id_akses');
        $id_general_consent=getDataDetail($Conn,"general_consent",'id_kunjungan',$id_kunjungan,'id_general_consent');
        $tanggal=getDataDetail($Conn,"general_consent",'id_kunjungan',$id_kunjungan,'tanggal');
        $nama_pasien=getDataDetail($Conn,"general_consent",'id_kunjungan',$id_kunjungan,'nama_pasien');
        $nama_petugas=getDataDetail($Conn,"general_consent",'id_kunjungan',$id_kunjungan,'nama_petugas');
        $penanggung_jawab=getDataDetail($Conn,"general_consent",'id_kunjungan',$id_kunjungan,'penanggung_jawab');
        $general_consent=getDataDetail($Conn,"general_consent",'id_kunjungan',$id_kunjungan,'general_consent');
        //Decode JSON
        $JsonPetugas =json_decode($nama_petugas, true);
        $JsonPenanggungJawab =json_decode($penanggung_jawab, true);
        $JsonGeneralConsent =json_decode($general_consent, true);
        //Format Tanggal
        $strtotime=strtotime($tanggal);
        $FormatTanggal=date('Y-m-d', $strtotime);
        $FormatJam=date('H:i', $strtotime);
        //Buka Petugas
        $NamaPetugas=$JsonPetugas['nama'];
        $NikPetugas=$JsonPetugas['nik'];
        $KontakPetugas=$JsonPetugas['kontak'];
        $AlamatPetugas=$JsonPetugas['alamat'];
        //Buka Penanggung Jawab
        $NamaPenanggungJawab=$JsonPenanggungJawab['nama'];
        $NikPenanggungJawab=$JsonPenanggungJawab['nik'];
        $KontakPenanggungJawab=$JsonPenanggungJawab['kontak'];
        $AlamatPenanggungJawab=$JsonPenanggungJawab['alamat'];
        //Buka General Consent
        $pernyataan_1=$JsonGeneralConsent['pernyataan_1'];
        $pernyataan_2=$JsonGeneralConsent['pernyataan_2'];
        $pernyataan_3=$JsonGeneralConsent['pernyataan_3'];
        $pernyataan_4=$JsonGeneralConsent['pernyataan_4'];
        $pernyataan_5=$JsonGeneralConsent['pernyataan_5'];
        $pernyataan_6=$JsonGeneralConsent['pernyataan_6'];
        $pernyataan_7=$JsonGeneralConsent['pernyataan_7'];
        $pernyataan_8=$JsonGeneralConsent['pernyataan_8'];
        $pernyataan_9=$JsonGeneralConsent['pernyataan_9'];
        $pernyataan_10=$JsonGeneralConsent['pernyataan_10'];
?>
    <div class="modal-body">
        <div class="row mb-3">
            <div class="col-md-12 mb-2">
                <dt>1. Informasi Pasien & Kunjungan</dt>
            </div>
            <div class="col-md-4 mb-2">1.1 ID.Kunjungan</div>
            <div class="col-md-8 mb-2">
                <input type="text" readonly name="id_kunjungan" id="id_kunjungan" class="form-control" value="<?php echo "$id_kunjungan"; ?>">
            </div>
            <div class="col-md-4 mb-2">1.2 No.RM</div>
            <div class="col-md-8 mb-2">
                <input type="text" readonly name="id_pasien" id="id_pasien" class="form-control" value="<?php echo "$id_pasien"; ?>">
            </div>
            <div class="col-md-4 mb-2">1.3 Nama Pasien</div>
            <div class="col-md-8 mb-2">
                <input type="text" readonly name="nama_pasien" id="nama_pasien" class="form-control" value="<?php echo "$nama_pasien"; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12 mb-2">
                <dt>2. Tanggal & Waktu</dt>
            </div>
            <div class="col-md-4 mb-2">2.1 Tanggal</div>
            <div class="col-md-8 mb-2">
                <input type="date" name="tanggal" id="tanggal" class="form-control" value="<?php echo "$FormatTanggal"; ?>">
            </div>
            <div class="col-md-4 mb-2">2.2 Jam</div>
            <div class="col-md-8 mb-2">
                <input type="time" name="jam" id="jam" class="form-control" value="<?php echo "$FormatJam"; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12 mb-2">
                <dt>3. Penanggung Jawab</dt>
            </div>
            <div class="col-md-4 mb-2">3.1 Nama</div>
            <div class="col-md-8 mb-2">
                <input type="text" name="nama_penanggung_jawab" id="nama_penanggung_jawab" class="form-control" value="<?php echo "$NamaPenanggungJawab"; ?>">
            </div>
            <div class="col-md-4 mb-2">3.2 NIK</div>
            <div class="col-md-8 mb-2">
                <input type="text" name="nik_penanggung_jawab" id="nik_penanggung_jawab" class="form-control" value="<?php echo "$NikPenanggungJawab"; ?>">
            </div>
            <div class="col-md-4 mb-2">3.3 Kontak/HP</div>
            <div class="col-md-8 mb-2">
                <input type="text" name="nomor_kontak" id="nomor_kontak" class="form-control" value="<?php echo "$KontakPenanggungJawab"; ?>">
            </div>
            <div class="col-md-4 mb-2">3.4 Alamat</div>
            <div class="col-md-8 mb-2">
                <input type="text" name="alamat" id="alamat" class="form-control" value="<?php echo "$AlamatPenanggungJawab"; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12 mb-2">
                <dt>4. Saksi/Petugas RS</dt>
            </div>
            <div class="col-md-4 mb-2">4.1 Nama</div>
            <div class="col-md-8 mb-2">
                <input type="text" name="nama_petugas" id="nama_petugas" class="form-control" value="<?php echo $NamaPetugas; ?>">
            </div>
            <div class="col-md-4 mb-2">4.2 NIK</div>
            <div class="col-md-8 mb-2">
                <input type="text" name="nik_petugas" id="nik_petugas" class="form-control" value="<?php echo $NikPetugas; ?>">
            </div>
            <div class="col-md-4 mb-2">4.3 Kontak/HP</div>
            <div class="col-md-8 mb-2">
                <input type="text" name="nomor_kontak_petugas" id="nomor_kontak_petugas" class="form-control" value="<?php echo $KontakPetugas; ?>">
            </div>
            <div class="col-md-4 mb-2">4.4 Alamat</div>
            <div class="col-md-8 mb-2">
                <input type="text" name="alamat_petugas" id="alamat_petugas" class="form-control" value="<?php echo $AlamatPetugas; ?>">
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
                            <input <?php if($pernyataan_1=="Ya"){echo "checked";} ?> type="radio" checked name="PernyataanPasien" id="PernyataanPasienYa" value="Ya">
                            <label for="PernyataanPasienYa">Ya</label>
                            <input <?php if($pernyataan_1=="Tidak"){echo "checked";} ?> type="radio" name="PernyataanPasien" id="PernyataanPasienTidak" value="Tidak">
                            <label for="PernyataanPasienTidak">Tidak</label>
                        </small>
                    </li>
                    <li>
                        Informasi Ketentuan Pembayaran<br>
                        <span>
                            Penjelasan dari petugas RS mengenai ketentuan pembayaran pelayanan RS.
                        </span><br>
                        <small>
                            <input type="radio" <?php if($pernyataan_2=="Setuju"){echo "checked";} ?> name="InformasiPembayaran" id="InformasiPembayaranSetuju" value="Setuju">
                            <label for="InformasiPembayaranSetuju">Setuju</label>
                            <input type="radio" <?php if($pernyataan_2=="Tidak"){echo "checked";} ?> name="InformasiPembayaran" id="InformasiPembayaranTidak" value="Tidak">
                            <label for="InformasiPembayaranTidak">Tidak</label>
                        </small>
                    </li>
                    <li>
                        Informasi tentang Hak dan Kewajiban Pasien<br>
                        <span>
                        Penjelasan dari petugas RS mengenai hak dan kewajiban pasien
                        </span><br>
                        <small>
                            <input type="radio" <?php if($pernyataan_3=="Setuju"){echo "checked";} ?> name="InformasiHakDanKewajiban" id="InformasiHakDanKewajibanSetuju" value="Setuju">
                            <label for="InformasiHakDanKewajibanSetuju">Setuju</label>
                            <input type="radio" <?php if($pernyataan_3=="Tidak"){echo "checked";} ?> name="InformasiHakDanKewajiban" id="InformasiHakDanKewajibanTidak" value="Tidak">
                            <label for="InformasiHakDanKewajibanTidak">Tidak</label>
                        </small>
                    </li>
                    <li>
                        Informasi tentang Tata Tertib RS<br>
                        <span>
                        Penjelasan dari petugas RS mengenai tata tertib RS
                        </span><br>
                        <small>
                            <input type="radio" <?php if($pernyataan_4=="Setuju"){echo "checked";} ?> name="InformasiTataTertib" id="InformasiTataTertibSetuju" value="Setuju">
                            <label for="InformasiTataTertibSetuju">Setuju</label>
                            <input type="radio" <?php if($pernyataan_4=="Tidak"){echo "checked";} ?> name="InformasiTataTertib" id="InformasiTataTertibTidak" value="Tidak">
                            <label for="InformasiTataTertibTidak">Tidak</label>
                        </small>
                    </li>
                    <li>
                        Kebutuhan Penterjemah Bahasa<br>
                        <span>
                        Penjelasan dari petugas RS mengenai kebutuhan akan penterjemah bahasa
                        </span><br>
                        <small>
                            <input type="radio" <?php if($pernyataan_5=="Ya"){echo "checked";} ?> name="KebutuhanPenterjemah" id="KebutuhanPenterjemahYa" value="Ya">
                            <label for="KebutuhanPenterjemahYa">Ya</label>
                            <input type="radio" <?php if($pernyataan_5=="Tidak"){echo "checked";} ?> name="KebutuhanPenterjemah" id="KebutuhanPenterjemahTidak" value="Tidak">
                            <label for="KebutuhanPenterjemahTidak">Tidak</label>
                        </small>
                    </li>
                    <li>
                        Kebutuhan Rohaniawan<br>
                        <span>
                            Penjelasan dari petugas RS mengenai kebutuhan akan rohaniawan
                        </span><br>
                        <small>
                            <input type="radio" <?php if($pernyataan_6=="Ya"){echo "checked";} ?> name="KebutuhanRohaniawan" id="KebutuhanRohaniawanYa" value="Ya">
                            <label for="KebutuhanRohaniawanYa">Ya</label>
                            <input type="radio" <?php if($pernyataan_6=="Tidak"){echo "checked";} ?> name="KebutuhanRohaniawan" id="KebutuhanRohaniawanTidak" value="Tidak">
                            <label for="KebutuhanRohaniawanTidak">Tidak</label>
                        </small>
                    </li>
                    <li>
                        Pelepasan Informasi / Kerahasiaan Informasi<br>
                        <span>
                        Penjelasan dari petugas RS mengenai konsekuensi pelepasan informasi terkait data-data pasien
                        </span><br>
                        <small>
                            <input type="radio" <?php if($pernyataan_7=="Setuju"){echo "checked";} ?> name="PelepasanInformasi" id="PelepasanInformasiSetuju" value="Setuju">
                            <label for="PelepasanInformasiSetuju">Setuju</label>
                            <input type="radio" <?php if($pernyataan_7=="Tidak"){echo "checked";} ?> name="PelepasanInformasi" id="PelepasanInformasiTidak" value="Tidak">
                            <label for="PelepasanInformasiTidak">Tidak</label>
                        </small>
                        <li>
                            Hasil Pemeriksaan Penunjang dapat Diberikan kepada Pihak Penjamin<br>
                            <span>
                            Hasil pembacaan dari hasil pemeriksaan penunjang yang diberikan kepada pihak penjamin
                            </span><br>
                            <small>
                                <input type="radio" <?php if($pernyataan_8=="Setuju"){echo "checked";} ?> name="HasilPemeriksaanPenunjang" id="HasilPemeriksaanPenunjangSetuju" value="Setuju">
                                <label for="HasilPemeriksaanPenunjangSetuju">Setuju</label>
                                <input type="radio" <?php if($pernyataan_8=="Tidak"){echo "checked";} ?> name="HasilPemeriksaanPenunjang" id="HasilPemeriksaanPenunjangTidak" value="Tidak">
                                <label for="HasilPemeriksaanPenunjangTidak">Tidak</label>
                            </small>
                        </li>
                        <li>
                            Hasil Pemeriksaan Penunjang dapat Diakses oleh Peserta Didik<br>
                            <span>
                            Hasil pemeriksaan penunjang yang dapat diinformasikan/diakses kepada peserta didik
                            </span><br>
                            <small>
                                <input type="radio" <?php if($pernyataan_9=="Setuju"){echo "checked";} ?> name="HasilPemeriksaanPenunjang2" id="HasilPemeriksaanPenunjangSetuju2" value="Setuju">
                                <label for="HasilPemeriksaanPenunjangSetuju2">Setuju</label>
                                <input type="radio" <?php if($pernyataan_9=="Tidak"){echo "checked";} ?> name="HasilPemeriksaanPenunjang2" id="HasilPemeriksaanPenunjangTidak2" value="Tidak">
                                <label for="HasilPemeriksaanPenunjangTidak2">Tidak</label>
                            </small>
                        </li>
                        <li>
                            Fasyankes tertentu dalam rangka rujukan<br>
                            <span>
                            Persetujuan terkait dengan informasi pasien yang diberikan kepada fasyankes yang akan dituju
                            </span><br>
                            <small>
                                <input type="radio" <?php if($pernyataan_10=="Setuju"){echo "checked";} ?> name="FasyankesRujukan" id="FasyankesRujukanSetuju" value="Setuju">
                                <label for="FasyankesRujukanSetuju">Setuju</label>
                                <input type="radio" <?php if($pernyataan_10=="Tidak"){echo "checked";} ?> name="FasyankesRujukan" id="FasyankesRujukanTidak" value="Tidak">
                                <label for="FasyankesRujukanTidak">Tidak</label>
                            </small>
                        </li>
                    </li>
                </ol>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12" id="NotifikasiEditGeneralConsent">
                <span class="text-primary">Pastikan informasi <i>General Consent</i> sudah terisi dengan lengkap dan benar.</span>
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