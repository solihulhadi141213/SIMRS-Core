<?php
    include "../../_Config/Connection.php"; 
    include "../../_Config/Session.php"; 
    include "../../_Config/SimrsFunction.php"; 
    if(empty($_POST['id_antrian'])){
        echo '<div class="row"><div class="col col-md-12 mb-3 text-center text-danger">ID Antrian Tidak Boleh Kosong!</div></div>';
    }else{
        $id_antrian=$_POST['id_antrian'];
        //Buka Detail Antrian
        $no_antrian=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'no_antrian');
        $id_pasien=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'id_pasien');
        $kodebooking=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'kodebooking');
        $_SESSION['UrlBackKunjungan']="index.php?Page=Antrian&Sub=DetailAntrian&id=$id_antrian";
        echo '<div class="row mb-3">';
        echo '  <div class="col-md-12">';
        echo '      <dt>Keterangan:</dt>';
        echo '      Untuk menambahkan data kunjungan untuk ID antrian ini maka anda akan diarahkan pada halaman form tambah kunjungan.';
        echo '  </div>';
        echo '</div>';
        echo '<div class="row mb-3">';
        echo '  <div class="col-md-12">';
        echo '      <a href="index.php?Page=RawatJalan&Sub=TambahKunjungan&id='.$id_pasien.'&id_antrian='.$id_antrian.'" class="btn btn-sm btn-block btn-outline-dark">';
        echo '          Lanjutkan Ke Form Tambah Kunjungan';
        echo '      </a>';
        echo '  </div>';
        echo '</div>';
    }
?>