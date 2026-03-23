<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingBridging.php";
    include "../../vendor/autoload.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap jenisreferensi
    if(empty($_POST['jenisreferensi'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 mb-3 text-center text-danger">';
        echo '      Jenis Referensi Tidak Boleh Kosong!!.';
        echo '  </div>';
        echo '</div>';
    }else{
        if(empty($_POST['nomorreferensi'])){
            echo '<div class="row">';
            echo '  <div class="col-md-12 mb-3 text-center text-danger">';
            echo '      Nama Referensi Tidak Boleh Kosong!!.';
            echo '  </div>';
            echo '</div>';
        }else{
            $jenisreferensi=$_POST['jenisreferensi'];
            $nomorreferensi=$_POST['nomorreferensi'];
            if($jenisreferensi=="1"){
                $url ="$url_vclaim/Rujukan/$nomorreferensi";
                $response=DetailReferensi($url_antrol,$consid,$secret_key,$user_key,$url,$nomorreferensi);
            }else{
                if($jenisreferensi=="2"){
                    $url ="$url_vclaim/RencanaKontrol/noSuratKontrol/$nomorreferensi";
                    $response=DetailReferensi($url_antrol,$consid,$secret_key,$user_key,$url,$nomorreferensi);
                }else{
                    if($jenisreferensi=="3"){
                        $url ="$url_vclaim/RencanaKontrol/noSuratKontrol/$nomorreferensi";
                        $response=DetailReferensi($url_antrol,$consid,$secret_key,$user_key,$url,$nomorreferensi);
                    }else{
                        if($jenisreferensi=="4"){
                            $url ="$url_vclaim/Rujukan/RS/$nomorreferensi";
                            $response=DetailReferensi($url_antrol,$consid,$secret_key,$user_key,$url,$nomorreferensi);
                        }else{
                            $response="";
                        }
                    }
                }
            }
            if(empty($response)){
                echo '<div class="row">';
                echo '  <div class="col-md-12 text-danger text-center">';
                echo '      Tidak Ada Response Dari Service Bridging BPJS!';
                echo '  </div>';
                echo '</div>';
            }else{
                $ambil_json =json_decode($response, true);
                if(empty($ambil_json["metaData"])){
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-12 text-danger text-center">';
                    echo '      Kesalahan Tidak Diketahui!';
                    echo '  </div>';
                    echo '</div>';
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-12 text-center text-danger">';
                    echo '      '.$response.'';
                    echo '  </div>';
                    echo '</div>';
                }else{
                    if(empty($ambil_json["metaData"]["code"])){
                        echo '<div class="row mb-3">';
                        echo '  <div class="col-md-12 text-danger text-center">';
                        echo '      Kesalahan Tidak Diketahui!';
                        echo '  </div>';
                        echo '</div>';
                        echo '<div class="row mb-3">';
                        echo '  <div class="col-md-12 text-center text-danger">';
                        echo '      '.$response.'';
                        echo '  </div>';
                        echo '</div>';
                    }else{
                        if($ambil_json["metaData"]["code"]!=="200"){
                            if(empty($ambil_json["metaData"]["message"])){
                                echo '<div class="row mb-3">';
                                echo '  <div class="col-md-12 text-center text-danger">';
                                echo '      '.$response.'';
                                echo '  </div>';
                                echo '</div>';
                            }else{
                                $PesanService=$ambil_json["metaData"]["message"];
                                $code=$ambil_json["metaData"]["code"];
                                echo '<div class="row mb-3">';
                                echo '<div class="col-md-12 text-center text-danger"><span class="text-danger">'.$code.'-'.$PesanService.'</span></div>';
                                echo '</div>';
                            }
                        }else{
                            if(empty($ambil_json["response"])){
                                echo '<div class="row mb-3">';
                                echo '  <div class="col-md-12 text-center text-danger">';
                                echo '      Response Kosong! Atau Data Tidak Ditemukan Sama Sekali!';
                                echo '  </div>';
                                echo '</div>';
                            }else{
                                $string=$ambil_json["response"];
                                $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
                                $key="$consid$secret_key$timestamp";
                                //--masukan ke fungsi
                                $FileDeskripsi=stringDecrypt("$key", "$string");
                                $FileDekompresi=decompress("$FileDeskripsi");
                                //--konveris json to raw
                                $JsonData =json_decode($FileDekompresi, true);
                                if(empty($JsonData)){
                                    echo '<div class="row mb-3">';
                                    echo '  <div class="col-md-12 text-center text-danger">';
                                    echo '      Data Tidak Ditemukan!';
                                    echo '  </div>';
                                    echo '</div>';
                                }else{
                                    if($jenisreferensi=="1"||$jenisreferensi=="4"){
                                        if(empty($JsonData['rujukan'])){
                                            echo '<div class="row mb-3">';
                                            echo '  <div class="col-md-12 text-center text-danger">';
                                            echo '      Rujukan Data Tidak Ditemukan!';
                                            echo '  </div>';
                                            echo '</div>';
                                        }else{
                                            if(!empty($JsonData['rujukan']['diagnosa']['kode'])){
                                                $kodediagnosa=$JsonData['rujukan']['diagnosa']['kode'];
                                            }else{
                                                $kodediagnosa='<span class="text-danger">Tidak Ada</span>';
                                            }
                                            if(!empty($JsonData['rujukan']['diagnosa']['nama'])){
                                                $namadiagnosa=$JsonData['rujukan']['diagnosa']['nama'];
                                            }else{
                                                $namadiagnosa='<span class="text-danger">Tidak Ada</span>';
                                            }
                                            if(!empty($JsonData['rujukan']['keluhan'])){
                                                $keluhan=$JsonData['rujukan']['keluhan'];
                                            }else{
                                                $keluhan='<span class="text-danger">Tidak Ada</span>';
                                            }
                                            if(!empty($JsonData['rujukan']['noKunjungan'])){
                                                $noKunjungan=$JsonData['rujukan']['noKunjungan'];
                                            }else{
                                                $noKunjungan='<span class="text-danger">Tidak Ada</span>';
                                            }
                                            if(!empty($JsonData['rujukan']['pelayanan']['kode'])){
                                                $kodepelayanan=$JsonData['rujukan']['pelayanan']['kode'];
                                            }else{
                                                $kodepelayanan='<span class="text-danger">Tidak Ada</span>';
                                            }
                                            if(!empty($JsonData['rujukan']['pelayanan']['nama'])){
                                                $namapelayanan=$JsonData['rujukan']['pelayanan']['nama'];
                                            }else{
                                                $namapelayanan='<span class="text-danger">Tidak Ada</span>';
                                            }
                                            if(!empty($JsonData['rujukan']['poliRujukan']['kode'])){
                                                $kodepolirujikan=$JsonData['rujukan']['poliRujukan']['kode'];
                                            }else{
                                                $kodepolirujikan='<span class="text-danger">Tidak Ada</span>';
                                            }
                                            if(!empty($JsonData['rujukan']['poliRujukan']['nama'])){
                                                $namapolirujikan=$JsonData['rujukan']['poliRujukan']['nama'];
                                            }else{
                                                $namapolirujikan='<span class="text-danger">Tidak Ada</span>';
                                            }
                                            if(!empty($JsonData['rujukan']['provPerujuk']['kode'])){
                                                $kodeproviderperujuk=$JsonData['rujukan']['provPerujuk']['kode'];
                                            }else{
                                                $kodeproviderperujuk='<span class="text-danger">Tidak Ada</span>';
                                            }
                                            if(!empty($JsonData['rujukan']['provPerujuk']['nama'])){
                                                $namaproviderperujuk=$JsonData['rujukan']['provPerujuk']['nama'];
                                            }else{
                                                $namaproviderperujuk='<span class="text-danger">Tidak Ada</span>';
                                            }
                                            if(!empty($JsonData['rujukan']['tglKunjungan'])){
                                                $tglKunjungan=$JsonData['rujukan']['tglKunjungan'];
                                            }else{
                                                $tglKunjungan='<span class="text-danger">Tidak Ada</span>';
                                            }
                                            if(!empty($JsonData['rujukan']['peserta']['cob']['nmAsuransi'])){
                                                $nmAsuransi=$JsonData['rujukan']['peserta']['cob']['nmAsuransi'];
                                            }else{
                                                $nmAsuransi='<span class="text-danger">Tidak Ada</span>';
                                            }
                                            if(!empty($JsonData['rujukan']['peserta']['cob']['noAsuransi'])){
                                                $noAsuransi=$JsonData['rujukan']['peserta']['cob']['noAsuransi'];
                                            }else{
                                                $noAsuransi='<span class="text-danger">Tidak Ada</span>';
                                            }
                                            if(!empty($JsonData['rujukan']['peserta']['cob']['tglTAT'])){
                                                $tglTAT=$JsonData['rujukan']['peserta']['cob']['tglTAT'];
                                            }else{
                                                $tglTAT='<span class="text-danger">Tidak Ada</span>';
                                            }
                                            if(!empty($JsonData['rujukan']['peserta']['cob']['tglTMT'])){
                                                $tglTMT=$JsonData['rujukan']['peserta']['cob']['tglTMT'];
                                            }else{
                                                $tglTMT='<span class="text-danger">Tidak Ada</span>';
                                            }
                                            if(!empty($JsonData['rujukan']['peserta']['hakKelas']['keterangan'])){
                                                $keteranganhakkelas=$JsonData['rujukan']['peserta']['hakKelas']['keterangan'];
                                            }else{
                                                $keteranganhakkelas='<span class="text-danger">Tidak Ada</span>';
                                            }
                                            if(!empty($JsonData['rujukan']['peserta']['hakKelas']['kode'])){
                                                $kodehakkelas=$JsonData['rujukan']['peserta']['hakKelas']['kode'];
                                            }else{
                                                $kodehakkelas='<span class="text-danger">Tidak Ada</span>';
                                            }
                                            if(!empty($JsonData['rujukan']['peserta']['informasi']['dinsos'])){
                                                $informasidinsos=$JsonData['rujukan']['peserta']['informasi']['informasi'];
                                            }else{
                                                $informasidinsos='<span class="text-danger">Tidak Ada</span>';
                                            }
                                            if(!empty($JsonData['rujukan']['peserta']['informasi']['noSKTM'])){
                                                $noSKTM=$JsonData['rujukan']['peserta']['informasi']['noSKTM'];
                                            }else{
                                                $noSKTM='<span class="text-danger">Tidak Ada</span>';
                                            }
                                            if(!empty($JsonData['rujukan']['peserta']['informasi']['prolanisPRB'])){
                                                $prolanisPRB=$JsonData['rujukan']['peserta']['informasi']['prolanisPRB'];
                                            }else{
                                                $prolanisPRB='<span class="text-danger">Tidak Ada</span>';
                                            }
                                            if(!empty($JsonData['rujukan']['peserta']['jenisPeserta']['keterangan'])){
                                                $keteranganjenispeserta=$JsonData['rujukan']['peserta']['jenisPeserta']['keterangan'];
                                            }else{
                                                $keteranganjenispeserta='<span class="text-danger">Tidak Ada</span>';
                                            }
                                            if(!empty($JsonData['rujukan']['peserta']['jenisPeserta']['kode'])){
                                                $kodejenispeserta=$JsonData['rujukan']['peserta']['jenisPeserta']['kode'];
                                            }else{
                                                $kodejenispeserta='<span class="text-danger">Tidak Ada</span>';
                                            }
                                            if(!empty($JsonData['rujukan']['peserta']['mr']['noMR'])){
                                                $noMR=$JsonData['rujukan']['peserta']['mr']['noMR'];
                                            }else{
                                                $noMR='<span class="text-danger">Tidak Ada</span>';
                                            }
                                            if(!empty($JsonData['rujukan']['peserta']['mr']['noTelepon'])){
                                                $noTelepon=$JsonData['rujukan']['peserta']['mr']['noTelepon'];
                                            }else{
                                                $noTelepon='<span class="text-danger">Tidak Ada</span>';
                                            }
                                            if(!empty($JsonData['rujukan']['peserta']['nama'])){
                                                $namapeserta=$JsonData['rujukan']['peserta']['nama'];
                                            }else{
                                                $namapeserta='<span class="text-danger">Tidak Ada</span>';
                                            }
                                            if(!empty($JsonData['rujukan']['peserta']['nik'])){
                                                $nikpeserta=$JsonData['rujukan']['peserta']['nik'];
                                            }else{
                                                $nikpeserta='<span class="text-danger">Tidak Ada</span>';
                                            }
                                            if(!empty($JsonData['rujukan']['peserta']['noKartu'])){
                                                $noKartu=$JsonData['rujukan']['peserta']['noKartu'];
                                            }else{
                                                $noKartu='<span class="text-danger">Tidak Ada</span>';
                                            }
                                            if(!empty($JsonData['rujukan']['peserta']['pisa'])){
                                                $pisa=$JsonData['rujukan']['peserta']['pisa'];
                                            }else{
                                                $pisa='<span class="text-danger">Tidak Ada</span>';
                                            }
                                            if(!empty($JsonData['rujukan']['peserta']['provUmum']['kdProvider'])){
                                                $kdProvider=$JsonData['rujukan']['peserta']['provUmum']['kdProvider'];
                                            }else{
                                                $kdProvider='<span class="text-danger">Tidak Ada</span>';
                                            }
                                            if(!empty($JsonData['rujukan']['peserta']['provUmum']['nmProvider'])){
                                                $nmProvider=$JsonData['rujukan']['peserta']['provUmum']['nmProvider'];
                                            }else{
                                                $nmProvider='<span class="text-danger">Tidak Ada</span>';
                                            }
                                            if(!empty($JsonData['rujukan']['peserta']['sex'])){
                                                $sex=$JsonData['rujukan']['peserta']['sex'];
                                            }else{
                                                $sex='<span class="text-danger">Tidak Ada</span>';
                                            }
                                            if(!empty($JsonData['rujukan']['peserta']['statusPeserta']['keterangan'])){
                                                $keteranganstatusPeserta=$JsonData['rujukan']['peserta']['statusPeserta']['keterangan'];
                                            }else{
                                                $keteranganstatusPeserta='<span class="text-danger">Tidak Ada</span>';
                                            }
                                            if(!empty($JsonData['rujukan']['peserta']['statusPeserta']['kode'])){
                                                $kodestatusPeserta=$JsonData['rujukan']['peserta']['statusPeserta']['kode'];
                                            }else{
                                                $kodestatusPeserta='<span class="text-danger">Tidak Ada</span>';
                                            }
                                            if(!empty($JsonData['rujukan']['peserta']['tglCetakKartu'])){
                                                $tglCetakKartu=$JsonData['rujukan']['peserta']['tglCetakKartu'];
                                            }else{
                                                $tglCetakKartu='<span class="text-danger">Tidak Ada</span>';
                                            }
                                            if(!empty($JsonData['rujukan']['peserta']['tglLahir'])){
                                                $tglLahir=$JsonData['rujukan']['peserta']['tglLahir'];
                                            }else{
                                                $tglLahir='<span class="text-danger">Tidak Ada</span>';
                                            }
                                            if(!empty($JsonData['rujukan']['peserta']['tglTAT'])){
                                                $pesertatglTAT=$JsonData['rujukan']['peserta']['tglTAT'];
                                            }else{
                                                $pesertatglTAT='<span class="text-danger">Tidak Ada</span>';
                                            }
                                            if(!empty($JsonData['rujukan']['peserta']['tglTMT'])){
                                                $pesertatglTMT=$JsonData['rujukan']['peserta']['tglTMT'];
                                            }else{
                                                $pesertatglTMT='<span class="text-danger">Tidak Ada</span>';
                                            }
                                            if(!empty($JsonData['rujukan']['peserta']['umur']['umurSaatPelayanan'])){
                                                $umurSaatPelayanan=$JsonData['rujukan']['peserta']['umur']['umurSaatPelayanan'];
                                            }else{
                                                $umurSaatPelayanan='<span class="text-danger">Tidak Ada</span>';
                                            }
                                            if(!empty($JsonData['rujukan']['peserta']['umur']['umurSekarang'])){
                                                $umurSekarang=$JsonData['rujukan']['peserta']['umur']['umurSekarang'];
                                            }else{
                                                $umurSekarang='<span class="text-danger">Tidak Ada</span>';
                                            }
                                            echo '<div class="row mb-3">';
                                            echo '  <div class="col-md-6"><dt>Kode Diagnosa</dt></div>';
                                            echo '  <div class="col-md-6"><small>'.$kodediagnosa.'</small></div>';
                                            echo '</div>';
                                            echo '<div class="row mb-3">';
                                            echo '  <div class="col-md-6"><dt>Nama Diagnosa</dt></div>';
                                            echo '  <div class="col-md-6"><small>'.$namadiagnosa.'</small></div>';
                                            echo '</div>';
                                            echo '<div class="row mb-3">';
                                            echo '  <div class="col-md-6"><dt>Keluhan</dt></div>';
                                            echo '  <div class="col-md-6"><small>'.$keluhan.'</small></div>';
                                            echo '</div>';
                                            echo '<div class="row mb-3">';
                                            echo '  <div class="col-md-6"><dt>No.Kunjungan</dt></div>';
                                            echo '  <div class="col-md-6"><small>'.$noKunjungan.'</small></div>';
                                            echo '</div>';
                                            echo '<div class="row mb-3">';
                                            echo '  <div class="col-md-6"><dt>Kode Pelayanan</dt></div>';
                                            echo '  <div class="col-md-6"><small>'.$kodepelayanan.'</small></div>';
                                            echo '</div>';
                                            echo '<div class="row mb-3">';
                                            echo '  <div class="col-md-6"><dt>Nama Pelayanan</dt></div>';
                                            echo '  <div class="col-md-6"><small>'.$namapelayanan.'</small></div>';
                                            echo '</div>';
                                            echo '<div class="row mb-3">';
                                            echo '  <div class="col-md-6"><dt>Kode Poli</dt></div>';
                                            echo '  <div class="col-md-6"><small>'.$kodepolirujikan.'</small></div>';
                                            echo '</div>';
                                            echo '<div class="row mb-3">';
                                            echo '  <div class="col-md-6"><dt>Nama Poli</dt></div>';
                                            echo '  <div class="col-md-6"><small>'.$namapolirujikan.'</small></div>';
                                            echo '</div>';
                                            echo '<div class="row mb-3">';
                                            echo '  <div class="col-md-6"><dt>Provider Perujuk</dt></div>';
                                            echo '  <div class="col-md-6"><small>'.$kodeproviderperujuk.'-'.$namaproviderperujuk.'</small></div>';
                                            echo '</div>';
                                            echo '<div class="row mb-3">';
                                            echo '  <div class="col-md-6"><dt>Tanggal Kunjungan</dt></div>';
                                            echo '  <div class="col-md-6"><small>'.$tglKunjungan.'</small></div>';
                                            echo '</div>';
                                            echo '<div class="row mb-3">';
                                            echo '  <div class="col-md-6"><dt>Nama Asuransi</dt></div>';
                                            echo '  <div class="col-md-6"><small>'.$nmAsuransi.'</small></div>';
                                            echo '</div>';
                                            echo '<div class="row mb-3">';
                                            echo '  <div class="col-md-6"><dt>No Asuransi</dt></div>';
                                            echo '  <div class="col-md-6"><small>'.$noAsuransi.'</small></div>';
                                            echo '</div>';
                                            echo '<div class="row mb-3">';
                                            echo '  <div class="col-md-6"><dt>Tanggal TAT</dt></div>';
                                            echo '  <div class="col-md-6"><small>'.$tglTAT.'</small></div>';
                                            echo '</div>';
                                            echo '<div class="row mb-3">';
                                            echo '  <div class="col-md-6"><dt>Tanggal TMT</dt></div>';
                                            echo '  <div class="col-md-6"><small>'.$tglTMT.'</small></div>';
                                            echo '</div>';
                                            echo '<div class="row mb-3">';
                                            echo '  <div class="col-md-6"><dt>Kelas</dt></div>';
                                            echo '  <div class="col-md-6"><small>'.$keteranganhakkelas.'</small></div>';
                                            echo '</div>';
                                            echo '<div class="row mb-3">';
                                            echo '  <div class="col-md-6"><dt>Kode Kelas</dt></div>';
                                            echo '  <div class="col-md-6"><small>'.$kodehakkelas.'</small></div>';
                                            echo '</div>';
                                            echo '<div class="row mb-3">';
                                            echo '  <div class="col-md-6"><dt>Dinsos</dt></div>';
                                            echo '  <div class="col-md-6"><small>'.$informasidinsos.'</small></div>';
                                            echo '</div>';
                                            echo '<div class="row mb-3">';
                                            echo '  <div class="col-md-6"><dt>No.SKTM</dt></div>';
                                            echo '  <div class="col-md-6"><small>'.$noSKTM.'</small></div>';
                                            echo '</div>';
                                            echo '<div class="row mb-3">';
                                            echo '  <div class="col-md-6"><dt>PRB</dt></div>';
                                            echo '  <div class="col-md-6"><small>'.$prolanisPRB.'</small></div>';
                                            echo '</div>';
                                            echo '<div class="row mb-3">';
                                            echo '  <div class="col-md-6"><dt>Peserta</dt></div>';
                                            echo '  <div class="col-md-6"><small>'.$keteranganjenispeserta.'</small></div>';
                                            echo '</div>';
                                            echo '<div class="row mb-3">';
                                            echo '  <div class="col-md-6"><dt>Kode Peserta</dt></div>';
                                            echo '  <div class="col-md-6"><small>'.$kodejenispeserta.'</small></div>';
                                            echo '</div>';
                                            echo '<div class="row mb-3">';
                                            echo '  <div class="col-md-6"><dt>No.RM</dt></div>';
                                            echo '  <div class="col-md-6"><small>'.$noMR.'</small></div>';
                                            echo '</div>';
                                            echo '<div class="row mb-3">';
                                            echo '  <div class="col-md-6"><dt>No.Kontak</dt></div>';
                                            echo '  <div class="col-md-6"><small>'.$noTelepon.'</small></div>';
                                            echo '</div>';
                                            echo '<div class="row mb-3">';
                                            echo '  <div class="col-md-6"><dt>Nama Peserta</dt></div>';
                                            echo '  <div class="col-md-6"><small>'.$namapeserta.'</small></div>';
                                            echo '</div>';
                                            echo '<div class="row mb-3">';
                                            echo '  <div class="col-md-6"><dt>NIK</dt></div>';
                                            echo '  <div class="col-md-6"><small>'.$nikpeserta.'</small></div>';
                                            echo '</div>';
                                            echo '<div class="row mb-3">';
                                            echo '  <div class="col-md-6"><dt>No.Kartu</dt></div>';
                                            echo '  <div class="col-md-6"><small>'.$noKartu.'</small></div>';
                                            echo '</div>';
                                            echo '<div class="row mb-3">';
                                            echo '  <div class="col-md-6"><dt>Pisa</dt></div>';
                                            echo '  <div class="col-md-6"><small>'.$pisa.'</small></div>';
                                            echo '</div>';
                                            echo '<div class="row mb-3">';
                                            echo '  <div class="col-md-6"><dt>Provider Peserta</dt></div>';
                                            echo '  <div class="col-md-6"><small>'.$kdProvider.'-'.$nmProvider.'</small></div>';
                                            echo '</div>';
                                            echo '<div class="row mb-3">';
                                            echo '  <div class="col-md-6"><dt>Gender</dt></div>';
                                            echo '  <div class="col-md-6"><small>'.$sex.'</small></div>';
                                            echo '</div>';
                                            echo '<div class="row mb-3">';
                                            echo '  <div class="col-md-6"><dt>Status Peserta</dt></div>';
                                            echo '  <div class="col-md-6"><small>'.$kodestatusPeserta.'-'.$keteranganstatusPeserta.'</small></div>';
                                            echo '</div>';
                                            echo '<div class="row mb-3">';
                                            echo '  <div class="col-md-6"><dt>Tanggal Cetak Kartu</dt></div>';
                                            echo '  <div class="col-md-6"><small>'.$tglCetakKartu.'</small></div>';
                                            echo '</div>';
                                            echo '<div class="row mb-3">';
                                            echo '  <div class="col-md-6"><dt>Tanggal Lahir</dt></div>';
                                            echo '  <div class="col-md-6"><small>'.$tglLahir.'</small></div>';
                                            echo '</div>';
                                            echo '<div class="row mb-3">';
                                            echo '  <div class="col-md-6"><dt>Tanggal TAT</dt></div>';
                                            echo '  <div class="col-md-6"><small>'.$pesertatglTAT.'</small></div>';
                                            echo '</div>';
                                            echo '<div class="row mb-3">';
                                            echo '  <div class="col-md-6"><dt>Tanggal TMT</dt></div>';
                                            echo '  <div class="col-md-6"><small>'.$pesertatglTMT.'</small></div>';
                                            echo '</div>';
                                            echo '<div class="row mb-3">';
                                            echo '  <div class="col-md-6"><dt>Usia</dt></div>';
                                            echo '  <div class="col-md-6"><small>'.$umurSaatPelayanan.'/'.$umurSekarang.'</small></div>';
                                            echo '</div>';
                                        }
                                    }else{
                                        if(!empty($JsonData['noSuratKontrol'])){
                                            $noSuratKontrol=$JsonData['noSuratKontrol'];
                                        }else{
                                            $noSuratKontrol='<span class="text-danger">Tidak Ada</span>';
                                        }
                                        if(!empty($JsonData['tglRencanaKontrol'])){
                                            $tglRencanaKontrol=$JsonData['tglRencanaKontrol'];
                                        }else{
                                            $tglRencanaKontrol='<span class="text-danger">Tidak Ada</span>';
                                        }
                                        if(!empty($JsonData['tglTerbit'])){
                                            $tglTerbit=$JsonData['tglTerbit'];
                                        }else{
                                            $tglTerbit='<span class="text-danger">Tidak Ada</span>';
                                        }
                                        if(!empty($JsonData['jnsKontrol'])){
                                            $jnsKontrol=$JsonData['jnsKontrol'];
                                        }else{
                                            $jnsKontrol='<span class="text-danger">Tidak Ada</span>';
                                        }
                                        if(!empty($JsonData['poliTujuan'])){
                                            $poliTujuan=$JsonData['poliTujuan'];
                                        }else{
                                            $poliTujuan='<span class="text-danger">Tidak Ada</span>';
                                        }
                                        if(!empty($JsonData['namaPoliTujuan'])){
                                            $namaPoliTujuan=$JsonData['namaPoliTujuan'];
                                        }else{
                                            $namaPoliTujuan='<span class="text-danger">Tidak Ada</span>';
                                        }
                                        if(!empty($JsonData['kodeDokter'])){
                                            $kodeDokter=$JsonData['kodeDokter'];
                                        }else{
                                            $kodeDokter='<span class="text-danger">Tidak Ada</span>';
                                        }
                                        if(!empty($JsonData['namaDokter'])){
                                            $namaDokter=$JsonData['namaDokter'];
                                        }else{
                                            $namaDokter='<span class="text-danger">Tidak Ada</span>';
                                        }
                                        if(!empty($JsonData['flagKontrol'])){
                                            $flagKontrol=$JsonData['flagKontrol'];
                                        }else{
                                            $flagKontrol='<span class="text-danger">Tidak Ada</span>';
                                        }
                                        if(!empty($JsonData['kodeDokterPembuat'])){
                                            $kodeDokterPembuat=$JsonData['kodeDokterPembuat'];
                                        }else{
                                            $kodeDokterPembuat='<span class="text-danger">Tidak Ada</span>';
                                        }
                                        if(!empty($JsonData['namaDokterPembuat'])){
                                            $namaDokterPembuat=$JsonData['namaDokterPembuat'];
                                        }else{
                                            $namaDokterPembuat='<span class="text-danger">Tidak Ada</span>';
                                        }
                                        if(!empty($JsonData['namaJnsKontrol'])){
                                            $namaJnsKontrol=$JsonData['namaJnsKontrol'];
                                        }else{
                                            $namaJnsKontrol='<span class="text-danger">Tidak Ada</span>';
                                        }
                                        if(!empty($JsonData['sep']['noSep'])){
                                            $noSep=$JsonData['sep']['noSep'];
                                        }else{
                                            $noSep='<span class="text-danger">Tidak Ada</span>';
                                        }
                                        if(!empty($JsonData['sep']['tglSep'])){
                                            $tglSep=$JsonData['sep']['tglSep'];
                                        }else{
                                            $tglSep='<span class="text-danger">Tidak Ada</span>';
                                        }
                                        if(!empty($JsonData['sep']['jnsPelayanan'])){
                                            $jnsPelayanan=$JsonData['sep']['jnsPelayanan'];
                                        }else{
                                            $jnsPelayanan='<span class="text-danger">Tidak Ada</span>';
                                        }
                                        if(!empty($JsonData['sep']['poli'])){
                                            $poli=$JsonData['sep']['poli'];
                                        }else{
                                            $poli='<span class="text-danger">Tidak Ada</span>';
                                        }
                                        if(!empty($JsonData['sep']['diagnosa'])){
                                            $diagnosa=$JsonData['sep']['diagnosa'];
                                        }else{
                                            $diagnosa='<span class="text-danger">Tidak Ada</span>';
                                        }
                                        if(!empty($JsonData['sep']['peserta']['noKartu'])){
                                            $noKartu=$JsonData['sep']['peserta']['noKartu'];
                                        }else{
                                            $noKartu='<span class="text-danger">Tidak Ada</span>';
                                        }
                                        if(!empty($JsonData['sep']['peserta']['nama'])){
                                            $nama=$JsonData['sep']['peserta']['nama'];
                                        }else{
                                            $nama='<span class="text-danger">Tidak Ada</span>';
                                        }
                                        if(!empty($JsonData['sep']['peserta']['tglLahir'])){
                                            $tglLahir=$JsonData['sep']['peserta']['tglLahir'];
                                        }else{
                                            $tglLahir='<span class="text-danger">Tidak Ada</span>';
                                        }
                                        if(!empty($JsonData['sep']['peserta']['kelamin'])){
                                            $kelamin=$JsonData['sep']['peserta']['kelamin'];
                                        }else{
                                            $kelamin='<span class="text-danger">Tidak Ada</span>';
                                        }
                                        if(!empty($JsonData['sep']['peserta']['hakKelas'])){
                                            $hakKelas=$JsonData['sep']['peserta']['hakKelas'];
                                        }else{
                                            $hakKelas='<span class="text-danger">Tidak Ada</span>';
                                        }
                                        if(!empty($JsonData['sep']['provUmum']['kdProvider'])){
                                            $kdProvider=$JsonData['sep']['provUmum']['kdProvider'];
                                        }else{
                                            $kdProvider='<span class="text-danger">Tidak Ada</span>';
                                        }
                                        if(!empty($JsonData['sep']['provUmum']['nmProvider'])){
                                            $nmProvider=$JsonData['sep']['provUmum']['nmProvider'];
                                        }else{
                                            $nmProvider='<span class="text-danger">Tidak Ada</span>';
                                        }
                                        if(!empty($JsonData['sep']['provPerujuk']['nmProviderPerujuk'])){
                                            $nmProviderPerujuk=$JsonData['sep']['provPerujuk']['nmProviderPerujuk'];
                                        }else{
                                            $nmProviderPerujuk='<span class="text-danger">Tidak Ada</span>';
                                        }
                                        if(!empty($JsonData['sep']['provPerujuk']['asalRujukan'])){
                                            $asalRujukan=$JsonData['sep']['provPerujuk']['asalRujukan'];
                                        }else{
                                            $asalRujukan='<span class="text-danger">Tidak Ada</span>';
                                        }
                                        if(!empty($JsonData['sep']['provPerujuk']['noRujukan'])){
                                            $noRujukan=$JsonData['sep']['provPerujuk']['noRujukan'];
                                        }else{
                                            $noRujukan='<span class="text-danger">Tidak Ada</span>';
                                        }
                                        if(!empty($JsonData['sep']['provPerujuk']['tglRujukan'])){
                                            $tglRujukan=$JsonData['sep']['provPerujuk']['tglRujukan'];
                                        }else{
                                            $tglRujukan='<span class="text-danger">Tidak Ada</span>';
                                        }
                                        echo '<div class="row mb-3">';
                                        echo '  <div class="col-md-6"><dt>Nomor Kontrol</dt></div>';
                                        echo '  <div class="col-md-6"><small>'.$noSuratKontrol.'</small></div>';
                                        echo '</div>';
                                        echo '<div class="row mb-3">';
                                        echo '  <div class="col-md-6"><dt>Tanggal Kontrol</dt></div>';
                                        echo '  <div class="col-md-6"><small>'.$tglRencanaKontrol.'</small></div>';
                                        echo '</div>';
                                        echo '<div class="row mb-3">';
                                        echo '  <div class="col-md-6"><dt>Tanggal Terbit</dt></div>';
                                        echo '  <div class="col-md-6"><small>'.$tglTerbit.'</small></div>';
                                        echo '</div>';
                                        echo '<div class="row mb-3">';
                                        echo '  <div class="col-md-6"><dt>Jenis Kontrol</dt></div>';
                                        echo '  <div class="col-md-6"><small>'.$jnsKontrol.'</small></div>';
                                        echo '</div>';
                                        echo '<div class="row mb-3">';
                                        echo '  <div class="col-md-6"><dt>Poli Tujuan</dt></div>';
                                        echo '  <div class="col-md-6"><small>'.$poliTujuan.'-'.$namaPoliTujuan.'</small></div>';
                                        echo '</div>';
                                        echo '<div class="row mb-3">';
                                        echo '  <div class="col-md-6"><dt>Dokter</dt></div>';
                                        echo '  <div class="col-md-6"><small>'.$kodeDokter.'-'.$namaDokter.'</small></div>';
                                        echo '</div>';
                                        echo '<div class="row mb-3">';
                                        echo '  <div class="col-md-6"><dt>Flag Kontrol</dt></div>';
                                        echo '  <div class="col-md-6"><small>'.$flagKontrol.'</small></div>';
                                        echo '</div>';
                                        echo '<div class="row mb-3">';
                                        echo '  <div class="col-md-6"><dt>Dokter Pembuat</dt></div>';
                                        echo '  <div class="col-md-6"><small>'.$kodeDokterPembuat.'-'.$namaDokterPembuat.'</small></div>';
                                        echo '</div>';
                                        echo '<div class="row mb-3">';
                                        echo '  <div class="col-md-6"><dt>Jenis Kontrol</dt></div>';
                                        echo '  <div class="col-md-6"><small>'.$namaJnsKontrol.'</small></div>';
                                        echo '</div>';
                                        echo '<div class="row mb-3">';
                                        echo '  <div class="col-md-6"><dt>No.SEP</dt></div>';
                                        echo '  <div class="col-md-6"><small>'.$noSep.'</small></div>';
                                        echo '</div>';
                                        echo '<div class="row mb-3">';
                                        echo '  <div class="col-md-6"><dt>Tanggal SEP</dt></div>';
                                        echo '  <div class="col-md-6"><small>'.$tglSep.'</small></div>';
                                        echo '</div>';
                                        echo '<div class="row mb-3">';
                                        echo '  <div class="col-md-6"><dt>Jenis Pelayanan</dt></div>';
                                        echo '  <div class="col-md-6"><small>'.$jnsPelayanan.'</small></div>';
                                        echo '</div>';
                                        echo '<div class="row mb-3">';
                                        echo '  <div class="col-md-6"><dt>Poliklinik</dt></div>';
                                        echo '  <div class="col-md-6"><small>'.$poli.'</small></div>';
                                        echo '</div>';
                                        echo '<div class="row mb-3">';
                                        echo '  <div class="col-md-6"><dt>Diagnosa</dt></div>';
                                        echo '  <div class="col-md-6"><small>'.$diagnosa.'</small></div>';
                                        echo '</div>';
                                        echo '<div class="row mb-3">';
                                        echo '  <div class="col-md-6"><dt>Diagnosa</dt></div>';
                                        echo '  <div class="col-md-6"><small>'.$diagnosa.'</small></div>';
                                        echo '</div>';
                                        echo '<div class="row mb-3">';
                                        echo '  <div class="col-md-6"><dt>Nomor Kartu</dt></div>';
                                        echo '  <div class="col-md-6"><small>'.$noKartu.'</small></div>';
                                        echo '</div>';
                                        echo '<div class="row mb-3">';
                                        echo '  <div class="col-md-6"><dt>Nama pasien</dt></div>';
                                        echo '  <div class="col-md-6"><small>'.$nama.'</small></div>';
                                        echo '</div>';
                                        echo '<div class="row mb-3">';
                                        echo '  <div class="col-md-6"><dt>Tanggal Lahir</dt></div>';
                                        echo '  <div class="col-md-6"><small>'.$tglLahir.'</small></div>';
                                        echo '</div>';
                                        echo '<div class="row mb-3">';
                                        echo '  <div class="col-md-6"><dt>Gender</dt></div>';
                                        echo '  <div class="col-md-6"><small>'.$kelamin.'</small></div>';
                                        echo '</div>';
                                        echo '<div class="row mb-3">';
                                        echo '  <div class="col-md-6"><dt>Hak Kelas</dt></div>';
                                        echo '  <div class="col-md-6"><small>'.$hakKelas.'</small></div>';
                                        echo '</div>';
                                        echo '<div class="row mb-3">';
                                        echo '  <div class="col-md-6"><dt>Provider</dt></div>';
                                        echo '  <div class="col-md-6"><small>'.$kdProvider.'-'.$nmProvider.'</small></div>';
                                        echo '</div>';
                                        echo '<div class="row mb-3">';
                                        echo '  <div class="col-md-6"><dt>Provider Perujuk</dt></div>';
                                        echo '  <div class="col-md-6"><small>'.$nmProviderPerujuk.'</small></div>';
                                        echo '</div>';
                                        echo '<div class="row mb-3">';
                                        echo '  <div class="col-md-6"><dt>Asal Rujukan</dt></div>';
                                        echo '  <div class="col-md-6"><small>'.$asalRujukan.'</small></div>';
                                        echo '</div>';
                                        echo '<div class="row mb-3">';
                                        echo '  <div class="col-md-6"><dt>No Rujukan</dt></div>';
                                        echo '  <div class="col-md-6"><small>'.$noRujukan.'</small></div>';
                                        echo '</div>';
                                        echo '<div class="row mb-3">';
                                        echo '  <div class="col-md-6"><dt>Tanggal Rujukan</dt></div>';
                                        echo '  <div class="col-md-6"><small>'.$tglRujukan.'</small></div>';
                                        echo '</div>';
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
?>