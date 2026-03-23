<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    //Tangkap id_kunjungan
    if(empty($_POST['id_kunjungan'])){
        echo '<div class="card-body border-0 pb-0">';
        echo '  <div class="row">';
        echo '      <div class="col-md-6 mb-3">';
        echo '          Data ID Kunjungan Tidak Dapat didefinisikan.';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_kunjungan=$_POST['id_kunjungan'];
?>
    <div class="modal-body border-0 pb-0 mb-4">
        <div class="row mt-2 mb-2"> 
            <div class="col-md-12 text-center">
                <img src="assets/images/question.gif" alt="" width="70%">
            </div>
        </div>
        <div class="row mt-2 mb-2"> 
            <div class="col-md-12 text-center">
                Untuk melakukan perubahan data kunjungan, anda akan diarahkan pada halaman form edit kunjungan.<br>
                Apakah anda yakin akan melakukan perubahan data Kunjungan ini?
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <a href="index.php?Page=RawatJalan&Sub=EditKunjungan&id=<?php echo "$id_kunjungan";?>" class="btn btn-sm btn-success">
            <i class="ti-check-box"></i> Ya, Lanjutkan
        </a>
        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
            <i class="ti-close"></i> Tutup
        </button>
    </div>
<?php } ?>