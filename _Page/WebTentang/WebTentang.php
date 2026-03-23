<?php
    date_default_timezone_set('Asia/Jakarta');
    include "_Config/SettingKoneksiWeb.php";
    include "_Config/WebFunction.php";
    $url_tentang=getServiceUrl("Informasi Tentang RS");
    $url_update_tentang=getServiceUrl("Update Tentang RS");
    //Menentukan url dari setting
    if(!empty($api_key)&&!empty($url_tentang)){
        //Akses Data Dari Server Website
        $KirimData = array(
            'api_key' => $api_key,
        );
        $json = json_encode($KirimData);
        //Mulai CURL
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, "$url_tentang");
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
            $web_sejarah="";
            $web_visi="";
            $web_misi="";
            $web_lokasi="";
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
            if(!empty($JsonData['response']['web_sejarah'])){
                $web_sejarah=$JsonData['response']['web_sejarah'];
            }else{
                $web_sejarah="";
            }
            if(!empty($JsonData['response']['web_visi'])){
                $web_visi=$JsonData['response']['web_visi'];
            }else{
                $web_visi="";
            }
            if(!empty($JsonData['response']['web_misi'])){
                $web_misi=$JsonData['response']['web_misi'];
            }else{
                $web_misi="";
            }
            if(!empty($JsonData['response']['web_lokasi'])){
                $web_lokasi=$JsonData['response']['web_lokasi'];
            }else{
                $web_lokasi="";
            }
        }
    }else{
        $massage="$err";
        $code="";
        $web_sejarah="";
        $web_visi="";
        $web_misi="";
        $web_lokasi="";
    }
?>
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="page-header-title">
                    <h5 class="m-b-12">
                        <i class="ti ti-info-alt"></i> Tentang
                    </h5>
                    <p class="m-b-0">Kelola kontent tentang (Sejarah, Google map embed code, Visi dan Misi) pada website</p>
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
                        <div class="card">
                            <div class="card-header border-info">
                                <div class="row">
                                    <div class="col-md-10">
                                        <dt class="text-dark">Sejarah Rumah Sakit</dt>
                                        <small>Koneksi : <?php echo "$massage"; ?></small><br>
                                    </div>
                                    <div class="col-md-2" id="TombolEditSejarah">
                                        <button type="button" class="btn btn-sm btn-outline-success btn-block" id="EditSejarah">
                                            <i class="ti ti-pencil-alt"></i> Edit
                                        </button>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12" >
                                        <div class="content" id="web_sejarah"></div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12" id="NotifikasiUpdateSejarah">
                                        <!-- Notifikasi Proses Disini -->
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer" id="TombolSubmitSejarah">
                                <!-- Tombol Simpan Disini -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12 col-md-12">
                        <div class="card">
                            <div class="card-header border-info">
                                <div class="row">
                                    <div class="col-md-10">
                                        <dt class="text-dark">Visi Rumah Sakit</dt>
                                        <small>Koneksi : <?php echo "$massage"; ?></small>
                                    </div>
                                    <div class="col-md-2" id="TombolEditVisi">
                                        <button type="button" class="btn btn-sm btn-outline-success btn-block" id="EditVisi">
                                            <i class="ti ti-pencil-alt"></i> Edit
                                        </button>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12" >
                                        <div class="content" id="web_visi"></div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12" id="NotifikasiUpdateVisi">
                                        <!-- Notifikasi Proses Disini -->
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer" id="TombolSubmitVisi">
                                <!-- Tombol Simpan Disini -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12 col-md-12">
                        <div class="card">
                            <div class="card-header border-info">
                                <div class="row">
                                    <div class="col-md-10">
                                        <dt class="text-dark">Misi Rumah Sakit</dt>
                                        <small>Koneksi : <?php echo "$massage"; ?></small>
                                    </div>
                                    <div class="col-md-2" id="TombolEditMisi">
                                        <button type="button" class="btn btn-sm btn-outline-success btn-block" id="EditMisi">
                                            <i class="ti ti-pencil-alt"></i> Edit
                                        </button>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12" >
                                        <div class="content" id="web_misi"></div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12" id="NotifikasiUpdateMisi">
                                        <!-- Notifikasi Proses Disini -->
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer" id="TombolSubmitMisi">
                                <!-- Tombol Simpan Disini -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12 col-md-12">
                        <div class="card">
                            <div class="card-header border-info">
                                <div class="row">
                                    <div class="col-md-10">
                                        <dt class="text-dark">Lokasi Rumah Sakit</dt>
                                        <small>Koneksi : <?php echo "$massage"; ?></small>
                                    </div>
                                    <div class="col-md-2" id="TombolEditLokasi">
                                        <button type="button" class="btn btn-sm btn-outline-success btn-block" id="EditLokasi">
                                            <i class="ti ti-pencil-alt"></i> Edit
                                        </button>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12" >
                                        <div class="content" id="web_lokasi"></div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12" id="NotifikasiUpdateLokasi">
                                        <!-- Notifikasi Proses Disini -->
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer" id="TombolSubmitLokasi">
                                <!-- Tombol Simpan Disini -->
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