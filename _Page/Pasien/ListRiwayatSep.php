<?php
    date_default_timezone_set('UTC');
    include "../../_Config/Connection.php";
    include "../../_Config/SettingBridging.php";
    include "../../_Config/SimrsFunction.php";
    include "../../vendor/autoload.php";
    if(empty($_POST['GetNoKartuPeserta'])){
        echo '<span class="text-danger">Nomor Kartu Tidak Boleh Kosong!</span>';
    }else{
        if(empty($_POST['PeriodeAwal'])){
            echo '<span class="text-danger">Periode Awal Tidak Boleh Kosong!</span>';
        }else{
            if(empty($_POST['PeriodeAkhir'])){
                echo '<span class="text-danger">Periode Akhir Tidak Boleh Kosong!</span>';
            }else{
                $NoKartu=$_POST['GetNoKartuPeserta'];
                $PeriodeAwal=$_POST['PeriodeAwal'];
                $PeriodeAkhir=$_POST['PeriodeAkhir'];
                $timestamp_awal = strtotime($PeriodeAwal);
                $timestamp_akhir = strtotime($PeriodeAkhir);
                if($timestamp_akhir<=$timestamp_awal){
                    echo '<span class="text-danger">Periode Akhir Tidak Boleh Lebih Kecil Dari Pada Periode Awal!</span>';
                }else{
                    $url="$url_vclaim/monitoring/HistoriPelayanan/NoKartu/$NoKartu/tglMulai/$PeriodeAwal/tglAkhir/$PeriodeAkhir";
                    $Response=BridgingServiceGet($consid,$secret_key,$user_key,$url);
                    $ResponseJson =json_decode($Response, true);
                    if(empty($ResponseJson['metaData']['code'])){
                        echo '<div class="row">';
                        echo '  <div class="col-md-12 text-center">';
                        echo '      <span class="text-danger">Tidak Ada Response Dari Service BPJS!</span>';
                        echo '  </div>';
                        echo '</div>';
                    }else{
                        $ResponseCode=$ResponseJson['metaData']['code'];
                        if($ResponseCode!=="200"){
                            echo '<div class="row">';
                            echo '  <div class="col-md-12 text-center">';
                            echo '      <span class="text-danger">Pesan: '.$ResponseJson['metaData']['message'].'</span>';
                            echo '  </div>';
                            echo '</div>';
                        }else{
                            if(empty($ResponseJson['response'])){
                                echo '<div class="row">';
                                echo '  <div class="col-md-12 text-center">';
                                echo '      <dt class="text-danger">Terjadi Kesalahan Pada Response</dt>';
                                echo '      <span class="text-danger">Pesan: '.$ResponseJson['metaData']['message'].'</span>';
                                echo '  </div>';
                                echo '</div>';
                            }else{
                                $string=$ResponseJson['response'];
                                $stringData =json_decode($string, true);
                                $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
                                $key="$consid$secret_key$timestamp";
                                //--masukan ke fungsi
                                $FileDeskripsi=stringDecrypt("$key", "$string");
                                $FileDekompresi=decompress("$FileDeskripsi");
                                //--konveris json to raw
                                $JsonData =json_decode($FileDekompresi, true);
                                if(empty($JsonData['histori'])){
                                    echo '<div class="row">';
                                    echo '  <div class="col-md-12 text-center">';
                                    echo '      <dt class="text-danger">Terjadi Kesalahan Saat Deskripsi Data</dt>';
                                    echo '  </div>';
                                    echo '</div>';
                                }else{
                                    echo '<ul>';
                                    $ListHistory=$JsonData['histori'];
                                    $no2=1;
                                    $JumlahListHistory=count($ListHistory);
                                    foreach($ListHistory as $ListDataShow){
                                        $diagnosa=$ListDataShow['diagnosa'];
                                        $jnsPelayanan=$ListDataShow['jnsPelayanan'];
                                        $kelasRawat=$ListDataShow['kelasRawat'];
                                        $namaPeserta=$ListDataShow['namaPeserta'];
                                        $noKartu=$ListDataShow['noKartu'];
                                        $noSep=$ListDataShow['noSep'];
                                        $noRujukan=$ListDataShow['noRujukan'];
                                        $poli=$ListDataShow['poli'];
                                        $ppkPelayanan=$ListDataShow['ppkPelayanan'];
                                        $tglPlgSep=$ListDataShow['tglPlgSep'];
                                        $tglSep=$ListDataShow['tglSep'];
                                        echo '<li class="mb-4">';
                                        echo '  <a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalDetailSep" data-id="'.$noSep.'">';
                                        echo '      <dt>'.$no2.'. SEP.'.$noSep.' <i class="ti ti-new-window"></i></dt>';
                                        echo '  </a>';
                                        echo '      <ol>';
                                        echo '          <li>Tanggal SEP : <code class="text-dark">'.$tglSep.'</code></li>';
                                        echo '          <li>Tanggal Pulang : <code class="text-dark">'.$tglPlgSep.'</code></li>';
                                        echo '          <li>Diagnosa : <code class="text-dark">'.$diagnosa.'</code></li>';
                                        echo '          <li>Jenis Pelayanan : <code class="text-dark">'.$jnsPelayanan.'</code></li>';
                                        echo '          <li>Kelas Rawat : <code class="text-dark">'.$kelasRawat.'</code></li>';
                                        echo '          <li>Poli : <code class="text-dark">'.$poli.'</code></li>';
                                        echo '          <li>Nama : <code class="text-dark">'.$namaPeserta.'</code></li>';
                                        echo '          <li>No.Rujukan : <code class="text-dark">'.$noRujukan.'</code></li>';
                                        echo '          <li>PPK Pelayanan : <code class="text-dark">'.$ppkPelayanan.'</code></li>';
                                        echo '      </ol>';
                                        echo '</li>';
                                        $no2++;
                                    }
                                    echo '</ul>';
                                }
                            }
                        }
                    }
                }
            }
        }
    }
?>