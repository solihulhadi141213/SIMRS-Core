<?php
    if(empty($_GET['id'])){
        echo 'ID Tidak Boleh Kosong!';
    }else{
        $id=$_GET['id'];
        include "_Config/SettingKoneksiWeb.php";
        include "_Config/WebFunction.php";
        $url=urlServiceInline('Detail Event');
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
                        <a href="index.php?Page=WebEvent&Sub=EditEvent" class="h5">
                            <i class="ti ti-image"></i> Edit Album Event
                        </a>
                    </h5>
                    <p class="m-b-0">Edit informasi album event pada website</p>
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
                        <form action="javascript:void(0);" id="ProsesEditAlbumEvent">
                            <input type="hidden" id="id_web_event" name="id_web_event" value="<?php echo $id;?>">
                            <div class="card table-card">
                                <div class="card-header border-info">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <dt>Form Edit Album Event</dt>
                                        </div>
                                        <div class="col-md-2">
                                            <a href="index.php?Page=WebEvent" class="btn btn-sm btn-block btn-secondary">
                                                <i class="ti ti-angle-left"></i> Kembali
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="nama_event">Nama/Judul Event</label>
                                            <input type="text" name="nama_event" id="nama_event" class="form-control" value="<?php echo $nama_event;?>">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="kategori_event">Kategori</label>
                                            <input type="text" name="kategori_event" id="kategori_event" class="form-control" value="<?php echo $kategori_event;?>">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 mb-3">
                                            <label for="tanggal_event">Tanggal</label>
                                            <input type="date" name="tanggal_event" id="tanggal_event" class="form-control" value="<?php echo $tanggal;?>">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="jam_event">Jam</label>
                                            <input type="time" name="jam_event" id="jam_event" class="form-control" value="<?php echo $jam;?>">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="poster_event">Poster/Foto</label>
                                            <input type="file" name="poster_event" id="poster_event" class="form-control">
                                            <small>
                                                Kami menyarankan untuk menggunakan file foto dengan ukuran yang seragam.
                                            </small>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="deskripsi_event">Deskripsi Event</label>
                                            <textarea name="deskripsi_event" id="deskripsi_event" cols="30" rows="4" class="form-control"><?php echo $deskripsi_event;?></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col col-md-12 mb-3">
                                            <span class="text-primary" id="NotifikasiEditEvent">Pastikan semua data event sudah terisi dengan benar</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-md btn-primary" id="KlikProsesEditAlbumEvent">
                                        <i class="ti ti-save"></i> Simpan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php }}} ?>