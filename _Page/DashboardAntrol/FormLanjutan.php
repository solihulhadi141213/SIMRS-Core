<?php
    //validasi mode
    if(empty($_POST['mode'])){
        $mode = "";
    }else{
        $mode = $_POST['mode'];
        if($mode == "Harian"){
            $tanggalSekarang=date('Y-m-d');
            echo '<div class="row mb-4">';
            echo '  <div class="col-md-12">';
            echo '      <label for="tanggal">Tanggal</label>';
            echo '      <input type="date" name="tanggal" id="tanggal" class="form-control" value="'.$tanggalSekarang.'">';
            echo '  </div>';
            echo '</div>';
        }else{
            echo '<div class="row mb-4">';
            echo '  <div class="col-md-12">';
            echo '      <label for="">Bulan</label>';
            echo '      <input type="month" name="bulan" id="bulan" class="form-control" value="'.date('m').'">';
            echo '  </div>';
            echo '</div>';
            echo '<div class="row mb-4">';
            echo '  <div class="col-md-12">';
            echo '      <label for="">Tahun</label>';
            echo '      <input type="year" name="tahun" id="tahun" class="form-control" value="'.date('Y').'">';
            echo '  </div>';
            echo '</div>';
        }
    }
?>