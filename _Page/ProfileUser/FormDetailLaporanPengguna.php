<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap id_laporan_pengguna
    if(empty($_POST['id_laporan_pengguna'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center mb-3">';
        echo '      ID Laporan Pengguna Tidak Boleh Kosong!.';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_laporan_pengguna=$_POST['id_laporan_pengguna'];
        $nama=getDataDetail($Conn,'laporan_pengguna','id_laporan_pengguna',$id_laporan_pengguna,'nama');
        $tanggal=getDataDetail($Conn,'laporan_pengguna','id_laporan_pengguna',$id_laporan_pengguna,'tanggal');
        $judul=getDataDetail($Conn,'laporan_pengguna','id_laporan_pengguna',$id_laporan_pengguna,'judul');
        $laporan=getDataDetail($Conn,'laporan_pengguna','id_laporan_pengguna',$id_laporan_pengguna,'laporan');
        $response=getDataDetail($Conn,'laporan_pengguna','id_laporan_pengguna',$id_laporan_pengguna,'response');
        if(empty($response)){
            $Response='<span class="text-danger">Belum Ada Response</span>';
        }else{
            $Response='<span class="text-success">'.$response.'</span>';
        }
?>
    <div class="row mb-2">
        <div class="col-md-12">
            <dt>Nama User</dt>
            <small><?php echo "$nama"; ?></small>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-12">
            <dt>Tanggal Laporan</dt>
            <small><?php echo "$tanggal"; ?></small>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-12">
            <dt>Judul Laporan</dt>
            <small><?php echo "$judul"; ?></small>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-12">
            <dt>Laporan</dt>
            <small><?php echo "$laporan"; ?></small>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-12">
            <dt>Response</dt>
            <small><?php echo "$Response"; ?></small>
        </div>
    </div>
<?php } ?>