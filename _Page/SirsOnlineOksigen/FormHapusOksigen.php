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
?>
    <input type="hidden" name="id_sirs_online_task" value="<?php echo $id_sirs_online_task;?>">
    <div class="row mb-3">
        <div class="col-md-12">
            <dt>Apakah anda yakin akan menghapus laporan pada tanggal <?php echo $tanggal;?> Tersebut?</dt>
        </div>
    </div>
<?php } ?>