<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "_Config/SettingBridging.php";
    include "vendor/autoload.php";
    include "_Config/SimrsFunction.php";
    //Tangkap
    if(!empty($_GET['KodeBooking'])){
        $KategoriDetail="BPJS";
        if(!empty($_GET['tanggal'])){
            $KodeBooking=$_GET['KodeBooking'];
            $tanggal=$_GET['tanggal'];
            $response=AntrianByKodeBooking($url_antrol,$consid,$secret_key,$user_key,$KodeBooking);
            if(empty($response)){
                $kodebooking="";
                $ValidasiKelengkapanData="Tidak Ada Response Dari Service Bridging BPJS!";
            }else{
                $ambil_json =json_decode($response, true);
                if(empty($ambil_json["metadata"])){
                    $kodebooking="";
                    $ValidasiKelengkapanData="Kesalahan Tidak Diketahui! <br>'.$response.'";
                }else{
                    if(empty($ambil_json["metadata"]["code"])){
                        $kodebooking="";
                        $ValidasiKelengkapanData="Kesalahan Tidak Diketahui! <br>'.$response.'";
                    }else{
                        if($ambil_json["metadata"]["code"]!==200){
                            $kodebooking="";
                            if(empty($ambil_json["metadata"]["message"])){
                                $ValidasiKelengkapanData="'.$response.'";
                            }else{
                                $PesanService=$ambil_json["metadata"]["message"];
                                $code=$ambil_json["metadata"]["code"];
                                $ValidasiKelengkapanData="'.$code.'-'.$PesanService.'";
                            }
                        }else{
                            if(empty($ambil_json["response"])){
                                $kodebooking="";
                                $ValidasiKelengkapanData="Response Kosong! Atau Data Tidak Ditemukan Sama Sekali!";
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
                                    $kodebooking="";
                                    $ValidasiKelengkapanData="Response Kosong! Atau Data Tidak Ditemukan Sama Sekali!";
                                }else{
                                    $Jumlah=count($JsonData);
                                    if(empty($JsonData)){
                                        $kodebooking="";
                                        $ValidasiKelengkapanData="Response Kosong! Atau Data Tidak Ditemukan Sama Sekali!";
                                    }else{
                                        for($a=0; $a<$Jumlah; $a++){
                                            if($tanggal==$JsonData[$a]['tanggal']){
                                                $ValidasiKelengkapanData="Valid";
                                                $kodebooking=$JsonData[$a]['kodebooking'];
                                                $tanggal_antrian=$JsonData[$a]['tanggal'];
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
                                                    $LabelNomorReferensi='<a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalDetailReferensi" data-id="'.$jeniskunjungan.','.$nomorreferensi.'">'.$nomorreferensi.' <i class="ti ti-layers"></i></a>';
                                                }
                                                if($ispeserta=="1"){
                                                    $LabelPeserta='<span class="text-dark">BPJS</span>';
                                                }else{
                                                    $LabelPeserta='<span class="text-dark">UMUM</span>';
                                                }
                                                //Creat Time
                                                $createdtime=$createdtime/1000;
                                                $FormatCreatTime=date('d/m/Y',$createdtime);
                                                $strtotime2=strtotime($tanggal);
                                                $FormatTanggal=date('d/m/Y',$strtotime2);
                                                // $estimasidilayani=$estimasidilayani/1000;
                                                $FormatEstimasiDilayani=date('H:i',$estimasidilayani);
                                            }else{
                                                $kodebooking="";
                                                $ValidasiKelengkapanData="Data Tidak Ditemukan";
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }else{
            $kodebooking="";
            $ValidasiKelengkapanData="Tanggal Tidak Boleh Kosong!";
        }
    }else{
        $KategoriDetail="SIMRS";
        if(!empty($_GET['id'])){
            $GetIdAntrian=$_GET['id'];
            //Buka Data Antrian Berdasarkan Id Antrian
            $id_antrian=getDataDetail($Conn,'antrian','id_antrian',$GetIdAntrian,'id_antrian');
            if(empty($id_antrian)){
                $ValidasiKelengkapanData="ID Antrian Tidak Valid/Tidak Ditemukan Pada Database!";
            }else{
                $id_kunjungan=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'id_kunjungan');
                $no_antrian=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'no_antrian');
                $kodebooking=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'kodebooking');
                $id_pasien=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'id_pasien');
                $nama_pasien=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'nama_pasien');
                $nomorkartu=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'nomorkartu');
                $nik=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'nik');
                $notelp=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'notelp');
                $nomorreferensi=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'nomorreferensi');
                $jenisreferensi=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'jenisreferensi');
                $jenisrequest=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'jenisrequest');
                $polieksekutif=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'polieksekutif');
                $tanggal_daftar=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'tanggal_daftar');
                $tanggal_kunjungan=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'tanggal_kunjungan');
                $jam_kunjungan=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'jam_kunjungan');
                $jam_checkin=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'jam_checkin');
                $kode_dokter=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'kode_dokter');
                $nama_dokter=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'nama_dokter');
                $kodepoli=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'kodepoli');
                $namapoli=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'namapoli');
                $kelas=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'kelas');
                $keluhan=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'keluhan');
                $pembayaran=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'pembayaran');
                $no_rujukan=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'no_rujukan');
                $status=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'status');
                $sumber_antrian=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'sumber_antrian');
                $ws_bpjs=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'ws_bpjs');
                $ValidasiKelengkapanData="Valid";
            }
        }else{
            $ValidasiKelengkapanData="ID Antrian Tidak Boleh Kosong!";
        }
    }
?>
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-8">
                        <h4 class="card-title"><i class="ti ti-info-alt"></i> Detail Antrian (<?php echo "$KategoriDetail"; ?>)</h4>
                    </div>
                    <div class="col-md-2">
                        <a href="index.php?Page=Antrian" class="btn btn-sm btn-block btn-secondary">
                            <i class="ti ti-angle-left"></i> Kembali
                        </a>
                    </div>
                    <div class="col-md-2">
                        <?php
                            if($KategoriDetail=="BPJS"){
                                echo '<div class="btn-group dropdown-split-inverse btn-block">';
                                echo '  <button type="button" class="btn btn-sm btn-block btn-info dropdown-toggle dropdown-toggle-split waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="OptionButton">';
                                echo '      Option';
                                echo '  </button>';
                                echo '  <div class="dropdown-menu" x-placement="top-start" style="position: absolute; transform: translate3d(107px, -2px, 0px); top: 0px; left: 0px; will-change: transform;">';
                                echo '      <a class="dropdown-item waves-effect waves-light" href="">';
                                echo '          <i class="ti ti-reload"></i> Reload';
                                echo '      </a>';
                                echo '      <a class="dropdown-item waves-effect waves-light" href="javascript:void(0);" data-toggle="modal" data-target="#ModalBatalAntrian" data-id="'.$kodebooking.'">';
                                echo '          <i class="ti ti-close"></i> Batal Paksa';
                                echo '      </a>';
                                echo '  </div>';
                                echo '</div>';
                            }else{
                                echo '<div class="btn-group dropdown-split-inverse btn-block">';
                                echo '  <button type="button" class="btn btn-sm btn-block btn-info dropdown-toggle dropdown-toggle-split waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="OptionButton">';
                                echo '      Option';
                                echo '  </button>';
                                echo '  <div class="dropdown-menu" x-placement="top-start" style="position: absolute; transform: translate3d(107px, -2px, 0px); top: 0px; left: 0px; will-change: transform;">';
                                echo '      <a class="dropdown-item waves-effect waves-light" href="">';
                                echo '          <i class="ti ti-reload"></i> Reload';
                                echo '      </a>';
                                echo '      <a class="dropdown-item waves-effect waves-light" href="javascript:void(0);" data-toggle="modal" data-target="#ModalBatalAntrian" data-id="'.$kodebooking.'">';
                                echo '          <i class="ti ti-close"></i> Batal Paksa';
                                echo '      </a>';
                                echo '      <a href="_Page/Pendaftaran/CetakTiketAntrian.php?id_antrian='.$id_antrian.'" class="dropdown-item waves-effect waves-light" target="_blank">';
                                echo '          <i class="ti ti-printer"></i> Cetak Antrian';
                                echo '      </a>';
                                echo '  </div>';
                                echo '</div>';
                            }
                        ?>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <?php
                    if($ValidasiKelengkapanData!=="Valid"){
                        echo '<div class="row mb-3">';
                        echo '  <div class="col-md-12 text-center">'.$ValidasiKelengkapanData.'</div>';
                        echo '</div>';
                    }else{
                        if($KategoriDetail=="BPJS"){
                            include "_Page/Antrian/DetailAntrianBpjs.php";
                        }else{
                            include "_Page/Antrian/DetailAntrianSimrs.php";
                        }
                    }
                ?>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-header">
                <h4 class="card-title"><i class="icofont-history"></i> Task ID</h4>
            </div>
            <div class="card-block">
                <?php
                    //Membuka Task ID
                    if($ValidasiKelengkapanData!=="Valid"){
                        $TaskId1="";
                        $TaskId2="";
                        $TaskId3="";
                        $TaskId4="";
                        $TaskId5="";
                        $TaskId6="";
                        $TaskId7="";
                        $TaskId99="";
                    }else{
                        $QryTaskId1 = mysqli_query($Conn,"SELECT * FROM antrian_task_id WHERE kodebooking='$kodebooking' AND taskid='1'")or die(mysqli_error($Conn));
                        $DatataskId1 = mysqli_fetch_array($QryTaskId1);
                        if(!empty($DatataskId1['wakturs'])){
                            $TaskId1 = $DatataskId1['wakturs'];
                        }else{
                            $TaskId1="";
                        }
                        $QryTaskId2 = mysqli_query($Conn,"SELECT * FROM antrian_task_id WHERE kodebooking='$kodebooking' AND taskid='2'")or die(mysqli_error($Conn));
                        $DatataskId2 = mysqli_fetch_array($QryTaskId2);
                        if(!empty($DatataskId2['wakturs'])){
                            $TaskId2= $DatataskId2['wakturs'];
                        }else{
                            $TaskId2="";
                        }
                        $QryTaskId3 = mysqli_query($Conn,"SELECT * FROM antrian_task_id WHERE kodebooking='$kodebooking' AND taskid='3'")or die(mysqli_error($Conn));
                        $DatataskId3 = mysqli_fetch_array($QryTaskId3);
                        if(!empty($DatataskId3['wakturs'])){
                            $TaskId3= $DatataskId3['wakturs'];
                        }else{
                            $TaskId3="";
                        }
                        $QryTaskId4 = mysqli_query($Conn,"SELECT * FROM antrian_task_id WHERE kodebooking='$kodebooking' AND taskid='4'")or die(mysqli_error($Conn));
                        $DatataskId4 = mysqli_fetch_array($QryTaskId4);
                        if(!empty($DatataskId4['wakturs'])){
                            $TaskId4= $DatataskId4['wakturs'];
                        }else{
                            $TaskId4="";
                        }
                        $QryTaskId5 = mysqli_query($Conn,"SELECT * FROM antrian_task_id WHERE kodebooking='$kodebooking' AND taskid='5'")or die(mysqli_error($Conn));
                        $DatataskId5 = mysqli_fetch_array($QryTaskId5);
                        if(!empty($DatataskId5['wakturs'])){
                            $TaskId5= $DatataskId5['wakturs'];
                        }else{
                            $TaskId5="";
                        }
                        $QryTaskId6 = mysqli_query($Conn,"SELECT * FROM antrian_task_id WHERE kodebooking='$kodebooking' AND taskid='6'")or die(mysqli_error($Conn));
                        $DatataskId6 = mysqli_fetch_array($QryTaskId6);
                        if(!empty($DatataskId6['wakturs'])){
                            $TaskId6= $DatataskId6['wakturs'];
                        }else{
                            $TaskId6="";
                        }
                        $QryTaskId7 = mysqli_query($Conn,"SELECT * FROM antrian_task_id WHERE kodebooking='$kodebooking' AND taskid='7'")or die(mysqli_error($Conn));
                        $DatataskId7 = mysqli_fetch_array($QryTaskId7);
                        if(!empty($DatataskId7['wakturs'])){
                            $TaskId7= $DatataskId7['wakturs'];
                        }else{
                            $TaskId7="";
                        }
                        $QryTaskId99 = mysqli_query($Conn,"SELECT * FROM antrian_task_id WHERE kodebooking='$kodebooking' AND taskid='99'")or die(mysqli_error($Conn));
                        $DatataskId99 = mysqli_fetch_array($QryTaskId99);
                        if(!empty($DatataskId99['wakturs'])){
                            $TaskId99= $DatataskId99['wakturs'];
                        }else{
                            $TaskId99="";
                        }
                    }
                ?>
                <div class="align-middle m-b-30">
                    <?php
                        if(empty($TaskId1)){
                            echo '<i class="icofont-check-circled icofont-3x text-secondary"></i>';
                        }else{
                            echo '<i class="icofont-check-circled icofont-3x text-success"></i>';
                        }
                    ?>
                    <div class="d-inline-block">
                        <h6>1. Mulai waktu tunggu admisi</h6>
                        <p class="text-muted m-b-0">
                            <?php
                                if(empty($TaskId1)){
                                    if(empty($TaskId99)){
                                        echo '<a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalCheckinAntrian" data-id="'.$kodebooking.'">';
                                        echo '  <small><i class="ti ti-back-right"></i> Checkin Antrian</small>';
                                        echo '</a>';
                                    }else{
                                        echo '<small>Antrian Sudah Dibatalkan!</small>';
                                    }
                                }else{
                                    echo $TaskId1;
                                }
                            ?>
                        </p>
                    </div>
                </div>
                <div class="align-middle m-b-30">
                    <?php
                        if(empty($TaskId2)){
                            echo '<i class="icofont-check-circled icofont-3x text-secondary"></i>';
                        }else{
                            echo '<i class="icofont-check-circled icofont-3x text-success"></i>';
                        }
                    ?>
                    <div class="d-inline-block">
                        <h6>2. Mulai waktu layan admisi</h6>
                        <p class="text-muted m-b-0">
                            <?php
                                if(empty($TaskId2)){
                                    if(!empty($TaskId1)){
                                        if(empty($TaskId99)){
                                            echo '<a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalPangglAntrian" data-id="'.$kodebooking.'">';
                                            echo '  <small><i class="ti ti-back-right"></i> Panggil Antrian</small>';
                                            echo '</a>';
                                        }else{
                                            echo '<small>Antrian Sudah Dibatalkan!</small>';
                                        }
                                    }else{
                                        echo '<small>Pasien Belum Checkin</small>';
                                    }
                                }else{
                                    echo $TaskId2;
                                }
                            ?>
                        </p>
                    </div>
                </div>
                <div class="align-middle m-b-30">
                    <?php
                        if(empty($TaskId3)){
                            echo '<i class="icofont-check-circled icofont-3x text-secondary"></i>';
                        }else{
                            echo '<i class="icofont-check-circled icofont-3x text-success"></i>';
                        }
                    ?>
                    <div class="d-inline-block">
                        <h6>3. Mulai waktu tunggu poli</h6>
                        <p class="text-muted m-b-0">
                            <?php
                                if(empty($TaskId3)){
                                    if(!empty($TaskId2)){
                                        echo '<a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalTungguPoli" data-id="'.$kodebooking.'">';
                                        echo '  <small><i class="ti ti-back-right"></i> Tunggu Poli</small>';
                                        echo '</a>';
                                    }else{
                                        echo '<small>Pasien Belum Ke Admisi</small>';
                                    }
                                }else{
                                    echo $TaskId3;
                                }
                            ?>
                        </p>
                    </div>
                </div>
                <div class="align-middle m-b-30">
                    <?php
                        if(empty($TaskId4)){
                            echo '<i class="icofont-check-circled icofont-3x text-secondary"></i>';
                        }else{
                            echo '<i class="icofont-check-circled icofont-3x text-success"></i>';
                        }
                    ?>
                    <div class="d-inline-block">
                        <h6>4. Mulai waktu layan poli</h6>
                        <p class="text-muted m-b-0">
                            <?php
                                if(empty($TaskId4)){
                                    if(!empty($TaskId3)){
                                        echo '<a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalLayananPoli" data-id="'.$kodebooking.'">';
                                        echo '  <small><i class="ti ti-back-right"></i> Layanan Poli</small>';
                                        echo '</a>';
                                    }else{
                                        echo '<small>Pasien Belum Mendapat Antrian Poli</small>';
                                    }
                                }else{
                                    echo $TaskId4;
                                }
                            ?>
                        </p>
                    </div>
                </div>
                <div class="align-middle m-b-30">
                    <?php
                        if(empty($TaskId5)){
                            echo '<i class="icofont-check-circled icofont-3x text-secondary"></i>';
                        }else{
                            echo '<i class="icofont-check-circled icofont-3x text-success"></i>';
                        }
                    ?>
                    <div class="d-inline-block">
                        <h6>5. Mulai waktu tunggu farmasi</h6>
                        <p class="text-muted m-b-0">
                            <?php
                                if(empty($TaskId5)){
                                    if(!empty($TaskId4)){
                                        echo '<a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalTungguFarmasi" data-id="'.$kodebooking.'">';
                                        echo '  <small><i class="ti ti-back-right"></i> Tunggu Farmasi</small>';
                                        echo '</a>';
                                    }else{
                                        echo '<small>Pasien Belum Dipanggil Oleh Poli</small>';
                                    }
                                }else{
                                    echo $TaskId5;
                                }
                            ?>
                        </p>
                    </div>
                </div>
                <div class="align-middle m-b-30">
                    <?php
                        if(empty($TaskId6)){
                            echo '<i class="icofont-check-circled icofont-3x text-secondary"></i>';
                        }else{
                            echo '<i class="icofont-check-circled icofont-3x text-success"></i>';
                        }
                    ?>
                    <div class="d-inline-block">
                        <h6>6. Mulai waktu layan farmasi membuat obat</h6>
                        <p class="text-muted m-b-0">
                            <?php
                                if(empty($TaskId6)){
                                    if(!empty($TaskId5)){
                                        echo '<a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalLayananFarmasi" data-id="'.$kodebooking.'">';
                                        echo '  <small><i class="ti ti-back-right"></i> Layanan Farmasi</small>';
                                        echo '</a>';
                                    }else{
                                        echo '<small>Pasien Belum Antri Farmasi</small>';
                                    }
                                }else{
                                    echo $TaskId6;
                                }
                            ?>
                        </p>
                    </div>
                </div>
                <div class="align-middle m-b-30">
                    <?php
                        if(empty($TaskId7)){
                            echo '<i class="icofont-check-circled icofont-3x text-secondary"></i>';
                        }else{
                            echo '<i class="icofont-check-circled icofont-3x text-success"></i>';
                        }
                    ?>
                    <div class="d-inline-block">
                        <h6>7. Akhir waktu obat selesai dibuat</h6>
                        <p class="text-muted m-b-0">
                            <?php
                                if(empty($TaskId7)){
                                    if(!empty($TaskId6)){
                                        echo '<a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalLayananSelesai" data-id="'.$kodebooking.'">';
                                        echo '  <small><i class="ti ti-back-right"></i> Layanan Selesai</small>';
                                        echo '</a>';
                                    }else{
                                        echo '<small>Pasien Belum Dipanggil Farmasi</small>';
                                    }
                                }else{
                                    echo $TaskId7;
                                }
                            ?>
                        </p>
                    </div>
                </div>
                <div class="align-middle m-b-30">
                    <?php
                        if(empty($TaskId99)){
                            echo '<i class="icofont-check-circled icofont-3x text-secondary"></i>';
                        }else{
                            echo '<i class="icofont-check-circled icofont-3x text-success"></i>';
                        }
                    ?>
                    <div class="d-inline-block">
                        <h6>99. Tidak hadir/Batal</h6>
                        <p class="text-muted m-b-0">
                            <?php
                                if(empty($TaskId99)){
                                    if(empty($TaskId3)){
                                        echo '<a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalBatalAntrian" data-id="'.$kodebooking.'">';
                                        echo '  <small><i class="ti ti-back-right"></i> Batalkan Antrian</small>';
                                        echo '</a>';
                                    }else{
                                        echo '<small class="text-dark">Antrian Tidak Bisa Dibatalkan</small>';
                                    }
                                }else{
                                    echo $TaskId99;
                                }
                            ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="card">
            <div class="card-header">
                <h4 class="card-title"><i class="ti ti-settings"></i> Operasional</h4>
            </div>
            <div class="card-body">

            </div>
        </div> -->
    </div>
</div>