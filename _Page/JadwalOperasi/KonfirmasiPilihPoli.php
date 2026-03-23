<?php
    //koneksi
    include "../../_Config/Connection.php";
    //Session
    include "../../_Config/Session.php";
    //Tangkap id_pasien
    if(empty($_POST['id_poliklinik'])){
        echo '<div class="card-body border-0 pb-0">';
        echo '  <div class="row">';
        echo '      <div class="col-md-6 mb-3">';
        echo '          Data ID Poliklinik Tidak Dapat didefinisikan.';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_poliklinik=$_POST['id_poliklinik'];
        //Buka data pasien berdasarkan id_pasien
        $QryPoli = mysqli_query($Conn,"SELECT * FROM poliklinik WHERE id_poliklinik='$id_poliklinik'");
        $DataPoli = mysqli_fetch_array($QryPoli);
        $nama=$DataPoli['nama'];
        $kode=$DataPoli['kode'];
?>
<div class="modal-body">   
    <div class="row">
        <div class="col col-md-12 text-center">
            <div class="alert alert-danger" role="alert">
                <input type="hidden" name="GetKodePoli" id="GetKodePoli" value="<?php echo "$kode"; ?>">
                <input type="hidden" name="GetNamaPoli" id="GetNamaPoli" value="<?php echo "$nama"; ?>">
                    Anda yakin ingin membuat jadwal operasi untuk poliklinik ini?
            </div>
        </div>
    </div>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col col-md col-12 text-center">
            <button type="button" class="btn btn-sm btn-primary mt-2 mr-2 btn-round" id="KonfimasiPilihPoliini">
                <i class="ti ti-check"></i> Ya
            </button>
            <button type="button" class="btn btn-sm btn-danger mt-2 mr-2 btn-round" data-dismiss="modal">
                <i class="fa fa-times"></i> Tutup
            </button>
        </div>
    </div>
</div>
<?php } ?>