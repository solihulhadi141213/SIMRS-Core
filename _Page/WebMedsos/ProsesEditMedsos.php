<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingKoneksiWeb.php";
    include "../../_Config/WebFunction.php";
    $Url=urlService('Edit Medsos');
    $updatetime=date('Y-m-d H:i');
    //Validasi Form Data
    if(empty($_POST['id_web_medsos'])){
        echo '<span class="text-danger">ID Medsos Tidak Boleh Kosong</span>';
    }else{
        if(empty($_POST['nama_medsos'])){
            echo '<span class="text-danger">Nama Medsos Tidak Boleh Kosong</span>';
        }else{
            if(empty($_POST['url_medsos'])){
                echo '<span class="text-danger">URL MedsosTidak Boleh Kosong</span>';
            }else{
                if(empty($_FILES['img_medsos']['name'])){
                    $ValidasiGambar="Valid";
                    $hex_string="";
                }else{
                    //Validasi Tipe File
                    $tipe_gambar = $_FILES['img_medsos']['type']; 
                    //ukuran gambar
                    $ukuran_gambar = $_FILES['img_medsos']['size']; 
                    //Ukurn Maksiman 1mb
                    $UkuranMaksimal=2000*1000;
                    //Konversi Ke Base64
                    $TmpFile=$_FILES['img_medsos']['tmp_name'];
                    $bin_string = file_get_contents($TmpFile);
                    $hex_string = base64_encode($bin_string);
                    //Validasi Ukuran File
                    if($ukuran_gambar>$UkuranMaksimal){
                        $ValidasiGambar="Untuk slider sebaiknya tidak lebih dari 2 Mb";
                    }else{
                        //Validasi Tipe File
                        if($tipe_gambar=="image/jpeg"||$tipe_gambar=="image/jpg"||$tipe_gambar== "image/gif" || $tipe_gambar == "image/png"){
                            $ValidasiGambar="Valid";
                        }else{
                            $ValidasiGambar="logo hanya boleh berformat jpg, jpg, gif atau png";
                        }
                    }
                }
                if($ValidasiGambar!=="Valid"){
                    echo '<span class="text-danger">'.$ValidasiGambar.'</span>';
                }else{
                    $id_web_medsos=$_POST['id_web_medsos'];
                    $nama_medsos=$_POST['nama_medsos'];
                    $url_medsos=$_POST['url_medsos'];
                    $KirimData = array(
                        'api_key' => $api_key,
                        'id_web_medsos' => $id_web_medsos,
                        'nama_medsos' => $nama_medsos,
                        'url_medsos' => $url_medsos,
                        'icon_medsos' => "",
                        'img_medsos' => $hex_string
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
                            echo '<span class="text-success" id="NotifikasiEditMedsosBerhasil">Success</span>';
                        }else{
                            echo '<span class="text-danger">'.$content.'</span>';
                        }
                    }
                }
            }
        }
    }
?>