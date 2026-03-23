<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    $WaktuLog=date('Y-m-d H:i:s');
    //Validasi Form Data
    if(empty($_POST['password1'])){
        echo '<span class="text-danger">Password Tidak Boleh Kosong</span>';
    }else{
        if(empty($_POST['password2'])){
            echo '<span class="text-danger">Password Tidak Boleh Kosong</span>';
        }else{
            $password1=$_POST['password1'];
            $JmlhKarPassword = strlen($password1);
            $password2=$_POST['password2'];
            if($JmlhKarPassword<6){
                echo '<span class="text-danger" id="NotifikasiBerhasil">Password Harus 6-20 karakter</span>';
            }else{
                if($JmlhKarPassword>20){
                    echo '<span class="text-danger" id="NotifikasiBerhasil">Password Harus 6-20 karakter</span>';
                }else{
                    if($password1!==$password2){
                        echo '<span class="text-danger" id="NotifikasiBerhasil">Password harus sama</span>';
                    }else{
                        //Proses Enkripsi MD5
                        $PasswordEnkripsi=MD5($password1);
                        $UpdateAkses = mysqli_query($Conn,"UPDATE akses SET 
                            password='$PasswordEnkripsi'
                        WHERE id_akses='$SessionIdAkses'") or die(mysqli_error($Conn)); 
                        if($UpdateAkses){
                            $MenyimpanLog=getSaveLog($Conn,$WaktuLog,$SessionNama,"Ubah Password","My Profile",$SessionIdAkses,$LogJsonFile);
                            if($MenyimpanLog=="Berhasil"){
                                $_SESSION['NotifikasiSwal']="Ubah Password Berhasil";
                                echo '<span id="NotifikasiUbahPasswordBerhasil" class="text-success">Success</span>';
                            }else{
                                echo '<span class="text-danger">Gagal Menyimpan Log!</span>';
                            }
                        }else{
                            echo '<span class="text-danger">Ubah password Gagal</span>';
                        }
                    }
                }
            }
        }
    }
?>