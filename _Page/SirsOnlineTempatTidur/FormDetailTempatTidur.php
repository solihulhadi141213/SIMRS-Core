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
    if(empty($_POST['id_tt'])){
        echo '<div class="row">';
        echo '  <div class="col-xl-12 col-md-12 text-danger text-center">';
        echo '      ID Tempat Tidur Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_tt=$_POST['id_tt'];
        //Buka detail pengaturan
        $response_referensi=DataTtSirsOnline($x_id_rs,$password_sirs_online,$url_sirs_online,'GET');
        if(empty($response_referensi)){
            echo '<div class="row">';
            echo '  <div class="col-xl-12 col-md-12 text-danger text-center">';
            echo '      Tidak ada response dari SIRS Online <br>Keterangan: '.$response_referensi.'';
            echo '  </div>';
            echo '</div>';
        }else{
            $php_array = json_decode($response_referensi, true);
            $ReferensiTt=$php_array['fasyankes'];
            $JumlahData=count($ReferensiTt);
            if(empty($JumlahData)){
                echo '<div class="row">';
                echo '  <div class="col-xl-12 col-md-12 text-danger text-center">';
                echo '      Tidak ada yang ditampilkan dari SIRS Online <br>Keterangan: '.$response_referensi.'';
                echo '  </div>';
                echo '</div>';
            }else{
                foreach ($ReferensiTt as $item) {
                    // Tambahkan setiap elemen ke dalam array PHP
                    $IdTtList= $item['id_tt'];
                    if($IdTtList==$id_tt){
                        if(empty($item['tglupdate'])){
                            echo '<div class="row">';
                            echo '  <div class="col-xl-12 col-md-12 text-danger text-center">';
                            echo '      ID Tempat Tidur Yang Anda Pilih Bleum Terdaftar. Silahkan tambahkan terlebih dulu!';
                            echo '  </div>';
                            echo '</div>';
                        }else{
                            $tt= $item['tt'];
                            $ruang= $item['ruang'];
                            $kode_siranap= $item['kode_siranap'];
                            $jumlah_ruang= $item['jumlah_ruang'];
                            $jumlah= $item['jumlah'];
                            $terpakai= $item['terpakai'];
                            $terpakai_suspek= $item['terpakai_suspek'];
                            $terpakai_konfirmasi= $item['terpakai_konfirmasi'];
                            $antrian= $item['antrian'];
                            $prepare= $item['prepare'];
                            $prepare_plan= $item['prepare_plan'];
                            $kosong= $item['kosong'];
                            $covid= $item['covid'];
                            $id_t_tt= $item['id_t_tt'];
                            $tglupdate= $item['tglupdate'];
                            if(!empty($ruang)){
                                $DataRuang = explode("," , $ruang);
                                $JumlahRuang=count($DataRuang);
                            }else{
                                $DataRuang ="";
                                $JumlahRuang=0;
                            }
                            if(!empty($tglupdate)){
                                $strtotime=strtotime($tglupdate);
                                $LabelTglUpdate=date('d/m/Y H:i:s',$strtotime);
                            }else{
                                $strtotime="";
                                $LabelTglUpdate='<span class="text-danger">Tidak Ada</span>';
                            }
                            //Cari Kelas dari SIMRS yang sudah di sinkronisasikan
                            $id_ruang_rawat_sirs=getDataDetail($Conn,'ruang_rawat_sirs','id_tt',$id_tt,'id_ruang_rawat_sirs');
                            $id_ruang_rawat=getDataDetail($Conn,'ruang_rawat_sirs','id_tt',$id_tt,'id_ruang_rawat');
                            //Buka Nama kelas
                            
                            if(!empty($id_ruang_rawat)){
                                $Namakelas=getDataDetail($Conn,'ruang_rawat','id_ruang_rawat',$id_ruang_rawat,'kelas');
                            }else{
                                $Namakelas='<span class="text-danger">Tidak ADa</span>';
                            }
?>
    <div class="row mb-3 sub-title">
        <div class="col-md-4">
            <dt>ID TT</dt>
        </div>
        <div class="col-md-8">
            <?php echo $IdTtList; ?>
        </div>
    </div>
    <div class="row mb-3 sub-title">
        <div class="col-md-4">
            <dt>ID Record</dt>
        </div>
        <div class="col-md-8">
            <?php echo $id_t_tt; ?>
        </div>
    </div>
    <div class="row mb-3 sub-title">
        <div class="col-md-4">
            <dt>Nama TT</dt>
        </div>
        <div class="col-md-8">
            <?php echo $tt; ?>
        </div>
    </div>
    <div class="row mb-3 sub-title">
        <div class="col-md-4">
            <dt>Ruangan</dt>
        </div>
        <div class="col-md-8">
            <?php
                echo $ruang; 
            ?>
        </div>
    </div>
    <div class="row mb-3 sub-title">
        <div class="col-md-4">
            <dt>Kode Siranap</dt>
        </div>
        <div class="col-md-8">
            <?php echo $kode_siranap; ?>
        </div>
    </div>
    <div class="row mb-3 sub-title">
        <div class="col-md-4">
            <dt>Jumlah Ruangan</dt>
        </div>
        <div class="col-md-8">
            <?php echo $jumlah_ruang; ?>
        </div>
    </div>
    <div class="row mb-3 sub-title">
        <div class="col-md-4">
            <dt>Jumlah TT</dt>
        </div>
        <div class="col-md-8">
            <?php echo $jumlah; ?>
        </div>
    </div>
    <div class="row mb-3 sub-title">
        <div class="col-md-4">
            <dt>Jumlah Terpakai</dt>
        </div>
        <div class="col-md-8">
            <?php echo $terpakai; ?>
        </div>
    </div>
    <div class="row mb-3 sub-title">
        <div class="col-md-4">
            <dt>Terpakai Suspek</dt>
        </div>
        <div class="col-md-8">
            <?php echo $terpakai_suspek; ?>
        </div>
    </div>
    <div class="row mb-3 sub-title">
        <div class="col-md-4">
            <dt>Terpakai Konfirmasi</dt>
        </div>
        <div class="col-md-8">
            <?php echo $terpakai_konfirmasi; ?>
        </div>
    </div>
    <div class="row mb-3 sub-title">
        <div class="col-md-4">
            <dt>Antrian</dt>
        </div>
        <div class="col-md-8">
            <?php echo $antrian; ?>
        </div>
    </div>
    <div class="row mb-3 sub-title">
        <div class="col-md-4">
            <dt>Dipersiapkan</dt>
        </div>
        <div class="col-md-8">
            <?php echo $prepare; ?>
        </div>
    </div>
    <div class="row mb-3 sub-title">
        <div class="col-md-4">
            <dt>Rencana Dipersiapkan</dt>
        </div>
        <div class="col-md-8">
            <?php echo $prepare_plan; ?>
        </div>
    </div>
    <div class="row mb-3 sub-title">
        <div class="col-md-4">
            <dt>Kosong</dt>
        </div>
        <div class="col-md-8">
            <?php echo $kosong; ?>
        </div>
    </div>
    <div class="row mb-3 sub-title">
        <div class="col-md-4">
            <dt>Covid</dt>
        </div>
        <div class="col-md-8">
            <?php echo $covid; ?>
        </div>
    </div>
    <div class="row mb-3 sub-title">
        <div class="col-md-4">
            <dt>Update</dt>
        </div>
        <div class="col-md-8">
            <?php echo $tglupdate; ?>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12 text-center">
            <?php
                if(!empty($tglupdate)){
                    echo 'Anda bisa menghapus data tempat tidur ini dengan memilih tombol berikut<br>';
                    echo '<button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#ModalHapusTempatTidur" data-id="'.$id_tt.'">';
                    echo '  <i class="ti ti-close"></i> Hapus Tempat Tidur';
                    echo '</button>';
                }
            ?>
        </div>
    </div>
<?php }}}}}} ?>