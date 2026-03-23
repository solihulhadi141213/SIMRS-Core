<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/FungsiSirsOnline.php";
    if(empty($_POST['keyword_by'])){
        echo '<label for="keyword">Kata Kunci</label>';
        echo '<input type="date" name="keyword" id="keyword" class="form-control">';
    }else{
        $keyword_by=$_POST['keyword_by'];
        if($keyword_by=="updatetime"||$keyword_by=="tanggal"){
            echo '<label for="keyword">Kata Kunci</label>';
            echo '<input type="date" name="keyword" id="keyword" class="form-control">';
        }else{
            if($keyword_by=="id_akses"){
                echo '<label for="keyword">Kata Kunci</label>';
                echo '<select name="keyword" id="keyword" class="form-control">';
                echo '  <option value="">Pilih</option>';
                $query = mysqli_query($Conn, "SELECT DISTINCT id_akses FROM sirs_online_task WHERE kategori='Oksigen'");
                while ($data = mysqli_fetch_array($query)) {
                    if(!empty($data['id_akses'])){
                        $id_akses= $data['id_akses'];
                        //Buka Nama Kode Poli
                        $NamaPetugas=getDataDetail($Conn,'akses','id_akses',$id_akses,'nama');
                        echo '  <option value="'.$id_akses.'">'.$NamaPetugas.'</option>';
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