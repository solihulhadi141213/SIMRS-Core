<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingKoneksiWeb.php";
    include "../../_Config/WebFunction.php";
    $url=urlService('Edit Artikel');
    //Validasi artikel_judul tidak boleh kosong
    if(empty($_POST['id_web_artikel'])){
        echo '<span class="text-danger">ID Artikel Tidak Boleh Kosong</span>';
    }else{
        if(empty($_POST['artikel_judul'])){
            echo '<span class="text-danger">Judul Tidak Boleh Kosong</span>';
        }else{
            //Validasi artikel_kategori tidak boleh kosong
            if(empty($_POST['artikel_kategori'])){
                echo '<span class="text-danger">Kategori Tidak Boleh Kosong</span>';
            }else{
                //Validasi artikel_tanggal tidak boleh kosong
                if(empty($_POST['artikel_tanggal'])){
                    echo '<span class="text-danger">Tanggal Tidak Boleh Kosong</span>';
                }else{
                    //Validasi artikel_jam tidak boleh kosong
                    if(empty($_POST['artikel_jam'])){
                        echo '<span class="text-danger">Jam Tidak Boleh Kosong</span>';
                    }else{
                        //Validasi artikel_penulis tidak boleh kosong
                        if(empty($_POST['artikel_penulis'])){
                            echo '<span class="text-danger">Penulis Tidak Boleh Kosong</span>';
                        }else{
                            //Validasi artikel_ringkasan tidak boleh kosong
                            if(empty($_POST['artikel_ringkasan'])){
                                echo '<span class="text-danger">Ringkasan Tidak Boleh Kosong</span>';
                            }else{
                                //Validasi artikel_isi tidak boleh kosong
                                if(empty($_POST['artikel_isi'])){
                                    echo '<span class="text-danger">Isi Artikel Tidak Boleh Kosong</span>';
                                }else{
                                    //Validasi artikel_status tidak boleh kosong
                                    if(empty($_POST['artikel_status'])){
                                        echo '<span class="text-danger">Status Artikel Tidak Boleh Kosong</span>';
                                    }else{
                                        $id_web_artikel=$_POST['id_web_artikel'];
                                        $artikel_judul=$_POST['artikel_judul'];
                                        $artikel_kategori=$_POST['artikel_kategori'];
                                        $artikel_tanggal=$_POST['artikel_tanggal'];
                                        $artikel_jam=$_POST['artikel_jam'];
                                        $artikel_tanggal="$artikel_tanggal $artikel_jam";
                                        $artikel_penulis=$_POST['artikel_penulis'];
                                        $artikel_ringkasan=$_POST['artikel_ringkasan'];
                                        $artikel_isi=$_POST['artikel_isi'];
                                        $artikel_status=$_POST['artikel_status'];
                                        //Proses Kirim Data
                                        $KirimData = array(
                                            'id_web_artikel' => $id_web_artikel,
                                            'api_key' => $api_key,
                                            'artikel_judul' => $artikel_judul,
                                            'artikel_kategori' => $artikel_kategori,
                                            'artikel_tanggal' => $artikel_tanggal,
                                            'artikel_jam' => $artikel_jam,
                                            'artikel_penulis' => $artikel_penulis,
                                            'artikel_ringkasan' => $artikel_ringkasan,
                                            'artikel_isi' => $artikel_isi,
                                            'artikel_status' => $artikel_status
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
                                                echo '<span class="text-danger">Gagal!! <br> Pesan: '.$massage.' <br> content: '.$content.'</span>';
                                            }else{
                                                $_SESSION['NotifikasiSwal']="Edit Artikel Berhasil";
                                                echo '<span class="text-success" id="NotifikasiEditArtikelBerhasil">Success</span>';
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