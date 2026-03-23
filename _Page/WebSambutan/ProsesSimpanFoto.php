<?php
    //Mengambil data sambutan dari service
    session_start();
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SettingKoneksiWeb.php";
    include "../../_Config/WebFunction.php";
    if(empty($_FILES['foto']['name'])){
        echo '<small class="text-danger">Foto Tidak Boleh Kosong</small>';
    }else{
        $UrlSambutan=getServiceUrl2("Detail Sambutan");
        $UrlSimpanSambutan=getServiceUrl2("Simpan Sambutan");
        //Menentukan url dari setting
        if(!empty($api_key)&&!empty($UrlSambutan)){
            //Akses Data Dari Server Website
            $KirimData = array(
                'api_key' => $api_key,
            );
            $json = json_encode($KirimData);
            //Mulai CURL
            $ch = curl_init();
            curl_setopt($ch,CURLOPT_URL, "$UrlSambutan");
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
                echo '<small class="text-danger">'.$err.'</small>';
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
                if(!empty($JsonData['response']['id_web_sambutan'])){
                    $id_web_sambutan=$JsonData['response']['id_web_sambutan'];
                }else{
                    $id_web_sambutan="";
                }
                if(!empty($JsonData['response']['judul_sambutan'])){
                    $judul_sambutan=$JsonData['response']['judul_sambutan'];
                }else{
                    $judul_sambutan="";
                }
                if(!empty($JsonData['response']['nama'])){
                    $nama=$JsonData['response']['nama'];
                }else{
                    $nama="";
                }
                if(!empty($JsonData['response']['jabatan'])){
                    $jabatan=$JsonData['response']['jabatan'];
                }else{
                    $jabatan="";
                }
                if(!empty($JsonData['response']['isi_sambutan'])){
                    $isi_sambutan=$JsonData['response']['isi_sambutan'];
                }else{
                    $isi_sambutan="";
                }
                if(!empty($JsonData['response']['foto'])){
                    $foto=$JsonData['response']['foto'];
                }else{
                    $foto="";
                }
                //Apabila response berhasil
                if($code!==200){
                    echo '<small class="text-danger">'.$massage.'</small>';
                }else{
                    //Validasi Tipe File
                    $tipe_gambar = $_FILES['foto']['type']; 
                    //ukuran gambar
                    $ukuran_gambar = $_FILES['foto']['size']; 
                    //Ukurn Maksiman 1mb
                    $UkuranMaksimal=2000*1000;
                    //Konversi Ke Base64
                    $TmpFile=$_FILES['foto']['tmp_name'];
                    $bin_string = file_get_contents($TmpFile);
                    $hex_string = base64_encode($bin_string);
                    //Validasi Ukuran File
                    if($ukuran_gambar>$UkuranMaksimal){
                        $ValidasiGambar="Untuk slider sebaiknya tidak lebih dari 2 Mb";
                        echo '<small class="text-danger">'.$ValidasiGambar.'</small>';
                    }else{
                        //Validasi Tipe File
                        if($tipe_gambar=="image/jpeg"||$tipe_gambar=="image/jpg"||$tipe_gambar== "image/gif" || $tipe_gambar == "image/png"){
                            $ValidasiGambar="Valid";
                        }else{
                            $ValidasiGambar="logo hanya boleh berformat jpg, jpg, gif atau png";
                        }
                        if($ValidasiGambar!=="Valid"){
                            echo '<span class="text-danger">'.$ValidasiGambar.'</span>';
                        }else{
                            $KirimData = array(
                                'api_key' => $api_key,
                                'judul_sambutan' => $judul_sambutan,
                                'nama' => $nama,
                                'jabatan' => "$jabatan",
                                'isi_sambutan' => "$isi_sambutan",
                                'foto' => $hex_string
                            );
                            $json = json_encode($KirimData);
                            //Mulai CURL
                            $ch = curl_init();
                            curl_setopt($ch,CURLOPT_URL, "$UrlSimpanSambutan");
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
                                echo '<small class="text-danger">'.$err.'</small>';
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
                                    $_SESSION['NotifikasiSwal']="Simpan Foto Sambutan Berhasil";
                                    echo '<span class="text-success" id="NotifikasiSimpanFotoBerhasil">Success</span>';
                                }else{
                                    echo '<span class="text-danger">'.$massage.'</span>';
                                }
                            }
                        }
                    }
                }
            }
        }else{
            echo '<small class="text-danger">Terjadi kesalahan koneksi web</small>';
        }
    }
?>