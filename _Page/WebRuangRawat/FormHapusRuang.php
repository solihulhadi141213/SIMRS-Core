<?php
    if(empty($_POST['ruang_rawat'])){
        echo '<div class="modal-body">';
        echo '  <div class="row">';
        echo '      <div class="col col-md-12 text-center">';
        echo '          ID Ruang Rawat Tidak Boleh Kosong!';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
        echo '<div class="modal-footer bg-danger">';
        echo '  <button type="button" class="btn btn-md btn-outline-light" data-dismiss="modal"><i class="ti ti-close"></i> Tutup</button>';
        echo '</div>';
    }else{
        $ruang_rawat=$_POST['ruang_rawat'];
?>
    <div class="modal-body">
        <div class="row">
                <div class="col col-md-12 text-center">
                    <span class="modal-icon display-2-lg">
                        <img src="assets/images/question.gif" width="70%">
                    </span>
                </div>
            </div>
            <div class="row">
                <div class="col col-md-12 text-center mb-3">
                    <small class="modal-title my-3" id="NotifikasiHapusRuang">Anda Yakin Ingin Menghapus Data Ini?</small>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer bg-danger">
        <div class="row">
            <div class="col col-md-12 text-center">
                <button type="button" id="KonfirmasiHapusRuang" class="btn btn-md btn-info">
                    <i class="ti ti-check"></i> Ya
                </button>
                <button type="button" class="btn btn-md btn-outline-light" data-dismiss="modal">
                    <i class="ti ti-close"></i> Tidak
                </button>
            </div>
        </div>
    </div>
<?php } ?>