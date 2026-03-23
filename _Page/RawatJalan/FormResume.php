<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php"; 
    //Tangkap ID
    if(empty($_POST['id_kunjungan'])){
        echo '<span class="text-danger">Belum Ada Data Kunjungan Yang Dipilih</span>';
    }else{
        $id_kunjungan=$_POST['id_kunjungan'];
        //Buka ID Pasien
        $id_pasien=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'id_pasien');
        $sep=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'sep');
        //Mencari Nomor Identitas Pada Pengajuan Akses User
        $NikUser=getDataDetail($Conn,"akses_pengajuan",'email',$SessionEmail,'nik');
        //Mencari Nomor BPJS pada data pasien
        $no_bpjs=getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'no_bpjs');
        //Cek Apakah pasien sudah punya resume
        $id_resume=getDataDetail($Conn,"resume",'id_kunjungan',$id_kunjungan,'id_resume');
        //Membuka data resume
        $tanggal_entry=getDataDetail($Conn,"resume",'id_resume',$id_resume,'tanggal_entry');
        $tanggal_pulang=getDataDetail($Conn,"resume",'id_resume',$id_resume,'tanggal_pulang');
        $petugas=getDataDetail($Conn,"resume",'id_resume',$id_resume,'petugas');
        $dokter=getDataDetail($Conn,"resume",'id_resume',$id_resume,'dokter');
        $resume=getDataDetail($Conn,"resume",'id_resume',$id_resume,'resume');
        $pasca_pulang=getDataDetail($Conn,"resume",'id_resume',$id_resume,'pasca_pulang');
        $nasehat=getDataDetail($Conn,"resume",'id_resume',$id_resume,'nasehat');
        $evaluasi=getDataDetail($Conn,"resume",'id_resume',$id_resume,'evaluasi');
        $kondisi_keluar=getDataDetail($Conn,"resume",'id_resume',$id_resume,'kondisi_keluar');
        $cara_keluar=getDataDetail($Conn,"resume",'id_resume',$id_resume,'cara_keluar');
        $terapi_pulang=getDataDetail($Conn,"resume",'id_resume',$id_resume,'terapi_pulang');
        $rencana_kontrol=getDataDetail($Conn,"resume",'id_resume',$id_resume,'rencana_kontrol');
        $meninggal=getDataDetail($Conn,"resume",'id_resume',$id_resume,'meninggal');
        $pengaturan_lampiran=getDataDetail($Conn,"resume",'id_resume',$id_resume,'pengaturan_lampiran');
        //Buka Petugas
        if(!empty($petugas)){
            $JsonPetugas=json_decode($petugas, true);
            $NamaPetugas=$JsonPetugas['nama'];
            $KategoriPetugas=$JsonPetugas['kategori'];
            $KontakPetugas=$JsonPetugas['kontak'];
            $KategoriIdentitasPetugas=$JsonPetugas['kategori_identitas'];
            $NomorIdentitasPetugas=$JsonPetugas['no_identitas'];
        }else{
            $NamaPetugas="";
            $KategoriPetugas="";
            $KontakPetugas="";
            $KategoriIdentitasPetugas="";
            $NomorIdentitasPetugas="";
        }
        //Buka Dokter
        if(!empty($petugas)){
            $JsonDokter =json_decode($dokter, true);
            $NamaDokter=$JsonDokter['nama'];
            $SipDokter=$JsonDokter['SIP'];
            $KontakDokter=$JsonDokter['kontak'];
            $KategoriIdentitasDokter=$JsonDokter['kategori_identitas'];
            $NomorIdentitasDokter=$JsonDokter['no_identitas'];
        }else{
            $NamaDokter="";
            $SipDokter="";
            $KontakDokter="";
            $KategoriIdentitasDokter="";
            $NomorIdentitasDokter="";
        }
        //Rencana Kontrol
        if(!empty($rencana_kontrol)){
            $JsonRencanaKontrol =json_decode($rencana_kontrol, true);
            $NomorSuratRencanaKontrol=$JsonRencanaKontrol['no_surat'];
            $TanggalRencanaKontrol=$JsonRencanaKontrol['tanggal'];
            $NamaPoliRencanaKontrol=$JsonRencanaKontrol['nama_poli'];
            $NamaDokterRencanaKontrol=$JsonRencanaKontrol['nama_dokter'];
        }else{
            $NomorSuratRencanaKontrol="";
            $TanggalRencanaKontrol="";
            $NamaPoliRencanaKontrol="";
            $NamaDokterRencanaKontrol="";
        }
        //Meninggal
        if(!empty($meninggal)){
            $JsonMeninggal =json_decode($meninggal, true);
            $no_surat_meninggal=$JsonMeninggal['no_surat_meninggal'];
            $tanggal_meninggal=$JsonMeninggal['tanggal_meninggal'];
            $strtotime3=strtotime($tanggal_meninggal);
            $TanggalMeninggal=date('Y-m-d',$strtotime3);
            $JamMeninggal=date('H:i',$strtotime3);
        }else{
            $no_surat_meninggal="";
            $tanggal_meninggal="";
            $TanggalMeninggal="";
            $JamMeninggal="";
        }
        //Lampiran
        if(!empty($pengaturan_lampiran)){
            $JsonLampiran =json_decode($pengaturan_lampiran, true);
        }else{
            $JsonLampiran="";
        }
        //Format Tanggal
        $strtotime1=strtotime($tanggal_entry);
        $strtotime2=strtotime($tanggal_pulang);
        $TanggalEntry=date('Y-m-d',$strtotime1);
        $JamEntry=date('H:i',$strtotime1);
        $TanggalPulang=date('Y-m-d',$strtotime2);
        $JamPulang=date('H:i',$strtotime2);
?>  
    <form action="javascript:void(0);" id="ProsesUbahResume">
        <div class="row mb-3">
            <div class="col-md-12 sub-title">
                <dt>Informasi Resume</dt>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="id_pasien">No.RM</label>
            </div>
            <div class="col-md-9">
                <input type="text" readonly name="id_pasien" id="id_pasien" class="form-control" value="<?php echo "$id_pasien"; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="id_kunjungan">ID Kunjungan</label>
            </div>
            <div class="col-md-9">
                <input type="text" readonly name="id_kunjungan" id="id_kunjungan" class="form-control" value="<?php echo "$id_kunjungan"; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="tanggal_entry">Tanggal Entry</label>
            </div>
            <div class="col-md-5">
                <input type="date" name="tanggal_entry" id="tanggal_entry" class="form-control" value="<?php if(empty($tanggal_entry)){echo date('Y-m-d');}else{echo "$TanggalEntry";} ?>">
                <small>Tanggal Entry</small>
            </div>
            <div class="col-md-4">
                <input type="time" name="jam_entry" id="jam_entry" class="form-control" value="<?php if(empty($tanggal_entry)){echo date('H:i');}else{echo "$JamEntry";} ?>">
                <small>Jam Entry</small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="tanggal_pulang">Tanggal Pulang</label>
            </div>
            <div class="col-md-5">
                <input type="date" name="tanggal_pulang" id="tanggal_pulang" class="form-control" value="<?php if(empty($tanggal_pulang)){echo date('Y-m-d');}else{echo "$TanggalPulang";} ?>">
                <small>Tanggal Pulang</small>
            </div>
            <div class="col-md-4">
                <input type="time" name="jam_pulang" id="jam_pulang" class="form-control" value="<?php if(empty($tanggal_pulang)){echo date('H:i');}else{echo "$JamPulang";} ?>">
                <small>Jam Pulang</small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="resume">Status Resume (Cara Keluar)</label>
            </div>
            <div class="col-md-9">
                <select name="resume" id="resume" class="form-control">
                    <option <?php if($resume==""){echo "selected";} ?> value="">Pilih</option>
                    <option <?php if($resume=="Atas Persetujuan Dokter"){echo "selected";} ?> value="Atas Persetujuan Dokter">Atas Persetujuan Dokter</option>
                    <option <?php if($resume=="Dirujuk"){echo "selected";} ?> value="Dirujuk">Dirujuk</option>
                    <option <?php if($resume=="Atas Permintaan Sendiri"){echo "selected";} ?> value="Atas Permintaan Sendiri">Atas Permintaan Sendiri</option>
                    <option <?php if($resume=="Meninggal"){echo "selected";} ?> value="Meninggal">Meninggal</option>
                    <option <?php if($resume=="Lain-lain"){echo "selected";} ?> value="Lain-lain">Lain-lain</option>
                </select>
                <input type="checkbox" checked name="UpdateStatusKunjungan" id="UpdateStatusKunjungan" value="Ya">
                <label for="UpdateStatusKunjungan">Update Status Data Kunjungan</label> 
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="pasca_pulang">Pasca Pulang</label>
            </div>
            <div class="col-md-9">
                <select name="pasca_pulang" id="pasca_pulang" class="form-control">
                    <?php if($resume=="Meninggal"){ ?>
                        <option value="Meninggal">Meninggal</option>
                    <?php }else{ ?>
                        <option <?php if($pasca_pulang==""){echo "selected";} ?> value="">Pilih</option>
                        <option <?php if($pasca_pulang=="Sembuh"){echo "selected";} ?> value="Sembuh">Sembuh</option>
                        <option <?php if($pasca_pulang=="Belum Sembuh"){echo "selected";} ?> value="Belum Sembuh">Belum Sembuh</option>
                    <?php } ?>
                    
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12 sub-title">
                <dt>Pasien Meninggal</dt>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <span class="text-danger">*</span>Diisi hanya apabila pasien meninggal dunia.
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="no_surat_meninggal">Nomor Surat Meninggal</label><br>
            </div>
            <div class="col-md-9">
                <input type="text" <?php if($resume!=="Meninggal"){echo "disabled";} ?>  name="no_surat_meninggal" id="no_surat_meninggal" class="form-control" value="<?php echo "$no_surat_meninggal"; ?>">
                <input type="checkbox" <?php if($resume!=="Meninggal"){echo "disabled";} ?> name="UpdateStatusPasien" id="UpdateStatusPasien" value="Ya">
                <label for="UpdateStatusPasien">Update Status Data Pasien</label> 
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="waktu_meninggal">Tgl/Jam Meninggal</label><br>
            </div>
            <div class="col-md-5">
                <input type="date" <?php if($resume!=="Meninggal"){echo "disabled";} ?> name="tanggal_meninggal" id="tanggal_meninggal" class="form-control" value="<?php echo "$TanggalMeninggal"; ?>">
                <small>Tanggal</small>
            </div>
            <div class="col-md-4">
                <input type="time" <?php if($resume!=="Meninggal"){echo "disabled";} ?> name="jam_meninggal" id="jam_meninggal" class="form-control" value="<?php echo "$JamMeninggal"; ?>">
                <small>Jam</small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12 sub-title">
                <dt>Petugas Entry</dt>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="nama_petugas_entry">Petugas Entry</label>
            </div>
            <div class="col-md-9">
                <input type="text" name="nama_petugas_entry" id="nama_petugas_entry" class="form-control" value="<?php if(empty($NamaPetugas)){echo "$SessionNama";}else{echo "$NamaPetugas";} ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="kategori_petugas_entry">Kategori Petugas</label>
            </div>
            <div class="col-md-9">
                <input type="text" name="kategori_petugas_entry" id="kategori_petugas_entry" class="form-control" list="ListKategoriPetugas" value="<?php if(empty($KategoriPetugas)){echo "";}else{echo "$KategoriPetugas";} ?>">
                <datalist id="ListKategoriPetugas">
                    <option value="Perawat">
                    <option value="Bidan">
                    <option value="Rekam Medis">
                    <option value="Administrasi Keuangan">
                    <option value="Administrasi Ruangan">
                </datalist>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="kontak_petugas_entry">Nomor Kontak</label>
            </div>
            <div class="col-md-9">
                <input type="text" name="kontak_petugas_entry" id="kontak_petugas_entry" class="form-control" placeholder="+62" value="<?php if(empty($KontakPetugas)){echo "$SessionKontak";}else{echo "$KontakPetugas";} ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="identitas_petugas">Identitas</label>
            </div>
            <div class="col-md-5">
                <input type="text" name="kategori_identitas_petugas" id="kategori_identitas_petugas" class="form-control" list="KategoriIdentitas" value="<?php if(empty($KategoriIdentitasPetugas)){if(!empty($NikUser)){echo "NIK";}}else{echo $KategoriIdentitasPetugas;} ?>">
                <small>Kategori Identitas</small>
            </div>
            <div class="col-md-4">
                <input type="text" name="no_identitas_petugas" id="no_identitas_petugas" class="form-control" value="<?php if(empty($NomorIdentitasPetugas)){echo $NikUser;}else{echo $NomorIdentitasPetugas;} ?>">
                <small>Nomor Identitas</small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12 sub-title">
                <dt>
                    Dokter DPJP 
                    <a href="javascript:void(0);" class="badge badge-primary" data-toggle="modal" data-target="#ModalCariDokterResume" data-id="<?php echo "$id_kunjungan"; ?>">
                        Referensi Dokter <i class="ti ti-layers"></i>
                    </a>
                </dt>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="nama_dokter">Nama Dokter</label>
            </div>
            <div class="col-md-9">
                <input type="text" name="nama_dokter" id="nama_dokter" class="form-control" value="<?php echo "$NamaDokter"; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="sip_dokter">SIP</label>
            </div>
            <div class="col-md-9">
                <input type="text" name="sip_dokter" id="sip_dokter" class="form-control" value="<?php echo "$SipDokter"; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="kontak_dokter">Nomor Kontak</label>
            </div>
            <div class="col-md-9">
                <input type="text" name="kontak_dokter" id="kontak_dokter" class="form-control" placeholder="+62" value="<?php echo "$KontakDokter"; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="identitas_dokter">Identitas</label>
            </div>
            <div class="col-md-5">
                <input type="text" name="kategori_identitas_dokter" id="kategori_identitas_dokter" class="form-control" list="KategoriIdentitas" value="<?php echo "$KategoriIdentitasDokter"; ?>">
                <small>Kategori Identitas</small>
            </div>
            <div class="col-md-4">
                <input type="text" name="no_identitas_dokter" id="no_identitas_dokter" class="form-control" value="<?php echo "$NomorIdentitasDokter"; ?>">
                <small>Nomor Identitas</small>
            </div>
        </div>
        <div class="row mb-3 mt-4">
            <div class="col-md-12 sub-title">
                <dt>Evaluasi Kepulangan Dan Nasihat Dokter</dt>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="evaluasi">Evaluasi Kepulangan</label>
            </div>
            <div class="col-md-9">
                <div id="evaluasi"><?php echo "$evaluasi"; ?></div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="nasehat">Nasihat Dokter</label>
            </div>
            <div class="col-md-9">
                <div id="nasehat"><?php echo "$nasehat"; ?></div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="terapi_pulang">Terapi Pulang</label>
            </div>
            <div class="col-md-9">
                <div id="terapi_pulang"><?php echo "$terapi_pulang"; ?></div>
            </div>
        </div>
        <div class="row mb-3 mt-4">
            <div class="col-md-12 sub-title">
                <dt>
                    Rencana Kontrol
                    <a href="javascript:void(0);" class="badge badge-primary" data-toggle="modal" data-target="#ModalCariSuratKontrol" data-id="<?php echo "$no_bpjs"; ?>">
                        Referensi Surat Kontrol <i class="ti ti-layers"></i>
                    </a>
                </dt>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <span class="text-danger">*</span>Form berikut ini diisi apabila pasien direncanakan untuk melakukan kontrol dan sudah memiliki surat kontrol.
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="no_surat_kontrol">Nomor Surat</label><br>
            </div>
            <div class="col-md-9">
                <input type="text" name="no_surat_kontrol" id="no_surat_kontrol" class="form-control" value="<?php echo $NomorSuratRencanaKontrol;?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="tanggal_rencana_kontrol">Tanggal Rencana Kontrol</label>
            </div>
            <div class="col-md-9">
                <input type="date" name="tanggal_rencana_kontrol" id="tanggal_rencana_kontrol" class="form-control" value="<?php echo $TanggalRencanaKontrol;?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="nama_poli_kontrol">Poliklinik</label>
            </div>
            <div class="col-md-9">
                <input type="text" name="nama_poli_kontrol" id="nama_poli_kontrol" class="form-control" value="<?php echo $NamaPoliRencanaKontrol;?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="nama_dokter_kontrol">Dokter</label>
            </div>
            <div class="col-md-9">
                <input type="text" name="nama_dokter_kontrol" id="nama_dokter_kontrol" class="form-control" value="<?php echo $NamaDokterRencanaKontrol;?>">
            </div>
        </div>
        <div class="row mb-3 mt-4">
            <div class="col-md-12 sub-title">
                <dt>Ringkasan Lain Yang Perlu Ditampilkan</dt>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <ul>
                    <li>
                        <input type="checkbox" name="lampiran[]" id="lampiran1" value="Diagnosa" <?php if(!empty($JsonLampiran)){foreach($JsonLampiran as $Lampiran){if($Lampiran['lampiran']=="Diagnosa"){echo "checked";}}} ?>>
                        <label for="lampiran1">Diagnosa</label>
                    </li>
                    <li>
                        <input type="checkbox" name="lampiran[]" id="lampiran2" value="Operasi" <?php if(!empty($JsonLampiran)){foreach($JsonLampiran as $Lampiran){if($Lampiran['lampiran']=="Operasi"){echo "checked";}}} ?>>
                        <label for="lampiran2">Operasi</label>
                    </li>
                    <li>
                        <input type="checkbox" name="lampiran[]" id="lampiran3" value="pemeriksaan_fisik" <?php if(!empty($JsonLampiran)){foreach($JsonLampiran as $Lampiran){if($Lampiran['lampiran']=="pemeriksaan_fisik"){echo "checked";}}} ?>>
                        <label for="lampiran3">Pemeriksaan Fisik</label>
                    </li>
                    <li>
                        <input type="checkbox" name="lampiran[]" id="lampiran4" value="tanda_vital" <?php if(!empty($JsonLampiran)){foreach($JsonLampiran as $Lampiran){if($Lampiran['lampiran']=="tanda_vital"){echo "checked";}}} ?>>
                        <label for="lampiran4">Tanda Vital</label>
                    </li>
                    <li>
                        <input type="checkbox" name="lampiran[]" id="lampiran5" value="riwayat_tindakan" <?php if(!empty($JsonLampiran)){foreach($JsonLampiran as $Lampiran){if($Lampiran['lampiran']=="riwayat_tindakan"){echo "checked";}}} ?>>
                        <label for="lampiran5">Riwayat Tindakan</label>
                    </li>
                    <li>
                        <input type="checkbox" name="lampiran[]" id="lampiran6" value="riwayat_obat" <?php if(!empty($JsonLampiran)){foreach($JsonLampiran as $Lampiran){if($Lampiran['lampiran']=="riwayat_obat"){echo "checked";}}} ?>>
                        <label for="lampiran6">Riwayat Obat</label>
                    </li>
                    <li>
                        <input type="checkbox" name="lampiran[]" id="lampiran7" value="laboratorium" <?php if(!empty($JsonLampiran)){foreach($JsonLampiran as $Lampiran){if($Lampiran['lampiran']=="laboratorium"){echo "checked";}}} ?>>
                        <label for="lampiran7">Laboratorium</label>
                    </li>
                    <li>
                        <input type="checkbox" name="lampiran[]" id="lampiran8" value="radiologi" <?php if(!empty($JsonLampiran)){foreach($JsonLampiran as $Lampiran){if($Lampiran['lampiran']=="radiologi"){echo "checked";}}} ?>>
                        <label for="lampiran8">Radiologi</label>
                    </li>
                    <li>
                        <input type="checkbox" name="lampiran[]" id="lampiran9" value="konsultasi" <?php if(!empty($JsonLampiran)){foreach($JsonLampiran as $Lampiran){if($Lampiran['lampiran']=="konsultasi"){echo "checked";}}} ?>>
                        <label for="lampiran9">Konsultasi</label>
                    </li>
                </ul>
            </div>
        </div>
        <datalist id="KategoriIdentitas">
            <option value="KTP">
            <option value="SIM">
            <option value="KK">
            <option value="Passport">
        </datalist>
        <div class="row mb-3">
            <div class="col-md-12" id="NotifikasiResume">
                <span class="text-primary">Pastikan Informasi Edukasi Sudah Terisi Dengan Benar Dan Lengkap!</span>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <button type="submit" class="btn btn-md btn-primary mr-2">
                    <i class="ti ti-save"></i> Simpan
                </button>
                <button type="reset" class="btn btn-md btn-secondary">
                    <i class="ti ti-reload"></i> Reset
                </button>
            </div>
        </div>
    </form>
<?PHP } ?>
<script>
    //Apabila Resume Meninggal Maka Pasca Pulang Meninggal
    $('#resume').change(function(){
        var resume=$('#resume').val();
        if(resume=="Meninggal"){
            $('#pasca_pulang').html('<option value="Meninggal">Meninggal</option>');
            $("#no_surat_meninggal").attr("disabled", false);
            $("#UpdateStatusPasien").attr("disabled", false);
            $("#UpdateStatusPasien").attr("checked", true);
            $("#tanggal_meninggal").attr("disabled", false);
            $("#jam_meninggal").attr("disabled", false);
        }else{
            $('#pasca_pulang').html('<option value="">Pilih</option><option value="Sembuh">Sembuh</option><option value="Belum Sembuh">Belum Sembuh</option>');
            $("#no_surat_meninggal").attr("disabled", true);
            $("#UpdateStatusPasien").attr("disabled", true);
            $("#tanggal_meninggal").attr("disabled", true);
            $("#jam_meninggal").attr("disabled", true);
            //Kosongkan nilai
            $("#no_surat_meninggal").val('');
            $("#UpdateStatusPasien").attr("checked", false);
            $("#tanggal_meninggal").val('');
            $("#jam_meninggal").val('');
        }
    });
    //Proses Ubah Resume
    $('#ProsesUbahResume').submit(function(){
        var ProsesUbahResume = $('#ProsesUbahResume').serialize();
        var evaluasi =  $('#evaluasi').summernote('code');
        var nasehat =  $('#nasehat').summernote('code');
        var terapi_pulang =  $('#terapi_pulang').summernote('code');
        $('#NotifikasiResume').html("Loading...");
        $.ajax({
            type 	    :   'POST',
            url 	    :   '_Page/RawatJalan/ProsesUbahResume.php',
            data        :   {
                ProsesUbahResume, 
                evaluasi: evaluasi, 
                nasehat: nasehat, 
                terapi_pulang: terapi_pulang
            },
            success     :   function(data){
                $('#NotifikasiResume').html(data);
                var NotifikasiResumeBerhasil=$('#NotifikasiResumeBerhasil').html();
                if(NotifikasiResumeBerhasil=="Success"){
                    var GetIdKunjunganResume2=<?php echo "$id_kunjungan"; ?>;
                    $('#KontenResume').html("Loading...");
                    $.ajax({
                        type 	    : 'POST',
                        url 	    : '_Page/RawatJalan/PreviewResume.php',
                        data        : {id_kunjungan: GetIdKunjunganResume2},
                        success     : function(data){
                            $('#KontenResume').html(data);
                            $("#FormResume").removeClass("btn-dark");
                            $("#FormResume").addClass("btn-outline-dark");
                            $("#DetailResume").removeClass("btn-outline-dark");
                            $("#DetailResume").addClass("btn-dark");
                        }
                    });
                    //Tampilkan Swal
                    Swal.fire({
                        title: 'Good Job!',
                        text: 'Buat Resume Berhasil',
                        icon: 'success',
                        confirmButtonText: 'Tutup'
                    })
                }
            }
        });
    });
</script>