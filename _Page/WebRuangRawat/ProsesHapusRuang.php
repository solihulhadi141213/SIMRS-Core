<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingKoneksiWeb.php";
    include "../../_Config/WebFunction.php";
    $url=urlService('Hapus Ruang Rawat');
    //Validasi nama tidak boleh kosong
    if(empty($_POST['ruang_rawat'])){
        echo '<span class="text-danger">Ruang Rawat Tidak Boleh Kosong</span>';
    }else{
        $ruang_rawat=$_POST['ruang_rawat'];     
        //Proses Kirim Data
        $KirimData = array(
            'api_key' => $api_key,
            'ruang_rawat' => $ruang_rawat
        );
        $json = json_encode($KirimData);
        //Mulai CURL
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, "$url");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch,CURLOPT_HEADER, 0);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $content = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        if(!empty($err)){
            echo '<span class="text-danger">'.$err.'</span>';
        }else{
            $JsonData =json_decode($content, true);
            if(!empty($JsonData['metadata']['massage'])){
                $massage=$JsonData['metadata']['massage'];
            }else{
                $massage="";
            }
            if(!empty($JsonData['metadata']['code'])){
                $code=$JsonData['metadata']['code'];
            }else{
                $code="";
            }
            if($code!==200){
                echo '<span class="text-danger">Gagal!! <br> Pesan: '.$massage.'</span>';
            }else{
                echo '<span class="text-success" id="NotifikasiHapusRuangBerhasil">Success</span>';
            }
        }
    }
?>