<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    $updatetime=date('Y-m-d H:i');
    //Validasi Form Data
    if(empty($_POST['from_replice'])){
        echo '<span class="text-danger">Form Ubah Dari Tidak Boleh Kosong</span>';
    }else{
        if(empty($_POST['to_replice'])){
            echo '<span class="text-danger">Form Ubah Ke Tidak Boleh Kosong</span>';
        }else{
            $from_replice=$_POST['from_replice'];
            $to_replice=$_POST['to_replice'];
            //Melakukan array semua service
            $jumlahTotal=0;
            $JumlahBerhasil=0;
            $QryService = mysqli_query($Conn, "SELECT*FROM setting_service");
            while ($DataService = mysqli_fetch_array($QryService)) {
                $id_setting_service= $DataService['id_setting_service'];
                $service_name= $DataService['service_name'];
                $service_category= $DataService['service_category'];
                $url_service= $DataService['url_service'];
                $LastUpdateList= $DataService['last_update'];
                $StrTotime= strtotime($LastUpdateList);
                $LastUpdateList2= date('d/m/Y H:i',$StrTotime);
                //Melakukan replace
                $CountFind=str_replace("$from_replice","$to_replice","$url_service");
                //Apabila Sudah Ada Lakukan Proses Update
                $UpdateSrvice= mysqli_query($Conn,"UPDATE setting_service SET 
                    url_service='$CountFind'
                WHERE id_setting_service='$id_setting_service'") or die(mysqli_error($Conn)); 
                if($UpdateSrvice){
                    $berhasil=1;
                }else{
                    $berhasil=0;
                }
                $jumlahTotal=$jumlahTotal+1;
                $JumlahBerhasil=$JumlahBerhasil+$berhasil;
            }
            if($jumlahTotal!==$JumlahBerhasil){
                echo '<span class="text-danger">Update URL Service Gagal, ada '.$JumlahBerhasil.' yang berhasil dari '.$jumlahTotal.'</span>';
            }else{
                echo '<span class="text-success" id="NotifikasiRepliceServiceBerhasil">Success</span>';
            }
        }
    }
?>