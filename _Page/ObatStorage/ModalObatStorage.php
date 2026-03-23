<!--- Modal Tambah Storage ---->
<div class="modal fade" id="ModalTambahStorage" tabindex="-1" role="dialog" aria-labelledby="ModalTambahStorage" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahStorage">
                <div class="modal-header bg-inverse">
                    <b cass="text-light"><i class="ti ti-plus"></i> Form Tambah Penyimpanan</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="FormTambahStorage">
                    <!---- Form Tambah Storage ----->
                </div>
                <div class="modal-footer bg-inverse">
                    <button type="submit" class="btn btn-md btn-primary mr-3">
                        <i class="icofont-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-md btn-white" data-dismiss="modal">
                        <i class="icofont-close-circled"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Tambah Storage ---->
<div class="modal fade" id="ModalKonfirmasiKeHalamanTransfer" tabindex="-1" role="dialog" aria-labelledby="ModalKonfirmasiKeHalamanTransfer" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-light"><i class="icofont-question"></i> Transfer Barang</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <span class="modal-icon display-2-lg">
                            <img src="assets/images/question.gif" width="70%">
                        </span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-center">
                        Untuk melakukan input data transfer barang, anda akan diarahkan ke halaman form transfer barang. 
                        Silahkan pilih tombol lanjutkan untuk masuk ke halaman form tersebut.
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="index.php?Page=ObatStorage&Sub=FormTransferBarang" class="btn btn-sm btn-success mr-3">
                    <i class="ti-arrow-circle-right"></i> Lanjutkan
                </a>
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                    <i class="icofont-close-circled"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Detail Storage ---->
<div class="modal fade" id="ModalDetailObatStorage" tabindex="-1" role="dialog" aria-labelledby="ModalDetailObatStorage" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-trash"></i> Detail Tempat Penyimpanan</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="FormDetailStorage">
                <!---- Form Detail Storage ----->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                    <i class="icofont-close-circled"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Edit Storage ---->
<div class="modal fade" id="ModalEditObatStorage" tabindex="-1" role="dialog" aria-labelledby="ModalEditObatStorage" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditStorage">
                <div class="modal-header bg-success">
                    <b cass="text-light"><i class="ti ti-pencil"></i> Form Edit Penyimpanan</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="FormEditStorage">
                    <!---- Form Tambah Storage ----->
                </div>
                <div class="modal-footer bg-success">
                    <button type="submit" class="btn btn-md btn-primary mr-3">
                        <i class="icofont-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-md btn-white" data-dismiss="modal">
                        <i class="icofont-close-circled"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Hapus Storage ---->
<div class="modal fade" id="ModalHapusObatStorage" tabindex="-1" role="dialog" aria-labelledby="ModalHapusObatStorage" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusStorageObat">
                <div class="modal-header bg-danger">
                    <b cass="text-light"><i class="ti ti-trash"></i> Hapus Tempat Penyimpanan</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row" id="FormHapusStorage">

                    </div>
                    <div class="row">
                        <div class="col col-md-12 text-center mb-3" id="NotifikasiHapusStorage">
                            <spoan class="text-primary">Anda Yakin Ingin Menghapus Data Ini?</spoan>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-danger">
                    <button type="submit" class="btn btn-sm btn-success">
                        <i class="icofont-check-circled"></i> Ya, Hapus
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                        <i class="icofont-close-circled"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Alokasi Item ---->
<div class="modal fade" id="ModalAlokasiItem" tabindex="-1" role="dialog" aria-labelledby="ModalAlokasiItem" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesCariObatUntukAlokasi">
                <input type="hidden" name="id_obat_storage" id="IdObatStorage">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-check"></i> Pilih Item Obat</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="input-group">
                                <input type="text" name="KeywordObatUntukAlokasi" class="form-control">
                                <button type="submit" class="btn btn-sm btn-outline-dark">
                                    <i class="ti ti-search"></i> Cari
                                </button>
                            </div>
                        </div>
                    </div>
                    <div id="ListObatUntukAlokasi">
                        <!---- List Hasil Cari Obat Untuk Alokasi ----->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                        <i class="icofont-close-circled"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Posisi Obat ---->
<div class="modal fade" id="ModalPosisiObat" tabindex="-1" role="dialog" aria-labelledby="ModalPosisiObat" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesPosisiObat">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-pencil-alt"></i> Posisi Penyimpanan Obat</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="FormPosisiObat">
                        <!---- Form Posisi Obat ----->
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <dt class="text-primary">Keterangan : </dt>
                        </div>
                        <div class="col-md-8" id="NotifikasiPosisiObat">
                            <span class="text-primary">Pastikan Data Yang Anda Input Sudah Sesuai</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <button type="submit" class="btn btn-sm btn-block btn-primary btn-round">
                                <i class="ti-save"></i> Simpan
                            </button>
                        </div>
                        <div class="col-md-12 mb-2">
                            <button type="button" class="btn btn-sm btn-block btn-outline-danger btn-round" id="ClickHapusPosisiObat">
                                <i class="ti-trash"></i> Hapus
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary btn-round" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Pilih Obat ---->
<div class="modal fade" id="ModalPilihObatUntukTransfer" tabindex="-1" role="dialog" aria-labelledby="ModalPilihObatUntukTransfer" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesCariObatUntukTransfer">
                <input type="hidden" name="id_obat_storage" id="PutIdObatStorage">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-check"></i> Pilih Item Obat</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="input-group">
                                <input type="text" name="KeywordObatUntukTransfer" class="form-control">
                                <button type="submit" class="btn btn-sm btn-outline-dark">
                                    <i class="ti ti-search"></i> Cari
                                </button>
                            </div>
                        </div>
                    </div>
                    <div id="ListObatUntukTransfer">
                        <!---- List Hasil Cari Obat Untuk Transfer ----->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                        <i class="icofont-close-circled"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Detail Transfer -->
<div class="modal fade" id="ModalDetailTransfer" tabindex="-1" role="dialog" aria-labelledby="ModalDetailTransfer" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-info-alt"></i> Detail Transfer</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="FormDetailTransfer">
                <!---- Form Detail Transfer ----->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-round btn-secondary" data-dismiss="modal">
                    <i class="icofont-close-circled"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Hapus Transfer ---->
<div class="modal fade" id="ModalHapusTransfer" tabindex="-1" role="dialog" aria-labelledby="ModalHapusTransfer" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusTransfer">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-trash"></i> Hapus Transfer Barang</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row" id="FormHapusTransfer">

                    </div>
                    <div class="row">
                        <div class="col col-md-12 text-center mb-3" id="NotifikasiHapusTransfer">
                            <span class="text-primary">Anda Yakin Ingin Menghapus Data Ini?</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-success">
                        <i class="icofont-check-circled"></i> Ya, Hapus
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                        <i class="icofont-close-circled"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Konfirmasi Edit Transfer ---->
<div class="modal fade" id="ModalKonfirmasiEditTransfer" tabindex="-1" role="dialog" aria-labelledby="ModalKonfirmasiEditTransfer" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-trash"></i> Konfirmasi Edit Transfer</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormKonfirmasiEditTransfer"></div>
        </div>
    </div>
</div>