<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../vendor/autoload.php";
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $now=date('Y-m-d H:i:s');
    //Menangkap Variabel
    if(empty($_POST['tipe_koneksi'])){
        $tipe_koneksi="";
    }else{
        $tipe_koneksi=$_POST['tipe_koneksi'];
    }
    if(empty($_POST['consid'])){
        $consid="";
    }else{
        $consid=$_POST['consid'];
    }
    if(empty($_POST['cons_id_antrol'])){
        $cons_id_antrol="";
    }else{
        $cons_id_antrol=$_POST['cons_id_antrol'];
    }
    if(empty($_POST['user_key'])){
        $user_key="";
    }else{
        $user_key=$_POST['user_key'];
    }
    if(empty($_POST['user_key_antrol'])){
        $user_key_antrol="";
    }else{
        $user_key_antrol=$_POST['user_key_antrol'];
    }
    if(empty($_POST['secret_key'])){
        $secret_key="";
    }else{
        $secret_key=$_POST['secret_key'];
    }
    if(empty($_POST['secret_key_antrol'])){
        $secret_key_antrol="";
    }else{
        $secret_key_antrol=$_POST['secret_key_antrol'];
    }
    if(empty($_POST['kode_ppk'])){
        $kode_ppk="";
    }else{
        $kode_ppk=$_POST['kode_ppk'];
    }
    if(empty($_POST['url_vclaim'])){
        $url_vclaim="";
    }else{
        $url_vclaim=$_POST['url_vclaim'];
    }
    if(empty($_POST['url_aplicare'])){
        $url_aplicare="";
    }else{
        $url_aplicare=$_POST['url_aplicare'];
    }
    if(empty($_POST['url_antrol'])){
        $url_antrol="";
    }else{
        $url_antrol=$_POST['url_antrol'];
    }
    if(empty($_POST['url_faskes'])){
        $url_faskes="";
    }else{
        $url_faskes=$_POST['url_faskes'];
    }
    if(empty($_POST['kategori_ppk'])){
        $kategori_ppk="";
    }else{
        $kategori_ppk=$_POST['kategori_ppk'];
    }
    if($tipe_koneksi=="Aplicare (Ketersediaan Kamar)"){
        $response=referensiAplicare($url_aplicare,$kode_ppk,$consid,$secret_key,$user_key);
        echo '<textarea class="form-control" rows="5">'.$response.'</textarea>';
    }else{
        if($tipe_koneksi=="Vclaim (Referensi Provinsi)"){
            $response=referensiProvinsi($url_vclaim,$kode_ppk,$consid,$secret_key,$user_key);
            if(!empty($response)){
                if(!empty(json_decode($response, true))){
                    $ambil_json =json_decode($response, true);
                    $string=$ambil_json["response"];
                    $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
                    $key="$consid$secret_key$timestamp";
                    $FileDeskripsi=stringDecrypt("$key", "$string");
                    $FileDekompresi=decompress("$FileDeskripsi");
                    echo '<textarea class="form-control" rows="5">'.$response.'</textarea><br>';
                    echo '<textarea class="form-control" rows="5">'.$FileDekompresi.'</textarea>';
                }else{
                    echo $response;
                }
            }
        }else{
            if($tipe_koneksi=="PCare (Referensi Dokter)"){
                $response=referensiDokterPcare($url_vclaim,$kode_ppk,$consid,$secret_key,$user_key);
                if(!empty($response)){
                    if(!empty(json_decode($response, true))){
                        $ambil_json =json_decode($response, true);
                        $string=$ambil_json["response"];
                        $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
                        $key="$consid$secret_key$timestamp";
                        $FileDeskripsi=stringDecrypt("$key", "$string");
                        $FileDekompresi=decompress("$FileDeskripsi");
                        echo '<textarea class="form-control" rows="5">'.$response.'</textarea><br>';
                        echo '<textarea class="form-control" rows="5">'.$FileDekompresi.'</textarea>';
                    }else{
                        echo $response;
                    }
                }else{
                    echo $response;
                    echo $url_vclaim;
                }
            }
        }
    }

?>
