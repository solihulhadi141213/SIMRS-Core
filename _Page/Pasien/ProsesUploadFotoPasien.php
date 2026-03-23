<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    $updatetime=date('Y-m-d H:i:s');
    $now=date('Y-m-d H:i:s');
    //Validasi Form Data Yang Wajib Diisi
    if(empty($_POST['UploadIdPasien'])){
        echo '<span class="text-danger">ID Pasien Tidak Boleh Kosong</span>';
    }else{
        if(empty($_FILES['Fotopasien']['name'])){
            echo '<span class="text-danger">Foto Tidak Boleh Kosong</span>';
        }else{
            $id_pasien=$_POST['UploadIdPasien'];
            //Membuka data lama berdasarkan id_pasien
            $QryPasien = mysqli_query($Conn,"SELECT * FROM pasien WHERE id_pasien='$id_pasien'")or die(mysqli_error($Conn));
            $DataPasien = mysqli_fetch_array($QryPasien);
            if(empty($DataPasien['id_pasien'])){
                echo '<span class="text-danger">ID Pasien Tidak Valid</span>';
            }else{
                if(empty($DataPasien['gambar'])){
                    $GambarLama="";
                }else{
                    $GambarLama=$DataPasien['gambar'];
                }
                //nama gambar
                $nama_gambar=$_FILES['Fotopasien']['name'];
                //ukuran gambar
                $ukuran_gambar = $_FILES['Fotopasien']['size']; 
                //tipe
                $tipe_gambar = $_FILES['Fotopasien']['type']; 
                //sumber gambar
                $tmp_gambar = $_FILES['Fotopasien']['tmp_name'];
                $milliseconds = round(microtime(true) * 1000);
                $Pecah = explode("." , $nama_gambar);
                $BiasanyaNama=$Pecah[0];
                $Ext=$Pecah[1];
                $namabaru = "$milliseconds.$Ext";
                //Simpan Gambar di
                $path = "../../assets/images/pasien/".$namabaru;
                if($ukuran_gambar>1000000){
                    echo '<span class="text-danger">Ukuran File Tidak Boleh Lebih Dari 1 Mb</span>';
                }else{
                    //Validasi tipe gambar
                    if($tipe_gambar == "image/jpeg" || $tipe_gambar == "image/jpg" || $tipe_gambar == "image/gif" || $tipe_gambar == "image/png"){
                        //Upload file
                        if(move_uploaded_file($tmp_gambar, $path)){
                            //Apabila dimasa lalu mempunyai gambar
                            $UpdatePasien= mysqli_query($Conn,"UPDATE pasien SET 
                                gambar='$namabaru',
                                updatetime='$updatetime'
                            WHERE id_pasien='$id_pasien'") or die(mysqli_error($Conn)); 
                            if($UpdatePasien){
                                if(!empty($GambarLama)){
                                    //Menghapus file
                                    $files="../../assets/images/pasien/$GambarLama";
                                    unlink($files);
                                }
                                $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Upload Foto Pasien","Pasien",$SessionIdAkses,$LogJsonFile);
                                if($MenyimpanLog=="Berhasil"){
                                    $_SESSION['NotifikasiSwal']="Upload Pasien Berhasil";
                                    echo '<span class="text-success" id="NotifikasiUploadFotoPasienBerhasil">Success</span>';
                                }else{
                                    echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                                }
                            }else{
                                echo '<span class="text-danger">Update Pasien Gagal</span>';
                            }
                        }
                    }else{
                        echo '<span class="text-danger">Tipe gambar tidak sesuai (ex: jpeg, jpg, gif, png)</span>';
                    }
                }
            }
        }
    }
?>