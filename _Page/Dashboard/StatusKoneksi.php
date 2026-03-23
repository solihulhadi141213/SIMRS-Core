<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/WebFunction.php";
    include "../../_Config/SettingBridging.php";
    include "../../vendor/autoload.php";
    if(!empty($_POST['KategoriKoneksi'])){
        $KategoriKoneksi=$_POST['KategoriKoneksi'];
        if($KategoriKoneksi=="Satu Sehat"){
            $Token=GenerateTokenSatuSehat2($Conn);
            if(!empty($Token)){
                echo '<span class="text-success">Connected</span>';
            }else{
                echo '<span class="text-danger">No Connection</span>';
            }
        }else{
            if($KategoriKoneksi=="Bridging BPJS"){
                date_default_timezone_set('UTC');
                $JenisFaskes="2";
                $keyword="El-Syifa";
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
                $URLKatalog="referensi/faskes/$keyword/$JenisFaskes";
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
                if(empty($content)){
                    echo '<span class="text-danger">Content Null</span>';
                }else{
                    $ambil_json =json_decode($content, true);
                    if(empty($ambil_json["response"])){
                        echo '<span class="text-danger">No Response</span>';
                        echo '<span class="text-danger">'.$content.'</span>';
                    }else{
                        $string=$ambil_json["response"];
                        $key="$consid$secret_key$timestamp";
                        if(empty(stringDecrypt("$key", "$string"))){
                            echo '<span class="text-danger">Error Decrypt</span>';
                        }else{
                            $FileDeskripsi=stringDecrypt("$key", "$string");
                            if(empty(decompress("$FileDeskripsi"))){
                                echo '<span class="text-danger">Error Decompress</span>';
                            }else{
                                $FileDekompresi=decompress("$FileDeskripsi");
                                if(empty(json_decode($FileDekompresi, true))){
                                    echo '<span class="text-danger">Error JSON Decode</span>';
                                }else{
                                    $JsonData =json_decode($FileDekompresi, true);
                                    if(empty($JsonData['faskes'])){
                                        echo '<span class="text-danger">No Connection</span>';
                                    }else{
                                        $list=$JsonData['faskes'];
                                        if(empty(count($list))){
                                            echo '<span class="text-danger">No Connection</span>';
                                        }else{
                                            echo '<span class="text-success">Connected</span>';
                                        }
                                    }
                                }
                            }
                        }
                    }
                    
                }
            }else{
                if($KategoriKoneksi=="Website"){
                    echo '<span class="text-success">Connected</span>';
                }else{
                    echo '<span class="text-danger">No Connection</span>';
                }
            }
        }
    }else{
        echo '<span class="text-danger">No Connection</span>';
    }
?>