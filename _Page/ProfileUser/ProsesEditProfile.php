<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    $WaktuLog=date('Y-m-d H:i:s');
    if(empty($_POST['nama'])){
        echo '<span id="NotifikasiBerhasil" class="text-danger">Nama Tidak Boleh Kosong</span>';
    }else{
        if(empty($_POST['email'])){
            echo '<span id="NotifikasiBerhasil" class="text-danger">Email Tidak Boleh Kosong</span>';
        }else{
            if(empty($_POST['kontak'])){
                echo '<span id="NotifikasiBerhasil" class="text-danger">Nomor Kontak Tidak Boleh Kosong</span>';
            }else{
                $nama=$_POST['nama'];
                $JmlhKarNama = strlen($nama);
                $email=$_POST['email'];
                $JmlhKarEmail = strlen($email);
                $kontak=$_POST['kontak'];
                $JmlhKarKontak = strlen($kontak);
                //Membuka email lama
                $QueryAkses = mysqli_query($Conn,"SELECT * FROM akses WHERE id_akses='$SessionIdAkses'")or die(mysqli_error($Conn));
                $DataAkses = mysqli_fetch_array($QueryAkses);
                $EmailLama= $DataAkses['email'];
                //Validasi Email Sama
                if($email==$EmailLama){
                    $ValidasiEmailSama="0";
                }else{
                    $ValidasiEmailSama=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akses WHERE email='$email'"));
                }
                if(!empty($ValidasiEmailSama)){
                    echo '<span id="NotifikasiBerhasil" class="text-danger">Email Tersebut Sudah Digunakan</span>';
                }else{
                    if($JmlhKarNama>50){
                        echo '<span id="NotifikasiBerhasil" class="text-danger">Nama maksimal 50 karakter</span>';
                    }else{
                        if($JmlhKarEmail>50){
                            echo '<span id="NotifikasiBerhasil" class="text-danger">Email maksimal 50 karakter</span>';
                        }else{
                            if($JmlhKarKontak>15){
                                echo '<span id="NotifikasiBerhasil" class="text-danger">Kontak maksimal 15 karakter</span>';
                            }else{
                                $UpdateAkses = mysqli_query($Conn,"UPDATE akses SET 
                                    nama='$nama',
                                    email='$email',
                                    kontak='$kontak'
                                WHERE id_akses='$SessionIdAkses'") or die(mysqli_error($Conn)); 
                                if($UpdateAkses){
                                    $MenyimpanLog=getSaveLog($Conn,$WaktuLog,$SessionNama,"Edit Profile","My Profile",$SessionIdAkses,$LogJsonFile);
                                    if($MenyimpanLog=="Berhasil"){
                                        $_SESSION['NotifikasiSwal']="Edit Profile Berhasil";
                                        echo '<span id="NotifikasiBerhasil" class="text-info">Success</span>';
                                    }else{
                                        echo '<span class="text-danger">Gagal Menyimpan Log!</span>';
                                    } 
                                }else{
                                    echo '<span id="NotifikasiBerhasil" class="text-danger">Edit Profile Gagal</span>';
                                }
                            }
                        }
                    }
                }
            }
        }
    }
?>