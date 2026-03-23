<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    $now=date('Y-m-d H:i:s');
    //Validasi Form Data
    if(empty($_POST['id_setting_satusehat'])){
        $id_setting_satusehat="";
    }else{
        $id_setting_satusehat=$_POST['id_setting_satusehat'];
    }
    if(empty($_POST['status'])){
        $status="Non-Active";
    }else{
        $status=$_POST['status'];
    }
    if(empty($_POST['nama_setting'])){
        echo '<span class="text-danger">Nama Setting Tidak Boleh Kosong</span>';
    }else{
        if(empty($_POST['oauth_baseurl'])){
            echo '<span class="text-danger">OAuth Baseurl Tidak Boleh Kosong</span>';
        }else{
            if(empty($_POST['baseurl'])){
                echo '<span class="text-danger">Base URL Tidak Boleh Kosong</span>';
            }else{
                if(empty($_POST['consent_url'])){
                    echo '<span class="text-danger">Consent URL Tidak Boleh Kosong</span>';
                }else{
                    if(empty($_POST['organization_id'])){
                        echo '<span class="text-danger">Organization ID Tidak Boleh Kosong</span>';
                    }else{
                        if(empty($_POST['client_key'])){
                            echo '<span class="text-danger">Client Key Tidak Boleh Kosong</span>';
                        }else{
                            if(empty($_POST['secret_key'])){
                                echo '<span class="text-danger">Secret Key Tidak Boleh Kosong</span>';
                            }else{
                                if(empty($_POST['kfa_url'])){
                                    echo '<span class="text-danger">URL KFA Tidak Boleh Kosong</span>';
                                }else{
                                    if(empty($_POST['masterdata_url'])){
                                        echo '<span class="text-danger">URL Master Data Tidak Boleh Kosong</span>';
                                    }else{
                                        //Bentuk variabel
                                        $nama_setting=$_POST['nama_setting'];
                                        $oauth_baseurl=$_POST['oauth_baseurl'];
                                        $baseurl=$_POST['baseurl'];
                                        $consent_url=$_POST['consent_url'];
                                        $kfa_url=$_POST['kfa_url'];
                                        $masterdata_url=$_POST['masterdata_url'];
                                        $organization_id=$_POST['organization_id'];
                                        $client_key=$_POST['client_key'];
                                        $secret_key=$_POST['secret_key'];
                                        //Apabila Status Active maka Non Aktifkan Yang Lainnya
                                        if($status=="Active"){
                                            $NonAktifkan= mysqli_query($Conn,"UPDATE setting_satusehat SET status='Non-Active'") or die(mysqli_error($Conn)); 
                                        }
                                        if(empty($_POST['id_setting_satusehat'])){
                                            $ValidasiDuplikat=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM setting_satusehat WHERE nama_setting='$nama_setting' AND nama_setting='$nama_setting'"));
                                            if(!empty($ValidasiDuplikat)){
                                                echo '<span class="text-danger">Nama Setting Tersebut Sudah Ada</span>';
                                            }else{
                                                //Insert Setting
                                                $entry="INSERT INTO setting_satusehat (
                                                    nama_setting,
                                                    oauth_baseurl,
                                                    baseurl,
                                                    consent_url,
                                                    kfa_url,
                                                    masterdata_url,
                                                    organization_id,
                                                    client_key,
                                                    secret_key,
                                                    status,
                                                    updatetime
                                                ) VALUES (
                                                    '$nama_setting',
                                                    '$oauth_baseurl',
                                                    '$baseurl',
                                                    '$consent_url',
                                                    '$kfa_url',
                                                    '$masterdata_url',
                                                    '$organization_id',
                                                    '$client_key',
                                                    '$secret_key',
                                                    '$status',
                                                    '$now'
                                                )";
                                                $Input=mysqli_query($Conn, $entry);
                                                if($Input){
                                                    $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Insert Setting Satu Sehat","Setting",$SessionIdAkses,$LogJsonFile);
                                                    if($MenyimpanLog=="Berhasil"){
                                                        $_SESSION['NotifikasiSwal']="Simpan Setting Berhasil";
                                                        echo '<span class="text-success" id="NotifikasiSimpanSettingSatuSehatBerhasil">Success</span>';
                                                    }else{
                                                        echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                                                    }
                                                }else{
                                                    echo '<span class="text-danger">Simpan Setting Gagal!</span>';
                                                }
                                            }
                                        }else{
                                            //Proses Update
                                            $UpdateSettingSatuSehat= mysqli_query($Conn,"UPDATE setting_satusehat SET 
                                                nama_setting='$nama_setting',
                                                oauth_baseurl='$oauth_baseurl',
                                                baseurl='$baseurl',
                                                consent_url='$consent_url',
                                                kfa_url='$kfa_url',
                                                masterdata_url='$masterdata_url',
                                                organization_id='$organization_id',
                                                client_key='$client_key',
                                                secret_key='$secret_key',
                                                status='$status',
                                                updatetime='$now'
                                            WHERE id_setting_satusehat='$id_setting_satusehat'") or die(mysqli_error($Conn)); 
                                            if($UpdateSettingSatuSehat){
                                                $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Update Setting Satu Sehat","Setting",$SessionIdAkses,$LogJsonFile);
                                                if($MenyimpanLog=="Berhasil"){
                                                    $_SESSION['NotifikasiSwal']="Simpan Setting Berhasil";
                                                    echo '<span class="text-success" id="NotifikasiSimpanSettingSatuSehatBerhasil">Success</span>';
                                                }else{
                                                    echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                                                }
                                            }else{
                                                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Update Setting Satu Sehat!</span>';
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