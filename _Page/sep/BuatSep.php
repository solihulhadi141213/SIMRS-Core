<?php
    include "_Config/SettingBridging.php";
    include "_Config/SimrsFunction.php"; 
    include "vendor/autoload.php"; 
    //Now
    $now=date('Y-m-d');
    if(empty($_SESSION['UrlBackSep'])){
        $UrlBack='index.php?Page=sep';
    }else{
        $UrlBack=$_SESSION['UrlBackSep'];
    }
    //Tangkap ID
    if(empty($_GET['id_kunjungan'])){
        echo "Silahkan Pilih Kunjungan Pasien Terlebih Dulu!";
    }else{
        $id_kunjungan=$_GET['id_kunjungan'];
        //Informasi Pasien
        $id_pasien=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'id_pasien');
        $no_bpjs=getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'no_bpjs');
        $nik=getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'nik');
        $nama=getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'nama');
        $KontakPasien=getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'kontak');
        $rujukan_dari=getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'rujukan_dari');
        $noRujukan=getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'noRujukan');
        $skdp=getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'skdp');
        $DiagAwal=getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'DiagAwal');
        $id_poliklinik=getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'id_poliklinik');
        //Informasi Kunjungan
        $sep=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'sep');
        $noRujukan=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'noRujukan');
        $skdp=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'skdp');
        $TanggalKunjungan=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'tanggal');
        $keluhan=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'keluhan');
        $tujuan=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'tujuan');
        $id_dokter=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'id_dokter');
        $NamaDokterKunjungan=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'dokter');
        $NamaPoliklinikKunjungan=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'poliklinik');
        $id_poliklinik=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'id_poliklinik');
        $DiagAwal=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'DiagAwal');
        $rujukan_dari=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'rujukan_dari');
        if(!empty($sep)){

        }
?>
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <dt class="sub-title">A. Informasi Pasien (SIMRS)</dt>
                                    <ol class="mb-4">
                                        <li>No.RM : <code class="text-secondary"><?php echo "$id_pasien"; ?></code></li>
                                        <li>Nama Pasien : <code class="text-secondary"><?php echo "$nama"; ?></code></li>
                                        <li>NIK : <code class="text-secondary"><?php echo "$nik"; ?></code></li>
                                        <li>No.BPJS : <code class="text-secondary"><?php echo "$no_bpjs"; ?></code></li>
                                        <li>Kontak : <code class="text-secondary"><?php echo "$KontakPasien"; ?></code></li>
                                    </ol>
                                    <dt class="sub-title">B. Informasi Kunjungan (SIMRS)</dt>
                                    <ol class="mb-4">
                                        <li>ID.Kunjungan : <code class="text-secondary"><?php echo "$id_kunjungan"; ?></code></li>
                                        <li>No.Rujukan : <code class="text-secondary"><?php echo "$noRujukan"; ?></code></li>
                                        <li>Rujukan Dari : <code class="text-secondary"><?php echo "$rujukan_dari"; ?></code></li>
                                        <li>No.SKDP/SPRI : <code class="text-secondary"><?php echo "$skdp"; ?></code></li>
                                        <li>Tgl Kunjungan : <code class="text-secondary"><?php echo "$TanggalKunjungan"; ?></code></li>
                                        <li>Keluhan : <code class="text-secondary"><?php echo "$keluhan"; ?></code></li>
                                        <li>Tujuan : <code class="text-secondary"><?php echo "$tujuan"; ?></code></li>
                                        <li>Dokter : <code class="text-secondary"><?php echo "($id_dokter) $NamaDokterKunjungan"; ?></code></li>
                                        <li>Poliklinik : <code class="text-secondary"><?php echo "($id_poliklinik) $NamaPoliklinikKunjungan"; ?></code></li>
                                        <li>Diagnosa : <code class="text-secondary"><?php echo "$DiagAwal"; ?></code></li>
                                    </ol>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h4><i class="icofont-patient-file"></i> Informasi Lainnya</h4>
                                </div>
                                <div class="card-body accordion-block">
                                    <div id="accordion" role="tablist" aria-multiselectable="true">
                                        <div class="accordion-panel">
                                            <div class="accordion-heading" role="tab" id="heading1">
                                                <h3 class="card-title accordion-title">
                                                    <a class="accordion-msg waves-effect waves-dark scale_active" data-toggle="collapse" data-parent="#accordion" href="#SubInformasiPeserta" aria-expanded="true" aria-controls="SubInformasiPeserta">
                                                        <dt>1. Informasi Peserta BPJS</dt>
                                                    </a>
                                                </h3>
                                            </div>
                                        </div>
                                        <div id="SubInformasiPeserta" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading1">
                                            <div class="accordion-content accordion-desc bg-light">
                                                <p>
                                                    Informasi data pasien berdasarkan nomor kartu BPJS dari service bridging BPJS
                                                </p>
                                                <?php
                                                    if(empty($no_bpjs)){
                                                        echo '<span class="text-danger">Nomor kartu BPJS tidak ada, anda mungkin tidak akan bisa membuat SEP untuk kunjungan ini.</span>';
                                                    }else{
                                                        $UrlPencarianPeserta="$url_vclaim/Peserta/nokartu/$no_bpjs/tglSEP/$now";
                                                        $Response=BridgingServiceGet($consid,$secret_key,$user_key,$UrlPencarianPeserta);
                                                        if(empty($Response)){
                                                            echo '<span class="text-danger">';
                                                            echo '  Tidak ada response dari sistem BPJS';
                                                            echo '</span>';
                                                        }else{
                                                            $InformasiPesertaJson =json_decode($Response, true);
                                                            if(empty($InformasiPesertaJson["metaData"]["code"])){
                                                                echo '<span class="text-danger pre-scrollable">';
                                                                echo '  Terjadi Kesalahan Pada Service BPJS! Tidak ada kode kesalahan<br> '.$Response.'';
                                                                echo '</span>';
                                                            }else{
                                                                if($InformasiPesertaJson["metaData"]["code"]!=="200"){
                                                                    $PesanKesalahan=$InformasiPesertaJson["metaData"]["message"];
                                                                    echo '<span class="text-danger pre-scrollable">';
                                                                    echo '  Terjadi Kesalahan Pada Service BPJS!<br> '.$PesanKesalahan.'';
                                                                    echo '</span>';
                                                                }else{
                                                                    if(empty($InformasiPesertaJson["response"])){
                                                                        echo '<span class="text-danger pre-scrollable">';
                                                                        echo '  Terjadi Kesalahan Pada Service BPJS! </dt> '.$Response.'';
                                                                        echo '</span>';
                                                                    }else{
                                                                        $StringInformasiPasien=$InformasiPesertaJson["response"];
                                                                        $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
                                                                        $key="$consid$secret_key$timestamp";
                                                                        //--masukan ke fungsi
                                                                        $FileDeskripsi=stringDecrypt("$key", "$StringInformasiPasien");
                                                                        $FileDekompresi=decompress("$FileDeskripsi");
                                                                        $FileDekompresiJson =json_decode($FileDekompresi, true);
                                                                        //--konveris json to raw
                                                                        if(empty(json_decode($FileDekompresi, true))){
                                                                            echo '<span class="text-danger pre-scrollable">';
                                                                            echo '  <dt>Proses Decrypt Gagal!</dt> Terjadi kesalahan pada saat melakukan proses deskripsi';
                                                                            echo '</span>';
                                                                        }else{
                                                                            if(empty($FileDekompresiJson['peserta'])){
                                                                                echo '<span class="text-danger pre-scrollable">';
                                                                                echo '  <dt>Tidak Ada Response Yang Di Dekripsi!</dt> '.$StringInformasiPasien.'';
                                                                                echo '</span>';
                                                                            }else{
                                                                                $peserta=$FileDekompresiJson['peserta'];
                                                                                echo '<ol>';
                                                                                echo '  <li>';
                                                                                echo '      COB';
                                                                                echo '      <ul>';
                                                                                echo '          <li>- Nama Asuransi : <code class="text-secondary">'.$peserta['cob']['nmAsuransi'].'</code></li>';
                                                                                echo '          <li>- No.Asuransi : <code class="text-secondary">'.$peserta['cob']['noAsuransi'].'</code></li>';
                                                                                echo '          <li>- Tgl.TAT : <code class="text-secondary">'.$peserta['cob']['tglTAT'].'</code></li>';
                                                                                echo '          <li>- Tgl.TMT : <code class="text-secondary">'.$peserta['cob']['tglTMT'].'</code></li>';
                                                                                echo '      </ul>';
                                                                                echo '  </li>';
                                                                                echo '  <li>';
                                                                                echo '      Hak Kelas';
                                                                                echo '      <ul>';
                                                                                echo '          <li>- Hak Kelas : <code class="text-secondary">'.$peserta['hakKelas']['keterangan'].'</code></li>';
                                                                                echo '          <li>- Kode : <code class="text-secondary">'.$peserta['hakKelas']['kode'].'</code></li>';
                                                                                echo '      </ul>';
                                                                                echo '  </li>';
                                                                                echo '  <li>';
                                                                                echo '      Informasi';
                                                                                echo '      <ul>';
                                                                                echo '          <li>- Dinsos : <code class="text-secondary">'.$peserta['informasi']['dinsos'].'</code></li>';
                                                                                echo '          <li>- No.SKTM : <code class="text-secondary">'.$peserta['informasi']['noSKTM'].'</code></li>';
                                                                                echo '          <li>- Prolanis PRB : <code class="text-secondary">'.$peserta['informasi']['prolanisPRB'].'</code></li>';
                                                                                echo '      </ul>';
                                                                                echo '  </li>';
                                                                                echo '  <li>';
                                                                                echo '      Jenis Peserta';
                                                                                echo '      <ul>';
                                                                                echo '          <li>- Keterangan : <code class="text-secondary">'.$peserta['jenisPeserta']['keterangan'].'</code></li>';
                                                                                echo '          <li>- Kode : <code class="text-secondary">'.$peserta['jenisPeserta']['kode'].'</code></li>';
                                                                                echo '      </ul>';
                                                                                echo '  </li>';
                                                                                echo '  <li>';
                                                                                echo '      MR';
                                                                                echo '      <ul>';
                                                                                echo '          <li>- No.RM : <code class="text-secondary">'.$peserta['mr']['noMR'].'</code></li>';
                                                                                echo '          <li>- No.Telepon : <code class="text-secondary">'.$peserta['mr']['noTelepon'].'</code></li>';
                                                                                echo '      </ul>';
                                                                                echo '  </li>';
                                                                                echo '  <li>Nama : <code class="text-secondary">'.$peserta['nama'].'</code></li>';
                                                                                echo '  <li>NIK : <code class="text-secondary">'.$peserta['nik'].'</code></li>';
                                                                                echo '  <li>No.Kartu : <code class="text-secondary">'.$peserta['noKartu'].'</code></li>';
                                                                                echo '  <li>Pisa : <code class="text-secondary">'.$peserta['pisa'].'</code></li>';
                                                                                echo '  <li>';
                                                                                echo '      Prov Umum';
                                                                                echo '      <ul>';
                                                                                echo '          <li>- Kode : <code class="text-secondary">'.$peserta['provUmum']['kdProvider'].'</code></li>';
                                                                                echo '          <li>- Nama : <code class="text-secondary">'.$peserta['provUmum']['nmProvider'].'</code></li>';
                                                                                echo '      </ul>';
                                                                                echo '  </li>';
                                                                                echo '  <li>Gender : <code class="text-secondary">'.$peserta['sex'].'</code></li>';
                                                                                echo '  <li>';
                                                                                echo '      Status Peserta';
                                                                                echo '      <ul>';
                                                                                echo '          <li>- Keterangan : <code class="text-secondary">'.$peserta['statusPeserta']['keterangan'].'</code></li>';
                                                                                echo '          <li>- Kode : <code class="text-secondary">'.$peserta['statusPeserta']['kode'].'</code></li>';
                                                                                echo '      </ul>';
                                                                                echo '  </li>';
                                                                                echo '  <li>Tgl.Cetak Kartu : <code class="text-secondary">'.$peserta['tglCetakKartu'].'</code></li>';
                                                                                echo '  <li>Tgl Lahir : <code class="text-secondary">'.$peserta['tglLahir'].'</code></li>';
                                                                                echo '  <li>Tgl TAT : <code class="text-secondary">'.$peserta['tglTAT'].'</code></li>';
                                                                                echo '  <li>Tgl TMT : <code class="text-secondary">'.$peserta['tglTMT'].'</code></li>';
                                                                                echo '  <li>';
                                                                                echo '      Umur';
                                                                                echo '      <ul>';
                                                                                echo '          <li>- Saat Layanan : <code class="text-secondary">'.$peserta['umur']['umurSaatPelayanan'].'</code></li>';
                                                                                echo '          <li>- Sekarang : <code class="text-secondary">'.$peserta['umur']['umurSekarang'].'</code></li>';
                                                                                echo '      </ul>';
                                                                                echo '  </li>';
                                                                                echo '</ol>';
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                        <?php if(!empty($sep)){ ?>
                                            <div class="accordion-panel">
                                                <div class="accordion-heading" role="tab" id="heading1">
                                                    <h3 class="card-title accordion-title">
                                                        <a class="accordion-msg waves-effect waves-dark scale_active" data-toggle="collapse" data-parent="#accordion" href="#SubInformasiSep" aria-expanded="true" aria-controls="SubInformasiSep">
                                                            <dt>2. Informasi SEP</dt>
                                                        </a>
                                                    </h3>
                                                </div>
                                            </div>
                                            <div id="SubInformasiSep" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading1">
                                                <div class="accordion-content accordion-desc bg-light">
                                                    <p>
                                                        Informasi SEP berdasarkan nomor SEP dari service bridging BPJS
                                                    </p>
                                                    <?php
                                                        $ResponseSep=DetailSep($url_vclaim,$consid,$secret_key,$user_key,$url_vclaim,$sep);
                                                        if(empty($ResponseSep)){
                                                            echo '<div class="row">';
                                                            echo '  <div class="col-md-12 text-center">';
                                                            echo '      <span class="text-danger">Tidak Ada Response Dari Service Function SIMRS!</span>';
                                                            echo '  </div>';
                                                            echo '</div>';
                                                        }else{
                                                            $ResponseDataSep =json_decode($ResponseSep, true);
                                                            if(empty($ResponseDataSep['metaData']['code'])){
                                                                echo '<div class="row">';
                                                                echo '  <div class="col-md-12 text-center">';
                                                                echo '      <span class="text-danger">Tidak Ada Response Dari Service BPJS!</span>';
                                                                echo '  </div>';
                                                                echo '</div>';
                                                            }else{
                                                                $ResponseCodeSep=$ResponseDataSep['metaData']['code'];
                                                                if($ResponseCodeSep!=="200"){
                                                                    echo '<div class="row">';
                                                                    echo '  <div class="col-md-12 text-center">';
                                                                    echo '      <span class="text-danger">Pesan: '.$ResponseDataSep['metaData']['message'].'</span>';
                                                                    echo '  </div>';
                                                                    echo '</div>';
                                                                }else{
                                                                    if(empty($ResponseDataSep['response'])){
                                                                        echo '<div class="row">';
                                                                        echo '  <div class="col-md-12 text-center">';
                                                                        echo '      <dt class="text-danger">Terjadi Kesalahan Pada Response</dt>';
                                                                        echo '      <span class="text-danger">Pesan: '.$ResponseDataSep['metaData']['message'].'</span>';
                                                                        echo '  </div>';
                                                                        echo '</div>';
                                                                    }else{
                                                                        $string=$ResponseDataSep['response'];
                                                                        $stringData =json_decode($string, true);
                                                                        $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
                                                                        $key="$consid$secret_key$timestamp";
                                                                        //--masukan ke fungsi
                                                                        $FileDeskripsi=stringDecrypt("$key", "$string");
                                                                        $FileDekompresi=decompress("$FileDeskripsi");
                                                                        //--konveris json to raw
                                                                        $JsonDataSep =json_decode($FileDekompresi, true);
                                                                        $noSep2=$JsonDataSep["noSep"];
                                                                        $tglSep2=$JsonDataSep["tglSep"];
                                                                        $jnsPelayanan2=$JsonDataSep["jnsPelayanan"];
                                                                        $kelasRawat2=$JsonDataSep["kelasRawat"];
                                                                        $diagnosa2=$JsonDataSep["diagnosa"];
                                                                        $noRujukan2=$JsonDataSep["noRujukan"];
                                                                        $poli2=$JsonDataSep["poli"];
                                                                        $poliEksekutif2=$JsonDataSep["poliEksekutif"];
                                                                        $catatan2=$JsonDataSep["catatan"];
                                                                        $penjamin2=$JsonDataSep["penjamin"];
                                                                        $kdStatusKecelakaan2=$JsonDataSep["kdStatusKecelakaan"];
                                                                        $nmstatusKecelakaan2=$JsonDataSep["nmstatusKecelakaan"];
                                                                        echo '<ol>';
                                                                        echo '  <li class="mb-2">No.SEP : <code class="text-secondary">'.$noSep2.'</code></li>';
                                                                        echo '  <li class="mb-2">Tgl.SEP : <code class="text-secondary">'.$tglSep2.'</code></li>';
                                                                        echo '  <li class="mb-2">Jenis Pelayanan : <code class="text-secondary">'.$jnsPelayanan2.'</code></li>';
                                                                        echo '  <li class="mb-2">Diagnosa : <code class="text-secondary">'.$diagnosa2.'</code></li>';
                                                                        echo '  <li class="mb-2">No.Rujukan : <code class="text-secondary">'.$noRujukan2.'</code></li>';
                                                                        echo '  <li class="mb-2">Poliklinik : <code class="text-secondary">'.$poli2.'</code></li>';
                                                                        echo '  <li class="mb-2">Poli Eksekutif : <code class="text-secondary">'.$poliEksekutif2.'</code></li>';
                                                                        echo '  <li class="mb-2">Catatan : <code class="text-secondary">'.$catatan2.'</code></li>';
                                                                        echo '  <li class="mb-2">Penjamin : <code class="text-secondary">'.$penjamin2.'</code></li>';
                                                                        echo '  <li class="mb-2">Kode Status Kecelakaan : <code class="text-secondary">'.$kdStatusKecelakaan2.'</code></li>';
                                                                        echo '  <li class="mb-2">Nama Status Kecelakaan : <code class="text-secondary">'.$nmstatusKecelakaan2.'</code></li>';
                                                                        echo '</ol>';
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <form action="javascript:void(0);" id="ProsesBuatSep" autocomplete="off">
                                <input type="hidden" name="UrlForBack" id="UrlForBack" value="<?php echo "$UrlBack"; ?>">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-md-8 mb-2">
                                                <h4>
                                                    <?php
                                                        if(!empty($sep)){
                                                            echo '<i class="ti ti-pencil"></i> Form Edit SEP';
                                                        }else{
                                                            echo '<i class="ti ti-plus"></i> Form Buat SEP';
                                                        }
                                                    ?>
                                                    
                                                </h4>
                                            </div>
                                            <div class="col-md-2 mb-2">
                                                <a href="<?php echo $UrlBack;?>" class="btn btn-sm btn-secondary btn-block">
                                                    <i class="ti ti-angle-left"></i> Kembali
                                                </a>
                                            </div>
                                            <div class="col-md-2 mb-2">
                                                <button type="button" class="btn btn-sm btn-outline-secondary btn-block" data-toggle="modal" data-target="#ModalBuatSep">
                                                    <i class="ti ti-user"></i> Pilih
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-4">
                                            <div class="col-md-12 sub-title">
                                                <dt class="mb-3">A. Informasi Pasien</dt>
                                                <div class="row mb-3">
                                                    <div class="col-md-12">
                                                        Sesuai data kunjungan pasien yang dipilih. 
                                                        Apabila terdapat data yang tidak sesuai, anda harus kembali ke modul pengelolaan data pasien dan kunjungan.
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-3">
                                                        <label for="sep">NO.SEP</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" readonly required id="sep" name="sep" class="form-control" value="<?php echo $sep;?>">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-3">
                                                        <label for="id_pasien">NO.RM</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" readonly required id="id_pasien" name="id_pasien" class="form-control" value="<?php echo $id_pasien;?>">
                                                    </div>
                                                </div>
                                                <div class="row mb-4">
                                                    <div class="col-md-3">
                                                        <label for="id_kunjungan">ID. Kunjungan</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" readonly required id="id_kunjungan" name="id_kunjungan" class="form-control" value="<?php echo $id_kunjungan;?>">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-3"><label for="nik">NIK Pasien</label></div>
                                                    <div class="col-md-9">
                                                        <input type="text" readonly required id="nik" name="nik" class="form-control" value="<?php echo $nik; ?>">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-3"><label for="no_bpjs">Nomor BPJS</label></div>
                                                    <div class="col-md-9">
                                                        <input type="text" readonly required id="no_bpjs" name="no_bpjs" class="form-control" value="<?php echo $no_bpjs; ?>">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-3"><label for="nama">Nama Pasien</label></div>
                                                    <div class="col-md-9">
                                                        <input type="text" readonly required id="nama" name="nama" class="form-control" value="<?php echo $nama;?>">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-3"><label for="noTelp">Kontak Pasien</label></div>
                                                    <div class="col-md-9">
                                                        <input type="text" readonly required id="noTelp" name="noTelp" class="form-control" value="<?php echo $KontakPasien;?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-md-12 sub-title">
                                                <dt class="mb-3">B. PPK Pelayanan</dt>
                                                <div class="row mb-3">
                                                    <div class="col-md-12">
                                                        PPK pelayanan sesuai dengan pengaturan bridging faskes yang aktif.
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-3">
                                                        <label for="ppkPelayanan">Kode PPK</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" readonly required id="ppkPelayanan" name="ppkPelayanan" class="form-control" value="<?php echo "$kode_ppk"; ?>">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-3">
                                                        <label for="NamappkPelayanan">Nama PPK</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" readonly required id="NamappkPelayanan" name="NamappkPelayanan" class="form-control" value="<?php echo "$NamaFaskes"; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-md-12 sub-title">
                                                <dt class="mb-3">C. Rujukan</dt>
                                                <div class="row mb-3">
                                                    <div class="col-md-3">
                                                        <label for="noRujukan">Nomor Rujukan</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <div class="input-group">
                                                            <input type="text" name="noRujukan" id="noRujukan" class="form-control" value="<?php if(!empty($sep)){echo "$noRujukan2";}else{echo "$noRujukan";} ?>">
                                                            <button type="button" class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#ModalCariRujukan" title="Cari Rujukan">
                                                                <i class="ti ti-search"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-3">
                                                        <label for="tglRujukan">Tanggal Rujukan</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="date" id="tglRujukan" name="tglRujukan" class="form-control" value="">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-3">
                                                        <label for="asalRujukan">Asal Rujukan</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <select name="asalRujukan" id="asalRujukan" class="form-control">
                                                            <option value="">Pilih</option>
                                                            <option value="1">Faskes 1</option>
                                                            <option value="2">Faskes 2</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-3">
                                                        <label for="rujukan_dari">PPK Asal Rujukan</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <div class="input-group">
                                                            <input type="text" name="rujukan_dari" id="rujukan_dari" class="form-control" value="<?php echo "$rujukan_dari"; ?>">
                                                            <button type="button" class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#ModalPencarianPpkPerujuk" title="Cari Kode PPK Perujuk">
                                                                <i class="ti ti-search"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-md-12 sub-title">
                                                <dt class="mb-3">D. SKDP/SPRI</dt>
                                                <div class="row mb-3">
                                                    <div class="col-md-3">
                                                        <label for="noSurat">No.SKDP/SPRI</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <div class="input-group">
                                                            <input type="text" name="noSurat" id="noSurat" class="form-control" value="<?php echo "$skdp"; ?>">
                                                            <button type="button" class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#ModalPencarianSpriSkdp" title="Cari SPRI/SKDP">
                                                                <i class="ti ti-search"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-3">
                                                        <label for="kodeDPJP">Kode DPJP</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <select name="kodeDPJP" id="kodeDPJP" class="form-control">
                                                            <option value="">Pilih</option>
                                                            <?php
                                                                //menamilkan dari database
                                                                $query = mysqli_query($Conn, "SELECT*FROM dokter");
                                                                while ($data = mysqli_fetch_array($query)) {
                                                                    $id_dokter_list= $data['id_dokter'];
                                                                    $nama= $data['nama'];
                                                                    $kodeDpjp= $data['kode'];
                                                                    echo '<option value="'.$kodeDpjp.'">('.$kodeDpjp.') '.$nama.'</option>';
                                                                }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-md-12 sub-title">
                                                <dt class="mb-3">E. Informasi Kunjungan</dt>
                                                <div class="row mb-3">
                                                    <div class="col-md-3">
                                                        <label for="jnsPelayanan">Jenis Pelayanan</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <select name="jnsPelayanan" id="jnsPelayanan" class="form-control">
                                                            <option <?php if(!empty($sep)){if($jnsPelayanan2=="Rawat Inap"){echo "selected";}} ?> value="1">Rawat Inap</option>
                                                            <option <?php if(!empty($sep)){if($jnsPelayanan2=="Rawat Jalan"){echo "selected";}}else{echo "selected";} ?> selected value="2">Rawat Jalan</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-3">
                                                        <label for="tglSep">Tanggal SEP</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="date" name="tglSep" id="tglSep" class="form-control" value="<?php if(!empty($sep)){echo "$tglSep2";}else{echo date('Y-m-d');} ?>">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-3">
                                                        <label for="diagAwal">Diagnosa Awal</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <div class="input-group">
                                                            <input type="text" name="diagAwal" id="diagAwal" class="form-control" value="<?php if(!empty($sep)){echo "$DiagAwal";}else{echo "$DiagAwal";} ?>">
                                                            <button type="button" class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#ModalCariDiagnosa" title="Cari Diagnosa Awal">
                                                                <i class="ti ti-search"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-3">
                                                        <label for="dpjpLayan">DPJP Pelayanan</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <select name="dpjpLayan" id="dpjpLayan" class="form-control">
                                                            <option value="">Pilih</option>
                                                            <?php
                                                                //menamilkan dari database
                                                                $query = mysqli_query($Conn, "SELECT*FROM dokter");
                                                                while ($data = mysqli_fetch_array($query)) {
                                                                    $id_dokter_list= $data['id_dokter'];
                                                                    $nama= $data['nama'];
                                                                    $kodeDpjp= $data['kode'];
                                                                    if($id_dokter==$id_dokter_list){
                                                                        echo '<option selected value="'.$kodeDpjp.'">'.$nama.'</option>';
                                                                    }else{
                                                                        echo '<option value="'.$kodeDpjp.'">'.$nama.'</option>';
                                                                    }
                                                                }
                                                            ?>
                                                        </select>
                                                        <small>Diisi hanya apabila jenis layanan rawat inap (Ranap)</small>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-3">
                                                        <label for="cob">COB</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <select name="cob" id="cob" class="form-control">
                                                            <option value="0">Tidak</option>
                                                            <option value="1">Ya</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-3">
                                                        <label for="katarak">Katarak</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <select name="katarak" id="katarak" class="form-control">
                                                            <option value="0">Tidak</option>
                                                            <option value="1">Ya</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-3">
                                                        <label for="catatan">Catatan</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" name="catatan" id="catatan" class="form-control" value="<?php if(!empty($sep)){echo "$catatan2";} ?>">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-3">
                                                        <label for="tujuanKunj">Tujuan Kunjungan</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <select name="tujuanKunj" id="tujuanKunj" class="form-control">
                                                            <option value="0">0.Normal</option>
                                                            <option value="1">1.Prosedur</option>
                                                            <option value="2">2.Konsul Dokter</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-3">
                                                        <label for="flagProcedure">Flag Procedure</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <select disabled name="flagProcedure" id="flagProcedure" class="form-control">
                                                            <option value="0">0.Prosedur Tidak Berkelanjutan</option>
                                                            <option value="1">1.Prosedur dan Terapi Berkelanjutan</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-3">
                                                        <label for="kdPenunjang">Kode Penunjang</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <select disabled name="kdPenunjang" id="kdPenunjang" class="form-control">
                                                            <option value="1">1.Radioterapi</option>
                                                            <option value="2">2.Kemoterapi</option>
                                                            <option value="3">3.Rehabilitasi Medik</option>
                                                            <option value="4">4.Rehabilitasi Psikososial</option>
                                                            <option value="5">5.Transfusi Darah</option>
                                                            <option value="6">6.Pelayanan Gigi</option>
                                                            <option value="7">7.Laboratorium</option>
                                                            <option value="8">8.USG</option>
                                                            <option value="9">9.Farmasi</option>
                                                            <option value="10">10.Lain-Lain</option>
                                                            <option value="11">11.MRI</option>
                                                            <option value="12">12.Hemodialisa</option>
                                                            <option value="0">0.Tidak Ada</option>
                                                            <option value="">None</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-3">
                                                        <label for="assesmentPel">Assesment Pelayanan</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <ul>
                                                            <li>
                                                                <input type="radio" name="assesmentPel" id="assesmentPel1" value="1">
                                                                <label for="assesmentPel1">1. Poli spesialis tidak tersedia pada hari sebelumnya</label>
                                                            </li>
                                                            <li>
                                                                <input type="radio" name="assesmentPel" id="assesmentPel2" value="2">
                                                                <label for="assesmentPel2">2. Jam Poli telah berakhir pada hari sebelumnya</label>
                                                            </li>
                                                            <li>
                                                                <input type="radio" name="assesmentPel" id="assesmentPel3" value="3">
                                                                <label for="assesmentPel3">3. Dokter Spesialis yang dimaksud tidak praktek pada hari sebelumnya</label>
                                                            </li>
                                                            <li>
                                                                <input checked type="radio" name="assesmentPel" id="assesmentPel4" value="4">
                                                                <label for="assesmentPel4">4. Atas Instruksi RS</label>
                                                            </li>
                                                            <li>
                                                                <input type="radio" name="assesmentPel" id="assesmentPel5" value="5">
                                                                <label for="assesmentPel5">5. Tujuan Kontrol</label>
                                                            </li>
                                                            <li>
                                                                <input type="radio" name="assesmentPel" id="assesmentPel0" value="0">
                                                                <label for="assesmentPel0">0. Tidak Ada</label>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-3">
                                                        <label for="user">Petugas</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" name="user" id="user" value="<?php echo "$SessionNama"; ?>" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-md-12 sub-title">
                                                <dt class="mb-3">F. Jaminan Kecelakaan</dt>
                                                <div class="row mb-3">
                                                    <div class="col-md-3">
                                                        <label for="lakaLantas">Kategori</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <ul>
                                                            <li>
                                                                <input type="radio" checked name="lakaLantas" id="lakaLantas0" value="0">
                                                                <label for="lakaLantas0">Bukan Kecelakaan lalu lintas [BKLL]</label>
                                                            </li>
                                                            <li>
                                                                <input type="radio" name="lakaLantas" id="lakaLantas1" value="1">
                                                                <label for="lakaLantas1">Kecelakaan lalu lintas dan bukan kecelakaan Kerja [BKK]</label>
                                                            </li>
                                                            <li>
                                                                <input type="radio" name="lakaLantas" id="lakaLantas2" value="2">
                                                                <label for="lakaLantas2">Kecelakaan Kerja Dan Lalulintas (KLL dan KK)</label>
                                                            </li>
                                                            <li>
                                                                <input type="radio" name="lakaLantas" id="lakaLantas3" value="3">
                                                                <label for="lakaLantas3">Kecelakaan Kerja (KK)</label>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-3">
                                                        <label for="noLP">Nomor Laporan</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" disabled name="noLP" id="noLP" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-3">
                                                        <label for="tglKejadian">Tanggal Kejadian</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="date" disabled name="tglKejadian" id="tglKejadian" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-3">
                                                        <label for="keterangan">Keterangan Kejadian</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" disabled name="keterangan" id="keterangan" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-3">
                                                        <label for="suplesi">Suplesi</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <ul>
                                                            <li>
                                                                <input disabled type="radio" name="suplesi" id="suplesi1" value="0">
                                                                <label for="suplesi1">Tidak </label>
                                                            </li>
                                                            <li>
                                                                <input disabled type="radio" name="suplesi" id="suplesi2" value="1">
                                                                <label for="suplesi2">Ya </label>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-3">
                                                        <label for="noSepSuplesi">No. SEP Suplesi</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" disabled name="noSepSuplesi" id="noSepSuplesi" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-12">
                                                        Lokasi Kejadian
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-3">
                                                        <label for="kdPropinsi">Provinsi</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <select disabled name="kdPropinsi" id="kdPropinsi" class="form-control">
                                                            <option value="">Pilih</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-3">
                                                        <label for="kdPropinsi">Kabupaten</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <select disabled name="kdKabupaten" id="kdKabupaten" class="form-control">
                                                            <option value="">Pilih</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-3">
                                                        <label for="kdKecamatan">Kecamatan</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <select disabled name="kdKecamatan" id="kdKecamatan" class="form-control">
                                                            <option value="">Pilih</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-md-12 sub-title">
                                                <dt class="mb-3">G. Poliklinik</dt>
                                                <div class="row mb-3">
                                                    <div class="col-md-3">
                                                        <label for="poli_tujuan">Poliklinik</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <select name="poli_tujuan" id="poli_tujuan" class="form-control">
                                                            <option value="">Pilih</option>
                                                            <?php
                                                                //menamilkan dari database
                                                                $query = mysqli_query($Conn, "SELECT*FROM poliklinik");
                                                                while ($data = mysqli_fetch_array($query)) {
                                                                    $id_poliklinik_list= $data['id_poliklinik'];
                                                                    $nama= $data['nama'];
                                                                    $kode= $data['kode'];
                                                                    if($id_poliklinik==$id_poliklinik_list){
                                                                        echo '<option selected value="'.$kode.'">'.$nama.'</option>';
                                                                    }else{
                                                                        echo '<option value="'.$kode.'">'.$nama.'</option>';
                                                                    }
                                                                }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-3">
                                                        <label for="eksekutif">Poliklinik Eksekutif</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <select name="eksekutif" id="eksekutif" class="form-control">
                                                            <option value="0">Tidak</option>
                                                            <option value="1">Ya</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-md-12 sub-title">
                                                <dt class="mb-3">H. Kelas Rawat</dt>
                                                <div class="row mb-3">
                                                    <div class="col-md-3"><label for="klsRawatHak">Hak Kelas</label></div>
                                                    <div class="col-md-9">
                                                        <select name="klsRawatHak" id="klsRawatHak" class="form-control">
                                                            <option value="1">Kelas 1</option>
                                                            <option value="2">Kelas 2</option>
                                                            <option value="3">Kelas 3</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-3"><label for="klsRawatNaik">Kelas Rawat Naik</label></div>
                                                    <div class="col-md-9">
                                                        <select name="klsRawatNaik" id="klsRawatNaik" class="form-control">
                                                            <option value="">Pilih</option>
                                                            <option value="1">VVIP</option>
                                                            <option value="2">VIP</option>
                                                            <option value="3">Kelas 1</option>
                                                            <option value="4">Kelas 2</option>
                                                            <option value="5">Kelas 3</option>
                                                            <option value="6">ICCU</option>
                                                            <option value="7">ICU</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-3"><label for="pembiayaan">Pembiayaan</label></div>
                                                    <div class="col-md-9">
                                                        <select disabled name="pembiayaan" id="pembiayaan" class="form-control">
                                                            <option value="">Pilih</option>
                                                            <option value="1">Pribadi</option>
                                                            <option value="2">Pemberi Kerja</option>
                                                            <option value="3">Asuransi Kesehatan Tambahan</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-3"><label for="penanggungJawab">Penanggung Jawab</label></div>
                                                    <div class="col-md-9">
                                                        <select disabled name="penanggungJawab" id="penanggungJawab" class="form-control">
                                                            <option value="">Pilih</option>
                                                            <option value="Pribadi">Pribadi</option>
                                                            <option value="Pemberi Kerja">Pemberi Kerja</option>
                                                            <option value="Asuransi Kesehatan Tambahan">Asuransi Kesehatan Tambahan</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-12" id="NotifikasiBuatSep">
                                                <span class="text-primary">
                                                    <dt>Keterangan : </dt> Pastikan Data SEP Yang Anda Input Sudah Benar!
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            <i class="ti-save"></i> Simpan SEP
                                        </button>
                                        <button type="reset" class="btn btn-sm btn-secondary">
                                            <i class="ti-back-left"></i> Reset Form
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php 
    } 
    //Hapus Session URL back
    $_SESSION['UrlBackSep']="";
?>