<?php
    if(!empty($_POST['id_obat_storage'])){
        $id_obat_storage=$_POST['id_obat_storage'];
?>
    <input type="hidden" name="id_obat_storage" id="id_obat_storage" value="<?php echo $id_obat_storage;?>">
    <div class="col col-md-12 text-center">
        <span class="modal-icon display-2-lg">
            <img src="assets/images/question.gif" width="70%">
        </span>
    </div>
<?php } ?>