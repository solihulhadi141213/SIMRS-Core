<?php
    include "_Config/Connection.php";
    $query = mysqli_query($Conn, "SELECT DISTINCT cara_keluar FROM kunjungan  ORDER BY cara_keluar ASC");
    while ($data = mysqli_fetch_array($query)) {
        $status = $data['cara_keluar'];
        echo "$status <br>";
    }
?>