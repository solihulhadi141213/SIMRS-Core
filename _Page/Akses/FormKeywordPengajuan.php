<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    if(!empty($_POST['keyword_by_pengajuan'])){
        $keyword_by_pengajuan=$_POST['keyword_by_pengajuan'];
        if($keyword_by_pengajuan=="tanggal"){
            echo '<input type="date" class="form-control" name="keyword_pengajuan" id="keyword_pengajuan" placeholder="Kata Kunci">';
            echo '<small>Pencarian</small>';
        }else{
            if($keyword_by_pengajuan=="status"){
                echo '<select name="keyword_pengajuan" id="keyword_pengajuan" class="form-control">';
                $QryKategori = mysqli_query($Conn, "SELECT DISTINCT status FROM akses_pengajuan ORDER BY status ASC");
                while ($Datakategori = mysqli_fetch_array($QryKategori)) {
                    $KategoriList= $Datakategori['status'];
                    echo '<option value="'.$KategoriList.'">'.$KategoriList.'</option>';
                }
                echo '</select>';
                echo '<small>Pencarian</small>';
            }else{
                echo '<input type="text" class="form-control" name="keyword_pengajuan" id="keyword_pengajuan" placeholder="Kata Kunci">';
                echo '<small>Pencarian</small>';
            }
        }
    }else{
        echo '<input type="text" class="form-control" name="keyword_pengajuan" id="keyword_pengajuan" placeholder="Kata Kunci">';
        echo '<small>Pencarian</small>';
    }
?>