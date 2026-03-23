<!--- Modal Tambah Supplier ---->
<div class="modal fade" id="ModalTambahSupplier" tabindex="-1" role="dialog" aria-labelledby="ModalTambahSupplier" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="PorosesTambahSupplier" autocomplete="off">
                <div class="modal-header">
                    <h4 cass="modal-title">
                        <i class="ti ti-plus"></i> Tambah Supplier
                    </h4> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="nama"><dt>Nama Petugas</dt></label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="nama" id="nama" class="form-control" required>
                            <small>Diisi dengan nama petugas/delegasi penanggung jawab</small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="alamat"><dt>Alamat</dt></label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="alamat" id="alamat" class="form-control">
                            <small>Alamat perusahaan, cabang atau operasional</small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="kontak"><dt>Kontak</dt></label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="kontak" id="kontak" class="form-control" placeholder="62" required>
                            <small>Nomor kantor atau kontak pribadi penanggung jawab</small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="email"><dt>Alamat Email</dt></label>
                        </div>
                        <div class="col-md-8">
                            <input type="email" name="email" id="email" class="form-control" placeholder="email@domain.com">
                            <small>
                                * Sertakan Apabila Ada
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="company"><dt>Nama Perusahaan</dt></label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="company" id="company" class="form-control" required>
                            <small>Nama perusahan, badan hukum resmi yang sah</small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <dt>Keterangan</dt>
                        </div>
                        <div class="col-md-8" id="NotifikasiTambahSupplier"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row mb-2">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-sm btn-primary btn-round mr-3">
                                <i class="ti ti-save"></i> Simpan
                            </button>
                            <button type="button" class="btn btn-sm btn-secondary btn-round" data-dismiss="modal">
                                <i class="ti-close"></i> Tutup
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Detail Supplier ---->
<div class="modal fade" id="ModalDetailSupplier" tabindex="-1" role="dialog" aria-labelledby="ModalDetailSupplier" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 cass="modal-title">
                    <i class="ti ti-info-alt"></i> Detail Supplier
                </h4> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="FormDetailSupplier">
                
            </div>
            <div class="modal-footer">
                <div class="row mb-2">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-sm btn-secondary btn-round" data-dismiss="modal">
                            <i class="ti-close"></i> Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--- Modal Edit Supplier ---->
<div class="modal fade" id="ModalEditSupplier" tabindex="-1" role="dialog" aria-labelledby="ModalEditSupplier" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditSupplier" autocomplete="off">
                <div class="modal-header">
                    <h4 cass="modal-title">
                        <i class="ti ti-pencil"></i> Edit Supplier
                    </h4> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="FormEditSupplier">
                        <!-- Menampilkan Form Edit Supplier Disini -->
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <dt>Keterangan</dt>
                        </div>
                        <div class="col-md-8" id="NotifikasiEditSupplier"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row mb-2">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-sm btn-primary btn-round mr-3">
                                <i class="ti ti-save"></i> Simpan
                            </button>
                            <button type="button" class="btn btn-sm btn-secondary btn-round" data-dismiss="modal">
                                <i class="ti-close"></i> Tutup
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Hapus Supplier ---->
<div class="modal fade" id="ModalHapusSupplier" tabindex="-1" role="dialog" aria-labelledby="ModalHapusSupplier" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusSupplier">
                <div class="modal-header bg-danger">
                    <b cass="text-light"><i class="icofont-trash"></i> Konfirmasi Hapus Supplier</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="FormHapusSupplier">
                        <!-- Form hapus Supplier Disini -->
                    </div>
                    <div class="row mt-2 mb-2"> 
                        <div class="col-md-12 text-center" id="NotifikasiHapusSupplier">
                            <!-- Notifikasi Hapus Data Supplier -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-danger">
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <button type="submit" class="btn btn-sm btn-primary mr-2" id="TombolHapusSupplier">
                                <i class="ti-check-box"></i> Ya, Hapus
                            </button>
                            <button type="button" class="btn btn-sm btn-dark" data-dismiss="modal">
                                <i class="ti-close"></i> Tidak
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Transaksi Supplier ---->
<div class="modal fade" id="ModalTransaksiSupplier" tabindex="-1" role="dialog" aria-labelledby="ModalTransaksiSupplier" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 cass="modal-title">
                    <i class="icofont-history"></i> Riwayat Transaksi Supplier
                </h4> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0);" id="FilterTransaksiSupplier">
                    <input type="hidden"  name="page" id="PutPageTransaksiSupplier">
                    <div class="row mb-4 sub-title">
                        <div class="col-md-3">
                            <input type="text" readonly class="form-control" name="id_supplier" id="PutIdSupplierForTransaksi">
                            <small>ID.Supplier</small>
                        </div>
                        <div class="col-md-9">
                            <div class="input-group">
                                <input type="text" class="form-control" name="keyword" id="KeywordForTransaksiSupplier">
                                <button type="submit" class="btn btn-sm btn-info">
                                    <i class="ti ti-search"></i> Cari
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
                <div id="TabelTransaksiSupplier"></div>
            </div>
            <div class="modal-footer">
                <div class="row mb-2">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-sm btn-secondary btn-round" data-dismiss="modal">
                            <i class="ti-close"></i> Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>