<?php
    session_start();
    if(!empty($_SESSION["CaptchaGambar"])){
        $String=$_SESSION["CaptchaGambar"];
        $wh = imagecreatetruecolor(173, 50);
        $bgc = imagecolorallocate($wh, 22, 86, 165);
        //membuat text warna 
        $fc = imagecolorallocate($wh, 223, 230, 233);
        imagefill($wh, 0, 0, $bgc);
        imagestring($wh, 10, 50, 15,  $String, $fc);
        //membuat gambar
        header('content-type: image/jpg');
        imagejpeg($wh);
        imagedestroy($wh);
    }
?>