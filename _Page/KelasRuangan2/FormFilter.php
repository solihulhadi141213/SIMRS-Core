<?php
    //Koneksi
    include "../../_Config/Connection.php";

    //Apabila Kosong
    if(empty($_POST['KeywordBy'])){
        echo '<input type="text" name="keyword" id="keyword" class="form-control">';
    }else{
        $KeywordBy=$_POST['KeywordBy'];
        if($KeywordBy=="kelas"||$KeywordBy=="ruangan"||$KeywordBy=="bed"){
            echo '<input type="text" name="keyword" id="keyword" class="form-control">';
        }elseif($KeywordBy=="kodekelas"){
            echo '<select name="keyword_by" id="KeywordBy" class="form-control">';
            echo '  <option value="">Pilih</option>';
            $query = mysqli_query($Conn, "SELECT DISTINCT kodekelas FROM ruang_rawat");
            while ($data = mysqli_fetch_array($query)) {
                if(!empty($data['kodekelas'])){
                    $kodekelas = $data['kodekelas'];
                    echo '  <option value="'.$kodekelas.'">'.$kodekelas.'</option>';
                }
            }
            echo '</select>';
        }elseif($KeywordBy=="updatetime"){
            echo '<input type="date" name="keyword" id="keyword" class="form-control">';
        }elseif($KeywordBy=="status"){
            echo '<select name="keyword_by" id="KeywordBy" class="form-control">';
            echo '  <option value="">Pilih</option>';
            $query = mysqli_query($Conn, "SELECT DISTINCT status FROM ruang_rawat");
            while ($data = mysqli_fetch_array($query)) {
                if(!empty($data['status'])){
                    $status = $data['status'];
                    echo '  <option value="'.$status.'">'.$status.'</option>';
                }
            }
            echo '</select>';
        }
    }
?>