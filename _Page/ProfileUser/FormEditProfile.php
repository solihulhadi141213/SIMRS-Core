<?php
    //Inclde Koneksi dan akses 
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    if(empty($SessionIdAkses)){
        echo '<div class="card-body border-0 pb-0">';
        echo '  <div class="row">';
        echo '      <div class="col-md-6 mb-3">';
        echo '          Sesi Akses Sudah Berakhir. Silahkan Login Ulang!';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
?>
<div class="row"> 
    <div class="col-md-12 mb-3">
        <label for="nama"><small>Nama Lengkap</small></label>
        <input type="text" class="form-control" id="nama" name="nama" value="<?php echo "$SessionNama"; ?>" required>
    </div>
</div>
<div class="row"> 
    <div class="col-md-12 mb-3">
        <label for="email"><small>Email</small></label>
        <input type="email" class="form-control" id="email" name="email" value="<?php echo "$SessionEmail"; ?>" required>
    </div>
</div>
<div class="row"> 
    <div class="col-md-12 mb-3">
        <label for="kontak"><small>No.Kontak</small></label>
        <input type="text" class="form-control" id="kontak" name="kontak" value="<?php echo "$SessionKontak"; ?>" required>
    </div>
</div>
<?php } ?>