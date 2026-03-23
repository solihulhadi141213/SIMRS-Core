<?php
    if(empty($_GET['id'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12">';
        echo '      <div class="card">';
        echo '          <div class="card-body">';
        echo '              <span class="text-danger">ID Laman Tidak Boleh Kosong!</span>';
        echo '          </div>';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_laman=$_GET['id'];
        include "_Config/Connection.php";
        include "_Config/SettingKoneksiWeb.php";
        include "_Config/WebFunction.php";
        $url=getServiceUrl('Detail Laman Mandiri');
        $KirimData = array(
            'api_key' => $api_key,
            'id_laman' => $id_laman
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
            echo '<div class="row">';
            echo '  <div class="col-md-12">';
            echo '      <div class="card">';
            echo '          <div class="card-body">';
            echo '              <span class="text-danger">'.$err.'</span>';
            echo '          </div>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
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
                echo '<div class="row">';
                echo '  <div class="col-md-12">';
                echo '      <div class="card">';
                echo '          <div class="card-body">';
                echo '              <span class="text-danger">'.$massage.'</span>';
                echo '          </div>';
                echo '      </div>';
                echo '  </div>';
                echo '</div>';
            }else{
                $id_laman=$JsonData['response']['id_laman'];
                $judul=$JsonData['response']['judul'];
                $tanggal=$JsonData['response']['tanggal'];
                $penulis=$JsonData['response']['penulis'];
                $isi_laman=$JsonData['response']['isi_laman'];
                //Format tanggal
                $strtotime=strtotime($tanggal);
                $Tanggal=date('Y-m-d',$strtotime);
                $Jam=date('H:i',$strtotime);
?>
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">
                            <a href="" class="h5"><i class="ti ti-pencil"></i> Edit Laman Mandiri</a>
                        </h5>
                        <p class="m-b-0">Ubah data laman mandiri</p>
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
                            <form action="javascript:void(0);" id="ProsesEditLamanMandiri">
                                <input type="hidden" id="id_laman" name="id_laman" value="<?php echo "$id_laman"; ?>">
                                <div class="card table-card">
                                    <div class="card-header border-info">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <dt>Form Tambah Artikel</dt>
                                            </div>
                                            <div class="col-md-2">
                                                <a href="index.php?Page=WebLaman" class="btn btn-sm btn-block btn-secondary">
                                                    <i class="ti ti-angle-left"></i> Kembali
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="penulis">Author</label>
                                                <input type="text" name="penulis" id="penulis" class="form-control" value="<?php echo "$penulis"; ?>">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="tanggal">Tanggal</label>
                                                <input type="date" name="tanggal" id="tanggal" class="form-control" value="<?php echo "$Tanggal"; ?>">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="jam">Jam</label>
                                                <input type="time" name="jam" id="jam" class="form-control" value="<?php echo "$Jam"; ?>">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label for="judul">Judul Laman</label>
                                                <input type="text" name="judul" id="judul" class="form-control" value="<?php echo "$judul"; ?>">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label for="isi_laman">Isi Laman</label>
                                                <textarea name="isi_laman" id="isi_laman" cols="30" rows="4" class="form-control"><?php echo "$isi_laman"; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col col-md-12 mb-3">
                                                <span class="text-primary" id="NotifikasiEditLaman">Pastikan semua data laman sudah terisi dengan benar</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-md btn-primary" id="KlikProsesEditLaman">
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