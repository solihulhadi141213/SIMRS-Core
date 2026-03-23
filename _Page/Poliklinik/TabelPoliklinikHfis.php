<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <div class="table table-responsive pre-scrollable">
                <?php
                    include "../../_Config/Connection.php";
                    include "../../_Config/SettingBridging.php";
                    //Membuat fungsi
                    include "../../vendor/autoload.php";
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
                    //Membuat URL
                    $url="$url_antrol/ref/poli";
                    //Mulai CURL
                    $ch = curl_init();
                    curl_setopt($ch,CURLOPT_URL, "$url");
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch,CURLOPT_HEADER, 0);
                    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $content = curl_exec($ch);
                    $err = curl_error($ch);
                    curl_close($ch);
                    $ambil_json =json_decode($content, true);
                    $string=$ambil_json["response"];
                    $metadata=$ambil_json["metadata"];
                    $code=$metadata["code"];
                    $message=$metadata["message"];
                    $Terjemahkan=stringDecrypt($key, $string);
                    $FileDekompresi=decompress("$Terjemahkan");
                    $JsonData =json_decode($FileDekompresi, true);
                    $JumlahPoli=count($JsonData);
                    if($message!=="OK"){
                        echo "URL: $url_antrol<br>";
                        echo "Cons ID: $cons_id_antrol<br>";
                        echo "USER Key: $user_key_antrol<br>";
                        echo "Secret Key: $secret_key_antrol<br>";
                        echo "Timestamp: $tStamp<br>";
                        echo "EncodedSignature: $encodedSignature<br>";
                        echo "urlencodedSignature: $urlencodedSignature<br>";
                        echo "JumlahPoli: $JumlahPoli<br>";
                        echo "code: $code<br>";
                        echo "message: $message<br>";
                        echo "$FileDekompresi";
                    }
                ?>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th><dt>No</dt></th>
                            <th><dt>Kode</dt></th>
                            <th><dt>Poliklinik</dt></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $no=1;
                            for($a=0; $a<$JumlahPoli; $a++){
                                $nmpoli=$JsonData[$a]['nmpoli'];
                                $nmsubspesialis=$JsonData[$a]['nmsubspesialis'];
                                $kdsubspesialis=$JsonData[$a]['kdsubspesialis'];
                                $kdpoli=$JsonData[$a]['kdpoli'];
                                echo '<tr>';
                                echo '  <td>'.$no.'</td>';
                                echo '  <td>'.$kdpoli.'</td>';
                                echo '  <td>';
                                echo '      Poli:'.$nmpoli.'<br>';
                                echo '      Kd-Sub:'.$kdsubspesialis.'<br>';
                                echo '      Subspesialis:'.$nmsubspesialis.'<br>';
                                echo '  </td>';
                                echo '</tr>';
                            $no++;}
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer bg-primary">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">
        <i class="ti ti-close"></i> Tutup
    </button>
</div>