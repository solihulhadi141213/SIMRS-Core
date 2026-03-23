<?php
    if(!empty($_POST['DasarPencarianPasienSatuSehat'])){
        $DasarPencarianPasienSatuSehat=$_POST['DasarPencarianPasienSatuSehat'];
        if($DasarPencarianPasienSatuSehat=="NIK"){
            echo '<div class="col-md-12 mb-3">';
            echo '  <input type="text" class="form-control" id="nik_pasien" name="nik_pasien">';
            echo '  <small>NIK</small>';
            echo '</div>';
        }else{
            if($DasarPencarianPasienSatuSehat=="NIK Ibu"){
                echo '<div class="col-md-12 mb-3">';
                echo '  <input type="text" class="form-control" id="nik_ibu" name="nik_ibu">';
                echo '  <small>NIK Ibu</small>';
                echo '</div>';
            }else{
                if($DasarPencarianPasienSatuSehat=="Nama Pasien"){
                    echo '<div class="col-md-12 mb-3">';
                    echo '  <input type="text" class="form-control" id="nama_pasien" name="nama_pasien">';
                    echo '  <small>Nama Pasien</small>';
                    echo '</div>';
                    echo '<div class="col-md-12 mb-3">';
                    echo '  <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir">';
                    echo '  <small>Tanggal Lahir</small>';
                    echo '</div>';
                    echo '<div class="col-md-12 mb-3">';
                    echo '  <input type="text" class="form-control" id="nik_pasien" name="nik_pasien">';
                    echo '  <small>NIK</small>';
                    echo '</div>';
                }else{
                    if($DasarPencarianPasienSatuSehat=="ID Pasien"){
                        echo '<div class="col-md-12 mb-3">';
                        echo '  <input type="text" class="form-control" id="IdPasien" name="IdPasien">';
                        echo '  <small>ID Pasien</small>';
                        echo '</div>';
                    }else{
            
                    }
                }
            }
        }
    }
?>