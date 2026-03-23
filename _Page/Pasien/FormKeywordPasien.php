<?php
    include "../../_Config/Connection.php";
    if(empty($_POST['keyword_by'])){
        echo '<input type="text" class="form-control" name="keyword" id="keyword" placeholder="Kata Kunci">';
        echo '<small>Keyword</small>';
    }else{
        $keyword_by=$_POST['keyword_by'];
        if($keyword_by=="status"){
            echo '<select class="form-control" name="keyword" id="keyword">';
            $query = mysqli_query($Conn, "SELECT DISTINCT status FROM pasien ORDER BY status ASC");
            while ($data = mysqli_fetch_array($query)) {
                $status= $data['status'];
                echo '<option value="'.$status.'">'.$status.'</option>';
            }
            echo '</select>';
            echo '<small>Keyword</small>';
        }else{
            if($keyword_by=="tanggal_daftar"){
                echo '<input type="date" class="form-control" name="keyword" id="keyword" placeholder="Kata Kunci">';
                echo '<small>Keyword</small>';
            }else{
                if($keyword_by=="gender"){
                    echo '<select class="form-control" name="keyword" id="keyword">';
                    $query = mysqli_query($Conn, "SELECT DISTINCT gender FROM pasien ORDER BY gender ASC");
                    while ($data = mysqli_fetch_array($query)) {
                        $gender= $data['gender'];
                        echo '<option value="'.$gender.'">'.$gender.'</option>';
                    }
                    echo '</select>';
                    echo '<small>Keyword</small>';
                }else{
                    echo '<input type="text" class="form-control" name="keyword" id="keyword" placeholder="Kata Kunci">';
                    echo '<small>Keyword</small>';
                }
            }
        }
    }
?>