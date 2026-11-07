<?php
    // Connection
    include "../../_Config/Connection.php";
    echo '<option value="">Pilih</option>';
    if(!empty($_POST['province'])){
        $province = $_POST['province'];
        // Prepared Statement: filter kabupaten berdasarkan provinsi.
        $query_kab = mysqli_prepare($Conn, "SELECT DISTINCT regency FROM wilayah WHERE province=? ORDER BY regency ASC");
        mysqli_stmt_bind_param($query_kab, "s", $province);
        mysqli_stmt_execute($query_kab);
        $query_kab = mysqli_stmt_get_result($query_kab);
        while ($data_kab = mysqli_fetch_array($query_kab)) {
            $regency_list = $data_kab['regency'];
            echo '<option value="'.$regency_list.'">'.$regency_list.'</option>';
        }
    }
?>