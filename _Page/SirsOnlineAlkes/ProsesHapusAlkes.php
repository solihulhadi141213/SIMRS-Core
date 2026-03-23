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
        $data = array(
            'id_kebutuhan' => $id_kebutuhan
        );
        $json_data = json_encode($data);
        //Kirim Data
        $KirimData=HapusAlkes($x_id_rs,$password_sirs_online,$url_sirs_online,$json_data);
        if(empty($KirimData)){
            echo '<span class="text-danger">Tidak ada response dari service SIRS Online</span>';
        }else{
            $response = json_decode($KirimData, true);
            $status=$response['apd'][0]['status'];
            if($status=="200"){
                $MenyimpanLog=getSaveLog($Conn,$WaktuLog,$SessionNama,"Hapus Alkes","Alkes SIRS Online",$SessionIdAkses,$LogJsonFile);
                if($MenyimpanLog=="Berhasil"){
                    echo '<span class="text-success" id="NotifikasiHapusAlkesBerhasil">Success</span>';
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
?>