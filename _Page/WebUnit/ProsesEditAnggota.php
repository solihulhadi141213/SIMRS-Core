<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingKoneksiWeb.php";
    include "../../_Config/WebFunction.php";
    $Url=urlService('Edit Anggota');
    $tanggal_galeri=date('Y-m-d H:i');
    //Validasi Form Data
    if(empty($_POST['id_web_unit_karyawan'])){
        echo '<small class="text-danger">ID Anggota Tidak Boleh Kosong</small>';
    }else{
        if(empty($_POST['nama_karyawan'])){
            echo '<small class="text-danger">Nama Anggota Tidak Boleh Kosong</small>';
        }else{
            if(empty($_POST['posisi_jabatan'])){
                echo '<small class="text-danger">Posisi Jabatan Tidak Boleh Kosong</small>';
            }else{
                if(empty($_POST['sk_jabatan'])){
                    echo '<small class="text-danger">SK Jabatan Tidak Boleh Kosong</small>';
                }else{
                    if(empty($_FILES['foto']['name'])){
                        $ValidasiGambar="Valid";
                        $hex_string="";
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
                        $id_web_unit_karyawan=$_POST['id_web_unit_karyawan'];
                        $nama_karyawan=$_POST['nama_karyawan'];
                        $posisi_jabatan=$_POST['posisi_jabatan'];
                        $sk_jabatan=$_POST['sk_jabatan'];
                        $KirimData = array(
                            'api_key' => $api_key,
                            'id_web_unit_karyawan' => $id_web_unit_karyawan,
                            'nama_karyawan' => $nama_karyawan,
                            'posisi_jabatan' => $posisi_jabatan,
                            'sk_jabatan' => $sk_jabatan,
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
                                $_SESSION['NotifikasiSwal']="Edit Anggota Berhasil";
                                echo '<small class="text-success" id="NotifikasiEditAnggotaBerhasil">Success</small>';
                            }else{
                                echo '<small class="text-danger">'.$massage.'</small>';
                            }
                        }
                    }
                }
            }
        }
    }
?>