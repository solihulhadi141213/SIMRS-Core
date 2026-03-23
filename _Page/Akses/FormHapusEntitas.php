<?php
    if(!empty($_POST['id_akses_entitas'])){
        $id_akses_entitas=$_POST['id_akses_entitas'];
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
                    <small class="modal-title my-3" id="NotifikasiHapusEntitas">Anda Yakin Ingin Menghapus Data Ini?</small>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer bg-danger">
        <div class="row">
            <div class="col col-md-12 text-center">
                <button type="button" id="KonfirmasiHapusEntitas" class="btn btn-md btn-success">Ya</button>
                <button type="button" class="btn btn-md btn-secondary" data-dismiss="modal">Tidak</button>
            </div>
        </div>
    </div>
<?php } ?>