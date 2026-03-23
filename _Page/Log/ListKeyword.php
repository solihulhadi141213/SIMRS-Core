<?php
    include "../../_Config/Connection.php";
    if(!empty($_POST['keyword_by'])){
        $keyword_by=$_POST['keyword_by'];
        $query = mysqli_query($Conn, "SELECT DISTINCT $keyword_by FROM log ORDER BY $keyword_by ASC");
        while ($data = mysqli_fetch_array($query)) {
            $List= $data[$keyword_by];
            echo '<option value="'.$List.'">';
        }
    }
?>