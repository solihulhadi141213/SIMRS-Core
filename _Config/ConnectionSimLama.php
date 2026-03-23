<?php
    // //Ini adalah halaman untuk melakukan konfigurasi database
    // $servername = "localhost";
    // $username = "root";
    // $password = "";
    // $db = "medrek";
    // // Create connection
    // $Conn = new mysqli($servername, $username, $password, $db);
    // // Check connection
    // if ($Conn->connect_error) {
    //     die("Connection failed: " . $conn->connect_error);
    // }
    
    //Ini adalah halaman untuk melakukan konfigurasi database
    $servername2 = "localhost";
    $username2 = "root";
    $password2 = "arunaparasilvanursari";
    $db2 = "simrs";
    // Create connection
    $Conn2 = new mysqli($servername2, $username2, $password2, $db2);
    // Check connection
    if ($Conn2->connect_error) {
        die("Connection failed: " . $Conn2->connect_error);
    }
?> 