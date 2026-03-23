<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingBridging.php";
    include "../../vendor/autoload.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap jenisreferensi
    if(empty($_POST['skdp'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 mb-3 text-center text-danger">';
        echo '      Nama Referensi Tidak Boleh Kosong!!.';
        echo '  </div>';
        echo '</div>';
    }else{
        $nomorreferensi=$_POST['skdp'];
        $url ="$url_vclaim/RencanaKontrol/noSuratKontrol/$nomorreferensi";
        $response=DetailReferensi($url_antrol,$consid,$secret_key,$user_key,$url,$nomorreferensi);
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
?>