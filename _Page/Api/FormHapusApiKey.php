<?php
    if(empty($_POST['id_api_access'])){
        echo '<span>ID API Key Tidak Boleh Kosong!</span>';
    }else{
        $id_api_access=$_POST['id_api_access'];
?>
    <input type="hidden" name="id_api_access" value="<?php echo "$id_api_access"; ?>">
    <div class="row">
        <div class="col col-md-12 text-center">
            <span class="modal-icon display-2-lg">
                <img src="assets/images/question.gif" width="70%">
            </span>
        </div>
    </div>
    <div class="row">
        <div class="col col-md-12 text-center">
            Apakah anda yakin akan menghapus data ini?
        </div>
    </div>
<?php } ?>