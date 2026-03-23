<?php
    if(!empty($_POST['id_kunjungan'])){
        echo '<a href="index.php?Page=RawatJalan&Sub=DetailKunjungan&id='.$_POST['id_kunjungan'].'" class="btn btn-sm btn-block btn-round btn-outline-dark">';
        echo '  Lihat Selengkapnya';
        echo '</a>';
    }
?>