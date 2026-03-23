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
    <input type="hidden" name="id_sirs_online_task" value="<?php echo $id_sirs_online_task; ?>">
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="tanggal">Tanggal Laporan</label>
        </div>
        <div class="col-md-8">
            <input type="date" readonly name="tanggal" id="tanggal" class="form-control" value="<?php echo $tanggal; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="satuan">Satuan</label>
        </div>
        <div class="col-md-8">
            <input type="text" readonly name="satuan" id="satuan" class="form-control" value="M3">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <dt>1. Data Pemakaian</dt>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="p_cair">Oksigen Cair</label>
        </div>
        <div class="col-md-8">
            <input type="text" name="p_cair" id="p_cair" class="form-control" value="<?php echo $p_cair; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="p_tabung_kecil">Tabung Kecil</label>
        </div>
        <div class="col-md-8">
            <input type="text" name="p_tabung_kecil" id="p_tabung_kecil" class="form-control" value="<?php echo $p_tabung_kecil; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="p_tabung_sedang">Tabung Sedang</label>
        </div>
        <div class="col-md-8">
            <input type="text" name="p_tabung_sedang" id="p_tabung_sedang" class="form-control" value="<?php echo $p_tabung_sedang; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="p_tabung_besar">Tabung Besar</label>
        </div>
        <div class="col-md-8">
            <input type="text" name="p_tabung_besar" id="p_tabung_besar" class="form-control" value="<?php echo $p_tabung_besar; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <dt>2. Data Ketersediaan</dt>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="k_isi_cair">Oksigen Cair</label>
        </div>
        <div class="col-md-8">
            <input type="text" name="k_isi_cair" id="k_isi_cair" class="form-control" value="<?php echo $k_isi_cair; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="k_isi_tabung_kecil">Tabung Kecil</label>
        </div>
        <div class="col-md-8">
            <input type="text" name="k_isi_tabung_kecil" id="k_isi_tabung_kecil" class="form-control" value="<?php echo $k_isi_tabung_kecil; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="k_isi_tabung_sedang">Tabung Sedang</label>
        </div>
        <div class="col-md-8">
            <input type="text" name="k_isi_tabung_sedang" id="k_isi_tabung_sedang" class="form-control" value="<?php echo $k_isi_tabung_sedang; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="k_isi_tabung_besar">Tabung Besar</label>
        </div>
        <div class="col-md-8">
            <input type="text" name="k_isi_tabung_besar" id="k_isi_tabung_besar" class="form-control" value="<?php echo $k_isi_tabung_besar; ?>">
        </div>
    </div>
<?php } ?>