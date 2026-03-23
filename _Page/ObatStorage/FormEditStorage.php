<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    if(empty($_POST['id_obat_storage'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 mb-4 text-center">';
        echo '      <span class="text-danger">ID Tempat Penyimpanan Tidak Bisa Ditangkap Oleh Sistem</span>';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_obat_storage=$_POST['id_obat_storage'];
        //Buka data Pengimpanan Obat
        $QryStorage = mysqli_query($Conn,"SELECT * FROM obat_storage WHERE id_obat_storage='$id_obat_storage'")or die(mysqli_error($Conn));
        $DataStorage = mysqli_fetch_array($QryStorage);
        $nama_obat_storage= $DataStorage['nama_penyimpanan'];
        $deskripsi_tempat= $DataStorage['deskripsi_tempat'];
        echo '<input type="hidden" id="id_obat_storage" name="id_obat_storage" value="'.$id_obat_storage.'">';
?>
    <div class="row">
        <div class="col-md-12 mb-4">
            <label for="nama_obat_storage">Nama Tempat Penyimpanan</label>
            <input type="text" name="nama_obat_storage" id="nama_obat_storage" class="form-control" value="<?php echo $nama_obat_storage;?>">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-4">
            <label for="deskripsi_tempat">Keterngan/Deskripsi</label>
            <textarea name="deskripsi_tempat" id="deskripsi_tempat" cols="30" rows="4" class="form-control"><?php echo $deskripsi_tempat;?></textarea>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-4" id="NotifikasiEditStorage">
            <span class="text-primary">Silahkan Isi Informasi Tempat Penyimpanan Dengan Lengkap</span>
        </div>
    </div>
<?php } ?>