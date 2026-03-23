<!--- Modal Tambah Bantuan ---->
<div class="modal fade" id="ModalTambahbantuan" tabindex="-1" role="dialog" aria-labelledby="ModalTambahbantuan" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="index.php" method="GET">
                <input type="hidden" name="Page" value="Bantuan">
                <input type="hidden" name="Sub" value="TambahBantuan">
                <div class="modal-header">
                    <b cass="text-dark">
                        <i class="ti ti-plus"></i> Tambah Bantuan
                    </b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <dt>Keterangan</dt>
                            Untuk menambahkan informasi bantuan, anda akan diarahkan pada halaman form mandiri tambah bantuan.
                            Untuk melanjutkan silahkan pilih tombol lanjutkan di bawah ini.
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary btn-round">
                        <i class="ti-close"></i> Ya, Lanjutkan
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary btn-round" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Detail Bantuan ---->
<div class="modal fade" id="ModalDetailBantuan" tabindex="-1" role="dialog" aria-labelledby="ModalDetailBantuan" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark">
                    <i class="ti ti-info-alt"></i> Detail Bantuan
                </b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="FormDetailBantuan">
                <!---- Form Hapus Bantuan ----->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary btn-round" data-dismiss="modal">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Edit Bantuan ---->
<div class="modal fade" id="ModalEditBantuan" tabindex="-1" role="dialog" aria-labelledby="ModalEditBantuan" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="index.php" method="GET">
                <input type="hidden" name="Page" value="Bantuan">
                <input type="hidden" name="Sub" value="EditBantuan">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-pencil-alt"></i> Konfirmasi Edit Bantuan</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body border-0 pb-0 mb-4">
                    <div id="FormEditBantuan">
                        <!---- Form Hapus Bantuan ----->
                    </div>
                    <div class="row mb-4"> 
                        <div class="col-md-12">
                            <dt>Keterangan : </dt>
                            Untuk mengubah informasi bantuan, anda akan diarahkan pada halaman form mandiri ubah bantuan.
                            Untuk melanjutkan silahkan pilih tombol lanjutkan di bawah ini.
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <button type="submit" class="btn btn-sm btn-primary btn-round btn-block">
                                <i class="ti-check-box"></i> Ya, Lanjutkan
                            </button>
                        </div>
                        <div class="col-md-6 mb-3">
                            <button type="button" class="btn btn-sm btn-secondary btn-round btn-block" data-dismiss="modal">
                                <i class="ti-close"></i> Tutup
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Hapus Bantuan ---->
<div class="modal fade" id="ModalDeleteBantuan" tabindex="-1" role="dialog" aria-labelledby="ModalDeleteBantuan" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusBantuan">
                <div class="modal-header">
                    <b cass="text-dark"><i class="icofont-trash"></i> Konfirmasi Hapus Bantuan</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body border-0 pb-0 mb-4">
                    <div id="FormHapusBantuan">
                        <!---- Form Hapus Bantuan ----->
                    </div>
                    <div class="row mt-2 mb-2"> 
                        <div class="col-md-12 text-center text-danger">
                            <span id="NotifikasiHapusBantuan">
                                Apakah anda yakin akan menghapus data bantuan ini?
                            </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <button type="submit" class="btn btn-sm btn-primary btn-round btn-block">
                                <i class="ti-check-box"></i> Ya, Hapus
                            </button>
                        </div>
                        <div class="col-md-6 mb-3">
                            <button type="button" class="btn btn-sm btn-secondary btn-round btn-block" data-dismiss="modal">
                                <i class="ti-close"></i> Tutup
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>