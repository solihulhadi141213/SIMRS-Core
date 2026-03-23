<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    //Tangkap kode
    if(empty($_POST['kode'])){
        echo '<div class="card-body border-0 pb-0">';
        echo '  <div class="row">';
        echo '      <div class="col-md-6 mb-3">';
        echo '          Data kode PPK Tidak Dapat didefinisikan.';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        $kode=$_POST['kode'];
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
                    Apakah anda yakin memilih Kode PPK ini untuk diterapkan pada form?
                </span>
            </div>
        </div>
    </div>
    <div class="modal-footer bg-inverse">
        <div class="row">
            <div class="col-md-12 mb-3">
                <a href="javascript:void(0);" class="btn btn-sm btn-success mr-2" id="KonfirmasiYaPPK">
                    <i class="ti-check-box"></i> Ya
                </a>
                <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
<?php } ?>