<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingKoneksiWeb.php";
    include "../../_Config/WebFunction.php";
    $url=urlService('Add So');
    //Validasi nama tidak boleh kosong
    if(empty($_POST['nama'])){
        echo '<span class="text-danger">Nama Tidak Boleh Kosong</span>';
    }else{
        //Validasi job_title tidak boleh kosong
        if(empty($_POST['job_title'])){
            echo '<span class="text-danger">Job Title Tidak Boleh Kosong</span>';
        }else{
            //Validasi NIP tidak boleh kosong
            if(empty($_POST['NIP'])){
                echo '<span class="text-danger">NIP Tidak Boleh Kosong</span>';
            }else{
                if(empty($_POST['boss'])){
                    $boss="";
                }else{
                    $boss=$_POST['boss'];
                }
                $nama=$_POST['nama'];
                $job_title=$_POST['job_title'];
                $NIP=$_POST['NIP'];
                //Kondisi ketika ada file gambar
                if(!empty($_FILES['foto']['name'])){
                    //Validasi Tipe File
                    $tipe_gambar = $_FILES['foto']['type']; 
                    //ukuran gambar
                    $ukuran_gambar = $_FILES['foto']['size']; 
                    //Ukurn Maksiman 1mb
                    $UkuranMaksimal=1000*1000;
                    //Konversi Ke Base64
                    $TmpFile=$_FILES['foto']['tmp_name'];
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
                        'boss' => $boss,
                        'nama' => $nama,
                        'job_title' => $job_title,
                        'NIP' => $NIP,
                        'foto' => $hex_string
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
                            $_SESSION['NotifikasiSwal']="Tambah SO Berhasil";
                            echo '<span class="text-success" id="NotifikasiTambahSoBerhasil">Success</span>';
                        }
                    }
                }
            }
        }
    }
?>