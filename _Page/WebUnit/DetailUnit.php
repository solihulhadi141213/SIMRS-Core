<?php
    if(empty($_GET['id'])){
        echo 'ID Tidak Boleh Kosong!';
    }else{
        $id=$_GET['id'];
        include "_Config/SettingKoneksiWeb.php";
        include "_Config/WebFunction.php";
        $url=urlServiceInline('Detail Unit');
        $UrlListGaleri=urlService('List Galeri');
        $UrlListAnggota=urlService('List Anggota Unit');
        $KirimData = array(
            'api_key' => $api_key,
            'id_unit_instalasi' => $id
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
            echo ''.$err.'';
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
                echo '<span>'.$massage.'</span>';
            }else{
                $id_unit_instalasi=$JsonData['response']['id_unit_instalasi'];
                $nama_unit_instalasi=$JsonData['response']['nama_unit_instalasi'];
                $deskripsi_unit_instalasi=$JsonData['response']['deskripsi_unit_instalasi'];
                $poster_unit_instalasi=$JsonData['response']['poster_unit_instalasi'];
                $datetime_unit_instalasi=$JsonData['response']['datetime_unit_instalasi'];
                $jumlah_anggota=$JsonData['response']['jumlah_anggota'];
                $jumlah_galeri=$JsonData['response']['jumlah_galeri'];
?>
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">
                        <a href="" class="h5">
                            <i class="ti ti-image"></i> Detail Unit Instalasi
                        </a>
                    </h5>
                    <p class="m-b-0">Lihat detail informasi lengkap mengenai Unit Instalasi</p>
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
                        <div class="card table-card">
                            <div class="card-header border-info">
                                <div class="row">
                                    <div class="col-md-10 mb-3 text-dark">
                                        <h3><?php echo "$nama_unit_instalasi"; ?></h3>
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <a href="index.php?Page=WebUnit" class="btn btn-md btn-block btn-secondary">
                                            <i class="ti ti-angle-left"></i> Kembali
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <img src="<?php echo "$poster_unit_instalasi";?>" alt="Foto Unit" width="100%">
                                    </div>
                                    <div class="col-md-9 mb-3">
                                        <i class="ti ti-calendar"></i> <?php echo "$datetime_unit_instalasi";?><br>
                                        <p><?php echo "$deskripsi_unit_instalasi";?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-6 col-md-12 mt-3">
                        <div class="card table-card">
                            <div class="card-header border-info">
                                <div class="row">
                                    <div class="col-md-6 text-dark">
                                        <h3>List Galeri Unit</h3>
                                        <small>Kelola Data Galeri Unit Disini</small>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-md btn-block btn-primary btn-sm" data-toggle="modal" data-target="#ModalTambahGaleri" data-id="<?php echo "$id"; ?>">
                                            <i class="ti ti-plus"></i> Tambah Galeri
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 mb-3 table table-responsive" id="TabelGaleriEvent">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        <dt>No</dt>
                                                    </th>
                                                    <th>
                                                        <dt>Image</dt>
                                                    </th>
                                                    <th>
                                                        <dt>Judul Galeri</dt>
                                                    </th>
                                                    <th>
                                                        <dt>Option</dt>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    //Akses Data Dari Server Website
                                                    $KirimData = array(
                                                        'api_key' => $api_key,
                                                        'page' => "1",
                                                        'limit' => "100",
                                                        'short_by' => "",
                                                        'order_by' => "",
                                                        'keyword_by' => "id_unit_instalasi",
                                                        'keyword' => $id,
                                                    );
                                                    $json = json_encode($KirimData);
                                                    //Mulai CURL
                                                    $ch = curl_init();
                                                    curl_setopt($ch,CURLOPT_URL, "$UrlListGaleri");
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
                                                        echo '  <td colspan="4" class="text-center">';
                                                        echo '      '.$err.'';
                                                        echo '  </td>';
                                                        echo '</tr>';
                                                    }else{
                                                        $JsonData =json_decode($content, true);
                                                        if(!empty($JsonData['metadata']['massage'])){
                                                            $massage=$JsonData['metadata']['massage'];
                                                        }else{
                                                            $massage="Tidak Ada Pesan Response <br>$content";
                                                        }
                                                        if(!empty($JsonData['metadata']['code'])){
                                                            $code=$JsonData['metadata']['code'];
                                                        }else{
                                                            $code="Kode Tidak Diketahui";
                                                        }
                                                        if($code!==200){
                                                            echo '<tr>';
                                                            echo '  <td colspan="4" class="text-center">';
                                                            echo '      '.$massage.'';
                                                            echo '  </td>';
                                                            echo '</tr>';
                                                        }else{
                                                            $JumlahBaris=count($JsonData['response']['list']);
                                                            if(empty($JumlahBaris)){
                                                                echo '<tr>';
                                                                echo '  <td colspan="4" class="text-center">';
                                                                echo '      Tidak Ada Data Yang Ditampilkan';
                                                                echo '  </td>';
                                                                echo '</tr>';
                                                            }else{
                                                                $list_data=$JsonData['response']['list'];
                                                                $no=1;
                                                                foreach($list_data as $value){
                                                                    $id_web_galeri=$value['id_web_galeri'];
                                                                    $judul_galeri=$value['judul_galeri'];
                                                                    $deskripsi_galeri=$value['deskripsi_galeri'];
                                                                    $tanggal_galeri=$value['tanggal_galeri'];
                                                                    $url_file=$value['url_file'];
                                                ?>
                                                                    <tr>
                                                                        <td class="text-center">
                                                                            <?php echo "$no"; ?>
                                                                        </td>
                                                                        <td class="text-left">
                                                                            <img src="<?php echo "$url_file"; ?>" width="40px">
                                                                        </td>
                                                                        <td class="text-left">
                                                                            <a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalDetailGaleri" data-id="<?php echo "$id_web_galeri"; ?>">
                                                                                <dt><?php echo "$judul_galeri"; ?></dt>
                                                                            </a>
                                                                            <small><?php echo "$tanggal_galeri"; ?></small><br>
                                                                            <a href="<?php echo "$url_file"; ?>" target="_blank" class="text-primary">
                                                                                <small class="text-muted">Open URL</small>
                                                                            </a>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <div class="btn-group dropdown-split-inverse">
                                                                                <button type="button" class="btn btn-sm btn-inverse dropdown-toggle dropdown-toggle-split waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="OptionButton">
                                                                                    <i class="ti ti-settings"></i>
                                                                                </button>
                                                                                <div class="dropdown-menu" x-placement="top-start" style="position: absolute; transform: translate3d(107px, -2px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                                                    <a class="dropdown-item waves-effect waves-light" href="javascript:void(0);" data-toggle="modal" data-target="#ModalEditGaleri" data-id="<?php echo $id_web_galeri;?>">
                                                                                        <i class="ti-pencil"></i> Edit
                                                                                    </a>
                                                                                    <div class="dropdown-divider"></div>
                                                                                    <a class="dropdown-item waves-effect waves-light" href="javascript:void(0);" data-toggle="modal" data-target="#ModalHapusGaleri" data-id="<?php echo $id_web_galeri;?>">
                                                                                        <i class="ti-trash"></i> Hapus
                                                                                    </a>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                <?php
                                                                    $no++;
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
                    <div class="col-xl-6 col-md-12 mt-3">
                        <div class="card table-card">
                            <div class="card-header border-info">
                                <div class="row">
                                    <div class="col-md-6 text-dark">
                                        <h3>Anggota Unit</h3>
                                        <small>Kelola Data Anggota Unit Disini</small>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-md btn-block btn-primary btn-sm" data-toggle="modal" data-target="#ModalTambahAnggota" data-id="<?php echo "$id"; ?>">
                                            <i class="ti ti-plus"></i> Tambah Anggota
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 mb-3 table table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        <dt>No</dt>
                                                    </th>
                                                    <th>
                                                        <dt>Image</dt>
                                                    </th>
                                                    <th>
                                                        <dt>Anggota</dt>
                                                    </th>
                                                    <th>
                                                        <dt>Option</dt>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    //Akses Data Dari Server Website
                                                    $KirimData = array(
                                                        'api_key' => $api_key,
                                                        'id_unit_instalasi' => $id,
                                                    );
                                                    $json = json_encode($KirimData);
                                                    //Mulai CURL
                                                    $ch = curl_init();
                                                    curl_setopt($ch,CURLOPT_URL, "$UrlListAnggota");
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
                                                        echo '  <td colspan="4" class="text-center">';
                                                        echo '      '.$err.'';
                                                        echo '  </td>';
                                                        echo '</tr>';
                                                    }else{
                                                        $JsonData =json_decode($content, true);
                                                        if(!empty($JsonData['metadata']['massage'])){
                                                            $massage=$JsonData['metadata']['massage'];
                                                        }else{
                                                            $massage="Tidak Ada Pesan Response <br>$content";
                                                        }
                                                        if(!empty($JsonData['metadata']['code'])){
                                                            $code=$JsonData['metadata']['code'];
                                                        }else{
                                                            $code="Kode Tidak Diketahui";
                                                        }
                                                        if($code!==200){
                                                            echo '<tr>';
                                                            echo '  <td colspan="4" class="text-center">';
                                                            echo '      '.$massage.'';
                                                            echo '  </td>';
                                                            echo '</tr>';
                                                        }else{
                                                            $JumlahBaris=count($JsonData['response']['list']);
                                                            if(empty($JumlahBaris)){
                                                                echo '<tr>';
                                                                echo '  <td colspan="4" class="text-center">';
                                                                echo '      Tidak Ada Data Yang Ditampilkan';
                                                                echo '  </td>';
                                                                echo '</tr>';
                                                            }else{
                                                                $list_data=$JsonData['response']['list'];
                                                                $no=1;
                                                                foreach($list_data as $value){
                                                                    $id_web_unit_karyawan=$value['id_web_unit_karyawan'];
                                                                    $posisi_jabatan=$value['posisi_jabatan'];
                                                                    $sk_jabatan=$value['sk_jabatan'];
                                                                    $updatetime=$value['updatetime'];
                                                                    $nama_karyawan=$value['nama_karyawan'];
                                                                    $url_foto=$value['url_foto'];
                                                ?>
                                                                    <tr>
                                                                        <td class="text-center">
                                                                            <?php echo "$no"; ?>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <img src="<?php echo "$url_foto"; ?>" width="40px">
                                                                        </td>
                                                                        <td class="text-left">
                                                                            <a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalDetailAnggota" data-id="<?php echo "$id_web_unit_karyawan"; ?>">
                                                                                <dt><?php echo "$nama_karyawan"; ?></dt>
                                                                            </a>
                                                                            <small><?php echo "Posisi: $posisi_jabatan"; ?></small><br>
                                                                            <small><?php echo "SK Jabatan: $sk_jabatan"; ?></small><br>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <div class="btn-group dropdown-split-inverse">
                                                                                <button type="button" class="btn btn-sm btn-inverse dropdown-toggle dropdown-toggle-split waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="OptionButton">
                                                                                    <i class="ti ti-settings"></i>
                                                                                </button>
                                                                                <div class="dropdown-menu" x-placement="top-start" style="position: absolute; transform: translate3d(107px, -2px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                                                    <a class="dropdown-item waves-effect waves-light" href="javascript:void(0);" data-toggle="modal" data-target="#ModalEditAnggota" data-id="<?php echo $id_web_unit_karyawan;?>">
                                                                                        <i class="ti-pencil"></i> Edit
                                                                                    </a>
                                                                                    <div class="dropdown-divider"></div>
                                                                                    <a class="dropdown-item waves-effect waves-light" href="javascript:void(0);" data-toggle="modal" data-target="#ModalHapusAnggota" data-id="<?php echo $id_web_unit_karyawan;?>">
                                                                                        <i class="ti-trash"></i> Hapus
                                                                                    </a>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                <?php
                                                                    $no++;
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
                </div>
            </div>
        </div>
    </div>
</div>
<?php }}} ?>