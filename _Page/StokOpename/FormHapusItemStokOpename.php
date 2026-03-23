<?php
    if(empty($_POST['id_obat_so'])){
        echo '<span class="text-danger">ID Obat SO Tidak Boleh Kosong!</span>';
    }else{
        echo '<input type="hidden" name="id_obat_so" value="'.$_POST['id_obat_so'].'">';
        echo '<img src="assets/images/question.gif" width="70%" alt="">';
    }
?>