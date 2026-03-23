<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    //menangkap data
    if(empty($_POST['AksesGroup'])){
        echo '<div class="text-danger" id="NotifikasiBerhasil">Maaf!! Akses group tidak boleh kosong</div>';
    }else{
        if(empty($_POST['keterangan'])){
            echo '<div class="text-danger" id="NotifikasiBerhasil">Maaf!! Keterangan Setting tidak boleh kosong</div>';
        }else{
            if(empty($_POST['status'])){
                echo '<div class="text-danger" id="NotifikasiBerhasil">Maaf!! Status Setting tidak boleh kosong</div>';
            }else{
                //Bentuk variabel
                $AksesGroup=$_POST['AksesGroup'];
                $keterangan=$_POST['keterangan'];
                $status=$_POST['status'];
                //lakukan update
                $ValidasiAksesGroup=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM setting_a WHERE akses='$AksesGroup'"));
                if(empty($ValidasiAksesGroup)){
                    $entry="INSERT INTO setting_a (
                        akses,
                        $keterangan
                    ) VALUES (
                        '$AksesGroup',
                        '$status'
                    )";
                    $Input=mysqli_query($Conn, $entry);
                    if($Input){
                        //Catat Log Aktivitas
                        $WaktuLog=date('Y-m-d H:i');
                        $nama_log="Update Setting Aksesibilitas Berhasil";
                        $kategori_log="Akses";
                        include "../../_Config/Log.php";
                        echo '<div class="text-info" id="NotifikasiBerhasil">Setting berhasil</div>';
                    }else{
                        echo '<div class="text-danger" id="NotifikasiBerhasil">Setting gagal</div>';
                    }
                }else{
                    //Apabila sudah ada maka update
                    $Update = mysqli_query($Conn,"UPDATE setting_a SET 
                        $keterangan='$status'
                    WHERE akses='$AksesGroup'") or die(mysqli_error($Conn)); 
                    if($Update){
                        //Catat Log Aktivitas
                        $WaktuLog=date('Y-m-d H:i');
                        $nama_log="Update Setting Aksesibilitas Berhasil";
                        $kategori_log="Akses";
                        include "../../_Config/Log.php";
                        echo '<div class="text-info" id="NotifikasiBerhasil">Setting berhasil</div>';
                    }else{
                        echo '<div class="text-danger" id="NotifikasiBerhasil">Setting gagal</div>';
                    }
                }
            }
        }
    }

?>