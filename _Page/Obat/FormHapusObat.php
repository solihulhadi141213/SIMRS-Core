<?php
    if(!empty($_POST['id_obat'])){
        $id_obat=$_POST['id_obat'];
?>
    <div class="row">
            <div class="col col-md-12 text-center">
                <span class="modal-icon display-2-lg">
                    <img src="assets/images/question.gif" width="70%">
                </span>
            </div>
        </div>
        <div class="row">
            <div class="col col-md-12 text-center mb-3">
                <small class="modal-title my-3" id="NotifikasiHapusObat">Anda Yakin Ingin Menghapus Data Ini?</small>
            </div>
        </div>
        <div class="row">
            <div class="col col-md-12 text-center mb-3">
                <button type="button" class="btn btn-sm btn-round btn-success btn-block" id="KonfirmasiHapusObat">
                    <i class="ti ti-check-box"></i> Ya, Hapus
                </button>
            </div>
        </div>
    </div>
<?php } ?>