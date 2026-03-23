<?php
    session_start();
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['id_obat'])){
        echo '<span class="text-danger">ID Obat Tidak Boleh Kosong!</span>';
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
                            $id_obat=$_POST['id_obat'];
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
                            $nama=getDataDetail($Conn,'obat','id_obat',$id_obat,'nama');
                            //Simpan data
                            $sql=mysqli_query($Conn,"INSERT INTO obat_expired (
                                id_obat,
                                batch,
                                nama,
                                qty,
                                satuan,
                                expired,
                                ingatkan,
                                status
                            ) VALUES (
                                '$id_obat',
                                '$batch',
                                '$nama',
                                '$qty',
                                '$satuan',
                                '$expired',
                                '$ingatkan',
                                '$status'
                            )");
                            if($sql){
                                // $_SESSION['NotifikasiSwal']="Tambah Expired Date Berhasil";
                                echo '<span class="text-success" id="NotifikasiExpiredDateBerhasil">Success</span>';
                            }else{
                                echo '<span class="text-danger">Terjadi kesalahan pada saat menambahkan data expired</span>';
                            }
                        }
                    }
                }
            }
        }
    }
?>