<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    //Tangkap kodePoli
    if(empty($_POST['kodePoli'])){
        echo '<div class="card-body border-0 pb-0">';
        echo '  <div class="row">';
        echo '      <div class="col-md-6 mb-3">';
        echo '          Data kode Poli Tidak Dapat didefinisikan.';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        $kodePoli=$_POST['kodePoli'];
?>
    <div class="modal-body border-0 pb-0 mb-4">
        <div class="row mt-2 mb-2"> 
            <div class="col-md-12 text-center">
                <img src="assets/images/question.gif" alt="" width="70%">
            </div>
        </div>
        <div class="row mt-2 mb-2"> 
            <div class="col-md-12 text-center text-primary">
                <span id="">
                    Apakah anda yakin akan menambahkan Kode Poli ini?
                </span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3 text-center">
                <a href="javascript:void(0);" class="btn btn-sm btn-inverse mt-2 ml-2" id="KonfirmasiPilihPoliYa">
                    <i class="ti-check-box"></i> Ya, Tambahkan
                </a>
                <button type="button" class="btn btn-sm btn-danger mt-2 ml-2" data-dismiss="modal">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
<?php } ?>