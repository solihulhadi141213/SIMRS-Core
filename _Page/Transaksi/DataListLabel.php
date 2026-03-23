<?php
    include "../../_Config/Connection.php";
    if(!empty($_POST['label'])){
        $label=$_POST['label'];
        $query = mysqli_query($Conn, "SELECT DISTINCT label FROM transaksi WHERE label like '%$label%'");
        while ($data = mysqli_fetch_array($query)) {
            $label= $data['label'];
            echo '<option value="'.$label.'">';
        }
    }
?>