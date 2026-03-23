<?php
    if(empty($_POST['FotoProfile'])){
        echo "Tidak Ada File Foto";
    }else{
        $FotoProfile=$_POST['FotoProfile'];
        echo '<img src="assets/images/user/'.$FotoProfile.'" width="100%">';
    }
?>