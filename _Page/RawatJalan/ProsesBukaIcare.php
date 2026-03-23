<?php
    //Zona Waktu
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../vendor/autoload.php";
    date_default_timezone_set('UTC');
    if(empty($_POST['nomor_kartu'])){
        echo "Nomor Kartu Tidak Boleh Kosong";
    }else{
        if(empty($_POST['kode_dokter'])){
            echo "Kode Dokter Tidak Boleh Kosong";
        }else{
            $nomor_kartu=$_POST['nomor_kartu'];
            $kode_dokter=$_POST['kode_dokter'];
            $x_timestamp=strval(time()-strtotime('1970-01-01 00:00:00'));
            $x_cons_id=getDataDetail($Conn,'bridging','status','Aktiv','consid');
            $user_key=getDataDetail($Conn,'bridging','status','Aktiv','user_key');
            $secret_key=getDataDetail($Conn,'bridging','status','Aktiv','secret_key');
            $signature=hash_hmac('sha256', $x_cons_id."&".$x_timestamp, $secret_key, true);
            $x_signature = base64_encode($signature);
            $url_icare=getDataDetail($Conn,'bridging','status','Aktiv','url_icare');
            if(empty($x_cons_id)){
                echo "Cons ID Bellum Diatur";
            }else{
                if(empty($user_key)){
                    echo "User Key Belum Diatur";
                }else{
                    if(empty($secret_key)){
                        echo "Secret Key Belum Diatur";
                    }else{
                        if(empty($x_signature)){
                            echo "x_signature Belum Diatur";
                        }else{
                            if(empty($url_icare)){
                                echo "url icare Belum Diatur";
                            }else{
                                //Kirim Data
                                $curl = curl_init();
                                curl_setopt_array($curl, array(
                                CURLOPT_URL => ''.$url_icare.'',
                                CURLOPT_SSL_VERIFYPEER => false,
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_HEADER => 0,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS =>'{
                                    "param": "'.$nomor_kartu.'",
                                    "kodedokter": '.$kode_dokter.'
                                }',
                                CURLOPT_HTTPHEADER => array(
                                    'X-signature: '.$x_signature.'',
                                    'X-timestamp: '.$x_timestamp.'',
                                    'X-cons-id: '.$x_cons_id.'',
                                    'user_key: '.$user_key.'',
                                    'Content-Type: application/json'
                                ),
                                ));
                                $response = curl_exec($curl);
                                $data = json_decode($response, true);
                                curl_close($curl);
                                echo '<div class="row mb-3">';
                                echo '  <div class="col-md-12">';
                                echo '      <span>Data Yang Dikirim (Request)</span>';
                                echo '      <ol>';
                                echo '          <li>URL : <code class="text text-secondary">'.$url_icare.'</code></li>';
                                echo '          <li>Nomor Kartu : <code class="text text-secondary">'.$nomor_kartu.'</code></li>';
                                echo '          <li>Kode Dokter : <code class="text text-secondary">'.$kode_dokter.'</code></li>';
                                echo '          <li>X-signature : <code class="text text-secondary">'.$x_signature.'</code></li>';
                                echo '          <li>X-timestamp : <code class="text text-secondary">'.$x_timestamp.'</code></li>';
                                echo '          <li>X-cons-id : <code class="text text-secondary">'.$x_cons_id.'</code></li>';
                                echo '          <li>User Key : <code class="text text-secondary">'.$user_key.'</code></li>';
                                echo '      </ol>';
                                echo '  </div>';
                                echo '</div>';
                                echo '<div class="row mb-3">';
                                echo '  <div class="col-md-12">';
                                echo '      <span>Data Yang Diterima (Response)</span>';
                                //Apabila Data Dalam Bentuk JSON
                                if (json_last_error() === JSON_ERROR_NONE) {
                                    //Proses decode dan dekompresi
                                    $ambil_json =json_decode($response, true);
                                    $string=$ambil_json["response"];
                                    $metaData=$ambil_json["metaData"];
                                    $code=$metaData["code"];
                                    $message=$metaData["message"];
                                    //Apabila Response Null
                                    if($string==null){
                                        echo '<ol>';
                                        echo '  <li>Code : <code>'.$code.'</code></li>';
                                        echo '  <li>Message : <code>'.$message.'</code></li>';
                                        echo '</ol>';
                                    }else{
                                        //--membuat key
                                        $key="$x_cons_id$secret_key$x_timestamp";
                                        //--masukan ke fungsi
                                        $FileDeskripsi=stringDecrypt("$key", "$string");
                                        $FileDekompresi=decompress("$FileDeskripsi");
                                        echo '<ol>';
                                        echo '  <li>Code : <code class="text text-secondary">'.$code.'</code></li>';
                                        echo '  <li>Message : <code class="text text-secondary">'.$message.'</code></li>';
                                        echo '  <li>String/Response : <code class="text text-secondary">'.$string.'</code></li>';
                                        echo '  <li>Dekompresi : <code class="text text-secondary">'.$FileDekompresi.'</code></li>';
                                        $ambil_json =json_decode($FileDekompresi, true);
                                        if(!empty($ambil_json['url'])){
                                            $url=$ambil_json['url'];
                                            echo '  <li>';
                                            echo '      URL/Link : <code class="text text-success"><a href="'.$url.'" class="text-success" target="_blank">'.$url.'</a></code>';
                                            echo '  </li>';
                                        }
                                        echo '</ol>';
                                    }
                                }else{
                                    //Apabila Data Bukan JSOn maka langsung tampilkan saja
                                    echo ''.$response.'';
                                }
                                echo '  </div>';
                                echo '</div>';
                            }
                        }
                    }
                }
            }
        }
    }
?>
