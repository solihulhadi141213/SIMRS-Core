<?php
    //Zona Waktu
    date_default_timezone_set('UTC');
    //Koneksi
    include "../../_Config/Connection.php";
    //SettingBridging
    include "../../_Config/SettingBridging.php";
    //Membuat fungsi
    include "../../vendor/autoload.php";
    //Menangkap parameter
    if(empty($_POST['tanggal1'])){
        echo '<span class="text-danger">Tanggal Awal Pencarian Tidak Boleh Kosong</span>';
    }else{
        if(empty($_POST['tanggal2'])){
            echo '<span class="text-danger">Tanggal Akhir Pencarian Tidak Boleh Kosong</span>';
        }else{
            if(empty($_POST['FormatFilter'])){
                echo '<span class="text-danger">Format Filter Pencarian Tidak Boleh Kosong</span>';
            }else{
                $tanggal1=$_POST['tanggal1'];
                $tanggal2=$_POST['tanggal2'];
                $FormatFilter=$_POST['FormatFilter'];
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
                $URLKatalog="RencanaKontrol/ListRencanaKontrol/tglAwal/$tanggal1/tglAkhir/$tanggal2/filter/$FormatFilter";
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
                $list=$JsonData['list'];
                //--Hitung jumlah list
                $Jumlah=count($list);
                if(empty($Jumlah)){
                    echo "<span class='text-danger'>Data Tidak Ditemukan</span>";
                }else{
                    $no=1;
                    for($a=0; $a<$Jumlah; $a++){
                        $noSuratKontrol=$list[$a]['noSuratKontrol'];
                        $jnsPelayanan=$list[$a]['jnsPelayanan'];
                        $jnsKontrol=$list[$a]['jnsKontrol'];
                        $namaJnsKontrol=$list[$a]['namaJnsKontrol'];
                        $tglRencanaKontrol=$list[$a]['tglRencanaKontrol'];
                        $tglTerbitKontrol=$list[$a]['tglTerbitKontrol'];
                        $noSepAsalKontrol=$list[$a]['noSepAsalKontrol'];
                        $poliAsal=$list[$a]['poliAsal'];
                        $namaPoliAsal=$list[$a]['namaPoliAsal'];
                        $poliTujuan=$list[$a]['poliTujuan'];
                        $namaPoliTujuan=$list[$a]['namaPoliTujuan'];
                        $tglSEP=$list[$a]['tglSEP'];
                        $kodeDokter=$list[$a]['kodeDokter'];
                        $namaDokter=$list[$a]['namaDokter'];
                        $noKartu=$list[$a]['noKartu'];
                        $nama=$list[$a]['nama'];
?>
    <tr tabindex="0" data-toggle="modal" data-target="#ModalDetailSpri" data-id="<?php echo "$noSuratKontrol";?>" onmousemove="this.style.cursor='pointer'">
        <td class="text-center"><?php echo "$no"; ?></td>
        <td class="text-left"><?php echo "<dt>$noSuratKontrol</dt> $nama"; ?></td>
        <td class="text-left"><?php echo "$namaJnsKontrol"; ?></td>
        <td class="text-left"><?php echo "$tglRencanaKontrol"; ?></td>
        <td class="text-left"><?php echo "$namaPoliTujuan"; ?></td>
        <td class="text-left"><?php echo "$namaDokter"; ?></td>
    </tr>
<?php  $no++;}}}}} ?>