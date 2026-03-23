<?php
    if(!empty($_POST['id_obat_transfer_alokasi'])){
        $id_obat_transfer_alokasi=$_POST['id_obat_transfer_alokasi'];
?>
    <input type="hidden" name="id_obat_transfer_alokasi" id="id_obat_transfer_alokasi" value="<?php echo $id_obat_transfer_alokasi;?>">
    <div class="row">
        <div class="col col-md-12 text-center">
            <span class="modal-icon display-2-lg">
                <img src="assets/images/question.gif" width="70%">
            </span>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col col-md-12 text-center">
            <small class="text-dark">
                Sistem akan mengembalikan kalkulasi barang yang telah dipindahkan sebelumnya.
            </small>
        </div>
    </div>
<?php } ?>