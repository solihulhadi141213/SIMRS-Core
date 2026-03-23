<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap id_laporan_pengguna
    if(empty($_POST['id_laporan_pengguna'])){
        echo '<span class="text-danger text-center">';
        echo '  ID Laporan Pengguna Tidak Boleh Kosong!.';
        echo '</span>';
    }else{
        $id_laporan_pengguna=$_POST['id_laporan_pengguna'];
        $id_akses=getDataDetail($Conn,'laporan_pengguna','id_laporan_pengguna',$id_laporan_pengguna,'id_akses');
        $nama=getDataDetail($Conn,'laporan_pengguna','id_laporan_pengguna',$id_laporan_pengguna,'nama');
        $tanggal=getDataDetail($Conn,'laporan_pengguna','id_laporan_pengguna',$id_laporan_pengguna,'tanggal');
        $judul=getDataDetail($Conn,'laporan_pengguna','id_laporan_pengguna',$id_laporan_pengguna,'judul');
        $laporan=getDataDetail($Conn,'laporan_pengguna','id_laporan_pengguna',$id_laporan_pengguna,'laporan');
        $response=getDataDetail($Conn,'laporan_pengguna','id_laporan_pengguna',$id_laporan_pengguna,'response');
        $Tanggal=strtotime($tanggal);
        $Tanggal=date('d/m/Y H:i T',$Tanggal);
        if(empty($response)){
            $status='<code class="text-danger">Belum Ada Response</code>';
        }else{
            $status='<code class="text-success">Sudah Di Response</code>';
        }
        echo '<div class="row mb-3">';
        echo '  <div class="col col-md-4">ID Pengirim</div>';
        echo '  <div class="col col-md-8"><code class="text-secondary">'.$id_akses.'</code></div>';
        echo '</div>';
        echo '<div class="row mb-3">';
        echo '  <div class="col col-md-4">Nama Pengirim</div>';
        echo '  <div class="col col-md-8"><code class="text-secondary">'.$nama.'</code></div>';
        echo '</div>';
        echo '<div class="row mb-3">';
        echo '  <div class="col col-md-4">Tanggal</div>';
        echo '  <div class="col col-md-8"><code class="text-secondary">'.$Tanggal.'</code></div>';
        echo '</div>';
        echo '<div class="row mb-3">';
        echo '  <div class="col col-md-4">Judul</div>';
        echo '  <div class="col col-md-8"><code class="text-secondary">'.$judul.'</code></div>';
        echo '</div>';
        echo '<div class="row mb-3">';
        echo '  <div class="col col-md-4">Laporan</div>';
        echo '  <div class="col col-md-8"><code class="text-secondary">'.$laporan.'</code></div>';
        echo '</div>';
        echo '<div class="row mb-3">';
        echo '  <div class="col col-md-4">Response</div>';
        echo '  <div class="col col-md-8"><code class="text-secondary">'.$response.'</code></div>';
        echo '</div>';
        echo '<div class="row mb-3">';
        echo '  <div class="col col-md-4">Status</div>';
        echo '  <div class="col col-md-8">'.$status.'</div>';
        echo '</div>';
?>
    
<?php } ?>