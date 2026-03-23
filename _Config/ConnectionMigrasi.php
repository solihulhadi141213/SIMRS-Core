<?php
    //Ini adalah halaman untuk melakukan konfigurasi database
    $servername3 = "localhost";
    $username3 = "root";
    $password3 = "arunaparasilvanursari";
    $db3 = "migrator";
    // Create connection
    $Conn3 = new mysqli($servername3, $username3, $password3, $db3);
    // Check connection
    if ($Conn3->connect_error) {
        die("Connection failed: " . $Conn3->connect_error);
    }
?> 