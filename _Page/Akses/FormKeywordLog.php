<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    if(!empty($_POST['KeywordByLog'])){
        $KeywordByLog=$_POST['KeywordByLog'];
        if($KeywordByLog=="waktu"){
            echo '<input type="date" class="form-control" name="KeywordLog" id="KeywordLog" placeholder="Kata Kunci">';
            echo '<small>Pencarian</small>';
        }else{
            if($KeywordByLog=="kategori"){
                echo '<select name="KeywordLog" id="KeywordLog" class="form-control">';
                $QryKategori = mysqli_query($Conn, "SELECT DISTINCT kategori FROM log ORDER BY kategori ASC");
                while ($Datakategori = mysqli_fetch_array($QryKategori)) {
                    $KategoriList= $Datakategori['kategori'];
                    echo '<option value="'.$KategoriList.'">'.$KategoriList.'</option>';
                }
                echo '</select>';
                echo '<small>Pencarian</small>';
            }else{
                echo '<input type="text" class="form-control" name="KeywordLog" id="KeywordLog" placeholder="Kata Kunci">';
                echo '<small>Pencarian</small>';
            }
        }
    }else{
        echo '<input type="text" class="form-control" name="KeywordLog" id="KeywordLog" placeholder="Kata Kunci">';
        echo '<small>Pencarian</small>';
    }
?>