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
        $query = mysqli_query($Conn, "SELECT*FROM obat WHERE nama_obat like '%$keyword%'");
        while ($data = mysqli_fetch_array($query)) {
            $nama_obat= $data['nama_obat'];
            echo '<option value="'.$nama_obat.'">';
        }
    }
?>