<?php
    if(!empty($_POST['id_obat_expired'])){
        $id_obat_expired=$_POST['id_obat_expired'];
?>
    <input type="hidden" name="id_obat_expired" value="<?php echo "$id_obat_expired"; ?>">
    <div class="row">
            <div class="col col-md-12 text-center">
                <span class="modal-icon display-2-lg">
                    <img src="assets/images/question.gif" width="70%">
                </span>
            </div>
        </div>
    </div>
<?php } ?>