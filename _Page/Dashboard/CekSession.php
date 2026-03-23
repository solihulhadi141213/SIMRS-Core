<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    if(!empty($SessionEmail)){
        echo "$SessionEmail";
    }else{
        
    }
?>