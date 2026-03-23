<?php
    include "../../_Config/Connection.php";
    if(!empty($_POST['keyword_by'])){
        $keyword_by=$_POST['keyword_by'];
        if($keyword_by=="updatetime"){
            echo '<input type="date" class="form-control" name="keyword" id="keyword" placeholder="Kata Kunci">';
        }else{
            if($keyword_by=="id_akses"){
                include "../../_Config/Connection.php";
                echo '<select name="keyword" id="keyword" class="form-control">';
                echo '  <option value="">Pilih</option>';
                $Qry = mysqli_query($Conn, "SELECT * FROM akses ORDER BY nama ASC");
                while ($Data = mysqli_fetch_array($Qry)) {
                    $id_akses= $Data['id_akses'];
                    $nama= $Data['nama'];
                    echo '<option value="'.$id_akses.'">'.$nama.'</option>';
                }
                echo '</select>';
            }else{
                echo '<input type="text" class="form-control" name="keyword" id="keyword" placeholder="Kata Kunci">';
            }
        }
    }else{
        echo '<input type="text" class="form-control" name="keyword" id="keyword" placeholder="Kata Kunci">';
    }
?>