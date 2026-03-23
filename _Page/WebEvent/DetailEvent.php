<?php
    if(empty($_GET['id'])){
        echo 'ID Tidak Boleh Kosong!';
    }else{
        $id=$_GET['id'];
        include "_Config/SettingKoneksiWeb.php";
        include "_Config/WebFunction.php";
        $url=urlServiceInline('Detail Event');
        $UrlListGaleri=urlService('List Galeri');
        $KirimData = array(
            'api_key' => $api_key,
            'id_web_event' => $id
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
                $id_web_event=$JsonData['response']['id_web_event'];
                $nama_event=$JsonData['response']['nama_event'];
                $kategori_event=$JsonData['response']['kategori_event'];
                $tanggal_event=$JsonData['response']['tanggal_event'];
                $deskripsi_event=$JsonData['response']['deskripsi_event'];
                $poster_event=$JsonData['response']['poster_event'];
                //explode tanggal
                $explode = explode(" " , $tanggal_event);
                $tanggal = $explode[0];
                $jam = $explode[1];
?>
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">
                        <a href="" class="h5">
                            <i class="ti ti-image"></i> Detail Album Event
                        </a>
                    </h5>
                    <p class="m-b-0">Lihat detail informasi lengkap mengenai album event</p>
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
                                    <div class="col-md-8 mb-3 text-dark">
                                        <h3><?php echo "$nama_event"; ?></h3>
                                        <i class="ti ti-tag"></i> <?php echo "$kategori_event"; ?>
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <a href="index.php?Page=WebEvent" class="btn btn-md btn-block btn-secondary">
                                            <i class="ti ti-angle-left"></i> Kembali
                                        </a>
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <a href="index.php?Page=WebEvent&Sub=EditEvent&id=<?php echo $id_web_event;?>" class="btn btn-md btn-success btn-block">
                                            <i class="ti ti-pencil"></i> Edit Event
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <img src="<?php echo "$poster_event";?>" alt="Foto Event" width="100%">
                                    </div>
                                    <div class="col-md-9 mb-3">
                                        <i class="ti ti-calendar"></i> <?php echo "$tanggal_event";?><br>
                                        <p><?php echo "$deskripsi_event";?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12 col-md-12 mt-3">
                        <div class="card table-card">
                            <div class="card-header border-info">
                                <div class="row">
                                    <div class="col-md-10 text-dark">
                                        <h3>List Galeri Event</h3>
                                        <small>Kelola Data Galeri Event Disini</small>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-md btn-block btn-primary" data-toggle="modal" data-target="#ModalTambahGaleri" data-id="<?php echo "$id"; ?>">
                                            <i class="ti ti-plus"></i> Tambah Galeri
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 mb-3 table table-responsive" id="TabelGaleriEvent">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        <dt>No</dt>
                                                    </th>
                                                    <th>
                                                        <dt>Judul Galeri</dt>
                                                    </th>
                                                    <th>
                                                        <dt>File</dt>
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
                                                        'keyword_by' => "id_web_event",
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
                                                                            <a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalDetailGaleri" data-id="<?php echo "$id_web_galeri"; ?>">
                                                                                <dt><?php echo "$judul_galeri"; ?></dt>
                                                                            </a>
                                                                            <small><?php echo "$tanggal_galeri"; ?></small>
                                                                        </td>
                                                                        <td class="text-left">
                                                                            <a href="<?php echo "$url_file"; ?>" target="_blank" class="text-primary">
                                                                                Open URL
                                                                            </a>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <a href="javascript:void(0);" class="text-danger" data-toggle="modal" data-target="#ModalHapusGaleri" data-id="<?php echo "$id_web_galeri"; ?>">
                                                                                <i class="ti ti-close"></i> Hapus
                                                                            </a>
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