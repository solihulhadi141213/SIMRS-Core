<?php
    if(empty($_POST['keyword_by'])){
        echo '<label for="keyword">Kata Kunci</label>';
        echo '<input type="text" name="keyword" id="keyword" class="form-control">';
    }else{
        $keyword_by=$_POST['keyword_by'];
        if($keyword_by=="tgllahir"){
            echo '<label for="keyword">Kata Kunci</label>';
            echo '<input type="date" name="keyword" id="keyword" class="form-control">';
        }else{
            if($keyword_by=="gender_anak"){
                echo '<label for="keyword">Kata Kunci</label>';
                echo '<select name="keyword" id="keyword" class="form-control">';
                echo '     <option value="">Pilih</option>';
                echo '     <option value="Laki-Laki">Laki-Laki</option>';
                echo '     <option value="Perempuan">Perempuan</option>';
                echo '</select>';
            }else{
                echo '<label for="keyword">Kata Kunci</label>';
                echo '<input type="text" name="keyword" id="keyword" class="form-control">';
            }
        }
    }
?>