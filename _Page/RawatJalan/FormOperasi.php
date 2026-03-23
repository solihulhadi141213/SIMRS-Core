<?php
    //Membuka Data Operasi
    $id_operasi=getDataDetail($Conn,"operasi",'id_kunjungan',$id_kunjungan,'id_operasi');
    if(!empty($id_operasi)){
        $id_jadwal_operasi=getDataDetail($Conn,"operasi",'id_operasi',$id_operasi,'id_jadwal_operasi');
        $id_pasien=getDataDetail($Conn,"operasi",'id_operasi',$id_operasi,'id_pasien');
        $tanggal_entry=getDataDetail($Conn,"operasi",'id_operasi',$id_operasi,'tanggal_entry');
        $tanggal_mulai=getDataDetail($Conn,"operasi",'id_operasi',$id_operasi,'tanggal_mulai');
        $tanggal_selesai=getDataDetail($Conn,"operasi",'id_operasi',$id_operasi,'tanggal_selesai');
        $petugas_entry=getDataDetail($Conn,"operasi",'id_operasi',$id_operasi,'petugas_entry');
        $pelaksana=getDataDetail($Conn,"operasi",'id_operasi',$id_operasi,'pelaksana');
        $diagnosa_operasi=getDataDetail($Conn,"operasi",'id_operasi',$id_operasi,'diagnosa_operasi');
        $body_site=getDataDetail($Conn,"operasi",'id_operasi',$id_operasi,'body_site');
        $tindakan_operasi=getDataDetail($Conn,"operasi",'id_operasi',$id_operasi,'tindakan_operasi');
        $instrumen=getDataDetail($Conn,"operasi",'id_operasi',$id_operasi,'instrumen');
        $keterangan_dokter=getDataDetail($Conn,"operasi",'id_operasi',$id_operasi,'keterangan_dokter');
        $anastesi=getDataDetail($Conn,"operasi",'id_operasi',$id_operasi,'anastesi');
        $persetujuan=getDataDetail($Conn,"operasi",'id_operasi',$id_operasi,'persetujuan');
        //Nama
        $nama_pasien=getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'nama');
        //Json Dekrip
        //Format Tanggal
        $strtotime1=strtotime($tanggal_entry);
        $strtotime2=strtotime($tanggal_mulai);
        $strtotime3=strtotime($tanggal_selesai);
        $TanggalEntry=date('Y-m-d',$strtotime1);
        $JamEntry=date('H:i',$strtotime1);
        $TanggalMulai=date('Y-m-d',$strtotime2);
        $JamMulai=date('H:i',$strtotime2);
        $TanggalSelesai=date('Y-m-d',$strtotime3);
        $JamSelesai=date('H:i',$strtotime3);
        //Anastesi
        if(!empty($anastesi)){
            $JsonAnastesi =json_decode($anastesi, true);
            $durasi=$JsonAnastesi['durasi'];
            $diagnosis_kerja=$JsonAnastesi['diagnosis_kerja'];
            $diagnosis_banding=$JsonAnastesi['diagnosis_banding'];
            $tindakan=$JsonAnastesi['tindakan'];
            $tata_cara=$JsonAnastesi['tata_cara'];
            $tujuan=$JsonAnastesi['tujuan'];
            $resiko=$JsonAnastesi['resiko'];
            $komplikasi=$JsonAnastesi['komplikasi'];
            $prognosis=$JsonAnastesi['prognosis'];
            $alternatif=$JsonAnastesi['alternatif'];
            $lainnya=$JsonAnastesi['lainnya'];
        }else{
            $durasi="";
            $diagnosis_kerja="";
            $diagnosis_banding="";
            $tindakan="";
            $tata_cara="";
            $tujuan="";
            $resiko="";
            $komplikasi="";
            $prognosis="";
            $alternatif="";
            $lainnya="";
        }
        //Persetujuan
        if(!empty($persetujuan)){
            $JsonPersetujuan =json_decode($persetujuan, true);
            $HubunganKeluarga=$JsonPersetujuan['hubungan'];
            $NamaPenanggungjawab=$JsonPersetujuan['nama'];
            $KontakPenanggungjawab=$JsonPersetujuan['kontak'];
            $KategoriIdentitasPenanggungjawab=$JsonPersetujuan['kategori_identitas'];
            $NomorIdentitasPenanggungjawab=$JsonPersetujuan['nomor_identitas'];
            $TtdPenanggungjawab=$JsonPersetujuan['ttd'];
        }else{
            $HubunganKeluarga="";
            $NamaPenanggungjawab="";
            $KontakPenanggungjawab="";
            $KategoriIdentitasPenanggungjawab="";
            $NomorIdentitasPenanggungjawab="";
            $TtdPenanggungjawab="";
        }
    }else{
        $id_jadwal_operasi="";
        $id_pasien=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'id_pasien');
        $petugas_entry=$SessionNama;
        $nama_pasien=getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'nama');
        $TanggalEntry=date('Y-m-d');
        $JamEntry=date('H:i');
        $TanggalMulai=date('Y-m-d');
        $JamMulai=date('H:i');
        $TanggalSelesai=date('Y-m-d');
        $JamSelesai=date('H:i');
        //Anastesi
        $durasi="";
        $diagnosis_kerja="";
        $diagnosis_banding="";
        $tindakan="";
        $tata_cara="";
        $tujuan="";
        $resiko="";
        $komplikasi="";
        $prognosis="";
        $alternatif="";
        $lainnya="";
        //Persetujuan
        $HubunganKeluarga="";
        $NamaPenanggungjawab="";
        $KontakPenanggungjawab="";
        $KategoriIdentitasPenanggungjawab="";
        $NomorIdentitasPenanggungjawab="";
        $TtdPenanggungjawab="";
        //Lainnya
        $pelaksana="";
        $diagnosa_operasi="";
        $body_site="";
        $tindakan_operasi="";
        $instrumen="";
        $keterangan_dokter="";
    }
        
?>  
<form action="javascript:void(0);" id="ProsesTambahStatusOperasi">
    <div class="row mb-3">
        <div class="col-md-12 sub-title">
            <dt>Informasi Umum</dt>
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
            <label for="id_jadwal_operasi">
                ID Jadwal Operasi <br>
                <a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalCariJadwalOperasi" data-id="<?php echo "$id_pasien"; ?>">
                    <small><i class="ti ti-search"></i> Jadwal Operasi</small>
                </a>
            </label>
        </div>
        <div class="col-md-9">
            <input type="text" name="id_jadwal_operasi" id="id_jadwal_operasi" class="form-control" value="<?php echo "$id_jadwal_operasi"; ?>">
            <small>Setidaknya tindakan operasi sudah melalui penjadwalan sebelumnya</small>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-3">
            <label for="tanggal_entry">Tanggal Entry</label>
        </div>
        <div class="col-md-5">
            <input type="date" name="tanggal_entry" id="tanggal_entry" class="form-control" value="<?php echo "$TanggalEntry"; ?>">
            <small>Tanggal Entry</small>
        </div>
        <div class="col-md-4">
            <input type="time" name="jam_entry" id="jam_entry" class="form-control" value="<?php echo "$JamEntry"; ?>">
            <small>Jam Entry</small>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-3">
            <label for="tanggal_mulai">Tanggal Mulai</label>
        </div>
        <div class="col-md-5">
            <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control" value="<?php echo "$TanggalMulai"; ?>">
            <small>Tanggal Mulai Pelaksanaan</small>
        </div>
        <div class="col-md-4">
            <input type="time" name="jam_mulai" id="jam_mulai" class="form-control" value="<?php echo "$JamMulai"; ?>">
            <small>Jam Mulai Pelaksanaan</small>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-3">
            <label for="tanggal_selesai">Tanggal Selesai</label>
        </div>
        <div class="col-md-5">
            <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control" value="<?php echo "$TanggalSelesai"; ?>">
            <small>Tanggal Selesai Pelaksanaan</small>
        </div>
        <div class="col-md-4">
            <input type="time" name="jam_selesai" id="jam_selesai" class="form-control" value="<?php echo "$JamSelesai"; ?>">
            <small>Jam Selesai Pelaksanaan</small>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-3">
            <label for="petugas_entry">Petugas Entry</label>
        </div>
        <div class="col-md-9">
            <input type="text" name="petugas_entry" id="petugas_entry" class="form-control" value="<?php echo "$petugas_entry"; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12 sub-title">
            <dt>Anastesi</dt>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-3">
            <label for="durasi_anastesi">Durasi</label>
        </div>
        <div class="col-md-9">
            <input type="text" name="durasi_anastesi" id="durasi_anastesi" class="form-control" value="<?php echo "$durasi"; ?>">
            <small>Lamanya anastesi berlangsung</small>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-3">
            <label for="diagnosis_kerja_operasi">Diagnosa Kerja</label>
        </div>
        <div class="col-md-9">
            <input type="text" name="diagnosis_kerja_operasi" id="diagnosis_kerja_operasi" class="form-control" value="<?php echo "$diagnosis_kerja"; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-3">
            <label for="diagnosis_banding_operasi">Diagnosa Banding</label>
        </div>
        <div class="col-md-9">
            <input type="text" name="diagnosis_banding_operasi" id="diagnosis_banding_operasi" class="form-control" value="<?php echo "$diagnosis_banding"; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-3">
            <label for="tindakan_anastesi">Tindakan</label>
        </div>
        <div class="col-md-4">
            <ul>
                <li>
                    <input type="checkbox" <?php if(!empty($tindakan)){foreach($tindakan as $ListTindakan){if($ListTindakan['tindakan_anastesi']=="Anastesi Umum"){echo "checked";}}} ?> name="tindakan_anastesi[]" id="tindakan_anastesi1" value="Anastesi Umum">
                    <label for="tindakan_anastesi1">Anastesi Umum</label>
                </li>
                <li>
                    <input type="checkbox" <?php if(!empty($tindakan)){foreach($tindakan as $ListTindakan){if($ListTindakan['tindakan_anastesi']=="Sedasi"){echo "checked";}}} ?> name="tindakan_anastesi[]" id="tindakan_anastesi2" value="Sedasi">
                    <label for="tindakan_anastesi2">Sedasi</label>
                </li>
                <li>
                    <input type="checkbox" <?php if(!empty($tindakan)){foreach($tindakan as $ListTindakan){if($ListTindakan['tindakan_anastesi']=="Anastesi Spinal"){echo "checked";}}} ?> name="tindakan_anastesi[]" id="tindakan_anastesi3" value="Anastesi Spinal">
                    <label for="tindakan_anastesi3">Anastesi Spinal</label>
                </li>
                <li>
                    <input type="checkbox" <?php if(!empty($tindakan)){foreach($tindakan as $ListTindakan){if($ListTindakan['tindakan_anastesi']=="Anastesi Spidural"){echo "checked";}}} ?> name="tindakan_anastesi[]" id="tindakan_anastesi4" value="Anastesi Spidural">
                    <label for="tindakan_anastesi4">Anastesi Spidural</label>
                </li>
            </ul>
        </div>
        <div class="col-md-5">
            <ul>
                <li>
                    <input type="checkbox" <?php if(!empty($tindakan)){foreach($tindakan as $ListTindakan){if($ListTindakan['tindakan_anastesi']=="Kombinasi Spinal & Epidural"){echo "checked";}}} ?> name="tindakan_anastesi[]" id="tindakan_anastesi5" value="Kombinasi Spinal & Epidural">
                    <label for="tindakan_anastesi5">Kombinasi Spinal & Epidural</label>
                </li>
                <li>
                    <input type="checkbox" <?php if(!empty($tindakan)){foreach($tindakan as $ListTindakan){if($ListTindakan['tindakan_anastesi']=="Anastesi Kaudal"){echo "checked";}}} ?> name="tindakan_anastesi[]" id="tindakan_anastesi6" value="Anastesi Kaudal">
                    <label for="tindakan_anastesi6">Anastesi Kaudal</label>
                </li>
                <li>
                    <input type="checkbox" <?php if(!empty($tindakan)){foreach($tindakan as $ListTindakan){if($ListTindakan['tindakan_anastesi']=="Blok Saraf Perifer"){echo "checked";}}} ?> name="tindakan_anastesi[]" id="tindakan_anastesi7" value="Blok Saraf Perifer">
                    <label for="tindakan_anastesi7">Blok Saraf Perifer</label>
                </li>
                <li>
                    <input type="checkbox" <?php if(!empty($tindakan)){foreach($tindakan as $ListTindakan){if($ListTindakan['tindakan_anastesi']=="Anastesi Lokal"){echo "checked";}}} ?> name="tindakan_anastesi[]" id="tindakan_anastesi8" value="Anastesi Lokal">
                    <label for="tindakan_anastesi8">Anastesi Lokal</label>
                </li>
            </ul>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-3">
            <label for="tata_cara">Tata Cara</label>
        </div>
        <div class="col-md-9">
            <ul>
                <li>
                    <input type="checkbox" <?php if(!empty($tata_cara)){foreach($tata_cara as $ListTataCara){if($ListTataCara['tata_cara']=="1"){echo "checked";}}} ?> name="tata_cara[]" id="tata_cara1" value="1">
                    <label for="tata_cara1">
                        Obat disuntikan ke pembuluh darah, dihirup melalui paru-paru, atau dengan cara lain dan dilakukan pemasangan alat bantu nafas.
                    </label>
                </li>
                <li>
                    <input type="checkbox" <?php if(!empty($tata_cara)){foreach($tata_cara as $ListTataCara){if($ListTataCara['tata_cara']=="2"){echo "checked";}}} ?> name="tata_cara[]" id="tata_cara2" value="2">
                    <label for="tata_cara2">
                        Obat disuntikan melalui jarum atau kateter yang ditempatkan ke dalam rongga sumsum tulang belakang atau rongga didekatnya.
                    </label>
                </li>
                <li>
                    <input type="checkbox" <?php if(!empty($tata_cara)){foreach($tata_cara as $ListTataCara){if($ListTataCara['tata_cara']=="3"){echo "checked";}}} ?> name="tata_cara[]" id="tata_cara3" value="3">
                    <label for="tata_cara3">
                        Obat disuntikan ke jaringan sekitar saraf melalui kulit.
                    </label>
                </li>
            </ul>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-3">
            <label for="tujuan_anastesi">Tujuan Anastesi</label>
        </div>
        <div class="col-md-9">
            <ul>
                <li>
                    <input type="checkbox" <?php if(!empty($tujuan)){foreach($tujuan as $ListTujuan){if($ListTujuan['tujuan_anastesi']=="1"){echo "checked";}}} ?> name="tujuan_anastesi[]" id="tujuan_anastesi1" value="1">
                    <label for="tujuan_anastesi1">
                        Menghilangkan kesadaran selama tindakan pembedahan.
                    </label>
                </li>
                <li>
                    <input type="checkbox" <?php if(!empty($tujuan)){foreach($tujuan as $ListTujuan){if($ListTujuan['tujuan_anastesi']=="2"){echo "checked";}}} ?> name="tujuan_anastesi[]" id="tujuan_anastes2" value="2">
                    <label for="tujuan_anastes2">
                        Menghilangkan rasa nyeri selama tindakan pembedahan.
                    </label>
                </li>
                <li>
                    <input type="checkbox" <?php if(!empty($tujuan)){foreach($tujuan as $ListTujuan){if($ListTujuan['tujuan_anastesi']=="3"){echo "checked";}}} ?> name="tujuan_anastesi[]" id="tujuan_anastes3" value="3">
                    <label for="tujuan_anastes3">
                        Memberikan efek mati rasa sementara di daerah perut sampai ujung kaki.
                    </label>
                </li>
                <li>
                    <input type="checkbox" <?php if(!empty($tujuan)){foreach($tujuan as $ListTujuan){if($ListTujuan['tujuan_anastesi']=="4"){echo "checked";}}} ?> name="tujuan_anastesi[]" id="tujuan_anastes4" value="4">
                    <label for="tujuan_anastes4">
                        Memberikan efek mati rasa di sekitar daerah operasi
                    </label>
                </li>
                <li>
                    <input type="checkbox" <?php if(!empty($tujuan)){foreach($tujuan as $ListTujuan){if($ListTujuan['tujuan_anastesi']=="5"){echo "checked";}}} ?> name="tujuan_anastesi[]" id="tujuan_anastes5" value="5">
                    <label for="tujuan_anastes5">
                        Mengurangi kecemasan
                    </label>
                </li>
            </ul>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-3">
            <label for="resiko_tindakan">Resiko Tindakan</label>
        </div>
        <div class="col-md-4">
            <ul>
                <li><input type="checkbox" <?php if(!empty($resiko)){foreach($resiko as $ListResiko){if($ListResiko['resiko_tindakan']=="1"){echo "checked";}}} ?> name="resiko_tindakan[]" id="resiko_tindakan1" value="1"> <label for="resiko_tindakan1">Nyeri tenggorokan</label></li>
                <li><input type="checkbox" <?php if(!empty($resiko)){foreach($resiko as $ListResiko){if($ListResiko['resiko_tindakan']=="2"){echo "checked";}}} ?> name="resiko_tindakan[]" id="resiko_tindakan2" value="2"> <label for="resiko_tindakan2">Suara serak/batuk</label></li>
                <li><input type="checkbox" <?php if(!empty($resiko)){foreach($resiko as $ListResiko){if($ListResiko['resiko_tindakan']=="3"){echo "checked";}}} ?> name="resiko_tindakan[]" id="resiko_tindakan3" value="3"> <label for="resiko_tindakan3">Mual-mual</label></li>
                <li><input type="checkbox" <?php if(!empty($resiko)){foreach($resiko as $ListResiko){if($ListResiko['resiko_tindakan']=="4"){echo "checked";}}} ?> name="resiko_tindakan[]" id="resiko_tindakan4" value="4"> <label for="resiko_tindakan4">Aspirasi</label></li>
                <li><input type="checkbox" <?php if(!empty($resiko)){foreach($resiko as $ListResiko){if($ListResiko['resiko_tindakan']=="5"){echo "checked";}}} ?> name="resiko_tindakan[]" id="resiko_tindakan5" value="5"> <label for="resiko_tindakan5">Sumbatan Jalan Nafas</label></li>
                <li><input type="checkbox" <?php if(!empty($resiko)){foreach($resiko as $ListResiko){if($ListResiko['resiko_tindakan']=="6"){echo "checked";}}} ?> name="resiko_tindakan[]" id="resiko_tindakan6" value="6"> <label for="resiko_tindakan6">Trauma pada mulut, daerah mata dan gigi</label></li>
                <li><input type="checkbox" <?php if(!empty($resiko)){foreach($resiko as $ListResiko){if($ListResiko['resiko_tindakan']=="7"){echo "checked";}}} ?> name="resiko_tindakan[]" id="resiko_tindakan7" value="7"> <label for="resiko_tindakan7">Obat bius masuk ke alirah darah janin</label></li>
            </ul>
        </div>
        <div class="col-md-5">
            <ul>
                <li><input type="checkbox" <?php if(!empty($resiko)){foreach($resiko as $ListResiko){if($ListResiko['resiko_tindakan']=="8"){echo "checked";}}} ?> name="resiko_tindakan[]" id="resiko_tindakan8" value="8"> <label for="resiko_tindakan8">Gangguan pernafasan ringan sampe berat dan reaksi alergi</label></li>
                <li><input type="checkbox" <?php if(!empty($resiko)){foreach($resiko as $ListResiko){if($ListResiko['resiko_tindakan']=="9"){echo "checked";}}} ?> name="resiko_tindakan[]" id="resiko_tindakan9" value="9"> <label for="resiko_tindakan9">Infeksi</label></li>
                <li><input type="checkbox" <?php if(!empty($resiko)){foreach($resiko as $ListResiko){if($ListResiko['resiko_tindakan']=="10"){echo "checked";}}} ?> name="resiko_tindakan[]" id="resiko_tindakan10" value="10"> <label for="resiko_tindakan10">Kejang jalan nafas</label></li>
                <li><input type="checkbox" <?php if(!empty($resiko)){foreach($resiko as $ListResiko){if($ListResiko['resiko_tindakan']=="11"){echo "checked";}}} ?> name="resiko_tindakan[]" id="resiko_tindakan11" value="11"> <label for="resiko_tindakan11">Hematoma</label></li>
                <li><input type="checkbox" <?php if(!empty($resiko)){foreach($resiko as $ListResiko){if($ListResiko['resiko_tindakan']=="12"){echo "checked";}}} ?> name="resiko_tindakan[]" id="resiko_tindakan12" value="12"> <label for="resiko_tindakan12">Penurunan tekanan darah</label></li>
                <li><input type="checkbox" <?php if(!empty($resiko)){foreach($resiko as $ListResiko){if($ListResiko['resiko_tindakan']=="13"){echo "checked";}}} ?> name="resiko_tindakan[]" id="resiko_tindakan13" value="13"> <label for="resiko_tindakan13">Peningkatan tekanan darah</label></li>
                <li><input type="checkbox" <?php if(!empty($resiko)){foreach($resiko as $ListResiko){if($ListResiko['resiko_tindakan']=="14"){echo "checked";}}} ?> name="resiko_tindakan[]" id="resiko_tindakan14" value="14"> <label for="resiko_tindakan14">Nyeri ditempat suntikan</label></li>
            </ul>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-3">
            <label for="komplikasi">Komplikasi</label>
        </div>
        <div class="col-md-4">
            <ul>
                <li><input type="checkbox" <?php if(!empty($komplikasi)){foreach($komplikasi as $ListKomplikasi){if($ListKomplikasi['komplikasi']=="1"){echo "checked";}}} ?> name="komplikasi[]" id="komplikasi1" value="1"> <label for="komplikasi1">Pemulihan lama</label></li>
                <li><input type="checkbox" <?php if(!empty($komplikasi)){foreach($komplikasi as $ListKomplikasi){if($ListKomplikasi['komplikasi']=="2"){echo "checked";}}} ?> name="komplikasi[]" id="komplikasi2" value="2"> <label for="komplikasi2">Kelumpuhan/baal memanjang</label></li>
                <li><input type="checkbox" <?php if(!empty($komplikasi)){foreach($komplikasi as $ListKomplikasi){if($ListKomplikasi['komplikasi']=="3"){echo "checked";}}} ?> name="komplikasi[]" id="komplikasi3" value="3"> <label for="komplikasi3">Sakit pinggang, sakit kepala</label></li>
                <li><input type="checkbox" <?php if(!empty($komplikasi)){foreach($komplikasi as $ListKomplikasi){if($ListKomplikasi['komplikasi']=="4"){echo "checked";}}} ?> name="komplikasi[]" id="komplikasi4" value="4"> <label for="komplikasi4">Mengigigl</label></li>
                <li><input type="checkbox" <?php if(!empty($komplikasi)){foreach($komplikasi as $ListKomplikasi){if($ListKomplikasi['komplikasi']=="5"){echo "checked";}}} ?> name="komplikasi[]" id="komplikasi5" value="5"> <label for="komplikasi5">Kerusakan syaraf</label></li>
            </ul>
        </div>
        <div class="col-md-5">
            <ul>
                <li><input type="checkbox" <?php if(!empty($komplikasi)){foreach($komplikasi as $ListKomplikasi){if($ListKomplikasi['komplikasi']=="6"){echo "checked";}}} ?> name="komplikasi[]" id="komplikasi6" value="6"> <label for="komplikasi6">Infeksi saluran nafas berat-ringan</label></li>
                <li><input type="checkbox" <?php if(!empty($komplikasi)){foreach($komplikasi as $ListKomplikasi){if($ListKomplikasi['komplikasi']=="7"){echo "checked";}}} ?> name="komplikasi[]" id="komplikasi7" value="7"> <label for="komplikasi7">Gangguan irama jantung</label></li>
                <li><input type="checkbox" <?php if(!empty($komplikasi)){foreach($komplikasi as $ListKomplikasi){if($ListKomplikasi['komplikasi']=="8"){echo "checked";}}} ?> name="komplikasi[]" id="komplikasi8" value="8"> <label for="komplikasi8">Gagal Jantung</label></li>
                <li><input type="checkbox" <?php if(!empty($komplikasi)){foreach($komplikasi as $ListKomplikasi){if($ListKomplikasi['komplikasi']=="9"){echo "checked";}}} ?> name="komplikasi[]" id="komplikasi9" value="9"> <label for="komplikasi9">Abses</label></li>
                <li><input type="checkbox" <?php if(!empty($komplikasi)){foreach($komplikasi as $ListKomplikasi){if($ListKomplikasi['komplikasi']=="10"){echo "checked";}}} ?> name="komplikasi[]" id="komplikasi10" value="10"> <label for="komplikasi10">Kejang</label></li>
            </ul>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-3">
            <label for="prognosis">Prognosis</label>
        </div>
        <div class="col-md-9">
            <input type="text" name="prognosis" id="prognosis" class="form-control" value="<?php echo "$prognosis"; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-3">
            <label for="alternatif">Alternatif Dan Resiko</label>
        </div>
        <div class="col-md-9">
            <input type="text" name="alternatif" id="alternatif" class="form-control" value="<?php echo "$alternatif"; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-3">
            <label for="lain_lain">Lain-lain</label>
        </div>
        <div class="col-md-9">
            <input type="text" name="lain_lain" id="lain_lain" class="form-control" value="<?php echo "$lainnya"; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12 sub-title">
            <dt>Persetujuan Operasi</dt>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-3">
            <label for="nama_persetujuan">Nama Sesuai Identitas</label>
        </div>
        <div class="col-md-9">
            <input type="text" name="nama_persetujuan" id="nama_persetujuan" class="form-control" value="<?php echo "$NamaPenanggungjawab"; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-3">
            <label for="hubungan_dengan_pasien">Hubungan Dengan Pasien</label>
        </div>
        <div class="col-md-9">
            <input type="text" name="hubungan_dengan_pasien" id="hubungan_dengan_pasien" class="form-control" value="<?php echo "$HubunganKeluarga"; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-3">
            <label for="kontak_persetujuan">Kontak</label>
        </div>
        <div class="col-md-9">
            <input type="text" name="kontak_persetujuan" id="kontak_persetujuan" class="form-control" value="<?php echo "$KontakPenanggungjawab"; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-3">
            <label for="kategori_identitas_persetujuan">Kategori Identitas</label>
        </div>
        <div class="col-md-9">
            <input type="text" name="kategori_identitas_persetujuan" id="kategori_identitas_persetujuan" class="form-control" value="<?php echo "$KategoriIdentitasPenanggungjawab"; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-3">
            <label for="nomor_identitas_persetujuan">Nomor Identitas</label>
        </div>
        <div class="col-md-9">
            <input type="text" name="nomor_identitas_persetujuan" id="nomor_identitas_persetujuan" class="form-control" value="<?php echo "$NomorIdentitasPenanggungjawab"; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12 sub-title">
            <dt>Uraian Operasi</dt>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 mb-3">
            <ol class="list-group text-left" id="FormListNakesOperasi">
                <li class="list-group-item d-flex justify-content-between align-items-start text-center">
                    Tenaga Kesehatan
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <a href="javascript:void(0);" class="btn btn-sm btn-primary btn-round btn-block mb-2" data-toggle="modal" data-target="#ModalTambahNakesOperasi" data-id="<?php echo "$id_kunjungan"; ?>">
                        <i class="ti ti-plus"></i> Tambah
                    </a>
                </li>
                <?php
                    if(!empty($pelaksana)){
                        $pelaksana =json_decode($pelaksana, true);
                        foreach($pelaksana as $ListPelaksanaOperasi){
                            $id_nakes_operasi=$ListPelaksanaOperasi['id_nakes_operasi'];
                            $kategori=$ListPelaksanaOperasi['kategori'];
                            $nama=$ListPelaksanaOperasi['nama'];
                            $sip=$ListPelaksanaOperasi['sip'];
                            $kontak=$ListPelaksanaOperasi['kontak'];
                            $kategori_identitas=$ListPelaksanaOperasi['kategori_identitas'];
                            $nomor_identitas=$ListPelaksanaOperasi['nomor_identitas'];
                            $ttd=$ListPelaksanaOperasi['ttd'];
                            echo '<li class="list-group-item d-flex justify-content-between align-items-start" id="BarisNakesOperasi'.$id_nakes_operasi.'">';
                            echo '  <div class="ms-2 me-auto">';
                            echo '      <input type="hidden" id="KategoriNakesOperasi'.$id_nakes_operasi.'" name="KategoriNakesOperasi[]" value="'.$kategori.'">';
                            echo '      <input type="hidden" id="NamaNakesOperasi'.$id_nakes_operasi.'" name="NamaNakesOperasi[]" value="'.$nama.'">';
                            echo '      <input type="hidden" id="SipNakesOperasi'.$id_nakes_operasi.'" name="SipNakesOperasi[]" value="'.$sip.'">';
                            echo '      <input type="hidden" id="KontakNakesOperasi'.$id_nakes_operasi.'" name="KontakNakesOperasi[]" value="'.$kontak.'">';
                            echo '      <input type="hidden" id="KategoriIdentitasNakesOperasi'.$id_nakes_operasi.'" name="KategoriIdentitasNakesOperasi[]" value="'.$kategori_identitas.'">';
                            echo '      <input type="hidden" id="NomorIdentitasNakesOperasi'.$id_nakes_operasi.'" name="NomorIdentitasNakesOperasi[]" value="'.$nomor_identitas.'">';
                            echo '      <dt class="fw-bold">'.$kategori.'</dt>';
                            echo '      <small>';
                            echo '          <ul>';
                            echo '              <li>'.$nama.'</li>';
                            echo '              <li>SIP: <code class="text-secondary">'.$sip.'</code></li>';
                            echo '              <li>Kontak: <code class="text-secondary">'.$kontak.'</code></li>';
                            echo '              <li>Identitas: <code class="text-secondary">('.$kategori_identitas.') '.$nomor_identitas.'</code></li>';
                            echo '          </ul>';
                            echo '      </small>';
                            echo '  </div>';
                            echo '  <span class="icon-btn">';
                            echo '      <button type="button" class="btn btn-icon btn-outline-danger" data-toggle="modal" data-target="#ModalHapusNakesOperasi" data-id="'.$id_nakes_operasi.'">';
                            echo '          <i class="ti ti-close"></i>';
                            echo '      </button>';
                            echo '  </span>';
                            echo '</li>';
                        }
                    }
                ?>
            </ol>
        </div>
        <div class="col-md-4 mb-3">
            <ol class="list-group text-left" id="FormListDiagnosaOperasi">
                <li class="list-group-item d-flex justify-content-between align-items-start text-center">
                    Diagnosa Operasi
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <a href="javascript:void(0);" class="btn btn-sm btn-primary btn-round btn-block mb-2" data-toggle="modal" data-target="#ModalTambahDiagnosaOperasi">
                        <i class="ti ti-plus"></i> Tambah
                    </a>
                </li>
                <?php
                    if(!empty($diagnosa_operasi)){
                        $diagnosa_operasi =json_decode($diagnosa_operasi, true);
                        $no=1;
                        foreach($diagnosa_operasi as $ListDiagnosaOperasi){
                            $kategori=$ListDiagnosaOperasi['kategori'];
                            $kode=$ListDiagnosaOperasi['kode'];
                            $deskripsi=$ListDiagnosaOperasi['deskripsi'];
                            echo '<li class="list-group-item d-flex justify-content-between align-items-start" id="BarisDiagnosaOperasi'.$no.'">';
                            echo '  <div class="ms-2 me-auto">';
                            echo '      <input type="hidden" id="KategoriDiagnosaOperasi'.$no.'" name="KategoriDiagnosaOperasi[]" value="'.$kategori.'">';
                            echo '      <input type="hidden" id="KodeDiagnosaOperasi'.$no.'" name="KodeDiagnosaOperasi[]" value="'.$kode.'">';
                            echo '      <input type="hidden" id="NamaDiagnosaOperasi'.$no.'" name="NamaDiagnosaOperasi[]" value="'.$deskripsi.'">';
                            echo '      <dt class="fw-bold">'.$kategori.'</dt>';
                            echo '      '.$kode.'';
                            echo '      <small>';
                            echo '          <ul>';
                            echo '              <li>'.$deskripsi.'</li>';
                            echo '          </ul>';
                            echo '      </small>';
                            echo '  </div>';
                            echo '  <span class="icon-btn">';
                            echo '      <button type="button" class="btn btn-icon btn-outline-danger" data-toggle="modal" data-target="#ModalHapusDiagnosaOperasi" data-id="'.$no.'">';
                            echo '          <i class="ti ti-close"></i>';
                            echo '      </button>';
                            echo '  </span>';
                            echo '</li>';
                            $no++;
                        }
                    }
                ?>
            </ol>
        </div>
        <div class="col-md-4 mb-3">
            <ol class="list-group text-left" id="FormListBodySiteOperasi">
                <li class="list-group-item d-flex justify-content-between align-items-start text-center">
                    Body Site
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <a href="javascript:void(0);" class="btn btn-sm btn-primary btn-round btn-block mb-2" data-toggle="modal" data-target="#ModalTambahBodySiteOperasi">
                        <i class="ti ti-plus"></i> Tambah
                    </a>
                </li>
                <?php
                    if(!empty($body_site)){
                        $body_site =json_decode($body_site, true);
                        $no=1;
                        foreach($body_site as $ListBodySite){
                            $BodySite=$ListBodySite['body_site'];
                            $keterangan=$ListBodySite['keterangan'];
                            echo '<li class="list-group-item d-flex justify-content-between align-items-start" id="BarisBodySite'.$no.'">';
                            echo '  <div class="ms-2 me-auto">';
                            echo '      <input type="hidden" id="BodySiteOperasi'.$no.'" name="BodySiteOperasi[]" value="'.$BodySite.'">';
                            echo '      <input type="hidden" id="KeteranganBodySiteOperasi'.$no.'" name="KeteranganBodySiteOperasi[]" value="'.$keterangan.'">';
                            echo '      <dt class="fw-bold">'.$BodySite.'</dt>';
                            echo '      <small>';
                            echo '          <ul>';
                            echo '              <li>'.$keterangan.'</li>';
                            echo '          </ul>';
                            echo '      </small>';
                            echo '  </div>';
                            echo '  <span class="icon-btn">';
                            echo '      <button type="button" class="btn btn-icon btn-outline-danger" data-toggle="modal" data-target="#ModalHapusBodySiteOperasi" data-id="'.$no.'">';
                            echo '          <i class="ti ti-close"></i>';
                            echo '      </button>';
                            echo '  </span>';
                            echo '</li>';
                            $no++;
                        }
                    }
                ?>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 mb-3">
            <ol class="list-group text-left" id="FormListTindakanOperasi">
                <li class="list-group-item d-flex justify-content-between align-items-start text-center">
                    Tindakan Operasi
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <a href="javascript:void(0);" class="btn btn-sm btn-primary btn-round btn-block mb-2" data-toggle="modal" data-target="#ModalTambahTindakanOperasi">
                        <i class="ti ti-plus"></i> Tambah
                    </a>
                </li>
                <?php
                    if(!empty($tindakan_operasi)){
                        $tindakan_operasi =json_decode($tindakan_operasi, true);
                        $no=1;
                        foreach($tindakan_operasi as $ListTindakanOperasi){
                            $kode=$ListTindakanOperasi['kode'];
                            $deskripsi=$ListTindakanOperasi['deskripsi'];
                            echo '<li class="list-group-item d-flex justify-content-between align-items-start" id="BarisTindakanOperasi'.$no.'">';
                            echo '  <div class="ms-2 me-auto">';
                            echo '      <input type="hidden" id="KodeTindakan'.$no.'" name="KodeTindakan[]" value="'.$kode.'">';
                            echo '      <input type="hidden" id="NamaTindakan'.$no.'" name="NamaTindakan[]" value="'.$deskripsi.'">';
                            echo '      <dt class="fw-bold">'.$kode.'</dt>';
                            echo '      '.$deskripsi.'';
                            echo '  </div>';
                            echo '  <span class="icon-btn">';
                            echo '      <button type="button" class="btn btn-icon btn-outline-danger" data-toggle="modal" data-target="#ModalHapusTindakanOperasi" data-id="'.$no.'">';
                            echo '          <i class="ti ti-close"></i>';
                            echo '      </button>';
                            echo '  </span>';
                            echo '</li>';
                            $no++;
                        }
                    }
                ?>
            </ol>
        </div>
        <div class="col-md-4 mb-3">
            <ol class="list-group text-left" id="FormListInstrumenOperasi">
                <li class="list-group-item d-flex justify-content-between align-items-start text-center">
                    Instrumen Operasi
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <a href="javascript:void(0);" class="btn btn-sm btn-primary btn-round btn-block mb-2" data-toggle="modal" data-target="#ModalTambahInstrumenOperasi">
                        <i class="ti ti-plus"></i> Tambah
                    </a>
                </li>
                <?php
                    if(!empty($instrumen)){
                        $instrumen =json_decode($instrumen, true);
                        $no=1;
                        foreach($instrumen as $ListInstrumen){
                            $Inst=$ListInstrumen['instrumen'];
                            echo '<li class="list-group-item d-flex justify-content-between align-items-start" id="BarisInstrumenOperasi'.$no.'">';
                            echo '  <div class="ms-2 me-auto">';
                            echo '      <input type="hidden" id="GetInstrumenOperasi'.$no.'" name="GetInstrumenOperasi[]" value="'.$Inst.'">';
                            echo '      '.$Inst.'';
                            echo '  </div>';
                            echo '  <span class="icon-btn">';
                            echo '      <button type="button" class="btn btn-icon btn-outline-danger" data-toggle="modal" data-target="#ModalHapusInstrumenOperasi" data-id="'.$no.'">';
                            echo '          <i class="ti ti-close"></i>';
                            echo '      </button>';
                            echo '  </span>';
                            echo '</li>';
                            $no++;
                        }
                    }
                ?>
            </ol>
        </div>
        <div class="col-md-4 mb-3">
            <ol class="list-group text-left" id="FormListKeteranganDokterOperasi">
                <li class="list-group-item d-flex justify-content-between align-items-start text-center">
                    Keterangan Dokter
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <a href="javascript:void(0);" class="btn btn-sm btn-primary btn-round btn-block mb-2" data-toggle="modal" data-target="#ModalTambahKeteranganDokter">
                        <i class="ti ti-plus"></i> Tambah
                    </a>
                </li>
                <?php
                    if(!empty($keterangan_dokter)){
                        $keterangan_dokter =json_decode($keterangan_dokter, true);
                        $no=1;
                        foreach($keterangan_dokter as $ListKeteranganDokter){
                            $dokter=$ListKeteranganDokter['dokter'];
                            $catatan=$ListKeteranganDokter['catatan'];
                            echo '<li class="list-group-item d-flex justify-content-between align-items-start" id="BarisTindakanOperasi'.$no.'">';
                            echo '  <div class="ms-2 me-auto">';
                            echo '      <input type="hidden" id="GetNamaKeteranganDokterOperasi'.$no.'" name="GetNamaKeteranganDokterOperasi[]" value="'.$dokter.'">';
                            echo '      <input type="hidden" id="GetKeteranganDokterOperasi'.$no.'" name="GetKeteranganDokterOperasi[]" value="'.$catatan.'">';
                            echo '      <dt class="fw-bold">'.$dokter.'</dt>';
                            echo '      <small class="text-secondary">'.$catatan.'</small>';
                            echo '  </div>';
                            echo '  <span class="icon-btn">';
                            echo '      <button type="button" class="btn btn-icon btn-outline-danger" data-toggle="modal" data-target="#ModalHapusKeteranganDokterOperasi" data-id="'.$no.'">';
                            echo '          <i class="ti ti-close"></i>';
                            echo '      </button>';
                            echo '  </span>';
                            echo '</li>';
                            $no++;
                        }
                    }
                ?>
            </ol>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12" id="NotifikasiTambahStatusOperasi">
            <span class="text-primary">Pastikan Informasi Operasi Sudah Terisi Dengan Benar Dan Lengkap!</span>
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