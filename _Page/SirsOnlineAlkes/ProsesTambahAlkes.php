<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    //Koneksi ke database
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/FungsiSirsOnline.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    $WaktuLog=date('Y-m-d H:i:s');
    //Buka Pengaturan SIRS Online
    $x_id_rs=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','id_rs');
    $url_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','url_sirs_online');
    $password_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','password_sirs_online');
    //Buat Variabel
    if(empty($_POST['id_kebutuhan'])){
        echo '<span class="text-danger">ID Kebutuhan Tidak Boleh Kosong!</span>';
    }else{
        $id_kebutuhan=$_POST['id_kebutuhan'];
        if(empty($_POST['jumlah'])){
            $jumlah="0";
        }else{
            $jumlah=$_POST['jumlah'];
        }
        if(empty($_POST['jumlah_eksisting'])){
            $jumlah_eksisting="0";
        }else{
            $jumlah_eksisting=$_POST['jumlah_eksisting'];
        }
        if(empty($_POST['jumlah_diterima'])){
            $jumlah_diterima="0";
        }else{
            $jumlah_diterima=$_POST['jumlah_diterima'];
        }
        //Validasi angka dan desimal
        if(!preg_match('/^[0-9]+(?:\.[0-9]+)?$/', $id_kebutuhan)){
            echo '<span class="text-danger">ID Kebutuhan hanya bolehh angka</span>';
        }else{
            if(!preg_match('/^[0-9]+(?:\.[0-9]+)?$/', $jumlah)){
                echo '<span class="text-danger">Jumlah Alkes Hanya Boleh Angka</span>';
            }else{
                if(!preg_match('/^[0-9]+(?:\.[0-9]+)?$/', $jumlah_eksisting)){
                    echo '<span class="text-danger">Jumlah Eksisting Hanya Boleh Angka</span>';
                }else{
                    if(!preg_match('/^[0-9]+(?:\.[0-9]+)?$/', $jumlah_diterima)){
                        echo '<span class="text-danger">Jumlah Diterima Hanya Boleh Angka</span>';
                    }else{
                        $data = array(
                            'id_kebutuhan' => $id_kebutuhan,
                            'jumlah_eksisting' => $jumlah_eksisting,
                            'jumlah' => $jumlah,
                            'jumlah_diterima' => $jumlah_diterima,
                        );
                        $json_data = json_encode($data);
                        //Kirim Data
                        $KirimData=TambahAlkes($x_id_rs,$password_sirs_online,$url_sirs_online,$json_data);
                        if(empty($KirimData)){
                            echo '<span class="text-danger">Tidak ada response dari service SIRS Online</span>';
                        }else{
                            $response = json_decode($KirimData, true);
                            $status=$response['apd'][0]['status'];
                            if($status=="200"){
                                $MenyimpanLog=getSaveLog($Conn,$WaktuLog,$SessionNama,"Tambah Alkes","Alkes SIRS Online",$SessionIdAkses,$LogJsonFile);
                                if($MenyimpanLog=="Berhasil"){
                                    echo '<span class="text-success" id="NotifikasiTambahAlkesBerhasil">Success</span>';
                                }else{
                                    echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                                }
                            }else{
                                $message=$response['apd'][0]['message'];
                                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Mmengirim data ke service SIRS Online!</span>';
                                echo '<textarea class="form-control">'.$message.'</textarea>';
                            }
                        }
                    }
                }
            }
        }
    }
?>