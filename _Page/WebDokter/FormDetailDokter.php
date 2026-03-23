<?php
    if(empty($_POST['id_dokter'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12">';
        echo '      <span class="text-danger">ID Dokter Tidak Boleh Kosong!</span>';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_dokter=$_POST['id_dokter'];
        include "../../_Config/Connection.php";
        include "../../_Config/SettingKoneksiWeb.php";
        include "../../_Config/WebFunction.php";
        $url=getServiceUrl2('Detail Dokter');
        $KirimData = array(
            'api_key' => $api_key,
            'id_dokter' => $id_dokter
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
                $id_dokter=$JsonData['response']['id_dokter'];
                $kode=$JsonData['response']['kode'];
                $nama=$JsonData['response']['nama'];
                $spesialis=$JsonData['response']['spesialis'];
                $alamat=$JsonData['response']['alamat'];
                $kontak=$JsonData['response']['kontak'];
                $email=$JsonData['response']['email'];
                $status=$JsonData['response']['status'];
                $foto=$JsonData['response']['foto'];
                $last_update=$JsonData['response']['last_update'];
?>
    <div class="row">
        <div class="col-md-12 mb-3 text-center">
            <?php
                if(!empty($JsonData['response']['foto'])){
                    echo '<img src="'.$foto.'" width="100%%">';
                }
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-3 pre-scrollable">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <dt>Nama Dokter:</dt>
                    <?php echo "$nama"; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <dt>Kode Dokter:</dt>
                    <?php echo "$kode"; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <dt>Spesialis:</dt>
                    <?php echo "$spesialis"; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <dt>Alamat:</dt>
                    <?php echo "$alamat"; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <dt>Kontak:</dt>
                    <?php echo "$kontak"; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <dt>Email:</dt>
                    <?php echo "$email"; ?>
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
                    <dt>Last Update:</dt>
                    <?php echo "$last_update"; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-3">
            <a href="index.php?Page=WebDokter&Sub=DetailDokter&id=<?php echo "$id_dokter"; ?>" class="btn btn-md btn-primary btn-block">
                Selengkapnya
            </a>
        </div>
    </div>
<?php }}} ?>