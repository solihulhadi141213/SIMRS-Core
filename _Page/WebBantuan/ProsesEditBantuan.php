<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingKoneksiWeb.php";
    include "../../_Config/WebFunction.php";
    $url=urlService('Edit Bantuan');
    //Validasi tanggal tidak boleh kosong
    if(empty($_POST['tanggal'])){
        echo '<span class="text-danger">Tanggal Tidak Boleh Kosong</span>';
    }else{
        //Validasi jam tidak boleh kosong
        if(empty($_POST['jam'])){
            echo '<span class="text-danger">Jam Tidak Boleh Kosong</span>';
        }else{
            //Validasi kategori tidak boleh kosong
            if(empty($_POST['kategori'])){
                echo '<span class="text-danger">Kategori Tidak Boleh Kosong</span>';
            }else{
                //Validasi judul tidak boleh kosong
                if(empty($_POST['judul'])){
                    echo '<span class="text-danger">Judul Tidak Boleh Kosong</span>';
                }else{
                    //Validasi deskripsi tidak boleh kosong
                    if(empty($_POST['deskripsi'])){
                        echo '<span class="text-danger">Diskripsi Tidak Boleh Kosong</span>';
                    }else{
                        //Validasi id_bantuan tidak boleh kosong
                        if(empty($_POST['id_bantuan'])){
                            echo '<span class="text-danger">ID Bantuan Tidak Boleh Kosong</span>';
                        }else{
                            $id_bantuan=$_POST['id_bantuan'];
                            $tanggal=$_POST['tanggal'];
                            $jam=$_POST['jam'];
                            $kategori=$_POST['kategori'];
                            $judul=$_POST['judul'];
                            $deskripsi=$_POST['deskripsi'];
                            $tanggal="$tanggal $jam";
                            //Proses Kirim Data
                            $KirimData = array(
                                'api_key' => $api_key,
                                'id_bantuan' => $id_bantuan,
                                'judul' => $judul,
                                'kategori' => $kategori,
                                'deskripsi' => $deskripsi,
                                'tanggal' => $tanggal
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
                                    $_SESSION['NotifikasiSwal']="Edit Bantuan Berhasil";
                                    echo '<span class="text-success" id="NotifikasiEditBantuanBerhasil">Success</span>';
                                }
                            }
                        }
                    }
                }
            }
        }
    }
?>