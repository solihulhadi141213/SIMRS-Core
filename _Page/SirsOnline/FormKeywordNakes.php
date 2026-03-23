<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/FungsiSirsOnline.php";
    if(empty($_POST['keyword_by_nakes'])){
        echo '<label for="keyword">Kata Kunci</label>';
        echo '<input type="text" name="keyword" id="keyword" class="form-control">';
    }else{
        $keyword_by_nakes=$_POST['keyword_by_nakes'];
        if($keyword_by_nakes=="kategori"){
            echo '<label for="keyword">Kata Kunci</label>';
            echo '<select name="keyword" id="keyword" class="form-control">';
            echo '  <option value="">Pilih</option>';
            $query = mysqli_query($Conn, "SELECT DISTINCT kategori FROM nakes");
            while ($data = mysqli_fetch_array($query)) {
                $kategori= $data['kategori'];
                echo '  <option value="'.$kategori.'">'.$kategori.'</option>';
            }
            echo '</select>';
        }else{
            if($keyword_by_nakes=="referensi_sdm"){
                echo '<label for="keyword">Kata Kunci</label>';
                echo '<select name="keyword" id="keyword" class="form-control">';
                echo '  <option value="">Pilih</option>';
                $query = mysqli_query($Conn, "SELECT DISTINCT referensi_sdm FROM nakes");
                while ($data = mysqli_fetch_array($query)) {
                    $referensi_sdm= $data['referensi_sdm'];
                    echo '  <option value="'.$referensi_sdm.'">'.$referensi_sdm.'</option>';
                }
                echo '</select>';
            }else{
                if($keyword_by_nakes=="id_akses"){
                    echo '<label for="keyword">Kata Kunci</label>';
                    echo '<select name="keyword" id="keyword" class="form-control">';
                    echo '  <option value="">Pilih</option>';
                    $query = mysqli_query($Conn, "SELECT DISTINCT id_akses FROM nakes");
                    while ($data = mysqli_fetch_array($query)) {
                        $id_akses= $data['id_akses'];
                        //Mendefinisikan id_akses
                        $NamaPetugas=getDataDetail($Conn,'akses','id_akses',$id_akses,'nama');
                        echo '  <option value="'.$id_akses.'">'.$NamaPetugas.'</option>';
                    }
                    echo '</select>';
                }else{
                    echo '<label for="keyword">Kata Kunci</label>';
                    echo '<input type="text" name="keyword" id="keyword" class="form-control">';
                }
            }
        }
    }
?>