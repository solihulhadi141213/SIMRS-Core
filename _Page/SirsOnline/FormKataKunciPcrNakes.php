<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    if(!empty($_POST['keyword_by'])){
        $keyword_by=$_POST['keyword_by'];
        if($keyword_by=="tanggal"){
            echo '<label for="keyword"><small>Kata Kunci</small></label>';
            echo '<input type="date" name="keyword" id="keyword" class="form-control">';
        }else{
            if($keyword_by=="id_akses"){
                echo '<label for="keyword"><small>Kata Kunci</small></label>';
                echo '<select name="keyword" id="keyword" class="form-control">';
                echo '  <option value="">Pilih</option>';
                $query = mysqli_query($Conn, "SELECT DISTINCT id_akses FROM nakes_pcr");
                while ($data = mysqli_fetch_array($query)) {
                    $id_akses= $data['id_akses'];
                    $NamaPetugas=getDataDetail($Conn,'akses','id_akses',$id_akses,'nama');
                    echo '<option value="'.$id_akses.'">'.$NamaPetugas.'</option>';
                }
                echo '</select>';
            }else{
                if($keyword_by=="kategori_nakes"){
                    echo '<label for="keyword"><small>Kata Kunci</small></label>';
                    echo '<select name="keyword" id="keyword" class="form-control">';
                    echo '  <option value="">Pilih</option>';
                    $query = mysqli_query($Conn, "SELECT DISTINCT kategori_nakes FROM nakes_pcr");
                    while ($data = mysqli_fetch_array($query)) {
                        $kategori_nakes= $data['kategori_nakes'];
                        echo '<option value="'.$kategori_nakes.'">'.$kategori_nakes.'</option>';
                    }
                    echo '</select>';
                }else{
                    if($keyword_by=="hasil_pcr"){
                        echo '<label for="keyword"><small>Kata Kunci</small></label>';
                        echo '<select name="keyword" id="keyword" class="form-control">';
                        echo '  <option value="">Pilih</option>';
                        $query = mysqli_query($Conn, "SELECT DISTINCT hasil_pcr FROM nakes_pcr");
                        while ($data = mysqli_fetch_array($query)) {
                            $hasil_pcr= $data['hasil_pcr'];
                            echo '<option value="'.$hasil_pcr.'">'.$hasil_pcr.'</option>';
                        }
                        echo '</select>';
                    }else{
                        echo '<label for="keyword"><small>Kata Kunci</small></label>';
                        echo '<input type="text" name="keyword" id="keyword" class="form-control">';
                    }
                }
            }
        }
    }
?>