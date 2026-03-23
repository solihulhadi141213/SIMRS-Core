<?php
    date_default_timezone_set('UTC');
    include "../../_Config/Connection.php";
    include "../../_Config/SettingBridging.php";
    include "../../_Config/SimrsFunction.php";
    include "../../vendor/autoload.php";
    //Menangkap sep
    if(empty($_POST['sep'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center">';
        echo '      <span class="text-danger">Nomor SEP Tidak Boleh Kosong!</span>';
        echo '  </div>';
        echo '</div>';
    }else{
        $sep=$_POST['sep'];
        $Response=DetailSep($url_vclaim,$consid,$secret_key,$user_key,$url_vclaim,$sep);
        if(empty($Response)){
            echo '<div class="row">';
            echo '  <div class="col-md-12 text-center">';
            echo '      <span class="text-danger">Tidak Ada Response Dari Service Function SIMRS!</span>';
            echo '  </div>';
            echo '</div>';
        }else{
            $ResponseData =json_decode($Response, true);
            if(empty($ResponseData['metaData']['code'])){
                echo '<div class="row">';
                echo '  <div class="col-md-12 text-center">';
                echo '      <span class="text-danger">Tidak Ada Response Dari Service BPJS!</span>';
                echo '  </div>';
                echo '</div>';
            }else{
                $ResponseCode=$ResponseData['metaData']['code'];
                if($ResponseCode!=="200"){
                    echo '<div class="row">';
                    echo '  <div class="col-md-12 text-center">';
                    echo '      <span class="text-danger">Pesan: '.$ResponseData['metaData']['message'].'</span>';
                    echo '  </div>';
                    echo '</div>';
                }else{
                    if(empty($ResponseData['response'])){
                        echo '<div class="row">';
                        echo '  <div class="col-md-12 text-center">';
                        echo '      <dt class="text-danger">Terjadi Kesalahan Pada Response</dt>';
                        echo '      <span class="text-danger">Pesan: '.$ResponseData['metaData']['message'].'</span>';
                        echo '  </div>';
                        echo '</div>';
                    }else{
                        $string=$ResponseData['response'];
                        $stringData =json_decode($string, true);
                        $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
                        $key="$consid$secret_key$timestamp";
                        //--masukan ke fungsi
                        $FileDeskripsi=stringDecrypt("$key", "$string");
                        $FileDekompresi=decompress("$FileDeskripsi");
                        //--konveris json to raw
                        $JsonData =json_decode($FileDekompresi, true);
                        if(empty($JsonData["noSep"])){
                            $noSep='<span class="text-danger">Tidak Ada</span>';
                        }else{
                            $noSep=$JsonData["noSep"];
                        }
                        if(empty($JsonData["tglSep"])){
                            $tglSep='<span class="text-danger">Tidak Ada</span>';
                        }else{
                            $tglSep=$JsonData["tglSep"];
                        }
                        if(empty($JsonData["jnsPelayanan"])){
                            $jnsPelayanan='<span class="text-danger">Tidak Ada</span>';
                        }else{
                            $jnsPelayanan=$JsonData["jnsPelayanan"];
                        }
                        if(empty($JsonData["kelasRawat"])){
                            $kelasRawat='<span class="text-danger">Tidak Ada</span>';
                        }else{
                            $kelasRawat=$JsonData["kelasRawat"];
                        }
                        if(empty($JsonData["diagnosa"])){
                            $diagnosa='<span class="text-danger">Tidak Ada</span>';
                        }else{
                            $diagnosa=$JsonData["diagnosa"];
                        }
                        if(empty($JsonData["noRujukan"])){
                            $noRujukan='<span class="text-danger">Tidak Ada</span>';
                        }else{
                            $noRujukan=$JsonData["noRujukan"];
                        }
                        if(empty($JsonData["poli"])){
                            $poli='<span class="text-danger">Tidak Ada</span>';
                        }else{
                            $poli=$JsonData["poli"];
                        }
                        if(empty($JsonData["poliEksekutif"])){
                            $poliEksekutif='<span class="text-danger">Tidak Ada</span>';
                        }else{
                            $poliEksekutif=$JsonData["poliEksekutif"];
                        }
                        if(empty($JsonData["catatan"])){
                            $catatan='<span class="text-danger">Tidak Ada</span>';
                        }else{
                            $catatan=$JsonData["catatan"];
                        }
                        if(empty($JsonData["penjamin"])){
                            $penjamin='<span class="text-danger">Tidak Ada</span>';
                        }else{
                            $penjamin=$JsonData["penjamin"];
                        }
                        if(empty($JsonData["kdStatusKecelakaan"])){
                            $kdStatusKecelakaan='<span class="text-danger">Tidak Ada</span>';
                        }else{
                            if(empty($JsonData["nmstatusKecelakaan"])){
                                $kdStatusKecelakaan='<span class="text-danger">Tidak Ada</span>';
                            }else{
                                $nmstatusKecelakaan=$JsonData["nmstatusKecelakaan"];
                                $kdStatusKecelakaan=$JsonData["kdStatusKecelakaan"];
                                $kdStatusKecelakaan="$kdStatusKecelakaan-$nmstatusKecelakaan";
                            }
                            
                        }
                        if(empty($JsonData["lokasiKejadian"])){
                            $lokasiKejadian='<span class="text-danger">Tidak Ada</span>';
                        }else{
                            $lokasiKejadian=$JsonData["lokasiKejadian"];
                            if(empty($lokasiKejadian["kdKab"])){
                                $kdKab='<span class="text-danger">Tidak Ada</span>';
                            }else{
                                $kdKab=$lokasiKejadian["kdKab"];
                            }
                            if(empty($lokasiKejadian["kdKec"])){
                                $kdKec='<span class="text-danger">Tidak Ada</span>';
                            }else{
                                $kdKec=$lokasiKejadian["kdKec"];
                            }
                            if(empty($lokasiKejadian["kdProp"])){
                                $kdProp='<span class="text-danger">Tidak Ada</span>';
                            }else{
                                $kdProp=$lokasiKejadian["kdProp"];
                            }
                            if(empty($lokasiKejadian["ketKejadian"])){
                                $ketKejadian='<span class="text-danger">Tidak Ada</span>';
                            }else{
                                $ketKejadian=$lokasiKejadian["ketKejadian"];
                            }
                            if(empty($lokasiKejadian["lokasi"])){
                                $lokasi='<span class="text-danger">Tidak Ada</span>';
                            }else{
                                $lokasi=$lokasiKejadian["lokasi"];
                            }
                            if(empty($lokasiKejadian["tglKejadian"])){
                                $tglKejadian='<span class="text-danger">Tidak Ada</span>';
                            }else{
                                $tglKejadian=$lokasiKejadian["tglKejadian"];
                            }
                        }
                        if(empty($JsonData["dpjp"])){
                            $dpjp='<span class="text-danger">Tidak Ada</span>';
                        }else{
                            $dpjp=$JsonData["dpjp"];
                            if(empty($JsonData["dpjp"]["kdDPJP"])){
                                $dpjp='<span class="text-danger">Tidak Ada</span>';
                            }else{
                                if(empty($JsonData["dpjp"]["nmDPJP"])){
                                    $dpjp='<span class="text-danger">Tidak Ada</span>';
                                }else{
                                    $kdDPJP=$JsonData["dpjp"]["kdDPJP"];
                                    $nmDPJP=$JsonData["dpjp"]["nmDPJP"];
                                    $dpjp="$kdDPJP-$nmDPJP";
                                }
                            }
                        }
                        if(empty($JsonData["peserta"])){
                            $peserta='<span class="text-danger">Tidak Ada</span>';
                        }else{
                            $peserta=$JsonData["peserta"];
                            if(empty($peserta["asuransi"])){
                                $asuransi='<span class="text-danger">Tidak Ada</span>';
                            }else{
                                $asuransi=$peserta["asuransi"];
                            }
                            if(empty($peserta["hakKelas"])){
                                $hakKelas='<span class="text-danger">Tidak Ada</span>';
                            }else{
                                $hakKelas=$peserta["hakKelas"];
                            }
                            if(empty($peserta["jnsPeserta"])){
                                $jnsPeserta='<span class="text-danger">Tidak Ada</span>';
                            }else{
                                $jnsPeserta=$peserta["jnsPeserta"];
                            }
                            if(empty($peserta["kelamin"])){
                                $kelamin='<span class="text-danger">Tidak Ada</span>';
                            }else{
                                $kelamin=$peserta["kelamin"];
                            }
                            if(empty($peserta["nama"])){
                                $nama='<span class="text-danger">Tidak Ada</span>';
                            }else{
                                $nama=$peserta["nama"];
                            }
                            if(empty($peserta["noKartu"])){
                                $noKartu='<span class="text-danger">Tidak Ada</span>';
                            }else{
                                $noKartu=$peserta["noKartu"];
                            }
                            if(empty($peserta["noMr"])){
                                $noMr='<span class="text-danger">Tidak Ada</span>';
                            }else{
                                $noMr=$peserta["noMr"];
                            }
                            if(empty($peserta["tglLahir"])){
                                $tglLahir='<span class="text-danger">Tidak Ada</span>';
                            }else{
                                $tglLahir=$peserta["tglLahir"];
                            }
                        }
                        if(empty($JsonData["klsRawat"])){
                            $klsRawat='<span class="text-danger">Tidak Ada</span>';
                        }else{
                            $klsRawat=$JsonData["klsRawat"];
                            if(empty($klsRawat["klsRawatHak"])){
                                $klsRawatHak='<span class="text-danger">Tidak Ada</span>';
                            }else{
                                $klsRawatHak=$klsRawat["klsRawatHak"];
                            }
                            if(empty($klsRawat["klsRawatNaik"])){
                                $klsRawatNaik='<span class="text-danger">Tidak Ada</span>';
                            }else{
                                $klsRawatNaik=$klsRawat["klsRawatNaik"];
                            }
                            if(empty($klsRawat["pembiayaan"])){
                                $pembiayaan='<span class="text-danger">Tidak Ada</span>';
                            }else{
                                $pembiayaan=$klsRawat["pembiayaan"];
                            }
                            if(empty($klsRawat["penanggungJawab"])){
                                $penanggungJawab='<span class="text-danger">Tidak Ada</span>';
                            }else{
                                $penanggungJawab=$klsRawat["penanggungJawab"];
                            }
                        }
                        if(empty($JsonData["kontrol"])){
                            $kontrol='<span class="text-danger">Tidak Ada</span>';
                        }else{
                            $kontrol=$JsonData["kontrol"];
                            if(empty($kontrol["kdDokter"])){
                                $kdDokter='<span class="text-danger">Tidak Ada</span>';
                            }else{
                                $kdDokter=$kontrol["kdDokter"];
                            }
                            if(empty($kontrol["nmDokter"])){
                                $nmDokter='<span class="text-danger">Tidak Ada</span>';
                            }else{
                                $nmDokter=$kontrol["nmDokter"];
                            }
                            if(empty($kontrol["noSurat"])){
                                $noSurat='<span class="text-danger">Tidak Ada</span>';
                            }else{
                                $noSurat=$kontrol["noSurat"];
                            }
                        }
                        if(empty($JsonData["cob"])){
                            $cob='<span class="text-danger">Tidak</span>';
                        }else{
                            $cob=$JsonData["cob"];
                        }
                        if(empty($JsonData["katarak"])){
                            $katarak='<span class="text-danger">Tidak</span>';
                        }else{
                            $katarak=$JsonData["katarak"];
                        }
                        if(empty($JsonData["tujuanKunj"])){
                            $tujuanKunj='<span class="text-danger">Tidak Ada</span>';
                        }else{
                            $tujuanKunj=$JsonData["tujuanKunj"];
                            if(empty($tujuanKunj["tujuanKunj"])){
                                $kodetujuanKunj='<span class="text-danger">0</span>';
                            }else{
                                $kodetujuanKunj=$tujuanKunj["kode"];
                            }
                            if(empty($tujuanKunj["nama"])){
                                $namatujuanKunj='<span class="text-danger">Tidak Ada</span>';
                            }else{
                                $namatujuanKunj=$tujuanKunj["nama"];
                            }
                        }
                        if(empty($JsonData["flagProcedure"])){
                            $flagProcedure='<span class="text-danger">Tidak Ada</span>';
                        }else{
                            if(empty($JsonData["flagProcedure"]["kode"])){
                                $flagProcedure='<span class="text-danger">Prosedur tidak berkelanjutan</span>';
                            }else{
                                $kodeflagProcedure=$JsonData["flagProcedure"]["kode"];
                                if(empty($JsonData["flagProcedure"]["nama"])){
                                    $flagProcedure='<span class="text-danger">Tidak Ada</span>';
                                }else{
                                    $namaflagProcedure=$JsonData["flagProcedure"]["nama"];
                                    $flagProcedure="$kodeflagProcedure-$namaflagProcedure";
                                }
                            }
                        }
                        if(empty($JsonData["kdPenunjang"])){
                            $kdPenunjang='<span class="text-danger">Tidak Ada</span>';
                        }else{
                            if(empty($JsonData["kdPenunjang"]["kode"])){
                                $kdPenunjang='<span class="text-danger">Tidak Ada</span>';
                            }else{
                                if(empty($JsonData["kdPenunjang"]["nama"])){
                                    $kdPenunjang='<span class="text-danger">Tidak Ada</span>';
                                }else{
                                    $KodekdPenunjang=$JsonData["kdPenunjang"]["kode"];
                                    $namakdPenunjang=$JsonData["kdPenunjang"]["nama"];
                                    $kdPenunjang="$KodekdPenunjang-$namakdPenunjang";
                                }
                            }
                        }
                        if(empty($JsonData["assestmenPel"])){
                            $assestmenPel='<span class="text-danger">Tidak Ada</span>';
                        }else{
                            if(empty($JsonData["assestmenPel"]["kode"])){
                                $assestmenPel='<span class="text-danger">Tidak Ada</span>';
                            }else{
                                if(empty($JsonData["assestmenPel"]["nama"])){
                                    $assestmenPel='<span class="text-danger">Tidak Ada</span>';
                                }else{
                                    $kodeassestmenPel=$JsonData["assestmenPel"]["kode"];
                                    $namaassestmenPel=$JsonData["assestmenPel"]["nama"];
                                    $assestmenPel="$kodeassestmenPel-$namaassestmenPel";
                                }
                            }
                        }
                        if(empty($JsonData["eSEP"])){
                            $eSEP='<span class="text-danger">Tidak Ada</span>';
                        }else{
                            $eSEP=$JsonData["eSEP"];
                        }
                        echo '<div class="row mb-3">';
                        echo '  <div class="col-md-6"><dt>Nomor SEP</dt></div>';
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
                        echo '  <div class="col-md-6"><dt>Kelas Rawat</dt></div>';
                        echo '  <div class="col-md-6"><small>'.$kelasRawat.'</small></div>';
                        echo '</div>';
                        echo '<div class="row mb-3">';
                        echo '  <div class="col-md-6"><dt>Diagnosa</dt></div>';
                        echo '  <div class="col-md-6"><small>'.$diagnosa.'</small></div>';
                        echo '</div>';
                        echo '<div class="row mb-3">';
                        echo '  <div class="col-md-6"><dt>Nomor Rujukan</dt></div>';
                        echo '  <div class="col-md-6"><small>'.$noRujukan.'</small></div>';
                        echo '</div>';
                        echo '<div class="row mb-3">';
                        echo '  <div class="col-md-6"><dt>Nomor Rujukan</dt></div>';
                        echo '  <div class="col-md-6"><small>'.$noRujukan.'</small></div>';
                        echo '</div>';
                        echo '<div class="row mb-3">';
                        echo '  <div class="col-md-6"><dt>Poliklinik</dt></div>';
                        echo '  <div class="col-md-6"><small>'.$poli.'</small></div>';
                        echo '</div>';
                        echo '<div class="row mb-3">';
                        echo '  <div class="col-md-6"><dt>Poli Eksekutif</dt></div>';
                        echo '  <div class="col-md-6"><small>'.$poliEksekutif.'</small></div>';
                        echo '</div>';
                        echo '<div class="row mb-3">';
                        echo '  <div class="col-md-6"><dt>Catatan</dt></div>';
                        echo '  <div class="col-md-6"><small>'.$catatan.'</small></div>';
                        echo '</div>';
                        echo '<div class="row mb-3">';
                        echo '  <div class="col-md-6"><dt>Penjamin</dt></div>';
                        echo '  <div class="col-md-6"><small>'.$penjamin.'</small></div>';
                        echo '</div>';
                        if(empty($JsonData["kdStatusKecelakaan"])){
                            echo '<div class="row mb-3">';
                            echo '  <div class="col-md-6"><dt>Status Kecelakaan</dt></div>';
                            echo '  <div class="col-md-6"><small>'.$kdStatusKecelakaan.'</small></div>';
                            echo '</div>';
                        }else{
                            if(empty($JsonData["nmstatusKecelakaan"])){
                                echo '<div class="row mb-3">';
                                echo '  <div class="col-md-6"><dt>Status Kecelakaan</dt></div>';
                                echo '  <div class="col-md-6"><small>'.$kdStatusKecelakaan.'</small></div>';
                                echo '</div>';
                            }else{
                                echo '<div class="row mb-3">';
                                echo '  <div class="col-md-6"><dt>Status Kecelakaan</dt></div>';
                                echo '  <div class="col-md-6"><small>'.$kdStatusKecelakaan.'</small></div>';
                                echo '</div>';
                                if(empty($JsonData["lokasiKejadian"])){
                                    echo '<div class="row mb-3">';
                                    echo '  <div class="col-md-6"><dt>Lokasi Kejadian</dt></div>';
                                    echo '  <div class="col-md-6"><small>'.$kdStatusKecelakaan.'</small></div>';
                                    echo '</div>';
                                }else{
                                    echo '<div class="row mb-3">';
                                    echo '  <div class="col col-md-6"><dt>Lokasi Kejadian</dt></div>';
                                    echo '  <div class="col col-md-6"><small></small></div>';
                                    echo '  <div class="col col-md-6"><small>Kabupaten</small></div>';
                                    echo '  <div class="col col-md-6"><small>'.$kdKab.'</small></div>';
                                    echo '  <div class="col col-md-6"><small>Kecamatan</small></div>';
                                    echo '  <div class="col col-md-6"><small>'.$kdKec.'</small></div>';
                                    echo '  <div class="col col-md-6"><small>Provinsi</small></div>';
                                    echo '  <div class="col col-md-6"><small>'.$kdProp.'</small></div>';
                                    echo '  <div class="col col-md-6"><small>Keterangan</small></div>';
                                    echo '  <div class="col col-md-6"><small>'.$ketKejadian.'</small></div>';
                                    echo '  <div class="col col-md-6"><small>Lokasi</small></div>';
                                    echo '  <div class="col col-md-6"><small>'.$lokasi.'</small></div>';
                                    echo '  <div class="col col-md-6"><small>Tanggal Kejadian</small></div>';
                                    echo '  <div class="col col-md-6"><small>'.$tglKejadian.'</small></div>';
                                    echo '</div>';
                                }
                            }
                        }
                        if(empty($JsonData["peserta"])){
                            echo '<div class="row mb-3">';
                            echo '  <div class="col-md-6"><dt>Peserta</dt></div>';
                            echo '  <div class="col-md-6"><small>'.$peserta.'</small></div>';
                            echo '</div>';
                        }else{
                            echo '<div class="row mb-3">';
                            echo '  <div class="col-md-6"><dt>Peserta</dt></div>';
                            echo '  <div class="col-md-6"><small></small></div>';
                            echo '  <div class="col col-md-6"><small>Asuransi</small></div>';
                            echo '  <div class="col col-md-6"><small>'.$asuransi.'</small></div>';
                            echo '  <div class="col col-md-6"><small>Hak Kelas</small></div>';
                            echo '  <div class="col col-md-6"><small>'.$hakKelas.'</small></div>';
                            echo '  <div class="col col-md-6"><small>Jenis Peserta</small></div>';
                            echo '  <div class="col col-md-6"><small>'.$jnsPeserta.'</small></div>';
                            echo '  <div class="col col-md-6"><small>Gender</small></div>';
                            echo '  <div class="col col-md-6"><small>'.$kelamin.'</small></div>';
                            echo '  <div class="col col-md-6"><small>Nama Peserta</small></div>';
                            echo '  <div class="col col-md-6"><small>'.$nama.'</small></div>';
                            echo '  <div class="col col-md-6"><small>Nomor Kartu</small></div>';
                            echo '  <div class="col col-md-6"><small>'.$noKartu.'</small></div>';
                            echo '  <div class="col col-md-6"><small>Nomor RM</small></div>';
                            echo '  <div class="col col-md-6"><small>'.$noMr.'</small></div>';
                            echo '  <div class="col col-md-6"><small>Tanggal Lahir</small></div>';
                            echo '  <div class="col col-md-6"><small>'.$tglLahir.'</small></div>';
                            echo '</div>';
                        }
                        if(empty($JsonData["klsRawat"])){
                            echo '<div class="row mb-3">';
                            echo '  <div class="col-md-6"><dt>Kelas Rawat</dt></div>';
                            echo '  <div class="col-md-6"><small>'.$klsRawat.'</small></div>';
                            echo '</div>';
                        }else{
                            echo '<div class="row mb-3">';
                            echo '  <div class="col-md-6"><dt>Kelas Rawat</dt></div>';
                            echo '  <div class="col-md-6"><small></small></div>';
                            echo '  <div class="col col-md-6"><small>Hak Kelas Rawat</small></div>';
                            echo '  <div class="col col-md-6"><small>'.$klsRawatHak.'</small></div>';
                            echo '  <div class="col col-md-6"><small>Kelas Rawat Naik</small></div>';
                            echo '  <div class="col col-md-6"><small>'.$klsRawatNaik.'</small></div>';
                            echo '  <div class="col col-md-6"><small>Pembayaran</small></div>';
                            echo '  <div class="col col-md-6"><small>'.$pembiayaan.'</small></div>';
                            echo '  <div class="col col-md-6"><small>Penanggung Jawab</small></div>';
                            echo '  <div class="col col-md-6"><small>'.$penanggungJawab.'</small></div>';
                            echo '</div>';
                        }
                        if(empty($JsonData["kontrol"])){
                            echo '<div class="row mb-3">';
                            echo '  <div class="col-md-6"><dt>Kontrol</dt></div>';
                            echo '  <div class="col-md-6"><small>'.$kontrol.'</small></div>';
                            echo '</div>';
                        }else{
                            echo '<div class="row mb-3">';
                            echo '  <div class="col-md-6"><dt>Kontrol</dt></div>';
                            echo '  <div class="col-md-6"><small></small></div>';
                            echo '  <div class="col col-md-6"><small>Kode Dokter</small></div>';
                            echo '  <div class="col col-md-6"><small>'.$kdDokter.'</small></div>';
                            echo '  <div class="col col-md-6"><small>Nama Dokter</small></div>';
                            echo '  <div class="col col-md-6"><small>'.$nmDokter.'</small></div>';
                            echo '  <div class="col col-md-6"><small>Nomor Surat</small></div>';
                            echo '  <div class="col col-md-6"><small>'.$noSurat.'</small></div>';
                            echo '</div>';
                        }
                        echo '<div class="row mb-3">';
                        echo '  <div class="col-md-6"><dt>DPJP</dt></div>';
                        echo '  <div class="col-md-6"><small>'.$dpjp.'</small></div>';
                        echo '</div>';
                        echo '<div class="row mb-3">';
                        echo '  <div class="col-md-6"><dt>COB</dt></div>';
                        echo '  <div class="col-md-6"><small>'.$cob.'</small></div>';
                        echo '</div>';
                        if(empty($JsonData["tujuanKunj"])){
                            echo '<div class="row mb-3">';
                            echo '  <div class="col-md-6"><dt>Tujuan Kunjungan</dt></div>';
                            echo '  <div class="col-md-6"><small>'.$tujuanKunj.'</small></div>';
                            echo '</div>';
                        }else{
                            echo '<div class="row mb-3">';
                            echo '  <div class="col-md-6"><dt>Tujuan Kunjungan</dt></div>';
                            echo '  <div class="col-md-6"><small>'.$kodetujuanKunj.'-'.$namatujuanKunj.'</small></div>';
                            echo '</div>';
                        }
                        echo '<div class="row mb-3">';
                        echo '  <div class="col-md-6"><dt>Flag Procedure (Tindakan)</dt></div>';
                        echo '  <div class="col-md-6"><small>'.$flagProcedure.'</small></div>';
                        echo '</div>';
                        echo '<div class="row mb-3">';
                        echo '  <div class="col-md-6"><dt>Kode Penunjang</dt></div>';
                        echo '  <div class="col-md-6"><small>'.$kdPenunjang.'</small></div>';
                        echo '</div>';
                        echo '<div class="row mb-3">';
                        echo '  <div class="col-md-6"><dt>Assestmen Pelayanan</dt></div>';
                        echo '  <div class="col-md-6"><small>'.$assestmenPel.'</small></div>';
                        echo '</div>';
                        echo '<div class="row mb-3">';
                        echo '  <div class="col-md-6"><dt>Katarak</dt></div>';
                        echo '  <div class="col-md-6"><small>'.$katarak.'</small></div>';
                        echo '</div>';
                        echo '<div class="row mb-3">';
                        echo '  <div class="col-md-6"><dt>E-SEP</dt></div>';
                        echo '  <div class="col-md-6"><small>'.$eSEP.'</small></div>';
                        echo '</div>';
                        echo '<div class="row mb-3">';
                        echo '  <div class="col-md-12">';
                        echo '      <a href="index.php?Page=Sep&Sub=DetailSep&sep='.$sep.'" class="btn btn-sm btn-block btn-outline-dark">';
                        echo '          Detail SEP <i class="ti ti-layers-alt"></i>';
                        echo '      </a>';
                        echo '  </div>';
                        echo '</div>';
                    }
                }
            }
        }
    }
?>