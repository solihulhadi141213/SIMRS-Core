<?php
    date_default_timezone_set('UTC');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/SettingBridging.php";
    include "../../vendor/autoload.php";
    if(empty($_POST['sep'])){
        echo '<div class="row mb-3">';
        echo '  <div class="col-md-12 text-center text-danger">';
        echo '      SEP Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        $sep=$_POST['sep'];
        $KontentSep=DetailSep($url_vclaim,$consid,$secret_key,$user_key,$url_vclaim,$sep);
        if(empty($KontentSep)){
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-12 text-center text-danger">';
            echo '      SEP Tidak Ditemukan Pada Service BPJS!<br>';
            echo '      <small>Ini mungkin bisa terjadi karena tidak ada koneksi ke service BPJS</small>';
            echo '  </div>';
            echo '</div>';
        }else{
            $ambil_json =json_decode($KontentSep, true);
            if(empty($ambil_json["response"])){
                echo '<div class="row mb-3">';
                echo '  <div class="col-md-12 text-center text-danger">';
                echo '      SEP Tidak Ditemukan Pada Service BPJS!<br>';
                echo '      <small>Ini mungkin bisa terjadi karena tidak ada koneksi ke service BPJS</small>';
                echo '      <code>'.$KontentSep.'</code>';
                echo '  </div>';
                echo '</div>';
            }else{
                $string=$ambil_json["response"];
                //Proses decode dan dekompresi
                //--membuat key
                $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
                $key="$consid$secret_key$timestamp";
                //--masukan ke fungsi
                $FileDeskripsi=stringDecrypt("$key", "$string");
                $FileDekompresi=decompress($FileDeskripsi);
                //--konveris json to raw
                $JsonData =json_decode($FileDekompresi, true);
                //INFORMASI UMUM
                echo '<div class="row mb-3">';
                echo '  <div class="col-md-12">';
                echo '      <b>A. Informasi Umum</b>';
                echo '      <ol>';
                echo '          <li>';
                echo '              No.SEP : ';
                                    if(!empty($JsonData["noSep"])){
                                        echo '<code class="text-secondary">'.$JsonData["noSep"].'</code>';
                                    }else{
                                        echo '<code class="text-danger">Tidak Ada</code>';
                                    }
                echo '          </li>';
                echo '          <li>';
                echo '              Tgl.SEP : ';
                                    if(!empty($JsonData["tglSep"])){
                                        echo '<code class="text-secondary">'.$JsonData["tglSep"].'</code>';
                                    }else{
                                        echo '<code class="text-danger">Tidak Ada</code>';
                                    }
                echo '          </li>';
                echo '          <li>';
                echo '              Jenis Layanan : ';
                                    if(!empty($JsonData["jnsPelayanan"])){
                                        echo '<code class="text-secondary">'.$JsonData["jnsPelayanan"].'</code>';
                                    }else{
                                        echo '<code class="text-danger">Tidak Ada</code>';
                                    }
                echo '          </li>';
                echo '          <li>';
                echo '              Kelas Rawat : ';
                                    if(!empty($JsonData["kelasRawat"])){
                                        echo '<code class="text-secondary">'.$JsonData["kelasRawat"].'</code>';
                                    }else{
                                        echo '<code class="text-danger">Tidak Ada</code>';
                                    }
                echo '          </li>';
                echo '          <li>';
                echo '              Diagnosa : ';
                                    if(!empty($JsonData["diagnosa"])){
                                        echo '<code class="text-secondary">'.$JsonData["diagnosa"].'</code>';
                                    }else{
                                        echo '<code class="text-danger">Tidak Ada</code>';
                                    }
                echo '          </li>';
                echo '          <li>';
                echo '              Nomor Rujukan : ';
                                    if(!empty($JsonData["noRujukan"])){
                                        echo '<code class="text-secondary">'.$JsonData["noRujukan"].'</code>';
                                    }else{
                                        echo '<code class="text-danger">Tidak Ada</code>';
                                    }
                echo '          </li>';
                echo '          <li>';
                echo '              Poliklinik : ';
                                    if(!empty($JsonData["poli"])){
                                        echo '<code class="text-secondary">'.$JsonData["poli"].'</code>';
                                    }else{
                                        echo '<code class="text-danger">Tidak Ada</code>';
                                    }
                echo '          </li>';
                echo '          <li>';
                echo '              Poli Eksekutif : ';
                                    if(!empty($JsonData["poliEksekutif"])){
                                        echo '<code class="text-secondary">'.$JsonData["poliEksekutif"].'</code>';
                                    }else{
                                        echo '<code class="text-danger">Tidak Ada</code>';
                                    }
                echo '          </li>';
                echo '          <li>';
                echo '              Catatan : ';
                                    if(!empty($JsonData["catatan"])){
                                        echo '<code class="text-secondary">'.$JsonData["catatan"].'</code>';
                                    }else{
                                        echo '<code class="text-danger">Tidak Ada</code>';
                                    }
                echo '          </li>';
                echo '          <li>';
                echo '              Penjamin : ';
                                    if(!empty($JsonData["penjamin"])){
                                        echo '<code class="text-secondary">'.$JsonData["penjamin"].'</code>';
                                    }else{
                                        echo '<code class="text-danger">Tidak Ada</code>';
                                    }
                echo '          </li>';
                echo '          <li>';
                echo '              Informasi : ';
                                    if(!empty($JsonData["informasi"])){
                                        echo '<code class="text-secondary">'.$JsonData["informasi"].'</code>';
                                    }else{
                                        echo '<code class="text-danger">Tidak Ada</code>';
                                    }
                echo '          </li>';
                echo '          <li>';
                echo '              COB : ';
                                    if(!empty($JsonData["cob"])){
                                        echo '<code class="text-secondary">'.$JsonData["cob"].'</code>';
                                    }else{
                                        echo '<code class="text-danger">Tidak Ada</code>';
                                    }
                echo '          </li>';
                echo '          <li>';
                echo '              Katarak : ';
                                    if(!empty($JsonData["katarak"])){
                                        echo '<code class="text-secondary">'.$JsonData["katarak"].'</code>';
                                    }else{
                                        echo '<code class="text-danger">Tidak Ada</code>';
                                    }
                echo '          </li>';
                echo '      </ol>';
                echo '  </div>';
                echo '</div>'; 
                //PESERTA
                echo '<div class="row mb-3">';
                echo '  <div class="col-md-12">';
                echo '      <b>B. Informasi Peserta</b>';
                echo '      <ol>';
                echo '          <li>';
                echo '              Nomor Kartu : ';
                                    if(!empty($JsonData["peserta"]["noKartu"])){
                                        echo '<code class="text-secondary">'.$JsonData["peserta"]["noKartu"].'</code>';
                                    }else{
                                        echo '<code class="text-danger">Tidak Ada</code>';
                                    }
                echo '          </li>';
                echo '          <li>';
                echo '              Nama Peserta : ';
                                    if(!empty($JsonData["peserta"]["nama"])){
                                        echo '<code class="text-secondary">'.$JsonData["peserta"]["nama"].'</code>';
                                    }else{
                                        echo '<code class="text-danger">Tidak Ada</code>';
                                    }
                echo '          </li>';
                echo '          <li>';
                echo '              Tanggal Lahir : ';
                                    if(!empty($JsonData["peserta"]["tglLahir"])){
                                        echo '<code class="text-secondary">'.$JsonData["peserta"]["tglLahir"].'</code>';
                                    }else{
                                        echo '<code class="text-danger">Tidak Ada</code>';
                                    }
                echo '          </li>';
                echo '          <li>';
                echo '              No.MR : ';
                                    if(!empty($JsonData["peserta"]["noMr"])){
                                        echo '<code class="text-secondary">'.$JsonData["peserta"]["noMr"].'</code>';
                                    }else{
                                        echo '<code class="text-danger">Tidak Ada</code>';
                                    }
                echo '          </li>';
                echo '          <li>';
                echo '              Gender : ';
                                    if(!empty($JsonData["peserta"]["kelamin"])){
                                        echo '<code class="text-secondary">'.$JsonData["peserta"]["kelamin"].'</code>';
                                    }else{
                                        echo '<code class="text-danger">Tidak Ada</code>';
                                    }
                echo '          </li>';
                echo '          <li>';
                echo '              Jenis Peserta : ';
                                    if(!empty($JsonData["peserta"]["jnsPeserta"])){
                                        echo '<code class="text-secondary">'.$JsonData["peserta"]["jnsPeserta"].'</code>';
                                    }else{
                                        echo '<code class="text-danger">Tidak Ada</code>';
                                    }
                echo '          </li>';
                echo '          <li>';
                echo '              Hak Kelas : ';
                                    if(!empty($JsonData["peserta"]["hakKelas"])){
                                        echo '<code class="text-secondary">'.$JsonData["peserta"]["hakKelas"].'</code>';
                                    }else{
                                        echo '<code class="text-danger">Tidak Ada</code>';
                                    }
                echo '          </li>';
                echo '          <li>';
                echo '              Asuransi : ';
                                    if(!empty($JsonData["peserta"]["asuransi"])){
                                        echo '<code class="text-secondary">'.$JsonData["peserta"]["asuransi"].'</code>';
                                    }else{
                                        echo '<code class="text-danger">Tidak Ada</code>';
                                    }
                echo '          </li>';
                echo '      </ol>';
                echo '  </div>';
                echo '</div>'; 
                //DPJP
                echo '<div class="row mb-3">';
                echo '  <div class="col-md-12">';
                echo '      <b>C. Dokter DPJP</b>';
                echo '      <ol>';
                echo '          <li>';
                echo '              Kode DPJP : ';
                                    if(!empty($JsonData["dpjp"]["kdDPJP"])){
                                        echo '<code class="text-secondary">'.$JsonData["dpjp"]["kdDPJP"].'</code>';
                                    }else{
                                        echo '<code class="text-danger">Tidak Ada</code>';
                                    }
                echo '          </li>';
                echo '          <li>';
                echo '              Nama DPJP : ';
                                    if(!empty($JsonData["dpjp"]["nmDPJP"])){
                                        echo '<code class="text-secondary">'.$JsonData["dpjp"]["nmDPJP"].'</code>';
                                    }else{
                                        echo '<code class="text-danger">Tidak Ada</code>';
                                    }
                echo '          </li>';
                echo '      </ol>';
                echo '  </div>';
                echo '</div>'; 
                //KELAS RAWAT
                echo '<div class="row mb-3">';
                echo '  <div class="col-md-12">';
                echo '      <b>D. Kelas Rawat</b>';
                echo '      <ol>';
                echo '          <li>';
                echo '              Hak Kelas Rawat : ';
                                    if(!empty($JsonData["klsRawat"]["klsRawatHak"])){
                                        echo '<code class="text-secondary">'.$JsonData["klsRawat"]["klsRawatHak"].'</code>';
                                    }else{
                                        echo '<code class="text-danger">Tidak Ada</code>';
                                    }
                echo '          </li>';
                echo '          <li>';
                echo '              Kelas Rawat Naik : ';
                                    if(!empty($JsonData["klsRawat"]["klsRawatNaik"])){
                                        echo '<code class="text-secondary">'.$JsonData["klsRawat"]["klsRawatNaik"].'</code>';
                                    }else{
                                        echo '<code class="text-danger">Tidak Ada</code>';
                                    }
                echo '          </li>';
                echo '          <li>';
                echo '              Pembiayaan : ';
                                    if(!empty($JsonData["klsRawat"]["pembiayaan"])){
                                        echo '<code class="text-secondary">'.$JsonData["klsRawat"]["pembiayaan"].'</code>';
                                    }else{
                                        echo '<code class="text-danger">Tidak Ada</code>';
                                    }
                echo '          </li>';
                echo '          <li>';
                echo '              Penanggung Jawab : ';
                                    if(!empty($JsonData["klsRawat"]["penanggungJawab"])){
                                        echo '<code class="text-secondary">'.$JsonData["klsRawat"]["penanggungJawab"].'</code>';
                                    }else{
                                        echo '<code class="text-danger">Tidak Ada</code>';
                                    }
                echo '          </li>';
                echo '      </ol>';
                echo '  </div>';
                echo '</div>'; 
                //KONTROL
                if(!empty($JsonData["kontrol"])){
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-12">';
                    echo '      <b>E. Kontrol</b>';
                    echo '      <ol>';
                    echo '          <li>';
                    echo '              Nomor Surat : ';
                                        if(!empty($JsonData["kontrol"]["noSurat"])){
                                            echo '<code class="text-secondary">'.$JsonData["kontrol"]["noSurat"].'</code>';
                                        }else{
                                            echo '<code class="text-danger">Tidak Ada</code>';
                                        }
                    echo '          </li>';
                    echo '          <li>';
                    echo '              Kode Dokter : ';
                                        if(!empty($JsonData["kontrol"]["kdDokter"])){
                                            echo '<code class="text-secondary">'.$JsonData["kontrol"]["kdDokter"].'</code>';
                                        }else{
                                            echo '<code class="text-danger">Tidak Ada</code>';
                                        }
                    echo '          </li>';
                    echo '          <li>';
                    echo '              Nama Dokter : ';
                                        if(!empty($JsonData["kontrol"]["nmDokter"])){
                                            echo '<code class="text-secondary">'.$JsonData["kontrol"]["nmDokter"].'</code>';
                                        }else{
                                            echo '<code class="text-danger">Tidak Ada</code>';
                                        }
                    echo '          </li>';
                    echo '      </ol>';
                    echo '  </div>';
                    echo '</div>';
                }
                //JASA RAHARJA
                echo '<div class="row mb-3">';
                echo '  <div class="col-md-12">';
                echo '      <b>F. Suplesi Jasa Raharja</b>';
                echo '      <ol>';
                echo '          <li>';
                echo '              Kode Status Kecelakaan : ';
                                    if(!empty($JsonData["kdStatusKecelakaan"])){
                                        echo '<code class="text-secondary">'.$JsonData["kdStatusKecelakaan"].'</code>';
                                    }else{
                                        echo '<code class="text-danger">Tidak Ada</code>';
                                    }
                echo '          </li>';
                echo '          <li>';
                echo '              Nama Status Kecelakaan : ';
                                    if(!empty($JsonData["nmstatusKecelakaan"])){
                                        echo '<code class="text-secondary">'.$JsonData["nmstatusKecelakaan"].'</code>';
                                    }else{
                                        echo '<code class="text-danger">Tidak Ada</code>';
                                    }
                echo '          </li>';
                echo '          <li>';
                echo '              Uraian Kejadian : ';
                echo '              <ol>';
                echo '                  <li>';
                echo '                      Tanggal Kejadian : ';
                                            if(!empty($JsonData['lokasiKejadian']["tglKejadian"])){
                                                echo '<code class="text-secondary">'.$JsonData["lokasiKejadian"]["tglKejadian"].'</code>';
                                            }else{
                                                echo '<code class="text-danger">Tidak Ada</code>';
                                            }
                echo '                  </li>';
                echo '                  <li>';
                echo '                      Provinsi : ';
                                            if(!empty($JsonData['lokasiKejadian']["kdProp"])){
                                                echo '<code class="text-secondary">'.$JsonData["lokasiKejadian"]["kdProp"].'</code>';
                                            }else{
                                                echo '<code class="text-danger">Tidak Ada</code>';
                                            }
                echo '                  </li>';
                echo '                  <li>';
                echo '                      Kabupaten : ';
                                            if(!empty($JsonData['lokasiKejadian']["kdKab"])){
                                                echo '<code class="text-secondary">'.$JsonData["lokasiKejadian"]["kdKab"].'</code>';
                                            }else{
                                                echo '<code class="text-danger">Tidak Ada</code>';
                                            }
                echo '                  </li>';
                echo '                  <li>';
                echo '                      Kecamatan : ';
                                            if(!empty($JsonData['lokasiKejadian']["kdKec"])){
                                                echo '<code class="text-secondary">'.$JsonData["lokasiKejadian"]["kdKec"].'</code>';
                                            }else{
                                                echo '<code class="text-danger">Tidak Ada</code>';
                                            }
                echo '                  </li>';
                echo '                  <li>';
                echo '                      Keterangan Kejadian : ';
                                            if(!empty($JsonData['lokasiKejadian']["ketKejadian"])){
                                                echo '<code class="text-secondary">'.$JsonData["lokasiKejadian"]["ketKejadian"].'</code>';
                                            }else{
                                                echo '<code class="text-danger">Tidak Ada</code>';
                                            }
                echo '                  </li>';
                echo '                  <li>';
                echo '                      Lokasi : ';
                                            if(!empty($JsonData['lokasiKejadian']["lokasi"])){
                                                echo '<code class="text-secondary">'.$JsonData["lokasiKejadian"]["lokasi"].'</code>';
                                            }else{
                                                echo '<code class="text-danger">Tidak Ada</code>';
                                            }
                echo '                  </li>';
                echo '              </ol>';
                echo '          </li>';
                echo '      </ol>';
                echo '  </div>';
                echo '</div>'; 
                //JASA RAHARJA
                echo '<div class="row mb-3">';
                echo '  <div class="col-md-12">';
                echo '      <b>G. Informasi Lainnya</b>';
                echo '      <ol>';
                echo '          <li>';
                echo '              Tujuan Kunjungan : ';
                                    if(!empty($JsonData["tujuanKunj"]["nama"])){
                                        echo '<code class="text-secondary">'.$JsonData["tujuanKunj"]["kode"].'-'.$JsonData["tujuanKunj"]["nama"].'</code>';
                                    }else{
                                        echo '<code class="text-danger">Tidak Ada</code>';
                                    }
                echo '          </li>';
                echo '          <li>';
                echo '              Flag Procedure : ';
                                    if(!empty($JsonData["flagProcedure"]["nama"])){
                                        echo '<code class="text-secondary">'.$JsonData["flagProcedure"]["kode"].'-'.$JsonData["flagProcedure"]["nama"].'</code>';
                                    }else{
                                        echo '<code class="text-danger">Tidak Ada</code>';
                                    }
                echo '          </li>';
                echo '          <li>';
                echo '              Kode Penunjang : ';
                                    if(!empty($JsonData["kdPenunjang"]["nama"])){
                                        echo '<code class="text-secondary">'.$JsonData["kdPenunjang"]["kode"].'-'.$JsonData["kdPenunjang"]["nama"].'</code>';
                                    }else{
                                        echo '<code class="text-danger">Tidak Ada</code>';
                                    }
                echo '          </li>';
                echo '          <li>';
                echo '              Assesment Pelayanan : ';
                                    if(!empty($JsonData["assestmenPel"]["nama"])){
                                        echo '<code class="text-secondary">'.$JsonData["assestmenPel"]["kode"].'-'.$JsonData["assestmenPel"]["nama"].'</code>';
                                    }else{
                                        echo '<code class="text-danger">Tidak Ada</code>';
                                    }
                echo '          </li>';
                echo '          <li>';
                echo '              Assesment Pelayanan : ';
                                    if(!empty($JsonData["assestmenPel"]["nama"])){
                                        echo '<code class="text-secondary">'.$JsonData["assestmenPel"]["kode"].'-'.$JsonData["assestmenPel"]["nama"].'</code>';
                                    }else{
                                        echo '<code class="text-danger">Tidak Ada</code>';
                                    }
                echo '          </li>';
                echo '          <li>';
                echo '              eSEP : ';
                                    if(!empty($JsonData["eSEP"])){
                                        echo '<code class="text-secondary">'.$JsonData["eSEP"].'</code>';
                                    }else{
                                        echo '<code class="text-danger">Tidak Ada</code>';
                                    }
                echo '          </li>';
                echo '      </ol>';
                echo '  </div>';
                echo '</div>'; 
            }
        }
    }
?>
