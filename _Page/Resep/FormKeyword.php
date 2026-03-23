<?php
    if(empty($_POST['keyword_by'])){
        echo '<input type="text" name="keyword" id="keyword" class="form-control">';
        echo '<label for="keyword"><small>Kata Kunci</small></label>';
    }else{
        $keyword_by=$_POST['keyword_by'];
        if($keyword_by=="tanggal_resep"){
            echo '<input type="date" name="keyword" id="keyword" class="form-control">';
            echo '<label for="keyword"><small>Kata Kunci</small></label>';
        }else{
            if($keyword_by=="status"){
                echo '<select name="keyword" id="keyword" class="form-control">';
                echo '  <option value="Pending">Pending</option>';
                echo '  <option value="Selesai">Selesai</option>';
                echo '</select>';
                echo '<label for="keyword"><small>Kata Kunci</small></label>';
            }else{
                echo '<input type="text" name="keyword" id="keyword" class="form-control">';
                echo '<label for="keyword"><small>Kata Kunci</small></label>';
            }
        }
    }
?>


    
    

