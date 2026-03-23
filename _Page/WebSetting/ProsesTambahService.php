<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    $updatetime=date('Y-m-d H:i');
    //Validasi Form Data
    if(empty($_POST['service_name'])){
        echo '<span class="text-danger">Nama service Tidak Boleh Kosong</span>';
    }else{
        if(empty($_POST['service_category'])){
            echo '<span class="text-danger">Kategori service Tidak Boleh Kosong</span>';
        }else{
            if(empty($_POST['url_service'])){
                echo '<span class="text-danger">URL service Tidak Boleh Kosong</span>';
            }else{
                $service_name=$_POST['service_name'];
                $service_category=$_POST['service_category'];
                $url_service=$_POST['url_service'];
                //Cek Apakah Data Setting Web Info Sudah Ada
                $Qry = mysqli_query($Conn,"SELECT * FROM setting_service WHERE service_name='service_name'")or die(mysqli_error($Conn));
                $Data = mysqli_fetch_array($Qry);
                if(!empty($Data['id_setting_service'])){
                    echo '<span class="text-danger">Service Tersebut Sudah Ada</span>';
                }else{
                    //Apabila Belum Ada Lakukan Insert
                    $QryService = "INSERT INTO setting_service (
                        service_name, 
                        service_category,
                        url_service,
                        last_update
                    ) VALUES (
                        '$service_name',
                        '$service_category',
                        '$url_service',
                        '$updatetime'
                    )";
                    $SimpanService = mysqli_query($Conn, $QryService);
                    if($SimpanService){
                        echo '<span class="text-success" id="NotifikasiTambahServiceBerhasil">Success</span>';
                    }else{
                        echo '<span class="text-danger">Tambah Service Gagal</span>';
                    }
                }
            }
        }
    }
?>