<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['keyword_by'])){
        echo '<label for="keyword">Kata Kunci</label>';
        echo '<input type="text" name="keyword" id="keyword" class="form-control">';
    }else{
        $keyword_by=$_POST['keyword_by'];
        if($keyword_by=="sumber"){
            echo '<label for="keyword">Kata Kunci</label>';
            echo '<select name="keyword" id="keyword" class="form-control">';
            echo '  <option value="">Pilih</option>';
            $query = mysqli_query($Conn, "SELECT DISTINCT sumber FROM referensi_alergi");
            while ($data = mysqli_fetch_array($query)) {
                $sumber= $data['sumber'];
                echo '  <option value="'.$sumber.'">'.$sumber.'</option>';
            }
            echo '</select>';
        }else{
            echo '<label for="keyword">Kata Kunci</label>';
            echo '<input type="text" name="keyword" id="keyword" class="form-control">';
        }
    }
?>