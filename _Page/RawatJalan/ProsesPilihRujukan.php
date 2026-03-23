<?php
    if(empty($_POST['ItemPilihRujukan'])){
        echo '<span class="text-danger">';
        echo '  Tidak ada data SEP yang Dipilih, Silahkan pilih SEP terlebih Dulu.';
        echo '</span>';
    }else{
        $ItemPilihRujukan=$_POST['ItemPilihRujukan'];
        //Explode
        $Explode = explode("-" , $ItemPilihRujukan);
        if(empty($Explode[0])){
            echo '<span class="text-danger">';
            echo '  Terjadi kesalahan ketika melakukan konfirmasi Nomor Rujukan..';
            echo '</span>';
        }else{
            if(empty($Explode[1])){
                echo '<span class="text-danger">';
                echo '  Terjadi kesalahan ketika melakukan konfirmasi Nomor Rujukan.';
                echo '</span>';
            }else{
                $NomorRujukan=$Explode[0];
                $KodePpk=$Explode[1];
                echo '<input type="hidden" id="PpkRujukan" value="'.$KodePpk.'">';
                echo '<input type="hidden" id="GetNoRujukan" value="'.$NomorRujukan.'">';
                echo '<span class="text-success" id="NotifikasiTambahkanRujukanKeFormBerhasil">Success</span>';
            }
        }
    }
?>