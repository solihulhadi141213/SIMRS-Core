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
    //Validasi Data tidak boleh Kosong
    if(empty($_POST['id_t_tt'])){
        echo '<span class="text-danger">ID Record Tidak Boleh Kosong</span>';
    }else{
        $id_t_tt=$_POST['id_t_tt'];
        //Buat JSON
        $data = array(
            'id_t_tt' => $id_t_tt
        );
        $json_data = json_encode($data);
        //Kirim Data
        $KirimData=HapusTempatTidur($x_id_rs,$password_sirs_online,$url_sirs_online,$json_data);
        if(empty($KirimData)){
            echo '<span class="text-danger">Tidak ada response dari service SIRS online</span>';
        }else{
            $php_array = json_decode($KirimData, true);
            $status=$php_array['fasyankes']['0']['status'];
            $message=$php_array['fasyankes']['0']['message'];
            if($status=="200"){
                echo '<span class="text-success" id="NotifikasiHapusTempatTidurBerhasil">Success</span>';
            }else{
                echo '<span class="text-danger">Terjadi kesalahan pada saat mengirim data</span>';
                echo '<p class="text-danger">'.$message.'</p>';
            }
        }
    }
?>