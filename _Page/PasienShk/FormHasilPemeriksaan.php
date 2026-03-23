<?php
    if(empty($_POST['jenis_pemeriksaan'])){
        echo '<select name="hasil_pemeriksaan" id="hasil_pemeriksaan" class="form-control">';
        echo '  <option value="">Pilih</option>';
        echo '</select>';
    }else{
        $jenis_pemeriksaan=$_POST['jenis_pemeriksaan'];
        if($jenis_pemeriksaan=="1"){
            echo '<select name="hasil_pemeriksaan" id="hasil_pemeriksaan" class="form-control">';
            echo '  <option value="">Pilih</option>';
            echo '  <option value="1">TSH Normal (< 20 μU/mL)</option>';
            echo '  <option value="2">TSH Tinggi (? 20 μU/mL)</option>';
            echo '</select>';
        }else{
            echo '<select name="hasil_pemeriksaan" id="hasil_pemeriksaan" class="form-control">';
            echo '  <option value="">Pilih</option>';
            echo '  <option value="3">Positif (Serum FT4 di bawah normal, FT4 normal ATAU TSH >= 20µU/ml (2 kali pemeriksaan))</option>';
            echo '  <option value="4">Negatif</option>  ';
            echo '</select>';
        }
    }
?>