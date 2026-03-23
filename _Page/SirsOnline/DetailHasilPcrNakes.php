<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/FungsiSirsOnline.php";
    $tgllapor=date('Y-m-d H:i:s');
    if(empty($_POST['id_nakes_pcr'])){
        echo '<div class="row">';
        echo '  <div class="col-xl-12 col-md-12 text-danger text-center">';
        echo '      ID Laporan Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_nakes_pcr=$_POST['id_nakes_pcr'];
        $tanggal=getDataDetail($Conn,'nakes_pcr','id_nakes_pcr',$id_nakes_pcr,'tanggal');
        $nama_nakes=getDataDetail($Conn,'nakes_pcr','id_nakes_pcr',$id_nakes_pcr,'nama_nakes');
        $kategori_nakes=getDataDetail($Conn,'nakes_pcr','id_nakes_pcr',$id_nakes_pcr,'kategori_nakes');
        $hasil_pcr=getDataDetail($Conn,'nakes_pcr','id_nakes_pcr',$id_nakes_pcr,'hasil_pcr');
        $id_akses=getDataDetail($Conn,'nakes_pcr','id_nakes_pcr',$id_nakes_pcr,'id_akses');
        //Detail Petugas
        $NamaPetugas=getDataDetail($Conn,'akses','id_akses',$id_akses,'nama');
?>
    <div class="row mb-3">
        <div class="col-md-6">ID Laporan</div>
        <div class="col-md-6"><?php echo "$id_nakes_pcr"; ?></div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">Tanggal</div>
        <div class="col-md-6"><?php echo "$tanggal"; ?></div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">Nama Nakes</div>
        <div class="col-md-6"><?php echo "$nama_nakes"; ?></div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">Kategori Nakes</div>
        <div class="col-md-6"><?php echo "$kategori_nakes"; ?></div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">Hasil PCR</div>
        <div class="col-md-6"><?php echo "$hasil_pcr"; ?></div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">Nama Petugas</div>
        <div class="col-md-6"><?php echo "$NamaPetugas"; ?></div>
    </div>
<?php } ?>