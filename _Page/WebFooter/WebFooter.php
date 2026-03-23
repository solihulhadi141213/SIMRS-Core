<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">
                        <a href="" class="h5"><i class="ti-list"></i> Footer Menu</a>
                    </h5>
                    <p class="m-b-0">Kelola data footer menu pada website</p>
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
                                        <div class="col-md-8 mb-3">
                                            <select name="GetKategori" id="GetKategori" class="form-control">
                                                <option value="">Semua</option>
                                                <?php
                                                    include "_Config/SettingKoneksiWeb.php";
                                                    include "_Config/WebFunction.php";
                                                    $url=urlServiceInline('List Kategori');
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
                                                            $List=count($JsonData['response']['list']);
                                                            if(!empty($List)){
                                                                $GetListKategori=$JsonData['response']['list'];
                                                                foreach ($GetListKategori as $value){
                                                                    $Kategori=$value['kategori'];
                                                                    echo '<option value="'.$Kategori.'">'.$Kategori.'</option>';
                                                                }
                                                            }
                                                        }else{
                                                            echo '<option>'.$massage.'</option>';
                                                        }
                                                    }
                                                ?>
                                            </select>
                                            <small>Kategori</small>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <a href="javascript:void(0);" class="btn btn-md btn-block btn-primary" data-toggle="modal" data-target="#ModalTambahFooterMenu">
                                                <i class="ti-plus text-white"></i> Tambah Footer Menu
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div id="TabelFooterMenu">
                                <!--  menampilkan data Sitemap disini -->
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