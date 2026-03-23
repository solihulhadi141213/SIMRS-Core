<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    //Tangkap id_pasien
    if(empty($_POST['id_pasien'])){
        echo '<div class="card-body border-0 pb-0">';
        echo '  <div class="row">';
        echo '      <div class="col-md-6 mb-3">';
        echo '          Data ID Akses Tidak Dapat didefinisikan.';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_pasien=$_POST['id_pasien'];
?>
    <div class="modal-body border-0 pb-0 mb-4">
        <div class="row mt-2 mb-2"> 
            <div class="col-md-12 text-center">
                <img src="assets/images/question.gif" alt="" width="70%">
            </div>
        </div>
        <div class="row mt-2 mb-2"> 
            <div class="col-md-12 text-center text-danger">
                <span id="NotifikasiHapusPasien">
                    Apakah anda yakin akan mendaftarkan rajal untuk pasien ini?
                </span>
            </div>
        </div>
    </div>
    <div class="modal-footer bg-inverse">
        <div class="row">
            <div class="col-md-12 mb-3">
                <a href="index.php?Page=RawatJalan&Sub=TambahKunjungan&id=<?php echo "$id_pasien"; ?>" class="btn btn-md btn-success mt-2 ml-2">
                    <i class="ti-check-box"></i> Ya, Daftar
                </a>
                <button type="button" class="btn btn-md btn-light mt-2 ml-2" data-dismiss="modal">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
<?php } ?>