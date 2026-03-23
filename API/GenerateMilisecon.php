<?php
    if(empty($_GET['datetime'])){
        $datetime = date('Y-m-d H:i:s');
        $milisecond=strtotime(''.$datetime.'');
        $milisecond=$milisecond*1000;
    }else{
        date_default_timezone_set('Asia/Jakarta');
        $datetime =$_GET['datetime'];
        $milisecond=strtotime(''.$datetime.'');
        $milisecond=$milisecond*1000;
    }
    echo "$milisecond";
?>