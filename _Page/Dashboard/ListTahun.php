<?php
    include "../../_Config/Connection.php";

    $query = mysqli_query($Conn, "
        SELECT DISTINCT YEAR(datetime_daftar) as tahun 
        FROM kunjungan 
        WHERE tanggal IS NOT NULL 
        ORDER BY tahun ASC
    ");

    $data = [];

    while ($row = mysqli_fetch_assoc($query)) {
        $data[] = $row;
    }

    echo json_encode($data);
?>