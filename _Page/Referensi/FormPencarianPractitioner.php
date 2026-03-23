<?php
    if(!empty($_POST['kategori_pencarian_practitioner'])){
        $kategori_pencarian_practitioner=$_POST['kategori_pencarian_practitioner'];
        if($kategori_pencarian_practitioner=="NIK"){
            echo '<div class="col-md-12 mb-3">';
            echo '  <input type="text" class="form-control" name="nik" id="nik">';
            echo '  <small>NIK Practitioner</small>';
            echo '</div>';
        }else{
            if($kategori_pencarian_practitioner=="id_practitioner"){
                echo '<div class="col-md-12 mb-3">';
                echo '  <input type="text" class="form-control" name="id_practitioner" id="id_practitioner">';
                echo '  <small>ID Practitioner</small>';
                echo '</div>';
            }else{
                if($kategori_pencarian_practitioner=="Identitas"){
                    echo '<div class="col-md-12 mb-3">';
                    echo '  <input type="text" class="form-control" name="nama" id="nama">';
                    echo '  <small>Nama Practitioner</small>';
                    echo '</div>';
                    echo '<div class="col-md-12 mb-3">';
                    echo '  <input type="number" class="form-control" name="tanggal_lahir" id="tanggal_lahir">';
                    echo '  <small>Tahun Lahir</small>';
                    echo '</div>';
                    echo '<div class="col-md-12 mb-3">';
                    echo '  <select class="form-control" name="gender" id="gender">';
                    echo '      <option value="male">Laki-Laki</option>';
                    echo '      <option value="female">Perempuan</option>';
                    echo '  </select>';
                    echo '  <small>Gender</small>';
                    echo '</div>';
                }else{
        
                }
            }
        }
    }
?>