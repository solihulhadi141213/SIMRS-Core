<?php
    //KONEKSI KE DATABASE SQL
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    //TANGKAP VARIABEL DARI FORMULIR LOGIN.PHP
    $kabupaten=$_POST["kabupaten"];
    echo '<option>Pilih</option>';
    $QryKecamatan = mysqli_query($Conn, "SELECT DISTINCT kecamatan FROM wilayah WHERE kabupaten='$kabupaten' ORDER BY kecamatan ASC");
    while ($DataKecamatan = mysqli_fetch_array($QryKecamatan)) {
        $id_wilayah= $DataKecamatan['id_wilayah'];
        $kecamatan= $DataKecamatan['kecamatan'];
        if(!empty($kecamatan)){
            echo '<option value="'.$kecamatan.'">'.$kecamatan.'</option>';
        }
    }
?>