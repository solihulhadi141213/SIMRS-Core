<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingKoneksiWeb.php";
    include "../../_Config/WebFunction.php";
    $Url=urlService('Edit Galeri');
    $tanggal_galeri=date('Y-m-d H:i');
    //Validasi Form Data
    if(empty($_POST['id_web_galeri'])){
        echo '<small class="text-danger">ID Web Galeri Tidak Boleh Kosong</small>';
    }else{
        if(empty($_POST['judul_galeri'])){
            echo '<small class="text-danger">Judul Galeri Tidak Boleh Kosong</small>';
        }else{
            if(empty($_POST['deskripsi_galeri'])){
                echo '<small class="text-danger">Deskripsi Galeri Tidak Boleh Kosong</small>';
            }else{
                if(empty($_POST['id_web_event'])){
                    $id_web_event="0";
                }else{
                    $id_web_event=$_POST['id_web_event'];
                }
                if(empty($_POST['id_unit_instalasi'])){
                    $id_unit_instalasi="0";
                }else{
                    $id_unit_instalasi=$_POST['id_unit_instalasi'];
                }
                $id_web_galeri=$_POST['id_web_galeri'];
                $judul_galeri=$_POST['judul_galeri'];
                $deskripsi_galeri=$_POST['deskripsi_galeri'];
                if(empty($_FILES['file_galeri']['name'])){
                    $ValidasiGambar="Valid";
                    $hex_string="";
                    $Ext="";
                    $tipe_gambar="";
                }else{
                    //nama gambar
                    $nama_gambar=$_FILES['file_galeri']['name'];
                    //Validasi Tipe File
                    $tipe_gambar = $_FILES['file_galeri']['type']; 
                    //ukuran gambar
                    $ukuran_gambar = $_FILES['file_galeri']['size']; 
                    //Ukurn Maksiman 1mb
                    $UkuranMaksimal=2000*1000;
                    //Konversi Ke Base64
                    $TmpFile=$_FILES['file_galeri']['tmp_name'];
                    $bin_string = file_get_contents($TmpFile);
                    $hex_string = base64_encode($bin_string);
                    //Mencari extension file
                    $Pecah = explode("." , $nama_gambar);
                    $BiasanyaNama=$Pecah[0];
                    $Ext=$Pecah[1];
                    //Validasi Ukuran File
                    if($ukuran_gambar>$UkuranMaksimal){
                        $ValidasiGambar="Ukuran file tidak lebih dari 2 Mb";
                    }else{
                        //Validasi Tipe File
                        if($tipe_gambar=="image/jpeg"||$tipe_gambar=="image/jpg"||$tipe_gambar== "image/gif" || $tipe_gambar == "image/png"){
                            $ValidasiGambar="Valid";
                        }else{
                            $ValidasiGambar="File hanya boleh berformat jpg, jpg, gif atau png";
                        }
                    }
                }
                if($ValidasiGambar!=="Valid"){
                    echo '<small class="text-danger">'.$ValidasiGambar.'</small>';
                }else{
                    $KirimData = array(
                        'api_key' => $api_key,
                        'id_web_galeri' => $id_web_galeri,
                        'id_web_event' => $id_web_event,
                        'id_unit_instalasi' => $id_unit_instalasi,
                        'judul_galeri' => $judul_galeri,
                        'deskripsi_galeri' => $deskripsi_galeri,
                        'tanggal_galeri' => $tanggal_galeri,
                        'file_format' => $tipe_gambar,
                        'file_ext' => $Ext,
                        'file_base64' => $hex_string
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
                            $_SESSION['NotifikasiSwal']="Edit Galeri Berhasil";
                            echo '<small class="text-success" id="NotifikasiEditGaleriBerhasil">Success</small>';
                        }else{
                            echo '<small class="text-danger">'.$massage.'</small>';
                        }
                    }
                }
            }
        }
    }
?>