<?php
if(empty($_GET['id'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12">';
        echo '      <span class="text-danger">ID Dokter Tidak Boleh Kosong!</span>';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_dokter=$_GET['id'];
        include "_Config/SettingKoneksiWeb.php";
        include "_Config/WebFunction.php";
        $url=urlServiceInline('Detail Dokter');
        $KirimData = array(
            'api_key' => $api_key,
            'id_dokter' => $id_dokter
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
                $id_dokter=$JsonData['response']['id_dokter'];
                $kode=$JsonData['response']['kode'];
                $nama=$JsonData['response']['nama'];
                $spesialis=$JsonData['response']['spesialis'];
                $alamat=$JsonData['response']['alamat'];
                $kontak=$JsonData['response']['kontak'];
                $email=$JsonData['response']['email'];
                $status=$JsonData['response']['status'];
                $foto=$JsonData['response']['foto'];
                $last_update=$JsonData['response']['last_update'];
                //Mencari id_dokter di simrs
                $QryDokter = mysqli_query($Conn,"SELECT * FROM dokter WHERE kode='$kode'")or die(mysqli_error($Conn));
                $DataDokter = mysqli_fetch_array($QryDokter);
                if(empty($DataDokter['id_dokter'])){
                    $id_dokter_simrs="";
                    $JumlahJadwalSimrs="";
                }else{
                    $id_dokter_simrs= $DataDokter['id_dokter'];
                    //Mencari jadwal dokter dengan id tersebut
                    $JumlahJadwalSimrs = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM jadwal_dokter WHERE id_dokter='$id_dokter_simrs'"));
                }
                if(!empty($JumlahJadwalSimrs)){
                    $LablJadwalSimrs='<badge class="badge badge-danger">'.$JumlahJadwalSimrs.'</badge>';
                }else{
                    $LablJadwalSimrs="";
                }
?>
    <input type="hidden" id="GetIdDokter" value="<?php echo $id_dokter;?>">
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">
                            <a href="" class="h5"><i class="ti-user"></i> Detail Dokter & Jadwal</a>
                        </h5>
                        <p class="m-b-0">Kelola data dokter dan penjadwalan pada website</p>
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
                        <div class="col-xl-12 col-md-12 mb-3">
                            <div class="card table-card">
                                <div class="card-header border-info">
                                    <div class="row">
                                        <div class="col-md-8 mb-3">
                                            <h4>Detail Dokter</h4>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <a href="index.php?Page=WebDokter" class="btn btn-md btn-secondary btn-block">
                                                <i class="ti ti-arrow-circle-left"></i> Kembali
                                            </a>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <button type="button" class="btn btn-md btn-success btn-block" data-toggle="modal" data-target="#ModalEditDokter" data-id="<?php echo "$id_dokter"; ?>" title="Edit Dokter">
                                                <i class="ti ti-pencil"></i> Edit Dokter
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3 mb-3 text-center">
                                            <?php
                                                if(!empty($JsonData['response']['foto'])){
                                                    echo '<img src="'.$foto.'" width="100%%">';
                                                }
                                            ?>
                                        </div>
                                        <div class="col-md-9 mb-3">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <dt>ID Dokter:</dt>
                                                    <?php echo "$id_dokter"; ?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <dt>Nama Dokter:</dt>
                                                    <?php echo "$nama"; ?>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <dt>Kode Dokter:</dt>
                                                    <?php echo "$kode"; ?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <dt>Spesialis:</dt>
                                                    <?php echo "$spesialis"; ?>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <dt>Alamat:</dt>
                                                    <?php echo "$alamat"; ?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <dt>Kontak:</dt>
                                                    <?php echo "$kontak"; ?>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <dt>Email:</dt>
                                                    <?php echo "$email"; ?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <dt>Status:</dt>
                                                    <?php echo "$status"; ?>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <dt>Last Update:</dt>
                                                    <?php echo "$last_update"; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-5 mb-3">
                                           
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <select name="nama_hari" id="nama_hari" class="form-control">
                                                <option value="">Semua Hari</option>
                                                <option value="Senin">Senin</option>
                                                <option value="Selasa">Selasa</option>
                                                <option value="Rabu">Rabu</option>
                                                <option value="Kamis">Kamis</option>
                                                <option value="Jumat">Jumat</option>
                                                <option value="Sabtu">Sabtu</option>
                                                <option value="Minggu">Minggu</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <button type="button" class="btn btn-md btn-block btn-success" data-toggle="modal" data-target="#ModalTambahJadwalManual" data-id="<?php echo "$id_dokter"; ?>">
                                                <i class="ti-plus"></i> Tambah Manual
                                            </button>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <button type="button" class="btn btn-md btn-block btn-primary" data-toggle="modal" data-target="#ModalListJadwalSimrs" data-id="<?php echo "$id_dokter"; ?>">
                                                <i class="ti-layers"></i> Jadwal SIMRS
                                                <?php echo $LablJadwalSimrs; ?>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body" id="TabelJadwalDokterWeb">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="styleSelector">

            </div>
        </div>
    </div>
<?php }}} ?>