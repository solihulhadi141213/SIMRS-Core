<?php
    date_default_timezone_set('Asia/Jakarta');
    //bulan
    if(!empty($_POST['bulan'])){
        $bulan=$_POST['bulan'];
    }else{
        $bulan=date('m');
    }
    //tahun
    if(!empty($_POST['tahun'])){
        $tahun=$_POST['tahun'];
    }else{
        $tahun=date('Y');
    }
?>
<script>
    //ketika klik next
    $('#ProsesPencarianRujukanKhusus').submit(function() {
        var bulan=$('#bulan').val();
        var tahun=$('#tahun').val();
        $('#MenampilkanTabelRujukanKhusus').html('Loading...');
        $.ajax({
            url     : "_Page/Rujukan/TabelRujukanKhusus.php",
            method  : "POST",
            data 	:  { bulan: bulan, tahun: tahun },
            success: function (data) {
                $('#MenampilkanTabelRujukanKhusus').html(data);
            }
        })
    });
</script>

<div class="card-block">
    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th id="" class="text-center">
                        <div class="dropdown-primary">
                            <button class="btn btn-round btn-sm btn-outline-secondary waves-effect waves-light btn-disabled" type="button">
                                No
                            </button>
                        </div> 
                    </th>
                    <th class="text-center" id="TabShortNama">
                        <div class="dropdown-primary">
                            <button class="btn btn-round btn-sm btn-outline-secondary waves-effect waves-light btn-disabled" type="button">
                                No.Rujukan
                            </button>
                        </div> 
                    </th>
                    <th class="text-center" id="TabShortNama">
                        <div class="dropdown-primary">
                            <button class="btn btn-round btn-sm btn-outline-secondary waves-effect waves-light btn-disabled" type="button">
                                Nama Peserta
                            </button>
                        </div> 
                    </th>
                    <th class="text-center" id="TabShortNama">
                        <div class="dropdown-primary">
                            <button class="btn btn-round btn-sm btn-outline-secondary waves-effect waves-light btn-disabled" type="button">
                                Diagnosa
                            </button>
                        </div> 
                    </th>
                    <th class="text-center" id="TabShortNama">
                        <div class="dropdown-primary">
                            <button class="btn btn-round btn-sm btn-outline-secondary waves-effect waves-light btn-disabled" type="button">
                                Tanggal Rujukan
                            </button>
                        </div> 
                    </th>
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
                    $URLKatalog="Rujukan/Khusus/List/Bulan/$bulan/Tahun/$tahun";
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
                    $list=$JsonData['rujukan'];
                    //--Hitung jumlah sep
                    $Jumlah=count($list);
                    if(empty($Jumlah)){
                        echo '<tr><td align="center" colspan="5">Belum Ada Data Yang Bisa Ditampilkan<br>Keterangan : $message</td></tr>';
                    }else{
                        $no=1;
                        for($a=0; $a<$Jumlah; $a++){
                            $idrujukan=$list[$a]['idrujukan'];
                            $norujukan=$list[$a]['norujukan'];
                            $nokapst=$list[$a]['nokapst'];
                            $nmpst=$list[$a]['nmpst'];
                            $diagppk=$list[$a]['diagppk'];
                            $tglrujukan_awal=$list[$a]['tglrujukan_awal'];
                            $tglrujukan_berakhir=$list[$a]['tglrujukan_berakhir'];
                            echo '<tr>';
                            echo '  <td align="center">'.$no.'</td>';
                            echo '  <td align="left">';
                            echo '      <dt>'.$norujukan.'</dt>';
                            echo '  </td>';
                            echo '  <td align="left">'.$nmpst.'</td>';
                            echo '  <td align="left">'.$diagppk.'</td>';
                            echo '  <td align="left">'.$tglrujukan_awal.'-'.$tglrujukan_berakhir.'</td>';
                            echo '</tr>';
                        $no++;}
                    }
                    
                ?>
            </tbody>
        </table>
        
    </div>
</div>
