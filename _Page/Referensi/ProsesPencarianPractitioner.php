<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $now=date('Y-m-d H:i:s');
    if(empty($_POST['kategori_pencarian_practitioner'])){
        echo '<span class="text-danger">Kategori Pencarian Tidak Boleh Kosong!</span>';
    }else{
        $kategori_pencarian_practitioner=$_POST['kategori_pencarian_practitioner'];
        if(empty($_POST['nik'])){
            $nik="";
        }else{
            $nik=$_POST['nik'];
        }
        if(empty($_POST['id_practitioner'])){
            $id_practitioner="";
        }else{
            $id_practitioner=$_POST['id_practitioner'];
        }
        if(empty($_POST['nama'])){
            $nama="";
        }else{
            $nama=$_POST['nama'];
        }
        if(empty($_POST['tanggal_lahir'])){
            $tanggal_lahir="";
        }else{
            $tanggal_lahir=$_POST['tanggal_lahir'];
        }
        if(empty($_POST['gender'])){
            $gender="";
        }else{
            $gender=$_POST['gender'];
        }
        if($kategori_pencarian_practitioner=="NIK"){
            if(empty($_POST['nik'])){
                $ValidasiForm="Nik Tidak Boleh Kosong!";
            }else{
                $ValidasiForm="Valid";
            }
        }else{
            if($kategori_pencarian_practitioner=="id_practitioner"){
                if(empty($_POST['id_practitioner'])){
                    $ValidasiForm="ID Practitioner Tidak Boleh Kosong!";
                }else{
                    $ValidasiForm="Valid";
                }
            }else{
                if($kategori_pencarian_practitioner=="Identitas"){
                    if(empty($_POST['tanggal_lahir'])){
                        $ValidasiForm="Tanggal Lahir Tidak Boleh Kosong!";
                    }else{
                        if(empty($_POST['gender'])){
                            $ValidasiForm="Gender Tidak Boleh Kosong!";
                        }else{
                            if(empty($_POST['nama'])){
                                $ValidasiForm="Nama Tidak Boleh Kosong!";
                            }else{
                                $ValidasiForm="Valid";
                            }
                        }
                    }
                }else{
                    $ValidasiForm="Kategori Pencarian Tidak Valid";
                }
            }
        }
        if($ValidasiForm!=="Valid"){
            echo '<span class="text-danger">'.$ValidasiForm.'</span>';
        }else{
            //Inisiasi Setting
            $SettingSatuSehat=getDataDetail($Conn,' setting_satusehat','status','Active','id_setting_satusehat');
            if(empty($SettingSatuSehat)){
                echo '<span class="text-danger">Tidak Ada Setting Satu Sehat Yang Aktif!</span>';
            }else{
                $Token=GenerateTokenSatuSehat($Conn);
                if(empty($Token)){
                    echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Melakukan Generate Token!</span>';
                }else{
                    //Inisiasi BaseURL
                    $baseurl_satusehat=getDataDetail($Conn,'setting_satusehat','status','Active','baseurl');
                    //Pencarian Berdasarkan Kategori
                    if($kategori_pencarian_practitioner=="NIK"){
                        $response=PractitionerByNik($baseurl_satusehat,$Token,$nik);
                    }else{
                        if($kategori_pencarian_practitioner=="Identitas"){
                            $response=PractitionerByIdentitas($baseurl_satusehat,$Token,$nama,$tanggal_lahir,$gender);
                        }else{
                            if($kategori_pencarian_practitioner=="id_practitioner"){
                                $response=PractitionerById($baseurl_satusehat,$Token,$id_practitioner);
                            }else{
                                $response=PractitionerById($baseurl_satusehat,$Token,$id_practitioner);
                            }
                        }
                    }
                    $JsonData =json_decode($response, true);
                    if($kategori_pencarian_practitioner=="id_practitioner"){
                        include "../../_Page/Referensi/ViewPractitionerById.php";
                    }else{
                        include "../../_Page/Referensi/ViewPractitionerByNik.php";
                    }
                }
            }
        }
    }
?>