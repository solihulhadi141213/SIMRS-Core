<?php
    date_default_timezone_set('UTC');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingBridging.php";
    include "../../_Config/SimrsFunction.php";
    include "../../vendor/autoload.php";
    //keyword
    if(empty($_POST['keyword'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center text-danger">';
        echo '      Isi Terlebih Dulu Kata Kunci Untuk Memulai Pencarian.';
        echo '  </div>';
        echo '</div>';
    }else{
        if(empty($_POST['JenisFaskes'])){
            echo '<div class="row">';
            echo '  <div class="col-md-12 text-center text-danger">';
            echo '      Pilih Kategori Faskes Terlebih Dulu Untuk Memulai Pencarian.';
            echo '  </div>';
            echo '</div>';
        }else{
            $keyword=$_POST['keyword'];
            $JenisFaskes=$_POST['JenisFaskes'];
            $url="$url_vclaim/referensi/faskes/$keyword/$JenisFaskes";
            $Response=PencarianPpk($url_vclaim,$consid,$secret_key,$user_key,$url);
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
                        echo '  <div class="col-md-12 text-center text-danger"><dt>Terjadi Kesalahan Pada Service BPJS!</dt> '.$PesanKesalahan.'</div>';
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
                                if(empty($FileDekompresiJson['faskes'])){
                                    echo '<div class="row">';
                                    echo '  <div class="col-md-12 text-center text-danger"><dt>Tidak ada faskes yang ditemukan!</dt> '.$PesanKesalahan.'</div>';
                                    echo '</div>';
                                }else{
                                    $JsonData =json_decode($FileDekompresi, true);
                                    $list=$JsonData['faskes'];
                                    $Jumlah=count($list);
                                    echo '<div class="row mb-4">';
                                    echo '  <div class="col col-md-12 pre-scrollable">';
                                    echo '      <div  class="list-group">';
                                    for($a=0; $a<$Jumlah; $a++){
                                        $kode=$list[$a]['kode'];
                                        $nama=$list[$a]['nama'];
                                        echo '  <a href="javascript:void(0);" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#ModalKonfirmasiPPK" data-id="'.$kode.'">';
                                        echo '      <dt>'.$kode.'</dt>'.$nama.'';
                                        echo '  </a>';
                                    }
                                    echo '      </div>';
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