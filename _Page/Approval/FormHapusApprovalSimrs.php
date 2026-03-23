<?php
    if(!empty($_POST['id_approval'])){
        $id_approval=$_POST['id_approval'];
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
                <small class="modal-title my-3" id="NotifikasiHapusApproval">Anda Yakin Ingin Menghapus Data Ini?</small>
            </div>
        </div>
    </div>
<?php } ?>