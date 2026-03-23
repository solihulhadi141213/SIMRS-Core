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
        //Membuka Session List Tindakan
        if(!empty($_SESSION['SessionListTindakan'])){
            $SessionListTindakan=$_SESSION['SessionListTindakan'];
            $JsonSessionListTindakan =json_decode($SessionListTindakan, true);
        }else{
            $SessionListTindakan="";
            $JsonSessionListTindakan="";
        }
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
                <dt>B. Pencatatan Persetujuan Tindakan</dt>
            </div>
            <div class="col-md-12 mb-2">
                <div class="row mb-2">
                    <div class="col-md-4 mb-2">B.1 Tanggal</div>
                    <div class="col-md-8 mb-2">
                        <input type="date" readonly name="tanggal_entry" id="tanggal_entry" class="form-control" value="<?php echo "$tanggal"; ?>">
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4 mb-2">B.2 Jam</div>
                    <div class="col-md-8 mb-2">
                        <input type="time" readonly name="jam_entry" id="jam_entry" class="form-control" value="<?php echo "$jam"; ?>">
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4 mb-2">B.3 Petugas Entry</div>
                    <div class="col-md-8 mb-2">
                        <input type="text" name="petugas_entry" id="petugas_entry" class="form-control" value="<?php echo "$SessionNama"; ?>">
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-12 mb-2">
                <dt>C. Tanggal & Waktu Penjelasan Pada Pasien/Pendaping</dt>
            </div>
            <div class="col-md-4 mb-2">C.1 Tanggal</div>
            <div class="col-md-8 mb-2">
                <input type="date" name="tanggal_penjelasan" id="tanggal_penjelasan" class="form-control" value="<?php echo "$tanggal"; ?>">
            </div>
            <div class="col-md-4 mb-2">C.2 Jam</div>
            <div class="col-md-8 mb-2">
                <input type="time" name="jam_penjelasan" id="jam_penjelasan" class="form-control" value="<?php echo "$jam"; ?>">
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-12 mb-2">
                <dt>E. Identitas Dokter Yang Memberikan Penjelasan</dt>
            </div>
            <div class="col-md-12">
                <div class="row mb-2">
                    <div class="col-md-4 mb-2">
                        E.1 Kategori Identitas
                    </div>
                    <div class="col-md-8 mb-2">
                        <select name="kategori_identitas_dokter" id="kategori_identitas_dokter" class="form-control">
                            <option value="">Pilih</option>
                            <option value="NIK">NIK</option>
                            <option value="SIM">SIM</option>
                            <option value="Passport">Passport</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4 mb-2">
                        E.2 Nomor Identitas
                    </div>
                    <div class="col-md-8 mb-2">
                        <input type="text" name="nomor_identitas_dokter" id="nomor_identitas_dokter" class="form-control">
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4 mb-2">
                        E.3 Nama Dokter
                    </div>
                    <div class="col-md-8 mb-2">
                        <input type="text" name="nama_dokter" id="nama_dokter" class="form-control">
                        <small>Nama Harus Sesuai Identitas</small>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4 mb-2">
                        E.4 Pendaping Dokter
                    </div>
                    <div class="col-md-8 mb-2">
                        <input type="text" name="pendaping_dokter" id="pendaping_dokter" class="form-control">
                        <small>Nama petugas yang mendapingi dokter saat memberikan penjelasan</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-12 mb-2">
                <dt>F. Identitas Pemberi Pernyataan</dt>
            </div>
            <div class="col-md-12">
                <div class="row mb-2">
                    <div class="col-md-4 mb-2">
                        F.1 Pasien/Pendaping
                    </div>
                    <div class="col-md-8 mb-2">
                        <select name="pemberi_pernyataan" id="pemberi_pernyataan" class="form-control">
                            <option value="">Pilih</option>
                            <option value="Pasien">Pasien</option>
                            <option value="Pendaping/Keluarga">Pendaping/Keluarga</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4 mb-2">
                        F.2 Kategori Identitas
                    </div>
                    <div class="col-md-8 mb-2">
                        <select name="identitas_pemberi_pernyataan" id="identitas_pemberi_pernyataan" class="form-control">
                            <option value="">Pilih</option>
                            <option value="NIK">NIK</option>
                            <option value="SIM">SIM</option>
                            <option value="Passport">Passport</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4 mb-2">
                        F.3 Nomor Identitas
                    </div>
                    <div class="col-md-8 mb-2">
                        <input type="text" name="nomor_identitas_pemberi_pernyataan" id="nomor_identitas_pemberi_pernyataan" class="form-control">
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4 mb-2">
                        F.4 Nama
                    </div>
                    <div class="col-md-8 mb-2">
                        <input type="text" name="nama_pemberi_pernyataan" id="nama_pemberi_pernyataan" class="form-control">
                        <small>Nama Harus Sesuai Identitas</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-12 mb-2">
                <dt>G. Saksi 1 (Dari Pihak RS)</dt>
            </div>
            <div class="col-md-12">
                <div class="row mb-2">
                    <div class="col-md-4 mb-2">
                        G.1 Kategori Identitas
                    </div>
                    <div class="col-md-8 mb-2">
                        <select name="identitas_saksi1" id="identitas_saksi1" class="form-control">
                            <option value="">Pilih</option>
                            <option value="NIK">NIK</option>
                            <option value="SIM">SIM</option>
                            <option value="Passport">Passport</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4 mb-2">
                        G.2 Nomor Identitas
                    </div>
                    <div class="col-md-8 mb-2">
                        <input type="text" name="nomor_identitas_saksi1" id="nomor_identitas_saksi1" class="form-control">
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4 mb-2">
                        G.3 Nama
                    </div>
                    <div class="col-md-8 mb-2">
                        <input type="text" name="nama_saksi1" id="nama_saksi1" class="form-control">
                        <small>Nama Harus Sesuai Identitas</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-12 mb-2">
                <dt>H. Saksi 2 (Dari Pihak Pasien)</dt>
            </div>
            <div class="col-md-12">
                <div class="row mb-2">
                    <div class="col-md-4 mb-2">
                        H.1 Kategori Identitas
                    </div>
                    <div class="col-md-8 mb-2">
                        <select name="identitas_saksi2" id="identitas_saksi2" class="form-control">
                            <option value="">Pilih</option>
                            <option value="NIK">NIK</option>
                            <option value="SIM">SIM</option>
                            <option value="Passport">Passport</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4 mb-2">
                        H.2 Nomor Identitas
                    </div>
                    <div class="col-md-8 mb-2">
                        <input type="text" name="nomor_identitas_saksi2" id="nomor_identitas_saksi2" class="form-control">
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4 mb-2">
                        H.3 Nama
                    </div>
                    <div class="col-md-8 mb-2">
                        <input type="text" name="nama_saksi2" id="nama_saksi2" class="form-control">
                        <small>Nama Harus Sesuai Identitas</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-12 mb-2">
                <dt>I. Tindakan</dt>
            </div>
            <div class="col-md-12">
                <!-- <div class="row mb-2">
                    <div class="col-md-4 mb-2">
                        I.1.Tindakan
                    </div>
                    <div class="col-md-8 mb-2">
                        <ol>
                            <li>
                                <input type="checkbox" id="isi_tindakan_utama1" name="isi_tindakan_utama" value="Cateterisasi Vena (Pemasangan Infus)">
                                <label for="isi_tindakan_utama1">Cateterisasi Vena (Pemasangan Infus)</label>
                            </li>
                            <li>
                                <input type="checkbox" id="isi_tindakan_utama2" name="isi_tindakan_utama" value="Pemasangan transfusi darah">
                                <label for="isi_tindakan_utama2">Pemasangan transfusi darah</label>
                            </li>
                            <li>
                                <input type="checkbox" id="isi_tindakan_utama3" name="isi_tindakan_utama" value="Pemasangan NGT">
                                <label for="isi_tindakan_utama3">Pemasangan NGT</label>
                            </li>
                            <li>
                                <input type="checkbox" id="isi_tindakan_utama4" name="isi_tindakan_utama" value="Pemberian Suntikan (IV, Im, Ic)">
                                <label for="isi_tindakan_utama4">Pemberian Suntikan (IV, Im, Ic)</label>
                            </li>
                            <li>
                                <input type="checkbox" id="isi_tindakan_utama5" name="isi_tindakan_utama" value="Pemasangan Cateterisasi Urine (Dower Cateter)">
                                <label for="isi_tindakan_utama5">Pemasangan Cateterisasi Urine (Dower Cateter)</label>
                            </li>
                            <li>
                                <input type="checkbox" id="isi_tindakan_utama6" name="isi_tindakan_utama" value="Resusitasi Jantung Paru (RJP)">
                                <label for="isi_tindakan_utama6">Resusitasi Jantung Paru (RJP)</label>
                            </li>
                            <li>
                                <input type="checkbox" id="isi_tindakan_utama7" name="isi_tindakan_utama" value="Suction">
                                <label for="isi_tindakan_utama7">Suction</label>
                            </li>
                            <li>
                                <input type="checkbox" id="isi_tindakan_utama8" name="isi_tindakan_utama" value="Hecting">
                                <label for="isi_tindakan_utama8">Hecting</label>
                            </li>
                            <li>
                                <input type="checkbox" id="isi_tindakan_utama9" name="isi_tindakan_utama" value="Pengambilan Sample Darah">
                                <label for="isi_tindakan_utama9">Pengambilan Sample Darah</label>
                            </li>
                            <li>
                                <input type="checkbox" id="isi_tindakan_utama10" name="isi_tindakan_utama" value="Perawatan Luka">
                                <label for="isi_tindakan_utama10">Perawatan Luka</label>
                            </li>
                            <li>
                                <input type="checkbox" id="isi_tindakan_utama11" name="isi_tindakan_utama" value="Pemasangan Oxygen">
                                <label for="isi_tindakan_utama11">Pemasangan Oxygen</label>
                            </li>
                            <li>
                                <input type="checkbox" id="isi_tindakan_utama12" name="isi_tindakan_utama" value="Pemberian Obat Oral">
                                <label for="isi_tindakan_utama12">Pemberian Obat Oral</label>
                            </li>
                            <li>
                                <input type="checkbox" id="isi_tindakan_utama13" name="isi_tindakan_utama" value="Pemberian Nutrisi Enternal">
                                <label for="isi_tindakan_utama13">Pemberian Nutrisi Enternal</label>
                            </li>
                            <li>
                                <input type="checkbox" id="isi_tindakan_utama14" name="isi_tindakan_utama" value="Pemeriksaan Dalam (PD) Vagina">
                                <label for="isi_tindakan_utama14">Pemeriksaan Dalam (PD) Vagina</label>
                            </li>
                            <li>
                                <input type="checkbox" id="isi_tindakan_utama15" name="isi_tindakan_utama" value="Pemeriksaan Detak Jantung Janin">
                                <label for="isi_tindakan_utama15">Pemeriksaan Detak Jantung Janin</label>
                            </li>
                            <li>
                                <input type="checkbox" id="isi_tindakan_utama16" name="isi_tindakan_utama" value="Pemasangan CTG/EKG">
                                <label for="isi_tindakan_utama16">Pemasangan CTG/EKG</label>
                            </li>
                        </ol>
                    </div>
                </div> -->
                <div class="row mb-2">
                    <div class="col-md-4 mb-2">
                        I.1.Tindakan
                    </div>
                    <div class="col-md-8 mb-2">
                        <div class="row mb-2">
                            <div class="col-md-10 mb-2">
                                <input type="text" name="isi_tindakan[]" id="isi_tindakan" list="ReferensiTindakanList" placeholder="Tindakan" class="form-control">
                            </div>
                            <div class="col-md-2 mb-2">
                                <button type="button" id="tambahkan_form_tindakan" class="btn btn-sm btn-outline-dark btn-block" title="Tambah Form Tindakan">
                                    <i class="ti ti-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div id="MultiForm"></div>
                        <datalist id="ReferensiTindakanList">
                            <option value="Cateterisasi Vena (Pemasangan Infus)">
                            <option value="Pemasangan transfusi darah">
                            <option value="Pemasangan NGT">
                            <option value="Pemberian Suntikan (IV, Im, Ic)">
                            <option value="Pemasangan Cateterisasi Urine (Dower Cateter)">
                            <option value="Resusitasi Jantung Paru (RJP)">
                            <option value="Suction">
                            <option value="Hecting">
                            <option value="Pengambilan Sample Darah">
                            <option value="Perawatan Luka">
                            <option value="Pemasangan Oxygen">
                            <option value="Pemberian Obat Oral">
                            <option value="Pemberian Nutrisi Enternal">
                            <option value="Pemeriksaan Dalam (PD) Vagina">
                            <option value="Pemeriksaan Detak Jantung Janin">
                            <option value="Pemasangan CTG/EKG">
                        </datalist>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4 mb-2">
                        <label for="konsekuensi">I.2.Konsekuensi</label>
                    </div>
                    <div class="col-md-8 mb-2">
                        <textarea name="konsekuensi" id="konsekuensi" class="form-control"></textarea>
                        <small>Konsekuensi yang mungkin timbul setelah tindakan</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-4 mb-2">
                <dt>J. Persetujuan Tindakan</dt>
            </div>
            <div class="col-md-8 mb-2">
                <select name="persetujuan" id="persetujuan" class="form-control">
                    <option value="">Pilih</option>
                    <option value="Setuju">Setuju</option>
                    <option value="Menolak">Menolak</option>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12" id="NotifikasiTambahPersetujuanTindakan">
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
<script>
    $(document).ready(function(){
        var no =1;
        $('#tambahkan_form_tindakan').click(function(){
            no++;
            $('#MultiForm').append('<div class="row mb-3" id="row'+no+'"><div class="col-md-10 mb-2"><input type="text" class="form-control" id="isi_tindakan[]" name="isi_tindakan[]" list="ReferensiTindakanList" placeholder="Tindakan"></div><div class="col-md-2"><button type="button" class="btn btn-sm btn-danger btn-block hapus_form_tindakan" id="'+no+'"><i class="ti ti-close"></i></button></div>');
        });

        $(document).on('click', '.hapus_form_tindakan', function(){
            var button_id = $(this).attr("id"); 
            $('#row'+button_id+'').remove();
        });
    });
</script>