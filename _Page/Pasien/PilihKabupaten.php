<?php
    //KONEKSI KE DATABASE SQL
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    //TANGKAP VARIABEL DARI FORMULIR LOGIN.PHP
    $propinsi=$_POST["propinsi"];
    echo '<option>Pilih</option>';
    $QryKabupaten = mysqli_query($Conn, "SELECT DISTINCT kabupaten FROM wilayah WHERE propinsi='$propinsi' ORDER BY kabupaten ASC");
    while ($DataKabupaten = mysqli_fetch_array($QryKabupaten)) {
        $id_wilayah= $DataKabupaten['id_wilayah'];
        $kabupaten= $DataKabupaten['kabupaten'];
        if(!empty($kabupaten)){
            echo '<option value="'.$kabupaten.'">'.$kabupaten.'</option>';
        }
    }
?>