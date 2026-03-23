<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">
                        <a href="index.php?Page=Akses" class="h5"><i class="ti ti-text"></i> Artikel</a>
                    </h5>
                    <p class="m-b-0">Kelola data Artikel halaman website</p>
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
                                echo '      ID Artikel Tidak Boleh Kosong!';
                                echo '  </div>';
                                echo '</d>';
                            }else{
                                $id_web_artikel=$_GET['id'];
                                //Menampilkan data
                                include "_Config/SettingKoneksiWeb.php";
                                include "_Config/WebFunction.php";
                                $url=urlService('Detail Artikel');
                                //Akses Data Dari Server Website
                                $KirimData = array(
                                    'api_key' => $api_key,
                                    'id_web_artikel' => $id_web_artikel,
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
                                        $id_web_artikel=$response['id_web_artikel'];
                                        $artikel_judul=$response['artikel_judul'];
                                        $artikel_tanggal=$response['artikel_tanggal'];
                                        //Explode jam
                                        $Explode = explode(" " , $artikel_tanggal);
                                        $Tanggal=$Explode[0];
                                        if(!empty($Explode[1])){
                                            $Jam=$Explode[1];
                                        }else{
                                            $Jam="";
                                        }
                                        
                                        $artikel_penulis=$response['artikel_penulis'];
                                        $artikel_kategori=$response['artikel_kategori'];
                                        $artikel_ringkasan=$response['artikel_ringkasan'];
                                        $artikel_isi=$response['artikel_isi'];
                                        $artikel_status=$response['artikel_status'];
                        ?>
                            <form action="javascript:void(0);" id="ProsesEditArtikel">
                                <input type="hidden" name="id_web_artikel" id="id_web_artikel" class="form-control" value="<?php echo "$id_web_artikel"; ?>">
                                <div class="card table-card">
                                    <div class="card-header border-info">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <dt>Form Edit Artikel</dt>
                                            </div>
                                            <div class="col-md-2">
                                                <a href="ijavascript:void(0);" class="btn btn-sm btn-block btn-success" id="MulaiEditArtikel">
                                                    <i class="ti ti-pencil"></i> Mulai Edit
                                                </a>
                                            </div>
                                            <div class="col-md-2">
                                                <a href="index.php?Page=WebArtikel" class="btn btn-sm btn-block btn-secondary">
                                                    <i class="ti ti-angle-left"></i> Kembali
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="artikel_judul">Judul Artikel</label>
                                                <input type="text" readonly name="artikel_judul" id="artikel_judul" class="form-control" value="<?php echo "$artikel_judul"; ?>">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="artikel_kategori">Kategori</label>
                                                <input type="text" readonly name="artikel_kategori" id="artikel_kategori" class="form-control" value="<?php echo "$artikel_kategori"; ?>">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="artikel_tanggal">Tanggal</label>
                                                <input type="date" readonly name="artikel_tanggal" id="artikel_tanggal" class="form-control" value="<?php echo "$Tanggal"; ?>">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="artikel_jam">Jam</label>
                                                <input type="time" readonly name="artikel_jam" id="artikel_jam" class="form-control" value="<?php echo "$Jam"; ?>">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="artikel_penulis">Author</label>
                                                <input type="text" readonly name="artikel_penulis" id="artikel_penulis" class="form-control" value="<?php echo "$artikel_penulis"; ?>">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label for="artikel_ringkasan">Ringkasan</label>
                                                <input type="text" readonly name="artikel_ringkasan" id="artikel_ringkasan" class="form-control" value="<?php echo "$artikel_ringkasan"; ?>">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label>
                                                    <a href="javascipt:void(0);" data-toggle="modal" data-target="#ModalEditArtikel">Isi Artikel</a>
                                                </label>
                                                <div name="artikel_isi_edit" id="artikel_isi_edit">
                                                    <?php echo "$artikel_isi"; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label for="artikel_status">Status Artikel</label>
                                                <select name="artikel_status" disabled id="artikel_status" class="form-control">
                                                    <option <?php if($artikel_status=="Draft"){echo "selected";} ?> value="Draft">Draft</option>
                                                    <option <?php if($artikel_status=="Publish"){echo "selected";} ?> value="Publish">Publish</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col col-md-12 mb-3">
                                                <span class="text-primary" id="NotifikasiEditArtikel">Pastikan semua data Artikel sudah terisi dengan benar</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-md btn-primary" id="KlikProsesEditArtikel">
                                            <i class="ti ti-save"></i> Simpan
                                        </button>
                                    </div>
                                </div>
                            </form>
                        <?php
                                }
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>