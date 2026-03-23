<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    //Tangkap id_cppt
    if(empty($_POST['id_cppt'])){
        echo '<div class="modal-body">';
        echo '  <div class="row">';
        echo '      <div class="col-md-6 mb-3">';
        echo '          Data ID CPPT Tidak Dapat didefinisikan.';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
        echo '<div class="modal-footer">';
        echo '  <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">';
        echo '      <i class="ti ti-close"></i> Tutup';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_cppt=$_POST['id_cppt'];
?>
    <div class="modal-body">
        <div class="row mt-2 mb-2"> 
            <div class="col-md-12 text-center">
                <img src="assets/images/question.gif" alt="" width="70%">
            </div>
        </div>
        <div class="row mt-2 mb-2"> 
            <div class="col-md-12 text-center text-danger">
                Untuk melakukan perubahan data CPPT, anda akan diarahkan pada halaman Form Edit CPPT.<br>
                Silahkan lanjutkan untuk melakukan perubahan.
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-success mr-3" id="SetujuEditCppt">
            <i class="ti-check-box"></i> Ya, Lanjutkan
        </button>
        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">
            <i class="ti ti-close"></i> Tutup
        </button>
    </div>
<?php } ?>