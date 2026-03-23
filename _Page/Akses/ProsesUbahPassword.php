<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $now=date('Y-m-d H:i:s');
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
                if(empty($_POST['email'])){
                    echo '<span class="text-danger">Email Tidak Boleh Kosong</span>';
                }else{
                    $id_akses=$_POST['id_akses'];
                    $email=$_POST['email'];
                    $password1=$_POST['password1'];
                    $password2=$_POST['password2'];
                    $JumlahPassword1 = strlen($password1);
                    $JumlahPassword2 = strlen($password2);
                    $NamaAkses=getDataDetail($Conn,'akses','id_akses',$id_akses,'nama');
                    if(empty($_POST['KirimPassworedBaru'])){
                        $KirimPassworedBaru="";
                    }else{
                        $KirimPassworedBaru=$_POST['KirimPassworedBaru'];
                    }
                    if($JumlahPassword1<5||$JumlahPassword1>50){
                        echo '<span class="text-danger">Password Harus 6-20 karakter</span>';
                    }else{
                        if($JumlahPassword2<5||$JumlahPassword2>50){
                            echo '<span class="text-danger">Password Harus 6-20 karakter</span>';
                        }else{
                            $PasswordEnkripsi=MD5($password1);
                            $UpdateAkses = mysqli_query($Conn,"UPDATE akses SET 
                                password='$PasswordEnkripsi',
                                updatetime='$now'
                            WHERE id_akses='$id_akses'") or die(mysqli_error($Conn)); 
                            if($UpdateAkses){
                                if($KirimPassworedBaru=="Ya"){
                                    //Kirim Email
                                    $email_tujuan=$email;
                                    $nama_tujuan=$NamaAkses;
                                    $pesan='
                                    Petugas kami telah melakukan perubahan password akun anda. 
                                    Beriku ini adalah informasi akses yang bisa anda gunakan.<br>
                                    <b>Email :</b> '.$email.'<br>
                                    <b>Password :</b> '.$password1.'<br>
                                    Silahkan lakukan login pada aplikasi menggunakan informasi tersebut.
                                    ';
                                    $subjek='Perubahan Password Akun Akses';
                                    //Membuka Pengaturan
                                    $EmailGateway=getEmailSetting($Conn,'email_gateway');
                                    $PasswordGateway=getEmailSetting($Conn,'password_gateway');
                                    $UrlProvider=getEmailSetting($Conn,'url_provider');
                                    $PortGateway=getEmailSetting($Conn,'port_gateway');
                                    $NamaPengirim=getEmailSetting($Conn,'nama_pengirim');
                                    $UrlService=getEmailSetting($Conn,'url_service');
                                    //Kirim Email
                                    $KirimData = array(
                                        'subjek' => $subjek,
                                        'email_asal' => $EmailGateway,
                                        'password_email_asal' => $PasswordGateway,
                                        'url_provider' => $UrlProvider,
                                        'nama_pengirim' => $NamaPengirim,
                                        'email_tujuan' => $email_tujuan,
                                        'nama_tujuan' => $nama_tujuan,
                                        'pesan' => $pesan,
                                        'port' => $PortGateway
                                    );
                                    $json = json_encode($KirimData);
                                    //Mulai CURL
                                    $ch = curl_init();
                                    curl_setopt($ch,CURLOPT_URL, "$UrlService");
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
                                        $JsonUrl="../../_Page/Log/Log.json";
                                        //Menyimpan Log
                                        $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Menerima Pengajuan Akses","Akses",$SessionIdAkses,$JsonUrl);
                                        if($MenyimpanLog=="Berhasil"){
                                            $_SESSION['NotifikasiSwal']="Ubah Password Berhasil";
                                            echo '<span class="text-success" id="NotifikasiUbahPasswordBerhasil">Success</span>';
                                        }else{
                                            echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                                        }
                                    }
                                }else{
                                    $JsonUrl="../../_Page/Log/Log.json";
                                    $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Ubah Password Akses","Akses",$SessionIdAkses,$JsonUrl);
                                    if($MenyimpanLog=="Berhasil"){
                                        $_SESSION['NotifikasiSwal']="Ubah Password Berhasil";
                                        echo '<span class="text-success" id="NotifikasiUbahPasswordBerhasil">Success</span>';
                                    }else{
                                        echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                                    }
                                }
                            }else{
                                echo '<span class="text-danger">Update Password Gagal!</span>';
                            }
                        }
                    }
                }
            }
        }
    }
?>