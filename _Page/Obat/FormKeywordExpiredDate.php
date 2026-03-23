<?php
    include "../../_Config/Connection.php";
    //Tangkap Keyword By
    if(empty($_POST['KeywordByExpiredDate'])){
        echo '<input type="text" class="form-control" name="KeywordExpiredDate" id="KeywordExpiredDate" placeholder="Kata Kunci">';
        echo '<label for="KeywordExpiredDate"><small>Pencarian</small></label>';
    }else{
        $KeywordByExpiredDate=$_POST['KeywordByExpiredDate'];
        if($KeywordByExpiredDate=="batch"){
            echo '<input type="text" class="form-control" name="KeywordExpiredDate" id="KeywordExpiredDate" placeholder="Contoh: 77758574837">';
            echo '<label for="KeywordExpiredDate"><small>Nomor Batch</small></label>';
        }else{
            if($KeywordByExpiredDate=="expired"||$KeywordByExpiredDate=="ingatkan"){
                echo '<input type="date" class="form-control" name="KeywordExpiredDate" id="KeywordExpiredDate">';
                echo '<label for="KeywordExpiredDate"><small>Tanggal</small></label>';
            }else{
                if($KeywordByExpiredDate=="status"){
                    echo '<select name="KeywordExpiredDate" id="KeywordExpiredDate" class="form-control">';
                    echo '  <option value="">Pilih</option>';
                    echo '  <option value="Tersedia">Tersedia</option>';
                    echo '  <option value="Terjual">Terjual</option>';
                    echo '</select>';
                    echo '<label for="KeywordExpiredDate"><small>Status</small></label>';
                }
            }
        }
    }
?>