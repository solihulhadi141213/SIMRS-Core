<?php
    date_default_timezone_set('UTC');
    include "../../_Config/Connection.php";
    //keyword
    if(!empty($_POST['keyword'])){
        if(!empty($_POST['referensi'])){
            $keyword=$_POST['keyword'];
            $referensi=$_POST['referensi'];
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM diagnosa WHERE kode like '%$keyword%' OR long_des like '%$keyword%' OR short_des like '%$keyword%'"));
            if(empty($jml_data)){
                echo '<option value="No Data Found">';
            }else{
                echo '<option value="Data Found">';
            }
        }else{
            echo '<option value="Select Referensi Plese">';
        }
    }else{
        echo '<option value="Keyup Plese">';
    }
?>