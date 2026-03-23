<?php
    //NoRujukan
    if(!empty($_POST['NoRujukan'])){
        $NoRujukan=$_POST['NoRujukan'];
    }else{
        $NoRujukan="";
    }
    //Zona Waktu
    date_default_timezone_set('UTC');
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
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
    $diagnosa = array();
    $diagnosa["diagnosa"] = array();

    $procedur = array();
    $procedur["procedure"] = array();

    $queryDiagnosa = mysqli_query($Conn, "SELECT*FROM diagnosarujukankhusus WHERE rujukan='$NoRujukan' AND kategori!='Procedure'");
    while ($DataDiagnosa = mysqli_fetch_array($queryDiagnosa)) {
        $id_diagnosa  = $DataDiagnosa['id_diagnosa'];
        $rujukan= $DataDiagnosa['rujukan'];
        $kode= $DataDiagnosa['kode'];
        $kategori= $DataDiagnosa['kategori'];
        if($kategori=="Diagnosa Primer"){
            $kate="P;$kode";
        }else{
            $kate="S;$kode";
        }
        $ListDiagnosa['kode']=$kate;
        array_push($diagnosa["diagnosa"], $ListDiagnosa);
    }

    $QryPro = mysqli_query($Conn, "SELECT*FROM diagnosarujukankhusus WHERE rujukan='$NoRujukan' AND kategori='Procedure'");
    while ($DataPro = mysqli_fetch_array($QryPro)) {
        $DataProcedur['kode']=$DataPro['kode'];
        array_push($procedur["procedure"], $DataProcedur);
    }
    $arr = array(
        "noRujukan"=> "$NoRujukan",
        "diagnosa"=> $diagnosa["diagnosa"],
        "procedure"=> $procedur["procedure"],
        "user"=> "$SessionNama"
    );
    $json = json_encode($arr);
    //Membuat URL
        $TanggalSekarang=date('Y-m-d');
        $URLUtama=$url_vclaim;
        $URLKatalog="Rujukan/Khusus/insert";
        $url="$URLUtama$URLKatalog";
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
        $norujukan=$JsonData["rujukan"]["norujukan"];
        $nokapst=$JsonData["rujukan"]["nokapst"];
        $nmpst=$JsonData["rujukan"]["nmpst"];
        $diagppk=$JsonData["rujukan"]["diagppk"];
        $tglrujukan_awal=$JsonData["rujukan"]["tglrujukan_awal"];
        $tglrujukan_berakhir=$JsonData["rujukan"]["tglrujukan_berakhir"];
    //--konveris json to raw
        if($code=="200"){
            echo '<span class="text-info" id="NotifikasiBuatRujukanKhususBerhasil">Berhasil</span><br>';
            echo 'No.Rujukan : '.$norujukan.'<br>';
            echo 'No.Kartu Peserta : '.$nokapst.'<br>';
            echo 'Nama Peserta : '.$nmpst.'<br>';
            echo 'Diagnosa PPK : '.$diagppk.'<br>';
            echo 'Tanggal Rujukan Awal : '.$tglrujukan_awal.'<br>';
            echo 'Tanggal Rujukan Akhir : '.$tglrujukan_berakhir.'<br>';
        }else{
            echo '<span class="text-danger">Maaf, Buat Rujukan Khusus gagal!!</span><br>';
            echo '<span class="text-danger">Keterangan :'.$message.'<br>';
        }
?>