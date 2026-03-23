<?php
    include "../../_Config/SimrsFunction.php";
    session_start();
    //hasil kode acak disimpan di $code
    $code = generateStrongCode(6);
    //Enkrip Md5
    $CodeMd5=md5($code);
    //kode acak disimpan di dalam session agar data dapat dipassing ke halaman lain
    $_SESSION["code"] = $CodeMd5;
    $_SESSION["CaptchaGambar"] = $code;
    //Enkrip Code
    $UrlCaptcha="_Page/Akses/GambarCaptcha.php?String=$CodeMd5";
    echo $UrlCaptcha;
?>