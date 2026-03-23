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
?>
    
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12 mb-3">
                <img src="<?php echo $image_testimoni;?>" width="100%" alt="Foto Event">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3">
                <label for=""><dt>Tanggal :</dt></label><br>
                <?php echo "$tanggal_testimoni"; ?>
            </div>
            <div class="col-md-12 mb-3">
                <label for=""><dt>Nama Pengirim :</dt></label><br>
                <?php echo "$nama_testimoni"; ?>
            </div>
            <div class="col-md-12 mb-3">
                <label for=""><dt>Email :</dt></label><br>
                <?php echo "$email"; ?>
            </div>
            <div class="col-md-12 mb-3">
                <label for=""><dt>Status :</dt></label><br>
                <?php echo "$status_testimoni"; ?>
            </div>
            <div class="col-md-12 mb-3">
                <label for=""><dt>Isi Testimoni :</dt></label><br>
                <?php echo "$isi_testimoni"; ?>
            </div>
        </div>
    </div>
<?php }}} ?>