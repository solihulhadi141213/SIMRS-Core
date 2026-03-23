<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingBridging.php";
    include "../../vendor/autoload.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap KodeBooking
    if(empty($_POST['KodeBooking'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 mb-3 text-center text-danger">';
        echo '      Kode Booking Tidak Boleh Kosong!!.';
        echo '  </div>';
        echo '</div>';
    }else{
        $KodeBooking=$_POST['KodeBooking'];
        $response=AntrianByKodeBooking($url_antrol,$consid,$secret_key,$user_key,$KodeBooking);
        if(empty($response)){
            echo '<div class="row">';
            echo '  <div class="col-md-12 text-danger text-center">';
            echo '      Tidak Ada Response Dari Service Bridging BPJS!';
            echo '  </div>';
            echo '</div>';
        }else{
            $ambil_json =json_decode($response, true);
            if(empty($ambil_json["metadata"])){
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
                if(empty($ambil_json["metadata"]["code"])){
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
                    if($ambil_json["metadata"]["code"]!==200){
                        if(empty($ambil_json["metadata"]["message"])){
                            echo '<div class="row mb-3">';
                            echo '  <div class="col-md-12 text-center text-danger">';
                            echo '      '.$response.'';
                            echo '  </div>';
                            echo '</div>';
                        }else{
                            $PesanService=$ambil_json["metadata"]["message"];
                            $code=$ambil_json["metadata"]["code"];
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
                                $Jumlah=count($JsonData);
                                if(empty($JsonData)){
                                    echo '<div class="row mb-3">';
                                    echo '  <div class="col-md-12 text-center text-danger">';
                                    echo '      Data Tidak Ditemukan!';
                                    echo '  </div>';
                                    echo '</div>';
                                }else{
                                    $no=1;
                                    for($a=0; $a<$Jumlah; $a++){
                                        $kodebooking=$JsonData[$a]['kodebooking'];
                                        $tanggal=$JsonData[$a]['tanggal'];
                                        $kodepoli=$JsonData[$a]['kodepoli'];
                                        $kodedokter=$JsonData[$a]['kodedokter'];
                                        $jampraktek=$JsonData[$a]['jampraktek'];
                                        $nik=$JsonData[$a]['nik'];
                                        $nokapst=$JsonData[$a]['nokapst'];
                                        $nohp=$JsonData[$a]['nohp'];
                                        $norekammedis=$JsonData[$a]['norekammedis'];
                                        $jeniskunjungan=$JsonData[$a]['jeniskunjungan'];
                                        $nomorreferensi=$JsonData[$a]['nomorreferensi'];
                                        $sumberdata=$JsonData[$a]['sumberdata'];
                                        $ispeserta=$JsonData[$a]['ispeserta'];
                                        $noantrean=$JsonData[$a]['noantrean'];
                                        $estimasidilayani=$JsonData[$a]['estimasidilayani'];
                                        $createdtime=$JsonData[$a]['createdtime'];
                                        $status=$JsonData[$a]['status'];
                                        if($jeniskunjungan=="1"){
                                            $LabelJenisKunjungan="Rujukan FKTP";
                                        }else{
                                            if($jeniskunjungan=="2"){
                                                $LabelJenisKunjungan="Rujukan Internal";
                                            }else{
                                                if($jeniskunjungan=="3"){
                                                    $LabelJenisKunjungan="Kontrol";
                                                }else{
                                                    if($jeniskunjungan=="4"){
                                                        $LabelJenisKunjungan="Rujukan Antar RS";
                                                    }else{
                                                        $LabelJenisKunjungan='<span class="text-danger">Tidak Diketahui</span>';
                                                    }
                                                }
                                            }
                                        }
                                        //Nama Pasien
                                        $nama =getDataDetail($Conn,"pasien",'id_pasien',$norekammedis,'nama');
                                        $NamaPoli =getDataDetail($Conn,"poliklinik",'kode',$kodepoli,'nama');
                                        $NamaDokter =getDataDetail($Conn,"dokter",'kode',$kodedokter,'nama');
                                        if(empty($NamaPoli)){
                                            $LabelPoli='<span class="text-danger">Tidak Diketahui</span>';
                                        }else{
                                            $LabelPoli='<span class="text-dark">'.$NamaPoli.'</span>';
                                        }
                                        if(empty($NamaDokter)){
                                            $LabelDokter='<span class="text-danger">Tidak Diketahui</span>';
                                        }else{
                                            $LabelDokter='<span class="text-dark">'.$NamaDokter.'</span>';
                                        }
                                        if(empty($nama)){
                                            $LabelNama='<span class="text-danger">Tidak Diketahui</span>';
                                        }else{
                                            $LabelNama='<span class="text-dark">'.$nama.'</span>';
                                        }
                                        if(empty($nokapst)){
                                            $LabelNoKartu='<span class="text-danger">Tidak Diketahui</span>';
                                        }else{
                                            $LabelNoKartu='<span class="text-dark">'.$nokapst.'</span>';
                                        }
                                        if(empty($nomorreferensi)){
                                            $LabelNomorReferensi='<span class="text-danger">Tidak Diketahui</span>';
                                        }else{
                                            $LabelNomorReferensi='<span class="text-dark">'.$nomorreferensi.'</span>';
                                        }
                                        if($ispeserta=="1"){
                                            $LabelPeserta='<span class="text-info">BPJS</span>';
                                        }else{
                                            $LabelPeserta='<span class="text-danger">UMUM</span>';
                                        }
                                        //Creat Time
                                        $createdtime=$createdtime/1000;
                                        $FormatCreatTime=date('d/m/Y',$createdtime);
                                        $strtotime2=strtotime($tanggal);
                                        $FormatTanggal=date('d/m/Y',$strtotime2);
                                        $FormatEstimasiDilayani=date('H:i',$estimasidilayani);
                                        echo '<div class="row mb-3">';
                                        echo '  <div class="col-md-4"><dt>Kode Booking</dt></div>';
                                        echo '  <div class="col-md-8"><small>'.$kodebooking.'</small></div>';
                                        echo '</div>';
                                        echo '<div class="row mb-3">';
                                        echo '  <div class="col-md-4"><dt>No.Antrian</dt></div>';
                                        echo '  <div class="col-md-8"><small>'.$noantrean.'</small></div>';
                                        echo '</div>';
                                        echo '<div class="row mb-3">';
                                        echo '  <div class="col-md-4"><dt>Tanggal Kunjungan</dt></div>';
                                        echo '  <div class="col-md-8"><small>'.$tanggal.'</small></div>';
                                        echo '</div>';
                                        echo '<div class="row mb-3">';
                                        echo '  <div class="col-md-4"><dt>Nama Pasien</dt></div>';
                                        echo '  <div class="col-md-8"><small>'.$LabelNama.'</small></div>';
                                        echo '</div>';
                                        echo '<div class="row mb-3">';
                                        echo '  <div class="col-md-4"><dt>No.RM</dt></div>';
                                        echo '  <div class="col-md-8"><small>'.$norekammedis.'</small></div>';
                                        echo '</div>';
                                        echo '<div class="row mb-3">';
                                        echo '  <div class="col-md-4"><dt>NIK</dt></div>';
                                        echo '  <div class="col-md-8"><small>'.$nik.'</small></div>';
                                        echo '</div>';
                                        echo '<div class="row mb-3">';
                                        echo '  <div class="col-md-4"><dt>No.Kartu BPJS</dt></div>';
                                        echo '  <div class="col-md-8"><small>'.$LabelNoKartu.'</small></div>';
                                        echo '</div>';
                                        echo '<div class="row mb-3">';
                                        echo '  <div class="col-md-4"><dt>No.HP</dt></div>';
                                        echo '  <div class="col-md-8"><small>'.$nohp.'</small></div>';
                                        echo '</div>';
                                        echo '<div class="row mb-3">';
                                        echo '  <div class="col-md-4"><dt>Peserta</dt></div>';
                                        echo '  <div class="col-md-8"><small>'.$LabelPeserta.'</small></div>';
                                        echo '</div>';
                                        echo '<div class="row mb-3">';
                                        echo '  <div class="col-md-4"><dt>Poliklinik</dt></div>';
                                        echo '  <div class="col-md-8"><small>'.$kodepoli.'-'.$LabelPoli.'</small></div>';
                                        echo '</div>';
                                        echo '<div class="row mb-3">';
                                        echo '  <div class="col-md-4"><dt>Dokter</dt></div>';
                                        echo '  <div class="col-md-8"><small>'.$kodedokter.'-'.$LabelDokter.'</small></div>';
                                        echo '</div>';
                                        echo '<div class="row mb-3">';
                                        echo '  <div class="col-md-4"><dt>Jam Praktek</dt></div>';
                                        echo '  <div class="col-md-8"><small>'.$jampraktek.'</small></div>';
                                        echo '</div>';
                                        echo '<div class="row mb-3">';
                                        echo '  <div class="col-md-4"><dt>Estimasi Dilayani</dt></div>';
                                        echo '  <div class="col-md-8"><small>'.$FormatEstimasiDilayani.'</small></div>';
                                        echo '</div>';
                                        echo '<div class="row mb-3">';
                                        echo '  <div class="col-md-4"><dt>Jenis Kunjungan</dt></div>';
                                        echo '  <div class="col-md-8"><small>'.$LabelJenisKunjungan.'</small></div>';
                                        echo '</div>';
                                        echo '<div class="row mb-3">';
                                        echo '  <div class="col-md-4"><dt>No.Referensi</dt></div>';
                                        echo '  <div class="col-md-8"><small>'.$LabelNomorReferensi.'</small></div>';
                                        echo '</div>';
                                        echo '<div class="row mb-3">';
                                        echo '  <div class="col-md-4"><dt>Sumber Data</dt></div>';
                                        echo '  <div class="col-md-8"><small>'.$sumberdata.'</small></div>';
                                        echo '</div>';
                                        echo '<div class="row mb-3">';
                                        echo '  <div class="col-md-4"><dt>Status</dt></div>';
                                        echo '  <div class="col-md-8"><small>'.$status.'</small></div>';
                                        echo '</div>';
                                        echo '<div class="row mb-3">';
                                        echo '  <div class="col-md-12 text-center">';
                                        echo '      <a href="index.php?Page=Antrian&Sub=DetailAntrian&KodeBooking='.$KodeBooking.'&tanggal='.$tanggal.'" class="btn btn-sm btn-block btn-outline-dark">';
                                        echo '          Selengkapnya <i class="ti ti-more-alt"></i>';
                                        echo '      </a>';
                                        echo '  </div>';
                                        echo '</div>';
                                        $no++;
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