<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/FungsiSirsOnline.php";
    if(empty($_POST['id_nakes'])){
        echo '<div class="row">';
        echo '  <div class="col-xl-12 col-md-12 text-danger text-center">';
        echo '      ID Nakes Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_nakes=$_POST['id_nakes'];
        $ihs=getDataDetail($Conn,'nakes','id_nakes',$id_nakes,'ihs');
        $nik=getDataDetail($Conn,'nakes','id_nakes',$id_nakes,'nik');
        $kode=getDataDetail($Conn,'nakes','id_nakes',$id_nakes,'kode');
        $nama=getDataDetail($Conn,'nakes','id_nakes',$id_nakes,'nama');
        $kategori=getDataDetail($Conn,'nakes','id_nakes',$id_nakes,'kategori');
        $referensi_sdm=getDataDetail($Conn,'nakes','id_nakes',$id_nakes,'referensi_sdm');
        $id_akses=getDataDetail($Conn,'nakes','id_nakes',$id_nakes,'id_akses');
        //Detail Petugas
        $NamaPetugas=getDataDetail($Conn,'akses','id_akses',$id_akses,'nama');

        if(empty($ihs)){
            $ihs='<span class="text-danger">Tidak Ada</span>';
        }else{
            $ihs='<span class="text-info">'.$ihs.'</span>';
        }
        if(empty($nik)){
            $nik='<span class="text-danger">Tidak Ada</span>';
        }else{
            $nik='<span class="text-info">'.$nik.'</span>';
        }
        if(empty($kode)){
            $kode='<span class="text-danger">Tidak Ada</span>';
        }else{
            $kode='<span class="text-info">'.$kode.'</span>';
        }
?>
    <div class="row mb-3">
        <div class="col-md-6">ID Nakes</div>
        <div class="col-md-6"><small><?php echo "$id_nakes"; ?></small></div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">ID IHS</div>
        <div class="col-md-6"><small><?php echo "$ihs"; ?></small></div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">NIK</div>
        <div class="col-md-6"><small><?php echo "$nik"; ?></small></div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">Kode</div>
        <div class="col-md-6"><small><?php echo "$kode"; ?></small></div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">Nama</div>
        <div class="col-md-6"><small><?php echo "$nama"; ?></small></div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">Kategori</div>
        <div class="col-md-6"><small><?php echo "$kategori"; ?></small></div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">Referensi SDM</div>
        <div class="col-md-6"><small><?php echo "$referensi_sdm"; ?></small></div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">Petugas</div>
        <div class="col-md-6"><small><?php echo "$NamaPetugas"; ?></small></div>
    </div>
<?php } ?>