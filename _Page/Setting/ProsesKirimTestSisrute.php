<?php
    //Koneksi dan SessionLogin
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    $now=date('Y-m-d H:i');
    if(empty($_POST['x_id_rs_sisrute'])){
        echo "ID RS Tidak Boleh Kosong";
    }else{
        if(empty($_POST['x_timestamp_sisrute'])){
            echo "X-Timestamp Tidak Boleh Kosong";
        }else{
            if(empty($_POST['x_pass_sisrute'])){
                echo "X-Password Tidak Boleh Kosong";
            }else{
                if(empty($_POST['base_url_sisrute'])){
                    echo "Base URL Tidak Boleh Kosong";
                }else{
                    if(empty($_POST['metode_sisrute'])){
                        echo "Metode pengiriman data Tidak Boleh Kosong";
                    }else{
                        $x_id_rs_sisrute=$_POST['x_id_rs_sisrute'];
                        $x_timestamp_sisrute=$_POST['x_timestamp_sisrute'];
                        $x_pass_sisrute=$_POST['x_pass_sisrute'];
                        $base_url_sisrute=$_POST['base_url_sisrute'];
                        $metode_sisrute=$_POST['metode_sisrute'];
                        if(empty($_POST['ContentTypeSisrute'])){
                            $ContentTypeSisrute="";
                        }else{
                            $ContentTypeSisrute=$_POST['ContentTypeSisrute'];
                        }
                        if(empty($_POST['url_direction_sisrute'])){
                            $url_direction_sisrute="";
                        }else{
                            $url_direction_sisrute=$_POST['url_direction_sisrute'];
                        }
                        if(empty($_POST['body_sisrute'])){
                            $body_sisrute="";
                        }else{
                            $body_sisrute=$_POST['body_sisrute'];
                        }
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                        CURLOPT_URL => ''.$base_url_sisrute.'/'.$url_direction_sisrute.'',
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => ''.$metode_sisrute.'',
                        CURLOPT_HTTPHEADER => array(
                            'X-rs-id: '.$x_id_rs_sisrute.'',
                            'X-Timestamp: '.$x_timestamp_sisrute.'',
                            'X-pass: '.$x_pass_sisrute.''
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