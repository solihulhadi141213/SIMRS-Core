<?php
    include "../../_Config/SimrsFunction.php";
    session_start();
    //hasil kode acak disimpan di $code
    $code = generateStrongCode(6);
    //Ubah ke md5
    $CodeMd5=md5($code);
    //kode acak disimpan di dalam session agar data dapat dipassing ke halaman lain
    $_SESSION["CaptchaGambar"] = $code;
    $_SESSION["code"] = $CodeMd5;
    //Enkrip
    $UrlCaptcha="_Page/Login/GambarCaptcha.php?String=$CodeMd5";
    echo $UrlCaptcha;
?>