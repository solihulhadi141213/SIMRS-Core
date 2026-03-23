<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">
                        <a href="" class="h5"><i class="ti ti-info-alt"></i> Detail Kunjungan Pasien</a>
                    </h5>
                    <p class="m-b-0">Detail Kunjungan Pasien Dari Data Website.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="row">
                    <div class="col-xl-12 col-md-12">
                        <?php
                            if(empty($_GET['id'])){
                                echo '<div class="row">';
                                echo '  <div class="col-md-12">';
                                echo '      <span class="text-danger">ID Tidak Boleh Kosong!</span>';
                                echo '  </div>';
                                echo '</div>';
                            }else{
                                include "_Config/SettingKoneksiWeb.php";
                                include "_Config/WebFunction.php";
                                $id_kunjungan=$_GET['id'];
                                $url=getServiceUrl('Detail Kunjungan');
                                $KirimData = array(
                                    'api_key' => $api_key,
                                    'id_kunjungan' => $id_kunjungan
                                );
                                $json = json_encode($KirimData);
                                //Mulai CURL
                                $ch = curl_init();
                                curl_setopt($ch,CURLOPT_URL, "$url");
                                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                                curl_setopt($ch,CURLOPT_HEADER, 0);
                                curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
                                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                                curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                $content = curl_exec($ch);
                                $err = curl_error($ch);
                                curl_close($ch);
                                if(!empty($err)){
                                    echo '<div class="row">';
                                    echo '  <div class="col-md-12">';
                                    echo '      <span class="text-danger">'.$err.'</span>';
                                    echo '  </div>';
                                    echo '</div>';
                                }else{
                                    $JsonData =json_decode($content, true);
                                    if(!empty($JsonData['metadata']['massage'])){
                                        $massage=$JsonData['metadata']['massage'];
                                    }else{
                                        $massage="";
                                    }
                                    if(!empty($JsonData['metadata']['code'])){
                                        $code=$JsonData['metadata']['code'];
                                    }else{
                                        $code="";
                                    }
                                    if($code!==200){
                                        echo '<div class="row">';
                                        echo '  <div class="col-md-12">';
                                        echo '      <span class="text-danger">'.$massage.'</span>';
                                        echo '  </div>';
                                        echo '</div>';
                                    }else{
                                        $id_web_pasien=$JsonData['response']['id_web_pasien'];
                                        if(empty($JsonData['response']['id_pasien'])){
                                            //Melakukan Pencarian id_pasien pada data pasien
                                            $urlAksesPasien=getServiceUrl('Detail Pasien');
                                            $ResponseDetailAksesPasien=GetAksesPasien($api_key,$urlAksesPasien,$id_web_pasien);
                                            $ResponseDetailAksesPasienDecode =json_decode($ResponseDetailAksesPasien, true);
                                            if($ResponseDetailAksesPasienDecode['metadata']['code']!==200){
                                                $id_pasien="Response Web Error $ResponseDetailAksesPasien";
                                                $IdPasien="";
                                            }else{
                                                if(empty($ResponseDetailAksesPasienDecode['response']['id_pasien'])){
                                                    $id_pasien="Tidak Ada";
                                                    $IdPasien="";
                                                }else{
                                                    $id_pasien=$ResponseDetailAksesPasienDecode['response']['id_pasien'];
                                                    $IdPasien=$ResponseDetailAksesPasienDecode['response']['id_pasien'];
                                                }
                                            }
                                        }else{
                                            $id_pasien=$JsonData['response']['id_pasien'];
                                            $IdPasien=$JsonData['response']['id_pasien'];
                                        }
                                        if(empty($JsonData['response']['nomorreferensi'])){
                                            $nomorreferensi="Tidak Ada";
                                        }else{
                                            $nomorreferensi=$JsonData['response']['nomorreferensi'];
                                        }
                                        $tanggal_daftar=$JsonData['response']['tanggal_daftar'];
                                        $tanggal_kunjungan=$JsonData['response']['tanggal_kunjungan'];
                                        $jam_kunjungan=$JsonData['response']['jam_kunjungan'];
                                        $kode_dokter=$JsonData['response']['kode_dokter'];
                                        $nama_dokter=$JsonData['response']['nama_dokter'];
                                        $kodepoli=$JsonData['response']['kodepoli'];
                                        $namapoli=$JsonData['response']['namapoli'];
                                        $keluhan=$JsonData['response']['keluhan'];
                                        $pembayaran=$JsonData['response']['pembayaran'];
                                        $status=$JsonData['response']['status'];
                                        if(empty($JsonData['response']['no_antrian'])){
                                            $no_antrian="Tidak Ada";
                                        }else{
                                            $no_antrian=$JsonData['response']['no_antrian'];
                                        }
                                        if(empty($JsonData['response']['kodebooking'])){
                                            $kodebooking="Tidak Ada";
                                            $KodeBooking="";
                                        }else{
                                            $kodebooking=$JsonData['response']['kodebooking'];
                                            $KodeBooking=$JsonData['response']['kodebooking'];
                                        }
                                        if(empty($JsonData['response']['keterangan'])){
                                            $keterangan="Tidak Ada";
                                        }else{
                                            $keterangan=$JsonData['response']['keterangan'];
                                        }
                                        //Buka Data Pasien
                                        $urlDetailPasien=getServiceUrl('Detail Pasien');
                                        $KirimDataPasien2 = array(
                                            'api_key' => $api_key,
                                            'id_web_pasien' => $id_web_pasien
                                        );
                                        $Metode="POST";
                                        $ResponsePasien=GetResponseApis($urlDetailPasien,$KirimDataPasien2,$Metode);
                                        $KodeResponse=$ResponsePasien['metadata']['code'];
                                        $NamaPasien=$ResponsePasien['response']['nama'];
                                        $NamaPasien=$ResponsePasien['response']['nama'];
                        ?>
                            <div class="card table-card">
                                <div class="card-header border-info">
                                    <div class="row">
                                        <div class="col-md-8 mb-3">
                                            <dt>Informasi Pendaftaran Kunjungan</dt>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <a href="index.php?Page=WebKunjungan" class="btn btn-md btn-block btn-secondary">
                                                <i class="ti ti-angle-left"></i> Kembali
                                            </a>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <a href="index.php?Page=WebKunjungan&Sub=EditKunjungan&id=<?php echo "$id_kunjungan"; ?>" class="btn btn-md btn-block btn-success">
                                                <i class="ti ti-pencil-alt"></i> Edit Kunjungan
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <div class="table table-responsive">
                                                <table class="table table-hover">
                                                    <tbody>
                                                        <tr>
                                                            <td><dt>ID. Web Pasien</dt></td>
                                                            <td><dt>:</dt></td>
                                                            <td>
                                                                <?php echo "$id_web_pasien"; ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><dt>Nama Pasien</dt></td>
                                                            <td><dt>:</dt></td>
                                                            <td>
                                                                <?php echo "$NamaPasien"; ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><dt>No.RM</dt></td>
                                                            <td><dt>:</dt></td>
                                                            <td>
                                                                <?php echo "$id_pasien"; ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><dt>No.Referensi</dt></td>
                                                            <td><dt>:</dt></td>
                                                            <td>
                                                                <?php echo "$nomorreferensi"; ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><dt>Tanggal Daftar</dt></td>
                                                            <td><dt>:</dt></td>
                                                            <td>
                                                                <?php echo "$tanggal_daftar"; ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><dt>Tanggal Kunjungan</dt></td>
                                                            <td><dt>:</dt></td>
                                                            <td>
                                                                <?php echo "$tanggal_kunjungan"; ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><dt>Jam Kunjungan</dt></td>
                                                            <td><dt>:</dt></td>
                                                            <td>
                                                                <?php echo "$jam_kunjungan"; ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><dt>Kode Dokter</dt></td>
                                                            <td><dt>:</dt></td>
                                                            <td>
                                                                <?php echo "$kode_dokter"; ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><dt>Nama Dokter</dt></td>
                                                            <td><dt>:</dt></td>
                                                            <td>
                                                                <?php echo "$nama_dokter"; ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><dt>Kode Poli</dt></td>
                                                            <td><dt>:</dt></td>
                                                            <td>
                                                                <?php echo "$kodepoli"; ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><dt>Nama Poli</dt></td>
                                                            <td><dt>:</dt></td>
                                                            <td>
                                                                <?php echo "$namapoli"; ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><dt>Keluhan</dt></td>
                                                            <td><dt>:</dt></td>
                                                            <td>
                                                                <?php echo "$keluhan"; ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><dt>Pembayaran</dt></td>
                                                            <td><dt>:</dt></td>
                                                            <td>
                                                                <?php echo "$pembayaran"; ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><dt>Status</dt></td>
                                                            <td><dt>:</dt></td>
                                                            <td>
                                                                <?php echo "$status"; ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><dt>No.Antrian</dt></td>
                                                            <td><dt>:</dt></td>
                                                            <td>
                                                                <?php echo "$no_antrian"; ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><dt>Kode Booking</dt></td>
                                                            <td><dt>:</dt></td>
                                                            <td>
                                                                <?php echo "$kodebooking"; ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><dt>Keterangan</dt></td>
                                                            <td><dt>:</dt></td>
                                                            <td>
                                                                <?php echo "$keterangan"; ?>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php 
                                    }
                                }
                            }
                        ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card table-card">
                            <div class="card-header border-info">
                                <div class="row">
                                    <div class="col-md-8">
                                        <dt>
                                            Data Kode Booking Antrian SIMRS
                                        </dt>
                                    </div>
                                    <div class="col-md-4">
                                        <?php
                                            if(empty($JsonData['response']['no_antrian'])){
                                                echo '<button type="button" class="btn btn-md btn-block btn-outline-danger" data-toggle="modal" data-target="#ModalAddToAntrian" data-id="'.$id_kunjungan.'">';
                                                echo '  Tambahkan Ke Antrian SIMRS';
                                                echo '</button>';
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <?php
                                    if(empty($JsonData['response']['no_antrian'])){
                                        echo '<div class="row">';
                                        echo '  <div class="col-md-12">';
                                        echo '      <div class="alert alert-danger" role="alert">';
                                        echo '          Belum Ada Kode Booking Yang Terhubung';
                                        echo '      </div>';
                                        echo '  </div>';
                                        echo '</div>';
                                    }else{
                                        //Buka antrian Berdasarkan Kode Booking
                                        $Qry = mysqli_query($Conn,"SELECT * FROM antrian WHERE kodebooking='$kodebooking'")or die(mysqli_error($Conn));
                                        $Data = mysqli_fetch_array($Qry);
                                        if(empty($Data['id_antrian'])){
                                            echo '<div class="row">';
                                            echo '  <div class="col-md-12">';
                                            echo '      <div class="alert alert-danger" role="alert">';
                                            echo '          Kode Booking tidak valid atau tidak ditemukan pada SIMRS';
                                            echo '      </div>';
                                            echo '  </div>';
                                            echo '</div>';
                                        }else{
                                            $id_antrian= $Data['id_antrian'];
                                            $no_antrian= $Data['no_antrian'];
                                            $id_pasien= $Data['id_pasien'];
                                            $nama_pasien= $Data['nama_pasien'];
                                            $kode_dokter= $Data['kode_dokter'];
                                            $nama_dokter= $Data['nama_dokter'];
                                            $kodepoli= $Data['kodepoli'];
                                            $namapoli= $Data['namapoli'];
                                            $tanggal_kunjungan= $Data['tanggal_kunjungan'];
                                            $jam_kunjungan= $Data['jam_kunjungan'];
                                            $status= $Data['status'];
                                ?>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <div class="table table-responsive table-hover">
                                                <table width="100%">
                                                    <tr>
                                                        <td><dt>ID Antrian</dt></td>
                                                        <td><dt>:</dt></td>
                                                        <td><?php echo "$id_antrian";?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><dt>Kode Booking</dt></td>
                                                        <td><dt>:</dt></td>
                                                        <td><?php echo "$kodebooking";?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><dt>No.Antrian</dt></td>
                                                        <td><dt>:</dt></td>
                                                        <td><?php echo "$no_antrian";?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><dt>No.RM</dt></td>
                                                        <td><dt>:</dt></td>
                                                        <td><?php echo "$id_pasien";?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><dt>Nama Pasien</dt></td>
                                                        <td><dt>:</dt></td>
                                                        <td><?php echo "$nama_pasien";?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><dt>Kode Dokter</dt></td>
                                                        <td><dt>:</dt></td>
                                                        <td><?php echo "$kode_dokter";?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><dt>Nama Dokter</dt></td>
                                                        <td><dt>:</dt></td>
                                                        <td><?php echo "$nama_dokter";?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><dt>Kode Poliklinik</dt></td>
                                                        <td><dt>:</dt></td>
                                                        <td><?php echo "$kodepoli";?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><dt>Poliklinik</dt></td>
                                                        <td><dt>:</dt></td>
                                                        <td><?php echo "$namapoli";?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><dt>Tanggal Kunjungan</dt></td>
                                                        <td><dt>:</dt></td>
                                                        <td><?php echo "$tanggal_kunjungan";?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><dt>Jam Kunjungan</dt></td>
                                                        <td><dt>:</dt></td>
                                                        <td><?php echo "$jam_kunjungan";?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><dt>Status</dt></td>
                                                        <td><dt>:</dt></td>
                                                        <td><?php echo "$status";?></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <button type="button" class="btn btn-md btn-secondary btn-block" data-toggle="modal" data-target="#ModalRiwayatTaskId" data-id="<?php echo "$id_antrian"; ?>">
                                                <i class="ti ti-time"></i> Riwayat Task ID
                                            </button>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <button type="button" class="btn btn-md btn-danger btn-block" data-toggle="modal" data-target="#ModalHapusAntrian" data-id="<?php echo "$id_antrian,$id_kunjungan"; ?>">
                                                <i class="ti ti-trash"></i> Hapus Antrian
                                            </button>
                                        </div>
                                    </div>
                                <?php
                                    }}
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>