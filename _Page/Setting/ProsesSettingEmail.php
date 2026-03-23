<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    $now=date('Y-m-d H:i');
    if(empty($_POST['EmailGateway'])){
        echo '<span class="text-danger">Email Tidak Boleh Kosong!</span>';
    }else{
        if(empty($_POST['PasswordGateway'])){
            echo '<span class="text-danger">Password Tidak Boleh Kosong!</span>';
        }else{
            if(empty($_POST['UrlProvider'])){
                echo '<span class="text-danger">URL Provider Tidak Boleh Kosong!</span>';
            }else{
                if(empty($_POST['PortGateway'])){
                    echo '<span class="text-danger">PORT Tidak Boleh Kosong!</span>';
                }else{
                    if(empty($_POST['NamaPengirim'])){
                        echo '<span class="text-danger">Nama Pengirim Tidak Boleh Kosong!</span>';
                    }else{
                        if(empty($_POST['UrlService'])){
                            echo '<span class="text-danger">URL Service Tidak Boleh Kosong!</span>';
                        }else{
                            if(empty($_POST['id_setting_email_gateway'])){
                                $id_setting_email_gateway="";
                            }else{
                                $id_setting_email_gateway=$_POST['id_setting_email_gateway'];
                            }
                            if(empty($_POST['status'])){
                                $status="Non-Active";
                            }else{
                                $status=$_POST['status'];
                            }
                            $email_gateway=$_POST['EmailGateway'];
                            $password_gateway=$_POST['PasswordGateway'];
                            $url_provider=$_POST['UrlProvider'];
                            $port_gateway=$_POST['PortGateway'];
                            $nama_pengirim=$_POST['NamaPengirim'];
                            $url_service=$_POST['UrlService'];
                            //Apabila Status Active maka Non Aktifkan Yang Lainnya
                            if($status=="Active"){
                                $NonAktifkan= mysqli_query($Conn,"UPDATE setting_email_gateway SET status='Non-Active'") or die(mysqli_error($Conn)); 
                            }
                            if(empty($_POST['id_setting_email_gateway'])){
                                $ValidasiDuplikat=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM setting_email_gateway WHERE email_gateway='$email_gateway' AND url_service='$url_service'"));
                                if(!empty($ValidasiDuplikat)){
                                    echo '<span class="text-danger">Profile Setting Tersebut Sudah Ada</span>';
                                }else{
                                    $entry="INSERT INTO setting_email_gateway (
                                        email_gateway,
                                        password_gateway,
                                        url_provider,
                                        port_gateway,
                                        nama_pengirim,
                                        url_service,
                                        status
                                    ) VALUES (
                                        '$email_gateway',
                                        '$password_gateway',
                                        '$url_provider',
                                        '$port_gateway',
                                        '$nama_pengirim',
                                        '$url_service',
                                        '$status'
                                    )";
                                    $Input=mysqli_query($Conn, $entry);
                                    if($Input){
                                        $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Simpan Setting Email","Setting",$SessionIdAkses,$LogJsonFile);
                                        if($MenyimpanLog=="Berhasil"){
                                            $_SESSION['NotifikasiSwal']="Simpan Setting Berhasil";
                                            echo '<span class="text-success" id="NotifikasiSimpanSettingEmailBerhasil">Success</span>';
                                        }else{
                                            echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                                        }
                                    }else{
                                        echo '<span class="text-danger">Simpan Setting Email Gagal!</span>';
                                    }
                                }
                            }else{
                                $UpdateSettingEmail = mysqli_query($Conn,"UPDATE setting_email_gateway SET 
                                    email_gateway='$email_gateway',
                                    password_gateway='$password_gateway',
                                    url_provider='$url_provider',
                                    port_gateway='$port_gateway',
                                    nama_pengirim='$nama_pengirim',
                                    url_service='$url_service',
                                    status='$status'
                                WHERE id_setting_email_gateway='$id_setting_email_gateway'") or die(mysqli_error($Conn)); 
                                if($UpdateSettingEmail){
                                    $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Edit Setting Email","Setting",$SessionIdAkses,$LogJsonFile);
                                    if($MenyimpanLog=="Berhasil"){
                                        $_SESSION['NotifikasiSwal']="Simpan Setting Berhasil";
                                        echo '<span class="text-success" id="NotifikasiSimpanSettingEmailBerhasil">Success</span>';
                                    }else{
                                        echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                                    }
                                }else{
                                    echo '<span class="text-danger">Edit Setting Email Gateway Gagal!</span>';
                                }
                            }
                        }
                    }
                }
            }
        }
    }
?>