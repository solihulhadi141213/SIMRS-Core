<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">
                        <a href="" class="h5"><i class="ti ti-bag"></i> Edit Lowongan Kerja</a>
                    </h5>
                    <p class="m-b-0">Edit data lowongan kerja</p>
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
                        <form action="javascript:void(0);" id="ProsesEditLoker">
                            <input type="hidden" id="id_loker" name="id_loker" value="<?php echo "$id_loker"; ?>">
                            <div class="card table-card">
                                <div class="card-header border-info">
                                    <div class="row">
                                        <div class="col-md-9">
                                            <dt>Form Edit Lowongan Kerja</dt>
                                        </div>
                                        <div class="col-md-3">
                                            <a href="index.php?Page=WebLoker" class="btn btn-sm btn-block btn-secondary">
                                                <i class="ti ti-angle-left"></i> Kembali
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3 mb-3">
                                            <label for="tanggal_expired">Tanggal Berakhir</label>
                                            <input type="date" name="tanggal_expired" id="tanggal_expired" class="form-control" value="<?php echo "$Tanggal"; ?>">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="jam_expired">Jam Berakhir</label>
                                            <input type="time" name="jam_expired" id="jam_expired" class="form-control" value="<?php echo "$Jam"; ?>">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="jumlah_loker">Jumlah</label>
                                            <input type="number" name="jumlah_loker" id="jumlah_loker" class="form-control" value="<?php echo "$jumlah_loker"; ?>">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="status_loker">Status Loker</label>
                                            <select name="status_loker" id="status_loker" class="form-control">
                                                <option <?php if($status_loker=="Active"){echo "selected";} ?> value="Active">Active</option>
                                                <option <?php if($status_loker=="Closed"){echo "selected";} ?> value="Closed">Closed</option>
                                                <option <?php if($status_loker=="Expired"){echo "selected";} ?> value="Expired">Expired</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="posisi_jabatan">Posisi/Jabatan</label>
                                            <input type="text" name="posisi_jabatan" id="posisi_jabatan" class="form-control" value="<?php echo "$posisi_jabatan"; ?>">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="deskripsi_loker">Deskripsi Loker</label>
                                            <textarea name="deskripsi_loker" id="deskripsi_loker" cols="30" rows="4" class="form-control"><?php echo "$deskripsi_loker"; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col col-md-12 mb-3">
                                            <span class="text-primary" id="NotifikasiEditLoker">Pastikan semua data lowongan sudah terisi dengan benar</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="button" class="btn btn-md btn-primary" id="KlikProsesEditLoker">
                                        <i class="ti ti-save"></i> Simpan
                                    </button>
                                </div>
                            </div>
                        </form>
                        <?php }}} ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>