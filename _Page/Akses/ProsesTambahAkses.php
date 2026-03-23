<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    //Validasi Form Data
    if(empty($_POST['nama'])){
        echo '<span class="text-danger">Nama Tidak Boleh Kosong</span>';
    }else{
        if(empty($_POST['email'])){
            echo '<span class="text-danger">Email Tidak Boleh Kosong</span>';
        }else{
            if(empty($_POST['kontak'])){
                echo '<span class="text-danger">Nomor Kontak Tidak Boleh Kosong</span>';
            }else{
                if(empty($_POST['akses'])){
                    echo '<span class="text-danger">Hak Akses Tidak Boleh Kosong</span>';
                }else{
                    if(empty($_POST['username'])){
                        echo '<span class="text-danger">Username Tidak Boleh Kosong</span>';
                    }else{
                        if(empty($_POST['password1'])){
                            echo '<span class="text-danger">Password Tidak Boleh Kosong</span>';
                        }else{
                            if(empty($_POST['password2'])){
                                echo '<span class="text-danger">Password Tidak Boleh Kosong</span>';
                            }else{
                                $nama=$_POST['nama'];
                                $JmlhKarNama = strlen($nama);
                                $email=$_POST['email'];
                                $JmlhKarEmail = strlen($email);
                                $kontak=$_POST['kontak'];
                                $JmlhKarKontak = strlen($kontak);
                                $username=$_POST['username'];
                                $JmlhKarUsername = strlen($username);
                                $password1=$_POST['password1'];
                                $JmlhKarPassword = strlen($password1);
                                $password2=$_POST['password2'];
                                $akses=$_POST['akses'];
                                $ValidasiUsernameSama=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akses WHERE username='$username'"));
                                $ValidasiEmailSama=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akses WHERE email='$email'"));
                                if(!empty($ValidasiUsernameSama)){
                                    echo '<span class="text-danger">Username Tersebut Sudah Digunakan</span>';
                                }else{
                                    if(!empty($ValidasiEmailSama)){
                                        echo '<span class="text-danger">Email Tersebut Sudah Digunakan</span>';
                                    }else{
                                        if($JmlhKarUsername<6){
                                            echo '<span class="text-danger">Username Harus 6-20 karakter</span>';
                                        }else{
                                            if($JmlhKarNama>50){
                                                echo '<span class="text-danger">Nama maksimal 50 karakter</span>';
                                            }else{
                                                if($JmlhKarEmail>50){
                                                    echo '<span class="text-danger">Email maksimal 50 karakter</span>';
                                                }else{
                                                    if($JmlhKarKontak>15){
                                                        echo '<span class="text-danger">Kontak maksimal 15 karakter</span>';
                                                    }else{
                                                        if($JmlhKarUsername>20){
                                                            echo '<span class="text-danger">Username Harus 6-20 karakter</span>';
                                                        }else{
                                                            if($JmlhKarPassword<6){
                                                                echo '<span class="text-danger">Password Harus 6-20 karakter</span>';
                                                            }else{
                                                                if($JmlhKarPassword>20){
                                                                    echo '<span class="text-danger">Password Harus 6-20 karakter</span>';
                                                                }else{
                                                                    if($password1!==$password2){
                                                                        echo '<span class="text-danger">Password harus sama</span>';
                                                                    }else{
                                                                        //Proses Enkripsi MD5
                                                                        $PasswordEnkripsi=MD5($password1);
                                                                        if(empty($_FILES['gambar']['name'])){
                                                                            $nama_gambar="";
                                                                            $entry="INSERT INTO akses (
                                                                                nama,
                                                                                email,
                                                                                kontak,
                                                                                username,
                                                                                password,
                                                                                akses,
                                                                                gambar
                                                                            ) VALUES (
                                                                                '$nama',
                                                                                '$email',
                                                                                '$kontak',
                                                                                '$username',
                                                                                '$PasswordEnkripsi',
                                                                                '$akses',
                                                                                '$nama_gambar'
                                                                            )";
                                                                            $Input=mysqli_query($Conn, $entry);
                                                                            if($Input){
                                                                                //Catat Log Aktivitas
                                                                                $WaktuLog=date('Y-m-d H:i');
                                                                                $nama_log="Tambah Akses Berhasil";
                                                                                $kategori_log="Akses";
                                                                                include "../../_Config/Log.php";
                                                                                echo '<i id="Notifikasi">Tambah Akses Berhasil</i>';
                                                                            }else{
                                                                                echo '<i id="Notifikasi">Tambah Akses Gagal</i>';
                                                                            }
                                                                        }else{
                                                                            //nama gambar
                                                                            $nama_gambar=$_FILES['gambar']['name'];
                                                                            //ukuran gambar
                                                                            $ukuran_gambar = $_FILES['gambar']['size']; 
                                                                            //tipe
                                                                            $tipe_gambar = $_FILES['gambar']['type']; 
                                                                            //sumber gambar
                                                                            $tmp_gambar = $_FILES['gambar']['tmp_name'];
                                                                            //Simpan Gambar di
                                                                            $path = "../../assets/images/user/".$nama_gambar;
                                                                            //Validasi tipe gambar
                                                                            if($tipe_gambar == "image/jpeg" || $tipe_gambar == "image/jpg" || $tipe_gambar == "image/gif" || $tipe_gambar == "image/png"){
                                                                                //Upload file
                                                                                if(move_uploaded_file($tmp_gambar, $path)){
                                                                                    $entry="INSERT INTO akses (
                                                                                        nama,
                                                                                        email,
                                                                                        kontak,
                                                                                        username,
                                                                                        password,
                                                                                        akses,
                                                                                        gambar
                                                                                    ) VALUES (
                                                                                        '$nama',
                                                                                        '$email',
                                                                                        '$kontak',
                                                                                        '$username',
                                                                                        '$PasswordEnkripsi',
                                                                                        '$akses',
                                                                                        '$nama_gambar'
                                                                                    )";
                                                                                    $Input=mysqli_query($Conn, $entry);
                                                                                    if($Input){
                                                                                        //Catat Log Aktivitas
                                                                                        $WaktuLog=date('Y-m-d H:i');
                                                                                        $nama_log="Tambah Akses Berhasil";
                                                                                        $kategori_log="Akses";
                                                                                        include "../../_Config/Log.php";
                                                                                        echo '<i class="text-danger" id="Notifikasi">Tambah Akses Berhasil</i>';
                                                                                    }else{
                                                                                        echo '<i class="text-danger" id="Notifikasi">Tambah Akses Gagal</i>';
                                                                                    }
                                                                                }
                                                                            }else{
                                                                                echo '<span class="text-danger">Tipe gambar tidak sesuai (ex: jpeg, jpg, gif, png)</span>';
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