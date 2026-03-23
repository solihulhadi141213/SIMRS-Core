<?php
    date_default_timezone_set('Asia/Jakarta');
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
    if(empty($_POST['id_kebutuhan'])){
        echo '<span class="text-danger">ID Kebutuhan Tidak Boleh Kosong!</span>';
    }else{
        if(empty($_POST['kebutuhan'])){
            $kebutuhan="0";
        }else{
            $kebutuhan=$_POST['kebutuhan'];
        }
        if(empty($_POST['JumlahEksisting'])){
            $jumlah_eksisting="0";
        }else{
            $jumlah_eksisting=$_POST['JumlahEksisting'];
        }
        if(empty($_POST['jumlah'])){
            $jumlah="0";
        }else{
            $jumlah=$_POST['jumlah'];
        }
        if(empty($_POST['jumlah_diterima'])){
            $jumlah_diterima="0";
        }else{
            $jumlah_diterima=$_POST['jumlah_diterima'];
        }
        $id_kebutuhan=$_POST['id_kebutuhan'];
        if (!is_numeric($id_kebutuhan)) {
            echo '<span class="text-danger">ID Kebutuhan Hanya Boleh Angka (Value: '.$id_kebutuhan.')</span>';
        }else{
            if (!is_numeric($jumlah_eksisting)) {
                echo '<span class="text-danger">Jumlah Eksisting Hanya Boleh Angka</span>';
            }else{
                if (!is_numeric($jumlah)) {
                    echo '<span class="text-danger">Jumlah Yang Dibutuhkan Hanya Boleh Angka</span>';
                }else{
                    if (!is_numeric($jumlah_diterima)) {
                        echo '<span class="text-danger">Jumlah Yang Diterima Hanya Boleh Angka</span>';
                    }else{
                        //Buat Array
                        $data = array(
                            'id_kebutuhan' => ''.$id_kebutuhan.'',
                            'jumlah_eksisting' => ''.$jumlah_eksisting.'',
                            'jumlah' => ''.$jumlah.'',
                            'jumlah_diterima' => ''.$jumlah_diterima.''
                        );
                        // Encode array menjadi JSON
                        $json = json_encode($data);
                        $KirimData=CreatSdmSirsOnline($x_id_rs,$password_sirs_online,$url_sirs_online,$json);
                        $json_decode = json_decode($KirimData, true);
                        $response=$json_decode['sdm'];
                        $status=$json_decode['sdm'][0]['status'];
                        $message=$json_decode['sdm'][0]['message'];
                        if($message=="Success"){
                            $MenyimpanLog=getSaveLog($Conn,$WaktuLog,$SessionNama,"Creat Nakes Sirs Online","Nakes",$SessionIdAkses,$LogJsonFile);
                            if($MenyimpanLog=="Berhasil"){
                                echo '<span class="text-success" id="NotifikasiCreatSdmBerhasil">Success</span>';
                            }else{
                                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                            }
                        }else{
                            echo '<span class="text-danger">Creat Data Nakes Gagal!<br> Pesan : '.$message.'</span>';
                        }
                    }
                }
            }
        }
    }
?>