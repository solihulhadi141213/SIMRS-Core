<?php
    if(!empty($_POST['id_web_artikel'])){
        $id_web_artikel=$_POST['id_web_artikel'];
        //Menampilkan data
        include "../../_Config/Connection.php";
        include "../../_Config/SettingKoneksiWeb.php";
        include "../../_Config/WebFunction.php";
        $url=urlService('Detail Artikel');
        //Akses Data Dari Server Website
        $KirimData = array(
            'api_key' => $api_key,
            'id_web_artikel' => $id_web_artikel,
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
            echo '<div class="card">';
            echo '  <div class="card-body">';
            echo '      '.$err.'';
            echo '  </div>';
            echo '</d>';
        }else{
            $JsonData =json_decode($content, true);
            if(!empty($JsonData['metadata']['massage'])){
                $massage=$JsonData['metadata']['massage'];
            }else{
                $massage="Tidak Ada Pesan Response";
            }
            if(!empty($JsonData['metadata']['code'])){
                $code=$JsonData['metadata']['code'];
            }else{
                $code="Kode Tidak Diketahui";
            }
            if($code!==200){
                echo '<div class="card">';
                echo '  <div class="card-body">';
                echo '      '.$massage.'';
                echo '  </div>';
                echo '</d>';
            }else{
                $response=$JsonData['response'];
                $id_web_artikel=$response['id_web_artikel'];
                $artikel_judul=$response['artikel_judul'];
                $artikel_tanggal=$response['artikel_tanggal'];
                //Explode jam
                $Explode = explode(" " , $artikel_tanggal);
                $Tanggal=$Explode[0];
                if(!empty($Explode[1])){
                    $Jam=$Explode[1];
                }else{
                    $Jam="";
                }
                
                $artikel_penulis=$response['artikel_penulis'];
                $artikel_kategori=$response['artikel_kategori'];
                $artikel_ringkasan=$response['artikel_ringkasan'];
                $artikel_isi=$response['artikel_isi'];
                $artikel_status=$response['artikel_status'];
?>
    <div class="row">
            <div class="col col-md-12 mb-3">
                <?php 
                    echo "<dt>$artikel_judul</dt>"; 
                    echo "<small>Tanggal: $artikel_tanggal</small><br>"; 
                    echo "<small>Penulis: $artikel_penulis</small><br>"; 
                    echo "<small>Kategori: $artikel_kategori</small><br>"; 
                    echo "<small>Status: $artikel_status</small><br>"; 
                ?>
            </div>
        </div>
    </div>
    <div class="row">
            <div class="col col-md-12 mb-3">
                <?php 
                    echo "$artikel_isi"; 
                ?>
            </div>
        </div>
    </div>
<?php }}} ?>