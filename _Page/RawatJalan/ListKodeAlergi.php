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
        $query = mysqli_query($Conn, "SELECT*FROM referensi_alergi WHERE code like '%$keyword%' OR display like '%$keyword%' LIMIT 20");
        while ($data = mysqli_fetch_array($query)) {
            $code= $data['code'];
            $display= $data['display'];
            echo '<option value="'.$code.'-'.$display.'">';
        }
    }
?>