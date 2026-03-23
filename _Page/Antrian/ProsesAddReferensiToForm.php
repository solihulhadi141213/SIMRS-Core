<?php
    if(!empty($_POST['NomorReferensiToAdd'])){
        $NomorReferensiToAdd=$_POST['NomorReferensiToAdd'];
        echo '<span id="NotifikasiAddReferensiToFormBerhasil">Berhasil</span><br>';
        echo '<dt id="NomorReferensiYangDipilih">'.$NomorReferensiToAdd.'</dt>';
    }else{
        echo 'Silahkan Pilih Salah Satu Nomor Referensi Yang Ditemukan dan tambahkan ke form';
    }
?>