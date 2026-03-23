<?php
    if(empty($_GET['id'])){
        echo 'ID Tidak Boleh Kosong!';
    }else{
        $id=$_GET['id'];
        include "_Config/SettingKoneksiWeb.php";
        include "_Config/WebFunction.php";
        $url=urlServiceInline('Detail Unit');
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
<input type="hidden" id="id_unit_instalasi" name="id_unit_instalasi" value="<?php echo "$id_unit_instalasi"; ?>">
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">
                        <a href="" class="h5"><i class="ti-layout-menu-v"></i> Edit Unit Instlasi</a>
                    </h5>
                    <p class="m-b-0">Edit data unit instalasi yang ditampilkan di halaman website</p>
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
                                    <div class="col-md-2">
                                        <a href="index.php?Page=WebUnit" class="btn btn-md btn-block btn-secondary" title="Kembali Ke Halaman Utama Unit">
                                            <i class="ti-arrow-left text-white"></i> Kembali
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="nama_unit_instalasi">Nama Unit/Instalasi</label>
                                        <input type="text" id="nama_unit_instalasi" name="nama_unit_instalasi" class="form-control" value="<?php echo "$nama_unit_instalasi"; ?>">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="poster_unit_instalasi">File Poster</label>
                                        <input type="file" id="poster_unit_instalasi" name="poster_unit_instalasi" class="form-control">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="deskripsi_unit_instalasi">Deskripsi</label>
                                        <textarea name="deskripsi_unit_instalasi" id="deskripsi_unit_instalasi" cols="30" rows="3" class="form-control"><?php echo "$deskripsi_unit_instalasi"; ?></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-3" id="NotifikasiEditUnit">
                                        <span class="text-primary">Pastikan anda mengisi data informasi dengan lengkap dan sesuai</span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-md btn-primary" id="KonfirmasiEditUnit">
                                    <i class="ti ti-save"></i> Simpan
                                </button>
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