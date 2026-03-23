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
    if(empty($_POST['id_kebutuhan'])){
        echo '<div class="row">';
        echo '  <div class="col-xl-12 col-md-12 text-danger text-center">';
        echo '      ID Kebutuhan Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_kebutuhan=$_POST['id_kebutuhan'];
        $DataAlkes=DataAlkesSirsOnline($x_id_rs,$password_sirs_online,$url_sirs_online,'GET');
        if(empty($DataAlkes)){
            echo '<div class="row">';
            echo '  <div class="col-xl-12 col-md-12 text-danger text-center">';
            echo '      Tidak ada response dari service SIRS Online!';
            echo '  </div>';
            echo '</div>';
        }else{
            $php_array = json_decode($DataAlkes, true);
            $ListAlkes=$php_array['apd'];
            $JumlahData=count($ListAlkes);
            if(empty($JumlahData)){
                echo '<div class="row">';
                echo '  <div class="col-xl-12 col-md-12 text-danger text-center">';
                echo '      Tidak ada data alkes dari service SIRS Online!';
                echo '  </div>';
                echo '</div>';
                echo '<div class="row">';
                echo '  <div class="col-xl-12 col-md-12 text-danger text-center">';
                echo '      '.$DataAlkes.'';
                echo '  </div>';
                echo '</div>';
            }else{
                foreach ($ListAlkes as $item) {
                    // Tambahkan setiap elemen ke dalam array PHP
                    $IdKebutuhanList= $item['id_kebutuhan'];
                    if($id_kebutuhan==$item['id_kebutuhan']){
                        $jumlah_diterima= $item['jumlah_diterima'];
                        if(empty($item['kebutuhan'])){
                            $kebutuhan='<span class="text-danger">None</span>';
                        }else{
                            $kebutuhan= $item['kebutuhan'];
                        }
                        if(empty($item['jumlah_eksisting'])){
                            $jumlah_eksisting='<span class="text-danger">None</span>';
                        }else{
                            $jumlah_eksisting= $item['jumlah_eksisting'];
                        }
                        if(empty($item['jumlah'])){
                            $jumlah='<span class="text-danger">None</span>';
                        }else{
                            $jumlah= $item['jumlah'];
                        }
                        if(empty($item['jumlah_diterima'])){
                            $jumlah_diterima='<span class="text-danger">None</span>';
                        }else{
                            $jumlah_diterima= $item['jumlah_diterima'];
                        }
                        //Format Tanggal
                        $tglupdate= $item['tglupdate'];
                        $strtotime=strtotime($tglupdate);
                        $tglupdate=date('d/m/Y',$strtotime);
                        $sekarang=date('d/m/Y');
?>
    <div class="row mb-3">
        <div class="col-md-6"><dt>ID Kebutuhan</dt></div>
        <div class="col-md-6"><?php echo "$IdKebutuhanList"; ?></div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6"><dt>Kebutuhan</dt></div>
        <div class="col-md-6"><?php echo "$kebutuhan"; ?></div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6"><dt>Jumlah</dt></div>
        <div class="col-md-6"><?php echo "$jumlah"; ?></div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6"><dt>Jumlah Eksisting</dt></div>
        <div class="col-md-6"><?php echo "$jumlah_eksisting"; ?></div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6"><dt>Jumlah Diterima</dt></div>
        <div class="col-md-6"><?php echo "$jumlah_diterima"; ?></div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6"><dt>Update</dt></div>
        <div class="col-md-6"><?php echo "$tglupdate"; ?></div>
    </div>
    <?php if(!empty($item['tglupdate'])){ ?>
        <div class="row mb-3">
            <div class="col-md-12 text-center">
                <p>
                    Anda bisa menghapus data ini dengan memilih tombol berikut
                </p>
                <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#ModalHapusAlkes" data-id="<?php echo "$id_kebutuhan"; ?>">
                    <i class="ti ti-trash"></i> Hapus Alkes
                </button>
            </div>
        </div>
    <?php } ?>
<?php
                        }
                    }
                }
            }
        }
?>