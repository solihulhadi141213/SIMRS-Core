<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingKoneksiWeb.php";
    include "../../_Config/WebFunction.php";
    $Url=urlService('Edit Arsip');
    $updatetime=date('Y-m-d H:i');
    //Validasi Form Data
    if(empty($_POST['id_arsip'])){
        echo '<span class="text-danger">ID Arsip Tidak Boleh Kosong</span>';
    }else{
        if(empty($_POST['judul'])){
            echo '<span class="text-danger">Judul Arsip Tidak Boleh Kosong</span>';
        }else{
            if(empty($_POST['tanggal'])){
                echo '<span class="text-danger">Tanggal Arsip Boleh Kosong</span>';
            }else{
                if(empty($_POST['kategori'])){
                    echo '<span class="text-danger">Kategori Arsip Boleh Kosong</span>';
                }else{
                    if(empty($_POST['deskripsi'])){
                        echo '<span class="text-danger">Deskripsi Arsip Boleh Kosong</span>';
                    }else{
                        if(empty($_POST['status'])){
                            echo '<span class="text-danger">Status Arsip Boleh Kosong</span>';
                        }else{
                            $id_arsip=$_POST['id_arsip'];
                            $judul=$_POST['judul'];
                            $tanggal=$_POST['tanggal'];
                            $kategori=$_POST['kategori'];
                            $deskripsi=$_POST['deskripsi'];
                            $status=$_POST['status'];
                            if(empty($_FILES['file_arsip']['name'])){
                                $ValidasiGambar="Valid";
                                $hex_string="";
                                $Ext="";
                                $tipe_gambar="";
                                $nama_gambar="";
                                $tipe_gambar="";
                            }else{
                                //Validasi Tipe File
                                $nama_gambar = $_FILES['file_arsip']['name']; 
                                $tipe_gambar = $_FILES['file_arsip']['type']; 
                                //ukuran gambar
                                $ukuran_gambar = $_FILES['file_arsip']['size']; 
                                //Ukurn Maksiman 1mb
                                $UkuranMaksimal=2000*1000;
                                //Konversi Ke Base64
                                $TmpFile=$_FILES['file_arsip']['tmp_name'];
                                $bin_string = file_get_contents($TmpFile);
                                $hex_string = base64_encode($bin_string);
                                //Mencari extension file
                                $Pecah = explode("." , $nama_gambar);
                                $BiasanyaNama=$Pecah[0];
                                $Ext=$Pecah[1];
                                //Validasi Ukuran File
                                if($ukuran_gambar>$UkuranMaksimal){
                                    $ValidasiGambar="Untuk ukuran file sebaiknya tidak lebih dari 2 Mb";
                                }else{
                                    //Validasi Tipe File
                                    if($tipe_gambar=="image/jpeg"||$tipe_gambar=="image/jpg"||$tipe_gambar== "image/gif" || $tipe_gambar == "image/png"|| $tipe_gambar == "application/pdf"){
                                        $ValidasiGambar="Valid";
                                    }else{
                                        $ValidasiGambar="File arsip hanya boleh berformat pdf, jpg, jpg, gif atau png";
                                    }
                                }
                            }
                            if($ValidasiGambar!=="Valid"){
                                echo '<span class="text-danger">('.$tipe_gambar.') '.$ValidasiGambar.'</span>';
                            }else{
                                $KirimData = array(
                                    'api_key' => $api_key,
                                    'id_arsip' => $id_arsip,
                                    'judul' => $judul,
                                    'tanggal' => $tanggal,
                                    'kategori' => $kategori,
                                    'deskripsi' => $deskripsi,
                                    'sumber' => "Internal",
                                    'file_base64' => $hex_string,
                                    'file_ext' => $Ext,
                                    'file_format' => $tipe_gambar,
                                    'status' => $status
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
                                        echo '<span class="text-success" id="NotifikasiEditArsipBerhasil">Success</span>';
                                    }else{
                                        echo '<span class="text-danger">'.$massage.'</span>';
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
?>