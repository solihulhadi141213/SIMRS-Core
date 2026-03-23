<!--- Modal Tambah Transaksi ---->
<div class="modal fade" id="ModalTambahTransaksi" tabindex="-1" role="dialog" aria-labelledby="ModalTambahTransaksi" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 cass="modal-title text-dark">
                    <i class="ti ti-plus"></i> Tambah Transaksi
                </h4> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 mb-2">
                        Untuk menambahkan transaksi, maka anda akan diarahkan pada halaman mandiri tambah data transaksi. 
                        Silahkan lanjutkan untuk masuk ke form tambah transaksi.
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="index.php?Page=Transaksi&Sub=TambahTransaksi" class="btn btn-sm btn-primary mr-3">
                    <i class="ti ti-arrow-circle-right"></i> Lanjutkan
                </a>
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Detail Transaksi ---->
<div class="modal fade" id="ModalDetailTransaksi" tabindex="-1" role="dialog" aria-labelledby="ModalDetailTransaksi" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 cass="modal-title text-dark">
                    <i class="ti ti-info-alt"></i> Detail Transaksi
                </h4> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="FormDetailTransaksi">
                    <!---- Form Detail Transaksi ----->
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
<!--- Modal Rincian Transaksi ---->
<div class="modal fade" id="ModalRincianTransaksi" tabindex="-1" role="dialog" aria-labelledby="ModalRincianTransaksi" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 cass="modal-title text-dark">
                    <i class="icofont-list"></i> Rincian Transaksi
                </h4> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="FormRincianTransaksi">
                    <!---- Form Rincian Transaksi ----->
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
<!--- Modal Detail Pasien ---->
<div class="modal fade" id="ModalDetailPasien" tabindex="-1" role="dialog" aria-labelledby="ModalDetailPasien" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 cass="modal-title text-dark">
                    <i class="ti ti-info-alt"></i> Detail Pasien
                </h4> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="FormDetailPasien">
                    <!---- Form Detail Pasien ----->
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
<!--- Modal List Pasien ---->
<div class="modal fade" id="ModalListPasien" tabindex="-1" role="dialog" aria-labelledby="ModalListPasien" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 cass="modal-title text-dark">
                    <i class="ti ti-check-box"></i> Pilih Pasien
                </h4> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0);" id="ProsesPencarianPasien">
                    <div class="row">
                        <div class="col-md-3">
                            <select name="BatasPasien" id="BatasPasien" class="form-control">
                                <option value="5">5</option>
                                <option selected value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                            </select>
                            <small>
                                <label for="BatasPasien">Batas Data</label>
                            </small>
                        </div>
                        <div class="col-md-7">
                            <input type="text" class="form-control" name="KeywordPasien" id="KeywordPasien" placeholder="Nama/No.RM">
                            <small>
                                <label for="KeywordPasien">Kata Kunci Pencarian</label>
                            </small>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-sm btn-info btn-block">
                                <i class="ti ti-search"></i> Cari
                            </button>
                        </div>
                    </div>
                </form>
                <div id="FormListPasien">
                    <!---- Form List Pasien ----->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" id="RemoveIdPasien">
                    <i class="icofont-ban"></i> Remove
                </button>
                <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Info Pasien ---->
<div class="modal fade" id="ModalInfoPasien" tabindex="-1" role="dialog" aria-labelledby="ModalInfoPasien" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 cass="modal-title text-dark">
                    <i class="ti ti-info-alt"></i> Detail Pasien
                </h4> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="FormInfoPasien">
                    <!---- Form Info Pasien ----->
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
<!--- Modal List Kunjungan ---->
<div class="modal fade" id="ModalListKunjungan" tabindex="-1" role="dialog" aria-labelledby="ModalListKunjungan" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 cass="modal-title text-dark">
                    <i class="ti ti-check-box"></i> Pilih Kunjungan
                </h4> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="FormListKunjungan">
                    <!---- Form List Kunjungan ----->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" id="RemoveIdKunjungan">
                    <i class="icofont-ban"></i> Remove
                </button>
                <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Info Kunjungan ---->
<div class="modal fade" id="ModalInfoKunjungan" tabindex="-1" role="dialog" aria-labelledby="ModalInfoKunjungan" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 cass="modal-title text-dark">
                    <i class="ti ti-info-alt"></i> Detail Kunjungan
                </h4> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="FormInfoKunjungan">
                    <!---- Form Info Kunjungan ----->
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
<!--- Modal List Dokter ---->
<div class="modal fade" id="ModalListDokter" tabindex="-1" role="dialog" aria-labelledby="ModalListDokter" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 cass="modal-title text-dark">
                    <i class="ti ti-check-box"></i> Pilih Dokter
                </h4> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="FormListDokter">
                    <!---- Form List Dokter ----->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" id="RemoveIdDokter">
                    <i class="icofont-ban"></i> Remove
                </button>
                <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal List Supplier ---->
<div class="modal fade" id="ModalListSupplier" tabindex="-1" role="dialog" aria-labelledby="ModalListSupplier" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 cass="modal-title text-dark">
                    <i class="ti ti-check-box"></i> Pilih Supplier
                </h4> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0);" id="ProsesPencarianSupplier">
                    <div class="row">
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="KeywordSupplier" id="KeywordSupplier" placeholder="Nama Supplier / Perusahaan">
                            <small>
                                <label for="KeywordSupplier">Kata Kunci Pencarian</label>
                            </small>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-sm btn-info btn-block">
                                <i class="ti ti-search"></i> Cari
                            </button>
                        </div>
                    </div>
                </form>
                <div id="FormListSupplier">
                    <!---- Form List Supplier ----->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" id="RemoveIdSupplier">
                    <i class="icofont-ban"></i> Remove
                </button>
                <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Form Tambah Rincian ---->
<div class="modal fade" id="ModalTambahRincian" tabindex="-1" role="dialog" aria-labelledby="ModalTambahRincian" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahRincianTransaksi">
                <div class="modal-header">
                    <h4 cass="modal-title text-dark">
                        <i class="ti ti-plus"></i> Tambah Rincian
                    </h4> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="FormTambahRincianTransaksi"></div>
                    <div class="row mb-3">
                        <div class="col-md-12" id="NotifikasiTambahRincian">
                            <span class="text-primary">Pastikan rincian transaksi sudah sesuai</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="ti ti-plus"></i> Tambah Rincian
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Form Tambah Rincian Manual ---->
<div class="modal fade" id="ModalTambahRincianManual" tabindex="-1" role="dialog" aria-labelledby="ModalTambahRincianManual" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahRincianTransaksiManual">
                <div class="modal-header">
                    <h4 cass="modal-title text-dark">
                        <i class="ti ti-plus"></i> Tambah Rincian Manual
                    </h4> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="JenisTransaksiManual">Jenis Transaksi</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" readonly name="transaksi" id="JenisTransaksiManual">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="KategoriRincianManual">Kategori Rincian</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" readonly name="KategoriRincian" id="KategoriRincianManual" value="Lainnya">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="KodeTransaksiManual">Kode Transaksi</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" readonly name="KodeTransaksi" id="KodeTransaksiManual">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="NamaRincian">Nama Rincian</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="NamaRincian">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="HargaRincianManual">Harga/Tarif</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="HargaRincian" id="HargaRincianManual">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="QtyRincianManual">QTY</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="QtyRincian" id="QtyRincianManual" value="1">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="SatuanRincianManual">Satuan</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="SatuanRincian" id="SatuanRincianManual">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="PpnRincianManual">PPN</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="PpnRincian" id="PpnRincianManual"  value="0">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="DiskonRincianManual">Diskon</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="DiskonRincian" id="DiskonRincianManual" value="0">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="JumlahRincianManual">Jumlah</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="JumlahRincian" id="JumlahRincianManual">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="KlaimRincian">Klaim</label>
                        </div>
                        <div class="col-md-8">
                            <select name="KlaimRincian" id="KlaimRincian" class="form-control">
                                <option value="">Pilih</option>
                                <option value="BPJS">BPJS</option>
                                <option value="UMUM">UMUM</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12" id="NotifikasiTambahRincianManual">
                            <span class="text-primary">Pastikan rincian transaksi sudah sesuai</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="ti ti-plus"></i> Tambah Rincian
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Form Edit Rincian ---->
<div class="modal fade" id="ModalEditRincian" tabindex="-1" role="dialog" aria-labelledby="ModalEditRincian" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditRincian">
                <div class="modal-header">
                    <h4 cass="modal-title text-dark">
                        <i class="ti ti-pencil"></i> Edit Rincian Manual
                    </h4> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="FormEditRincian"></div>
                    <div class="row mb-3">
                        <div class="col-md-12" id="NotifikasiEditRincian">
                            <span class="text-primary">Pastikan rincian transaksi sudah sesuai</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="ti ti-save"></i> Update Rincian
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Hapus Rincian ---->
<div class="modal fade" id="ModalHapusRincian" tabindex="-1" role="dialog" aria-labelledby="ModalHapusRincian" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusRincian">
                <input type="hidden" name="id_rincian" id="GetIdRincianForHapus">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-trash"></i> Hapus Rincian</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <img src="assets/images/question.gif" width="70%">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center" id="NotifikasiHapusRincian">
                            <span class="text-danger">Apakah anda yakin akan menghapus data rincian ini?</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="ti ti-check"></i> Ya, Hapus
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>