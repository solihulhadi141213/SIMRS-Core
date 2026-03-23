<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    //Validasi Form Data
    if(empty($_POST['id_akses'])){
        echo '<span class="text-danger">Sistem Tidak Bisa Menangkap ID akses</span>';
    }else{
        if(empty($_POST['password1'])){
            echo '<span class="text-danger">Password Tidak Boleh Kosong</span>';
        }else{
            if(empty($_POST['password2'])){
                echo '<span class="text-danger">Password Tidak Boleh Kosong</span>';
            }else{
                $id_akses=$_POST['id_akses'];
                $password1=$_POST['password1'];
                $password2=$_POST['password2'];
                $JumlahPassword1 = strlen($password1);
                $JumlahPassword2 = strlen($password2);
                if($JumlahPassword1<6||$JumlahPassword1>50){
                    echo '<span class="text-danger">Password Harus 6-20 karakter</span>';
                }else{
                    if($JumlahPassword2<6||$JumlahPassword2>50){
                        echo '<span class="text-danger">Password Harus 6-20 karakter</span>';
                    }else{
                        $PasswordEnkripsi=MD5($password1);
                        $UpdateAkses = mysqli_query($Conn,"UPDATE akses SET 
                            password='$PasswordEnkripsi'
                        WHERE id_akses='$id_akses'") or die(mysqli_error($Conn)); 
                        if($UpdateAkses){
                            //Catat Log Aktivitas
                            $MenyimpanLog=getSaveLog($Conn,$WaktuLog,$SessionNama,"Edit Password User","Akses",$SessionIdAkses,$LogJsonFile);
                            if($MenyimpanLog=="Berhasil"){
                                echo '<i id="Notifikasi">Edit Password Berhasil</i>';
                            }else{
                                echo '<i id="Notifikasi">Terjadi kesalahan pada saat menyimp log</i>';
                            }
                        }else{
                            echo '<i id="Notifikasi">Edit Password Gagal</i>';
                        }
                    }
                }
            }
        }
    }
?>