<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    //Koneksi ke database
    include "../../_Config/Connection.php";
    //Session
    include "../../_Config/Session.php";
    //Setting Bridging
    include "../../_Config/SettingBridging.php";
    //Fungsi Autoload
    include "../../vendor/autoload.php";
    //Tangkap id_antrian
    if(empty($_POST['id_antrian'])){
        $id_antrian=$_POST['id_antrian'];
        echo '  <div class="row">';
        echo '      <div class="col-md-6 mb-3">';
        echo '          Data ID Antrian Tidak Boleh Kosong.';
        echo '      </div>';
        echo '  </div>';
    }else{
        $id_antrian=$_POST['id_antrian'];
        //Buka data Antrian
        $QryAntrian = mysqli_query($Conn,"SELECT * FROM antrian WHERE id_antrian='$id_antrian'")or die(mysqli_error($Conn));
        $DataAntrian = mysqli_fetch_array($QryAntrian);
        $id_kunjungan= $DataAntrian['id_kunjungan'];
        $no_antrian= $DataAntrian['no_antrian'];
        $kodebooking= $DataAntrian['kodebooking'];
?>
    <?php
        //menampilkan LIST task ID
        // function decrypt
        function stringDecrypt($key, $string){
            $encrypt_method = 'AES-256-CBC';
            // hash
            $key_hash = hex2bin(hash('sha256', $key));
            // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
            $iv = substr(hex2bin(hash('sha256', $key)), 0, 16);
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key_hash, OPENSSL_RAW_DATA, $iv);
            return $output;
        }
        // function lzstring decompress 
        // download libraries lzstring : https://github.com/nullpunkt/lz-string-php
        function decompress($string){
            return \LZCompressor\LZString::decompressFromEncodedURIComponent($string);
        }
        //Timestamp
        date_default_timezone_set('UTC');
        $tStamp = strval(time()-strtotime('1970-01-01 00:00:00'));
        //Creat Signature
        $signature = hash_hmac('sha256', $cons_id_antrol."&".$tStamp, $secret_key_antrol, true);
        $encodedSignature = base64_encode($signature);
        $urlencodedSignature = urlencode($encodedSignature);
        // base64 encode…
        $encodedSignature_manual="LwwWyiWHrr+tTQexsodhb6aWLzs+8Ofo4or68g9jIJM=";
        $timestamp_manual="1646230513";
        $key="$cons_id_antrol$secret_key_antrol$tStamp";
        //Membuat header
        $headers = array(
            'Content-Type:Application/x-www-form-urlencoded',
            'X-cons-id: '.$cons_id_antrol .'',
            'X-timestamp: '.$tStamp.'' ,
            'X-signature: '.$encodedSignature.'',
            'user_key: '.$user_key_antrol.''
        ); 
        $KirimData = array(
            'kodebooking' => $kodebooking
        );
        $json = json_encode($KirimData);
        //Membuat URL
        $url="$url_antrol/antrean/getlisttask";
        //Mulai CURL
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, "$url");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch,CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $content = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        $ambil_json =json_decode($content, true);
        if(empty($ambil_json["response"])){
            $pesan=$ambil_json["metadata"]["message"];
            echo '  <div class="row">';
            echo '      <div class="col-md-12 text-center text-danger mb-3">';
            echo '          Belum Ada Data Task ID<br><b>Keterangan :</b> '.$content.'';
            echo '      </div>';
            echo '  </div>';
        }else{
            $string=$ambil_json["response"];
            $metadata=$ambil_json["metadata"];
            $code=$metadata["code"];
            $message=$metadata["message"];
            $Terjemahkan=stringDecrypt($key, $string);
            $FileDekompresi=decompress("$Terjemahkan");
            $JsonData =json_decode($FileDekompresi, true);
            $JumlahTaskID=count($JsonData);
            //menampilkan Data
            $no=1;
            for($a=0; $a<$JumlahTaskID; $a++){
                $wakturs=$JsonData[$a]['wakturs'];
                $waktu=$JsonData[$a]['waktu'];
                $taskname=$JsonData[$a]['taskname'];
                $taskid=$JsonData[$a]['taskid'];
                $kodebooking=$JsonData[$a]['kodebooking'];
                echo '  <div class="row">';
                echo '      <div class="col-md-12 mb-3">';
                echo '          <dt>'.$taskid.'. '.$taskname.'</dt>';
                echo '          <small class="text-muted">RS: '.$wakturs.'<br>BPJS: '.$waktu.'</small>';
                echo '      </div>';
                echo '  </div>';
            $no++;}
        }
    ?>
<?php } ?>