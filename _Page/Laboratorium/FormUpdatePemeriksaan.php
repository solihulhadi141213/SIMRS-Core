<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['id_permintaan'])){
        echo '  <div class="row mb-4">';
        echo '      <div class="col-md-12 text-danger text-center">';
        echo '          ID Permintaan Tidak Boleh Kosong';
        echo '      </div>';
        echo '  </div>';
    }else{
        $id_permintaan=$_POST['id_permintaan'];
        $waktu_pendaftaran=getDataDetail($Conn,'laboratorium_pemeriksaan','id_permintaan',$id_permintaan,'waktu_pendaftaran');
        $strtotime1=strtotime($waktu_pendaftaran);
        if(!empty($waktu_pendaftaran)){
            $TanggalPendaftaran=date('Y-m-d',$strtotime1);
            $JamPendaftaran=date('H:i',$strtotime1);
        }else{
            $TanggalPendaftaran=date('Y-m-d');
            $JamPendaftaran=date('H:i');
        }
        
        $pengambilan_sample=getDataDetail($Conn,'laboratorium_pemeriksaan','id_permintaan',$id_permintaan,'pengambilan_sample');
        $strtotime2=strtotime($pengambilan_sample);
        if(!empty($pengambilan_sample)){
            $TanggalPengambilanSample=date('Y-m-d',$strtotime2);
            $JamPengambilanSample=date('H:i',$strtotime2);
        }else{
            $TanggalPengambilanSample=date('Y-m-d');
            $JamPengambilanSample=date('H:i');
        }

        $pemeriksaan_sample=getDataDetail($Conn,'laboratorium_pemeriksaan','id_permintaan',$id_permintaan,'pemeriksaan_sample');
        $strtotime3=strtotime($pemeriksaan_sample);
        if(!empty($pemeriksaan_sample)){
            $TanggalPemeriksaanSample=date('Y-m-d',$strtotime3);
            $JamPemeriksaanSample=date('H:i',$strtotime3);
        }else{
            $TanggalPemeriksaanSample=date('Y-m-d');
            $JamPemeriksaanSample=date('H:i');
        }

        $keluar_hasil=getDataDetail($Conn,'laboratorium_pemeriksaan','id_permintaan',$id_permintaan,'keluar_hasil');
        $strtotime4=strtotime($keluar_hasil);
        if(!empty($keluar_hasil)){
            $TanggalKeluarHasil=date('Y-m-d',$strtotime4);
            $JamKeluarHasil=date('H:i',$strtotime4);
        }else{
            $TanggalKeluarHasil=date('Y-m-d');
            $JamKeluarHasil=date('H:i');
        }

        $hasil_diserahkan=getDataDetail($Conn,'laboratorium_pemeriksaan','id_permintaan',$id_permintaan,'hasil_diserahkan');
        $strtotime5=strtotime($hasil_diserahkan);
        if(!empty($hasil_diserahkan)){
            $TanggalHasilDiserahkan=date('Y-m-d',$strtotime5);
            $JamHasilDiserahkan=date('H:i',$strtotime5);
        }else{
            $TanggalHasilDiserahkan=date('Y-m-d');
            $JamHasilDiserahkan=date('H:i');
        }
        
        $metode_penyerahan=getDataDetail($Conn,'laboratorium_pemeriksaan','id_permintaan',$id_permintaan,'metode_penyerahan');
        $interpertasi_hasil=getDataDetail($Conn,'laboratorium_pemeriksaan','id_permintaan',$id_permintaan,'interpertasi_hasil');
        $dokter_interpertasi=getDataDetail($Conn,'laboratorium_pemeriksaan','id_permintaan',$id_permintaan,'dokter_interpertasi');
        $dokter_validator=getDataDetail($Conn,'laboratorium_pemeriksaan','id_permintaan',$id_permintaan,'dokter_validator');
        $petugas_analis=getDataDetail($Conn,'laboratorium_pemeriksaan','id_permintaan',$id_permintaan,'petugas_analis');
        $sig_dokter_intr=getDataDetail($Conn,'laboratorium_pemeriksaan','id_permintaan',$id_permintaan,'sig_dokter_intr');
        $sig_dokter_validator=getDataDetail($Conn,'laboratorium_pemeriksaan','id_permintaan',$id_permintaan,'sig_dokter_validator');
        $sig_petugas_analis=getDataDetail($Conn,'laboratorium_pemeriksaan','id_permintaan',$id_permintaan,'sig_petugas_analis');
?>
    <input type="hidden" id="id_permintaan" name="id_permintaan" value="<?php echo "$id_permintaan"; ?>">
    <div class="row mb-4">
        <div class="col-md-12">
            <label for="tanggal_pendaftaran">Permintaan Diterima</label>
        </div>
        <div class="col-md-6">
            <input type="date" name="tanggal_pendaftaran" id="tanggal_pendaftaran" class="form-control" value="<?php echo "$TanggalPendaftaran"; ?>">
            <small>Tanggal</small>
        </div>
        <div class="col-md-6">
            <input type="time" name="jam_pendaftaran" id="jam_pendaftaran" class="form-control" value="<?php echo "$JamPendaftaran"; ?>">
            <small>Jam</small>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-12">
            <label for="tanggal_pengambilan_sample">Pengambilan Sample</label>
        </div>
        <div class="col-md-6">
            <input type="date" name="tanggal_pengambilan_sample" id="tanggal_pengambilan_sample" class="form-control" value="<?php echo "$TanggalPengambilanSample"; ?>">
            <small>Tanggal</small>
        </div>
        <div class="col-md-6">
            <input type="time" name="jam_pengambilan_sample" id="jam_pengambilan_sample" class="form-control" value="<?php echo "$JamPengambilanSample"; ?>">
            <small>Jam</small>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-12">
            <label for="tanggal_pemeriksaan_sample">Pemeriksaan Sample</label>
        </div>
        <div class="col-md-6">
            <input type="date" name="tanggal_pemeriksaan_sample" id="tanggal_pemeriksaan_sample" class="form-control" value="<?php echo "$TanggalPemeriksaanSample"; ?>">
            <small>Tanggal</small>
        </div>
        <div class="col-md-6">
            <input type="time" name="jam_pemeriksaan_sample" id="jam_pemeriksaan_sample" class="form-control" value="<?php echo "$JamPemeriksaanSample"; ?>">
            <small>Jam</small>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-12">
            <label for="tanggal_keluar_hasil">Keluar Hasil</label>
        </div>
        <div class="col-md-6">
            <input type="date" name="tanggal_keluar_hasil" id="tanggal_keluar_hasil" class="form-control" value="<?php echo "$TanggalKeluarHasil"; ?>">
            <small>Tanggal</small>
        </div>
        <div class="col-md-6">
            <input type="time" name="jam_keluar_hasil" id="jam_keluar_hasil" class="form-control" value="<?php echo "$JamKeluarHasil"; ?>">
            <small>Jam</small>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-12">
            <label for="tanggal_hasil_diserahkan">Penyerahan Hasil</label>
        </div>
        <div class="col-md-6">
            <input type="date" name="tanggal_hasil_diserahkan" id="tanggal_hasil_diserahkan" class="form-control" value="<?php echo "$TanggalHasilDiserahkan"; ?>">
            <small>Tanggal</small>
        </div>
        <div class="col-md-6">
            <input type="time" name="jam_hasil_diserahkan" id="jam_hasil_diserahkan" class="form-control" value="<?php echo "$JamHasilDiserahkan"; ?>">
            <small>Jam</small>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-12">
            <label for="metode_penyerahan">Metode Penyerahan Hasil</label>
            <select name="metode_penyerahan" id="metode_penyerahan" class="form-control">
                <option <?php if($metode_penyerahan=="1"){echo "selected";} ?> value="1">Penyerahan Langsung</option>
                <option <?php if($metode_penyerahan=="2"){echo "selected";} ?> value="2">Surel</option>
            </select>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-12">
            <label for="interpertasi_hasil">Interpertasi Dokter</label>
            <textarea name="interpertasi_hasil" id="interpertasi_hasil" cols="30" rows="3" class="form-control"><?php echo "$interpertasi_hasil"; ?></textarea>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-12">
            <label for="dokter_interpertasi">Dokter Analis</label>
            <input type="text" id="dokter_interpertasi" name="dokter_interpertasi" class="form-control" value="<?php echo "$dokter_interpertasi"; ?>">
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-12">
            <label for="dokter_validator">Dokter Validator</label>
            <input type="text" id="dokter_validator" name="dokter_validator" class="form-control" value="<?php echo "$dokter_validator"; ?>">
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-12">
            <label for="petugas_analis">Petugas Analis</label>
            <input type="text" id="petugas_analis" name="petugas_analis" class="form-control" value="<?php echo "$petugas_analis"; ?>">
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-12" id="NotifikasiUpdatePemeriksaan">
            <span class="text-primary">Pastikan Informasi pemeriksaan Sudah Sesuai</span>
        </div>
    </div>
<?php } ?>