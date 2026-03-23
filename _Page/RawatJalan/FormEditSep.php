<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    //Tangkap id_kunjungan
    if(empty($_POST['sep'])){
        echo '<div class="card-body border-0 pb-0">';
        echo '  <div class="row">';
        echo '      <div class="col-md-6 mb-3">';
        echo '          No.SEP Tidak Dapat didefinisikan.';
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
                <span id="NotifikasiHapusKunjungan">
                    Apakah anda yakin akan melakukan perubahan pada SEP ini?
                </span>
            </div>
        </div>
    </div>
    <div class="modal-footer bg-info">
        <div class="row">
            <div class="col-md-12 mb-3">
                <a href="index.php?Page=RawatJalan&Sub=EditSep&sep=<?php echo "$sep";?>"class="btn btn-md btn-inverse mt-2 ml-2" id="KonfirmasiHapusKunjungan">
                    <i class="ti-check-box"></i> Ya, Edit
                </a>
                <button type="button" class="btn btn-md btn-light mt-2 ml-2" data-dismiss="modal">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
<?php } ?>