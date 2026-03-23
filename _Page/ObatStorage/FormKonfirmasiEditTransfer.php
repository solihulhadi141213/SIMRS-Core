<?php
    if(!empty($_POST['id_obat_transfer_alokasi'])){
        $id_obat_transfer_alokasi=$_POST['id_obat_transfer_alokasi'];
?>
    <div class="modal-body">
        <div class="row">
            <div class="col col-md-12 text-center">
                <span class="modal-icon display-2-lg">
                    <img src="assets/images/question.gif" width="70%">
                </span>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col col-md-12 text-center">
                <span class="text-dark">
                    Untuk melakukan perubahan data transfer barang, anda akan diarahkan ke halaman khusus edit data transfer barang. 
                    Silahkan lanjutkan untuk masuk ke halaman tersebut.
                </span>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <a href="index.php?Page=ObatStorage&Sub=EditTransfer&id=<?php echo $id_obat_transfer_alokasi;?>" class="btn btn-sm btn-success">
            Ya, Lanjutkan <i class="ti-arrow-circle-right"></i>
        </a>
        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
            <i class="icofont-close-circled"></i> Tutup
        </button>
    </div>
<?php } ?>