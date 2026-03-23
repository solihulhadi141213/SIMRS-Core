<?php
    //Zona Waktu
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../vendor/autoload.php";
    if(empty($_POST['nomor_kartu'])){
        echo "Nomor Kartu Tidak Boleh Kosong";
    }else{
        if(empty($_POST['kode_dokter'])){
            echo "Kode Dokter Tidak Boleh Kosong";
        }else{
            if(empty($_POST['x_timestamp'])){
                echo "X Time  Tidak Boleh Kosong";
            }else{
                if(empty($_POST['x_signature'])){
                    echo "Signature  Tidak Boleh Kosong";
                }else{
                    if(empty($_POST['url_icare'])){
                        echo "URL  Tidak Boleh Kosong";
                    }else{
                        if(empty($_POST['nomor_kartu'])){
                            echo "URL  Tidak Boleh Kosong";
                        }else{
                            if(empty($_POST['x_cons_id'])){
                                echo "Cons ID  Tidak Boleh Kosong";
                            }else{
                                if(empty($_POST['secret_key'])){
                                    echo "secret_key  Tidak Boleh Kosong";
                                }else{
                                    if(empty($_POST['user_key'])){
                                        echo "user_key  Tidak Boleh Kosong";
                                    }else{
                                        $nomor_kartu=$_POST['nomor_kartu'];
                                        $kode_dokter=$_POST['kode_dokter'];
                                        $x_signature=$_POST['x_signature'];
                                        $x_timestamp=$_POST['x_timestamp'];
                                        $x_cons_id=$_POST['x_cons_id'];
                                        $user_key=$_POST['user_key'];
                                        $secret_key=$_POST['secret_key'];
                                        // $KirimData = array(
                                        //     'param' => "$nomor_kartu",
                                        //     'kodedokter' => $kode_dokter
                                        // );
                                        // $url="https://apijkn.bpjs-kesehatan.go.id/wsihs/api/rs/validate";
                                        // $JsonEncode = json_encode($KirimData);
                                        // $response=iCare($url,$JsonEncode,$x_signature,$x_timestamp,$x_cons_id,$user_key);
                                        
                                        $curl = curl_init();
                                        curl_setopt_array($curl, array(
                                        CURLOPT_URL => 'https://apijkn.bpjs-kesehatan.go.id/wsihs/api/rs/validate',
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

                                        curl_close($curl);

                                        echo '<div class="row mb-3">';
                                        echo '  <div class="col-md-12">';
                                        echo '      <dt>Response: </dt>';
                                        echo '      <textarea class="form-control">'.$response.'</textarea>';
                                        echo '  </div>';
                                        echo '</div>';
                                        //Proses decode dan dekompresi
                                        $ambil_json =json_decode($response, true);
                                        $string=$ambil_json["response"];
                                        //--membuat key
                                        $key="$x_cons_id$secret_key$x_timestamp";
                                        //--masukan ke fungsi
                                        $FileDeskripsi=stringDecrypt("$key", "$string");
                                        $FileDekompresi=decompress("$FileDeskripsi");
                                        //--konveris json to raw
                                        // $JsonData =json_decode($FileDekompresi, true);
                                        echo '<div class="row mb-3">';
                                        echo '  <div class="col-md-12">';
                                        echo '      <dt>Dekompress: </dt>';
                                        echo '      <textarea class="form-control">'.$FileDekompresi.'</textarea>';
                                        echo '  </div>';
                                        echo '</div>';
                                        $ambil_json =json_decode($FileDekompresi, true);
                                        $url=$ambil_json['url'];
                                        echo '<div class="row mb-3">';
                                        echo '  <div class="col-md-12">';
                                        echo '      <a href="'.$url.'" class="btn btn-md btn-block btn-outline-info">Go To iCare</a>';
                                        echo '  </div>';
                                        echo '</div>';
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    
?>