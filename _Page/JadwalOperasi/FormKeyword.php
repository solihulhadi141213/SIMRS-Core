<?php
    include "../../_Config/Connection.php";
    if(empty($_POST['keyword_by'])){
        echo '<input type="text" class="form-control" name="keyword" id="keyword" placeholder="Kata Kunci">';
        echo '<small>Pencarian</small>';
    }else{
        $keyword_by=$_POST['keyword_by'];
        if($keyword_by=="lastupdate"||$keyword_by=="tanggaloperasi"||$keyword_by=="tanggal_daftar"){
            echo '<input type="date" class="form-control" name="keyword" id="keyword" value="'.date('Y-m-d').'">';
            echo '<small>Pencarian Tanggal</small>';
        }else{
            if($keyword_by=="terlaksana"){
                echo '<select class="form-control" name="keyword" id="keyword">';
                echo '  <option value="0">Terdaftar</option>';
                echo '  <option value="1">Selesai</option>';
                echo '</select>';
                echo '<small>Status Jadwal</small>';
            }else{
                if($keyword_by=="namapoli"){
                    echo '<select class="form-control" name="keyword" id="keyword">';
                    echo '  <option value="">Pilih</option>';
                    //Array Nama Poli
                    $QryNamaPoli = mysqli_query($Conn, "SELECT DISTINCT namapoli FROM jadwal_operasi ORDER BY namapoli ASC");
                    while ($DataNamaPoli = mysqli_fetch_array($QryNamaPoli)) {
                        $namapoli = $DataNamaPoli['namapoli'];
                        echo '<option value="'.$namapoli.'">'.$namapoli.'</option>';
                    }
                    echo '</select>';
                    echo '<small>Nama Poli</small>';
                }else{
                    if($keyword_by=="kodepoli"){
                        echo '<select class="form-control" name="keyword" id="keyword">';
                        echo '  <option value="">Pilih</option>';
                        //Array Nama Poli
                        $QryNamaPoli = mysqli_query($Conn, "SELECT DISTINCT kodepoli FROM jadwal_operasi ORDER BY kodepoli ASC");
                        while ($DataNamaPoli = mysqli_fetch_array($QryNamaPoli)) {
                            $kodepoli = $DataNamaPoli['kodepoli'];
                            echo '<option value="'.$kodepoli.'">'.$kodepoli.'</option>';
                        }
                        echo '</select>';
                        echo '<small>Nama Poli</small>';
                    }else{
                        if($keyword_by=="kodepoli"){
                            echo '<select class="form-control" name="keyword" id="keyword">';
                            echo '  <option value="">Pilih</option>';
                            //Array Nama Poli
                            $QryNamaPoli = mysqli_query($Conn, "SELECT DISTINCT kodepoli FROM jadwal_operasi ORDER BY kodepoli ASC");
                            while ($DataNamaPoli = mysqli_fetch_array($QryNamaPoli)) {
                                $kodepoli = $DataNamaPoli['kodepoli'];
                                echo '<option value="'.$kodepoli.'">'.$kodepoli.'</option>';
                            }
                            echo '</select>';
                            echo '<small>Nama Poli</small>';
                        }else{
                            if($keyword_by=="jenistindakan"){
                                echo '<input type="text" class="form-control" name="keyword" id="keyword" list="ListKeyword" placeholder="Kata Kunci">';
                                echo '<datalist id="ListKeyword"></datalist>';
                                echo '<small>Pencarian</small>';
                            }else{
                                echo '<input type="text" class="form-control" name="keyword" id="keyword" list="ListKeyword" placeholder="Kata Kunci">';
                                echo '<datalist id="ListKeyword"></datalist>';
                                echo '<small>Pencarian</small>';
                            }
                        }
                    }
                }
            }
        }
    }
?>