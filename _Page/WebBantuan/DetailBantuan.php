<?php
    if(empty($_POST['id_bantuan'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12">';
        echo '      <span class="text-danger">ID Bantuan Tidak Boleh Kosong!</span>';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_bantuan=$_POST['id_bantuan'];
        include "../../_Config/Connection.php";
        include "../../_Config/SettingKoneksiWeb.php";
        include "../../_Config/WebFunction.php";
        $url=getServiceUrl2('Detail Bantuan');
        $KirimData = array(
            'api_key' => $api_key,
            'id_bantuan' => $id_bantuan
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
                $judul=$JsonData['response']['judul'];
                $kategori=$JsonData['response']['kategori'];
                $tanggal=$JsonData['response']['tanggal'];
                $deskripsi=$JsonData['response']['deskripsi'];
                //Format Tanggal
                $strtotime=strtotime($tanggal);
                $TanggalFormat=date('d/m/Y H:i',$strtotime);
?>
    <div class="row">
        <div class="col-md-12 mb-3 pre-scrollable">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <dt>Judul Bantuan :</dt>
                    <?php echo "$judul"; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <dt>Kategori Bantuan :</dt>
                    <?php echo "$kategori"; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <dt>Tanggal Post:</dt>
                    <?php echo "$tanggal"; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <dt>Deskripsi Bantuan:</dt>
                    <?php echo "$deskripsi"; ?>
                </div>
            </div>
        </div>
    </div>
<?php }}} ?>