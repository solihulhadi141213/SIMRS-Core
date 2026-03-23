<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    $tanggal=date('Y-m-d H:i:s');
    $now=date('T-m-d H:i:s');
    //Validasi Form Data
    if(empty($_POST['GetIdRad'])){
        echo '<span class="text-danger">ID Radiologi Tidak Boleh Kosong</span>';
    }else{
        if(empty($_POST['title'])){
            echo '<span class="text-danger">Judul File Tidak Boleh Kosong</span>';
        }else{
            if(empty($_POST['internal_eksternal'])){
                echo '<span class="text-danger">Internal/Eksternal File Tidak Boleh Kosong</span>';
            }else{
                $id_rad=$_POST['GetIdRad'];
                $title=$_POST['title'];
                $internal_eksternal=$_POST['internal_eksternal'];
                if(empty($_POST['deskripsi'])){
                    $deskripsi="";
                }else{
                    $deskripsi=$_POST['deskripsi'];
                }
                $JmlhKarTitle = strlen($title);
                if($JmlhKarTitle>50){
                    echo '<span class="text-danger">Judul File Tidak Boleh Melebihi 50 Karakter</span>';
                }else{
                    if($internal_eksternal=="Internal"){
                        $url_file="";
                        if(empty($_FILES['filename']['name'])){
                            $ValidasiFile="Silahkan Pilih File Yang Akan Diupload!";
                        }else{
                            //nama gambar
                            $nama_gambar=$_FILES['filename']['name'];
                            //ukuran gambar
                            $ukuran_gambar = $_FILES['filename']['size']; 
                            //tipe
                            $tipe_gambar = $_FILES['filename']['type']; 
                            //sumber gambar
                            $tmp_gambar = $_FILES['filename']['tmp_name'];
                            $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
                            $key=implode('', str_split(substr(strtolower(md5(microtime().rand(1000, 9999))), 0, 30), 6));
                            $FileNameRand=$key;
                            $Pecah = explode("." , $nama_gambar);
                            $BiasanyaNama=$Pecah[0];
                            $Ext=$Pecah[1];
                            $NamaFileBaru = "$FileNameRand.$Ext";
                            $path = "../../assets/images/Radiologi/".$NamaFileBaru;
                            if($tipe_gambar == "image/jpeg"||$tipe_gambar == "image/jpg"||$tipe_gambar == "image/gif"||$tipe_gambar == "image/png"){
                                if($ukuran_gambar<2000000){
                                    if(move_uploaded_file($tmp_gambar, $path)){
                                        $ValidasiFile="Valid";
                                    }else{
                                        $ValidasiFile="Upload file lampiran gagal";
                                    }
                                }else{
                                    $ValidasiFile="File gambar tidak boleh lebih dari 2 mb";
                                }
                            }else{
                                $ValidasiFile="tipe file hanya boleh JPG, JPEG, PNG and GIF";
                            }
                        }
                    }else{
                        if(empty($_POST['url_file'])){
                            $ValidasiFile="URL File Tidak Boleh Kosong!";
                        }else{
                            $url_file=$_POST['url_file'];
                            $NamaFileBaru="";
                            $ukuran_gambar=0;
                            $ValidasiFile="Valid";
                        }
                    }
                    if($ValidasiFile!=="Valid"){
                        echo '<span class="text-danger">'.$ValidasiFile.'</span>';
                    }else{
                        $ValidasiDuplikatData=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM radiologi_file WHERE id_rad='$id_rad' AND tanggal='$tanggal' AND title='$title' AND title='$title'"));
                        if(!empty($ValidasiDuplikatData)){
                            echo '<span class="text-danger">Data Tersebut Sudah Ada</span>';
                        }else{
                            $TambahLampiran="INSERT INTO radiologi_file (
                                id_rad,
                                id_akses,
                                tanggal,
                                internal_eksternal,
                                title,
                                deskripsi,
                                filesize,
                                url_file,
                                filename
                            ) VALUES (
                                '$id_rad',
                                '$SessionIdAkses',
                                '$tanggal',
                                '$internal_eksternal',
                                '$title',
                                '$deskripsi',
                                '$ukuran_gambar',
                                '$url_file',
                                '$NamaFileBaru'
                            )";
                            $Input=mysqli_query($Conn, $TambahLampiran);
                            if($Input){
                                //Input Log
                                $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Tambah Rincian Radiologi","Radiologi",$SessionIdAkses,$LogJsonFile);
                                if($MenyimpanLog=="Berhasil"){
                                    $_SESSION['NotifikasiSwal']="Tambah Lampiran Radiologi Berhasil";
                                    echo '<span class="text-success" id="NotifikasiTambahLampiranBerhasil">Success</span>';
                                }else{
                                    echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                                }
                            }else{
                                echo '<span class="text-danger">Tambah Lampiran Gagal</span>';
                            }
                        }
                    }
                }
            }
        }
    }
    
    
?>