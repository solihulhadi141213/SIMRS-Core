<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    if(!empty($_POST['keyword_by'])){
        $keyword_by=$_POST['keyword_by'];
        if($keyword_by=="kategori"){
            echo '<select name="keyword" id="keyword" class="form-control">';
            $QryKategori = mysqli_query($Conn, "SELECT DISTINCT kategori FROM dokter ORDER BY kategori ASC");
            while ($Datakategori = mysqli_fetch_array($QryKategori)) {
                $KategoriList= $Datakategori['kategori'];
                echo '<option value="'.$KategoriList.'">'.$KategoriList.'</option>';
            }
            echo '</select>';
            echo '<small>Kata Kunci</small>';
        }else{
            if($keyword_by=="status"){
                echo '<select name="keyword" id="keyword" class="form-control">';
                $QryKategori = mysqli_query($Conn, "SELECT DISTINCT status FROM dokter ORDER BY status ASC");
                while ($Datakategori = mysqli_fetch_array($QryKategori)) {
                    $KategoriList= $Datakategori['status'];
                    echo '<option value="'.$KategoriList.'">'.$KategoriList.'</option>';
                }
                echo '</select>';
                echo '<small>Kata Kunci</small>';
            }else{
                echo '<input type="text" class="form-control" name="keyword" id="keyword" placeholder="Kata Kunci">';
                echo '<small>Kata Kunci</small>';
            }
        }
    }else{
        echo '<input type="text" class="form-control" name="keyword" id="keyword" placeholder="Kata Kunci">';
        echo '<small>Kata Kunci</small>';
    }
?>