<?php
    include "_Config/SettingKoneksiWeb.php";
    include "_Config/WebFunction.php";
    $url=urlServiceInline('Info Email Gateway');
    $KirimData = array(
        'api_key' => $api_key
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
        $id_setting_email_gateway="";
        $email_gateway="";
        $password_gateway="";
        $url_provider="";
        $port_gateway="";
        $nama_pengirim="";
        $url_service="";
        $validasi_email="";
        $redirect_validasi="";
        $pesan_validasi_email="";
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
            $id_setting_email_gateway="";
            $email_gateway="";
            $password_gateway="";
            $url_provider="";
            $port_gateway="";
            $nama_pengirim="";
            $url_service="";
            $validasi_email="";
            $redirect_validasi="";
            $pesan_validasi_email="";
        }else{
            $id_setting_email_gateway=$JsonData['response']['id_setting_email_gateway'];
            $email_gateway=$JsonData['response']['email_gateway'];
            $password_gateway=$JsonData['response']['password_gateway'];
            $url_provider=$JsonData['response']['url_provider'];
            $port_gateway=$JsonData['response']['port_gateway'];
            $nama_pengirim=$JsonData['response']['nama_pengirim'];
            $url_service=$JsonData['response']['url_service'];
            $validasi_email=$JsonData['response']['validasi_email'];
            $redirect_validasi=$JsonData['response']['redirect_validasi'];
            $pesan_validasi_email=$JsonData['response']['pesan_validasi_email'];
        }
    }
?>

<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">
                        <a href="" class="h5">
                            <i class="ti ti-email"></i> Email Gateway
                        </a>
                    </h5>
                    <p class="m-b-0">Atur koneksi dengan email gateway</p>
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
                        <form action="javascript:void(0);" id="ProsesUpdateEmailGateway">
                            <input type="hidden" name="id_setting_email_gateway" id="id_setting_email_gateway" value="<?php echo "$id_setting_email_gateway"; ?>">
                            <div class="card table-card">
                                <div class="card-header border-info">
                                    <div class="row">
                                        <div class="col col-md-9 mb-3">
                                            <dt class="card-title">Form Setting Email Gateway</dt>
                                        </div>
                                        <div class="col col-md-3 mb-3">
                                            <button type="button" class="btn btn-md btn-dark btn-block" data-toggle="modal" data-target="#ModalKirimEmail">
                                                <i class="ti ti-arrow-circle-up"></i> Coba Kirim Email
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label for="email_gateway"><dt>Email Gateway</dt></label>
                                        </div>
                                        <div class="col-md-9 mb-3">
                                            <input type="text" id="email_gateway" name="email_gateway" class="form-control" value="<?php echo "$email_gateway";?>">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label for="password_gateway"><dt>Password</dt></label>
                                        </div>
                                        <div class="col-md-9 mb-3">
                                            <input type="text" id="password_gateway" name="password_gateway" class="form-control" value="<?php echo "$password_gateway";?>">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label for="url_provider"><dt>URL Provider</dt></label>
                                        </div>
                                        <div class="col-md-9 mb-3">
                                            <input type="text" id="url_provider" name="url_provider" class="form-control" value="<?php echo "$url_provider";?>">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label for="port_gateway"><dt>Port Gateway</dt></label>
                                        </div>
                                        <div class="col-md-9 mb-3">
                                            <input type="text" id="port_gateway" name="port_gateway" class="form-control" value="<?php echo "$port_gateway";?>">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label for="nama_pengirim"><dt>Set Nama Pengirim</dt></label>
                                        </div>
                                        <div class="col-md-9 mb-3">
                                            <input type="text" id="nama_pengirim" name="nama_pengirim" class="form-control" value="<?php echo "$nama_pengirim";?>">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label for="url_service"><dt>URL Service</dt></label>
                                        </div>
                                        <div class="col-md-9 mb-3">
                                            <input type="text" id="url_service" name="url_service" class="form-control" value="<?php echo "$url_service";?>">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label for="validasi_email"><dt>Validasi Email</dt></label>
                                        </div>
                                        <div class="col-md-9 mb-3">
                                            <select name="validasi_email" id="validasi_email" class="form-control">
                                                <option <?php if($validasi_email==""){echo "selected";} ?> value=""></option>
                                                <option <?php if($validasi_email=="Yes"){echo "selected";} ?> value="Yes">Yes</option>
                                                <option <?php if($validasi_email=="No"){echo "selected";} ?> value="No">No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label for="redirect_validasi"><dt>Redirect</dt></label>
                                        </div>
                                        <div class="col-md-9 mb-3">
                                            <input type="text" id="redirect_validasi" name="redirect_validasi" class="form-control" value="<?php echo "$redirect_validasi";?>">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label for="pesan_validasi_email"><dt>Pesan Validasi</dt></label>
                                        </div>
                                        <div class="col-md-9 mb-3">
                                            <input type="text" id="pesan_validasi_email" name="pesan_validasi_email" class="form-control" value="<?php echo "$pesan_validasi_email";?>">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-12" id="NotifikasiUpdateEmailGateway">
                                            <span class="text-primary">Pastikan parameter pengaturan sudah benar</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-md btn-primary">
                                        <i class="ti ti-save"></i> Simpan Setting
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