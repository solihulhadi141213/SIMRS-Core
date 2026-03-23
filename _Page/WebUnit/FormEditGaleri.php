<?php
    if(empty($_POST['id_web_galeri'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12">';
        echo '      <span class="text-danger">ID Galeri Tidak Boleh Kosong!</span>';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_web_galeri=$_POST['id_web_galeri'];
        include "../../_Config/Connection.php";
        include "../../_Config/SettingKoneksiWeb.php";
        include "../../_Config/WebFunction.php";
        $url=getServiceUrl2('Detail Galeri');
        $KirimData = array(
            'api_key' => $api_key,
            'id_web_galeri' => $id_web_galeri
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
            echo '      <span class="text-danger">'.$err.'</span>';
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
                echo '      <span class="text-danger">'.$massage.'</span>';
                echo '  </div>';
                echo '</div>';
            }else{
                $id_web_galeri=$JsonData['response']['id_web_galeri'];
                $id_web_event=$JsonData['response']['id_web_event'];
                $id_unit_instalasi=$JsonData['response']['id_unit_instalasi'];
                $judul_galeri=$JsonData['response']['judul_galeri'];
                $deskripsi_galeri=$JsonData['response']['deskripsi_galeri'];
                $tanggal_galeri=$JsonData['response']['tanggal_galeri'];
                $tipe_file=$JsonData['response']['tipe_file'];
                $size_file=$JsonData['response']['size_file'];
                $name_file=$JsonData['response']['name_file'];
                $url_file=$JsonData['response']['url_file'];
?>
    <input type="hidden" id="id_web_galeri" name="id_web_galeri" value="<?php echo "$id_web_galeri";?>">
    <input type="hidden" id="id_web_event" name="id_web_event" value="<?php echo "$id_web_event";?>">
    <input type="hidden" id="id_unit_instalasi" name="id_unit_instalasi" value="<?php echo "$id_unit_instalasi";?>">
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12 mb-3">
                <label for="judul_galeri">Judul Galeri</label>
                <input type="text" id="judul_galeri" name="judul_galeri" class="form-control" value="<?php echo "$judul_galeri";?>">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3">
                <label for="deskripsi_galeri">Deskripsi Galeri</label>
                <textarea name="deskripsi_galeri" id="deskripsi_galeri" class="form-control" cols="30" rows="3"><?php echo "$deskripsi_galeri";?></textarea>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3">
                <label for="file_galeri">File Galeri</label>
                <input type="file" id="file_galeri" name="file_galeri" class="form-control">
                <small>Maksimal file 2 mb (jpg, jpeg, png & gif)</small>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3" id="NotifikasiEditGaleri">
                <small class="text-primary">Pastikan informasi galeri yang anda input sudah sesuai</small>
            </div>
        </div>
    </div>
    <div class="modal-footer bg-primary">
        <button type="submit" class="btn btn-md btn btn-success">
            <i class="ti ti-save"></i> Simpan
        </button>
        <button type="button" class="btn btn-md btn btn-secondary" data-dismiss="modal">
            <i class="ti ti-close"></i> Tutup
        </button>
    </div>
<?php }}} ?>