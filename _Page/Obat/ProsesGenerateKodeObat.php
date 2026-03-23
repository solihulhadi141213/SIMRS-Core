<?php
    //Koneksi dan SessionLogin
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    function getRandomeCode($length) {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    $getRandomeCode=getRandomeCode(16);
    //Cek Duplikasi
    $Duplikasi=getDataDetail($Conn,'obat','kode',$getRandomeCode,'id_obat');
    if(empty($Duplikasi)){
        echo $getRandomeCode;
    }
    
?>