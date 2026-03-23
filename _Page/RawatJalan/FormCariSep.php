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
        if(empty($_POST['TanggalAwalPencarianSep'])){
            echo '  <di class="row">';
            echo '      <di class="col-md-12 text-center text-danger">';
            echo '          Isi Terlebih Dulu Tanggal Awal Pencarian';
            echo '      </di>';
            echo '  </di>';
        }else{
            if(empty($_POST['TanggalAkhirPencarianSep'])){
                echo '  <di class="row">';
                echo '      <di class="col-md-12 text-center text-danger">';
                echo '          Isi Terlebih Dulu Tanggal Akhir Pencarian';
                echo '      </di>';
                echo '  </di>';
            }else{
                $KeywordNomorKartu=$_POST['KeywordNomorKartu'];
                $TanggalAwalPencarianSep=$_POST['TanggalAwalPencarianSep'];
                $TanggalAkhirPencarianSep=$_POST['TanggalAkhirPencarianSep'];
                $url="$url_vclaim/monitoring/HistoriPelayanan/NoKartu/$KeywordNomorKartu/tglMulai/$TanggalAwalPencarianSep/tglAkhir/$TanggalAkhirPencarianSep";
                $Response=PencarianSep($url_vclaim,$consid,$secret_key,$user_key,$url);
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
                                    if(empty($FileDekompresiJson['histori'])){
                                        echo '<div class="row">';
                                        echo '  <div class="col-md-12 text-center text-danger"><dt>Tidak ada histori yang ditemukan!</dt> '.$PesanKesalahan.'</div>';
                                        echo '</div>';
                                    }else{
                                        $JsonData =json_decode($FileDekompresi, true);
                                        $list=$JsonData['histori'];
                                        $Jumlah=count($list);
                                        echo '<div class="row mb-4">';
                                        echo '  <div class="col col-md-12 pre-scrollable">';
                                        echo '      <ul  class="list-group">';
                                        $no=1;
                                        for($a=0; $a<$Jumlah; $a++){
                                            $diagnosa=$list[$a]['diagnosa'];
                                            $jnsPelayanan=$list[$a]['jnsPelayanan'];
                                            $namaPeserta=$list[$a]['namaPeserta'];
                                            $noSep=$list[$a]['noSep'];
                                            $noRujukan=$list[$a]['noRujukan'];
                                            $poli=$list[$a]['poli'];
                                            $ppkPelayanan=$list[$a]['ppkPelayanan'];
                                            $tglPlgSep=$list[$a]['tglPlgSep'];
                                            $tglSep=$list[$a]['tglSep'];
                                            $noKartu=$list[$a]['noKartu'];
                                            $kelasRawat=$list[$a]['kelasRawat'];
                                            if($jnsPelayanan==1){
                                                $LabelPelayanan="Rawat Inap ($kelasRawat)";
                                            }else{
                                                $LabelPelayanan="Rawat Jalan ($poli)";
                                            }
                                            echo '  <li class="list-group-item">';
                                            echo '      <dt><input type="radio" id="ItemPilihSep'.$no.'" name="ItemPilihSep" value="'.$noSep.'-'.$noRujukan.'"><label for="ItemPilihSep'.$no.'">SEP '.$noSep.'</label></dt>';
                                            echo '      <small class="text-mutted">No.Rujukan : '.$noRujukan.'</small><br>';
                                            echo '      <small class="text-mutted">Pelayanan : '.$jnsPelayanan.'. '.$LabelPelayanan.'</small><br>';
                                            echo '      <small>Tanggal SEP : '.$tglSep.'</small>';
                                            echo '  </li>';
                                            $no++;
                                        }
                                        echo '      </ul>';
                                        echo '  </div>';
                                        echo '</div>';
                                        echo '<div class="row mb-3">';
                                        echo '  <div class="col col-md-12">';
                                        echo '      <span class="text-primary" id="NotifikasiTambahkanSepKeForm">';
                                        echo '          Silahkan pilih salah satu data SEP di atas kemudian tambahkan pada form.';
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
    }
?>