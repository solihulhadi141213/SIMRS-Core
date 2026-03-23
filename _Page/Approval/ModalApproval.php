<!--- Modal Tambah Approval ---->
<div class="modal fade" id="ModalTambahApproval" tabindex="-1" role="dialog" aria-labelledby="ModalTambahApproval" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesKirimApproval">
                <div class="modal-header bg-primary">
                    <b cass="text-light"><i class="icofont-prescription"></i> Tambah Approval</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="nomor_kartu">Nomor Kartu</label>
                            <input type="text" name="nomor_kartu" id="nomor_kartu" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="tanggal_sep">Tanggal SEP</label>
                            <input type="date" name="tanggal_sep" id="tanggal_sep" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="jenis_pelayanan">Jenis Pelayanan</label>
                            <select name="jenis_pelayanan" id="jenis_pelayanan" class="form-control">
                                <option value="1">Rawat Inap</option>
                                <option value="2">Rawat Jalan</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="jenis_pengajuan">Jenis Pengajuan</label>
                            <select name="jenis_pengajuan" id="jenis_pengajuan" class="form-control">
                                <option value="1">Pengajuan Backdate</option>
                                <option value="2">Pengajuan Finger Print</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="keterangan">Keterangan</label>
                            <input type="text" name="keterangan" id="keterangan" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12" id="NotifikasiTambahApproval">
                            <span class="text-primary">Pastikan Data Permintaan Approval Yang Anda kirim Sudah Benar</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-primary">
                    <button type="submit" class="btn btn-sm btn-success">
                        <i class="ti ti-save"></i> Kirim
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Hapus Approval---->
<div class="modal fade" id="ModalHapusApprovalSimrs" tabindex="-1" role="dialog" aria-labelledby="ModalHapusApprovalSimrs" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <b cass="text-light"><i class="ti ti-trash"></i> Hapus Approval</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="FormHapusApprovalSimrs">

            </div>
            <div class="modal-footer bg-danger">
                <button type="button" id="KonfirmasiHapusApproval" class="btn btn-sm btn-success">
                    <i class="ti ti-check"></i> Ya, Hapus
                </button>
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"><i class="ti ti-close"></i> Tidak</button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Update Approval---->
<div class="modal fade" id="ModalUpdateApprovalSimrs" tabindex="-1" role="dialog" aria-labelledby="ModalUpdateApprovalSimrs" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <b cass="text-light"><i class="ti ti-check"></i> Update Approval</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="FormUpdateApprovalSimrs">

            </div>
            <div class="modal-footer bg-success">
                <button type="button" id="KonfirmasiUpdateApproval" class="btn btn-sm btn-primary">
                    <i class="ti ti-check"></i> Ya, Update
                </button>
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"><i class="ti ti-close"></i> Tidak</button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Detail Approval---->
<div class="modal fade" id="ModalDetailApprovalSimrs" tabindex="-1" role="dialog" aria-labelledby="ModalDetailApprovalSimrs" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <b cass="text-light"><i class="ti ti-info-alt"></i> Detail Approval</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="FormDetailApprovalSimrs">
                <div class="row">
                    <div class="col col-md-12" id="FormDetailApprovalSimrs">
                        
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-info">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"><i class="ti ti-close"></i> Tutup</button>
            </div>
        </div>
    </div>
</div>