<?php
    include "../../_Config/Connection.php";
    //Tangkap Keyword By
    if(empty($_POST['keyword_by'])){
        echo '<input type="text" class="form-control" name="keyword" id="keyword" placeholder="Kode, Nama , Kategori, Satuan">';
    }else{
        $keyword_by=$_POST['keyword_by'];
        if($keyword_by=="kelompok"){
            echo '<select class="form-control" name="keyword" id="keyword">';
                //Menampilkan kelompok item secara distinct
                $JumlahKelompok = mysqli_num_rows(mysqli_query($Conn, "SELECT DISTINCT kelompok FROM obat"));
                if(empty($JumlahKelompok)){
                    echo '<option value="">Pilih</option>';
                }else{
                    echo '<option value="">Pilih</option>';
                    $query = mysqli_query($Conn, "SELECT DISTINCT kelompok FROM obat ORDER BY kelompok ASC");
                    while ($data = mysqli_fetch_array($query)) {
                        if(!empty($data['kelompok'])){
                            $kelompok= $data['kelompok'];
                            echo '<option value="'.$kelompok.'">'.$kelompok.'</option>';
                        }
                    }
                }
                echo '</select>';
        }else{
            if($keyword_by=="kategori"){
                echo '<select class="form-control" name="keyword" id="keyword">';
                //Menampilkan Kategori item secara distinct
                $JumlahKategori = mysqli_num_rows(mysqli_query($Conn, "SELECT DISTINCT kategori FROM obat"));
                if(empty($JumlahKategori)){
                    echo '<option value="">Pilih</option>';
                }else{
                    echo '<option value="">Pilih</option>';
                    $query = mysqli_query($Conn, "SELECT DISTINCT kategori FROM obat ORDER BY kategori ASC");
                    while ($data = mysqli_fetch_array($query)) {
                        if(!empty($data['kategori'])){
                            $kategori= $data['kategori'];
                            echo '<option value="'.$kategori.'">'.$kategori.'</option>';
                        }
                    }
                }
                echo '</select>';
            }else{
                if($keyword_by=="tanggal"){
                    echo '<input type="date" class="form-control" name="keyword" id="keyword" placeholder="Kode, Nama , Kategori, Satuan">';
                }else{
                    if($keyword_by=="updatetime"){
                        echo '<input type="date" class="form-control" name="keyword" id="keyword" placeholder="Kode, Nama , Kategori, Satuan">';
                    }else{
                        echo '<input type="text" class="form-control" name="keyword" id="keyword" placeholder="Kode, Nama , Kategori, Satuan">';
                    }
                }
            }
        }
    }
?>