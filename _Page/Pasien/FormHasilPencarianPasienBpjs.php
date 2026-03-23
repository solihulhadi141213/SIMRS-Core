<?php
    ini_set("display_errors","off");
    date_default_timezone_set('UTC');
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/SettingBridging.php";
    include "../../vendor/autoload.php";
    include "../../_Config/SimrsFunction.php";
    //Menangkap DasarPencarianPasienBpjs
    if(empty($_POST['DasarPencarianPasienBpjs'])){
        echo '<div class="row">';
        echo '<div class="col-md-12 text-center"><span class="text-danger">Anda Harus Memilih Dasar Pencarian Terlebih Dulu</span></div>';
        echo '</div>';
    }else{
        if(empty($_POST['keyword'])){
            echo '<div class="row">';
            echo '<div class="col-md-12 text-center"><span class="text-danger">Keyword Tidak Boleh Kosong!</span></div>';
            echo '</div>';
        }else{
            $DasarPencarianPasienBpjs=$_POST['DasarPencarianPasienBpjs'];
            $keyword=$_POST['keyword'];
            if($DasarPencarianPasienBpjs=="NIK"){
                $response=PesertaByNik($url_vclaim,$consid,$secret_key,$user_key,$keyword);
            }else{
                $response=PesertaByNoKa($url_vclaim,$consid,$secret_key,$user_key,$keyword);
            }
            // echo "$response";
            $ambil_json =json_decode($response, true);
            if($ambil_json["metaData"]["code"]!=="200"){
                $PesanService=$ambil_json["metaData"]["message"];
                $code=$ambil_json["metaData"]["code"];
                echo '<div class="row">';
                echo '<div class="col-md-12 text-center"><span class="text-danger">'.$code.'-'.$PesanService.'</span></div>';
                echo '</div>';
            }else{
                $string=$ambil_json["response"];
                //Proses decode dan dekompresi
                $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
                //--membuat key
                $key="$consid$secret_key$timestamp";
                //--masukan ke fungsi
                $FileDeskripsi=stringDecrypt("$key", "$string");
                $FileDekompresi=decompress("$FileDeskripsi");
                //--konveris json to raw
                $JsonData =json_decode($FileDekompresi, true);
                //Peserta
                if(empty($JsonData["peserta"]["nama"])){
                    $nama="";
                }else{
                    $nama=$JsonData["peserta"]["nama"];
                }
                
                $nik=$JsonData["peserta"]["nik"];
                $noKartu=$JsonData["peserta"]["noKartu"];
                $pisa=$JsonData["peserta"]["pisa"];
                $sex=$JsonData["peserta"]["sex"];
                $tglCetakKartu=$JsonData["peserta"]["tglCetakKartu"];
                $tglLahir=$JsonData["peserta"]["tglLahir"];
                $tglTAT=$JsonData["peserta"]["tglTAT"];
                $tglTMT=$JsonData["peserta"]["tglTMT"];
                //COB
                $nmAsuransi=$JsonData["peserta"]["cob"]["nmAsuransi"];
                $noAsuransi=$JsonData["peserta"]["cob"]["noAsuransi"];
                $tglTATCob=$JsonData["peserta"]["cob"]["tglTAT"];
                $tglTMTCob=$JsonData["peserta"]["cob"]["tglTMT"];
                //hakKelas
                $hakKelasketerangan=$JsonData["peserta"]["hakKelas"]["keterangan"];
                $hakKelaskode=$JsonData["peserta"]["hakKelas"]["kode"];
                //informasi
                $dinsos=$JsonData["peserta"]["informasi"]["dinsos"];
                $noSKTM=$JsonData["peserta"]["informasi"]["noSKTM"];
                $prolanisPRB=$JsonData["peserta"]["informasi"]["prolanisPRB"];
                //jenisPeserta
                $jenisPesertaketerangan=$JsonData["peserta"]["jenisPeserta"]["keterangan"];
                $jenisPesertakode=$JsonData["peserta"]["jenisPeserta"]["kode"];
                //mr
                $noMR=$JsonData["peserta"]["mr"]["noMR"];
                $noTelepon=$JsonData["peserta"]["mr"]["noTelepon"];
                //provUmum
                $kdProvider=$JsonData["peserta"]["provUmum"]["kdProvider"];
                $nmProvider=$JsonData["peserta"]["provUmum"]["nmProvider"];
                //statusPeserta
                $statusPesertaketerangan=$JsonData["peserta"]["statusPeserta"]["keterangan"];
                $statusPesertakode=$JsonData["peserta"]["statusPeserta"]["kode"];
                //umur
                $umurSaatPelayanan=$JsonData["peserta"]["umur"]["umurSaatPelayanan"];
                $umurSekarang=$JsonData["peserta"]["umur"]["umurSekarang"];
                if(!empty($nama)){
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-6"><dt>Nama</dt></div>';
                    echo '  <div class="col-md-6 text-left"><small>'.$nama.'</small></div>';
                    echo '</div>';
                }
                if(!empty($nik)){
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-6"><dt>NIK</dt></div>';
                    echo '  <div class="col-md-6 text-left"><small>'.$nik.'</small></div>';
                    echo '</div>';
                }
                if(!empty($noKartu)){
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-6"><dt>No.Kartu</dt></div>';
                    echo '  <div class="col-md-6 text-left"><small>'.$noKartu.'</small></div>';
                    echo '</div>';
                }
                if(!empty($pisa)){
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-6"><dt>Pisa</dt></div>';
                    echo '  <div class="col-md-6 text-left"><small>'.$pisa.'</small></div>';
                    echo '</div>';
                }
                if(!empty($sex)){
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-6"><dt>Gender</dt></div>';
                    echo '  <div class="col-md-6 text-left"><small>'.$sex.'</small></div>';
                    echo '</div>';
                }
                if(!empty($tglCetakKartu)){
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-6"><dt>Cetak Kartu</dt></div>';
                    echo '  <div class="col-md-6 text-left"><small>'.$tglCetakKartu.'</small></div>';
                    echo '</div>';
                }
                if(!empty($tglLahir)){
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-6"><dt>Tanggal Lahir</dt></div>';
                    echo '  <div class="col-md-6 text-left"><small>'.$tglLahir.'</small></div>';
                    echo '</div>';
                }
                if(!empty($tglTAT)){
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-6"><dt>Tanggal TAT</dt></div>';
                    echo '  <div class="col-md-6 text-left"><small>'.$tglTAT.'</small></div>';
                    echo '</div>';
                }
                if(!empty($tglTMT)){
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-6"><dt>Tanggal TMT</dt></div>';
                    echo '  <div class="col-md-6 text-left"><small>'.$tglTMT.'</small></div>';
                    echo '</div>';
                }
                if(!empty($nmAsuransi)){
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-6"><dt>Nama Asuransi</dt></div>';
                    echo '  <div class="col-md-6 text-left"><small>'.$nmAsuransi.'</small></div>';
                    echo '</div>';
                }
                if(!empty($noAsuransi)){
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-6"><dt>Nomor Asuransi</dt></div>';
                    echo '  <div class="col-md-6 text-left"><small>'.$noAsuransi.'</small></div>';
                    echo '</div>';
                }
                if(!empty($tglTATCob)){
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-6"><dt>TAT Cob</dt></div>';
                    echo '  <div class="col-md-6 text-left"><small>'.$tglTATCob.'</small></div>';
                    echo '</div>';
                }
                if(!empty($tglTMTCob)){
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-6"><dt>TMT Cob</dt></div>';
                    echo '  <div class="col-md-6 text-left"><small>'.$tglTMTCob.'</small></div>';
                    echo '</div>';
                }
                if(!empty($hakKelasketerangan)){
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-6"><dt>Hak Kelas</dt></div>';
                    echo '  <div class="col-md-6 text-left"><small>'.$hakKelasketerangan.'</small></div>';
                    echo '</div>';
                }
                if(!empty($hakKelaskode)){
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-6"><dt>Kode Kelas</dt></div>';
                    echo '  <div class="col-md-6 text-left"><small>'.$hakKelaskode.'</small></div>';
                    echo '</div>';
                }
                if(!empty($dinsos)){
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-6"><dt>Dinsos</dt></div>';
                    echo '  <div class="col-md-6 text-left"><small>'.$dinsos.'</small></div>';
                    echo '</div>';
                }
                if(!empty($noSKTM)){
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-6"><dt>NO.SKTM</dt></div>';
                    echo '  <div class="col-md-6 text-left"><small>'.$noSKTM.'</small></div>';
                    echo '</div>';
                }
                if(!empty($prolanisPRB)){
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-6"><dt>Prolansi PRB</dt></div>';
                    echo '  <div class="col-md-6 text-left"><small>'.$prolanisPRB.'</small></div>';
                    echo '</div>';
                }
                if(!empty($jenisPesertaketerangan)){
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-6"><dt>Jenis Peserta</dt></div>';
                    echo '  <div class="col-md-6 text-left"><small>'.$jenisPesertaketerangan.'</small></div>';
                    echo '</div>';
                }
                if(!empty($jenisPesertakode)){
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-6"><dt>Kode Peserta</dt></div>';
                    echo '  <div class="col-md-6 text-left"><small>'.$jenisPesertakode.'</small></div>';
                    echo '</div>';
                }
                if(!empty($noMR)){
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-6"><dt>No.RM</dt></div>';
                    echo '  <div class="col-md-6 text-left"><small>'.$noMR.'</small></div>';
                    echo '</div>';
                }
                if(!empty($noTelepon)){
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-6"><dt>No.Kontak</dt></div>';
                    echo '  <div class="col-md-6 text-left"><small>'.$noTelepon.'</small></div>';
                    echo '</div>';
                }
                if(!empty($kdProvider)){
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-6"><dt>Provider</dt></div>';
                    echo '  <div class="col-md-6 text-left"><small>'.$nmProvider.' ('.$kdProvider.')</small></div>';
                    echo '</div>';
                }
                if(!empty($statusPesertaketerangan)){
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-6"><dt>Status Peserta</dt></div>';
                    echo '  <div class="col-md-6 text-left"><small>'.$statusPesertaketerangan.' ('.$statusPesertakode.')</small></div>';
                    echo '</div>';
                }
                if(!empty($umurSaatPelayanan)){
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-6"><dt>Usia (Saat Pelayanan)</dt></div>';
                    echo '  <div class="col-md-6 text-left"><small>'.$umurSaatPelayanan.'</small></div>';
                    echo '</div>';
                }
                if(!empty($umurSekarang)){
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-6"><dt>Usia (Sekarang)</dt></div>';
                    echo '  <div class="col-md-6 text-left"><small>'.$umurSekarang.'</small></div>';
                    echo '</div>';
                }
            }
        }
    }
?>