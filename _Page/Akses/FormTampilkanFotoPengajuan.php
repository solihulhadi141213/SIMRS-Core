<?php
    if(empty($_POST['foto'])){
        echo "Tidak Ada File Foto";
    }else{
        $foto=$_POST['foto'];
        echo '<img src="assets/images/PengajuanAkses/'.$foto.'" width="100%">';
    }
?>