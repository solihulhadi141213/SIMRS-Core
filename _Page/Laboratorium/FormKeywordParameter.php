<?php
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['keyword_by_parameter'])){
        echo '<input type="text" class="form-control" name="keyword" id="keyword" placeholder="Kata Kunci">';
        echo '<small>Kata Kunci</small>';
    }else{
        $keyword_by_parameter=$_POST['keyword_by_parameter'];
        if($keyword_by_parameter=="kategori_parameter"){
            echo '<select class="form-control" name="keyword" id="keyword">';
            $QryKategori = mysqli_query($Conn, "SELECT DISTINCT kategori_parameter FROM laboratorium_parameter ORDER BY kategori_parameter ASC");
            while ($DataKategori = mysqli_fetch_array($QryKategori)) {
                $kategori_parameter= $DataKategori['kategori_parameter'];
                echo '<option value="'.$kategori_parameter.'">'.$kategori_parameter.'</option>';
            }
            echo '</select>';
        }else{
            if($keyword_by_parameter=="tipe_data"){
                echo '<select class="form-control" name="keyword" id="keyword">';
                $QryKategori = mysqli_query($Conn, "SELECT DISTINCT tipe_data FROM laboratorium_parameter ORDER BY tipe_data ASC");
                while ($DataKategori = mysqli_fetch_array($QryKategori)) {
                    $tipe_data= $DataKategori['tipe_data'];
                    echo '<option value="'.$tipe_data.'">'.$tipe_data.'</option>';
                }
                echo '</select>';
            }else{
                echo '<input type="text" class="form-control" name="keyword" id="keyword" placeholder="Kata Kunci">';
                echo '<small>Kata Kunci</small>';
            }
        }
    }
?>