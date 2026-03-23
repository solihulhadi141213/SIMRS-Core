<?php
    //Koneksi
    date_default_timezone_set('UTC');
    include "../../_Config/Connection.php";
    include "../../_Config/SettingBridging.php";
    include "../../_Config/SimrsFunction.php";
    include "../../vendor/autoload.php";
    //Menangkap parameter
    if(empty($_POST['nomorkartu'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center text-danger">';
        echo '      Nomor Kartu BPJS harus Diisi Terlebih Dulu!';
        echo '  </div>';
        echo '</div>';
    }else{
        if(empty($_POST['metode_pembayaran'])){
            echo '<div class="row">';
            echo '  <div class="col-md-12 text-center text-danger">';
            echo '      Metode Pembayaran Harus Diisi Terlebih Dulu!';
            echo '  </div>';
            echo '</div>';
        }else{
            $nomorkartu=$_POST['nomorkartu'];
            $metode_pembayaran=$_POST['metode_pembayaran'];
            if($metode_pembayaran!=="BPJS"){
                echo '<div class="row">';
                echo '  <div class="col-md-12 text-center text-danger">';
                echo '      Pencarian Rujukan Hanya Untuk Pasien BPJS!';
                echo '  </div>';
                echo '</div>';
            }else{
                if(empty($_POST['jeniskunjungan'])){
                    echo '<div class="row">';
                    echo '  <div class="col-md-12 text-center text-danger">';
                    echo '      Pilih Jenis Kunjungan Terlebih Dulu!';
                    echo '  </div>';
                    echo '</div>';
                }else{
                    $jeniskunjungan=$_POST['jeniskunjungan'];
                    if($jeniskunjungan=="1"||$jeniskunjungan=="4"){
                        $Pencarian=RujukanByKartu($url_vclaim,$consid,$secret_key,$user_key,$nomorkartu,$jeniskunjungan);
                        if(empty($Pencarian)){
                            echo '<div class="row">';
                            echo '  <div class="col-md-12 text-center text-danger">';
                            echo '      Tidak Ada Response Dari Service BPJS, Pastikan Anda Melakukan Pengaturan Bridging BPJS Dengan Benar!';
                            echo '  </div>';
                            echo '</div>';
                        }else{
                            $ambil_json =json_decode($Pencarian, true);
                            if($ambil_json["metaData"]["code"]!=="200"){
                                echo '<div class="row">';
                                echo '  <div class="col-md-12 text-center text-danger">';
                                echo '      '.$ambil_json["metaData"]["message"].'';
                                echo '  </div>';
                                echo '</div>';
                            }else{
                                $string=$ambil_json["response"];
                                $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
                                $key="$consid$secret_key$timestamp";
                                $FileDeskripsi=stringDecrypt("$key", "$string");
                                $FileDekompresi=decompress("$FileDeskripsi");
                                //--konveris json to raw
                                $JsonData =json_decode($FileDekompresi, true);
                                //Tampilkan Data Untuk Rujukan FKTP
                                if(empty($JsonData['rujukan'])){
                                    echo '<div class="row">';
                                    echo '  <div class="col-md-12 text-center text-danger">';
                                    echo '      '.$FileDekompresi.'';
                                    echo '  </div>';
                                    echo '</div>';
                                }else{
                                    $rujukan=$JsonData['rujukan'];
                                    if(empty(count($rujukan))){
                                        echo '<div class="row">';
                                        echo '  <div class="col-md-12 text-center text-danger">';
                                        echo '      List Rujukan Tidak Bisa Ditampilkan';
                                        echo '  </div>';
                                        echo '</div>';
                                    }else{
                                        echo '<div class="row mb-3">';
                                        echo '  <div class="col-md-12 table table-responsive pre-scrollable">';
                                        echo '      <table class="table table-hover">';
                                        echo '          <thead>';
                                        echo '              <tr>';
                                        echo '                  <th align="center"><dt>NO</dt></th>';
                                        echo '                  <th align="center"><dt>No.Rujukan</dt></th>';
                                        echo '              </tr>';
                                        echo '          </thead>';
                                        echo '          <tbody>';
                                        $no=1;
                                        $Jumlah=count($JsonData['rujukan']);
                                        $list=$JsonData['rujukan'];
                                        for($a=0; $a<$Jumlah; $a++){
                                            $noKunjungan=$list[$a]['noKunjungan'];
                                            $tglKunjungan=$list[$a]['tglKunjungan'];
                                            $NamaPelayanan=$list[$a]['pelayanan']['nama'];
                                            $NamaProvider=$list[$a]['provPerujuk']['nama'];
                                            echo '<tr>';
                                            echo '  <td class=" text-center">'.$no.'</td>';
                                            echo '  <td>';
                                            echo '      <input type="radio" name="NomorReferensiToAdd" id="NomorReferensiToAdd'.$no.'" value="'.$noKunjungan.'">';
                                            echo '      <label for="NomorReferensiToAdd'.$no.'"><dt>'.$noKunjungan.'</dt></label><br>';
                                            echo '      <small>Tgl: '.$tglKunjungan.'</small><br>';
                                            echo '      <small>Pelayanan: '.$NamaPelayanan.'</small><br>';
                                            echo '      <small>Dari: '.$NamaProvider.'</small>';
                                            echo '  </td>';
                                            echo '</tr>';
                                            $no++;
                                        }
                                        echo '          </tbody>';
                                        echo '      </table>';
                                        echo '  </div>';
                                        echo '</div>';
                                    }
                                }
                            }
                        }
                    }else{
                        if($jeniskunjungan=="2"||$jeniskunjungan=="3"){
                            if(empty($_POST['TanggalKunjungan'])){
                                echo '<div class="row">';
                                echo '  <div class="col-md-12 text-center text-danger">';
                                echo '      Tanggal Rencana Kunjungan Tidak Boleh Kosong!!';
                                echo '  </div>';
                                echo '</div>';
                            }else{
                                $TanggalKunjungan=$_POST['TanggalKunjungan'];
                                //Strtotime
                                $Strtotime=strtotime($TanggalKunjungan);
                                $Bulan=date('m',$Strtotime);
                                $Tahun=date('Y',$Strtotime);
                                $Pencarian=SuratKontrolByKartu($url_vclaim,$consid,$secret_key,$user_key,$nomorkartu,$Bulan,$Tahun);
                                if(empty($Pencarian)){
                                    echo '<div class="row">';
                                    echo '  <div class="col-md-12 text-center text-danger">';
                                    echo '      Tidak Ada Response Dari Service BPJS, Pastikan Anda Melakukan Pengaturan Bridging BPJS Dengan Benar!';
                                    echo '  </div>';
                                    echo '</div>';
                                }else{
                                    $ambil_json =json_decode($Pencarian, true);
                                    if($ambil_json["metaData"]["code"]!=="200"){
                                        echo '<div class="row">';
                                        echo '  <div class="col-md-12 text-center text-danger">';
                                        echo '      '.$ambil_json["metaData"]["message"].'';
                                        echo '  </div>';
                                        echo '</div>';
                                    }else{
                                        $string=$ambil_json["response"];
                                        $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
                                        $key="$consid$secret_key$timestamp";
                                        $FileDeskripsi=stringDecrypt("$key", "$string");
                                        $FileDekompresi=decompress("$FileDeskripsi");
                                        //--konveris json to raw
                                        $JsonData =json_decode($FileDekompresi, true);
                                        //Tampilkan Data Untuk Rujukan FKTP
                                        if(empty($JsonData['list'])){
                                            echo '<div class="row">';
                                            echo '  <div class="col-md-12 text-center text-danger">';
                                            echo '      '.$FileDekompresi.'';
                                            echo '  </div>';
                                            echo '</div>';
                                        }else{
                                            $rujukan=$JsonData['list'];
                                            if(empty(count($rujukan))){
                                                echo '<div class="row">';
                                                echo '  <div class="col-md-12 text-center text-danger">';
                                                echo '      List Rujukan Tidak Bisa Ditampilkan';
                                                echo '  </div>';
                                                echo '</div>';
                                            }else{
                                                if($jeniskunjungan=="3"){
                                                    echo '<div class="row mb-3">';
                                                    echo '  <div class="col-md-12 table table-responsive pre-scrollable">';
                                                    echo '      <table class="table table-hover">';
                                                    echo '          <thead>';
                                                    echo '              <tr>';
                                                    echo '                  <th align="center"><dt>NO</dt></th>';
                                                    echo '                  <th align="center"><dt>No.Surat Kontrol</dt></th>';
                                                    echo '              </tr>';
                                                    echo '          </thead>';
                                                    echo '          <tbody>';
                                                    $no=1;
                                                    $Jumlah=count($rujukan);
                                                    $list=$rujukan;
                                                    for($a=0; $a<$Jumlah; $a++){
                                                        $noSuratKontrol=$list[$a]['noSuratKontrol'];
                                                        $jnsPelayanan=$list[$a]['jnsPelayanan'];
                                                        $tglRencanaKontrol=$list[$a]['tglRencanaKontrol'];
                                                        $namaJnsKontrol=$list[$a]['namaJnsKontrol'];
                                                        if($namaJnsKontrol=="Surat Kontrol"){
                                                            echo '<tr>';
                                                            echo '  <td class=" text-center">'.$no.'</td>';
                                                            echo '  <td>';
                                                            echo '      <input type="radio" name="NomorReferensiToAdd" id="NomorReferensiToAdd'.$no.'" value="'.$noSuratKontrol.'">';
                                                            echo '      <label for="NomorReferensiToAdd'.$no.'"><dt>'.$noSuratKontrol.'</dt></label><br>';
                                                            echo '      <small>Tgl: '.$tglRencanaKontrol.'</small><br>';
                                                            echo '      <small>Pelayanan: '.$jnsPelayanan.'</small><br>';
                                                            echo '      <small>Kategori: '.$namaJnsKontrol.'</small><br>';
                                                            echo '  </td>';
                                                            echo '</tr>';
                                                        }
                                                        $no++;
                                                    }
                                                    echo '          </tbody>';
                                                    echo '      </table>';
                                                    echo '  </div>';
                                                    echo '</div>';
                                                }else{
                                                    echo '<div class="row mb-3">';
                                                    echo '  <div class="col-md-12 table table-responsive pre-scrollable">';
                                                    echo '      <table class="table table-hover">';
                                                    echo '          <thead>';
                                                    echo '              <tr>';
                                                    echo '                  <th align="center"><dt>NO</dt></th>';
                                                    echo '                  <th align="center"><dt>No.Rujukan Internal</dt></th>';
                                                    echo '              </tr>';
                                                    echo '          </thead>';
                                                    echo '          <tbody>';
                                                    $no=1;
                                                    $Jumlah=count($rujukan);
                                                    $list=$rujukan;
                                                    for($a=0; $a<$Jumlah; $a++){
                                                        $noSuratKontrol=$list[$a]['noSuratKontrol'];
                                                        $jnsPelayanan=$list[$a]['jnsPelayanan'];
                                                        $tglRencanaKontrol=$list[$a]['tglRencanaKontrol'];
                                                        $namaJnsKontrol=$list[$a]['namaJnsKontrol'];
                                                        if($namaJnsKontrol=="SPRI"){
                                                            echo '<tr>';
                                                            echo '  <td class=" text-center">'.$no.'</td>';
                                                            echo '  <td>';
                                                            echo '      <input type="radio" name="NomorReferensiToAdd" id="NomorReferensiToAdd'.$no.'" value="'.$noSuratKontrol.'">';
                                                            echo '      <label for="NomorReferensiToAdd'.$no.'"><dt>'.$noSuratKontrol.'</dt></label><br>';
                                                            echo '      <small>Tgl: '.$tglRencanaKontrol.'</small><br>';
                                                            echo '      <small>Pelayanan: '.$jnsPelayanan.'</small><br>';
                                                            echo '      <small>Kategori: '.$namaJnsKontrol.'</small><br>';
                                                            echo '  </td>';
                                                            echo '</tr>';
                                                        }
                                                        $no++;
                                                    }
                                                    echo '          </tbody>';
                                                    echo '      </table>';
                                                    echo '  </div>';
                                                    echo '</div>';
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }else{
                            echo '<div class="row">';
                            echo '  <div class="col-md-12 text-center text-danger">';
                            echo '      Jenis Kunjungan Tidak Diketahui!';
                            echo '  </div>';
                            echo '</div>';
                        }
                    }
                }
            }
        }
    }
?>