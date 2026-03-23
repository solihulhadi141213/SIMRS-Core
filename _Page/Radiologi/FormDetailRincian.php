<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap id_rincian
    if(empty($_POST['id_rincian'])){
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-center mb-3">';
        echo '         ID Rincian Pemeriksaan Radiologi Tidak Boleh Kosong!.';
        echo '      </div>';
        echo '  </div>';
    }else{
        $id_rincian=$_POST['id_rincian'];
        if(empty(getDataDetail($Conn,'radiologi_rincian','id_rincian',$id_rincian,'id_rincian'))){
            echo '  <div class="row">';
            echo '      <div class="col-md-12 text-center mb-3">';
            echo '         ID Rincian Pemeriksaan Tidak Valid.';
            echo '      </div>';
            echo '  </div>';
        }else{
            $kategori=getDataDetail($Conn,'radiologi_rincian','id_rincian',$id_rincian,'kategori');
            $pemeriksaan=getDataDetail($Conn,'radiologi_rincian','id_rincian',$id_rincian,'pemeriksaan');
            $hasil=getDataDetail($Conn,'radiologi_rincian','id_rincian',$id_rincian,'hasil');
            $keterangan=getDataDetail($Conn,'radiologi_rincian','id_rincian',$id_rincian,'keterangan');
?>
    <div class="row">
        <div class="col-md-12 mb-4">
            <dt>KATEGORI</dt>
            <?php echo "$kategori"; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-4">
            <dt>PEMERIKSAAN</dt>
            <?php echo "$pemeriksaan"; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-4">
            <dt>HASIL</dt>
            <?php echo "$hasil"; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-4">
            <dt>KETERANGAN</dt>
            <?php echo "$keterangan"; ?>
        </div>
    </div>
<?php }} ?>