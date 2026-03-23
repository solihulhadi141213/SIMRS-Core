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
    <div class="row">
        <div class="col-md-12 mb-3 table table-responsive">
            <table class="table">
                <tbody>
                    <tr>
                        <td>
                            <dt>Tanggal :</dt>
                            <?php echo "$tanggal"; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <dt>URL :</dt>
                            <?php echo "$url_site"; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <dt>Priority site :</dt>
                            <?php echo "$priority_site"; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <dt>Label :</dt>
                            <?php echo "$label"; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <dt>Status :</dt>
                            <?php echo "$status"; ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-3">
            <iframe src="<?php echo "$url_site"; ?>" frameborder="1" width="100%"></iframe>
        </div>
    </div>
<?php }}} ?>