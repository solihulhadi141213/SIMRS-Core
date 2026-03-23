<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    $now=date('Y-m-d H:i:s');
    //Validasi Form Data
    if(empty($_POST['id_setting_sisrute'])){
        $id_setting_sisrute="";
    }else{
        $id_setting_sisrute=$_POST['id_setting_sisrute'];
    }
    if(empty($_POST['status'])){
        $status="Non-Active";
    }else{
        $status=$_POST['status'];
    }
    if(empty($_POST['nama_setting'])){
        echo '<span class="text-danger">Nama Setting Tidak Boleh Kosong</span>';
    }else{
        if(empty($_POST['url_sisrute'])){
            echo '<span class="text-danger">Baseurl Tidak Boleh Kosong</span>';
        }else{
            if(empty($_POST['id_rs'])){
                echo '<span class="text-danger">ID RS Tidak Boleh Kosong</span>';
            }else{
                if(empty($_POST['password_sisrute'])){
                    echo '<span class="text-danger">Password Tidak Boleh Kosong</span>';
                }else{
                    //Bentuk variabel
                    $nama_setting=$_POST['nama_setting'];
                    $url_sisrute=$_POST['url_sisrute'];
                    $id_rs=$_POST['id_rs'];
                    $password_sisrute=$_POST['password_sisrute'];
                    //Apabila Status Active maka Non Aktifkan Yang Lainnya
                    if($status=="Aktiv"){
                        $NonAktifkan= mysqli_query($Conn,"UPDATE setting_sisrute SET status='Non-Aktiv'") or die(mysqli_error($Conn)); 
                    }
                    if(empty($_POST['id_setting_sisrute'])){
                        $ValidasiDuplikat=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM setting_sisrute WHERE nama_setting='$nama_setting'"));
                        if(!empty($ValidasiDuplikat)){
                            echo '<span class="text-danger">Nama Setting Tersebut Sudah Ada</span>';
                        }else{
                            //Insert Setting
                            $entry="INSERT INTO setting_sisrute (
                                nama_setting,
                                url_sisrute,
                                id_rs,
                                password_sisrute,
                                status
                            ) VALUES (
                                '$nama_setting',
                                '$url_sisrute',
                                '$id_rs',
                                '$password_sisrute',
                                '$status'
                            )";
                            $Input=mysqli_query($Conn, $entry);
                            if($Input){
                                $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Insert Setting SISRUTE","Setting",$SessionIdAkses,$LogJsonFile);
                                if($MenyimpanLog=="Berhasil"){
                                    $_SESSION['NotifikasiSwal']="Simpan Setting Berhasil";
                                    echo '<span class="text-success" id="NotifikasiSimpanSettingSisruteBerhasil">Success</span>';
                                }else{
                                    echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                                }
                            }else{
                                echo '<span class="text-danger">Simpan Setting Gagal!</span>';
                            }
                        }
                    }else{
                        //Proses Update
                        $UpdateSisrute= mysqli_query($Conn,"UPDATE setting_sisrute SET 
                            nama_setting='$nama_setting',
                            url_sisrute='$url_sisrute',
                            id_rs='$id_rs',
                            password_sisrute='$password_sisrute',
                            status='$status'
                        WHERE id_setting_sisrute='$id_setting_sisrute'") or die(mysqli_error($Conn)); 
                        if($UpdateSisrute){
                            $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Update Setting SISRUTE","Setting",$SessionIdAkses,$LogJsonFile);
                            if($MenyimpanLog=="Berhasil"){
                                $_SESSION['NotifikasiSwal']="Simpan Setting Berhasil";
                                echo '<span class="text-success" id="NotifikasiSimpanSettingSisruteBerhasil">Success</span>';
                            }else{
                                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                            }
                        }else{
                            echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Update Setting SISRUTE!</span>';
                        }
                    }
                }
            }
        }
    }
?>