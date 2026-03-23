<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/FungsiSirsOnline.php";
    //Buka Pengaturan SIRS Online
    $x_id_rs=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','id_rs');
    $url_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','url_sirs_online');
    $password_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','password_sirs_online');
    //Log
    $LogJsonFile="../../_Page/Log/Log.json";
    $WaktuLog=date('Y-m-d H:i:s');
    if(empty($_POST['id_shk'])){
        echo '<span class="text-danger">ID SHK Tidak Boleh Kosong!</span>';
    }else{
        if(empty($_POST['id_pasien_shk'])){
            echo '<span class="text-danger">ID Pasien SHK Tidak Boleh Kosong!</span>';
        }else{
            if(empty($_POST['HapusPasienShkSirsOnline'])){
                echo '<span class="text-danger">Keputusan Hapus Data SIRS Online Tidak Boleh Kosong!</span>';
            }else{
                $id_shk=$_POST['id_shk'];
                $id_pasien_shk=$_POST['id_pasien_shk'];
                $HapusPasienShkSirsOnline=$_POST['HapusPasienShkSirsOnline'];
                if($HapusPasienShkSirsOnline=="Ya"){
                    //Hapus Data Di SIRS Online
                    $data = array(
                        'id_shk' => $id_shk,
                        'koders' => $x_id_rs,
                    );
                    $json_data = json_encode($data);
                    //Kirim Data
                    $KirimData=HapusPasienShk($x_id_rs,$password_sirs_online,$url_sirs_online,$json_data);
                    if(empty($KirimData)){
                        $ProsesHapusSirsOnline="Gagal";
                        $AlasanKegagalanProses="Tidak ada response apapun dari service SIRS Online";
                    }else{
                        $response = json_decode($KirimData, true);
                        if($response['shk'][0]['status']=="200"){
                            $HapusPasienShk = mysqli_query($Conn, "DELETE FROM pasien_shk WHERE id_pasien_shk='$id_pasien_shk'") or die(mysqli_error($Conn));
                            if($HapusPasienShk){
                                $ProsesHapusSirsOnline="Berhasil";
                            }else{
                                $ProsesHapusSirsOnline="Gagal";
                                $AlasanKegagalanProses="Terjadi kesalahan saat menghapus data di database Pasien SHK";
                            }
                        }else{
                            $ProsesHapusSirsOnline="Gagal";
                            $AlasanKegagalanProses=$response['shk'][0]['message'];
                        }
                    }
                }else{
                    $HapusPasienShk = mysqli_query($Conn, "DELETE FROM pasien_shk WHERE id_pasien_shk='$id_pasien_shk'") or die(mysqli_error($Conn));
                    if($HapusPasienShk){
                        $ProsesHapusSirsOnline="Berhasil";
                    }else{
                        $ProsesHapusSirsOnline="Gagal";
                        $AlasanKegagalanProses="Terjadi kesalahan saat menghapus data di database Pasien SHK";
                    }
                }
                if($ProsesHapusSirsOnline!=="Berhasil"){
                    $_SESSION['NotifikasiSwal']="Hapus Pasien SHK Berhasil";
                    echo '<span class="text-danger">Hapus Data Pasien SHK di SIRS Online Gagal!</span><br>';
                    echo '<span class="text-danger">Keterangan : '.$AlasanKegagalanProses.'</span>';
                }else{
                    echo '<span class="text-success" id="NotifikasiHapusPasienShkBerhhasil">Success</span>';
                }
            }
        }
    }
?>