<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/FungsiSirsOnline.php";
    if(empty($_POST['keyword_by'])){
        echo '<label for="keyword">Kata Kunci</label>';
        echo '<input type="text" name="keyword" id="keyword" class="form-control">';
    }else{
        $keyword_by=$_POST['keyword_by'];
        if($keyword_by=="tanggal_daftar"||$keyword_by=="tanggal_kunjungan"){
            echo '<label for="keyword">Kata Kunci</label>';
            echo '<input type="date" name="keyword" id="keyword" class="form-control">';
        }else{
            if($keyword_by=="kodepoli"){
                echo '<label for="keyword">Kata Kunci</label>';
                echo '<select name="keyword" id="keyword" class="form-control">';
                echo '  <option value="">Pilih</option>';
                $query = mysqli_query($Conn, "SELECT DISTINCT kodepoli FROM antrian");
                while ($data = mysqli_fetch_array($query)) {
                    if(!empty($data['kodepoli'])){
                        $kodepoli= $data['kodepoli'];
                        //Buka Nama Kode Poli
                        $NamaPoliklinik=getDataDetail($Conn,'poliklinik','kode',$kodepoli,'nama');
                        echo '  <option value="'.$kodepoli.'">'.$kodepoli.'-'.$NamaPoliklinik.'</option>';
                    }
                }
                echo '</select>';
            }else{
                echo '<label for="keyword">Kata Kunci</label>';
                echo '<input type="text" name="keyword" id="keyword" class="form-control">';
            }
        }
    }
?>