<?php
    include 'assets/phpqrcode/qrlib.php';
    if(!empty($_GET['data'])){
        $data = $_GET['data'];
        header('Content-Type: image/png');
        QRcode::png($data);
    }else{
        echo "Data Tidak Ada";
    }
?>