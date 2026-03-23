<?php
    //Inisiasi Waktu Log
    $WaktuLog=date('Y-m-d H:i:s');
    $Inputlog="INSERT INTO log (
        waktu,
        nama,
        nama_log,
        kategori,
        id_akses
    ) VALUES (
        '$WaktuLog',
        '$SessionNama',
        '$nama_log',
        '$kategori_log',
        '$SessionIdAkses'
    )";
    $hasilInputLog=mysqli_query($Conn, $Inputlog);
    
?>