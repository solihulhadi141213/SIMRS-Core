<?php
    include "../../_Config/Connection.php";
    if(!empty($_POST['kategori'])){
        $kategori=$_POST['kategori'];
        $query = mysqli_query($Conn, "SELECT DISTINCT kategori FROM tarif WHERE kategori like '%$kategori%'");
        while ($data = mysqli_fetch_array($query)) {
            $KategroriList= $data['kategori'];
            echo '<option value="'.$KategroriList.'">';
        }
    }
?>