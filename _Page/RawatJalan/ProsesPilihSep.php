<?php
    if(empty($_POST['ItemPilihSep'])){
        echo '<span class="text-danger">';
        echo '  Tidak ada data SEP yang Dipilih, Silahkan pilih SEP terlebih Dulu.';
        echo '</span>';
    }else{
        $ItemPilihSep=$_POST['ItemPilihSep'];
        //Explode
        $Explode = explode("-" , $ItemPilihSep);
        if(empty($Explode[0])){
            echo '<span class="text-danger">';
            echo '  Terjadi kesalahan ketika melakukan konfirmasi Nomor SEP..';
            echo '</span>';
        }else{
            if(empty($Explode[1])){
                echo '<span class="text-danger">';
                echo '  Terjadi kesalahan ketika melakukan konfirmasi Nomor Rujukan.';
                echo '</span>';
            }else{
                $noSep=$Explode[0];
                $noRujukan=$Explode[1];
                echo '<input type="hidden" id="GetNoSep" value="'.$noSep.'">';
                echo '<input type="hidden" id="GetNoRujukan" value="'.$noRujukan.'">';
                echo '<span class="text-success" id="NotifikasiTambahkanSepKeFormBerhasil">Success</span>';
            }
        }
    }
?>