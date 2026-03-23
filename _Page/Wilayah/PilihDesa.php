<?php
    //KONEKSI KE DATABASE SQL
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    //TANGKAP VARIABEL DARI FORMULIR LOGIN.PHP
    $kecamatan=$_POST["kecamatan"];
    $QryKabupaten = mysqli_query($Conn, "SELECT DISTINCT desa FROM wilayah WHERE kecamatan='$kecamatan' ORDER BY desa ASC");
    while ($DataKabupaten = mysqli_fetch_array($QryKabupaten)) {
        $desa= $DataKabupaten['desa'];
        if(!empty($desa)){
            echo '<option value="'.$desa.'">';
        }
    }
?>