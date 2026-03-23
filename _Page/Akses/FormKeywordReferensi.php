<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    if(!empty($_POST['keyword_by_referensi'])){
        $keyword_by_referensi=$_POST['keyword_by_referensi'];
        if($keyword_by_referensi=="kategori"){
            echo '<select name="keyword_referensi" id="keyword_referensi" class="form-control">';
            $QryKategori = mysqli_query($Conn, "SELECT DISTINCT kategori FROM akses_ref ORDER BY kategori ASC");
            while ($Datakategori = mysqli_fetch_array($QryKategori)) {
                $KategoriList= $Datakategori['kategori'];
                echo '<option value="'.$KategoriList.'">'.$KategoriList.'</option>';
            }
            echo '</select>';
            echo '<small>Pencarian</small>';
        }else{
            echo '<input type="text" class="form-control" name="keyword_referensi" id="keyword_referensi" placeholder="Kata Kunci">';
            echo '<small>Pencarian</small>';
        }
    }else{
        echo '<input type="text" class="form-control" name="keyword_referensi" id="keyword_referensi" placeholder="Kata Kunci">';
        echo '<small>Pencarian</small>';
    }
?>