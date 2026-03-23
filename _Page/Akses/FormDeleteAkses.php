<?php
    if(!empty($_POST['id_akses'])){
        $id_akses=$_POST['id_akses'];
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
                    <small class="modal-title my-3" id="NotifikasiHapusAkses">Anda Yakin Ingin Menghapus Data Ini?</small>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <div class="row">
            <div class="col col-md-12 text-center">
                <button type="button" id="KonfirmasiHapusAkses" class="btn btn-md btn-outline-info" value="<?php echo $id_akses;?>">Ya</button>
                <button type="button" class="btn btn-md btn-outline-danger" data-dismiss="modal">Tidak</button>
            </div>
        </div>
    </div>
<?php } ?>