<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">
                        <a href="" class="h5"><i class="ti ti-comment"></i> Testimoni</a>
                    </h5>
                    <p class="m-b-0">Kelola dan Tampilkan Testimoni Dari Pengunjung Website</p>
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
                                <form action="javascript:void(0);" id="BatasPencarian">
                                    <div class="row">
                                        <div class="col-md-2 mb-3">
                                            <select name="batas" id="batas" class="form-control">
                                                <option value="5">5</option>
                                                <option selected value="10">10</option>
                                                <option value="25">25</option>
                                                <option value="50">50</option>
                                                <option value="100">100</option>
                                            </select>
                                            <small>Batas</small>
                                        </div>
                                        <div class="col-md-3  mb-3">
                                            <select name="keyword_by" id="keyword_by" class="form-control">
                                                <option value="">Semua</option>
                                                <?php
                                                    include "_Config/SettingKoneksiWeb.php";
                                                    include "_Config/WebFunction.php";
                                                    $url=urlServiceInline('Info Testimoni');
                                                    $KirimData = array(
                                                        'api_key' => $api_key,
                                                        'keyword_by' => "",
                                                        'keyword' => "",
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
                                                        $jumlah_Artikel="0";
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
                                                        if($code==200){
                                                            $Kolom=count($JsonData['response']['kolom']);
                                                            if(!empty($Kolom)){
                                                                $GetKolom=$JsonData['response']['kolom'];
                                                                foreach ($GetKolom as $value){
                                                                    $nama_kolom=$value['nama_kolom'];
                                                                    if($nama_kolom=="tanggal_testimoni"){
                                                                        $NamaEvent="Tanggal";
                                                                        echo '<option value="'.$nama_kolom.'">'.$NamaEvent.'</option>';
                                                                    }else{
                                                                        if($nama_kolom=="nama_testimoni"){
                                                                            $NamaEvent="Nama Pengirim";
                                                                            echo '<option value="'.$nama_kolom.'">'.$NamaEvent.'</option>';
                                                                        }else{
                                                                            if($nama_kolom=="email"){
                                                                                $NamaEvent="Email";
                                                                                echo '<option value="'.$nama_kolom.'">'.$NamaEvent.'</option>';
                                                                            }else{
                                                                                if($nama_kolom=="status_testimoni"){
                                                                                    $NamaEvent="Status";
                                                                                    echo '<option value="'.$nama_kolom.'">'.$NamaEvent.'</option>';
                                                                                }else{
                                                                                    // echo '<option value="'.$nama_kolom.'">'.$nama_kolom.'</option>';
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                    
                                                                }
                                                            }
                                                        }else{
                                                            echo '<option>'.$massage.'</option>';
                                                        }
                                                    }
                                                ?>
                                            </select>
                                            <small>Pencarian</small>
                                        </div>
                                        <div class="col-md-3  mb-3" id="FormKeyword">
                                            <input type="text" class="form-control" name="keyword" id="keyword" placeholder="Kata Kunci">
                                            <small>Kata Kunci</small>
                                        </div>
                                        <div class="col-md-2  mb-3">
                                            <button type="submit" class="btn btn-sm btn-block btn-secondary">
                                                <i class="ti-search"></i> Mulai Pencarian
                                            </button>
                                        </div>
                                        <div class="col-md-2  mb-3">
                                            <a href="javascript:void(0);" class="btn btn-sm btn-block btn-primary" data-toggle="modal" data-target="#ModalTambahTestimoni">
                                                <i class="ti-plus text-white"></i> Tambah Manual
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div id="TabelTestimoni">
                                <!--  menampilkan data testimoni disini -->
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