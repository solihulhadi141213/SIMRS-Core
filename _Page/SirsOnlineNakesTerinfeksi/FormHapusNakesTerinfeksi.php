<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/FungsiSirsOnline.php";
    if(empty($_POST['id_nakes_terinfeksi'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center text-danger">';
        echo '      ID Nakes Terinfeksi Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_nakes_terinfeksi=$_POST['id_nakes_terinfeksi'];
?>
    <input type="hidden" name="id_nakes_terinfeksi" id="id_nakes_terinfeksi" class="form-control" value="<?php echo $id_nakes_terinfeksi; ?>">
    <div class="row mb-3">
        <div class="col-md-12 text-enter">
            Apakah anda yakin akan menghapus data nakes terinfeksi ini?
        </div>
    </div>
<?php } ?>