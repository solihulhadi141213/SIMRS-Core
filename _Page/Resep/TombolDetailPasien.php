<?php
    if(!empty($_POST['id_pasien'])){
        echo '<a href="index.php?Page=Pasien&Sub=DetailPasien&id='.$_POST['id_pasien'].'" class="btn btn-sm btn-block btn-round btn-outline-dark">';
        echo '  Lihat Selengkapnya';
        echo '</a>';
    }
?>