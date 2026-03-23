<?php
    include "../../_Config/Connection.php";
    if(!empty($_POST['keyword_by_practitioner'])){
        $keyword_by_practitioner=$_POST['keyword_by_practitioner'];
        if($keyword_by_practitioner=="kategori"){
            echo '<div class="col-md-12 mb-3">';
            echo '  <select class="form-control" name="keyword_practitioner" id="keyword_practitioner">';
            $QryKategori = mysqli_query($Conn, "SELECT DISTINCT kategori FROM referensi_practitioner ORDER BY kategori ASC");
            while ($DataKategori = mysqli_fetch_array($QryKategori)) {
                $KategoriPractitionerList= $DataKategori['kategori'];
                echo '<option value="'.$KategoriPractitionerList.'">'.$KategoriPractitionerList.'</option>';
            }
            echo '  </select>';
            echo '  <small>Kategori Practitioner</small>';
            echo '</div>';
        }else{
            if($keyword_by_practitioner=="gender"){
                echo '<div class="col-md-12 mb-3">';
                echo '  <select class="form-control" name="keyword_practitioner" id="keyword_practitioner">';
                echo '      <option value="male">Male</option>';
                echo '      <option value="female">Female</option>';
                echo '  </select>';
                echo '  <small>Gender Practitioner</small>';
                echo '</div>';
            }else{
                if($keyword_by_practitioner=="tanggal_lahir"){
                    echo '<div class="col-md-12 mb-3">';
                    echo '  <input type="date" class="form-control" name="keyword_practitioner" id="keyword_practitioner">';
                    echo '  <small>Tanggal Lahir</small>';
                    echo '</div>';
                }else{
                    if($keyword_by_practitioner=="status"){
                        echo '<div class="col-md-12 mb-3">';
                        echo '  <select class="form-control" name="keyword_practitioner" id="keyword_practitioner">';
                        echo '      <option value="Aktif">Aktif</option>';
                        echo '      <option value="Tidak Aktif">Tidak Aktif</option>';
                        echo '  </select>';
                        echo '  <small>Status Practitioner</small>';
                        echo '</div>';
                    }else{
                        echo '<div class="col-md-12 mb-3">';
                        echo '  <input type="text" class="form-control" name="keyword_practitioner" id="keyword_practitioner">';
                        echo '  <small>Keyword</small>';
                        echo '</div>';
                    }
                }
            }
        }
    }else{
        echo '<div class="col-md-12 mb-3">';
        echo '  <input type="text" class="form-control" name="keyword_practitioner" id="keyword_practitioner">';
        echo '  <small>Keyword</small>';
        echo '</div>';
    }
?>