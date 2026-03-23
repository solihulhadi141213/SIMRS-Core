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
    <div class="row">
        <div class="col-md-12 mb-3">
            <dt>Judul Arsip:</dt>
            <?php echo "$judul"; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-3">
            <dt>Tanggal:</dt>
            <?php echo "$tanggal"; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-3">
            <dt>Kategori:</dt>
            <?php echo "$kategori"; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-3">
            <dt>Deskripsi:</dt>
            <?php echo "$deskripsi"; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-3">
            <dt>Status:</dt>
            <?php echo "$status"; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-3">
            <dt>File URL:</dt>
            <a href="<?php echo "$url_file"; ?>">
                <?php echo "$url_file"; ?>
            </a>
        </div>
    </div>
<?php }}} ?>