<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">
                        <a href="" class="h5"><i class="ti ti-pencil"></i> Detail Akun Pasien</a>
                    </h5>
                    <p class="m-b-0">Detail akun akses pasien pada website.</p>
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
                        <form action="javascript:void(0);">
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
                                    $id_web_pasien=$_GET['id'];
                                    $url=getServiceUrl('Detail Pasien');
                                    $KirimData = array(
                                        'api_key' => $api_key,
                                        'id_web_pasien' => $id_web_pasien
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
                                            $tanggal_daftar=$JsonData['response']['tanggal_daftar'];
                                            if(empty($JsonData['response']['id_pasien'])){
                                                $id_pasien="";
                                                $LabelIdPasien='<a href="javascript:void(0);" data-toggle="modal" data-target="#ModalTambahPasien" data-id="'.$id_web_pasien.'" class="text-danger"><i class="ti ti-plus"></i> Tambahkan RM</a>';
                                            }else{
                                                $id_pasien=$JsonData['response']['id_pasien'];
                                                $LabelIdPasien='<a href="javascript:void(0);" data-toggle="modal" data-target="#ModalDetailRm" data-id="'.$id_pasien.'" class="text-primary">'.$id_pasien.' <i class="ti ti-layers"></i></a>';
                                            }
                                            if(empty($JsonData['response']['nik'])){
                                                $nik="Tidak Ada";
                                            }else{
                                                $nik=$JsonData['response']['nik'];
                                            }
                                            if(empty($JsonData['response']['bpjs'])){
                                                $bpjs="Tidak Ada";
                                            }else{
                                                $bpjs=$JsonData['response']['bpjs'];
                                            }
                                            $nama=$JsonData['response']['nama'];
                                            $password=$JsonData['response']['password'];
                                            //Format tanggal
                                            $strtotime=strtotime($tanggal_daftar);
                                            $Tanggal=date('d/m/Y H:i',$strtotime);
                                            if(empty($JsonData['response']['propinsi'])){
                                                $propinsi="Tidak Ada";
                                            }else{
                                                $propinsi=$JsonData['response']['propinsi'];
                                            }
                                            if(empty($JsonData['response']['kabupaten'])){
                                                $kabupaten="Tidak Ada";
                                            }else{
                                                $kabupaten=$JsonData['response']['kabupaten'];
                                            }
                                            if(empty($JsonData['response']['kecamatan'])){
                                                $kecamatan="Tidak Ada";
                                            }else{
                                                $kecamatan=$JsonData['response']['kecamatan'];
                                            }
                                            if(empty($JsonData['response']['desa'])){
                                                $desa="Tidak Ada";
                                            }else{
                                                $desa=$JsonData['response']['desa'];
                                            }
                                            if(empty($JsonData['response']['alamat'])){
                                                $alamat="Tidak Ada";
                                            }else{
                                                $alamat=$JsonData['response']['alamat'];
                                            }
                                            if(empty($JsonData['response']['tepat_lahir'])){
                                                $tepat_lahir="None";
                                            }else{
                                                $tepat_lahir=$JsonData['response']['tepat_lahir'];
                                            }
                                            if(empty($JsonData['response']['tanggal_lahir'])){
                                                $tanggal_lahir="None";
                                            }else{
                                                $tanggal_lahir=$JsonData['response']['tanggal_lahir'];
                                            }
                                            if(empty($JsonData['response']['kontak'])){
                                                $kontak="Tidak Ada";
                                            }else{
                                                $kontak=$JsonData['response']['kontak'];
                                            }
                                            if(empty($JsonData['response']['email'])){
                                                $email="None";
                                            }else{
                                                $email=$JsonData['response']['email'];
                                            }
                                            if(empty($JsonData['response']['gol_darah'])){
                                                $gol_darah="";
                                            }else{
                                                $gol_darah=$JsonData['response']['gol_darah'];
                                            }
                                            if(empty($JsonData['response']['sex'])){
                                                $sex="None";
                                            }else{
                                                $sex=$JsonData['response']['sex'];
                                            }
                                            if(empty($JsonData['response']['pekerjaan'])){
                                                $pekerjaan="None";
                                            }else{
                                                $pekerjaan=$JsonData['response']['pekerjaan'];
                                            }
                                            if(empty($JsonData['response']['perkawinan'])){
                                                $perkawinan="None";
                                            }else{
                                                $perkawinan=$JsonData['response']['perkawinan'];
                                            }
                                            if(empty($JsonData['response']['token'])){
                                                $token="Tidak Ada";
                                            }else{
                                                $token=$JsonData['response']['token'];
                                            }
                                            if(empty($JsonData['response']['status'])){
                                                $status="None";
                                            }else{
                                                $status=$JsonData['response']['status'];
                                            }
                                            if(empty($JsonData['response']['updatetime'])){
                                                $updatetime="Tidak Ada";
                                            }else{
                                                $updatetime=$JsonData['response']['updatetime'];
                                                $strtotime2=strtotime($updatetime);
                                                $updatetime=date('d/m/Y H:i',$strtotime2);
                                            }
                                            $foto_profile=$JsonData['response']['foto_profile'];
                            ?>
                                <div class="card table-card">
                                    <div class="card-header border-info">
                                        <div class="row">
                                            <div class="col-md-8 mb-3">
                                                <dt>Detail Akun Akses Pasien</dt>
                                            </div>
                                            <div class="col-md-2 mb-3">
                                                <a href="index.php?Page=WebAksesPasien" class="btn btn-md btn-block btn-secondary">
                                                    <i class="ti ti-angle-left"></i> Kembali
                                                </a>
                                            </div>
                                            <div class="col-md-2 mb-3">
                                                <a href="index.php?Page=WebAksesPasien&Sub=EditPasien&id=<?php echo $id_web_pasien;?>" class="btn btn-md btn-success btn-block">
                                                    <i class="ti ti-pencil-alt"></i> Ubah Akun Web
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
                                                                <td><dt>No.RM</dt></td>
                                                                <td><dt>:</dt></td>
                                                                <td>
                                                                    <?php echo "$LabelIdPasien"; ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><dt>NIK</dt></td>
                                                                <td><dt>:</dt></td>
                                                                <td>
                                                                    <a href="javascript:void(0);" data-toggle="modal" data-target="#ModalDetailNik" data-id="<?php echo "$nik"; ?>" class="text-info">
                                                                        <?php echo "$nik"; ?> <i class="ti ti-layers"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><dt>BPJS</dt></td>
                                                                <td><dt>:</dt></td>
                                                                <td>
                                                                    <a href="javascript:void(0);" data-toggle="modal" data-target="#ModalDetailBpjs" data-id="<?php echo "$bpjs"; ?>" class="text-info">
                                                                        <?php echo "$bpjs"; ?> <i class="ti ti-layers"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><dt>Tanggal Daftar</dt></td>
                                                                <td><dt>:</dt></td>
                                                                <td>
                                                                    <?php echo "$Tanggal"; ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><dt>Nama Pasien</dt></td>
                                                                <td><dt>:</dt></td>
                                                                <td>
                                                                    <?php echo "$nama"; ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><dt>Propinsi</dt></td>
                                                                <td><dt>:</dt></td>
                                                                <td>
                                                                    <?php echo "$propinsi"; ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><dt>Kabupaten</dt></td>
                                                                <td><dt>:</dt></td>
                                                                <td>
                                                                    <?php echo "$kabupaten"; ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><dt>Kecamatan</dt></td>
                                                                <td><dt>:</dt></td>
                                                                <td>
                                                                    <?php echo "$kecamatan"; ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><dt>Desa</dt></td>
                                                                <td><dt>:</dt></td>
                                                                <td>
                                                                    <?php echo "$desa"; ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><dt>Alamat</dt></td>
                                                                <td><dt>:</dt></td>
                                                                <td>
                                                                    <?php echo "$alamat"; ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><dt>TTL</dt></td>
                                                                <td><dt>:</dt></td>
                                                                <td>
                                                                    <?php echo "$tepat_lahir, $tanggal_lahir"; ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><dt>Kontak</dt></td>
                                                                <td><dt>:</dt></td>
                                                                <td>
                                                                    <?php echo "$kontak"; ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><dt>Email</dt></td>
                                                                <td><dt>:</dt></td>
                                                                <td>
                                                                    <?php echo "$email"; ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><dt>Golongan Darah</dt></td>
                                                                <td><dt>:</dt></td>
                                                                <td>
                                                                    <?php echo "$gol_darah"; ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><dt>Jenis Kelamin</dt></td>
                                                                <td><dt>:</dt></td>
                                                                <td>
                                                                    <?php echo "$sex"; ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><dt>Status Perkawinan</dt></td>
                                                                <td><dt>:</dt></td>
                                                                <td>
                                                                    <?php echo "$perkawinan"; ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><dt>Pekerjaan</dt></td>
                                                                <td><dt>:</dt></td>
                                                                <td>
                                                                    <?php echo "$pekerjaan"; ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><dt>Token</dt></td>
                                                                <td><dt>:</dt></td>
                                                                <td>
                                                                    <?php echo "$token"; ?>
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
                                                                <td><dt>Updatetime</dt></td>
                                                                <td><dt>:</dt></td>
                                                                <td>
                                                                    <?php echo "$updatetime"; ?>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card table-card">
                                    <div class="card-header border-info">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <dt>Histori Kunjungan pasien</dt>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12 mb-3 pre-scrollable">
                                                <div class="table table-responsive">
                                                    <table class="table table-hover table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-center"><dt>No</dt></th>
                                                                <th class="text-center"><dt>Tanggal</dt></th>
                                                                <th class="text-center"><dt>Booking</dt></th>
                                                                <th class="text-center"><dt>Dokter</dt></th>
                                                                <th class="text-center"><dt>Poliklinik</dt></th>
                                                                <th class="text-center"><dt>Pembayaran</dt></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                                $UrlListKunjungan=getServiceUrl('List Kunjungan');
                                                                $UrlInfoKunjungan=getServiceUrl('Info Kunjungan');
                                                                //keyword
                                                                $keyword=$id_web_pasien;
                                                                //keyword_by
                                                                $keyword_by="id_web_pasien";
                                                                //batas
                                                                if(!empty($_POST['batas'])){
                                                                    $batas=$_POST['batas'];
                                                                }else{
                                                                    $batas="2000";
                                                                    //Agar Tampil semua
                                                                }
                                                                //ShortBy
                                                                if(!empty($_POST['ShortBy'])){
                                                                    $ShortBy=$_POST['ShortBy'];
                                                                }else{
                                                                    $ShortBy="DESC";
                                                                }
                                                                //OrderBy
                                                                if(!empty($_POST['OrderBy'])){
                                                                    $OrderBy=$_POST['OrderBy'];
                                                                }else{
                                                                    $OrderBy="id_kunjungan";
                                                                }
                                                                //Atur Page
                                                                if(!empty($_POST['page'])){
                                                                    $page=$_POST['page'];
                                                                    $posisi = ( $page - 1 ) * $batas;
                                                                }else{
                                                                    $page="1";
                                                                    $posisi = 0;
                                                                }
                                                                $parameter="jumlah";
                                                                $jml_data =jumlahData($api_key,$UrlInfoKunjungan,$keyword_by,$keyword,$parameter);
                                                                if(empty($jml_data)){
                                                                    echo '<tr>';
                                                                    echo '  <td colspan="6" class="text-center">';
                                                                    echo '      Tidak Ada Data Kunjungan Pada Web Untuk pasien ini';
                                                                    echo '  </td>';
                                                                    echo '</tr>';
                                                                }else{
                                                                    //Akses Data Dari Server Website
                                                                    $KirimData = array(
                                                                        'api_key' => $api_key,
                                                                        'page' => $page,
                                                                        'limit' => $batas,
                                                                        'short_by' => $ShortBy,
                                                                        'order_by' => $OrderBy,
                                                                        'keyword_by' => $keyword_by,
                                                                        'keyword' => $keyword,
                                                                    );
                                                                    $json = json_encode($KirimData);
                                                                    //Mulai CURL
                                                                    $ch = curl_init();
                                                                    curl_setopt($ch,CURLOPT_URL, "$UrlListKunjungan");
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
                                                                        echo '<tr>';
                                                                        echo '  <td colspan="6" class="text-center">';
                                                                        echo '      '.$err.'';
                                                                        echo '  </td>';
                                                                        echo '</tr>';
                                                                    }else{
                                                                        $JsonData =json_decode($content, true);
                                                                        if(!empty($JsonData['metadata']['massage'])){
                                                                            $massage=$JsonData['metadata']['massage'];
                                                                        }else{
                                                                            $massage="Tidak Ada Pesan Response";
                                                                        }
                                                                        if(!empty($JsonData['metadata']['code'])){
                                                                            $code=$JsonData['metadata']['code'];
                                                                        }else{
                                                                            $code="Kode Tidak Diketahui";
                                                                        }
                                                                        if($code!==200){
                                                                            echo '<tr>';
                                                                            echo '  <td colspan="6" class="text-center">';
                                                                            echo '      '.$massage.'';
                                                                            echo '  </td>';
                                                                            echo '</tr>';
                                                                        }else{
                                                                            $JumlahBaris=count($JsonData['response']['list']);
                                                                            if(empty($JumlahBaris)){
                                                                                echo '<tr>';
                                                                                echo '  <td colspan="6" class="text-center">';
                                                                                echo '      Tidak Ada Data Yang Ditampilkan';
                                                                                echo '  </td>';
                                                                                echo '</tr>';
                                                                            }else{
                                                                                $list_data=$JsonData['response']['list'];
                                                                                $no=1;
                                                                                foreach($list_data as $value){
                                                                                    $id_kunjungan=$value['id_kunjungan'];
                                                                                    $id_web_pasien=$value['id_web_pasien'];
                                                                                    if(empty($value['nomorreferensi'])){
                                                                                        $nomorreferensi="Tidak Ada";
                                                                                    }else{
                                                                                        $nomorreferensi=$value['nomorreferensi'];
                                                                                    }
                                                                                    $tanggal_daftar=$value['tanggal_daftar'];
                                                                                    $tanggal_kunjungan=$value['tanggal_kunjungan'];
                                                                                    $jam_kunjungan=$value['jam_kunjungan'];
                                                                                    $kode_dokter=$value['kode_dokter'];
                                                                                    $nama_dokter=$value['nama_dokter'];
                                                                                    $kodepoli=$value['kodepoli'];
                                                                                    $namapoli=$value['namapoli'];
                                                                                    $keluhan=$value['keluhan'];
                                                                                    $pembayaran=$value['pembayaran'];
                                                                                    $status=$value['status'];
                                                                                    if(empty($value['no_antrian'])){
                                                                                        $no_antrian="Tidak Ada";
                                                                                    }else{
                                                                                        $no_antrian=$value['no_antrian'];
                                                                                    }
                                                                                    if(empty($value['kodebooking'])){
                                                                                        $kodebooking="Tidak Ada";
                                                                                    }else{
                                                                                        $kodebooking=$value['kodebooking'];
                                                                                    }
                                                                                    $keterangan=$value['keterangan'];
                                                            ?>
                                                                <tr tabindex="0" class="table-light" data-toggle="modal" data-target="#ModalDetailKunjungan" data-id="<?php echo "$id_kunjungan";?>" onmousemove="this.style.cursor='pointer'">
                                                                    <td class="text-center">
                                                                        <?php echo "$no"; ?>
                                                                    </td>
                                                                    <td class="text-left">
                                                                        <?php 
                                                                            echo "<dt>Tgl Daftar : $tanggal_daftar</dt>"; 
                                                                            echo "<small class='text-muted'>Tgl Kunjungan : $tanggal_kunjungan</small><br>"; 
                                                                            echo "<small class='text-muted'>Jam Kunjungan : $jam_kunjungan</small><br>"; 
                                                                        ?>
                                                                    </td>
                                                                    <td class="text-left">
                                                                        <?php 
                                                                            echo "<dt>Antrian : $no_antrian</dt>"; 
                                                                            echo "<small class='text-muted'>Kode : $kodebooking</small><br>"; 
                                                                            echo "<small class='text-muted'>Referensi : $nomorreferensi</small><br>"; 
                                                                        ?>
                                                                    </td>
                                                                    <td class="text-left">
                                                                        <?php 
                                                                            echo "<dt>$kode_dokter</dt>"; 
                                                                            echo "<small class='text-muted'>$nama_dokter</small>"; 
                                                                        ?>
                                                                    </td>
                                                                    <td class="text-left">
                                                                        <?php 
                                                                            echo "<dt>$kodepoli</dt>"; 
                                                                            echo "<small class='text-muted'>$namapoli</small>"; 
                                                                        ?>
                                                                    </td>
                                                                    <td class="text-left">
                                                                        <?php 
                                                                            echo "<dt>$pembayaran</dt>"; 
                                                                            echo "<small class='text-muted'>$status</small>"; 
                                                                        ?>
                                                                    </td>
                                                                </tr>
                                                            <?php
                                                                                $no++;
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            ?>
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
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>