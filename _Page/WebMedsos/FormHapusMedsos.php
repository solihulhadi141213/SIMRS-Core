<?php
    if(!empty($_POST['id_web_medsos'])){
        $id_web_medsos=$_POST['id_web_medsos'];
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
                    <small class="modal-title my-3" id="NotifikasiHapusMedsos">Anda Yakin Ingin Menghapus Data Ini?</small>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <div class="row">
            <div class="col col-md-12 text-center">
                <button type="button" id="KonfirmasiHapusMedsos" class="btn btn-md btn-outline-info">Ya</button>
                <button type="button" class="btn btn-md btn-outline-danger" data-dismiss="modal">Tidak</button>
            </div>
        </div>
    </div>
<?php } ?>