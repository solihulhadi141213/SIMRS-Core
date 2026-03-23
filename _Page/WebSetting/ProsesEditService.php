<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    $updatetime=date('Y-m-d H:i');
    //Validasi Form Data
    if(empty($_POST['id_setting_service'])){
        echo '<span class="text-danger">ID service Tidak Boleh Kosong</span>';
    }else{
        if(empty($_POST['service_name'])){
            echo '<span class="text-danger">Nama service Tidak Boleh Kosong</span>';
        }else{
            if(empty($_POST['service_category'])){
                echo '<span class="text-danger">Kategori service Tidak Boleh Kosong</span>';
            }else{
                if(empty($_POST['url_service'])){
                    echo '<span class="text-danger">URL service Tidak Boleh Kosong</span>';
                }else{
                    $id_setting_service=$_POST['id_setting_service'];
                    $service_name=$_POST['service_name'];
                    $service_category=$_POST['service_category'];
                    $url_service=$_POST['url_service'];
                    //Apabila Sudah Ada Lakukan Proses Update
                    $UpdateSrvice= mysqli_query($Conn,"UPDATE setting_service SET 
                        service_name='$service_name',
                        service_category='$service_category',
                        url_service='$url_service',
                        last_update='$updatetime'
                    WHERE id_setting_service='$id_setting_service'") or die(mysqli_error($Conn)); 
                    if($UpdateSrvice){
                        echo '<span class="text-success" id="NotifikasiEditServiceBerhasil">Success</span>';
                    }else{
                        echo '<span class="text-danger">Update Setting Koneksi Gagal</span>';
                    }
                }
            }
        }
    }
?>