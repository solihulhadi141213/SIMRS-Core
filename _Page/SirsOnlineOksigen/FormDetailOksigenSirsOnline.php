<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/FungsiSirsOnline.php";
    //Buka Pengaturan SIRS Online
    $x_id_rs=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','id_rs');
    $url_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','url_sirs_online');
    $password_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','password_sirs_online');
    if(empty($_POST['tanggal'])){
        echo '<div class="row">';
        echo '  <div class="col-xl-12 col-md-12 text-danger text-center">';
        echo '      Tanggal Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        $tanggal=$_POST['tanggal'];
        $response_sisrs_online=DataOksigenSirsOnline($x_id_rs,$password_sirs_online,$url_sirs_online,$tanggal);
        if(empty($response_sisrs_online)){
            echo '<div class="row">';
            echo '  <div class="col-xl-12 col-md-12 text-danger text-center">';
            echo '      Tidak ada response dari service SIRS Online!';
            echo '  </div>';
            echo '</div>';
        }else{
            $php_array = json_decode($response_sisrs_online, true);
            $DataAntrianSirsOnline=$php_array['Oksigenasi'];
            foreach ($DataAntrianSirsOnline as $item) {
                $tanggal=$item['tanggal'];
                $p_cair=$item['p_cair'];
                $p_tabung_kecil=$item['p_tabung_kecil'];
                $p_tabung_sedang=$item['p_tabung_sedang'];
                $p_tabung_besar=$item['p_tabung_besar'];
                $k_isi_cair=$item['k_isi_cair'];
                $k_isi_tabung_kecil=$item['k_isi_tabung_kecil'];
                $k_isi_tabung_sedang=$item['k_isi_tabung_sedang'];
                $k_isi_tabung_besar=$item['k_isi_tabung_besar'];
                $tgllapor=$item['tgllapor'];
                $strtotime1=strtotime($tanggal);
                $strtotime2=strtotime($tgllapor);
                $Tanggal=date('d/m/Y',$strtotime1);
                $Updatetime=date('d/m/Y H:i:s',$strtotime2);
?>
    <div class="row mb-3">
        <div class="col-md-6"><dt>Tanggal Laporan</dt></div>
        <div class="col-md-6"><?php echo "$Tanggal"; ?></div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6"><dt>Update Time</dt></div>
        <div class="col-md-6"><?php echo "$Updatetime"; ?></div>
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
<?php }}} ?>