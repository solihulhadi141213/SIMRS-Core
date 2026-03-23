<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingKoneksiWeb.php";
    include "../../_Config/WebFunction.php";
    $Url=urlService('Add Dokter');
    $updatetime=date('Y-m-d H:i');
    if(empty($_POST['kode'])){
        echo '<span class="text-danger">Kode Dokter Tidak Boleh Kosong!</span>';
    }else{
        if(empty($_POST['spesialis'])){
            echo '<span class="text-danger">Keterangan Spesialis/Umum Tidak Boleh Kosong!</span>';
        }else{
            if(empty($_POST['nama'])){
                echo '<span class="text-danger">Nama Dokter Tidak Boleh Kosong!</span>';
            }else{
                if(empty($_POST['status'])){
                    echo '<span class="text-danger">Status Dokter Tidak Boleh Kosong!</span>';
                }else{
                    if(empty($_POST['kontak'])){
                        $kontak="";
                    }else{
                        $kontak=$_POST['kontak'];
                    }
                    if(empty($_POST['email'])){
                        $email="";
                    }else{
                        $email=$_POST['email'];
                    }
                    if(empty($_POST['alamat'])){
                        $alamat="";
                    }else{
                        $alamat=$_POST['alamat'];
                    }
                    if(empty($_FILES['foto']['name'])){
                        $hex_string="";
                        $ValidasiGambar="Valid";
                    }else{
                        //nama gambar
                        $nama_gambar=$_FILES['foto']['name'];
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
                        //Mencari extension file
                        $Pecah = explode("." , $nama_gambar);
                        $BiasanyaNama=$Pecah[0];
                        $Ext=$Pecah[1];
                        //Validasi Ukuran File
                        if($ukuran_gambar>$UkuranMaksimal){
                            $ValidasiGambar="Ukuran foto tidak lebih dari 2 Mb";
                        }else{
                            //Validasi Tipe File
                            if($tipe_gambar=="image/jpeg"||$tipe_gambar=="image/jpg"||$tipe_gambar== "image/gif" || $tipe_gambar == "image/png"){
                                $ValidasiGambar="Valid";
                            }else{
                                $ValidasiGambar="Foto hanya boleh berformat jpg, jpg, gif atau png";
                            }
                        }
                    }
                    if($ValidasiGambar!=="Valid"){
                        echo '<small class="text-danger">'.$ValidasiGambar.'</small>';
                    }else{
                        $kode=$_POST['kode'];
                        $spesialis=$_POST['spesialis'];
                        $nama=$_POST['nama'];
                        $status=$_POST['status'];
                        $KirimData = array(
                            'api_key' => $api_key,
                            'kode' => $kode,
                            'nama' => $nama,
                            'spesialis' => $spesialis,
                            'alamat' => $alamat,
                            'kontak' => $kontak,
                            'email' => $email,
                            'status' => $status,
                            'foto' => $hex_string
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
                                $_SESSION['NotifikasiSwal']="Tambah Dokter Berhasil";
                                echo '<span class="text-success" id="NotifikasiTambahDokterBerhasil">Success</span>';
                            }else{
                                echo '<span class="text-danger">'.$massage.'</span>';
                            }
                        }
                    }
                }
            }
        }
    }
?>