<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">
                        <a href="" class="h5"><i class="ti ti-bag"></i> Detail Lowongan Kerja</a>
                    </h5>
                    <p class="m-b-0">Detail informasi data lowongan kerja</p>
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
                                echo '<div class="card">';
                                echo '  <div class="card-body">';
                                echo '      ID Loker Tidak Boleh Kosong!';
                                echo '  </div>';
                                echo '</d>';
                            }else{
                                $id_loker=$_GET['id'];
                                //Menampilkan data
                                include "_Config/SettingKoneksiWeb.php";
                                include "_Config/WebFunction.php";
                                $url=urlService('Detail Loker');
                                //Akses Data Dari Server Website
                                $KirimData = array(
                                    'api_key' => $api_key,
                                    'id_loker' => $id_loker,
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
                                    echo '<div class="card">';
                                    echo '  <div class="card-body">';
                                    echo '      '.$err.'';
                                    echo '  </div>';
                                    echo '</d>';
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
                                        echo '<div class="card">';
                                        echo '  <div class="card-body">';
                                        echo '      '.$massage.'';
                                        echo '  </div>';
                                        echo '</d>';
                                    }else{
                                        $response=$JsonData['response'];
                                        //Buat Variabel Detail
                                        $datetime_post=$response['datetime_post'];
                                        $posisi_jabatan=$response['posisi_jabatan'];
                                        $jumlah_loker=$response['jumlah_loker'];
                                        $deskripsi_loker=$response['deskripsi_loker'];
                                        $pengumuman=$response['pengumuman'];
                                        $status_loker=$response['status_loker'];
                                        //Explode jam
                                        $Explode = explode(" " , $datetime_post);
                                        $Tanggal=$Explode[0];
                                        if(!empty($Explode[1])){
                                            $Jam=$Explode[1];
                                        }else{
                                            $Jam="";
                                        }
                        ?>
                        <div class="card table-card">
                            <div class="card-header border-info">
                                <div class="row">
                                    <div class="col-md-8">
                                        <dt><?php echo "$posisi_jabatan"; ?></dt>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="javascript:void(0);" class="btn btn-sm btn-block btn-success" id="MulaiEdit">
                                            <i class="ti ti-pencil"></i> Mulai Edit
                                        </a>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="index.php?Page=WebLoker" class="btn btn-sm btn-block btn-secondary">
                                            <i class="ti ti-angle-left"></i> Kembali
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <dt>Tanggal Berakhir:</dt>
                                        <?php echo "$datetime_post"; ?>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <dt>Jumlah Loker :</dt>
                                        <?php echo "$jumlah_loker Orang"; ?>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <dt>Status Loker :</dt>
                                        <?php echo "$status_loker"; ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="posisi_jabatan">Posisi/Jabatan</label>
                                        <input disabled type="text" name="posisi_jabatan" id="posisi_jabatan" class="form-control" value="<?php echo "$posisi_jabatan"; ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="deskripsi_loker">Deskripsi Loker</label>
                                        <textarea disabled name="deskripsi_loker2" id="deskripsi_loker2" cols="30" rows="4" class="form-control"><?php echo "$deskripsi_loker"; ?></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="pengumuman">Pengumuman Loker</label>
                                        <textarea disabled name="pengumuman2" id="pengumuman2" cols="30" rows="4" class="form-control"><?php echo "$pengumuman"; ?></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col col-md-12 mb-3">
                                        <span class="text-primary" id="NotifikasiEditLoker">Pastikan semua data lowongan sudah terisi dengan benar</span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="button" disabled class="btn btn-md btn-primary" id="KlikProsesEditLoker">
                                    <i class="ti ti-save"></i> Simpan
                                </button>
                            </div>
                        </div>
                        <?php }}} ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>