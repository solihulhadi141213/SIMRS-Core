<?php
    // Header JSON
    header('Content-Type: application/json');

    // Connection, Function & Session
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // Validasi Session
    if (empty($SessionIdAkses)) {
        echo json_encode(["status"  => false]);
        exit;
    }

    $ijin_akses = GetStatusAccess($Conn, $SessionIdAkses, 'wrA8sp3Y4r');
    if($ijin_akses==true){
        echo json_encode(["status"  => true]);
        exit;
    }else{
        echo json_encode(["status"  => false]);
        exit;
    }
?>