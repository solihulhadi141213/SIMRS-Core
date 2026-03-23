<?php
    if(empty($_POST['id_laman'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12">';
        echo '      <span class="text-danger">ID Pesan Tidak Boleh Kosong!</span>';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_laman=$_POST['id_laman'];
        include "../../_Config/Connection.php";
        include "../../_Config/SettingKoneksiWeb.php";
        include "../../_Config/WebFunction.php";
        $url=getServiceUrl2('Detail Laman Mandiri');
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
                $id_laman=$JsonData['response']['id_laman'];
                $judul=$JsonData['response']['judul'];
                $tanggal=$JsonData['response']['tanggal'];
                $penulis=$JsonData['response']['penulis'];
                $isi_laman=$JsonData['response']['isi_laman'];
                //Format tanggal
                $strtotime=strtotime($tanggal);
                $Tanggal=date('d/m/Y',$strtotime);
?>
    <div class="row">
        <div class="col-md-12 mb-3">
            <?php 
                echo "<h5>$judul</h5>"; 
                echo '<small>'.$penulis.'</small><br>';
                echo '<small>'.$Tanggal.'</small><br>';
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-3">
            <h5><?php echo "$isi_laman"; ?></h5>
        </div>
    </div>
<?php }}} ?>