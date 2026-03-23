<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $JsonUrl="../../_Page/Log/Log.json";
    $now=date('Y-m-d H:i:s');
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
                    echo '<span class="text-danger">Hak/Entitas Akses Tidak Boleh Kosong</span>';
                }else{
                    if(empty($_POST['password'])){
                        echo '<span class="text-danger">Password Tidak Boleh Kosong</span>';
                    }else{
                        if(empty($_POST['password'])){
                            echo '<span class="text-danger">Password Tidak Boleh Kosong</span>';
                        }else{
                            if(empty($_POST['foto'])){
                                echo '<span class="text-danger">File Foto Tidak Boleh Kosong</span>';
                            }else{
                                if(empty($_POST['KirimEmailPemberitahuan'])){
                                    $KirimEmailPemberitahuan="";
                                }else{
                                    $KirimEmailPemberitahuan=$_POST['KirimEmailPemberitahuan'];
                                }
                                $nama=$_POST['nama'];
                                $JmlhKarNama = strlen($nama);
                                $email=$_POST['email'];
                                $JmlhKarEmail = strlen($email);
                                $kontak=$_POST['kontak'];
                                $JmlhKarKontak = strlen($kontak);
                                $password=$_POST['password'];
                                $JmlhKarPassword = strlen($password);
                                $akses=$_POST['akses'];
                                $foto=$_POST['foto'];
                                $ValidasiEmailSama=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akses WHERE email='$email'"));
                                //Directory1
                                $DirectoryAsal="../../assets/images/PengajuanAkses/$foto";
                                $DirectoryTujuan="../../assets/images/user/$foto";
                                //Validasi Email
                                if(!empty($ValidasiEmailSama)){
                                    echo '<span class="text-danger">Username Tersebut Sudah Digunakan</span>';
                                }else{
                                    $CopyFile = copy($DirectoryAsal, $DirectoryTujuan);
                                    if(empty($CopyFile)){
                                        echo '<span class="text-danger">Copy File Foto Gagal!</span>';
                                    }else{
                                        if($JmlhKarPassword<5){
                                            echo '<span class="text-danger">Password Hanya Boleh 5-20 karakter</span>';
                                        }else{
                                            if($JmlhKarPassword>20){
                                                echo '<span class="text-danger">Password Hanya Boleh 5-20 karakter</span>';
                                            }else{
                                                //Proses Enkripsi MD5
                                                $PasswordEnkripsi=MD5($password);
                                                //Buat Data Akses
                                                $EntryAkses="INSERT INTO akses (
                                                    tanggal,
                                                    nama,
                                                    email,
                                                    kontak,
                                                    password,
                                                    akses,
                                                    gambar,
                                                    updatetime
                                                ) VALUES (
                                                    '$now',
                                                    '$nama',
                                                    '$email',
                                                    '$kontak',
                                                    '$PasswordEnkripsi',
                                                    '$akses',
                                                    '$foto',
                                                    '$now'
                                                )";
                                                $InputAkses=mysqli_query($Conn, $EntryAkses);
                                                if($InputAkses){
                                                    //Buka Referensi entitas akses
                                                    $standar_referensi=getDataDetail($Conn,'akses_entitas','akses',$akses,'standar_referensi');
                                                    if(empty($standar_referensi)){
                                                        echo '<span class="text-danger">Akses tersebut belum memiliki standar ijin akses!</span>';
                                                        //Hapus Akses Karena gagal menyimpan ijin akses
                                                        $HapusAkses = mysqli_query($Conn, "DELETE FROM akses WHERE email='$email'") or die(mysqli_error($Conn));
                                                    }else{
                                                        $JsonReferensi= json_decode($standar_referensi,true);
                                                        $string=count($JsonReferensi);
                                                        $JumlahProses=0;
                                                        for($i=0; $i<$string; $i++){
                                                            $id_akses_ref=$JsonReferensi[$i]['id_akses_ref'];
                                                            $StatusItem=$JsonReferensi[$i]['status'];
                                                            //Save Acc Data
                                                            $id_akses=getDataDetail($Conn,'akses','email',$email,'id_akses');
                                                            $SimpanAcc=saveAccData($Conn,$id_akses,$id_akses_ref,$StatusItem);
                                                            if($SimpanAcc=="Berhasil"){
                                                                $JumlahProses=$JumlahProses+1;
                                                            }else{
                                                                $JumlahProses=$JumlahProses+0;
                                                            }
                                                        }
                                                        if($JumlahProses!==$string){
                                                            echo '<span class="text-danger">Terjadi kesalahan pada saat menyimpan data ijin akses!'.$JumlahProses.'/'.$string.'</span>';
                                                            //Hapus Akses Karena gagal menyimpan ijin akses
                                                            $HapusAkses = mysqli_query($Conn, "DELETE FROM akses WHERE email='$email'") or die(mysqli_error($Conn));
                                                        }else{
                                                            //Update Permintaan Akses
                                                            $UpdatePermintaan = mysqli_query($Conn,"UPDATE akses_pengajuan SET 
                                                                status='Diterima'
                                                            WHERE email='$email'") or die(mysqli_error($Conn)); 
                                                            if($UpdatePermintaan){
                                                                if($KirimEmailPemberitahuan=="Ya"){
                                                                    //Kirim Email
                                                                    $email_tujuan=$email;
                                                                    $nama_tujuan=$nama;
                                                                    $pesan='
                                                                    Pengajuan akses anda telah diterima dan telah melalui proses verifikasi. 
                                                                    Beriku ini adalah informasi akses yang bisa anda gunakan.<br>
                                                                    <b>Email :</b> '.$email.'<br>
                                                                    <b>Password :</b> '.$password.'<br>
                                                                    Silahkan lakukan login pada aplikasi menggunakan informasi tersebut.
                                                                    ';
                                                                    $subjek='Pengajuan Akses Diterima';
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
                                                                        //Menyimpan Log
                                                                        $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Menerima Pengajuan Akses","Akses",$SessionIdAkses,$JsonUrl);
                                                                        if($MenyimpanLog=="Berhasil"){
                                                                            $JsonData =json_decode($content, true);
                                                                            $_SESSION['NotifikasiSwal']="Terima Pengajuan Berhasil";
                                                                            echo '<span class="text-success" id="NotifikasiTerimaPengajuanBerhasil">Success</span>';
                                                                        }else{
                                                                            echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                                                                        }
                                                                    }
                                                                }else{
                                                                    //Menyimpan Log
                                                                    $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Menerima Pengajuan Akses","Akses",$SessionIdAkses,$JsonUrl);
                                                                    if($MenyimpanLog=="Berhasil"){
                                                                        $_SESSION['NotifikasiSwal']="Terima Pengajuan Berhasil";
                                                                        echo '<span class="text-success" id="NotifikasiTerimaPengajuanBerhasil">Success</span>';
                                                                    }else{
                                                                        echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                                                                    }
                                                                }
                                                            }else{
                                                                echo '<span class="text-danger">Terjadi kesalahan pada saat melakukan update status permintaan!</span>';
                                                                //Hapus Akses Karena gagal melakukan update
                                                                $HapusAkses = mysqli_query($Conn, "DELETE FROM akses WHERE email='$email'") or die(mysqli_error($Conn));
                                                            }
                                                        }
                                                    }
                                                }else{
                                                    echo '<span class="text-danger">Terjadi kesalahan pada saat menyimpan data akses!</span>';
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