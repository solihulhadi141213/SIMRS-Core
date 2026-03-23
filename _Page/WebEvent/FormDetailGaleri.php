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
                $judul_galeri=$JsonData['response']['judul_galeri'];
                $deskripsi_galeri=$JsonData['response']['deskripsi_galeri'];
                $tanggal_galeri=$JsonData['response']['tanggal_galeri'];
                $tipe_file=$JsonData['response']['tipe_file'];
                $size_file=$JsonData['response']['size_file'];
                $name_file=$JsonData['response']['name_file'];
                $url_file=$JsonData['response']['url_file'];
?>
    
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12 text-center">
                <img src="<?php echo $url_file;?>" width="100%" alt="Foto Event">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="table table-responsive pre-scrollable">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <td>
                                    <dt>Judul Galeri:</dt>
                                    <?php echo "$judul_galeri"; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <dt>Tanggal:</dt>
                                    <?php echo "$tanggal_galeri"; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <dt>Deskripsi Galeri:</dt>
                                    <?php echo "$deskripsi_galeri"; ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php }}} ?>