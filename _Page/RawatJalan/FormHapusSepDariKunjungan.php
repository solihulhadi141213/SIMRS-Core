<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    //Tangkap sep
    if(empty($_POST['sep'])){
        echo '<div class="card-body border-0 pb-0">';
        echo '  <div class="row">';
        echo '      <div class="col-md-6 mb-3">';
        echo '          Data ID Kunjungan Tidak Dapat didefinisikan.';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        $sep=$_POST['sep'];
?>
    <div class="modal-body border-0 pb-0 mb-4">
        <div class="row mt-2 mb-2"> 
            <div class="col-md-12 text-center">
                <img src="assets/images/question.gif" alt="" width="70%">
            </div>
        </div>
        <div class="row mt-2 mb-2"> 
            <div class="col-md-12 text-center text-danger">
                <span id="NotifikasiHapusSepDariKunjungan">
                    Apakah anda yakin akan menghapus data SEp <?php echo "$sep"; ?> dari kunjungan ini?
                </span>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-sm btn-success">
            <i class="ti-check-box"></i> Ya, Hapus
        </button>
        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
            <i class="ti-close"></i> Tutup
        </button>
    </div>
<?php } ?>