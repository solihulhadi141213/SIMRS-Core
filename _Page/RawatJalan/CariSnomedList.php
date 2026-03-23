<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    //keyword
    if(!empty($_POST['keyword'])){
        $keyword=$_POST['keyword'];
        $Qry = mysqli_query($Conn, "SELECT*FROM snomed WHERE term like '%$keyword%' OR conceptId like '%$keyword%' LIMIT 50");
        while ($Data = mysqli_fetch_array($Qry)) {
            $term= $Data['term'];
            $conceptId= $Data['conceptId'];
            echo '<option value="'.$conceptId.'|'.$term.'">';
        }
    }
?>