<?php
    if(empty($_POST['id_unit_instalasi'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12">';
        echo '      <span class="text-danger">ID Unit Tidak Boleh Kosong!</span>';
        echo '  </div>';
        echo '</div>';
    }else{
        $id=$_POST['id_unit_instalasi'];
        include "../../_Config/Connection.php";
        include "../../_Config/SettingKoneksiWeb.php";
        include "../../_Config/WebFunction.php";
        $url=getServiceUrl2('Detail Unit');
        $KirimData = array(
            'api_key' => $api_key,
            'id_unit_instalasi' => $id
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
                $id_unit_instalasi=$JsonData['response']['id_unit_instalasi'];
                $nama_unit_instalasi=$JsonData['response']['nama_unit_instalasi'];
                $deskripsi_unit_instalasi=$JsonData['response']['deskripsi_unit_instalasi'];
                $poster_unit_instalasi=$JsonData['response']['poster_unit_instalasi'];
                $datetime_unit_instalasi=$JsonData['response']['datetime_unit_instalasi'];
                $jumlah_anggota=$JsonData['response']['jumlah_anggota'];
                $jumlah_galeri=$JsonData['response']['jumlah_galeri'];
?>
    
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12 text-center">
                <img src="<?php echo $poster_unit_instalasi;?>" width="100%" alt="Foto Unit">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="table table-responsive pre-scrollable">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <td>
                                    <dt>Nama Unit:</dt>
                                    <?php echo "$nama_unit_instalasi"; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <dt>Jumlah Anggota Unit:</dt>
                                    <?php echo "$jumlah_anggota"; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <dt>Jumlah Galeri:</dt>
                                    <?php echo "$jumlah_galeri"; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <dt>Update Time:</dt>
                                    <?php echo "$datetime_unit_instalasi"; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <dt>Deskripsi Unit:</dt>
                                    <?php echo "$deskripsi_unit_instalasi"; ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <a href="index.php?Page=WebUnit&Sub=DetailUnit&id=<?php echo "$id_unit_instalasi";?>" class="btn btn-md btn-outline-dark btn-block">
                    Selengkapnya
                </a>
            </div>
        </div>
    </div>
<?php }}} ?>