<?php
    if(!empty($_POST['id_kategori_harga'])){
        $id_kategori_harga=$_POST['id_kategori_harga'];
?>
    <input type="hidden" name="id_kategori_harga" value="<?php echo $id_kategori_harga; ?>">
    <div class="modal-body">
        <div class="row">
                <div class="col col-md-12 text-center">
                    <span class="modal-icon display-2-lg">
                        <img src="assets/images/question.gif" width="70%">
                    </span>
                </div>
            </div>
            <div class="row">
                <div class="col col-md-12 text-center mb-3" id="NotifikasiHapusKategoriHarga">
                    <small class="modal-title my-3">Anda Yakin Ingin Menghapus Data Ini?</small>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer bg-danger">
        <div class="row">
            <div class="col col-md-12">
                <button type="submit" class="btn btn-sm btn-success btn-round">
                    <i class="ti ti-check"></i> Ya, Hapus
                </button>
                <button type="button" class="btn btn-sm btn-secondary btn-round" data-toggle="modal" data-target="#ModalKategoriHarga">
                    <i class="ti ti-angle-left"></i> Kembali
                </button>
            </div>
        </div>
    </div>
<?php } ?>