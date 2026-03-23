<?php
    date_default_timezone_set('Asia/Jakarta');
    include "_Config\SettingKoneksiWeb.php";
    include "_Config\WebFunction.php";
    
    // $url_update_info=getServiceUrl("Update Informasi Website");
    $QryApiKey = mysqli_query($Conn,"SELECT * FROM setting_web ORDER BY id_setting_web DESC")or die(mysqli_error($Conn));
    $DataApiKey = mysqli_fetch_array($QryApiKey);
    $id_setting_web= $DataApiKey['id_setting_web'];
    $api_key= $DataApiKey['api_key'];
    $base_url_service= $DataApiKey['base_url_service'];
    $updatetime= $DataApiKey['last_update'];
    
    $QryService = mysqli_query($Conn,"SELECT * FROM setting_service WHERE service_name='Tampilkan Informasi Website'")or die(mysqli_error($Conn));
    $DataService = mysqli_fetch_array($QryService);
    if(!empty($DataService['url_service'])){
        $url_web_info= $DataService['url_service'];
    }else{
        $url_web_info="";
    }
    $KirimData = array(
        'api_key' => "$api_key"
    );
    $json = json_encode($KirimData);
    //Mulai CURL
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL, "$url_web_info");
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
        $ResponseInfo="Koneksi Error";
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
            $web_title="";
            $web_deskripsi="";
            $web_keywords="";
            $web_author="";
            $web_kontak="";
            $web_email="";
            $web_alamat="";
            $web_favicon="";
            $web_waktu_operasional="";
            $web_baseurl="";
            $copyright_text="";
            $copyright_url="";
        }else{
            $web_title=$JsonData['response']['web_title'];
            $web_deskripsi=$JsonData['response']['web_deskripsi'];
            $web_keywords=$JsonData['response']['web_keywords'];
            $web_author=$JsonData['response']['web_author'];
            $web_kontak=$JsonData['response']['web_kontak'];
            $web_email=$JsonData['response']['web_email'];
            $web_alamat=$JsonData['response']['web_alamat'];
            $web_favicon=$JsonData['response']['web_favicon'];
            $web_waktu_operasional=$JsonData['response']['web_waktu_operasional'];
            $web_baseurl=$JsonData['response']['web_baseurl'];
            $copyright_text=$JsonData['response']['copyright_text'];
            $copyright_url=$JsonData['response']['copyright_url'];
        }
    }
?>
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="page-header-title">
                    <h5 class="m-b-12">
                        <i class="ti ti-settings"></i> Setting Website
                    </h5>
                    <p class="m-b-0">Setting Koneksi CMS ke server Website Dan Kelola Pengaturan Halaman</p>
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
                    <div class="col-md-12 mb-3">
                        <div class="card">
                            <div class="card-header border-info">
                                <div class="row">
                                    <div class="col-md-10">
                                        <dt class="text-dark">1. Pengaturan APi Key Dan URL Website</dt>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-md btn-block btn-secondary" data-toggle="modal" data-target="#ModalSettingApiKey">
                                            <i class="ti ti-key"></i> Setting API Key
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label text-dark"><dt>User Key</dt></label>
                                    <div class="col-sm-10">
                                        <?php echo "$api_key"; ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label text-dark"><dt>Access Key</dt></label>
                                    <div class="col-sm-10">
                                        <?php echo "$api_key"; ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label text-dark"><dt>Base URL (Website)</dt></label>
                                    <div class="col-sm-10">
                                        <?php echo "$base_url_service"; ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label text-dark"><dt>Last Update</dt></label>
                                    <div class="col-sm-10">
                                        <?php echo "$last_update_setting"; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12 col-md-12">
                        <div class="card">
                            <div class="card-header border-info">
                                <div class="row">
                                    <div class="col-md-3 mt-3">
                                        <dt class="text-dark">2. Koneksi (CMS) Web Service</dt>
                                    </div>
                                    <div class="col-md-2 mt-3">
                                        <select name="BatasData" id="BatasData" class="form-control">
                                            <option value="5">5</option>
                                            <option selected value="10">10</option>
                                            <option value="25">25</option>
                                            <option value="50">50</option>
                                            <option value="100">100</option>
                                            <option value="250">250</option>
                                            <option value="500">500</option>
                                        </select>
                                        <small>Batas</small>
                                    </div>
                                    <div class="col-md-3 mt-3">
                                        <select name="kategori_service" id="kategori_service" class="form-control">
                                            <option value="">Semua Kategori</option>
                                            <?php
                                                $QryKategoriService = mysqli_query($Conn, "SELECT DISTINCT service_category FROM setting_service ORDER BY service_category ASC");
                                                while ($DataKategoriService = mysqli_fetch_array($QryKategoriService)) {
                                                    $service_category= $DataKategoriService['service_category'];
                                                    echo '<option value="'.$service_category.'">'.$service_category.'</option>';
                                                }
                                            ?>
                                        </select>
                                        <small>Kategori Service</small>
                                    </div>
                                    <div class="col-md-2 mt-3">
                                        <button type="button" class="btn btn-md btn-block btn-secondary" data-toggle="modal" data-target="#ModalTambahServiceWeb">
                                            <i class="ti ti-plus"></i> Buat Service
                                        </button>
                                    </div>
                                    <div class="col-md-2 mt-3">
                                        <button type="button" class="btn btn-md btn-block btn-secondary" data-toggle="modal" data-target="#ModalReplace">
                                            <i class="ti ti-pencil-alt"></i> Replice
                                        </button>
                                    </div>
                                </div>
                                
                            </div>
                            <div id="TabelService">
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12 col-md-12">
                        <div class="card">
                            <form action="javascript:void(0);" method="POST" id="ProsesSettingWebsite">
                                <div class="card-header border-info">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <dt class="text-dark">3. Pengaturan Personalisasi Website</dt>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label text-dark">Judul Websiite</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="web_title" id="web_title" value="<?php echo $web_title;  ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label text-dark">Deskripsi</label>
                                        <div class="col-sm-10">
                                            <textarea name="web_deskripsi" id="web_deskripsi" cols="30" rows="3" class="form-control"><?php echo "$web_deskripsi";?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label text-dark">Keyword</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="web_keywords" id="web_keywords" value="<?php echo "$web_keywords";?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label text-dark">Author</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="web_author" id="web_author" value="<?php echo "$web_author";?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label text-dark">Info Kontak</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="web_kontak" id="web_kontak" value="<?php echo "$web_kontak";?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label text-dark">Info Email</label>
                                        <div class="col-sm-10">
                                            <input type="email" class="form-control" name="web_email" id="web_email" value="<?php echo "$web_email";?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label text-dark">Info Alamat</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="web_alamat" id="web_alamat" value="<?php echo "$web_alamat";?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label text-dark">Logo Website</label>
                                        <div class="col-sm-10">
                                            <input type="file" class="form-control" name="web_favicon" id="web_favicon">
                                            <small>
                                                <?php
                                                    if(!empty($web_favicon)){
                                                        echo '<a href="'.$web_favicon.'" target="_blank" class="text-success">';
                                                        echo '  Lihat Favicon';
                                                        echo '</a>';
                                                    }else{
                                                        echo "Belum Ada Favicon";
                                                    }
                                                ?>
                                            </small>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label text-dark">Waktu Operasional</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="web_waktu_operasional" id="web_waktu_operasional" value="<?php echo "$web_waktu_operasional";?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label text-dark">Base URL Website</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="web_baseurl" id="web_baseurl" value="<?php echo "$web_baseurl";?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label text-dark">Copyright Text</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="copyright_text" id="copyright_text" value="<?php echo "$copyright_text";?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label text-dark">Copyright URL</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="copyright_url" id="copyright_url" value="<?php echo "$copyright_url";?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label text-dark"></label>
                                        <div class="col-sm-10">
                                            <span class="text-primary" id="NotifikasiSettingWebsite">
                                                Pastikan pengaturan web sudah benar.
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <div class="btn-group">
                                                <button type="submit" class="btn btn-md btn-primary">
                                                    <i class="ti-save"></i> Simpan
                                                </button>
                                                <button type="reset" class="btn btn-md btn-info">
                                                    <i class="ti-reload"></i> Reset
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="styleSelector">

        </div>
    </div>
</div>