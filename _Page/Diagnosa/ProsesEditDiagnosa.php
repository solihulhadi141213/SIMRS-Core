<?php
    //Connection
    include "../../_Config/Connection.php";
    //Variabel
    if(empty($_POST['kode'])){
        echo '<span class="text-danger">Kode Diagnosa tidak boleh kosong</span>';
    }else{
        if(empty($_POST['versi'])){
            echo '<span class="text-danger">Versi Diagnosa tidak boleh kosong</span>';
        }else{
            if(empty($_POST['long_des'])){
                echo '<span class="text-danger">Long Description Diagnosa tidak boleh kosong</span>';
            }else{
                if(empty($_POST['short_des'])){
                    echo '<span class="text-danger">Short Description Diagnosa tidak boleh kosong</span>';
                }else{
                    if(empty($_POST['id_diagnosa'])){
                        echo '<span class="text-danger">ID Diagnosa tidak boleh kosong</span>';
                    }else{
                        $kode=$_POST['kode'];
                        $id_diagnosa=$_POST['id_diagnosa'];
                        $versi=$_POST['versi'];
                        $long_des=$_POST['long_des'];
                        $short_des=$_POST['short_des'];
                        //update diagnosa
                        $sql = "UPDATE diagnosa SET kode='$kode', versi='$versi', long_des='$long_des', short_des='$short_des' WHERE id_diagnosa='$id_diagnosa'";
                        if(mysqli_query($Conn, $sql)){
                            echo '<span class="text-success" id="NotifikasiEditDiagnosaBerhasil">Berhasil</span>';
                        }else{
                            echo '<span class="text-danger">Data gagal disimpan</span>';
                        }
                    }
                }
            }
        }
    }
?>