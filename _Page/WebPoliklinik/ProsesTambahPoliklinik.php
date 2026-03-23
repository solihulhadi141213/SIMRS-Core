<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingKoneksiWeb.php";
    include "../../_Config/WebFunction.php";
    $url=urlService('Add Poliklinik');
    //Validasi nama tidak boleh kosong
    if(empty($_POST['nama'])){
        echo '<span class="text-danger">Nama Poli Tidak Boleh Kosong</span>';
    }else{
        //Validasi deskripsi tidak boleh kosong
        if(empty($_POST['deskripsi'])){
            echo '<span class="text-danger">Deskripsi Poli Tidak Boleh Kosong</span>';
        }else{
            //Validasi kode tidak boleh kosong
            if(empty($_POST['kode'])){
                echo '<span class="text-danger">Kode Poli Tidak Boleh Kosong</span>';
            }else{
                //Validasi status tidak boleh kosong
                if(empty($_POST['status'])){
                    echo '<span class="text-danger">Status Poli Tidak Boleh Kosong</span>';
                }else{
                    $nama=$_POST['nama'];
                    $deskripsi=$_POST['deskripsi'];
                    $kode=$_POST['kode'];
                    $status=$_POST['status'];        
                    //Proses Kirim Data
                    $KirimData = array(
                        'api_key' => $api_key,
                        'nama' => $nama,
                        'deskripsi' => $deskripsi,
                        'kode' => $kode,
                        'status' => $status,
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
                            echo '<span class="text-danger">Gagal!! <br> Pesan: '.$massage.'</span>';
                        }else{
                            $_SESSION['NotifikasiSwal']="Tambah Poliklinik Berhasil";
                            echo '<span class="text-success" id="NotifikasiTambahPoliklinikBerhasil">Success</span>';
                        }
                    }
                }
            }
        }
    }
?>