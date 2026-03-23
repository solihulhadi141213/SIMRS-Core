<?php
    if(empty($_POST['tanggal'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center text-danger">';
        echo '      Tanggal PCR Nakes Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        $tanggal=$_POST['tanggal'];
        echo '<input type="hidden" name="tanggal" id="tanggal" value="'.$tanggal.'">';
        echo '<div class="row mb-3">';
        echo '  <div class="col-md-12 text-center text-dark">';
        echo '      Apabila data laporan sudah ada sesuai tanggal tersebut maka sistem akan melakukan update.';
        echo '  </div>';
        echo '</div>';
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center text-dark" id="NotifikasiCopyPcrNakes">';
        echo '      Apakah Anda Yakin Akan Copy Data Laporan PCR Nakes Ini?';
        echo '  </div>';
        echo '</div>';
    }
?>