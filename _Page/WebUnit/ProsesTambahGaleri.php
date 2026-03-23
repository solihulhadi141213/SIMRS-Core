<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingKoneksiWeb.php";
    include "../../_Config/WebFunction.php";
    $Url=urlService('Add Galeri');
    $tanggal_galeri=date('Y-m-d H:i');
    //Validasi Form Data
    if(empty($_POST['id_unit_instalasi'])){
        echo '<small class="text-danger">ID Web Event Tidak Boleh Kosong</small>';
    }else{
        if(empty($_POST['judul_galeri'])){
            echo '<small class="text-danger">Judul Galeri Tidak Boleh Kosong</small>';
        }else{
            if(empty($_POST['deskripsi_galeri'])){
                echo '<small class="text-danger">Deskripsi Galeri Tidak Boleh Kosong</small>';
            }else{
                if(empty($_FILES['file_galeri']['name'])){
                    echo '<small class="text-danger">File Tidak Boleh Kosong</small>';
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
                        echo '<small class="text-danger">'.$ValidasiGambar.'</small>';
                    }else{
                        //Validasi Tipe File
                        if($tipe_gambar=="image/jpeg"||$tipe_gambar=="image/jpg"||$tipe_gambar== "image/gif" || $tipe_gambar == "image/png"){
                            $ValidasiGambar="Valid";
                        }else{
                            $ValidasiGambar="File hanya boleh berformat jpg, jpg, gif atau png";
                        }
                        if($ValidasiGambar!=="Valid"){
                            echo '<small class="text-danger">'.$ValidasiGambar.'</small>';
                        }else{
                            $id_unit_instalasi=$_POST['id_unit_instalasi'];
                            $judul_galeri=$_POST['judul_galeri'];
                            $deskripsi_galeri=$_POST['deskripsi_galeri'];
                            $KirimData = array(
                                'api_key' => $api_key,
                                'id_web_event' => "0",
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
                                    $_SESSION['NotifikasiSwal']="Tambah Galeri Berhasil";
                                    echo '<small class="text-success" id="NotifikasiTambahGaleriBerhasil">Success</small>';
                                }else{
                                    echo '<small class="text-danger">'.$massage.'</small>';
                                }
                            }
                        }
                    }
                }
            }
        }
    }
?>