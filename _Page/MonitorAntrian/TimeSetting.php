<?php
    //Setting Time Data
    date_default_timezone_set('Asia/Jakarta');
    $Tanggal=date('d F Y');
    $Jam=date('H:i:s');
    echo "<b class='text-info'>$Tanggal</b> <b class='text-dark'>$Jam WIB</b>";
?>