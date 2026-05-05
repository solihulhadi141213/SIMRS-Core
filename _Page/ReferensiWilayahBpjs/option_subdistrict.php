<?php
    // Connection
    include "../../_Config/Connection.php";
    echo '<option value="">Pilih</option>';
    if(!empty($_POST['regency'])){
        $regency = $_POST['regency'];
        $query_kab = mysqli_query($Conn, "SELECT DISTINCT subdistrict FROM wilayah WHERE regency='$regency' ORDER BY subdistrict ASC");
        while ($data_kab = mysqli_fetch_array($query_kab)) {
            $subdistrict_list = $data_kab['subdistrict'];
            echo '<option value="'.$subdistrict_list.'">'.$subdistrict_list.'</option>';
        }
    }
?>