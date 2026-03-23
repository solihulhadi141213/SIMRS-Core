<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    $now=date('Y-m-d H:i:s');
    //Validasi Form Data
    if(empty($_POST['id_akses'])){
        echo '<span class="text-danger">Sistem Tidak Bisa Menangkap ID akses</span>';
    }else{
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
                        $id_akses=$_POST['id_akses'];
                        $nama=$_POST['nama'];
                        $JmlhKarNama = strlen($nama);
                        $email=$_POST['email'];
                        $JmlhKarEmail = strlen($email);
                        $kontak=$_POST['kontak'];
                        $JmlhKarKontak = strlen($kontak);
                        $akses=$_POST['akses'];
                        //Membuka kontak dan email lama
                        $QueryAkses = mysqli_query($Conn,"SELECT * FROM akses WHERE id_akses='$id_akses'")or die(mysqli_error($Conn));
                        $DataAkses = mysqli_fetch_array($QueryAkses);
                        $KontakLama= $DataAkses['kontak'];
                        $EmailLama= $DataAkses['email'];
                        $GambarLama= $DataAkses['gambar'];
                        //Validasi Email Sama
                        if($email==$EmailLama){
                            $ValidasiEmailSama="0";
                        }else{
                            $ValidasiEmailSama=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akses WHERE email='$email'"));
                        }
                        //Validasi Kontak Sama
                        if($kontak==$KontakLama){
                            $ValidasiKontakSama="0";
                        }else{
                            $ValidasiKontakSama=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akses WHERE kontak='$kontak'"));
                        }
                        if(!empty($ValidasiKontakSama)){
                            echo '<span class="text-danger">Kontak Tersebut Sudah Digunakan</span>';
                        }else{
                            if(!empty($ValidasiEmailSama)){
                                echo '<span class="text-danger">Email Tersebut Sudah Digunakan</span>';
                            }else{
                                if($JmlhKarKontak>20){
                                    echo '<span class="text-danger">Kontak maksimal 20 karakter</span>';
                                }else{
                                    if(empty($_FILES['gambar']['name'])){
                                        $UpdateAkses = mysqli_query($Conn,"UPDATE akses SET 
                                            nama='$nama',
                                            email='$email',
                                            kontak='$kontak',
                                            akses='$akses',
                                            updatetime='$now'
                                        WHERE id_akses='$id_akses'") or die(mysqli_error($Conn)); 
                                        if($UpdateAkses){
                                            $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Edit Profile Akses","Akses",$SessionIdAkses,$LogJsonFile);
                                            if($MenyimpanLog=="Berhasil"){
                                                $_SESSION['NotifikasiSwal']="Edit Akses Berhasil";
                                                echo '<span class="text-success" id="NotifikasiEditAksesBerhasil">Success</span>';
                                            }else{
                                                echo '<span class="text-danger">Terjadi kesalahan ketika menyimpan data Log</span>';
                                            }
                                        }else{
                                            echo '<span class="text-danger">Terjadi kesalahan ketika menyimpan data akses</span>';
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
                                        //Buat Nama File
                                        $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
                                        $key=implode('', str_split(substr(strtolower(md5(microtime().rand(1000, 9999))), 0, 30), 6));
                                        $FileNameRand=$key;
                                        $Pecah = explode("." , $nama_gambar);
                                        $BiasanyaNama=$Pecah[0];
                                        $Ext=$Pecah[1];
                                        $NamaFileBaru = "$FileNameRand.$Ext";
                                        //Simpan Gambar di
                                        $path = "../../assets/images/user/".$NamaFileBaru;
                                        //Validasi Ukuran File
                                        if($ukuran_gambar>2000000){
                                            echo '<span class="text-danger">File Foto tidak boleh lebih dari 2 mb</span>';
                                        }else{
                                            //Validasi tipe gambar
                                            if($tipe_gambar == "image/jpeg" || $tipe_gambar == "image/jpg" || $tipe_gambar == "image/gif" || $tipe_gambar == "image/png"){
                                                //Upload file
                                                if(move_uploaded_file($tmp_gambar, $path)){
                                                    $UpdateAkses = mysqli_query($Conn,"UPDATE akses SET 
                                                        nama='$nama',
                                                        email='$email',
                                                        kontak='$kontak',
                                                        akses='$akses',
                                                        gambar='$NamaFileBaru',
                                                        updatetime='$now'
                                                    WHERE id_akses='$id_akses'") or die(mysqli_error($Conn)); 
                                                    if($UpdateAkses){
                                                        $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Edit Profile Akses","Akses",$SessionIdAkses,$LogJsonFile);
                                                        if($MenyimpanLog=="Berhasil"){
                                                            //Hapus File Gambar Lama
                                                            $UrlGambar="../../assets/images/user/$GambarLama";
                                                            if(file_exists("$UrlGambar")){
                                                                unlink($UrlGambar);
                                                            }
                                                            $_SESSION['NotifikasiSwal']="Edit Akses Berhasil";
                                                            echo '<span class="text-success" id="NotifikasiEditAksesBerhasil">Success</span>';
                                                        }else{
                                                            echo '<span class="text-danger">Terjadi kesalahan ketika menyimpan data Log</span>';
                                                        }
                                                    }else{
                                                        echo '<span class="text-danger">Terjadi kesalahan ketika menyimpan data akses</span>';
                                                    }
                                                }
                                            }else{
                                                echo '<span class="text-danger">Tipe file foto tidak sesuai (ex: jpeg, jpg, gif, png)</span>';
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