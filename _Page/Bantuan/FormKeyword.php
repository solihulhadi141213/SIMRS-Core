<?php
    include "../../_Config/Connection.php";
    if(empty($_POST['keyword_by'])){
        echo '<label for="keyword">Kata Kunci</label>';
        echo '<input type="text" name="keyword" id="keyword" class="form-control">';
    }else{
        $keyword_by=$_POST['keyword_by'];
        if($keyword_by=="tanggal"){
            echo '<label for="date">Kata Kunci</label>';
            echo '<input type="text" name="keyword" id="keyword" class="form-control">';
        }else{
            if($keyword_by=="kategori"){
                echo '<label for="date">Kata Kunci</label>';
                echo '<select name="keyword" id="keyword" class="form-control">';
                echo '  <option value="">Pilih</option>';
                $query = mysqli_query($Conn, "SELECT DISTINCT kategori FROM bantuan");
                while ($data = mysqli_fetch_array($query)) {
                    $kategori = $data['kategori'];
                    //Hitung Jumlah masing-masing Kategori
                    $JumlahData = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM bantuan WHERE kategori='$kategori'"));
                    echo '<option value="'.$kategori.'">'.$kategori.' ('.$JumlahData.')</option>';
                }
                echo '</select>';
            }else{
                if($keyword_by=="status"){
                    echo '<label for="date">Kata Kunci</label>';
                    echo '<select name="keyword" id="keyword" class="form-control">';
                    echo '  <option value="">Pilih</option>';
                    echo '  <option value="Terbit">Terbit</option>';
                    echo '  <option value="Draft">Draft</option>';
                    echo '</select>';
                }else{
                    echo '<label for="keyword">Kata Kunci</label>';
                    echo '<input type="text" name="keyword" id="keyword" class="form-control">';
                }
            }
        }
    }
?>