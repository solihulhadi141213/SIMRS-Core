<?php
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/SettingFaskes.php";

    if (!empty($_GET['bucket']) && !empty($_GET['file'])) {
        $bucket = validateAndSanitizeInput($_GET['bucket']);
        $file = validateAndSanitizeInput($_GET['file']);

        $imagePath = realpath("../../assets/images/$bucket/$file");

        if (!$imagePath || !file_exists($imagePath)) {
            header('HTTP/1.1 404 Not Found');
            echo 'File tidak ditemukan.';
            exit;
        }

        $allowedDir = realpath("../../assets/images/");
        if (strpos($imagePath, $allowedDir) !== 0) {
            header('HTTP/1.1 403 Forbidden');
            echo 'Akses ke file ini tidak diizinkan.';
            exit;
        }

        $imageInfo = @getimagesize($imagePath);
        if (!$imageInfo || !in_array($imageInfo['mime'], ['image/jpeg', 'image/png', 'image/gif', 'image/webp'])) {
            header('HTTP/1.1 400 Bad Request');
            echo 'Hanya gambar dengan format JPEG, PNG, GIF, atau WEBP yang diizinkan.';
            exit;
        }

        header('Content-Type: ' . $imageInfo['mime']);
        header('Cache-Control: max-age=3600, public');

        if (ob_get_length()) {
            ob_end_clean();
        }

        readfile($imagePath);
        exit;
    } else {
        header('HTTP/1.1 400 Bad Request');
        echo 'Parameter bucket dan file harus disediakan.';
        exit;
    }
?>
