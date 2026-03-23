<?php
    if(empty($_POST['id_akses_ref'])){
        echo '<span>ID Referensi Akses Tidak Boleh Kosong!</span>';
    }else{
        $id_akses_ref=$_POST['id_akses_ref'];
?>
    <input type="hidden" name="id_akses_ref" value="<?php echo "$id_akses_ref"; ?>">
    <div class="row">
        <div class="col col-md-12 text-center">
            <span class="modal-icon display-2-lg">
                <img src="assets/images/question.gif" width="70%">
            </span>
        </div>
    </div>
<?php } ?>