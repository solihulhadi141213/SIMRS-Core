<?php
    //Mengambil data sambutan dari service
    date_default_timezone_set('Asia/Jakarta');
    include "_Config/SettingKoneksiWeb.php";
    include "_Config/WebFunction.php";
    $UrlSambutan=getServiceUrl("Detail Sambutan");
    $UrlSimpanSambutan=getServiceUrl("Simpan Sambutan");
    //Menentukan url dari setting
    if(!empty($api_key)&&!empty($UrlSambutan)){
        //Akses Data Dari Server Website
        $KirimData = array(
            'api_key' => $api_key,
        );
        $json = json_encode($KirimData);
        //Mulai CURL
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, "$UrlSambutan");
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
            $massage="$err";
            $code="";
            $id_web_sambutan="";
            $judul_sambutan="";
            $nama="";
            $jabatan="";
            $isi_sambutan="";
            $foto="";
            $last_update="";
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
            if(!empty($JsonData['response']['id_web_sambutan'])){
                $id_web_sambutan=$JsonData['response']['id_web_sambutan'];
            }else{
                $id_web_sambutan="";
            }
            if(!empty($JsonData['response']['judul_sambutan'])){
                $judul_sambutan=$JsonData['response']['judul_sambutan'];
            }else{
                $judul_sambutan="";
            }
            if(!empty($JsonData['response']['nama'])){
                $nama=$JsonData['response']['nama'];
            }else{
                $nama="";
            }
            if(!empty($JsonData['response']['jabatan'])){
                $jabatan=$JsonData['response']['jabatan'];
            }else{
                $jabatan="";
            }
            if(!empty($JsonData['response']['isi_sambutan'])){
                $isi_sambutan=$JsonData['response']['isi_sambutan'];
            }else{
                $isi_sambutan="";
            }
            if(!empty($JsonData['response']['foto'])){
                $foto=$JsonData['response']['foto'];
            }else{
                $foto="";
            }
            if(!empty($JsonData['response']['last_update'])){
                $last_update=$JsonData['response']['last_update'];
            }else{
                $last_update="";
            }
        }
    }else{
        $massage="$err";
        $code="";
        $id_web_sambutan="";
        $judul_sambutan="";
        $nama="";
        $jabatan="";
        $isi_sambutan="";
        $foto="";
        $last_update="";
    }
?>
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">
                        <a href="" class="h5"><i class="ti ti-notepad"></i> Sambutan Direktur</a>
                    </h5>
                    <p class="m-b-0">Kelola Sambutan Direktur Pada Website</p>
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
                        <form action="javascript:void(0);" id="BatasPencarian">
                            <div class="card table-card">
                                <div class="card-header border-info">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <dt>Form Sambutan Direktur</dt>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="nama">Nama Direktur</label>
                                            <input type="text" class="form-control" name="nama" id="nama" value="<?php echo "$nama"; ?>">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="nama">Label Jabatan</label>
                                            <input type="text" class="form-control" name="jabatan" id="jabatan" value="<?php echo "$jabatan"; ?>">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="judul_sambutan">Judul Sambutan</label>
                                            <input type="text" class="form-control" name="judul_sambutan" id="judul_sambutan" value="<?php echo "$judul_sambutan"; ?>">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="isi_sambutan">Isi Sambutan</label>
                                            <textarea name="isi_sambutan" id="isi_sambutan" cols="30" rows="3" class="form-control"><?php echo "$isi_sambutan"; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3" id="NotifikasiSimpanSambutan">
                                            <span class="test-primary">Pastikan data sambutan yang anda input sudah sesuai</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-md btn-primary" id="SimpanSambutan">
                                        <i class="ti ti-save"></i> Simpan
                                    </button>
                                    <button type="button" class="btn btn-md btn-info" data-toggle="modal" data-target="#ModalLihatFoto">
                                        <i class="ti ti-image"></i> Ubah Foto
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div id="styleSelector">

        </div>
    </div>
</div>