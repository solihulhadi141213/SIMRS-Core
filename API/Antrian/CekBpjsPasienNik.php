<?php
	//Koneksi database
	//Zona Waktu
    date_default_timezone_set('UTC');
    //Koneksi
    include "../../_Config/Connection.php";
    //SettingBridging
    include "../../_Config/SettingBridging.php";
    //Membuat fungsi
    include "../../vendor/autoload.php";
	$fp = fopen('php://input', 'r');
	$raw = stream_get_contents($fp);
	//Decode data json
	$data = json_decode($raw,true);
	//Apabila data kategori_identitas tidak ada
	if(empty($data['username'])){
		$respon = Array (
			"massage" => "Koneksi Ke Server Gagal Karena Username Tidak Ada!!",
			"code" => 201
		);
        $metadata = Array ();
	}else{
		//Apabila password tidak ada
		if(empty($data['password'])){
			$respon = Array (
				"massage" => "Koneksi Ke Server Gagal Karena Password Tidak Ada!!",
				"code" => 201
			);
            $metadata = Array ();
		}else{
			$username=$data['username'];
			$password=$data['password'];
			//Menangkap nik
			if(empty($data['nik'])){
				$respon = Array (
					"massage" => "Nomor Kartu Tidak Boleh Kosong tidak boleh kosong",
					"code" => 201
				);
                $metadata = Array ();
			}else{
                $nik=$data['nik'];
                //Bridging BPJS
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
                $URLKatalog="Peserta/nik/$nik/tglSEP/$TanggalSekarang";
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
                //Keberadaan data
                $noKartu=$JsonData["peserta"]["noKartu"];
                if(!empty($noKartu)){
                    $nama=$JsonData["peserta"]["nama"];
                    $nik=$JsonData["peserta"]["nik"];
                    $noKartu=$JsonData["peserta"]["noKartu"];
                    $pisa=$JsonData["peserta"]["pisa"];
                    $sex=$JsonData["peserta"]["sex"];
                    $tglCetakKartu=$JsonData["peserta"]["tglCetakKartu"];
                    $tglLahir=$JsonData["peserta"]["tglLahir"];
                    $tglTAT=$JsonData["peserta"]["tglTAT"];
                    $tglTMT=$JsonData["peserta"]["tglTMT"];
                    //COB
                    $nmAsuransi=$JsonData["peserta"]["cob"]["nmAsuransi"];
                    $noAsuransi=$JsonData["peserta"]["cob"]["noAsuransi"];
                    $tglTAT=$JsonData["peserta"]["cob"]["tglTAT"];
                    $tglTMT=$JsonData["peserta"]["cob"]["tglTMT"];
                    //hakKelas
                    $hakKelasketerangan=$JsonData["peserta"]["hakKelas"]["keterangan"];
                    $hakKelaskode=$JsonData["peserta"]["hakKelas"]["kode"];
                    //informasi
                    $dinsos=$JsonData["peserta"]["informasi"]["dinsos"];
                    $noSKTM=$JsonData["peserta"]["informasi"]["noSKTM"];
                    $prolanisPRB=$JsonData["peserta"]["informasi"]["prolanisPRB"];
                    //jenisPeserta
                    $jenisPesertaketerangan=$JsonData["peserta"]["jenisPeserta"]["keterangan"];
                    $jenisPesertakode=$JsonData["peserta"]["jenisPeserta"]["kode"];
                    //mr
                    $noMR=$JsonData["peserta"]["mr"]["noMR"];
                    $noTelepon=$JsonData["peserta"]["mr"]["noTelepon"];
                    //provUmum
                    $kdProvider=$JsonData["peserta"]["provUmum"]["kdProvider"];
                    $nmProvider=$JsonData["peserta"]["provUmum"]["nmProvider"];
                    //statusPeserta
                    $statusPesertaketerangan=$JsonData["peserta"]["statusPeserta"]["keterangan"];
                    $statusPesertakode=$JsonData["peserta"]["statusPeserta"]["kode"];
                    //umur
                    $umurSaatPelayanan=$JsonData["peserta"]["umur"]["umurSaatPelayanan"];
                    $umurSekarang=$JsonData["peserta"]["umur"]["umurSekarang"];
                    $respon = Array (
                        "massage" => "Ok",
                        "code" => 200
                    );
                    $metadata = Array (
                        "nama" => "$nama",
                        "nik" => "$nik",
                        "noKartu" => "$noKartu",
                        "sex" => "$sex",
                        "noTelepon" => "$noTelepon",
                        "statusPesertaketerangan" => "$statusPesertaketerangan",
                        "statusPesertakode" => "$statusPesertakode",
                    );
                }else{
                    $respon = Array (
                        "massage" => "Data Tidak Ditemukan Pada Database BPJS",
                        "code" => 201
                    );
                    $metadata = Array ();
                }
			}
		}
	}
	$Array = Array (
		"respon" => $respon,
		"metadata" => $metadata
	);
	$json = json_encode(array("data" => $Array));
	echo "$json";
?>