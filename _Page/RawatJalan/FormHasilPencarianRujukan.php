<?php
    date_default_timezone_set('UTC');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingBridging.php";
    include "../../_Config/SimrsFunction.php";
    include "../../vendor/autoload.php";
    if(empty($_POST['KeywordNomorKartu'])){
        echo '  <di class="row">';
        echo '      <di class="col-md-12 text-center text-danger">';
        echo '          Isi Terlebih Dulu Nomor BPJS Pasien';
        echo '      </di>';
        echo '  </di>';
    }else{
        if(empty($_POST['SumberRujukan1'])&&empty($_POST['SumberRujukan2'])){
            echo '  <di class="row">';
            echo '      <di class="col-md-12 text-center text-danger">';
            echo '          Pilih Dasar Pencarian Rujukan Terlebih Dulu.';
            echo '      </di>';
            echo '  </di>';
        }else{
            if(empty($_POST['SumberRujukan1'])){
                $TipeRujukan="4";
            }else{
                $TipeRujukan="1";
            }
            $KeywordNomorKartu=$_POST['KeywordNomorKartu'];
            $Response=RujukanByKartu($url_vclaim,$consid,$secret_key,$user_key,$KeywordNomorKartu,$TipeRujukan);
            if(empty($Response)){
                echo '<div class="row">';
                echo '  <div class="col-md-12 text-center text-danger">';
                echo '      Terjadi kesalahan pada service BPJS.';
                echo '  </div>';
                echo '</div>';
            }else{
                $ambil_json =json_decode($Response, true);
                if(empty($ambil_json["metaData"]["code"])){
                    echo '<div class="row">';
                    echo '  <div class="col-md-12 text-center text-danger"><dt>Terjadi Kesalahan Pada Service BPJS!</dt> '.$ResponseData.'</div>';
                    echo '</div>';
                }else{
                    if($ambil_json["metaData"]["code"]!=="200"){
                        $PesanKesalahan=$ambil_json["metaData"]["message"];
                        echo '<div class="row">';
                        echo '  <div class="col-md-12 text-center text-danger"><dt>Terjadi Kesalahan Pada Service BPJS! '.$TipeRujukan.'</dt> Pesan: '.$PesanKesalahan.'</div>';
                        echo '</div>';
                    }else{
                        if(empty($ambil_json["response"])){
                            echo '<div class="row">';
                            echo '  <div class="col-md-12 text-center text-danger"><dt>Terjadi Kesalahan Pada Service BPJS!</dt> '.$ResponseData.'</div>';
                            echo '</div>';
                        }else{
                            $string=$ambil_json["response"];
                            //Proses decode dan dekompresi
                            //--membuat key
                            $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
                            $key="$consid$secret_key$timestamp";
                            //--masukan ke fungsi
                            $FileDeskripsi=stringDecrypt("$key", "$string");
                            $FileDekompresi=decompress("$FileDeskripsi");
                            $FileDekompresiJson =json_decode($FileDekompresi, true);
                            //--konveris json to raw
                            if(empty(json_decode($FileDekompresi, true))){
                                echo '<div class="row">';
                                echo '  <div class="col-md-12 text-center text-danger"><dt>Proses Decrypt Gagal!</dt> Terjadi kesalahan pada saat melakukan proses deskripsi</div>';
                                echo '</div>';
                            }else{
                                if(empty($FileDekompresiJson['rujukan'])){
                                    echo '<div class="row">';
                                    echo '  <div class="col-md-12 text-center text-danger"><dt>Tidak ada rujukan yang ditemukan!</dt> '.$PesanKesalahan.'</div>';
                                    echo '</div>';
                                }else{
                                    $JsonData =json_decode($FileDekompresi, true);
                                    $list=$JsonData['rujukan'];
                                    $Jumlah=count($list);
                                    echo '<div class="row mb-4">';
                                    echo '  <div class="col col-md-12 pre-scrollable">';
                                    echo '      <ul  class="list-group">';
                                    $no=1;
                                    for($a=0; $a<$Jumlah; $a++){
                                        $noKunjungan=$list[$a]['noKunjungan'];
                                        $kodediagnosa=$list[$a]['diagnosa']['kode'];
                                        $namadiagnosa=$list[$a]['diagnosa']['nama'];
                                        $tglKunjungan=$list[$a]['tglKunjungan'];
                                        $provPerujuk=$list[$a]['provPerujuk'];
                                        $kodeprovPerujuk=$list[$a]['provPerujuk']['kode'];
                                        $namaprovPerujuk=$list[$a]['provPerujuk']['nama'];
                                        echo '  <li class="list-group-item">';
                                        echo '      <dt><input type="radio" id="ItemPilihRujukan'.$no.'" name="ItemPilihRujukan" value="'.$noKunjungan.'-'.$kodeprovPerujuk.'"> <label for="ItemPilihRujukan'.$no.'">'.$noKunjungan.'</label></dt>';
                                        echo '      <small class="text-mutted">Diagnosa : '.$kodediagnosa.'-'.$namadiagnosa.'</small><br>';
                                        echo '      <small class="text-mutted">Provider : '.$kodeprovPerujuk.'. '.$namaprovPerujuk.'</small><br>';
                                        echo '      <small>Tanggal : '.$tglKunjungan.'</small>';
                                        echo '  </li>';
                                        $no++;
                                    }
                                    echo '      </ul>';
                                    echo '  </div>';
                                    echo '</div>';
                                    echo '<div class="row mb-3">';
                                    echo '  <div class="col col-md-12">';
                                    echo '      <span class="text-primary" id="NotifikasiTambahkanRujukanKeForm">';
                                    echo '          Silahkan pilih salah satu data Rujukan di atas kemudian tambahkan pada form.';
                                    echo '      </span>';
                                    echo '  </div>';
                                    echo '</div>';
                                    echo '<div class="row">';
                                    echo '  <div class="col col-md-12">';
                                    echo '      <button type="submit" class="btn btn-sm btn-secondary btn-block">';
                                    echo '          <i class="ti ti-arrow-circle-down"></i> Tambahkan Ke Form';
                                    echo '      </button>';
                                    echo '  </div>';
                                    echo '</div>';
                                }
                            }
                        }
                    }
                }
            }
        }
    }
?>