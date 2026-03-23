<?php
    //Koneksi
    ini_set("display_errors","off");
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
                $id_antrian=getDataDetail($Conn,'antrian','kodebooking',$kodebooking,'id_antrian');
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
                <dt for="kodebooking">Kode Booking</dt>
            </div>
            <div class="col col-md-8" id="NilaiKodeBooking">
                <?php echo $kodebooking; ?>
            </div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-4">
                <dt for="jenispasien">Jenis pasien</dt>
            </div>
            <div class="col col-md-8">
                <?php echo $jenispasien; ?>
            </div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-4">
                <dt for="nik">NIK</dt>
            </div>
            <div class="col col-md-8">
                <?php echo $nik; ?>
            </div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-4">
                <dt for="kodepoli">Kode Poli</dt>
            </div>
            <div class="col col-md-8">
                <?php echo $kodepoli; ?>
            </div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-4">
                <dt for="namapoli">Nama Poli</dt>
            </div>
            <div class="col col-md-8">
                <?php echo $namapoli; ?>
            </div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-4">
                <dt for="pasienbaru">Pasien Baru?</dt>
            </div>
            <div class="col col-md-8">
                <?php
                    if($pasienbaru=="0"){
                        echo "Tidak";
                    }else{
                        echo "Ya";
                    }
                ?>
            </div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-4">
                <dt for="norm">No.RM</dt>
            </div>
            <div class="col col-md-8">
                <?php echo $norm; ?>
            </div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-4">
                <dt for="tanggalperiksa">Tanggal Periksa</dt>
            </div>
            <div class="col col-md-8">
                <?php echo $tanggalperiksa; ?>
            </div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-4">
                <dt for="kodedokter">Kode Dokter</dt>
            </div>
            <div class="col col-md-8">
                <?php echo $kodedokter; ?>
            </div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-4">
                <dt for="namadokter">Nama Dokter</dt>
            </div>
            <div class="col col-md-8">
                <?php echo $namadokter; ?>
            </div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-4">
                <dt for="mulai_praktek">Jawal Praktek Awal</dt>
            </div>
            <div class="col col-md-8">
                <?php echo "$tanggal_praktek_mulai $jam_praktek_mulai"; ?>
            </div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-4">
                <dt for="mulai_praktek">Jawal Praktek Akhir</dt>
            </div>
            <div class="col col-md-8">
                <?php echo "$tanggal_praktek_akhir $jam_praktek_akhir"; ?>
            </div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-4">
                <dt for="jeniskunjungan">Jenis Kunjungan</dt>
            </div>
            <div class="col col-md-8">
                <?php
                    if($jeniskunjungan=="1"){
                        echo "Rujukan FKTP";
                    }else{
                        if($jeniskunjungan=="2"){
                            echo "Rujukan Internal";
                        }else{
                            if($jeniskunjungan=="3"){
                                echo "Kontrol";
                            }else{
                                if($jeniskunjungan=="4"){
                                    echo "Rujukan Antar RS";
                                }else{
                                    echo "<span class='text-danger'>Tidak Diketahui</span>";
                                }
                            }
                        }
                    }
                ?>
            </div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-4">
                <dt for="nomorreferensi">Nomor Referensi</dt>
            </div>
            <div class="col col-md-8">
                <?php echo $nomorreferensi; ?>
            </div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-4">
                <dt for="nomorantrean">Nomor Antrian</dt>
            </div>
            <div class="col col-md-8">
                <?php echo $nomorantrean; ?>
            </div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-4">
                <dt for="angkaantrean">Angka Antrian</dt>
            </div>
            <div class="col col-md-8">
                <?php echo $angkaantrean; ?>
            </div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-4">
                <dt for="estimasidilayani">Estimasi Dilayani</dt>
            </div>
            <div class="col col-md-8">
                <?php echo "$tanggal_estimasidilayani $jam_estimasidilayani"; ?>
            </div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-4">
                <dt for="keterangan">Keterangan</dt>
            </div>
            <div class="col col-md-8">
                <?php echo $keterangan; ?>
            </div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-4">
                <dt for="keterangan">Detail Antrian</dt>
            </div>
            <div class="col col-md-8">
                <a href="index.php?Page=Antrian&Sub=DetailAntrian&id=<?php echo $id_antrian;?>" target="_blank" class="text-success">
                    Buka Halaman Detail Antrian <i class="ti ti-new-window"></i> 
                </a>
            </div>
        </div>
<?php }}} ?>