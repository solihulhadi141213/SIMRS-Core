<?php
    include "../../_Config/Connection.php";
    if(!empty($_POST['keyword_by'])){
        if(!empty($_POST['keyword'])){
            $keyword_by=$_POST['keyword_by'];
            $keyword=$_POST['keyword'];
            $Qry = mysqli_query($Conn, "SELECT DISTINCT $keyword_by FROM jadwal_operasi WHERE $keyword_by like '%$keyword%' ORDER BY $keyword_by ASC");
            while ($DataNamaPoli = mysqli_fetch_array($Qry)) {
                $List = $DataNamaPoli[$keyword_by];
                echo '<option value="'.$List.'">';
            }
        }
    }
?>