<?php
    date_default_timezone_set('Asia/Jakarta');
    //Koneksi ke database
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/FungsiSirsOnline.php";
    if(empty($_POST['id_pasien_shk'])){
        echo '  <div class="row">';
        echo '      <div class="col-md-12 mb-3 text-center text-danger">';
        echo '          ID Pasien SHK Tidak Boleh Kosong';
        echo '      </div>';
        echo '  </div>';
    }else{
        $id_pasien_shk=$_POST['id_pasien_shk'];
?>
        <input type="hidden" name="id_pasien_shk" value="<?php echo "$id_pasien_shk"; ?>">
        <div class="row mb-3"> 
            <div class="col col-md-12">
                Untuk melakukan perubahan pada informasi pasien SHK ini, anda akan diarahkan pada halaman terpisah.
                <dt>Apakah anda yakin akan melakukan perubahan pada ID SHK <?php echo "$id_pasien_shk"; ?> ini?</dt>
            </div>
        </div>
<?php } ?>