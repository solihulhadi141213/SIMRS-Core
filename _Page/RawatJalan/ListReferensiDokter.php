<?php
    //Zona Waktu
    date_default_timezone_set('UTC');
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/SettingBridging.php";
    include "../../vendor/autoload.php";
    include "../../_Config/SimrsFunction.php";
    //keyword
    if(!empty($_POST['keyword'])){
        $keyword=$_POST['keyword'];
        $query = mysqli_query($Conn, "SELECT*FROM dokter WHERE nama like '%$keyword%'");
        while ($data = mysqli_fetch_array($query)) {
            $nama= $data['nama'];
            echo '<option value="'.$nama.'">';
        }
    }
?>