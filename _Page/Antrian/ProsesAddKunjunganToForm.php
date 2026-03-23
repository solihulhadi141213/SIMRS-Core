<?php
    if(!empty($_POST['GetIdKunjungan'])){
        $GetIdKunjungan=$_POST['GetIdKunjungan'];
        echo '<span id="NotifikasiTambahkanKunjunganKeFormBerhasil">Berhasil</span><br>';
        echo '<dt id="NomorKunjunganYangDipilih">'.$GetIdKunjungan.'</dt>';
    }else{
        echo 'Silahkan Pilih Salah Satu Nomor Kunjungan Yang Ditemukan dan tambahkan ke form';
    }
?>