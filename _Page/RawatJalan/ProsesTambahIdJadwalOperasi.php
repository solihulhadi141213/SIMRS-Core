<?php
    $now=date('Y-m-d H:i:s');
    $strtotime=strtotime($now);
    if(!empty($_POST['PilihIdJadwalOperasi'])){
        $PilihIdJadwalOperasi=$_POST['PilihIdJadwalOperasi'];
    }else{
        $PilihIdJadwalOperasi="";
    }
    echo "$PilihIdJadwalOperasi";
?>
