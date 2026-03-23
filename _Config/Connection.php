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
    $servername = "localhost";
    $username = "root";
    $password = "arunaparasilvanursari";
    $db = "elsyifa";
    // Create connection
    $Conn = new mysqli($servername, $username, $password, $db);
    // Check connection
    if ($Conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?> 