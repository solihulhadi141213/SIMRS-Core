<?php
    //KONEKSI KE DATABASE SQL
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    //TANGKAP VARIABEL DARI FORMULIR LOGIN.PHP
    $kabupaten=$_POST["kabupaten"];
    $QryKabupaten = mysqli_query($Conn, "SELECT DISTINCT kecamatan FROM wilayah WHERE kabupaten='$kabupaten' ORDER BY kecamatan ASC");
    while ($DataKabupaten = mysqli_fetch_array($QryKabupaten)) {
        $kecamatan= $DataKabupaten['kecamatan'];
        if(!empty($kecamatan)){
            echo '<option value="'.$kecamatan.'">';
        }
    }
?>