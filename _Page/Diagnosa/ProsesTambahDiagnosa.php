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
                    $kode=$_POST['kode'];
                    $versi=$_POST['versi'];
                    $long_des=$_POST['long_des'];
                    $short_des=$_POST['short_des'];
                    //Validasi duplikat data
                    $sql = "SELECT * FROM diagnosa WHERE kode='$kode' AND versi='$versi'";
                    $result = mysqli_query($Conn, $sql);
                    if(mysqli_num_rows($result) > 0){
                        echo '<span class="text-danger">Data sudah ada</span>';
                    }else{
                        //Simpan data
                        $sql = "INSERT INTO diagnosa (kode, versi, long_des, short_des) VALUES ('$kode', '$versi', '$long_des', '$short_des')";
                        if(mysqli_query($Conn, $sql)){
                            echo '<span class="text-success" id="NotifikasiTambahDiagnosaBerhasil">Berhasil</span>';
                        }else{
                            echo '<span class="text-danger">Data gagal disimpan</span>';
                        }
                    }
                }
            }
        }
    }
?>