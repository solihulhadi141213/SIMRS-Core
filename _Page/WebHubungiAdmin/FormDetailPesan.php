<?php
    if(empty($_POST['id_pesan'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12">';
        echo '      <span class="text-danger">ID Pesan Tidak Boleh Kosong!</span>';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_pesan=$_POST['id_pesan'];
        include "../../_Config/Connection.php";
        include "../../_Config/SettingKoneksiWeb.php";
        include "../../_Config/WebFunction.php";
        $url=getServiceUrl2('Detail Hubungi Admin');
        $KirimData = array(
            'api_key' => $api_key,
            'id_pesan' => $id_pesan
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
                $tanggal=$JsonData['response']['tanggal'];
                $nama_pengirim=$JsonData['response']['nama_pengirim'];
                $email_pengirim=$JsonData['response']['email_pengirim'];
                $kontak=$JsonData['response']['kontak'];
                $kategori=$JsonData['response']['kategori'];
                $subjek=$JsonData['response']['subjek'];
                $pesan=$JsonData['response']['pesan'];
                $pesan_balasan=$JsonData['response']['pesan_balasan'];
                $status=$JsonData['response']['status'];
?>
    <div class="row">
        <div class="col-md-12 mb-3 pre-scrollable">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <dt>Tanggal Pesan :</dt>
                    <?php echo "$tanggal"; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <dt>Nama Pengirim :</dt>
                    <?php echo "$nama_pengirim"; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <dt>Email Pengirim :</dt>
                    <?php echo "$email_pengirim"; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <dt>Kontak Pengirim :</dt>
                    <?php echo "$kontak"; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <dt>Kategori :</dt>
                    <?php echo "$kategori"; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <dt>Subjek :</dt>
                    <?php echo "$subjek"; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <dt>Isi Pesan :</dt>
                    <?php echo "$pesan"; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <dt>Pesan Balasan :</dt>
                    <?php echo "$pesan_balasan"; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <dt>Status :</dt>
                    <?php echo "$status"; ?>
                </div>
            </div>
        </div>
    </div>
<?php }}} ?>