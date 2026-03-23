<?php
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingBridging.php";
    include "../../vendor/autoload.php";
    if(empty($_POST['kode'])){
        $GetKode="";
    }else{
        $GetKode=$_POST['kode'];
    }
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
    $url="$url_antrol/ref/dokter";
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
    $JumlahDokter=count($JsonData);
?>
<div class="row">
    <div class="col-12">
        <div class="table table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th class="text-center"><dt>No</dt></th>
                        <th class="text-center"><dt>Kode & Nama Dokter</dt></th>
                        <th class="text-center"><dt>Status</dt></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if($message!=="OK"){
                            echo "<tr>
                                <td colspan='3' class='text-center'>$message</td>
                            </tr>";
                        }else{
                            $no=1;
                            for($a=0; $a<$JumlahDokter; $a++){
                                $namadokter=$JsonData[$a]['namadokter'];
                                $kodedokter=$JsonData[$a]['kodedokter'];
                                //Cek apakah kode tersebut sudah ada pada data dokter
                                $cek_kode=mysqli_query($Conn, "SELECT * FROM dokter WHERE kode='$kodedokter'");
                                $cek_kode_row=mysqli_num_rows($cek_kode);
                                if(!empty($cek_kode_row)){
                                    $status="<label class='label label-success'><i class='ti ti-check-box'></i> Tersedia</label>";
                                }else{
                                    $status="<label class='label label-danger'><i class='ti ti-close'></i> None</label>";
                                }
                                if($GetKode==$kodedokter){
                                    echo '<tr class="bg-secondary">';
                                    echo '  <td class="text-center">'.$no.'</td>';
                                    echo '  <td>'.$kodedokter.' - '.$namadokter.'</td>';
                                    echo '  <td class="text-left">'.$status.'</td>';
                                    echo '</tr>';
                                }else{
                                    echo '<tr>';
                                    echo '  <td class="text-center">'.$no.'</td>';
                                    echo '  <td>'.$kodedokter.' - '.$namadokter.'</td>';
                                    echo '  <td class="text-left">'.$status.'</td>';
                                    echo '</tr>';
                                }
                                
                            $no++;}
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

