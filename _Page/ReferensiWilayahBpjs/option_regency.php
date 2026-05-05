<?php
    // Connection
    include "../../_Config/Connection.php";
    echo '<option value="">Pilih</option>';
    if(!empty($_POST['province'])){
        $province = $_POST['province'];
        $query_kab = mysqli_query($Conn, "SELECT DISTINCT regency FROM wilayah WHERE province='$province' ORDER BY regency ASC");
        while ($data_kab = mysqli_fetch_array($query_kab)) {
            $regency_list = $data_kab['regency'];
            echo '<option value="'.$regency_list.'">'.$regency_list.'</option>';
        }
    }
?>