<?php
    if(empty($_POST['id_web_sitemap'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12">';
        echo '      <span class="text-danger">ID Sitemap Tidak Boleh Kosong!</span>';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_web_sitemap=$_POST['id_web_sitemap'];
        include "../../_Config/Connection.php";
        include "../../_Config/SettingKoneksiWeb.php";
        include "../../_Config/WebFunction.php";
        $url=getServiceUrl2('Detail Sitemap');
        $KirimData = array(
            'api_key' => $api_key,
            'id_web_sitemap' => $id_web_sitemap
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
                $id_web_sitemap=$JsonData['response']['id_web_sitemap'];
                $tanggal=$JsonData['response']['tanggal'];
                $url_site=$JsonData['response']['url_site'];
                $priority_site=$JsonData['response']['priority_site'];
                $label=$JsonData['response']['label'];
                $status=$JsonData['response']['status'];
?>
    <input type="hidden" id="id_web_sitemap" name="id_web_sitemap" value="<?php echo "$id_web_sitemap"; ?>">
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12 mb-3">
                <label for="url_site">URL</label>
                <input type="text" id="url_site" name="url_site" class="form-control" value="<?php echo "$url_site"; ?>">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3">
                <label for="label">Label</label>
                <input type="text" id="label" name="label" class="form-control" value="<?php echo "$label"; ?>">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="priority_site">Priority</label>
                <select name="priority_site" id="priority_site" class="form-control">
                    <option <?php if($priority_site=="0.0"){echo "selected";} ?> value="0.0">0.0</option>
                    <option <?php if($priority_site=="0.1"){echo "selected";} ?> value="0.1">0.1</option>
                    <option <?php if($priority_site=="0.2"){echo "selected";} ?> value="0.2">0.2</option>
                    <option <?php if($priority_site=="0.3"){echo "selected";} ?> value="0.3">0.3</option>
                    <option <?php if($priority_site=="0.4"){echo "selected";} ?> value="0.4">0.4</option>
                    <option <?php if($priority_site=="0.5"){echo "selected";} ?> value="0.5">0.5</option>
                    <option <?php if($priority_site=="0.6"){echo "selected";} ?> value="0.6">0.6</option>
                    <option <?php if($priority_site=="0.7"){echo "selected";} ?> value="0.7">0.7</option>
                    <option <?php if($priority_site=="0.8"){echo "selected";} ?> value="0.8">0.8</option>
                    <option <?php if($priority_site=="0.9"){echo "selected";} ?> value="0.9">0.9</option>
                    <option <?php if($priority_site=="1.0"){echo "selected";} ?> value="1.0">1.0</option>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label for="status">Status</label>
                <select name="status" id="status" class="form-control">
                    <option <?php if($status==""){echo "selected";} ?> value="">Pilih</option>
                    <option <?php if($status=="Draft"){echo "selected";} ?> value="Draft">Draft</option>
                    <option <?php if($status=="Publish"){echo "selected";} ?> value="Publish">Publish</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3" id="NotifikasiEditSitemap">
                <span class="text-primary">Pastikan bahwa data site map sudah terisi dengan lengkap</span>
            </div>
        </div>
    </div>
    <div class="modal-footer bg-success">
        <button type="submit" class="btn btn-md btn btn-primary">
            <i class="ti ti-save"></i> Simpan
        </button>
        <button type="button" class="btn btn-md btn btn-secondary" data-dismiss="modal">
            <i class="ti ti-close"></i> Tutup
        </button>
    </div>
<?php }}} ?>