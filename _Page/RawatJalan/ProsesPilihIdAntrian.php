<?php
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['GetIdAntrianPilih'])){
        echo '<span class="text-danger">Anda Belum Memilih Data Antrian</span>';
    }else{
        $GetIdAntrianPilih=$_POST['GetIdAntrianPilih'];
        $no_antrian=getDataDetail($Conn,'antrian','id_antrian',$GetIdAntrianPilih,'no_antrian');
        echo '<input type="hidden" id="GetIdAntrian" value="'.$GetIdAntrianPilih.'">';
        echo '<input type="hidden" id="GetNomorAntrian" value="'.$no_antrian.'">';
        echo '<span class="text-primary" id="NotifikasiPilihAntrianBerhasil">Pilih Antrian Berhasil</span>';
    }
?>