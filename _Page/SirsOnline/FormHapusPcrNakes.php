<?php
    if(empty($_POST['id_pcr_nakes'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center text-danger">';
        echo '      ID PCR Nakes Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_pcr_nakes=$_POST['id_pcr_nakes'];
        echo '<input type="hidden" name="id_pcr_nakes" id="id_pcr_nakes" value="'.$id_pcr_nakes.'">';
        echo '<div class="row mb-3">';
        echo '  <div class="col-md-12 text-dark text-center">';
        echo '      <input type="checkbox" name="HapusJugaDiSirsOnline" id="HapusJugaDiSirsOnline" value="Ya">';
        echo '      <label for="HapusJugaDiSirsOnline">Hapus Juga Di Sirs Online.</label>';
        echo '  </div>';
        echo '</div>';
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center text-dark" id="NotifikasiHapusPcrNakes">';
        echo '      Apakah Anda Yakin Akan Menghapus Data Laporan PCR Nakes Ini?';
        echo '  </div>';
        echo '</div>';
    }
?>