<?php
    //keyword
    if(empty($_POST['sep'])){
        echo "SEP Tidak Ditangkap";
    }else{
        $sep=$_POST['sep'];
?>
<div class="modal-body">
    <div class="table-responsive pre-scrollable">
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th class="text-center"><dt>No</dt></th>
                    <th class="text-center"><dt>Keterangan SEP</dt></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    //Zona Waktu
                    date_default_timezone_set('UTC');
                    //Koneksi
                    include "../../_Config/Connection.php";
                    //SettingBridging
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
                    $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
                    //Creat Signature
                    $signature = hash_hmac('sha256', $consid."&".$timestamp, $secret_key, true);
                    // base64 encode…
                    $encodedSignature = base64_encode($signature);
                    //Membuat header
                    $headers = array(
                        'X-signature: '.$encodedSignature.'',
                        'X-timestamp: '.$timestamp.'' ,
                        'X-cons-id: '.$consid .'',
                        'user_key: '.$user_key.'',
                        'Content-Type:Application/x-www-form-urlencoded'         
                    ); 
                    //Membuat URL
                    $TanggalSekarang=date('Y-m-d');
                    $URLUtama=$url_vclaim;
                    $URLKatalog="SEP/Internal/$sep";
                    $url="$URLUtama$URLKatalog";
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
                    $code=$ambil_json["metaData"]["code"];
                    $message=$ambil_json["metaData"]["message"];
                    $string=$ambil_json["response"];
                    //Proses decode dan dekompresi
                    //--membuat key
                    $key="$consid$secret_key$timestamp";
                    //--masukan ke fungsi
                    $FileDeskripsi=stringDecrypt("$key", "$string");
                    $FileDekompresi=decompress("$FileDeskripsi");
                    //--konveris json to raw
                    $JsonData =json_decode($FileDekompresi, true);
                    //--Get row poli
                    $count=$JsonData['count'];
                    $list=$JsonData['list'];
                    //--Hitung jumlah list
                    $Jumlah=count($list);
                    if($code!=="200"){
                        echo '<tr>';
                        echo '  <td colspan="2" class="text-center">SEP Internal Tidak Ada<br> <dt>KETERANGAN: '.$message.'</dt><small>'.$URLKatalog.'</small></td>';
                        echo '</tr>';
                    }else{
                        $no=1;
                        for($a=0; $a<$Jumlah; $a++){
                            $tujuanrujuk=$list[$a]['tujuanrujuk'];
                            $nmtujuanrujuk=$list[$a]['nmtujuanrujuk'];
                            $nmpoliasal=$list[$a]['nmpoliasal'];
                            $tglrujukinternal=$list[$a]['tglrujukinternal'];
                            $nosep=$list[$a]['nosep'];
                            $nosepref=$list[$a]['nosepref'];
                            $nosurat=$list[$a]['nosurat'];
                            echo '<tr>';
                            echo '  <td class="text-center">'.$no.'</td>';
                            echo '  <td>';
                            echo '      <dt>';
                            echo '          <a href="javascript:void(0);" class="btn btn-sm btn-primary btn-round" data-toggle="modal" data-target="#ModalKonfirmasiPPK" data-id="'.$nosep.'">';
                            echo '              '.$nosep.'';
                            echo '          </a><br>';
                            echo '          Tujuan Rujukan: '.$nmtujuanrujuk.'<br>';
                            echo '          Nama Poli: '.$nmpoliasal.'<br>';
                            echo '          No.SEP: '.$nosep.'<br>';
                            echo '          No.Surat: '.$nosurat.'<br>';
                            echo '      </dt>';
                            echo '  </td>';
                            echo '</tr>';
                        $no++;}
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>
<div class="modal-footer bg-info">
    <div class="row">
        <div class="col-md-12">
            <button type="button" class="btn btn-md btn-light mt-2 mr-2" data-dismiss="modal">
                <i class="ti-close"></i> Tutup
            </button>
        </div>
    </div>
</div>
<?php }?>