<?php
    if(!empty($_GET['code'])){
        require_once 'assets/phpqrcode/qrlib.php';

        // Data yang akan dijadikan QR Code
        $noKartu = $_GET['code'];

        // Atur header agar browser mengenali output sebagai gambar PNG
        header('Content-Type: image/png');

        // Generate QR Code langsung ke output (tanpa menyimpan file)
        QRcode::png($noKartu, false, QR_ECLEVEL_L, 10);
    }
?>