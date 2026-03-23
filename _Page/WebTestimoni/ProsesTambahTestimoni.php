<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingKoneksiWeb.php";
    include "../../_Config/WebFunction.php";
    $Url=urlService('Add Testimoni');
    $tanggal_galeri=date('Y-m-d H:i');
    //Validasi Form Data
    if(empty($_POST['tanggal'])){
        echo '<small class="text-danger">Tanggal Tidak Boleh Kosong</small>';
    }else{
        if(empty($_POST['jam'])){
            echo '<small class="text-danger">Jam Tidak Boleh Kosong</small>';
        }else{
            if(empty($_POST['nama_testimoni'])){
                echo '<small class="text-danger">Nama Pengirim Tidak Boleh Kosong</small>';
            }else{
                if(empty($_POST['email'])){
                    echo '<small class="text-danger">Email Pengirim Tidak Boleh Kosong</small>';
                }else{
                    if(empty($_POST['isi_testimoni'])){
                        echo '<small class="text-danger">Isi Testimoni Tidak Boleh Kosong</small>';
                    }else{
                        if(empty($_POST['status_testimoni'])){
                            echo '<small class="text-danger">Status Testimoni Tidak Boleh Kosong</small>';
                        }else{
                            if(empty($_FILES['image_testimoni']['name'])){
                                echo '<small class="text-danger">File Tidak Boleh Kosong</small>';
                            }else{
                                //nama gambar
                                $nama_gambar=$_FILES['image_testimoni']['name'];
                                //Validasi Tipe File
                                $tipe_gambar = $_FILES['image_testimoni']['type']; 
                                //ukuran gambar
                                $ukuran_gambar = $_FILES['image_testimoni']['size']; 
                                //Ukurn Maksiman 1mb
                                $UkuranMaksimal=2000*1000;
                                //Konversi Ke Base64
                                $TmpFile=$_FILES['image_testimoni']['tmp_name'];
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
                                        //Buatkan Variabel
                                        $tanggal=$_POST['tanggal'];
                                        $jam=$_POST['jam'];
                                        $tanggal_testimoni="$tanggal $jam";
                                        $nama_testimoni=$_POST['nama_testimoni'];
                                        $email=$_POST['email'];
                                        $isi_testimoni=$_POST['isi_testimoni'];
                                        $status_testimoni=$_POST['status_testimoni'];
                                        $KirimData = array(
                                            'api_key' => $api_key,
                                            'tanggal_testimoni' => $tanggal_testimoni,
                                            'nama_testimoni' => $nama_testimoni,
                                            'email' => $email,
                                            'isi_testimoni' => $isi_testimoni,
                                            'status_testimoni' => $status_testimoni,
                                            'image_testimoni' => $hex_string
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
                                                echo '<small class="text-success" id="NotifikasiTambahTestimoniBerhasil">Success</small>';
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
            }
        }
    }
?>