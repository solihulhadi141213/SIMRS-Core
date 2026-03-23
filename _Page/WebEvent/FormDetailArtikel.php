<?php
    if(empty($_POST['id_web_event'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12">';
        echo '      <span class="text-danger">ID Event Tidak Boleh Kosong!</span>';
        echo '  </div>';
        echo '</div>';
    }else{
        $id=$_POST['id_web_event'];
        include "../../_Config/Connection.php";
        include "../../_Config/SettingKoneksiWeb.php";
        include "../../_Config/WebFunction.php";
        $url=getServiceUrl2('Detail Event');
        $KirimData = array(
            'api_key' => $api_key,
            'id_web_event' => $id
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
                $id_web_event=$JsonData['response']['id_web_event'];
                $nama_event=$JsonData['response']['nama_event'];
                $kategori_event=$JsonData['response']['kategori_event'];
                $tanggal_event=$JsonData['response']['tanggal_event'];
                $deskripsi_event=$JsonData['response']['deskripsi_event'];
                $poster_event=$JsonData['response']['poster_event'];
                //explode tanggal
                $explode = explode(" " , $tanggal_event);
                $tanggal = $explode[0];
                $jam = $explode[1];
?>
    
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12 mb-3">
                <img src="<?php echo $poster_event;?>" width="100%" alt="Foto Event">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3">
                <h4><?php echo "$nama_event"; ?></h4>
                <?php echo "Label/Kategori: $kategori_event"; ?><br>
                <small><?php echo "Tanggal Posting: $tanggal_event"; ?></small>
                <p>
                    <?php echo "$deskripsi_event"; ?>
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <a href="index.php?Page=WebEvent&Sub=DetailEvent&id=<?php echo "$id_web_event";?>" class="btn btn-md btn-outline-dark btn-block">
                    Selengkapnya
                </a>
            </div>
        </div>
    </div>
<?php }}} ?>