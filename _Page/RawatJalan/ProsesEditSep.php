<?php
    //Pengaturan waktu
    date_default_timezone_set('UTC');
    //Koneksi dan akses
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingBridging.php";
    //Membuat fungsi
    include "../../vendor/autoload.php";
    //Inisiasi masing-masing variabel
    if(empty($_POST['noSep'])){
        $noSep="";
    }else{
        $noSep=$_POST['noSep'];
    }
    if(empty($_POST['klsRawatHak'])){
        $klsRawatHak="";
    }else{
        $klsRawatHak=$_POST['klsRawatHak'];
    }
    if(empty($_POST['klsRawatNaik'])){
        $klsRawatNaik="";
    }else{
        $klsRawatNaik=$_POST['klsRawatNaik'];
    }
    if(empty($_POST['pembiayaan'])){
        $pembiayaan="";
    }else{
        $pembiayaan=$_POST['pembiayaan'];
    }
    if(empty($_POST['penanggungJawab'])){
        $penanggungJawab="";
    }else{
        $penanggungJawab=$_POST['penanggungJawab'];
    }
    if(empty($_POST['noMR'])){
        $noMR="";
    }else{
        $noMR=$_POST['noMR'];
    }
    if(empty($_POST['catatan'])){
        $catatan="";
    }else{
        $catatan=$_POST['catatan'];
    }
    if(empty($_POST['diagAwal'])){
        $diagAwal="";
    }else{
        $diagAwal=$_POST['diagAwal'];
    }
    if(empty($_POST['tujuan'])){
        $tujuan="1";
    }else{
        $tujuan=$_POST['tujuan'];
    }
    if(empty($_POST['eksekutif'])){
        $eksekutif="0";
    }else{
        $eksekutif=$_POST['eksekutif'];
    }
    if(empty($_POST['cob'])){
        $cob="0";
    }else{
        $cob=$_POST['cob'];
    }
    if(empty($_POST['katarak'])){
        $katarak="0";
    }else{
        $katarak=$_POST['katarak'];
    }
    if(empty($_POST['lakaLantas'])){
        $lakaLantas="0";
    }else{
        $lakaLantas=$_POST['lakaLantas'];
    }
    if(empty($_POST['tglKejadian'])){
        $tglKejadian="";
    }else{
        $tglKejadian=$_POST['tglKejadian'];
    }
    if(empty($_POST['keterangan'])){
        $keterangan="";
    }else{
        $keterangan=$_POST['keterangan'];
    }
    if(empty($_POST['suplesi'])){
        $suplesi="";
    }else{
        $suplesi=$_POST['suplesi'];
    }
    if(empty($_POST['noSepSuplesi'])){
        $noSepSuplesi="";
    }else{
        $noSepSuplesi=$_POST['noSepSuplesi'];
    }
    if(empty($_POST['kdPropinsi'])){
        $kdPropinsi="";
    }else{
        $kdPropinsi=$_POST['kdPropinsi'];
    }
    if(empty($_POST['kdKabupaten'])){
        $kdKabupaten="";
    }else{
        $kdKabupaten=$_POST['kdKabupaten'];
    }
    if(empty($_POST['kdKecamatan'])){
        $kdKecamatan="";
    }else{
        $kdKecamatan=$_POST['kdKecamatan'];
    }
    if(empty($_POST['dpjpLayan'])){
        $dpjpLayan="";
    }else{
        $dpjpLayan=$_POST['dpjpLayan'];
    }
    if(empty($_POST['noTelp'])){
        $noTelp="";
    }else{
        $noTelp=$_POST['noTelp'];
    }
    if(empty($_POST['user'])){
        $user="Dhiforester";
    }else{
        $user=$_POST['user'];
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
    $arr = array("request" =>
        array("t_sep"=>
            array(
                "noSep"=> "$noSep",
                "klsRawat"=>array(
                    "klsRawatHak"=>"$klsRawatHak",
                    "klsRawatNaik"=> "$klsRawatNaik",
                    "pembiayaan"=> "$pembiayaan",
                    "penanggungJawab"=> "$penanggungJawab"
                ),
                "noMR"=> "$noMR",
                "catatan"=> "$catatan",
                "diagAwal"=> "$diagAwal",
                "poli"=>array( 
                    "tujuan"=> "$tujuan",
                    "eksekutif"=> "$eksekutif"
                ),
                "cob"=>array(
                    "cob"=>"$cob"
                ),
                "katarak"=>array(
                    "katarak"=>"$katarak"
                ),
                "jaminan"=>array(
                    "lakaLantas"=>"$lakaLantas",
                    "penjamin"=>array(
                        "tglKejadian"=>"$tglKejadian",
                        "keterangan"=>"$keterangan",
                        "suplesi"=>array(
                            "suplesi"=>"$suplesi",
                            "noSepSuplesi"=>"$noSepSuplesi",
                            "lokasiLaka"=>array(
                                "kdPropinsi"=>"$kdPropinsi",
                                "kdKabupaten"=>"$kdKabupaten",
                                "kdKecamatan"=>"$kdKecamatan"
                            )
                        )
                    )
                ),
                "dpjpLayan"=>"$dpjpLayan",
                "noTelp"=>"$noTelp",
                "user"=>"$user"
            )
        )
    );
    $json = json_encode($arr);
    //Membuat URL
    $TanggalSekarang=date('Y-m-d');
    $URLUtama=$url_vclaim;
    $URLKatalog="SEP/2.0/update";
    $url="$URLUtama$URLKatalog";
    //Mulai CURL
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL, "$url");
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch,CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
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
    $JsonData =json_decode($FileDekompresi, true);
    $noSep=$JsonData["sep"]["noSep"];
    //--konveris json to raw
    if($code=="200"){
        $UpdateKunjungan= mysqli_query($Conn,"UPDATE kunjungan_utama SET 
            DiagAwal='$diagAwal'
        WHERE sep='$noSep'") or die(mysqli_error($Conn));
        if($UpdateKunjungan){
            $_SESSION['NotifikasiSwal']="Edit SEP Berhasil";
            echo '<span class="text-info" id="ProsesEditSepBerhasil">Berhasil</span><br>';
        }else{
            echo '<span class="text-danger">Update data SEP pada SIMRS Gagal!!</span><br>';
        }
    }else{
        echo '<span class="text-danger">Maaf, Update SEP gagal!!</span><br>';
        echo '<span class="text-danger">Keterangan :'.$message.'<br>';
    }
?>