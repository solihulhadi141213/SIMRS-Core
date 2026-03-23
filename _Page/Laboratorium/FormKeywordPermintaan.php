<?php
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['keyword_by_permintaan'])){
        echo '<input type="text" class="form-control" name="keyword" id="keyword" placeholder="Kata Kunci">';
        echo '<small>Kata Kunci</small>';
    }else{
        $keyword_by_permintaan=$_POST['keyword_by_permintaan'];
        if($keyword_by_permintaan=="status"){
            echo '<select class="form-control" name="keyword" id="keyword">';
            $QryKategori = mysqli_query($Conn, "SELECT DISTINCT status FROM laboratorium_permintaan ORDER BY status ASC");
            while ($DataKategori = mysqli_fetch_array($QryKategori)) {
                $status= $DataKategori['status'];
                echo '<option value="'.$status.'">'.$status.'</option>';
            }
            echo '</select>';
        }else{
            if($keyword_by_permintaan=="prioritas"){
                echo '<select class="form-control" name="keyword" id="keyword">';
                $QryKategori = mysqli_query($Conn, "SELECT DISTINCT prioritas FROM laboratorium_permintaan ORDER BY prioritas ASC");
                while ($DataKategori = mysqli_fetch_array($QryKategori)) {
                    $prioritas= $DataKategori['prioritas'];
                    echo '<option value="'.$prioritas.'">'.$prioritas.'</option>';
                }
                echo '</select>';
            }else{
                if($keyword_by_permintaan=="tanggal"){
                    echo '<input type="date" class="form-control" name="keyword" id="keyword" placeholder="Kata Kunci">';
                    echo '<small>Kata Kunci</small>';
                }else{
                    echo '<input type="text" class="form-control" name="keyword" id="keyword" placeholder="Kata Kunci">';
                    echo '<small>Kata Kunci</small>';
                }
            }
        }
    }
?>