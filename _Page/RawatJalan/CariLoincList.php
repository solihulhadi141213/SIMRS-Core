<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    //keyword
    if(!empty($_POST['keyword'])){
        $keyword=$_POST['keyword'];
        $Qry = mysqli_query($Conn, "SELECT*FROM loinc WHERE loinc_num like '%$keyword%' OR component like '%$keyword%'");
        while ($Data = mysqli_fetch_array($Qry)) {
            $loinc_num= $Data['loinc_num'];
            $component= $Data['component'];
            echo '<option value="'.$loinc_num.'|'.$component.'">';
        }
    }
?>