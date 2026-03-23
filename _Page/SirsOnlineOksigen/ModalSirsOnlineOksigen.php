<!--- Modal Filter Laporan Oksigen---->
<div class="modal fade" id="ModalFilterOksigen" tabindex="-1" role="dialog" aria-labelledby="ModalFilterOksigen" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesFilterOksigen">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-filter"></i> Filter Oksigen</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="batas">Data</label>
                            <select name="batas" id="batas" class="form-control">
                                <option value="5">5</option>
                                <option selected value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="keyword_by">Dasar Pencarian</label>
                            <select name="keyword_by" id="keyword_by" class="form-control">
                                <option selected value="">All</option>
                                <option value="tanggal">Tanggal</option>
                                <option value="updatetime">Update Time</option>
                                <option value="id_akses">Petugas</option>
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="short_by">Urutan Data</label>
                            <select name="short_by" id="short_by" class="form-control">
                                <option selected value="DESC">DESC</option>
                                <option value="ASC">ASC</option>
                            </select>
                        </div>
                        <div class="col-md-12 mb-3" id="FormKeyword">
                            <label for="keyword">Kata Kunci</label>
                            <input type="date" name="keyword" id="keyword" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary mt-2 ml-2">
                        <i class="ti-search"></i> Cari
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary mt-2 ml-2" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Tambah Laporan Oksigen---->
<div class="modal fade" id="ModalTambahOksigen" tabindex="-1" role="dialog" aria-labelledby="ModalTambahOksigen" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahOksigen">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-plus"></i> Buat Laporan Oksigen</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="tanggal">Tanggal Laporan</label>
                        </div>
                        <div class="col-md-8">
                            <input type="date" name="tanggal" id="tanggal" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="satuan">Satuan</label>
                        </div>
                        <div class="col-md-8">
                            <select name="satuan" id="satuan" class="form-control">
                                <option value="M3">M3</option>
                                <option value="Liter">Liter</option>
                                <option value="Kg">Kg</option>
                                <option value="Ton">Ton</option>
                                <option value="Galon">Galon</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <dt>1. Data Pemakaian</dt>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="p_cair">Oksigen Cair</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="p_cair" id="p_cair" class="form-control">
                            <small id="notif_p_cair">Satuan dalam M3 : </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="p_tabung_kecil">Tabung Kecil</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="p_tabung_kecil" id="p_tabung_kecil" class="form-control">
                            <small id="notif_p_tabung_kecil">Satuan dalam M3 : </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="p_tabung_sedang">Tabung Sedang</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="p_tabung_sedang" id="p_tabung_sedang" class="form-control">
                            <small id="notif_p_tabung_sedang">Satuan dalam M3 : </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="p_tabung_besar">Tabung Besar</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="p_tabung_besar" id="p_tabung_besar" class="form-control">
                            <small id="notif_p_tabung_besar">Satuan dalam M3 : </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <dt>2. Data Ketersediaan</dt>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="k_isi_cair">Oksigen Cair</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="k_isi_cair" id="k_isi_cair" class="form-control">
                            <small id="notif_k_isi_cair">Satuan dalam M3 : </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="k_isi_tabung_kecil">Tabung Kecil</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="k_isi_tabung_kecil" id="k_isi_tabung_kecil" class="form-control">
                            <small id="notif_k_isi_tabung_kecil">Satuan dalam M3 : </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="k_isi_tabung_sedang">Tabung Sedang</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="k_isi_tabung_sedang" id="k_isi_tabung_sedang" class="form-control">
                            <small id="notif_k_isi_tabung_sedang">Satuan dalam M3 : </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="k_isi_tabung_besar">Tabung Besar</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="k_isi_tabung_besar" id="k_isi_tabung_besar" class="form-control">
                            <small id="notif_k_isi_tabung_besar">Satuan dalam M3 : </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <dt>Keterangan</dt>
                        </div>
                        <div class="col-md-8 mb-3" id="NotifikasiTambahLaporanOksigen">
                            Pastikan data yang anda input sudah benar
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary mt-2 ml-2">
                        <i class="ti-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary mt-2 ml-2" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Detail Oksigen SIRS Online ---->
<div class="modal fade" id="ModalDetailOksigenSirsOnline" tabindex="-1" role="dialog" aria-labelledby="ModalDetailOksigenSirsOnline" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <dt cass="text-dark"><i class="ti ti-info"></i> Detail (SIRS Online)</dt> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="FormDetailOksigenSirsOnline">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Form Detail Laporan Oksigen -->
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary mt-2 ml-2" data-dismiss="modal">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Detail Oksigen ---->
<div class="modal fade" id="ModalDetailOksigen" tabindex="-1" role="dialog" aria-labelledby="ModalDetailOksigen" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <dt cass="text-dark"><i class="ti ti-info"></i> Detail Laporan Oksigen</dt> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="FormDetailLaporanOksigen">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Form Detail Laporan Oksigen -->
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary mt-2 ml-2" data-dismiss="modal">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Hapus Laporan Oksigen ---->
<div class="modal fade" id="ModalHapusOksigen" tabindex="-1" role="dialog" aria-labelledby="ModalHapusOksigen" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusLaporanOksigen">
                <div class="modal-header">
                    <dt cass="text-dark"><i class="ti ti-trash"></i> Hapus Laporan Oksigen</dt> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="FormHapusOksigen">
                            <!-- Form Hapus Laporan Oksigen -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" id="NotifikasiHapusOksigen">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary mt-2 ml-2">
                        <i class="ti-check"></i> Ya, Hapus
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary mt-2 ml-2" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Edit Laporan Oksigen ---->
<div class="modal fade" id="ModalEditOksigen" tabindex="-1" role="dialog" aria-labelledby="ModalEditOksigen" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditOksigen">
                <div class="modal-header">
                    <dt cass="text-dark"><i class="ti ti-pencil"></i> Edit Laporan Oksigen</dt> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="FormEditOksigen">
                            <!-- Form Edit Laporan Oksigen -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <dt>Keterangan</dt>
                        </div>
                        <div class="col-md-8 mb-3" id="NotifikasiEditLaporanOksigen">
                            Pastikan data yang anda input sudah benar
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary mt-2 ml-2">
                        <i class="ti-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary mt-2 ml-2" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>