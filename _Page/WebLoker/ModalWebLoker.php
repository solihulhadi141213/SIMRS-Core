<!--- Modal Tambah Artikel ---->
<div class="modal fade" id="ModalEditArtikel" tabindex="-1" role="dialog" aria-labelledby="ModalEditArtikel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <b cass="text-light"><i class="ti ti-plus"></i> Edit Artikel</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 mt-3" id="KontenDeskripsi"><?php if($Page=="WebLoker"){echo "$deskripsi_loker";} ?></div>
                    <div class="col-md-12 mt-3" id="KontenPengumuman"><?php if($Page=="WebLoker"){echo "$pengumuman";} ?></div>
                </div>
            </div>
            <div class="modal-footer bg-primary">
                <button type="submit" class="btn btn-md btn btn-success">
                    <i class="ti ti-save"></i> Simpan
                </button>
                <button type="button" class="btn btn-md btn btn-secondary" data-dismiss="modal">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Delete Loker ---->
<div class="modal fade" id="ModalHapusLoker" tabindex="-1" role="dialog" aria-labelledby="ModalHapusLoker" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <b cass="text-light">Konfirmasi Hapus Loker</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormHapusLoker">
                <!---- Konfirmasi Hapus Loker ----->
            </div>
        </div>
    </div>
</div>