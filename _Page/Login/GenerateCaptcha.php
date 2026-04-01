<?php
    ob_start();

    // Jangan tampilkan error ke browser untuk file image
    error_reporting(E_ALL);
    ini_set('display_errors', 0);

    // Include
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";

    // menghapus Captcha Yang Expired
    $deleted = DeleteExpiredCaptcha($Conn);
    if($deleted == false){
        exit;
    }

    // Validasi parameter feature_name
    if (empty($_GET['feature_name'])) {
        exit;
    }

    // Validasi parameter id_captcha 
    if (empty($_GET['id_captcha'])) {
        exit;
    }

    $feature_name = trim($_GET['feature_name']);
    $id_captcha   = trim($_GET['id_captcha']);


    // Generate captcha
    $result = GenerateCaptcha($Conn, $feature_name, $id_captcha);

    // Jika gagal, tulis log lalu keluar
    if (!$result || !isset($result['captcha'])) {
        error_log("GenerateCaptcha gagal untuk feature: " . $feature_name);
        exit;
    }

    $captcha = $result['captcha'];

    // ==========================
    // Render Image
    // ==========================
    $width  = 173;
    $height = 50;

    $image = imagecreatetruecolor($width, $height);

    // Warna
    $bg = imagecolorallocate($image, 22, 86, 165);
    $textColor = imagecolorallocate($image, 223, 230, 233);

    // Background
    imagefill($image, 0, 0, $bg);

    // Noise garis
    for ($i = 0; $i < 5; $i++) {
        $lineColor = imagecolorallocate(
            $image,
            rand(100, 255),
            rand(100, 255),
            rand(100, 255)
        );

        imageline(
            $image,
            rand(0, $width - 1),
            rand(0, $height - 1),
            rand(0, $width - 1),
            rand(0, $height - 1),
            $lineColor
        );
    }

    // Noise titik
    for ($i = 0; $i < 80; $i++) {
        $dotColor = imagecolorallocate(
            $image,
            rand(100, 255),
            rand(100, 255),
            rand(100, 255)
        );

        imagesetpixel(
            $image,
            rand(0, $width - 1),
            rand(0, $height - 1),
            $dotColor
        );
    }

    // Text captcha
    imagestring($image, 5, 45, 18, $captcha, $textColor);

    // Bersihkan output buffer
    ob_clean();

    // Header image
    header('Content-Type: image/jpeg');
    header('Cache-Control: no-cache, no-store, must-revalidate');

    // Output
    imagejpeg($image, null, 90);

    imagedestroy($image);
    exit;
?>