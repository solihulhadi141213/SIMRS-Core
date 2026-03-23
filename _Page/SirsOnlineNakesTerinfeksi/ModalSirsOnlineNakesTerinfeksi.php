<!--- Modal Filter Nakes Terinfeksi---->
<div class="modal fade" id="ModalFilterNakesTerinfeksi" tabindex="-1" role="dialog" aria-labelledby="ModalFilterNakesTerinfeksi" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesFilterNakesTerinfeksi">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-filter"></i> Filter Nakes Terinfeksi</b> 
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
                                <option value="">All</option>
                                <option value="id_nakes_pcr">ID PCR Nakes</option>
                                <option value="id_pasien">No.RM</option>
                                <option value="id_kunjungan">No.REG</option>
                                <option value="nama">Nama</option>
                                <option value="tanggal">Tanggal</option>
                                <option value="kategori">Kategori</option>
                                <option value="status">Status</option>
                            </select>
                        </div>
                        <div class="col-md-12 mb-3" id="FormFilter">
                            <label for="keyword">Kata Kunci</label>
                            <input type="text" name="keyword" id="keyword" class="form-control">
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
<!--- Modal Pilih PCR Nakes---->
<div class="modal fade" id="ModalPilihPcrNakes" tabindex="-1" role="dialog" aria-labelledby="ModalPilihPcrNakes" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-plus"></i> Pilih Data PCR Nakes</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" >
                <div class="row mb-3">
                    <div class="col-md-12">
                        <form action="javascript:void(0);" class="form-group" id="ProsesFilterPcrNakes">
                            <div class="input-group">
                                <input type="text" name="keyword_pcr_nakes" class="form-control" placeholder="Nama Nakes/Tanggal Pemeriksaan PCR">
                                <button type="submit" class="btn btn-sm btn-primary">
                                    <i class="ti ti-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12" id="MenampilkanTabelPcrNakes">
                        
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
<!--- Modal Tambah Nakes Terinfeksi---->
<div class="modal fade" id="ModalTambahNakesTerinfeksi" tabindex="-1" role="dialog" aria-labelledby="ModalTambahNakesTerinfeksi" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahNakesTerinfeksi">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-plus"></i> Tambah Nakes Terinfeksi</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="FormTambahNakesTerinfeksi">
                        <!-- Form Tambah Nakes Terinfeksi -->
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12" id="NotifikasiTambahNakesTerinfeksi">Pastikan Data Nakes Terinfeksi Yang Anda Masukan Sudah Sesuai</div>
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
<!--- Modal Detail Nakes Terinfeksi---->
<div class="modal fade" id="ModalDetailNakesTerinfeksi" tabindex="-1" role="dialog" aria-labelledby="ModalDetailNakesTerinfeksi" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-info-alt"></i> Detail Nakes Terinfeksi</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="FormDetailNakesTerinfeksi">
                    <!-- Form Tambah Nakes Terinfeksi -->
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
<!--- Modal Edit Nakes Terinfeksi---->
<div class="modal fade" id="ModalEditNakesTerinfeksi" tabindex="-1" role="dialog" aria-labelledby="ModalEditNakesTerinfeksi" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditNakesTerinfeksi">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-pencil"></i> Edit Nakes Terinfeksi</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="FormEditNakesTerinfeksi">
                        <!-- Form Edit Nakes Terinfeksi -->
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12" id="NotifikasiEditNakesTerinfeksi">Pastikan Data Nakes Terinfeksi Yang Anda Masukan Sudah Sesuai</div>
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
<!--- Modal Hapus Nakes Terinfeksi---->
<div class="modal fade" id="ModalHapusNakesTerinfeksi" tabindex="-1" role="dialog" aria-labelledby="ModalHapusNakesTerinfeksi" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusNakesTerinfeksi">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-pencil"></i> Edit Nakes Terinfeksi</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="FormHapusNakesTerinfeksi">
                        <!-- Form Hapus Nakes Terinfeksi -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary mt-2 ml-2">
                        <i class="ti-save"></i> Ya, Hapus
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary mt-2 ml-2" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Detail Log Nakes Terinfeksi---->
<div class="modal fade" id="ModalDetailLaporanNakesTerinfeksi" tabindex="-1" role="dialog" aria-labelledby="ModalDetailLaporanNakesTerinfeksi" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-info"></i> Detail Nakes Terinfeksi</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="FormDetailLogNakesTerinfeksi">
                    <!-- Form Hapus Nakes Terinfeksi -->
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