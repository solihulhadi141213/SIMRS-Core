<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    $Updatetime=date("Y-m-d H:i:s");
    if(empty($_POST['id_obat_storage'])){
        echo '<span class="text-danger">ID Tempat Penyimpanan Tidak Boleh Kosong!</span>';
    }else{
        if(empty($_POST['nama_obat_storage'])){
            echo '<span class="text-danger">Nama Tempat Penyimpanan Tidak Boleh Kosong!</span>';
        }else{
            if(empty($_POST['deskripsi_tempat'])){
                echo '<span class="text-danger">Deskripsi Tempat Penyimpanan Tidak Boleh Kosong!</span>';
            }else{
                $id_obat_storage=$_POST['id_obat_storage'];
                $nama_obat_storage=$_POST['nama_obat_storage'];
                $deskripsi_tempat=$_POST['deskripsi_tempat'];
                //Update
                $sql=mysqli_query($Conn, "UPDATE obat_storage SET 
                    id_akses='$SessionIdAkses', 
                    nama_petugas='$SessionNama', 
                    nama_penyimpanan='$nama_obat_storage', 
                    updatetime='$Updatetime', 
                    deskripsi_tempat='$deskripsi_tempat'
                WHERE id_obat_storage='$id_obat_storage'");
                if($sql){
                    echo '<span class="text-success" id="NotifikasiEditStorageBerhasil">Berhasil</span>';
                }else{
                    echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Data Ke Database</span>';
                }
            }
        }
    }
?>