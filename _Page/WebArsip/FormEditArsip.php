<?php
    if(empty($_POST['id_arsip'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12">';
        echo '      <span class="text-danger">ID Arsip Tidak Boleh Kosong!</span>';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_arsip=$_POST['id_arsip'];
        include "../../_Config/Connection.php";
        include "../../_Config/SettingKoneksiWeb.php";
        include "../../_Config/WebFunction.php";
        $url=getServiceUrl2('Detail Arsip');
        $KirimData = array(
            'api_key' => $api_key,
            'id_arsip' => $id_arsip
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
                $id_arsip=$JsonData['response']['id_arsip'];
                $judul=$JsonData['response']['judul'];
                $tanggal=$JsonData['response']['tanggal'];
                $kategori=$JsonData['response']['kategori'];
                $deskripsi=$JsonData['response']['deskripsi'];
                $url_file=$JsonData['response']['url_file'];
                $status=$JsonData['response']['status'];
?>
    <input type="hidden" name="id_arsip" id="id_arsip" value="<?php echo "$id_arsip"; ?>">
    <div class="row">
        <div class="col-md-12 mt-3">
            <label for="judul">Judul Arsip</label>
            <input type="text" name="judul" id="judul" class="form-control" value="<?php echo "$judul"; ?>">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mt-3">
            <label for="tanggal">Tanggal</label>
            <input type="date" name="tanggal" id="tanggal" class="form-control" value="<?php echo "$tanggal"; ?>">
        </div>
        <div class="col-md-6 mt-3">
            <label for="kategori">Kategori</label>
            <input type="text" name="kategori" id="kategori" class="form-control" value="<?php echo "$kategori"; ?>">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mt-3">
            <label for="deskripsi">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" cols="30" rows="3" class="form-control"><?php echo "$deskripsi"; ?></textarea>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mt-3">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control">
                <option <?php if($status=="Publish"){echo "selected";} ?> value="Publish">Publish</option>
                <option <?php if($status=="Draft"){echo "selected";} ?> value="Draft">Draft</option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mt-3">
            <label for="file_arsip">File Arsip</label>
            <input type="file" name="file_arsip" id="file_arsip" class="form-control" value="">
            <small>File maksimal 2 mb (jpg, jpeg, png, gif, pdf)</small>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mt-3" id="NotifikasiEditArsip">
            <span class="text-primary">
                Pastikan data Medsos sudah benar.
            </span>
        </div>
    </div>
<?php }}} ?>