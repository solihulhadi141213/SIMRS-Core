<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingKoneksiWeb.php";
    include "../../_Config/WebFunction.php";
    $Url=urlService('Edit Pasien');
    //Validasi Form Data
    if(empty($_POST['tanggal_daftar'])){
        echo '<span class="text-danger">Tanggal Daftar Tidak Boleh Kosong</span>';
    }else{
        if(empty($_POST['nama'])){
            echo '<span class="text-danger">Nama Tidak Boleh Kosong</span>';
        }else{
            if(empty($_POST['email'])){
                echo '<span class="text-danger">Alamat Email Tidak Boleh Kosong</span>';
            }else{
                if(empty($_POST['id_web_pasien'])){
                    echo '<span class="text-danger">ID Pasien Web Tidak Boleh Kosong</span>';
                }else{
                    if(empty($_POST['sex'])){
                        echo '<span class="text-danger">Jenis Kelamin Tidak Boleh Kosong</span>';
                    }else{
                        if(empty($_POST['status'])){
                            echo '<span class="text-danger">Status Tidak Boleh Kosong</span>';
                        }else{
                            if(empty($_POST['password2'])){
                                echo '<span class="text-danger">Password Lama Tidak Boleh Kosong</span>';
                            }else{
                                if(empty($_FILES['foto_profile']['name'])){
                                    $hex_string ="";
                                    $ValidasiGambar="Valid";
                                }else{
                                    //Validasi Tipe File
                                    $nama_gambar = $_FILES['foto_profile']['name']; 
                                    $tipe_gambar = $_FILES['foto_profile']['type']; 
                                    //ukuran gambar
                                    $ukuran_gambar = $_FILES['foto_profile']['size']; 
                                    //Ukurn Maksiman 1mb
                                    $UkuranMaksimal=2000*1000;
                                    //Konversi Ke Base64
                                    $TmpFile=$_FILES['foto_profile']['tmp_name'];
                                    $bin_string = file_get_contents($TmpFile);
                                    $hex_string = base64_encode($bin_string);
                                    //Validasi Ukuran File
                                    if($ukuran_gambar>$UkuranMaksimal){
                                        $ValidasiGambar="Untuk ukuran file sebaiknya tidak lebih dari 2 Mb";
                                    }else{
                                        //Validasi Tipe File
                                        if($tipe_gambar=="image/jpeg"||$tipe_gambar=="image/jpg"||$tipe_gambar== "image/gif" || $tipe_gambar == "image/png"|| $tipe_gambar == "application/pdf"){
                                            $ValidasiGambar="Valid";
                                        }else{
                                            $ValidasiGambar="File foto hanya boleh berformat pdf, jpg, jpg, gif atau png";
                                        }
                                    }
                                }
                                if($ValidasiGambar!=="Valid"){
                                    echo '<span class="text-danger">'.$ValidasiGambar.'</span>';
                                }else{
                                    $id_web_pasien=$_POST['id_web_pasien'];
                                    $tanggal_daftar=$_POST['tanggal_daftar'];
                                    $nama=$_POST['nama'];
                                    $email=$_POST['email'];
                                    $sex=$_POST['sex'];
                                    $status=$_POST['status'];
                                    //Variabel lainnya yang tidak wajib
                                    if(empty($_POST['id_pasien'])){
                                        $id_pasien="0";
                                    }else{
                                        $id_pasien=$_POST['id_pasien'];
                                    }
                                    if(empty($_POST['nik'])){
                                        $nik="";
                                    }else{
                                        $nik=$_POST['nik'];
                                    }
                                    if(empty($_POST['bpjs'])){
                                        $bpjs="";
                                    }else{
                                        $bpjs=$_POST['bpjs'];
                                    }
                                    if(empty($_POST['kontak'])){
                                        $kontak="";
                                    }else{
                                        $kontak=$_POST['kontak'];
                                    }
                                    if(empty($_POST['propinsi'])){
                                        $propinsi="";
                                    }else{
                                        $propinsi=$_POST['propinsi'];
                                    }
                                    if(empty($_POST['kabupaten'])){
                                        $kabupaten="";
                                    }else{
                                        $kabupaten=$_POST['kabupaten'];
                                    }
                                    if(empty($_POST['kecamatan'])){
                                        $kecamatan="";
                                    }else{
                                        $kecamatan=$_POST['kecamatan'];
                                    }
                                    if(empty($_POST['desa'])){
                                        $desa="";
                                    }else{
                                        $desa=$_POST['desa'];
                                    }
                                    if(empty($_POST['alamat'])){
                                        $alamat="";
                                    }else{
                                        $alamat=$_POST['alamat'];
                                    }
                                    if(empty($_POST['tepat_lahir'])){
                                        $tepat_lahir="";
                                    }else{
                                        $tepat_lahir=$_POST['tepat_lahir'];
                                    }
                                    if(empty($_POST['tanggal_lahir'])){
                                        $tanggal_lahir="";
                                    }else{
                                        $tanggal_lahir=$_POST['tanggal_lahir'];
                                    }
                                    if(empty($_POST['gol_darah'])){
                                        $gol_darah="";
                                    }else{
                                        $gol_darah=$_POST['gol_darah'];
                                    }
                                    if(empty($_POST['pekerjaan'])){
                                        $pekerjaan="";
                                    }else{
                                        $pekerjaan=$_POST['pekerjaan'];
                                    }
                                    if(empty($_POST['perkawinan'])){
                                        $perkawinan="";
                                    }else{
                                        $perkawinan=$_POST['perkawinan'];
                                    }
                                    if(empty($_POST['token'])){
                                        $token="";
                                    }else{
                                        $token=$_POST['token'];
                                    }
                                    if(empty($_POST['password'])){
                                        $password=$_POST['password2'];
                                    }else{
                                        $password=$_POST['password'];
                                        $password=md5($password);
                                    }
                                    $KirimData = array(
                                        'api_key' => $api_key,
                                        'id_web_pasien' => $id_web_pasien,
                                        'id_pasien' => $id_pasien,
                                        'tanggal_daftar' => $tanggal_daftar,
                                        'nik' => $nik,
                                        'bpjs' => $bpjs,
                                        'nama' => $nama,
                                        'propinsi' => $propinsi,
                                        'kabupaten' => $kabupaten,
                                        'kecamatan' => $kecamatan,
                                        'desa' => $desa,
                                        'alamat' => $alamat,
                                        'tepat_lahir' => $tepat_lahir,
                                        'tanggal_lahir' => $tanggal_lahir,
                                        'kontak' => $kontak,
                                        'gol_darah' => $gol_darah,
                                        'sex' => $sex,
                                        'pekerjaan' => $pekerjaan,
                                        'perkawinan' => $perkawinan,
                                        'email' => $email,
                                        'password' => $password,
                                        'token' => $token,
                                        'status' => $status,
                                        'foto_profile' => $hex_string
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
                                            $_SESSION['NotifikasiSwal']="Edit Pasien Berhasil";
                                            echo '<span class="text-success" id="NotifikasiEditPasienBerhasil">Success</span>';
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
    }
?>