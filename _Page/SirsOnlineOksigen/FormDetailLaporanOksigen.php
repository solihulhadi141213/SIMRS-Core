<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/FungsiSirsOnline.php";
    if(empty($_POST['id_sirs_online_task'])){
        echo '<div class="row">';
        echo '  <div class="col-xl-12 col-md-12 text-danger text-center">';
        echo '      ID Task Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_sirs_online_task=$_POST['id_sirs_online_task'];
        $tanggal=getDataDetail($Conn,'sirs_online_task','id_sirs_online_task',$id_sirs_online_task,'tanggal');
        $updatetime=getDataDetail($Conn,'sirs_online_task','id_sirs_online_task',$id_sirs_online_task,'updatetime');
        $keterangan=getDataDetail($Conn,'sirs_online_task','id_sirs_online_task',$id_sirs_online_task,'keterangan');
        $id_akses=getDataDetail($Conn,'sirs_online_task','id_sirs_online_task',$id_sirs_online_task,'id_akses');
        //Format Tanggal
        $strtotime1=strtotime($tanggal);
        $Tanggal=date('d/m/Y',$strtotime1);
        $Updatetime=date('d/m/Y H:i:s',$updatetime);
        //Detail Petugas
        $NamaPetugas=getDataDetail($Conn,'akses','id_akses',$id_akses,'nama');
        //Buka Data Json
        $php_array = json_decode($keterangan, true);
        $p_cair=$php_array['p_cair'];
        $p_tabung_kecil=$php_array['p_tabung_kecil'];
        $p_tabung_sedang=$php_array['p_tabung_sedang'];
        $p_tabung_besar=$php_array['p_tabung_besar'];
        $k_isi_cair=$php_array['k_isi_cair'];
        $k_isi_tabung_kecil=$php_array['k_isi_tabung_kecil'];
        $k_isi_tabung_sedang=$php_array['k_isi_tabung_sedang'];
        $k_isi_tabung_besar=$php_array['k_isi_tabung_besar'];
?>
    <div class="row mb-3">
        <div class="col-md-6"><dt>ID Laporan</dt></div>
        <div class="col-md-6"><?php echo "$id_sirs_online_task"; ?></div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6"><dt>Tanggal Laporan</dt></div>
        <div class="col-md-6"><?php echo "$Tanggal"; ?></div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6"><dt>Update Time</dt></div>
        <div class="col-md-6"><?php echo "$Updatetime"; ?></div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6"><dt>Petugas</dt></div>
        <div class="col-md-6"><?php echo "$NamaPetugas"; ?></div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12"><dt>1. Data Penggunaan</dt></div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <ol>
                <li>Oksigen Cair : <?php echo $p_cair;?> M3</li>
                <li>Tabung Kecil : <?php echo $p_tabung_kecil;?> M3</li>
                <li>Tabung Sedang : <?php echo $p_tabung_sedang;?> M3</li>
                <li>Tabung Besar : <?php echo $p_tabung_besar;?> M3</li>
            </ol>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12"><dt>2. Data Ketersediaan</dt></div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <ol>
                <li>Oksigen Cair : <?php echo $k_isi_cair;?> M3</li>
                <li>Tabung Kecil : <?php echo $k_isi_tabung_kecil;?> M3</li>
                <li>Tabung Sedang : <?php echo $k_isi_tabung_sedang;?> M3</li>
                <li>Tabung Besar : <?php echo $k_isi_tabung_besar;?> M3</li>
            </ol>
        </div>
    </div>
<?php } ?>