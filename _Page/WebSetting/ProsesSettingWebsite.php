<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    //Setting koneksi (API key) & Referensi URL
    include "../../_Config/SettingKoneksiWeb.php";
    //Url Service
    $NamaService="Update Informasi Website";
    $QryService = mysqli_query($Conn,"SELECT * FROM setting_service WHERE service_name='$NamaService'")or die(mysqli_error($Conn));
    $DataService = mysqli_fetch_array($QryService);
    if(!empty($DataService['url_service'])){
        $ServiceUrl= $DataService['url_service'];
    }else{
        $ServiceUrl="";
    }
    $updatetime=date('Y-m-d H:i');
    //Validasi web_title tidak boleh kosong
    if(empty($_POST['web_title'])){
        echo '<span class="text-danger">Judul Web Tidak Boleh Kosong</span>';
    }else{
        //Validasi web_deskripsi tidak boleh kosong
        if(empty($_POST['web_deskripsi'])){
            echo '<span class="text-danger">Deskripsi Web Tidak Boleh Kosong</span>';
        }else{
            //Validasi web_keywords tidak boleh kosong
            if(empty($_POST['web_keywords'])){
                echo '<span class="text-danger">Keyword Web Tidak Boleh Kosong</span>';
            }else{
                //Validasi web_author tidak boleh kosong
                if(empty($_POST['web_author'])){
                    echo '<span class="text-danger">Author Web Tidak Boleh Kosong</span>';
                }else{
                    //Validasi web_kontak tidak boleh kosong
                    if(empty($_POST['web_kontak'])){
                        echo '<span class="text-danger">Kontak Web Tidak Boleh Kosong</span>';
                    }else{
                        //Validasi web_email tidak boleh kosong
                        if(empty($_POST['web_email'])){
                            echo '<span class="text-danger">Email Web Tidak Boleh Kosong</span>';
                        }else{
                            //Validasi web_alamat tidak boleh kosong
                            if(empty($_POST['web_alamat'])){
                                echo '<span class="text-danger">Alamat Web Tidak Boleh Kosong</span>';
                            }else{
                                //Validasi web_waktu_operasional tidak boleh kosong
                                if(empty($_POST['web_waktu_operasional'])){
                                    echo '<span class="text-danger">Informasi Waktu Operasional Tidak Boleh Kosong</span>';
                                }else{
                                    //Validasi web_baseurl tidak boleh kosong
                                    if(empty($_POST['web_baseurl'])){
                                        echo '<span class="text-danger">URL Web Tidak Boleh Kosong</span>';
                                    }else{
                                         //Validasi api_key_2 tidak boleh kosong
                                        if(empty($api_key)){
                                            echo '<span class="text-danger">API Key Tidak Boleh Kosong</span>';
                                        }else{
                                            //Validasi url_service_2 tidak boleh kosong
                                            if(empty($ServiceUrl)){
                                                echo '<span class="text-danger">URL Service Tidak Boleh Kosong</span>';
                                            }else{
                                                //Validasi copyright_text tidak boleh kosong
                                                if(empty($_POST['copyright_text'])){
                                                    echo '<span class="text-danger">Copy Right Text Tidak Boleh Kosong</span>';
                                                }else{
                                                    //Validasi url_service_2 tidak boleh kosong
                                                    if(empty($_POST['copyright_url'])){
                                                        echo '<span class="text-danger">Copyright URL Tidak Boleh Kosong</span>';
                                                    }else{
                                                        $web_title=$_POST['web_title'];
                                                        $web_deskripsi=$_POST['web_deskripsi'];
                                                        $web_keywords=$_POST['web_keywords'];
                                                        $web_author=$_POST['web_author'];
                                                        $web_kontak=$_POST['web_kontak'];
                                                        $web_email=$_POST['web_email'];
                                                        $web_alamat=$_POST['web_alamat'];
                                                        $web_waktu_operasional=$_POST['web_waktu_operasional'];
                                                        $web_baseurl=$_POST['web_baseurl'];
                                                        $copyright_text2=$_POST['copyright_text'];
                                                        $copyright_url2=$_POST['copyright_url'];
                                                        $api_key=$api_key;
                                                        $url_update_web_info=$ServiceUrl;
                                                        //Validasi Jumlah Karakter
                                                        $karakter_web_title = strlen($web_title);
                                                        $karakter_web_author = strlen($web_author);
                                                        $karakter_web_kontak = strlen($web_kontak);
                                                        if($karakter_web_title>30){
                                                            echo '<span class="text-danger">Judul Web Maksimal Memiliki 30 Karakter</span>';
                                                        }else{
                                                            if($karakter_web_author>25){
                                                                echo '<span class="text-danger">Author Web Maksimal Memiliki 25 Karakter</span>';
                                                            }else{
                                                                if($karakter_web_kontak>20){
                                                                    echo '<span class="text-danger">Informasi Kontaak Maksimal Memiliki 20 Karakter</span>';
                                                                }else{
                                                                    //Kondisi ketika ada file gambar
                                                                    if(!empty($_FILES['web_favicon']['name'])){
                                                                        //Validasi Tipe File
                                                                        $tipe_gambar = $_FILES['web_favicon']['type']; 
                                                                        //ukuran gambar
                                                                        $ukuran_gambar = $_FILES['web_favicon']['size']; 
                                                                        //Ukurn Maksiman 1mb
                                                                        $UkuranMaksimal=1000*1000;
                                                                        //Konversi Ke Base64
                                                                        $TmpFile=$_FILES['web_favicon']['tmp_name'];
                                                                        $bin_string = file_get_contents($TmpFile);
                                                                        $hex_string = base64_encode($bin_string);
                                                                        //Validasi Ukuran File
                                                                        if($ukuran_gambar>$UkuranMaksimal){
                                                                            $ValidasiGambar="Untuk logo sebaiknya tidak lebih dari 1 Mb";
                                                                        }else{
                                                                            //Validasi Tipe File
                                                                            if($tipe_gambar=="image/jpeg"||$tipe_gambar=="image/jpg"||$tipe_gambar== "image/gif" || $tipe_gambar == "image/png"){
                                                                                $ValidasiGambar="Valid";
                                                                            }else{
                                                                                $ValidasiGambar="logo hanya boleh berformat jpg, jpg, gif atau png";
                                                                            }
                                                                        }
                                                                    }else{
                                                                        $ValidasiGambar="Valid";
                                                                        $hex_string ="";
                                                                    }
                                                                    if($ValidasiGambar!=="Valid"){
                                                                        echo '<span class="text-danger">'.$ValidasiGambar.'</span>';
                                                                    }else{
                                                                        //Proses Kirim Data
                                                                        $KirimData = array(
                                                                            'api_key' => $api_key,
                                                                            'web_title' => $web_title,
                                                                            'web_deskripsi' => $web_deskripsi,
                                                                            'web_keywords' => $web_keywords,
                                                                            'web_author' => $web_author,
                                                                            'web_kontak' => $web_kontak,
                                                                            'web_email' => $web_email,
                                                                            'web_alamat' => $web_alamat,
                                                                            'web_waktu_operasional' => $web_waktu_operasional,
                                                                            'web_baseurl' => $web_baseurl,
                                                                            'copyright_text' => $copyright_text2,
                                                                            'copyright_url' => $copyright_url2,
                                                                            'base64' => $hex_string
                                                                        );
                                                                        $json = json_encode($KirimData);
                                                                        //Mulai CURL
                                                                        $ch = curl_init();
                                                                        curl_setopt($ch,CURLOPT_URL, "$url_update_web_info");
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
                                                                                $_SESSION['NotifikasiSwal']="Setting Website";
                                                                                echo '<span class="text-success" id="NotifikasiSettingWebsiteBerhasil">Success</span>';
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
                                }
                            }
                        }
                    }
                }
            }
        }
    }
?>