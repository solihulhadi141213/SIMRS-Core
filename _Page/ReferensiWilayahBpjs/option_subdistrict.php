<?php
    // Connection
    include "../../_Config/Connection.php";
    echo '<option value="">Pilih</option>';
    if(!empty($_POST['regency'])){
        $regency = $_POST['regency'];
        // Prepared Statement: filter kecamatan berdasarkan kabupaten.
        $query_kab = mysqli_prepare($Conn, "SELECT DISTINCT subdistrict FROM wilayah WHERE regency=? ORDER BY subdistrict ASC");
        mysqli_stmt_bind_param($query_kab, "s", $regency);
        mysqli_stmt_execute($query_kab);
        $query_kab = mysqli_stmt_get_result($query_kab);
        while ($data_kab = mysqli_fetch_array($query_kab)) {
            $subdistrict_list = $data_kab['subdistrict'];
            echo '<option value="'.$subdistrict_list.'">'.$subdistrict_list.'</option>';
        }
    }
?>