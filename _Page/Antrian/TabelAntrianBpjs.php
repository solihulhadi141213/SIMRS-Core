<div class="card-header">
    <h4><i class="ti ti-list"></i> Data Antrian BPJS</h4>
</div>
<?php
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingBridging.php";
    include "../../vendor/autoload.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['ModePencarianAntrian'])){
        $ValidasiKelengkapanData="Mode Pencarian Tidak Boleh Kosong!";
    }else{
        $ModePencarianAntrian=$_POST['ModePencarianAntrian'];
        if($ModePencarianAntrian=="Antrian Per Tanggal"){
            if(empty($_POST['TanggalAntrianPencarian'])){
                $ValidasiKelengkapanData="Tanggal Pencarian Tidak Boleh Kosong!";
            }else{
                $ValidasiKelengkapanData="Valid";
                $TanggalAntrianPencarian=$_POST['TanggalAntrianPencarian'];
            }
        }else{
            if($ModePencarianAntrian=="Antrian Per Kode Boking"){
                if(empty($_POST['PencarianKodeBooking'])){
                    $ValidasiKelengkapanData="Kode Booking Pencarian Tidak Boleh Kosong!";
                }else{
                    $ValidasiKelengkapanData="Valid";
                    $PencarianKodeBooking=$_POST['PencarianKodeBooking'];
                }
            }else{
                if($ModePencarianAntrian=="Antrian Belum Dilayani Per Poli"){
                    if(empty($_POST['KodePoli'])){
                        $ValidasiKelengkapanData="Kode Poli Pencarian Tidak Boleh Kosong!";
                    }else{
                        if(empty($_POST['KodeDokter'])){
                            $ValidasiKelengkapanData="Kode Dokter Pencarian Tidak Boleh Kosong!";
                        }else{
                            if(empty($_POST['KodeHari'])){
                                $ValidasiKelengkapanData="Hari Pencarian Tidak Boleh Kosong!";
                            }else{
                                if(empty($_POST['JamPraktek'])){
                                    $ValidasiKelengkapanData="Pencarian Jam Praktek Tidak Boleh Kosong!";
                                }else{
                                    $ValidasiKelengkapanData="Valid";
                                    $PencarianKodePoli=$_POST['KodePoli'];
                                    $PencarianKodeDokter=$_POST['KodeDokter'];
                                    $PencarianHari=$_POST['KodeHari'];
                                    $PencarianJamPraktek=$_POST['JamPraktek'];
                                }
                            }
                        }
                    }
                }else{
                    $ValidasiKelengkapanData="Valid";
                }
            }
        }
        if($ValidasiKelengkapanData!=="Valid"){
            echo '<div class="card-body">';
            echo '  <div class="row">';
            echo '      <div class="col-md-12 text-danger text-center">';
            echo '          '.$ValidasiKelengkapanData.'';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
            //Membuat Parameter Response
            if($ModePencarianAntrian=="Antrian Per Tanggal"){
                $response=AntrianByTanggal($url_antrol,$consid,$secret_key,$user_key,$TanggalAntrianPencarian);
            }else{
                if($ModePencarianAntrian=="Antrian Per Kode Boking"){
                    $response=AntrianByKodeBooking($url_antrol,$consid,$secret_key,$user_key,$PencarianKodeBooking);
                }else{
                    if($ModePencarianAntrian=="Antrian Belum Dilayani Per Poli"){
                        $response=AntrianByPoli($url_antrol,$consid,$secret_key,$user_key,$PencarianKodePoli,$PencarianKodeDokter,$PencarianHari,$PencarianJamPraktek);
                    }else{
                        $response=AntrianBelumDilayani($url_antrol,$consid,$secret_key,$user_key);
                    }
                }
            }
            if(empty($response)){
                echo '<div class="card-body">';
                echo '  <div class="row">';
                echo '      <div class="col-md-12 text-danger text-center">';
                echo '          Tidak Ada Response Dari Service Bridging BPJS!';
                echo '      </div>';
                echo '  </div>';
                echo '</div>';
            }else{
                $ambil_json =json_decode($response, true);
                if(empty($ambil_json["metadata"])){
                    echo '<div class="card-body">';
                    echo '  <div class="row">';
                    echo '      <div class="col-md-12 text-danger text-center">';
                    echo '          Kesalahan Tidak Diketahui!';
                    echo '      </div>';
                    echo '  </div>';
                    echo '  <div class="row">';
                    echo '      <div class="col-md-12 text-danger text-center">';
                    echo '          '.$response.'';
                    echo '      </div>';
                    echo '  </div>';
                    echo '</div>';
                }else{
                    if(empty($ambil_json["metadata"]["code"])){
                        echo '<div class="card-body">';
                        echo '  <div class="row">';
                        echo '      <div class="col-md-12 text-danger text-center">';
                        echo '          Kesalahan Tidak Diketahui!';
                        echo '      </div>';
                        echo '  </div>';
                        echo '  <div class="row">';
                        echo '      <div class="col-md-12 text-danger text-center">';
                        echo '          '.$response.'';
                        echo '      </div>';
                        echo '  </div>';
                        echo '</div>';
                    }else{
                        if($ambil_json["metadata"]["code"]!==200){
                            if(empty($ambil_json["metadata"]["message"])){
                                echo '<div class="card-body">';
                                echo '  <div class="row">';
                                echo '      <div class="col-md-12 text-danger text-center">';
                                echo '          '.$response.'';
                                echo '      </div>';
                                echo '  </div>';
                                echo '</div>';
                            }else{
                                $PesanService=$ambil_json["metadata"]["message"];
                                $code=$ambil_json["metadata"]["code"];
                                echo '<div class="row">';
                                echo '<div class="col-md-12 text-center"><span class="text-danger">'.$code.'-'.$PesanService.'</span></div>';
                                echo '</div>';
                            }
                        }else{
                            if(empty($ambil_json["response"])){
                                echo '<div class="card-body">';
                                echo '  <div class="row">';
                                echo '      <div class="col-md-12 text-danger text-center">';
                                echo '          Response Kosong! Atau Data Tidak Ditemukan Sama Sekali!';
                                echo '      </div>';
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
                                    echo '<div class="card-body">';
                                    echo '  <div class="row">';
                                    echo '      <div class="col-md-12 text-danger text-center">';
                                    echo '          Data Tidak Ditemukan';
                                    echo '      </div>';
                                    echo '  </div>';
                                    echo '</div>';
                                }else{
                                    $Jumlah=count($JsonData);
                                    if(empty($JsonData)){
                                        echo '<div class="card-body">';
                                        echo '  <div class="row">';
                                        echo '      <div class="col-md-12 text-danger text-center">';
                                        echo '          Data Tidak Ditemukan';
                                        echo '      </div>';
                                        echo '  </div>';
                                        echo '</div>';
                                    }else{
                                        echo '<div class="card-body">';
                                        echo '  <div class="row">';
                                        echo '      <div class="col-md-12 table table-responsive">';
                                        echo '          <table class="table table-hover table-bordered">';
                                        echo '              <thead>';
                                        echo '                  <tr>';
                                        echo '                      <th class="text-center" align="center"><dt>No</dt></th>';
                                        echo '                      <th class="text-center" align="center"><dt>Kode Booking</dt></th>';
                                        echo '                      <th class="text-center" align="center"><dt>Nama Pasien</dt></th>';
                                        echo '                      <th class="text-center" align="center"><dt>Kunjungan</dt></th>';
                                        echo '                      <th class="text-center" align="center"><dt>Poliklinik</dt></th>';
                                        echo '                  </tr>';
                                        echo '              </thead>';
                                        echo '              <tbody>';
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
                                            echo '<tr data-toggle="modal" data-target="#ModalDetailKodeBooking" data-id="'.$kodebooking.'">';
                                            echo '  <td class="text-center">'.$no.'</td>';
                                            echo '  <td class="text-left">';
                                            echo '      <dt><span class="text-primary" title="Kode Booking"><i class="ti-info-alt"></i> '.$kodebooking.'</span></dt>';
                                            echo '      <small title="Nomor Antrian"><i class="ti-ticket"></i> '.$noantrean.'</small><br>';
                                            echo '      <small title="Tanggal Kunjungan"><i class="ti-calendar"></i> '.$FormatTanggal.'</small><br>';
                                            echo '      <small title="Tanggal Daftar"><i class="icofont-ui-calendar"></i> '.$FormatCreatTime.'</small>';
                                            echo '  </td>';
                                            echo '  <td class="text-left">';
                                            echo '      <dt title="Nama Pasien"><i class="ti ti-user"></i> '.$LabelNama.'</dt>';
                                            echo '      <small title="Nomor RM"><i class="icofont-id-card"></i> '.$norekammedis.'</small><br>';
                                            echo '      <small title="Nomor NIK"><i class="icofont-ui-v-card"></i> '.$nik.'</small><br>';
                                            echo '      <small title="Nomor Kartu BPJS"><i class="icofont-card"></i> '.$LabelNoKartu.'</small>';
                                            echo '  </td>';
                                            echo '  <td class="text-left">';
                                            echo '      <dt title="Jenis Kunjungan"><i class="icofont-ambulance-cross"></i> '.$LabelJenisKunjungan.'</dt>';
                                            echo '      <small title="Nomor Referensi"><i class="icofont-prescription"></i> '.$LabelNomorReferensi.'</small><br>';
                                            echo '      <small title="Jenis Peserta"><i class="icofont-medical-sign"></i> '.$LabelPeserta.'</small><br>';
                                            echo '      <small title="Sumber Data"><i class="icofont-table"></i> '.$sumberdata.'</small>';
                                            echo '  </td>';
                                            echo '  <td class="text-left">';
                                            echo '      <dt title="Poliklinik"><i class="icofont-hospital"></i> '.$kodepoli.'-'.$LabelPoli.'</dt>';
                                            echo '      <small title="Nama Dokter"><i class="icofont-doctor"></i> '.$kodedokter.'-'.$NamaDokter.'</small><br>';
                                            echo '      <small title="Jam Praktek"><i class="icofont-clock-time"></i> '.$jampraktek.'</small><br>';
                                            echo '      <small title="Estimasi Dilayani"><i class="icofont-wall-clock"></i> '.$FormatEstimasiDilayani.' ('.$status.')</small>';
                                            echo '  </td>';
                                            echo '</tr>';
                                            $no++;
                                        }
                                        echo '              </tbody>';
                                        echo '          </table>';
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
    }
?>