<?php
    //Koneksi dan SessionLogin
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    $now=date('Y-m-d H:i');
    if(empty($_POST['x_id_rs'])){
        echo "ID RS Tidak Boleh Kosong";
    }else{
        if(empty($_POST['x_timestamp'])){
            echo "X-Timestamp Tidak Boleh Kosong";
        }else{
            if(empty($_POST['x_pass'])){
                echo "X-Password Tidak Boleh Kosong";
            }else{
                if(empty($_POST['base_url'])){
                    echo "Base URL Tidak Boleh Kosong";
                }else{
                    if(empty($_POST['metode'])){
                        echo "Metode pengiriman data Tidak Boleh Kosong";
                    }else{
                        $x_id_rs=$_POST['x_id_rs'];
                        $x_timestamp=$_POST['x_timestamp'];
                        $x_pass=$_POST['x_pass'];
                        $base_url=$_POST['base_url'];
                        $metode=$_POST['metode'];
                        if(empty($_POST['ContentType'])){
                            $ContentType="";
                        }else{
                            $ContentType=$_POST['ContentType'];
                        }
                        if(empty($_POST['url_direction'])){
                            $url_direction="";
                        }else{
                            $url_direction=$_POST['url_direction'];
                        }
                        if(empty($_POST['body'])){
                            $body="";
                        }else{
                            $body=$_POST['body'];
                        }
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                        CURLOPT_URL => ''.$base_url.'/'.$url_direction.'',
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => ''.$metode.'',
                        CURLOPT_HTTPHEADER => array(
                            'X-rs-id: '.$x_id_rs.'',
                            'X-Timestamp: '.$x_timestamp.'',
                            'X-pass: '.$x_pass.''
                        ),
                        ));
                        $response = curl_exec($curl);
                        curl_close($curl);
                        echo $response;
                    }
                }
            }
        }
    }
?>