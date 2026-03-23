<?php
    //koneksi
    include "../../_Config/Connection.php";
    //POST data from form
    if(empty($_POST['poliklinik'])){
        $poliklinik="";
        echo '<option>Isi Poliklinik Terlebih Dulu</option>';
    }else{
        $poliklinik=$_POST['poliklinik'];
        echo '<option value="">Pilih</option>';
        //get data from database jadwal_dokter 
        $sql = "SELECT DISTINCT id_dokter FROM jadwal_dokter WHERE id_poliklinik='$poliklinik'";
        $result = mysqli_query($Conn, $sql);
        while($row = mysqli_fetch_assoc($result)){
            $id_dokter=$row['id_dokter'];
            //buka nama_dokter
            $sql2 = "SELECT * FROM dokter WHERE id_dokter='$id_dokter'";
            $result2 = mysqli_query($Conn, $sql2);
            $row2 = mysqli_fetch_assoc($result2);
            $nama_dokter=$row2['nama'];
            echo '<option value="'.$id_dokter.'">'.$nama_dokter.'</option>';
        }

    }
?>