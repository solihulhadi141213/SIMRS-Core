<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    $WaktuLog=date('Y-m-d H:i:s');
    if(empty($_FILES['foto']['name'])){
        echo '<span class="text-danger">Foto Tidak Boleh Kosong!</span>';
    }else{
        //Membuka nama gambar yang lama
        $path_gambar_lama = "../../assets/images/user/".$SessionGambar;
        //nama gambar
        $nama_gambar=$_FILES['foto']['name'];
        //ukuran gambar
        $ukuran_gambar = $_FILES['foto']['size']; 
        //tipe
        $tipe_gambar = $_FILES['foto']['type']; 
        //sumber gambar
        $tmp_gambar = $_FILES['foto']['tmp_name'];
        //Membuat Nama Gambar baru
        $milliseconds = round(microtime(true) * 1000);
        $Pecah = explode("." , $nama_gambar);
        $BiasanyaNama=$Pecah[0];
        $Ext=$Pecah[1];
        $namabaru = "$milliseconds.$Ext";
        //Simpan Gambar di
        $path = "../../assets/images/user/".$namabaru;
        //Validasi tipe gambar
        if($ukuran_gambar>2000000){
            echo '<span class="text-danger">File Foto tidak boleh lebih dari 2 mb</span>';
        }else{
            if($tipe_gambar == "image/jpeg" || $tipe_gambar == "image/jpg" || $tipe_gambar == "image/gif" || $tipe_gambar == "image/png"){
                //Upload file
                if(move_uploaded_file($tmp_gambar, $path)){
                    $UpdateAkses = mysqli_query($Conn,"UPDATE akses SET 
                        gambar='$namabaru'
                    WHERE id_akses='$SessionIdAkses'") or die(mysqli_error($Conn)); 
                    if($UpdateAkses){
                        $MenyimpanLog=getSaveLog($Conn,$WaktuLog,$SessionNama,"Edit Profile","My Profile",$SessionIdAkses,$LogJsonFile);
                        if($MenyimpanLog=="Berhasil"){
                            unlink($path_gambar_lama);
                            $_SESSION['NotifikasiSwal']="Ubah Foto Profile Berhasil";
                            echo '<span class="text-info" id="NotifikasiBerhasil">Ganti Foto Berhasil</span>';
                        }else{
                            echo '<span class="text-danger">Gagal Menyimpan Log!</span>';
                        }
                    }else{
                        echo '<span class="text-danger">Ganti Foto Gagal</span>';
                    }
                }else{
                    echo '<span class="text-danger">Proses Upload Gagal!</span>';
                }
            }else{
                echo '<span class="text-danger">Tipe gambar tidak sesuai (ex: jpeg, jpg, gif, png)</span>';
            }
        }
    }
?>