<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //id_pasien
    if(empty($_POST['id_obat'])){
        echo '<span class="text-danger">Silahkan Pilih Salah Satu Item Obat</span>';
    }else{
        foreach ($_POST['id_obat'] as $option) {
            $nama_obat=getDataDetail($Conn,"obat",'id_obat',$option,'nama');
            $satuan=getDataDetail($Conn,"obat",'id_obat',$option,'satuan');
            echo '<div class="row">';
            echo '  <div class="col-md-4">ID Obat</div>';
            echo '  <div class="col-md-8" id="GetIdObat">'.$option.'</div>';
            echo '</div>';
            echo '<div class="row">';
            echo '  <div class="col-md-4">Nama Obat</div>';
            echo '  <div class="col-md-8" id="GetNamaObat">'.$nama_obat.'</div>';
            echo '</div>';
            echo '<div class="row">';
            echo '  <div class="col-md-4">Satuan</div>';
            echo '  <div class="col-md-8" id="GetSatuanObat">'.$satuan.'</div>';
            echo '</div>';
        }
    }
?>