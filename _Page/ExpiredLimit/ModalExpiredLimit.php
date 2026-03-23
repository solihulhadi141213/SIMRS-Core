<!--- Modal Edit Expired Item ---->
<div class="modal fade" id="ModalEditExpiredItem" tabindex="-1" role="dialog" aria-labelledby="ModalEditExpiredItem" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditExpiredItem">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-pencil-alt"></i> Edit Expired Item</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!---- Form Tambah Pasien ----->
                    <div class="row">
                        <div class="col-md-12" id="FormEditExpiredItem">
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" id="NotifikasiEditExpired">
                            <span>Pastikan informasi data expired item sudah sesuai dengan benar.</span>
                        </div>
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
<!--- Modal Hapus Expired Item ---->
<div class="modal fade" id="ModalHapusExpiredItem" tabindex="-1" role="dialog" aria-labelledby="ModalHapusExpiredItem" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusExpiredItem">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-trash"></i> Hapus Expired Item</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!---- Form Tambah Pasien ----->
                    <div class="row">
                        <div class="col-md-12" id="FormHapusExpiredItem">
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center" id="NotifikasiHapusExpiredItem">
                            <span class="text-primary">Apakah anda yakin akan menghapus data ini?</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-round btn-sm btn-success">
                        <i class="ti ti-check"></i> Ya, Hapus
                    </button>
                    <button type="button" class="btn btn-round btn-sm btn-secondary" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Detail Item ---->
<div class="modal fade" id="ModalDetailObat" tabindex="-1" role="dialog" aria-labelledby="ModalDetailObat" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="index.php" method="GET">
                <input type="hidden" name="Page" value="ExpiredLimit">
                <input type="hidden" name="sub" value="LimitItem">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-info-alt"></i> Detail Item</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="FormDetailItem">
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-round btn-sm btn-secondary" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Cetak Expired ---->
<div class="modal fade" id="ModalCetakExpiredItem" tabindex="-1" role="dialog" aria-labelledby="ModalCetakExpiredItem" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <form action="_Page/ExpiredLimit/ProsesCetakExpiredLimit.php" method="POST" target="_blank">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-trash"></i> Cetak/Export Data</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <label for="KategoriData">Kategori Data</label>
                            <ul>
                                <li>
                                    <input type="radio" checked name="KategoriData" id="ExpiredItem" value="ExpiredItem">
                                    <label for="ExpiredItem">Expired Item</label>
                                </li>
                                <li>
                                    <input type="radio" name="KategoriData" id="LimitItem" value="LimitItem">
                                    <label for="LimitItem">Limit Item</label>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <label for="FormatCetak">Format Cetak</label>
                            <ul>
                                <li>
                                    <input type="radio" checked name="FormatCetak" id="FormatCetakHtml" value="HTML">
                                    <label for="FormatCetakHtml">Format HTML</label>
                                </li>
                                <li>
                                    <input type="radio" name="FormatCetak" id="FormatCetakExcel" value="Excel">
                                    <label for="FormatCetakExcel">Format Excel</label>
                                </li>
                                <li>
                                    <input type="radio" name="FormatCetak" id="FormatCetakPdf" value="PDF">
                                    <label for="FormatCetakPdf">Format PDF</label>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <label for="TampilkanHeader">Tampilkan Header</label>
                            <ul>
                                <li>
                                    <input type="radio" checked name="TampilkanHeader" id="TampilkanHeaderYa" value="Ya">
                                    <label for="TampilkanHeaderYa">Ya, Tampilkan</label>
                                </li>
                                <li>
                                    <input type="radio" name="TampilkanHeader" id="TampilkanHeaderTidak" value="Tidak">
                                    <label for="TampilkanHeaderTidak">Tidak</label>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-round btn-sm btn-success">
                        <i class="ti ti-printer"></i> Cetak/Export
                    </button>
                    <button type="button" class="btn btn-round btn-sm btn-secondary" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>