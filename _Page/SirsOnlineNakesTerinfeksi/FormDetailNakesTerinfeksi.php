<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/FungsiSirsOnline.php";
    if(empty($_POST['id_nakes_terinfeksi'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center text-danger">';
        echo '      ID Nakes Terinfeksi Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_nakes_terinfeksi=$_POST['id_nakes_terinfeksi'];
        $id_nakes_pcr=getDataDetail($Conn,'nakes_terinfeksi','id_nakes_terinfeksi',$id_nakes_terinfeksi,'id_nakes_pcr');
        $nama=getDataDetail($Conn,'nakes_terinfeksi','id_nakes_terinfeksi',$id_nakes_terinfeksi,'nama');
        $tanggal=getDataDetail($Conn,'nakes_terinfeksi','id_nakes_terinfeksi',$id_nakes_terinfeksi,'tanggal');
        $kategori=getDataDetail($Conn,'nakes_terinfeksi','id_nakes_terinfeksi',$id_nakes_terinfeksi,'kategori');
        $status=getDataDetail($Conn,'nakes_terinfeksi','id_nakes_terinfeksi',$id_nakes_terinfeksi,'status');
        $id_akses=getDataDetail($Conn,'nakes_terinfeksi','id_nakes_terinfeksi',$id_nakes_terinfeksi,'id_akses');
        $NamaPetugas=getDataDetail($Conn,'akses','id_akses',$id_akses,'nama');
        //Buat Format Tanggal
        $strtotime=strtotime($tanggal);
        $TanggalFormat=date('d/m/Y',$strtotime)
?>
    <div class="row mb-3">
        <div class="col-md-6"> <dt>ID Nakes Terinfeksi</dt> </div>
        <div class="col-md-6"><?php echo "$id_nakes_terinfeksi"; ?></div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6"><dt>Tanggal</dt></div>
        <div class="col-md-6"><?php echo "$TanggalFormat"; ?></div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6"><dt>Nama Nakes</dt> </div>
        <div class="col-md-6"><?php echo "$nama"; ?></div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6"><dt>Kategori Nakes</dt> </div>
        <div class="col-md-6"><?php echo "$kategori"; ?></div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6"><dt>Status</dt> </div>
        <div class="col-md-6"><?php echo "$status"; ?></div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6"><dt>Petugas Entry</dt> </div>
        <div class="col-md-6"><?php echo "$NamaPetugas"; ?></div>
    </div>
<?php } ?>