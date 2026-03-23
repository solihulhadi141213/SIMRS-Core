<?php
    //Zona Waktu
    date_default_timezone_set('UTC');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingFaskes.php";
    include "../../_Config/SettingBridging.php";
    include "../../vendor/autoload.php";
    //Menangkap sep
    if(empty($_POST['noSepCetak'])){
        echo '<span class="text-danger">SEP Tidak Dipilih Pada Paramter Detail</span>';
    }else{
        if(empty($_POST['FormatCetakSep'])){
            echo '<span class="text-danger">Format Cetak SEP Tidak Boleh Kosong!</span>';
        }else{
            $sep=$_POST['noSepCetak'];
            $FormatCetakSep=$_POST['FormatCetakSep'];
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
            $URLKatalog="SEP/$sep";
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
            $noSep=$JsonData["noSep"];
            $tglSep=$JsonData["tglSep"];
            $jnsPelayanan=$JsonData["jnsPelayanan"];
            $kelasRawat=$JsonData["kelasRawat"];
            $diagnosa=$JsonData["diagnosa"];
            $noRujukan=$JsonData["noRujukan"];
            $poli=$JsonData["poli"];
            $poliEksekutif=$JsonData["poliEksekutif"];
            $catatan=$JsonData["catatan"];
            $penjamin=$JsonData["penjamin"];
            $kdStatusKecelakaan=$JsonData["kdStatusKecelakaan"];
            $nmstatusKecelakaan=$JsonData["nmstatusKecelakaan"];
            $cob=$JsonData["cob"];
            $katarak=$JsonData["katarak"];
            //lokasiKejadian
            $kdKab=$JsonData["lokasiKejadian"]["kdKab"];
            $kdKec=$JsonData["lokasiKejadian"]["kdKec"];
            $kdProp=$JsonData["lokasiKejadian"]["kdProp"];
            $ketKejadian=$JsonData["lokasiKejadian"]["ketKejadian"];
            $lokasi=$JsonData["lokasiKejadian"]["lokasi"];
            $tglKejadian=$JsonData["lokasiKejadian"]["tglKejadian"];
            //dpjp
            $kdDPJP=$JsonData["dpjp"]["kdDPJP"];
            $nmDPJP=$JsonData["dpjp"]["nmDPJP"];
            //peserta
            $asuransi=$JsonData["peserta"]["asuransi"];
            $hakKelas=$JsonData["peserta"]["hakKelas"];
            $jnsPeserta=$JsonData["peserta"]["jnsPeserta"];
            $kelamin=$JsonData["peserta"]["kelamin"];
            $nama=$JsonData["peserta"]["nama"];
            $noKartu=$JsonData["peserta"]["noKartu"];
            $noMr=$JsonData["peserta"]["noMr"];
            $tglLahir=$JsonData["peserta"]["tglLahir"];
            //klsRawat
            $klsRawatHak=$JsonData["klsRawat"]["klsRawatHak"];
            $klsRawatNaik=$JsonData["klsRawat"]["klsRawatNaik"];
            $pembiayaan=$JsonData["klsRawat"]["pembiayaan"];
            $penanggungJawab=$JsonData["klsRawat"]["penanggungJawab"];
            //kontrol
            $kdDokter=$JsonData["kontrol"]["kdDokter"];
            $nmDokter=$JsonData["kontrol"]["nmDokter"];
            $noSurat=$JsonData["kontrol"]["noSurat"];
            //KLL
            $nmstatusKecelakaan=$JsonData["nmstatusKecelakaan"];
            $kdKab=$JsonData["lokasiKejadian"]["kdKab"];
            // Inisiasi gende
            if($kelamin=="L"){
                $gender="Laki-Laki";
            }else{
                $gender="Perempuan";
            }
            if(!empty($noSep)){
                include "CetakSepHtml.php";
            }else{
                echo "<span class='text-danger'>Data Tidak Ditemukan</span>";
            }
        }
    }
?>