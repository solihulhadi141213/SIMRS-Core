<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['id_obat_expired'])){
        echo '<span class="text-danger">ID Expired Item Tidak Boleh Kosong!</span>';
    }else{
        if(empty($_POST['batch'])){
            echo '<span class="text-danger">Kode Batch Item Tidak Boleh Kosong!</span>';
        }else{
            if(empty($_POST['expired'])){
                echo '<span class="text-danger">Informasi Expired Item Tidak Boleh Kosong!</span>';
            }else{
                if(empty($_POST['ingatkan'])){
                    echo '<span class="text-danger">Informasi Peringatan Expired Item Tidak Boleh Kosong!</span>';
                }else{
                    if(empty($_POST['status'])){
                        echo '<span class="text-danger">Status Expired Item Tidak Boleh Kosong!</span>';
                    }else{
                        if(empty($_POST['qty'])){
                            $qty="0";
                        }else{
                            $qty=$_POST['qty'];
                        }
                        if(empty($_POST['GetPage'])){
                            $GetPage="0";
                        }else{
                            $GetPage=$_POST['GetPage'];
                        }
                        $id_obat_expired=$_POST['id_obat_expired'];
                        $batch=$_POST['batch'];
                        $expired=$_POST['expired'];
                        $ingatkan=$_POST['ingatkan'];
                        $status=$_POST['status'];
                        $UpdateExpiredDate=mysqli_query($Conn, "UPDATE obat_expired SET 
                            batch='$batch', 
                            qty='$qty', 
                            expired='$expired', 
                            ingatkan='$ingatkan', 
                            status='$status'
                        WHERE id_obat_expired='$id_obat_expired'");
                        if($UpdateExpiredDate){
                            $now=date('Y-m-d H:i:s');
                            $LogJsonFile="../../_Page/Log/Log.json";
                            $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Edit kategori Harga Obat","Obat",$SessionIdAkses,$LogJsonFile);
                            if($MenyimpanLog=="Berhasil"){
                                echo '<span class="text-success" id="NotifikasiEditExpiredBerhasil">Success</span>';
                                echo '<input type="hidden" id="PutPage" value="'.$GetPage.'">';
                            }else{
                                echo '<span class="text-danger">Terjadi kesalahan pada saat menyimpan data log</span>';
                            }
                        }else{
                            echo '<span class="text-danger">Terjadi kesalahan pada saat menyimpan data ke database</span>';
                        }
                    }
                }
            }
        }
    }
?>