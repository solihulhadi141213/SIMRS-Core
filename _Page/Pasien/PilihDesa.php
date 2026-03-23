<?php
    //KONEKSI KE DATABASE SQL
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    //TANGKAP VARIABEL DARI FORMULIR LOGIN.PHP
    $kecamatan=$_POST["kecamatan"];
    echo '<option>Pilih</option>';
    $QryDesa = mysqli_query($Conn, "SELECT DISTINCT id_wilayah, desa FROM wilayah WHERE kecamatan='$kecamatan' ORDER BY desa ASC");
    while ($DataDesa = mysqli_fetch_array($QryDesa)) {
        $id_wilayah= $DataDesa['id_wilayah'];
        $desa= $DataDesa['desa'];
        if(!empty($desa)){
            echo '<option value="'.$desa.'">'.$desa.'</option>';
        }
    }
?>