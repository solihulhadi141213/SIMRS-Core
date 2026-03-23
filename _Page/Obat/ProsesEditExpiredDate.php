<?php
    session_start();
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['id_obat_expired'])){
        echo '<span class="text-danger">ID Expired Tidak Boleh Kosong!</span>';
    }else{
        if(empty($_POST['qty'])){
            echo '<span class="text-danger">Kuantitas Obat Tidak Boleh Kosong!</span>';
        }else{
            if(empty($_POST['expired'])){
                echo '<span class="text-danger">Expired Obat Tidak Boleh Kosong!</span>';
            }else{
                if(empty($_POST['ingatkan'])){
                    echo '<span class="text-danger">Notifikasi Expired Obat Tidak Boleh Kosong!</span>';
                }else{
                    if(empty($_POST['satuan'])){
                        echo '<span class="text-danger">Satuan Obat Tidak Boleh Kosong!</span>';
                    }else{
                        if(empty($_POST['status'])){
                            echo '<span class="text-danger">Status expired Tidak Boleh Kosong!</span>';
                        }else{
                            //Variabel
                            $id_obat_expired=$_POST['id_obat_expired'];
                            $qty=$_POST['qty'];
                            $satuan=$_POST['satuan'];
                            $expired=$_POST['expired'];
                            $ingatkan=$_POST['ingatkan'];
                            $status=$_POST['status'];
                            if(empty($_POST['batch'])){
                                $batch="";
                            }else{
                                $batch=$_POST['batch'];
                            }
                            //Simpan data
                            $UpdateExpired=mysqli_query($Conn, "UPDATE obat_expired SET 
                                batch='$batch', 
                                qty='$qty', 
                                satuan='$satuan', 
                                expired='$expired', 
                                ingatkan='$ingatkan', 
                                status='$status'
                            WHERE id_obat_expired='$id_obat_expired'");
                            if($UpdateExpired){
                                // $_SESSION['NotifikasiSwal']="Tambah Expired Date Berhasil";
                                echo '<span class="text-success" id="NotifikasiEditExpiredDateBerhasil">Success</span>';
                            }else{
                                echo '<span class="text-danger">Terjadi kesalahan pada saat update data expired</span>';
                            }
                        }
                    }
                }
            }
        }
    }
?>