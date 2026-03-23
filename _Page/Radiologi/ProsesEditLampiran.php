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
    if(empty($_POST['id_radiologi_file'])){
        echo '<span class="text-danger">ID Lampiran Tidak Boleh Kosong</span>';
    }else{
        if(empty($_POST['title'])){
            echo '<span class="text-danger">Judul File Tidak Boleh Kosong</span>';
        }else{
            if(empty($_POST['internal_eksternal'])){
                echo '<span class="text-danger">Internal/Eksternal File Tidak Boleh Kosong</span>';
            }else{
                $id_radiologi_file=$_POST['id_radiologi_file'];
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
                    //Buka data lampiran
                    $InternalExternalLama=getDataDetail($Conn,'radiologi_file','id_radiologi_file',$id_radiologi_file,'internal_eksternal');
                    $UrlFileLama=getDataDetail($Conn,'radiologi_file','id_radiologi_file',$id_radiologi_file,'url_file');
                    $FileNameLama=getDataDetail($Conn,'radiologi_file','id_radiologi_file',$id_radiologi_file,'filename');
                    $FileSizeLama=getDataDetail($Conn,'radiologi_file','id_radiologi_file',$id_radiologi_file,'filesize');
                    if($InternalExternalLama=="Internal"){
                        $UrlGambarLama="assets/images/Radiologi/$FileNameLama";
                    }else{
                        $UrlGambarLama="$UrlFileLama";
                    }
                    if($internal_eksternal=="Internal"){
                        $url_file="";
                        if(empty($_FILES['filename']['name'])){
                            $ValidasiFile="Valid";
                            $NamaFileBaru=$FileNameLama;
                            $ukuran_gambar=$FileSizeLama;
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
                        $UpdateLampiran=mysqli_query($Conn, "UPDATE radiologi_file SET 
                            internal_eksternal='$internal_eksternal', 
                            title='$title', 
                            deskripsi='$deskripsi', 
                            filesize='$ukuran_gambar', 
                            url_file='$url_file', 
                            filename='$NamaFileBaru'
                        WHERE id_radiologi_file ='$id_radiologi_file'");
                        if($UpdateLampiran){
                            //Input Log
                            $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Edit Lampiran Radiologi","Radiologi",$SessionIdAkses,$LogJsonFile);
                            if($MenyimpanLog=="Berhasil"){
                                //Menghapus file lama apabila internal/eksternal lama adalah internal
                                if($InternalExternalLama=="Internal"){
                                    if($internal_eksternal=="Eksternal"){
                                        //Hapus File apabila diubah ke data eksternal
                                        $UrlGambar="../../assets/images/Radiologi/$FileNameLama";
                                        if(file_exists("$UrlGambar")){
                                            unlink($UrlGambar);
                                        }
                                    }else{
                                        if(!empty($_FILES['filename']['name'])){
                                            //Hapus File apabila diubah ke data eksternal
                                            $UrlGambar="../../assets/images/Radiologi/$FileNameLama";
                                            if(file_exists("$UrlGambar")){
                                                unlink($UrlGambar);
                                            }
                                        }
                                    }
                                }
                                $_SESSION['NotifikasiSwal']="Edit Lampiran Radiologi Berhasil";
                                echo '<span class="text-success" id="NotifikasiEditLampiranBerhasil">Success</span>';
                            }else{
                                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                            }
                        }else{
                            echo '<span class="text-danger">Edit Lampiran Gagal</span>';
                        }
                    }
                }
            }
        }
    }
    
    
?>