<!--- Modal Detail Pesan---->
<div class="modal fade" id="ModalDetailPesan" tabindex="-1" role="dialog" aria-labelledby="ModalDetailPesan" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <b cass="text-light"><i class="ti ti-info"></i> Detail Pesan</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="FormDetailPesan">
                
            </div>
            <div class="modal-footer bg-primary">
                <button type="button" class="btn btn-md btn btn-secondary" data-dismiss="modal">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Edit Pesan---->
<div class="modal fade" id="ModalEditPesan" tabindex="-1" role="dialog" aria-labelledby="ModalEditPesan" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditPesan">
                <div class="modal-header bg-success">
                    <b cass="text-light"><i class="ti ti-pencil"></i> Edit Pesan</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormEditPesan">
                    
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Delete Pesan ---->
<div class="modal fade" id="ModalHapusPesan" tabindex="-1" role="dialog" aria-labelledby="ModalHapusPesan" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <b cass="text-light">Konfirmasi Hapus Pesan</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormHapusPesan">
                <!---- Konfirmasi Hapus Pesan ----->
            </div>
        </div>
    </div>
</div>