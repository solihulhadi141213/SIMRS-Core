<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['keyword_by'])){
        echo '<input type="text" name="keyword" id="keyword" class="form-control" placeholder="Kata kunci pencarian">';
    }else{
        $keyword_by=$_POST['keyword_by'];
        if($keyword_by=="expired"||$keyword_by=="ingatkan"){
            echo '<input type="date" name="keyword" id="keyword" class="form-control">';
        }else{
            if($keyword_by=="status"){
                echo '<select class="form-control" name="keyword" id="keyword">';
                echo '  <option value="Terjual">Terjual</option>';
                echo '  <option value="Tersedia">Tersedia</option>';
                echo '</select>';
            }else{
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
                        if($keyword_by=="satuan"){
                            echo '<select class="form-control" name="keyword" id="keyword">';
                            //Menampilkan satuan item secara distinct
                            $JumlahSatuan = mysqli_num_rows(mysqli_query($Conn, "SELECT DISTINCT satuan FROM obat"));
                            if(empty($JumlahSatuan)){
                                echo '<option value="">Pilih</option>';
                            }else{
                                echo '<option value="">Pilih</option>';
                                $query = mysqli_query($Conn, "SELECT DISTINCT satuan FROM obat ORDER BY satuan ASC");
                                while ($data = mysqli_fetch_array($query)) {
                                    if(!empty($data['satuan'])){
                                        $satuan= $data['satuan'];
                                        echo '<option value="'.$satuan.'">'.$satuan.'</option>';
                                    }
                                }
                            }
                            echo '</select>';
                        }else{
                            echo '<input type="text" name="keyword" id="keyword" class="form-control" placeholder="Kata kunci pencarian">';
                        }
                    }
                }
            }
        }
    }
?>