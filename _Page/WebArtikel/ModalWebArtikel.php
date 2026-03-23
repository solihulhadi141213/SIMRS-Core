<!--- Modal Tambah Artikel ---->
<div class="modal fade" id="ModalTambahtArtikel" tabindex="-1" role="dialog" aria-labelledby="ModalTambahtArtikel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <b cass="text-light"><i class="ti ti-plus"></i> Tambah Artikel</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 mt-3" id="KontentIsiArtikel"><?php if($Page=="EditArtikel"){echo "$artikel_isi";} ?></div>
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
<!--- Modal Detail Artikel ---->
<div class="modal fade" id="ModalDetailArtikel" tabindex="-1" role="dialog" aria-labelledby="ModalDetailArtikel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <b cass="text-light"><i class="ti ti-info-alt"></i> Detail Artikel</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="DetailArtikel">
            </div>
            <div class="modal-footer bg-info">
                <button type="button" class="btn btn-md btn btn-secondary" data-dismiss="modal">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Delete Artikel ---->
<div class="modal fade" id="ModalHapustArtikel" tabindex="-1" role="dialog" aria-labelledby="ModalHapusService" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <b cass="text-light">Konfirmasi Hapus Artikel</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormHapusArtikel">
                <!---- Konfirmasi Hapus Artikel ----->
            </div>
        </div>
    </div>
</div>