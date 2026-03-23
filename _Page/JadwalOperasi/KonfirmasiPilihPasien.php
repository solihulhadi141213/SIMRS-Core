<?php
    //koneksi
    include "../../_Config/Connection.php";
    //Session
    include "../../_Config/Session.php";
    //Tangkap id_pasien
    if(empty($_POST['id_pasien'])){
        echo '<div class="card-body border-0 pb-0">';
        echo '  <div class="row">';
        echo '      <div class="col-md-6 mb-3">';
        echo '          Data ID Pasien Tidak Dapat didefinisikan.';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_pasien=$_POST['id_pasien'];
        //Buka data pasien berdasarkan id_pasien
        $data_pasien = mysqli_query($Conn,"SELECT * FROM pasien WHERE id_pasien='$id_pasien'");
        $data_pasien_array = mysqli_fetch_array($data_pasien);
        $nama=$data_pasien_array['nama'];
        $no_bpjs=$data_pasien_array['no_bpjs'];
?>
<div class="modal-body">   
    <div class="row">
        <div class="col col-md-12 text-center">
            <div class="alert alert-danger" role="alert">
                <input type="hidden" name="GetNamaPasien" id="GetNamaPasien" value="<?php echo "$nama"; ?>">
                <input type="hidden" name="GetNoKartu" id="GetNoKartu" value="<?php echo "$no_bpjs"; ?>">
                    Anda yakin ingin membuat jadwal operasi untuk pasien ini?
            </div>
        </div>
    </div>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col col-md col-12 text-center">
            <button type="button" class="btn btn-sm btn-primary mt-2 mr-2 btn-round" id="KonfimasiPilihPasienIni">
                <i class="ti ti-check"></i> Ya
            </button>
            <button type="button" class="btn btn-sm btn-danger mt-2 mr-2 btn-round" data-dismiss="modal">
                <i class="fa fa-times"></i> Tutup
            </button>
        </div>
    </div>
</div>
<?php } ?>