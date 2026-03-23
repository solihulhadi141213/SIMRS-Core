<?php
    date_default_timezone_set('UTC');
    include "../../_Config/Connection.php";
    include "../../_Config/SettingBridging.php";
    include "../../_Config/SimrsFunction.php";
    include "../../vendor/autoload.php";
    if(empty($_POST['PeriodeAwal'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center text-danger">Periode Awal Pencarian Belum Diisi!</div>';
        echo '</div>';
    }else{
        if(empty($_POST['PeriodeAkhir'])){
            echo '<div class="row">';
            echo '  <div class="col-md-12 text-center text-danger">Periode Akhir Pencarian Belum Diisi!</div>';
            echo '</div>';
        }else{
            $PeriodeAwal=$_POST['PeriodeAwal'];
            $PeriodeAkhir=$_POST['PeriodeAkhir'];
            $timestamp_awal = strtotime($PeriodeAwal);
            $timestamp_akhir = strtotime($PeriodeAkhir);
            if($timestamp_akhir<=$timestamp_awal){
                echo '<div class="row">';
                echo '  <div class="col-md-12 text-center text-danger">Periode Data Pencarian Tidak Valid!</div>';
                echo '</div>';
            }else{
                $no=1;
                $url="$url_vclaim//Rujukan/Keluar/List/tglMulai/$PeriodeAwal/tglAkhir/$PeriodeAkhir";
                $ResponseKunjunganRanap=BridgingServiceGet($consid,$secret_key,$user_key,$url);
                $ResponseKunjunganRanapJson =json_decode($ResponseKunjunganRanap, true);
                if(empty($ResponseKunjunganRanapJson['metaData']['code'])){
                    echo '<div class="row">';
                    echo '  <div class="col-md-12 text-center">';
                    echo '      <span class="text-danger">Tidak Ada Response Dari Service BPJS!</span>';
                    echo '  </div>';
                    echo '</div>';
                }else{
                    $ResponseCode=$ResponseKunjunganRanapJson['metaData']['code'];
                    if($ResponseCode!=="200"){
                        echo '<div class="row">';
                        echo '  <div class="col-md-12 text-center">';
                        echo '      <span class="text-danger">Pesan: '.$ResponseKunjunganRanapJson['metaData']['message'].'</span>';
                        echo '  </div>';
                        echo '</div>';
                    }else{
                        if(empty($ResponseKunjunganRanapJson['response'])){
                            echo '<div class="row">';
                            echo '  <div class="col-md-12 text-center">';
                            echo '      <dt class="text-danger">Terjadi Kesalahan Pada Response</dt>';
                            echo '      <span class="text-danger">Pesan: '.$ResponseKunjunganRanapJson['metaData']['message'].'</span>';
                            echo '  </div>';
                            echo '</div>';
                        }else{
                            $string=$ResponseKunjunganRanapJson['response'];
                            $stringData =json_decode($string, true);
                            $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
                            $key="$consid$secret_key$timestamp";
                            //--masukan ke fungsi
                            $FileDeskripsi=stringDecrypt("$key", "$string");
                            $FileDekompresi=decompress("$FileDeskripsi");
                            //--konveris json to raw
                            $JsonData =json_decode($FileDekompresi, true);
                            if(empty($JsonData['list'])){
                                echo '<div class="row">';
                                echo '  <div class="col-md-12 text-center">';
                                echo '      <dt class="text-danger">Terjadi Kesalahan Saat Deskripsi Data</dt>';
                                echo '  </div>';
                                echo '</div>';
                            }else{
                                $ListRujukan=$JsonData['list'];
                                echo '<div class="row">';
                                echo '  <div class="col-md-12 table table-responsive">';
                                echo '      <table class="table table-bordered table-hover">';
                                echo '          <thead>';
                                echo '              <tr>';
                                echo '                  <th class="text-center"><dt>No</dt></th>';
                                echo '                  <th class="text-center"><dt>Rujukan</dt></th>';
                                echo '                  <th class="text-center"><dt>Pasien</dt></th>';
                                echo '                  <th class="text-center"><dt>Keterangan</dt></th>';
                                echo '              </tr>';
                                echo '          </thead>';
                                echo '          <tbody>';
                                $no2=1;
                                $JumlahRujukan=count($ListRujukan);
                                foreach($ListRujukan as $ListDataShow){
                                    $noSep=$ListDataShow['noSep'];
                                    $noRujukan=$ListDataShow['noRujukan'];
                                    $tglRujukan=$ListDataShow['tglRujukan'];
                                    $jnsPelayanan=$ListDataShow['jnsPelayanan'];
                                    $noKartu=$ListDataShow['noKartu'];
                                    $nama=$ListDataShow['nama'];
                                    $ppkDirujuk=$ListDataShow['ppkDirujuk'];
                                    $namaPpkDirujuk=$ListDataShow['namaPpkDirujuk'];
                                    //Format Tanggal
                                    $strtotime1=strtotime($tglRujukan);
                                    $tglRujukan=date('d/m/Y',$strtotime1);
                                    //Cek Data Kunjungan Pasien
                                    $id_kunjungan=getDataDetail($Conn,"kunjungan_utama",'sep',$noSep,'id_kunjungan');
                                    if(empty($id_kunjungan)){
                                        $LabelIdKunjungan='<span class="text-danger">Belum Terdaftar</span>';
                                        $LabelIdPasien='<span class="text-danger">None</span>';
                                    }else{
                                        $id_pasien=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'id_pasien');
                                        $LabelIdKunjungan='<span class="text-muted">ID.REG.'.$id_kunjungan.'</span>';
                                        $LabelIdPasien='<span class="text-muted">No.RM.'.$id_pasien.'</span>';
                                    }
                                    //Routing Jenis Layanan
                                    if($jnsPelayanan=="1"){
                                        $JenisLayanan="Rawat Inap";
                                    }else{
                                        $JenisLayanan="Rawat Jalan";
                                    }
                                    echo '<tr>';
                                    echo '  <td class="text-center">'.$no2.'</td>';
                                    echo '  <td class="text-left">';
                                    echo '      <a href="javascript:void(0);" data-toggle="modal" data-target="#ModalDetailSep" data-id="'.$noSep.'" class="text-primary">'.$noRujukan.'</a><br>';
                                    echo '      <small class="text-muted m-b-0" title="Nomor Rujukan">Rujukan.'.$noRujukan.'</small><br>';
                                    echo '      <small class="text-muted m-b-0" title="Tanggal Rujukan">Tgl.'.$tglRujukan.'</small>';
                                    echo '  </td>';
                                    echo '  <td class="text-left">';
                                    echo '      <small class="text-muted m-b-0" title="Nama Pasien">'.$nama.'</small><br>';
                                    echo '      <small class="text-muted m-b-0" title="Nomor Kartu">No.Kartu : '.$noKartu.'</small><br>';
                                    echo '      <small class="text-muted m-b-0" title="Nomor SEP">SEP.'.$noSep.'</small><br>';
                                    echo '  </td>';
                                    echo '  <td class="text-left">';
                                    echo '      <small class="text-muted m-b-0" title="Kode PPK Tujuan Rujukan">Kode PPK : '.$ppkDirujuk.'</small><br>';
                                    echo '      <small class="text-muted m-b-0" title="Nama PPK Tujuan Rujukan">Nama PPK : '.$namaPpkDirujuk.'</small><br>';
                                    echo '      <small class="text-muted m-b-0" title="Jenis Layanan">'.$JenisLayanan.'</small><br>';
                                    echo '  </td>';
                                    echo '</tr>';
                                    $no2++;
                                }
                                echo '          </tbody>';
                                echo '      </table>';
                                echo '  </div>';
                                echo '</div>';
                            }
                        } 
                        $no++;
                    }
                }
            }
        }
    }
?>
