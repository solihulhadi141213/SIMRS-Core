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
    if(empty($_POST['JenisKontrol'])){
        echo '<div class="text-danger">Jenis Kontrol Tidak Boleh Kosong!!</div>';
    }else{
        $JenisKontrol=$_POST['JenisKontrol'];
        if($JenisKontrol=="1"){
            if(empty($_POST['noKartu'])){
                echo '<div class="text-danger">Nomor Kartu Tidak Boleh Kosong!!</div>';
            }else{
                $noKartu=$_POST['noKartu'];
                if(empty($_POST['poliKontrol'])){
                    echo '<div class="text-danger">Poli Kontrol Tidak Boleh Kosong!!</div>';
                }else{
                    $poliKontrol=$_POST['poliKontrol'];
                    if(empty($_POST['kodeDokter'])){
                        echo '<div class="text-danger">Kode Dokter Tidak Boleh Kosong!!</div>';
                    }else{
                        $kodeDokter=$_POST['kodeDokter'];
                        if(empty($_POST['tglRencanaKontrol'])){
                            echo '<div class="text-danger">Tanggal Rencana Kontrol Tidak Boleh Kosong!!</div>';
                        }else{
                            $tglRencanaKontrol=$_POST['tglRencanaKontrol'];
                            if(empty($_POST['user'])){
                                echo '<div class="text-danger">User Tidak Boleh Kosong!!</div>';
                            }else{
                                $user=$_POST['user'];
                                //Proses kirim
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
                                    array(
                                        "noKartu"=> "$noKartu",
                                        "kodeDokter"=> "$kodeDokter",
                                        "poliKontrol"=> "$poliKontrol",
                                        "tglRencanaKontrol"=>"$tglRencanaKontrol",
                                        "user"=>"$user"
                                    )
                                );
                                
                                $json = json_encode($arr);
                                //Membuat URL
                                $TanggalSekarang=date('Y-m-d');
                                $URLUtama=$url_vclaim;
                                $URLKatalog="RencanaKontrol/InsertSPRI";
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
                                //--konveris json to raw
                                if($code=="200"){
                                    //Menangkap data json menjadi variabel
                                    $noSPRI=$JsonData["noSPRI"];
                                    $tglRencanaKontrol=$JsonData["tglRencanaKontrol"];
                                    $namaDokter=$JsonData["namaDokter"];
                                    $noKartu=$JsonData["noKartu"];
                                    $nama=$JsonData["nama"];
                                    $kelamin=$JsonData["kelamin"];
                                    $tglLahir=$JsonData["tglLahir"];
                                    $namaDiagnosa=$JsonData["namaDiagnosa"];
                                    if(!empty($noSPRI)){
                                        echo '<span class="text-info" id="NotifikasiInsertRencanaKontrolBerhasil">Berhasil</span><br>';
                                        echo '<dt>No.SPRI :</dt>'.$noSPRI.'<br>';
                                        echo '<dt>Tgl Rencana Kontrol :</dt>'.$tglRencanaKontrol.'<br>';
                                        echo '<dt>Nama Dokter :</dt>'.$namaDokter.'<br>';
                                        echo '<dt>Nomor Kartu :</dt>'.$noKartu.'<br>';
                                        echo '<dt>Nama :</dt>'.$nama.'<br>';
                                        echo '<dt>Kelamin :</dt>'.$kelamin.'<br>';
                                        echo '<dt>Tgl.Lahir :</dt>'.$tglLahir.'<br>';
                                        echo '<dt>Nama Diagnosa :</dt>'.$namaDiagnosa.'<br>';
                                    }
                                }else{
                                    echo '<span class="text-danger">Maaf, kirim SPRI gagal!!</span><br>';
                                    echo '<span class="text-danger">Keterangan :'.$message.'<br>';
                                }
                            }
                        }
                    }
                }
            }
        }else{
            if(empty($_POST['noSEP'])){
                echo '<div class="text-danger">Nomor SEP Tidak Boleh Kosong!!</div>';
            }else{
                $noSEP=$_POST['noSEP'];
                if(empty($_POST['poliKontrol'])){
                    echo '<div class="text-danger">Poli Kontrol Tidak Boleh Kosong!!</div>';
                }else{
                    $poliKontrol=$_POST['poliKontrol'];
                    if(empty($_POST['kodeDokter'])){
                        echo '<div class="text-danger">Kode Dokter Tidak Boleh Kosong!!</div>';
                    }else{
                        $kodeDokter=$_POST['kodeDokter'];
                        if(empty($_POST['tglRencanaKontrol'])){
                            echo '<div class="text-danger">Tanggal Rencana Kontrol Tidak Boleh Kosong!!</div>';
                        }else{
                            $tglRencanaKontrol=$_POST['tglRencanaKontrol'];
                            if(empty($_POST['user'])){
                                echo '<div class="text-danger">User Tidak Boleh Kosong!!</div>';
                            }else{
                                $user=$_POST['user'];
                                //Proses kirim
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
                                    array(
                                        "noSEP"=> "$noSEP",
                                        "kodeDokter"=> "$kodeDokter",
                                        "poliKontrol"=> "$poliKontrol",
                                        "tglRencanaKontrol"=>"$tglRencanaKontrol",
                                        "user"=>"$user"
                                    )
                                );
                                
                                $json = json_encode($arr);
                                //Membuat URL
                                $TanggalSekarang=date('Y-m-d');
                                $URLUtama=$url_vclaim;
                                $URLKatalog="RencanaKontrol/insert";
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
                                //--konveris json to raw
                                if($code=="200"){
                                    //Menangkap data json menjadi variabel
                                    $noSuratKontrol=$JsonData["noSuratKontrol"];
                                    $tglRencanaKontrol=$JsonData["tglRencanaKontrol"];
                                    $namaDokter=$JsonData["namaDokter"];
                                    $noKartu=$JsonData["noKartu"];
                                    $nama=$JsonData["nama"];
                                    $kelamin=$JsonData["kelamin"];
                                    $tglLahir=$JsonData["tglLahir"];
                                    if(!empty($string)){
                                        echo '<span class="text-info" id="NotifikasiInsertRencanaKontrolBerhasil">Berhasil</span><br>';
                                        echo '<dt>No.Surat Kontrol :</dt>'.$noSuratKontrol.'<br>';
                                        echo '<dt>Tgl Rencana Kontrol :</dt>'.$tglRencanaKontrol.'<br>';
                                        echo '<dt>Nama Dokter :</dt>'.$namaDokter.'<br>';
                                        echo '<dt>Nomor Kartu :</dt>'.$noKartu.'<br>';
                                        echo '<dt>Nama :</dt>'.$nama.'<br>';
                                        echo '<dt>Kelamin :</dt>'.$kelamin.'<br>';
                                        echo '<dt>Tgl.Lahir :</dt>'.$tglLahir.'<br>';
                                    }
                                }else{
                                    echo '<span class="text-danger">Maaf, kirim Surat kontrol gagal!!</span><br>';
                                    echo '<span class="text-danger">Keterangan :'.$message.'<br>';
                                }
                            }
                        }
                    }
                }
            }
        }
    }
?>