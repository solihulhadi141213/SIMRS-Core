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
                $x_id_rs_sisrute=$_POST['x_id_rs_sisrute'];
                $x_timestamp_sisrute=$_POST['x_timestamp_sisrute'];
                $x_pass_sisrute=$_POST['x_pass_sisrute'];
                $pass = hash('sha256', $x_id_rs_sisrute . $x_pass_sisrute);
                $key = $x_id_rs_sisrute."&".$x_timestamp_sisrute;					
                $signature = base64_encode(hash_hmac("sha256", utf8_encode($key), utf8_encode($pass), true));
                echo "$signature";
            }
        }
    }
?>