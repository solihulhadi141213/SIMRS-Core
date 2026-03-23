<!--- Modal Tambah Sesi Baru ---->
<div class="modal fade" id="ModalTambahSesiStokOpename" tabindex="-1" role="dialog" aria-labelledby="ModalTambahSesiStokOpename" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="index.php" method="GET">
                <input type="hidden" name="Page" value="StokOpename">
                <input type="hidden" name="Sub" value="DetailSesiStokOpename">
                <input type="hidden" name="id" id="PutIdStorage">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-plus"></i> Buat Sesi Stok Opename</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="tanggal"><dt>Tanggal</dt></label>
                            <input type="date" required name="tanggal" id="tanggal" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            Silahkan isi tanggal sesi stok opename yang ingin anda buat kemudian lanjutkan proses. Setelah ini anda akan diarahkan pada halaman sesi stok opename.
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary btn-round">
                        <i class="ti ti-arrow-circle-right"></i> Lanjutkan
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary btn-round" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Tambah So ---->
<div class="modal fade" id="ModalTambahSo" tabindex="-1" role="dialog" aria-labelledby="ModalTambahSo" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahSo">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-plus"></i> Tambah Stok Opename</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="FormTambahSo">
                        
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4">Notifikasi</div>
                        <div class="col-md-8 mb-3" id="NotifikasiTambahSo"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-success btn-round">
                        <i class="ti ti-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary btn-round" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Detail Sesi Stok Opename ---->
<div class="modal fade" id="ModalDetailSesiStokOpename" tabindex="-1" role="dialog" aria-labelledby="ModalDetailSesiStokOpename" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-info-alt"></i> Detail Sesi Stok Opename</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        Berikut ini adalah detail informasi sesi stok opename yang telah dilaksanakan.
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12" id="FormDetailSesiStokOpename">
                        
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary btn-round" data-dismiss="modal">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Detail Stok Opename Item---->
<div class="modal fade" id="ModalDetailStokOpenameItem" tabindex="-1" role="dialog" aria-labelledby="ModalDetailStokOpenameItem" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-info-alt"></i> Detail Stok Opename</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="FormDetailStokOpename">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary btn-round" data-dismiss="modal">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Hapus Stok Opename Item---->
<div class="modal fade" id="ModalHapusStokOpenameItem" tabindex="-1" role="dialog" aria-labelledby="ModalHapusStokOpenameItem" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusStokOpenameItem">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-trash"></i> Hapus Stok Opename</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 text-center" id="FormHapusItemStokOpename">
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" id="NotifikasiHapusItemStokOpename">
                            Apakah anda yakin akan menghapus item stok opename ini?
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-success btn-round">
                        <i class="ti-check"></i> Ya, Hapus
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary btn-round" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Edit So ---->
<div class="modal fade" id="ModalEditStokOpenameItem" tabindex="-1" role="dialog" aria-labelledby="ModalEditStokOpenameItem" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditStokOpenameItem">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-pencil-alt"></i> Edit Stok Opename</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="FormEditStokOpenameItem">
                        
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4">Notifikasi</div>
                        <div class="col-md-8 mb-3" id="NotifikasiEditStokOpenameItem"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-success btn-round">
                        <i class="ti ti-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary btn-round" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Export Stok Opename ---->
<div class="modal fade" id="ModalExportStokOpename" tabindex="-1" role="dialog" aria-labelledby="ModalExportStokOpename" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="_Page/StokOpename/ProsesExportStokOpename.php" method="POST" target="_blank">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-download"></i> Export Stok Opename</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="FormExportStokOpename">
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-success btn-round">
                        <i class="ti ti-download"></i> Export
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary btn-round" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>