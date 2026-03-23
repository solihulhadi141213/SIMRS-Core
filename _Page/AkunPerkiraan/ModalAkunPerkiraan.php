<!--- Modal Detail Akun Perkiraan ---->
<div class="modal fade" id="ModalDetailAkunPerkiraan" tabindex="-1" role="dialog" aria-labelledby="ModalDetailAkunPerkiraan" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-info-alt"></i> Detail Akun Perkiraan</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="FormDetailAkunPerkiraan">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-round btn-sm btn-secondary" data-dismiss="modal">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Tambah Akun Perkiraan ---->
<div class="modal fade" id="ModalTambahAkunPerkiraan" tabindex="-1" role="dialog" aria-labelledby="ModalTambahAkunPerkiraan" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahAkunPerkiraan">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-plus"></i> Tambah Akun Perkiraan</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="FormTambahAkunPerkiraan"></div>
                    <div class="row">
                        <div class="col-md-12" id="NotifikasiTambahAkunPerkiraan"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-round btn-sm btn-success">
                        <i class="ti ti-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-round btn-sm btn-secondary" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--- Modal Edit Akun Perkiraan ---->
<div class="modal fade" id="ModalEditAkunPerkiraan" tabindex="-1" role="dialog" aria-labelledby="ModalEditAkunPerkiraan" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditAkunPerkiraan">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-pencil-alt"></i> Edit Akun Perkiraan</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="FormEditAkunPerkiraan"></div>
                    <div class="row">
                        <div class="col-md-12" id="NotifikasiEditAkunPerkiraan"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-round btn-sm btn-success">
                        <i class="ti ti-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-round btn-sm btn-secondary" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Hapus Akun Perkiraan ---->
<div class="modal fade" id="ModalHapusAkunPerkiraan" tabindex="-1" role="dialog" aria-labelledby="ModalHapusAkunPerkiraan" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusAkunPerkiraan">
                <input type="hidden" name="id_perkiraan" id="PutIdPerkiraanForHapus">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-trash"></i> Hapus Akun Perkiraan</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <span class="modal-icon display-2-lg">
                                <img src="assets/images/question.gif" width="100%">
                            </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center" id="NotifikasiHapusAkunPerkiraan"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-round btn-sm btn-success">
                        <i class="ti ti-check-box"></i> Ya, Hapus
                    </button>
                    <button type="button" class="btn btn-round btn-sm btn-secondary" data-dismiss="modal">
                        <i class="ti-close"></i> Tidak
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>