<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    if(!empty($_POST['keyword_by'])){
        $keyword_by=$_POST['keyword_by'];
        if($keyword_by=="tanggal"){
            echo '<input type="date" class="form-control" name="keyword" id="keyword" placeholder="Kata Kunci">';
            echo '<small>Pencarian</small>';
        }else{
            if($keyword_by=="updatetime"){
                echo '<input type="date" class="form-control" name="keyword" id="keyword" placeholder="Kata Kunci">';
                echo '<small>Pencarian</small>';
            }else{
                if($keyword_by=="akses"){
                    echo '<select name="keyword" id="keyword" class="form-control">';
                    $QryAkses = mysqli_query($Conn, "SELECT DISTINCT akses FROM akses ORDER BY akses ASC");
                    while ($DataAkses = mysqli_fetch_array($QryAkses)) {
                        $AksesList= $DataAkses['akses'];
                        echo '<option value="'.$AksesList.'">'.$AksesList.'</option>';
                    }
                    echo '</select>';
                    echo '<small>Pencarian</small>';
                }else{
                    echo '<input type="text" class="form-control" name="keyword" id="keyword" placeholder="Kata Kunci">';
                    echo '<small>Pencarian</small>';
                }
            }
        }
    }else{
        echo '<input type="text" class="form-control" name="keyword" id="keyword" placeholder="Kata Kunci">';
        echo '<small>Pencarian</small>';
    }
?>