<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    //Koneksi ke database
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/FungsiSirsOnline.php";
    //Buka Pengaturan SIRS Online
    $x_id_rs=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','id_rs');
    $url_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','url_sirs_online');
    $password_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','password_sirs_online');
    //Tangkap id_antrian
    if(empty($_POST['GetContent'])){
        echo '  <div class="row">';
        echo '      <div class="col-md-6 mb-3">';
        echo '          ID Antrian Tidak Boleh Kosong';
        echo '      </div>';
        echo '  </div>';
    }else{
        $GetContent=$_POST['GetContent'];
        //Explode
        $GetContent = explode(",", $GetContent);
        $kodebooking =$GetContent[0];
        $tanggal_kunjungan =$GetContent[1];
        //Buka data Antrian
        //Buka Data SIRS Online
        $response_sisrs_online=DataAntrianSirsOnline($x_id_rs,$password_sirs_online,$url_sirs_online,'GET',$tanggal_kunjungan);
        $php_array = json_decode($response_sisrs_online, true);
        $DataAntrianSirsOnline=$php_array['antrian'];
        $JumlahData=0;
        foreach ($DataAntrianSirsOnline as $item) {
            if($kodebooking==$item['kodebooking']){
                $antrianid = $item['antrianid'];
                $koders = $item['koders'];
                $kodebooking = $item['kodebooking'];
                $jenispasien = $item['jenispasien'];
                $nik = $item['nik'];
                $idpoli = $item['idpoli'];
                $kodepoli = $item['kodepoli'];
                $pasienbaru = $item['pasienbaru'];
                $norm = $item['norm'];
                $tanggalperiksa = $item['tanggalperiksa'];
                $kodedokter = $item['kodedokter'];
                $jampraktekawal = $item['jampraktekawal'];
                $jampraktekakhir = $item['jampraktekakhir'];
                $jeniskunjungan = $item['jeniskunjungan'];
                $nomorantrean = $item['nomorantrean'];
                $angkaantrean = $item['angkaantrean'];
                $estimasidilayani = $item['estimasidilayani'];
                $sisakuotajkn = $item['sisakuotajkn'];
                $kuotajkn = $item['kuotajkn'];
                $sisakuotanonjkn = $item['sisakuotanonjkn'];
                $kuotanonjkn = $item['kuotanonjkn'];
                if(!empty($item['nomorreferensi'])){
                    $nomorreferensi = $item['nomorreferensi'];
                }else{
                    $nomorreferensi ="";
                }
                
                $keterangan = $item['keterangan'];
                $tglupdate = $item['tglupdate'];
                //Buka Nama Pasien
                $NamaPasien=getDataDetail($Conn,'pasien','id_pasien',$norm,'nama');
                $namapoli=getDataDetail($Conn,'poliklinik','kode',$kodepoli,'nama');
                $namadokter=getDataDetail($Conn,'dokter','kode',$kodedokter,'nama');
                $JumlahData=$JumlahData+1;
                //Estimasi Dilayani
                $jam_estimasidilayani=date('H:i',$estimasidilayani);
                $tanggal_estimasidilayani=date('Y-m-d',$estimasidilayani);
                //Explode Jam praktek
                $explode_jampraktekawal=explode(' ', $jampraktekawal);
                $tanggal_praktek_mulai=$explode_jampraktekawal['0'];
                $jam_praktek_mulai=$explode_jampraktekawal['1'];
                $explode_jampraktekakhir=explode(' ', $jampraktekakhir);
                $tanggal_praktek_akhir=$explode_jampraktekakhir['0'];
                $jam_praktek_akhir=$explode_jampraktekakhir['1'];
?>
        <div class="row mb-3"> 
            <div class="col col-md-4">
                <label for="kodebooking">Kode Booking</label>
            </div>
            <div class="col col-md-8">
                <input type="text" name="kodebooking" id="kodebooking" class="form-control" value="<?php echo $kodebooking; ?>">
            </div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-4">
                <label for="jenispasien">Jenis pasien</label>
            </div>
            <div class="col col-md-8">
                <select name="jenispasien" id="jenispasien" class="form-control">
                    <option <?php if($jenispasien=="UMUM"){echo "selected";} ?> value="NON JKN">NON JKN</option>
                    <option <?php if($jenispasien=="BPJS"){echo "selected";} ?> value="JKN">JKN</option>
                </select>
            </div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-4">
                <label for="nik">NIK</label>
            </div>
            <div class="col col-md-8">
                <input type="text" name="nik" id="nik" class="form-control" value="<?php echo $nik; ?>">
            </div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-4">
                <label for="kodepoli">Kode Poli</label>
            </div>
            <div class="col col-md-8">
                <input type="text" name="kodepoli" id="kodepoli" class="form-control" value="<?php echo $kodepoli; ?>">
            </div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-4">
                <label for="namapoli">Nama Poli</label>
            </div>
            <div class="col col-md-8">
                <input type="text" name="namapoli" id="namapoli" class="form-control" value="<?php echo $namapoli; ?>">
            </div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-4">
                <label for="pasienbaru">Pasien Baru?</label>
            </div>
            <div class="col col-md-8">
                <select name="pasienbaru" id="pasienbaru" class="form-control">
                    <option <?php if($pasienbaru=="0"){echo "selected";} ?> value="0">Tidak</option>
                    <option <?php if($pasienbaru=="1"){echo "selected";} ?> value="1">Ya</option>
                </select>
            </div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-4">
                <label for="norm">No.RM</label>
            </div>
            <div class="col col-md-8">
                <input type="text" name="norm" id="norm" class="form-control" value="<?php echo $norm; ?>">
            </div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-4">
                <label for="tanggalperiksa">Tanggal Periksa</label>
            </div>
            <div class="col col-md-8">
                <input type="date" name="tanggalperiksa" id="tanggalperiksa" class="form-control" value="<?php echo $tanggalperiksa; ?>">
            </div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-4">
                <label for="kodedokter">Kode Dokter</label>
            </div>
            <div class="col col-md-8">
                <input type="text" name="kodedokter" id="kodedokter" class="form-control" value="<?php echo $kodedokter; ?>">
            </div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-4">
                <label for="namadokter">Nama Dokter</label>
            </div>
            <div class="col col-md-8">
                <input type="text" name="namadokter" id="namadokter" class="form-control" value="<?php echo $namadokter; ?>">
            </div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-4">
                <label for="mulai_praktek">Jawal Praktek Awal</label>
            </div>
            <div class="col col-md-4">
                <input type="date" name="tanggal_praktek_mulai" id="tanggal_praktek_mulai" class="form-control" value="<?php echo $tanggal_praktek_mulai; ?>">
                <label for="tanggal_praktek_mulai"><small>Tanggal Mulai</small></label>
            </div>
            <div class="col col-md-4">
                <input type="time" name="jam_praktek_mulai" id="jam_praktek_mulai" class="form-control" value="<?php echo $jam_praktek_mulai; ?>">
                <label for="jam_praktek_mulai"><small>Jam Mulai</small></label>
            </div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-4">
                <label for="mulai_praktek">Jawal Praktek Akhir</label>
            </div>
            <div class="col col-md-4">
                <input type="date" name="tanggal_praktek_akhir" id="tanggal_praktek_akhir" class="form-control" value="<?php echo $tanggal_praktek_akhir; ?>">
                <label for="tanggal_praktek_akhir"><small>Tanggal Akhir</small></label>
            </div>
            <div class="col col-md-4">
                <input type="time" name="jam_praktek_akhir" id="jam_praktek_akhir" class="form-control" value="<?php echo $jam_praktek_akhir; ?>">
                <label for="jam_praktek_akhir"><small>Jam Mulai</small></label>
            </div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-4">
                <label for="jeniskunjungan">Jenis Kunjungan</label>
            </div>
            <div class="col col-md-8">
                <select name="jeniskunjungan" id="jeniskunjungan" class="form-control">
                    <option <?php if($jeniskunjungan=="1"){echo "selected";} ?> value="1">Rujukan FKTP</option>
                    <option <?php if($jeniskunjungan=="2"){echo "selected";} ?> value="2">Rujukan Internal</option>
                    <option <?php if($jeniskunjungan=="3"){echo "selected";} ?> value="3">Kontrol</option>
                    <option <?php if($jeniskunjungan=="4"){echo "selected";} ?> value="4">Rujukan Antar RS</option>
                </select>
            </div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-4">
                <label for="nomorreferensi">Nomor Referensi</label>
            </div>
            <div class="col col-md-8">
                <input type="text" name="nomorreferensi" id="nomorreferensi" class="form-control" value="<?php echo $nomorreferensi; ?>">
            </div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-4">
                <label for="nomorantrean">Nomor Antrian</label>
            </div>
            <div class="col col-md-8">
                <input type="text" name="nomorantrean" id="nomorantrean" class="form-control" value="<?php echo $nomorantrean; ?>">
            </div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-4">
                <label for="angkaantrean">Angka Antrian</label>
            </div>
            <div class="col col-md-8">
                <input type="text" name="angkaantrean" id="angkaantrean" class="form-control" value="<?php echo $angkaantrean; ?>">
            </div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-4">
                <label for="estimasidilayani">Estimasi Dilayani</label>
            </div>
            <div class="col col-md-4">
                <input type="date" name="tanggal_estimasidilayani" id="tanggal_estimasidilayani" class="form-control" value="<?php echo $tanggal_estimasidilayani; ?>">
            </div>
            <div class="col col-md-4">
                <input type="time" name="jam_estimasidilayani" id="jam_estimasidilayani" class="form-control" value="<?php echo $jam_estimasidilayani; ?>">
            </div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-4">
                <label for="keterangan">Keterangan</label>
            </div>
            <div class="col col-md-8">
                <input type="text" name="keterangan" id="keterangan" class="form-control" value="<?php echo $keterangan; ?>">
            </div>
        </div>
<?php }}} ?>