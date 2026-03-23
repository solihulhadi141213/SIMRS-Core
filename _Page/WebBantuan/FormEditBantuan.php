<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">
                        <a href="" class="h5"><i class="ti-help"></i> Edit Bantuan</a>
                    </h5>
                    <p class="m-b-0">Edit data bantuan yang akan ditampilkan di halaman Web</p>
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
                                echo '      ID Bantuan Tidak Boleh Kosong!';
                                echo '  </div>';
                                echo '</d>';
                            }else{
                                $id_bantuan=$_GET['id'];
                                //Menampilkan data
                                include "_Config/SettingKoneksiWeb.php";
                                include "_Config/WebFunction.php";
                                $url=urlService('Detail Bantuan');
                                //Akses Data Dari Server Website
                                $KirimData = array(
                                    'api_key' => $api_key,
                                    'id_bantuan' => $id_bantuan,
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
                                        $id_bantuan=$response['id_bantuan'];
                                        $judul=$response['judul'];
                                        $kategori=$response['kategori'];
                                        $deskripsi=$response['deskripsi'];
                                        $tanggal=$response['tanggal'];
                                        //Explode jam
                                        $Explode = explode(" " , $tanggal);
                                        $Tanggal=$Explode[0];
                                        $Jam=$Explode[1];
                        ?>
                        <form action="javascript:void(0);" id="ProsesEditBantuan" autocomplete="off">
                            <input type="hidden" id="id_bantuan" name="id_bantuan" value="<?php echo "$id_bantuan"; ?>">
                            <div class="card table-card">
                                <div class="card-header border-info">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <dt>Form Edit Bantuan</dt>
                                        </div>
                                        <div class="col-md-2">
                                            <a href="index.php?Page=WebBantuan" class="btn btn-sm btn-block btn-secondary">
                                                <i class="ti ti-angle-left"></i> Kembali
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3 mb-3">
                                            <label for="tanggal">Tanggal Bantuan</label>
                                            <input type="date" name="tanggal" id="tanggal" class="form-control" value="<?php echo "$Tanggal"; ?>">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="jam">Jam Bantuan</label>
                                            <input type="time" name="jam" id="jam" class="form-control" value="<?php echo "$Jam"; ?>">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="kategori">Kategori Bantuan</label>
                                            <input type="text" name="kategori" id="kategori" list="list_kategori" class="form-control" value="<?php echo "$kategori"; ?>">
                                            <datalist id="list_kategori">
                                                <?php
                                                    $url=urlServiceInline('Info Bantuan');
                                                    $KirimData = array(
                                                        'api_key' => $api_key,
                                                        'keyword_by' => "id_bantuan",
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
                                                            $Kolom=count($JsonData['response']['list_kategori']);
                                                            if(!empty($Kolom)){
                                                                $GetKolom=$JsonData['response']['list_kategori'];
                                                                foreach ($GetKolom as $value){
                                                                    echo '<option value="'.$value['kategori'].'">';
                                                                }
                                                            }
                                                        }else{
                                                            echo '<option>'.$massage.'</option>';
                                                        }
                                                    }
                                                ?>
                                            </datalist>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="judul">Judul Bantuan</label>
                                            <input type="text" name="judul" id="judul" class="form-control" value="<?php echo "$judul"; ?>">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="deskripsi">Deskripsi Bantuan</label>
                                            <textarea name="deskripsi" id="deskripsi" cols="30" rows="4" class="form-control"><?php echo "$deskripsi"; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col col-md-12 mb-3">
                                            <span class="text-primary" id="NotifikasiEditBantuan">Pastikan semua data bantuan sudah terisi dengan benar</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-md btn-primary" id="KlikProsesEditBantuan">
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