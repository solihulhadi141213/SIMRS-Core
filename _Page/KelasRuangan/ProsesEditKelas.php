<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    //Menangkap variabe;
    if(empty($_POST['kategori'])){
        echo '<span class="text-danger">Kategori Tidak Boleh Kosong</span>';
    }else{
        if(empty($_POST['kodekelas'])){
            echo '<span class="text-danger">Kode Kelas Tidak Boleh Kosong</span>';
        }else{
            if(empty($_POST['kelas'])){
                echo '<span class="text-danger">Kelas Tidak Boleh Kosong</span>';
            }else{
                if(empty($_POST['id_ruang_rawat'])){
                    echo '<span class="text-danger">ID Ruang Rawat Tidak Boleh Kosong</span>';
                }else{
                    $id_ruang_rawat=$_POST['id_ruang_rawat'];
                    $kategori=$_POST['kategori'];
                    $kodekelas=$_POST['kodekelas'];
                    $kelas=$_POST['kelas'];
                    $updatetime=date('Y-m-d H:i:s');
                    //Edit data ke database
                    $Update= mysqli_query($Conn,"UPDATE ruang_rawat SET 
                        kategori='$kategori',
                        kodekelas='$kodekelas',
                        kelas='$kelas',
                        updatetime='$updatetime'
                    WHERE id_ruang_rawat='$id_ruang_rawat'") or die(mysqli_error($Conn)); 
                    if($Update){
                        //Catat Log Aktivitas
                        $WaktuLog=date('Y-m-d H:i');
                        $nama_log="Edit Data Kelas Berhasil";
                        $kategori_log="Kelas Ruangan";
                        include "../../_Config/Log.php";
                        echo '<span id="NotifikasiEditKelasBerhasil">Berhasil</span>';
                    }else{
                        echo '<span class="text-danger">Terjadi kegagalan pada saat update ke database</span>';
                    }
                }
            }
        }
    }
?>