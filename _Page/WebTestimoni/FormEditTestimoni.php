<?php
    if(empty($_POST['id_web_testimoni'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12">';
        echo '      <span class="text-danger">ID Galeri Tidak Boleh Kosong!</span>';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_web_testimoni=$_POST['id_web_testimoni'];
        include "../../_Config/Connection.php";
        include "../../_Config/SettingKoneksiWeb.php";
        include "../../_Config/WebFunction.php";
        $url=getServiceUrl2('Detail Testimoni');
        $KirimData = array(
            'api_key' => $api_key,
            'id_web_testimoni' => $id_web_testimoni
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
                $id_web_testimoni=$JsonData['response']['id_web_testimoni'];
                $tanggal_testimoni=$JsonData['response']['tanggal_testimoni'];
                $nama_testimoni=$JsonData['response']['nama_testimoni'];
                $email=$JsonData['response']['email'];
                $isi_testimoni=$JsonData['response']['isi_testimoni'];
                $image_testimoni=$JsonData['response']['image_testimoni'];
                $status_testimoni=$JsonData['response']['status_testimoni'];
                //Explode tanggal
                $Explode = explode(" ", $tanggal_testimoni);
                $tanggal=$Explode[0];
                $jam=$Explode[1];
?>
    <input type="hidden" name="id_web_testimoni" id="id_web_testimoni" value="<?php echo "$id_web_testimoni";?>">
    <div class="modal-body">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="tanggal">Tanggal</label>
                <input type="date" id="tanggal" name="tanggal" class="form-control" value="<?php echo "$tanggal";?>">
            </div>
            <div class="col-md-6 mb-3">
                <label for="jam">Jam</label>
                <input type="time" id="jam" name="jam" class="form-control" value="<?php echo "$jam";?>">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="nama_testimoni">Nama Pengirim</label>
                <input type="text" id="nama_testimoni" name="nama_testimoni" class="form-control" value="<?php echo "$nama_testimoni";?>">
            </div>
            <div class="col-md-6 mb-3">
                <label for="email">Email Pengirim</label>
                <input type="email" id="email" name="email" class="form-control" value="<?php echo "$email";?>">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3">
                <label for="isi_testimoni">Isi Testimoni</label>
                <textarea name="isi_testimoni" id="isi_testimoni" class="form-control" cols="30" rows="3"><?php echo "$isi_testimoni";?></textarea>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="status_testimoni">Status</label>
                <select name="status_testimoni" id="status_testimoni" class="form-control">
                    <option <?php if($status_testimoni==""){echo "selected";} ?> value="">Pilih</option>
                    <option <?php if($status_testimoni=="Pending"){echo "selected";} ?> value="Pending">Pending</option>
                    <option <?php if($status_testimoni=="Draft"){echo "selected";} ?> value="Draft">Draft</option>
                    <option <?php if($status_testimoni=="Publish"){echo "selected";} ?> value="Publish">Publish</option>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label for="image_testimoni">File Foto</label>
                <input type="file" id="image_testimoni" name="image_testimoni" class="form-control">
                <small>Maksimal file 2 mb (jpg, jpeg, png & gif)</small>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3" id="NotifikasiEditTestimoni">
                <small class="text-primary">Pastikan informasi testimoni yang anda input sudah sesuai</small>
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