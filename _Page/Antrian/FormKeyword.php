<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    if(empty($_POST['keyword_by'])){
        echo '<input type="text" class="form-control" name="keyword" id="keyword" placeholder="Kata Kunci">';
        echo '<small>Keyword</small>';
    }else{
        $keyword_by=$_POST['keyword_by'];
        if($keyword_by=="tanggal_daftar"){
            echo '<input type="date" class="form-control" name="keyword" id="keyword" placeholder="Kata Kunci">';
            echo '<small>Tanggal Daftar</small>';
        }else{
            if($keyword_by=="tanggal_kunjungan"){
                echo '<input type="date" class="form-control" name="keyword" id="keyword" placeholder="Kata Kunci">';
                echo '<small>Tanggal Kunjungan</small>';
            }else{
                if($keyword_by=="nama_dokter"){
                    echo '<select class="form-control" name="keyword" id="keyword">';
                    echo '  <option value="">Pilih</option>';
                    $QryDokter = mysqli_query($Conn, "SELECT DISTINCT nama_dokter FROM antrian ORDER BY nama_dokter ASC");
                    while ($DataDokter = mysqli_fetch_array($QryDokter)) {
                        $nama_dokter = $DataDokter['nama_dokter'];
                        echo '  <option value="'.$nama_dokter.'">'.$nama_dokter.'</option>';
                    }
                    echo '</select>';
                    echo '<small>Dokter</small>';
                }else{
                    if($keyword_by=="namapoli"){
                        echo '<select class="form-control" name="keyword" id="keyword">';
                        echo '  <option value="">Pilih</option>';
                        $QryDokter = mysqli_query($Conn, "SELECT DISTINCT namapoli FROM antrian ORDER BY namapoli ASC");
                        while ($DataDokter = mysqli_fetch_array($QryDokter)) {
                            $namapoli = $DataDokter['namapoli'];
                            echo '  <option value="'.$namapoli.'">'.$namapoli.'</option>';
                        }
                        echo '</select>';
                        echo '<small>Poliklinik</small>';
                    }else{
                        if($keyword_by=="pembayaran"){
                            echo '<select class="form-control" name="keyword" id="keyword">';
                            echo '  <option value="">Pilih</option>';
                            $QryDokter = mysqli_query($Conn, "SELECT DISTINCT pembayaran FROM antrian ORDER BY pembayaran ASC");
                            while ($DataDokter = mysqli_fetch_array($QryDokter)) {
                                $pembayaran = $DataDokter['pembayaran'];
                                echo '  <option value="'.$pembayaran.'">'.$pembayaran.'</option>';
                            }
                            echo '</select>';
                            echo '<small>Poliklinik</small>';
                        }else{
                            if($keyword_by=="status"){
                                echo '<select class="form-control" name="keyword" id="keyword">';
                                echo '  <option value="">Pilih</option>';
                                $QryDokter = mysqli_query($Conn, "SELECT DISTINCT status FROM antrian ORDER BY status ASC");
                                while ($DataDokter = mysqli_fetch_array($QryDokter)) {
                                    $status = $DataDokter['status'];
                                    echo '  <option value="'.$status.'">'.$status.'</option>';
                                }
                                echo '</select>';
                                echo '<small>Poliklinik</small>';
                            }else{
                                if($keyword_by=="sumber_antrian"){
                                    echo '<select class="form-control" name="keyword" id="keyword">';
                                    echo '  <option value="">Pilih</option>';
                                    $QryDokter = mysqli_query($Conn, "SELECT DISTINCT sumber_antrian FROM antrian ORDER BY sumber_antrian ASC");
                                    while ($DataDokter = mysqli_fetch_array($QryDokter)) {
                                        $sumber_antrian = $DataDokter['sumber_antrian'];
                                        echo '  <option value="'.$sumber_antrian.'">'.$sumber_antrian.'</option>';
                                    }
                                    echo '</select>';
                                    echo '<small>Poliklinik</small>';
                                }else{
                                    echo '<input type="text" class="form-control" name="keyword" id="keyword" placeholder="Kata Kunci">';
                                    echo '<small>Kata Kunci</small>';
                                }
                            }
                        }
                    }
                }
            }
        }
    }
?>