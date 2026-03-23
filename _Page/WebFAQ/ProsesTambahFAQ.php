<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingKoneksiWeb.php";
    include "../../_Page/WebFAQ/FungsiFAQ.php";
    $Url=urlService('Add FAQ');
    $updatetime=date('Y-m-d H:i');
    //Validasi Form Data
    if(empty($_POST['web_pertanyaan'])){
        echo '<span class="text-danger">Pertanyaan FAQ Tidak Boleh Kosong</span>';
    }else{
        if(empty($_POST['web_jawaban'])){
            echo '<span class="text-danger">Jawaban FAQTidak Boleh Kosong</span>';
        }else{
            $web_pertanyaan=$_POST['web_pertanyaan'];
            $web_jawaban=$_POST['web_jawaban'];
            $KirimData = array(
                'api_key' => $api_key,
                'web_pertanyaan' => $web_pertanyaan,
                'web_jawaban' => $web_jawaban
            );
            $json = json_encode($KirimData);
            //Mulai CURL
            $ch = curl_init();
            curl_setopt($ch,CURLOPT_URL, "$Url");
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
                if($code==200){
                    echo '<span class="text-success" id="NotifikasiTambahFAQBerhasil">Success</span>';
                }else{
                    echo '<span class="text-danger">Simpan FAQ gagal<br>Pesan: '.$massage.'<br>URL: '.$Url.'</span>';
                }
            }
        }
    }
?>