<?php
    //Koneksi
    include "../../_Config/Connection.php";
    if(!empty($_POST['keyword'])){
        if(!empty($_POST['keyword_by'])){
            $keyword=$_POST['keyword'];
            $keyword_by=$_POST['keyword_by'];
            $QryKeyword = mysqli_query($Conn, "SELECT DISTINCT $keyword_by FROM tarif WHERE $keyword_by like '%$keyword%'");
            while ($DataKeyword = mysqli_fetch_array($QryKeyword)) {
                $ListOption= $DataKeyword[$keyword_by];
                echo '<option value="'.$ListOption.'">';
            }
        }
    }
?>