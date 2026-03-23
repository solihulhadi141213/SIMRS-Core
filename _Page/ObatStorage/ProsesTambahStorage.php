<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    $Updatetime=date("Y-m-d H:i:s");
    if(empty($_POST['nama_obat_storage'])){
        echo '<span class="text-danger">Nama Tempat Penyimpanan Tidak Boleh Kosong!</span>';
    }else{
        if(empty($_POST['deskripsi_tempat'])){
            echo '<span class="text-danger">Deskripsi Tempat Penyimpanan Tidak Boleh Kosong!</span>';
        }else{
            $nama_obat_storage=$_POST['nama_obat_storage'];
            $deskripsi_tempat=$_POST['deskripsi_tempat'];
            $sql=mysqli_query($Conn,"INSERT INTO obat_storage (
                id_akses,
                tanggal,
                nama_petugas,
                nama_penyimpanan,
                deskripsi_tempat,
                updatetime
            ) VALUES (
                '$SessionIdAkses',
                '$Updatetime',
                '$SessionNama',
                '$nama_obat_storage',
                '$deskripsi_tempat',
                '$Updatetime'
            )");
            if($sql){
                echo '<span class="text-success" id="NotifikasiTambahStorageBerhasil">Berhasil</span>';
            }else{
                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Data Ke Database</span>';
            }
        }
    }
    
?>