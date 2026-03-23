<?php
    date_default_timezone_set('UTC');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/SettingBridging.php";
    include "../../vendor/autoload.php";
    if(empty($_POST['no_rujukan'])){
        echo '<div class="row mb-3">';
        echo '  <div class="col-md-12 text-center text-danger">';
        echo '      Nomor Rujukan Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        $no_rujukan=$_POST['no_rujukan'];
        $urlrujukan="$url_vclaim/Rujukan/$no_rujukan";
        $KontenRujukan=DetailReferensi($url_vclaim,$consid,$secret_key,$user_key,$urlrujukan,$no_rujukan);
        if(empty($KontenRujukan)){
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-12 text-center text-danger">';
            echo '      Rujukan Tidak Ditemukan Pada Service BPJS!<br>';
            echo '      <small>Ini mungkin bisa terjadi karena tidak ada koneksi ke service BPJS</small>';
            echo '  </div>';
            echo '</div>';
        }else{
            $ambil_json =json_decode($KontenRujukan, true);
            if(empty($ambil_json["response"])){
                echo '<div class="row mb-3">';
                echo '  <div class="col-md-12 text-center text-danger">';
                echo '      Rujukan Tidak Ditemukan Pada Service BPJS!<br>';
                echo '      <small>Ini mungkin bisa terjadi karena tidak ada koneksi ke service BPJS</small><br>';
                echo '      <code>'.$KontenRujukan.'</code>';
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
                if(empty($JsonData['rujukan'])){
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-12 text-center text-danger">';
                    echo '      SEP Tidak Ditemukan Pada Service BPJS!<br>';
                    echo '      <small>Ini mungkin bisa terjadi karena tidak ada koneksi ke service BPJS</small><br>';
                    echo '      <div class="pre-scrollable"><code>'.$KontenRujukan.'</code></div>';
                    echo '  </div>';
                    echo '</div>';
                }else{
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-12">';
                    echo '      Detail Rujukan';
                    echo '      <ol>';
                    if(!empty($JsonData['rujukan']['diagnosa'])){
                        echo '          <li class="mb-3">';
                        echo '              Diagnosa';
                        echo '              <ul>';
                        echo '                  <li>';
                        echo '                      Kode : ';
                                                    if(!empty($JsonData['rujukan']['diagnosa']['kode'])){
                                                        echo '<code class="text-secondary">'.$JsonData['rujukan']['diagnosa']['kode'].'</code>';
                                                    }else{
                                                        echo '<code class="text-danger">Tidak Ada</code>';
                                                    }
                        echo '                  </li>';
                        echo '                  <li>';
                        echo '                      Nama : ';
                                                    if(!empty($JsonData['rujukan']['diagnosa']['nama'])){
                                                        echo '<code class="text-secondary">'.$JsonData['rujukan']['diagnosa']['nama'].'</code>';
                                                    }else{
                                                        echo '<code class="text-danger">Tidak Ada</code>';
                                                    }
                        echo '                  </li>';
                        echo '              </ul>';
                        echo '          </li>';
                    }
                    if(!empty($JsonData['rujukan']['keluhan'])){
                        echo '          <li class="mb-3">';
                        echo '              Keluhan :';
                        if(!empty($JsonData['rujukan']['keluhan'])){
                            echo '<code class="text-secondary">'.$JsonData['rujukan']['keluhan'].'</code>';
                        }else{
                            echo '<code class="text-danger">Tidak Ada</code>';
                        }
                        echo '          </li>';
                    }
                    if(!empty($JsonData['rujukan']['noKunjungan'])){
                        echo '          <li class="mb-3">';
                        echo '              Nomor Kunjungan :';
                        if(!empty($JsonData['rujukan']['noKunjungan'])){
                            echo '<code class="text-secondary">'.$JsonData['rujukan']['noKunjungan'].'</code>';
                        }else{
                            echo '<code class="text-danger">Tidak Ada</code>';
                        }
                        echo '          </li>';
                    }
                    if(!empty($JsonData['rujukan']['pelayanan'])){
                        echo '          <li class="mb-3">';
                        echo '              Pelayanan';
                        echo '              <ul>';
                        echo '                  <li>';
                        echo '                      Kode : ';
                                                    if(!empty($JsonData['rujukan']['pelayanan']['kode'])){
                                                        echo '<code class="text-secondary">'.$JsonData['rujukan']['pelayanan']['kode'].'</code>';
                                                    }else{
                                                        echo '<code class="text-danger">Tidak Ada</code>';
                                                    }
                        echo '                  </li>';
                        echo '                  <li>';
                        echo '                      Nama : ';
                                                    if(!empty($JsonData['rujukan']['pelayanan']['nama'])){
                                                        echo '<code class="text-secondary">'.$JsonData['rujukan']['pelayanan']['nama'].'</code>';
                                                    }else{
                                                        echo '<code class="text-danger">Tidak Ada</code>';
                                                    }
                        echo '                  </li>';
                        echo '              </ul>';
                        echo '          </li>';
                    }
                    if(!empty($JsonData['rujukan']['peserta'])){
                        echo '          <li class="mb-3">';
                        echo '              Peserta';
                        echo '              <ol>';
                        echo '                  <li class="mb-3">';
                        echo '                      COB : ';
                                                    if(!empty($JsonData['rujukan']['peserta']['cob'])){
                                                        echo '<ul>';
                                                        if(!empty($JsonData['rujukan']['peserta']['cob']['nmAsuransi'])){
                                                            echo '<li><code class="text-secondary">Nama Asuransi : '.$JsonData['rujukan']['peserta']['cob']['nmAsuransi'].'</code></li>';
                                                        }
                                                        if(!empty($JsonData['rujukan']['peserta']['cob']['noAsuransi'])){
                                                            echo '<li><code class="text-secondary">Nama Asuransi : '.$JsonData['rujukan']['peserta']['cob']['noAsuransi'].'</code></li>';
                                                        }
                                                        if(!empty($JsonData['rujukan']['peserta']['cob']['tglTAT'])){
                                                            echo '<li><code class="text-secondary">Nama Asuransi : '.$JsonData['rujukan']['peserta']['cob']['tglTAT'].'</code></li>';
                                                        }
                                                        if(!empty($JsonData['rujukan']['peserta']['cob']['tglTMT'])){
                                                            echo '<li><code class="text-secondary">Nama Asuransi : '.$JsonData['rujukan']['peserta']['cob']['tglTMT'].'</code></li>';
                                                        }
                                                        echo '</ul>';
                                                    }else{
                                                        echo '<code class="text-danger">Tidak Ada</code>';
                                                    }
                        echo '                  </li>';
                        echo '                  <li class="mb-3">';
                        echo '                      Hak Kelas : ';
                                                    if(!empty($JsonData['rujukan']['peserta']['hakKelas'])){
                                                        echo '<ul>';
                                                        if(!empty($JsonData['rujukan']['peserta']['hakKelas']['keterangan'])){
                                                            echo '<li><code class="text-secondary">Keterangan : '.$JsonData['rujukan']['peserta']['hakKelas']['keterangan'].'</code></li>';
                                                        }
                                                        if(!empty($JsonData['rujukan']['peserta']['hakKelas']['kode'])){
                                                            echo '<li><code class="text-secondary">Kode : '.$JsonData['rujukan']['peserta']['hakKelas']['kode'].'</code></li>';
                                                        }
                                                        echo '</ul>';
                                                    }else{
                                                        echo '<code class="text-danger">Tidak Ada</code>';
                                                    }
                        echo '                  </li>';
                        echo '                  <li class="mb-3">';
                        echo '                      Informasi : ';
                                                    if(!empty($JsonData['rujukan']['peserta']['informasi'])){
                                                        echo '<ul>';
                                                        if(!empty($JsonData['rujukan']['peserta']['informasi']['dinsos'])){
                                                            echo '<li><code class="text-secondary">Dinsos : '.$JsonData['rujukan']['peserta']['informasi']['dinsos'].'</code></li>';
                                                        }
                                                        if(!empty($JsonData['rujukan']['peserta']['informasi']['kode'])){
                                                            echo '<li><code class="text-secondary">No.SKTM : '.$JsonData['rujukan']['peserta']['informasi']['noSKTM'].'</code></li>';
                                                        }
                                                        if(!empty($JsonData['rujukan']['peserta']['informasi']['prolanisPRB'])){
                                                            echo '<li><code class="text-secondary">Prolanis PRB : '.$JsonData['rujukan']['peserta']['informasi']['prolanisPRB'].'</code></li>';
                                                        }
                                                        echo '</ul>';
                                                    }else{
                                                        echo '<code class="text-danger">Tidak Ada</code>';
                                                    }
                        echo '                  </li>';
                        echo '                  <li class="mb-3">';
                        echo '                      Jenis Peserta : ';
                                                    if(!empty($JsonData['rujukan']['peserta']['jenisPeserta'])){
                                                        echo '<ul>';
                                                        if(!empty($JsonData['rujukan']['peserta']['jenisPeserta']['keterangan'])){
                                                            echo '<li><code class="text-secondary">Keterangan : '.$JsonData['rujukan']['peserta']['jenisPeserta']['keterangan'].'</code></li>';
                                                        }
                                                        if(!empty($JsonData['rujukan']['peserta']['jenisPeserta']['kode'])){
                                                            echo '<li><code class="text-secondary">Kode : '.$JsonData['rujukan']['peserta']['jenisPeserta']['kode'].'</code></li>';
                                                        }
                                                        echo '</ul>';
                                                    }else{
                                                        echo '<code class="text-danger">Tidak Ada</code>';
                                                    }
                        echo '                  </li>';
                        echo '                  <li class="mb-3">';
                        echo '                      MR : ';
                                                    if(!empty($JsonData['rujukan']['peserta']['mr'])){
                                                        echo '<ul>';
                                                        if(!empty($JsonData['rujukan']['peserta']['mr']['noMR'])){
                                                            echo '<li><code class="text-secondary">No.RM : '.$JsonData['rujukan']['peserta']['mr']['noMR'].'</code></li>';
                                                        }
                                                        if(!empty($JsonData['rujukan']['peserta']['mr']['noTelepon'])){
                                                            echo '<li><code class="text-secondary">No.Telepon : '.$JsonData['rujukan']['peserta']['mr']['noTelepon'].'</code></li>';
                                                        }
                                                        echo '</ul>';
                                                    }else{
                                                        echo '<code class="text-danger">Tidak Ada</code>';
                                                    }
                        echo '                  </li>';
                        echo '                  <li>';
                        echo '                      Nama : ';
                                                    if(!empty($JsonData['rujukan']['peserta']['nama'])){
                                                        echo '<code class="text-secondary">'.$JsonData['rujukan']['peserta']['nama'].'</code></li>';
                                                    }else{
                                                        echo '<code class="text-danger">Tidak Ada</code>';
                                                    }
                        echo '                  </li>';
                        echo '                  <li>';
                        echo '                      NIK : ';
                                                    if(!empty($JsonData['rujukan']['peserta']['nik'])){
                                                        echo '<code class="text-secondary">'.$JsonData['rujukan']['peserta']['nik'].'</code></li>';
                                                    }else{
                                                        echo '<code class="text-danger">Tidak Ada</code>';
                                                    }
                        echo '                  </li>';
                        echo '                  <li>';
                        echo '                      No.BPJS : ';
                                                    if(!empty($JsonData['rujukan']['peserta']['noKartu'])){
                                                        echo '<code class="text-secondary">'.$JsonData['rujukan']['peserta']['noKartu'].'</code></li>';
                                                    }else{
                                                        echo '<code class="text-danger">Tidak Ada</code>';
                                                    }
                        echo '                  </li>';
                        echo '                  <li>';
                        echo '                      Pisa : ';
                                                    if(!empty($JsonData['rujukan']['peserta']['pisa'])){
                                                        echo '<code class="text-secondary">'.$JsonData['rujukan']['peserta']['pisa'].'</code></li>';
                                                    }else{
                                                        echo '<code class="text-danger">Tidak Ada</code>';
                                                    }
                        echo '                  </li>';
                        echo '                  <li>';
                        echo '                      Gender : ';
                                                    if(!empty($JsonData['rujukan']['peserta']['sex'])){
                                                        echo '<code class="text-secondary">'.$JsonData['rujukan']['peserta']['sex'].'</code></li>';
                                                    }else{
                                                        echo '<code class="text-danger">Tidak Ada</code>';
                                                    }
                        echo '                  </li>';
                        echo '                  <li class="mb-3">';
                        echo '                      Provider Umum : ';
                                                    if(!empty($JsonData['rujukan']['peserta']['provUmum'])){
                                                        echo '<ul>';
                                                        if(!empty($JsonData['rujukan']['peserta']['provUmum']['kdProvider'])){
                                                            echo '<li><code class="text-secondary">Kode Provider : '.$JsonData['rujukan']['peserta']['provUmum']['kdProvider'].'</code></li>';
                                                        }
                                                        if(!empty($JsonData['rujukan']['peserta']['provUmum']['nmProvider'])){
                                                            echo '<li><code class="text-secondary">Nama Provider : '.$JsonData['rujukan']['peserta']['provUmum']['nmProvider'].'</code></li>';
                                                        }
                                                        echo '</ul>';
                                                    }else{
                                                        echo '<code class="text-danger">Tidak Ada</code>';
                                                    }
                        echo '                  </li>';
                        echo '                  <li class="mb-3">';
                        echo '                      Status Peserta : ';
                                                    if(!empty($JsonData['rujukan']['peserta']['statusPeserta'])){
                                                        echo '<ul>';
                                                        if(!empty($JsonData['rujukan']['peserta']['statusPeserta']['keterangan'])){
                                                            echo '<li><code class="text-secondary">Keterangan : '.$JsonData['rujukan']['peserta']['statusPeserta']['keterangan'].'</code></li>';
                                                        }
                                                        if(!empty($JsonData['rujukan']['peserta']['statusPeserta']['kode'])){
                                                            echo '<li><code class="text-secondary">Kode : '.$JsonData['rujukan']['peserta']['statusPeserta']['kode'].'</code></li>';
                                                        }
                                                        echo '</ul>';
                                                    }else{
                                                        echo '<code class="text-danger">Tidak Ada</code>';
                                                    }
                        echo '                  </li>';
                        echo '                  <li>';
                        echo '                      Tgl Cetak Kartu : ';
                                                    if(!empty($JsonData['rujukan']['peserta']['tglCetakKartu'])){
                                                        echo '<code class="text-secondary">'.$JsonData['rujukan']['peserta']['tglCetakKartu'].'</code></li>';
                                                    }else{
                                                        echo '<code class="text-danger">Tidak Ada</code>';
                                                    }
                        echo '                  </li>';
                        echo '                  <li>';
                        echo '                      Tgl Lahir : ';
                                                    if(!empty($JsonData['rujukan']['peserta']['tglLahir'])){
                                                        echo '<code class="text-secondary">'.$JsonData['rujukan']['peserta']['tglLahir'].'</code></li>';
                                                    }else{
                                                        echo '<code class="text-danger">Tidak Ada</code>';
                                                    }
                        echo '                  </li>';
                        echo '                  <li>';
                        echo '                      Tgl TAT : ';
                                                    if(!empty($JsonData['rujukan']['peserta']['tglTAT'])){
                                                        echo '<code class="text-secondary">'.$JsonData['rujukan']['peserta']['tglTAT'].'</code></li>';
                                                    }else{
                                                        echo '<code class="text-danger">Tidak Ada</code>';
                                                    }
                        echo '                  </li>';
                        echo '                  <li>';
                        echo '                      Tgl TMT : ';
                                                    if(!empty($JsonData['rujukan']['peserta']['tglTMT'])){
                                                        echo '<code class="text-secondary">'.$JsonData['rujukan']['peserta']['tglTMT'].'</code></li>';
                                                    }else{
                                                        echo '<code class="text-danger">Tidak Ada</code>';
                                                    }
                        echo '                  </li>';
                        echo '                  <li class="mb-3">';
                        echo '                      Umur : ';
                                                    if(!empty($JsonData['rujukan']['peserta']['umur'])){
                                                        echo '<ul>';
                                                        if(!empty($JsonData['rujukan']['peserta']['umur']['umurSaatPelayanan'])){
                                                            echo '<li><code class="text-secondary">Umur Saat Pelayanan : '.$JsonData['rujukan']['peserta']['umur']['umurSaatPelayanan'].'</code></li>';
                                                        }
                                                        if(!empty($JsonData['rujukan']['peserta']['umur']['umurSekarang'])){
                                                            echo '<li><code class="text-secondary">Umur Sekarang : '.$JsonData['rujukan']['peserta']['umur']['umurSekarang'].'</code></li>';
                                                        }
                                                        echo '</ul>';
                                                    }else{
                                                        echo '<code class="text-danger">Tidak Ada</code>';
                                                    }
                        echo '                  </li>';
                        echo '              </ol>';
                        echo '          </li>';
                    }
                    if(!empty($JsonData['rujukan']['poliRujukan'])){
                        echo '          <li class="mb-3">';
                        echo '              Poli Rujukan';
                        echo '              <ul>';
                        echo '                  <li>';
                        echo '                      Kode : ';
                                                    if(!empty($JsonData['rujukan']['poliRujukan']['kode'])){
                                                        echo '<code class="text-secondary">'.$JsonData['rujukan']['poliRujukan']['kode'].'</code>';
                                                    }else{
                                                        echo '<code class="text-danger">Tidak Ada</code>';
                                                    }
                        echo '                  </li>';
                        echo '                  <li>';
                        echo '                      Nama : ';
                                                    if(!empty($JsonData['rujukan']['poliRujukan']['nama'])){
                                                        echo '<code class="text-secondary">'.$JsonData['rujukan']['poliRujukan']['nama'].'</code>';
                                                    }else{
                                                        echo '<code class="text-danger">Tidak Ada</code>';
                                                    }
                        echo '                  </li>';
                        echo '              </ul>';
                        echo '          </li>';
                    }
                    if(!empty($JsonData['rujukan']['provPerujuk'])){
                        echo '          <li class="mb-3">';
                        echo '              Provider Perujuk';
                        echo '              <ul>';
                        echo '                  <li>';
                        echo '                      Kode : ';
                                                    if(!empty($JsonData['rujukan']['provPerujuk']['kode'])){
                                                        echo '<code class="text-secondary">'.$JsonData['rujukan']['provPerujuk']['kode'].'</code>';
                                                    }else{
                                                        echo '<code class="text-danger">Tidak Ada</code>';
                                                    }
                        echo '                  </li>';
                        echo '                  <li>';
                        echo '                      Nama : ';
                                                    if(!empty($JsonData['rujukan']['provPerujuk']['nama'])){
                                                        echo '<code class="text-secondary">'.$JsonData['rujukan']['provPerujuk']['nama'].'</code>';
                                                    }else{
                                                        echo '<code class="text-danger">Tidak Ada</code>';
                                                    }
                        echo '                  </li>';
                        echo '              </ul>';
                        echo '          </li>';
                    }
                    if(!empty($JsonData['rujukan']['tglKunjungan'])){
                        echo '          <li class="mb-3">';
                        echo '              Tanggal Kunjungan :';
                        if(!empty($JsonData['rujukan']['tglKunjungan'])){
                            echo '<code class="text-secondary">'.$JsonData['rujukan']['tglKunjungan'].'</code>';
                        }else{
                            echo '<code class="text-danger">Tidak Ada</code>';
                        }
                        echo '          </li>';
                    }
                    echo '      </ol>';
                    echo '  </div>';
                    echo '</div>';
                }
            }
        }
    }
?>
