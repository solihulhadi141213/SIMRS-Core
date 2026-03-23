<!-- Modal Buat SEP -->
<div class="modal fade" id="ModalBuatSep" tabindex="-1" role="dialog" aria-labelledby="ModalBuatSep" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="icofont-prescription"></i> Pilih Pasien</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="javascript:void(0);" id="PencarianPasien">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 input-group">
                            <input type="text" class="form-control" name="keyword" id="keyword" placeholder="Pencarian Pasien">
                            <button type="submit" class="btn btn-sm btn-outline-secondary"><i class="ti-search"></i></button>
                        </div>
                    </div>
                    <div class="row" >
                        <div class="col-md-12 mb-3 pre-scrollable">
                            <ul class="list-group" id="FormPilihPasien">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    A list item
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    A list item
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    A list item
                                </li>
                            </ul>
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
<!-- Modal Pilih Kunjungan -->
<div class="modal fade" id="ModalPilihKunjungan" tabindex="-1" role="dialog" aria-labelledby="ModalPilihKunjungan" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="icofont-prescription"></i> Pilih Kunjungan</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row" >
                    <div class="col-md-12 mb-3">
                        <ul class="list-group" id="ListKunjungan">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                A list item
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                A list item
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                A list item
                            </li>
                        </ul>
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
<!--- Modal Pencarian SEP Berdasarkan Nomor SEP ---->
<div class="modal fade" id="ModalPencarianNomorSep" tabindex="-1" role="dialog" aria-labelledby="ModalPencarianNomorSep" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-search"></i> Pencarian Nomor SEP</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row" >
                    <div class="col-md-12 mb-3" id="FormPencarianNomorSep">
                        
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
<!--- Modal Detail SEP ---->
<div class="modal fade" id="ModalDetailSep" tabindex="-1" role="dialog" aria-labelledby="ModalDetailSep" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-info-alt"></i> Detail SEP</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row" >
                    <div class="col-md-12 mb-3" id="FormDetailSep">
                        
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
<!--- Modal Cari Rujukan ---->
<div class="modal fade" id="ModalCariRujukan" tabindex="-1" role="dialog" aria-labelledby="ModalCariRujukan" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesPencarianRujukan">
                <div class="modal-header">
                    <b cass="text-dark"><i class="icofont-prescription"></i> Cari Rujukan</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2" >
                        <div class="col-md-12">
                            <dt>Pilih Dasar Pencarian Rujukan</dt>
                        </div>
                        <div class="col-md-6 mb-2">
                            <input type="text" name="PutNoRujukan" id="PutNoRujukan" class="form-control">
                            <small>
                                <input type="radio" id="DasarPencarianRujukan1" name="DasarPencarianRujukan" value="no_rujukan">
                                <label for="DasarPencarianRujukan1">Nomor Rujukan</label>
                            </small>
                        </div>
                        <div class="col-md-6 mb-2">
                            <input type="text" name="PutNoKartu" id="PutNoKartu" class="form-control">
                            <small>
                                <input type="radio" id="DasarPencarianRujukan2" name="DasarPencarianRujukan" value="no_kartu">
                                <label for="DasarPencarianRujukan2">Nomor Kartu</label>
                            </small>
                        </div>
                    </div>
                    <div class="row" >
                        <div class="col-md-12 mb-2">
                            <button type="submit" class="btn btn-sm btn-success btn-round btn-block">
                                <i class="ti-search"></i> Cari
                            </button>
                        </div>
                    </div>
                    <div class="row" >
                        <div class="col-md-12 mb-3">
                            <div class="list-group" id="HasilPencarianRujukan">
                                <a href="javascript:void(0);" class="list-group-item list-group-item-action">
                                    Silahkan lakukan proses pencarian.
                                </a>
                            </div>
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
<!--- Modal Cari PPK Perujuk ---->
<div class="modal fade" id="ModalPencarianPpkPerujuk" tabindex="-1" role="dialog" aria-labelledby="ModalPencarianPpkPerujuk" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesPencarianPpkPerujuk">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-search"></i> Cari Kode PPK Perujuk</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2" >
                        <div class="col-md-12">
                            <div class="input-group">
                                <input type="text" name="KeywordPencarianPpk" id="KeywordPencarianPpk" class="form-control">
                                <button type="submit" class="btn btn-sm btn-outline-secondary">
                                    <i class="ti-search"></i> Cari
                                </button>
                            </div>
                            <small>
                                <input type="radio" checked name="tipe_faskes_ppk" id="tipe_faskes_ppk1" value="1"> <label for="tipe_faskes_ppk1">Faskes 1</label> 
                                <input type="radio" name="tipe_faskes_ppk" id="tipe_faskes_ppk2" value="2"> <label for="tipe_faskes_ppk2">Faskes 2/RS</label> 
                            </small>
                        </div>
                    </div>
                    <div class="row" >
                        <div class="col-md-12 mb-3">
                            <div class="list-group" id="HasilPencarianPpkPerujuk">
                                <a href="javascript:void(0);" class="list-group-item list-group-item-action">
                                    Silahkan lakukan proses pencarian.
                                </a>
                            </div>
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
<!--- Modal Pencarian SPRI/SKDP ---->
<div class="modal fade" id="ModalPencarianSpriSkdp" tabindex="-1" role="dialog" aria-labelledby="ModalPencarianSpriSkdp" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesPencarianSpriSkdp">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-search"></i> Cari SPRi/SKDP</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-4" >
                        <div class="col-md-12">
                            <input type="radio" name="ModePencarianSpriSkdp" id="ModePencarianSpriSkdp1" value="nomor_surat_kontrol">
                            <label for="ModePencarianSpriSkdp1">Cari Dari Nomor SPRI/SKDP</label>
                            <input type="text" disabled name="KeywordByNomorSuratKontrol" id="KeywordByNomorSuratKontrol" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-4" >
                        <div class="col-md-12">
                            <input type="radio" name="ModePencarianSpriSkdp" id="ModePencarianSpriSkdp2" value="nomor_kartu_bpjs"> 
                            <label for="ModePencarianSpriSkdp2">Cari Dari Nomor Kartu BPJS</label>
                            <input type="text" disabled name="KeywordByNomorKartuBpjs" id="KeywordByNomorKartuBpjs" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-4" >
                        <div class="col-md-12">
                            <label for="TanggalPencarianSpriSkdp">Periode Pencarian</label>
                            <input type="date" disabled name="TanggalPencarianSpriSkdp" id="TanggalPencarianSpriSkdp" class="form-control" value="<?php echo date('Y-m-d'); ?>"> 
                        </div>
                    </div>
                    <div class="row mb-4" >
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-sm btn-success btn-round btn-block">
                                <i class="ti-search"></i> Cari
                            </button>
                        </div>
                    </div>
                    <div class="row mb-4" >
                        <div class="col-md-12">
                            <div class="list-group" id="HasilPencarianSpriSkdp">
                                <div class="list-group-item list-group-item-action">
                                    Silahkan lakukan proses pencarian.
                                </div>
                            </div>
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
<!--- Modal Pencarian Diagnosa ---->
<div class="modal fade" id="ModalCariDiagnosa" tabindex="-1" role="dialog" aria-labelledby="ModalCariDiagnosa" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesCariDiagnosa">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-search"></i> Cari Diagnosa</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-4" >
                        <div class="col-md-12 input-group">
                            <input type="text" name="KeywordDiagnosa" id="KeywordDiagnosa" class="form-control" placeholder="Kode/Nama Diagnosa">
                            <button type="submit" class="btn btn-sm btn-dark">
                                <i class="ti-search"></i> Cari
                            </button>
                        </div>
                    </div>
                    <div class="row mb-4" >
                        <div class="col-md-12">
                            <div class="list-group" id="HasilPencarianDiagnosa">
                                <div class="list-group-item list-group-item-action">
                                    Silahkan lakukan proses pencarian.
                                </div>
                            </div>
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
<!--- Modal Cetak SEP ---->
<div class="modal fade" id="ModalCetakSep" tabindex="-1" role="dialog" aria-labelledby="ModalCetakSep" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="_Page/sep/CetakSep.php" method="POST" target="_blank">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-printer"></i> Cetak SEP</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="noSepCetak">Nomor SEP</label>
                            <input type="text" id="noSepCetak" name="noSepCetak" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="FormatCetakSep">Format Cetak</label>
                            <select name="FormatCetakSep" id="FormatCetakSep" class="form-control">
                                <option value="HTML">HTML</option>
                                <option value="PDF">PDF</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary btn-round">
                        <i class="ti ti-arrow-circle-right"></i> Mulai Cetak
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary btn-round" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Hapus SEP ---->
<div class="modal fade" id="ModalHapusSep" tabindex="-1" role="dialog" aria-labelledby="ModalHapusSep" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-trash"></i> Hapus SEP</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormHapusSep">
                <!-- Form Hapus SEP -->
            </div>
        </div>
    </div>
</div>
<!--- Modal Edit SEP ---->
<div class="modal fade" id="ModalEditSep" tabindex="-1" role="dialog" aria-labelledby="ModalEditSep" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-pencil"></i> Edit SEP</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormEditSep">
                <!-- Form Edit SEP -->
            </div>
        </div>
    </div>
</div>
<!-- Modal Detail Kunjungan -->
<div class="modal fade" id="ModalDetailKunjungan" tabindex="-1" role="dialog" aria-labelledby="ModalDetailKunjungan" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-inverse">
                <b cass="text-light"><i class="icofont-prescription"></i> Detail Kunjungan Rajal</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="DetailKunjunganRajal">
                <!---- Detail Kunjungan Rajal----->
            </div>
        </div>
    </div>
</div>
<!-- Modal Detail Pasien -->
<div class="modal fade" id="ModalDetailPasien" tabindex="-1" role="dialog" aria-labelledby="ModalDetailPasien" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-light"><i class="icofont-prescription"></i> Detail Pasien</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="DetailPasien">
                <!---- Detail Pasien ----->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>