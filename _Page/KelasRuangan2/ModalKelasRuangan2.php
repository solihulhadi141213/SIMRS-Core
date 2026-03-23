<div class="modal fade" id="ModalFilter" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesFilterKelas">
                <input type="hidden" name="page" id="page" value="1">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">
                        <i class="ti ti-filter"></i> Filter Data
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="batas">Limit/Batas</label>
                        </div>
                        <div class="col-8">
                            <select name="batas" id="batas" class="form-control">
                                <option value="5">5</option>
                                <option selected value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                                <option value="250">250</option>
                                <option value="500">500</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="kategori_filter">Kategori</label>
                        </div>
                        <div class="col-8">
                            <select name="kategori" id="kategori_filter" class="form-control">
                                <option value="kelas">Kelas</option>
                                <option value="ruangan">Ruangan</option>
                                <option value="bed">Tempat Tidur</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="OrderBy">Dasar Urutan</label>
                        </div>
                        <div class="col-8">
                            <select name="OrderBy" id="OrderBy" class="form-control">
                                <option value="">Pilih</option>
                                <option value="kategori">Kategori</option>
                                <option value="kodekelas">Kode Kelas</option>
                                <option value="kelas">Kelas</option>
                                <option value="ruangan">Ruangan</option>
                                <option value="bed">Tempat Tidur (Bed)</option>
                                <option value="pria">Jumlah TT (Pria)</option>
                                <option value="wanita">Jumlah TT (Wanita)</option>
                                <option value="bebas">Jumlah TT (Umum)</option>
                                <option value="tarif">Tarif Inap</option>
                                <option value="status">Status</option>
                                <option value="updatetime">Updatetime</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="ShortBy">Tipe Urutan</label>
                        </div>
                        <div class="col-8">
                            <select name="ShortBy" id="ShortBy" class="form-control">
                                <option value="ASC">A To Z</option>
                                <option selected value="DESC">Z To A</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="KeywordBy">Dasar Pencarian</label>
                        </div>
                        <div class="col-8">
                            <select name="keyword_by" id="KeywordBy" class="form-control">
                                <option value="">Pilih</option>
                                <option value="kodekelas">Kode Kelas</option>
                                <option value="kelas">Kelas</option>
                                <option value="ruangan">Ruangan</option>
                                <option value="bed">Tempat Tidur (Bed)</option>
                                <option value="status">Status</option>
                                <option value="updatetime">Updatetime</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="keyword">Kata Kunci</label>
                        </div>
                        <div class="col-8" id="FormFilter">
                            <input type="text" name="keyword" id="keyword" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-rounded">
                        <i class="bi bi-save"></i> Filter
                    </button>
                    <button type="button" class="btn btn-secondary btn-rounded" data-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalTambah" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambah">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">
                        <i class="ti ti-plus"></i> Tambah Data Ruangan
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="kategori_tambah">Kategori</label>
                            <select name="kategori" id="kategori_tambah" class="form-control">
                                <option value="">Pilih</option>
                                <option value="kelas">Kelas</option>
                                <option value="ruangan">Ruangan</option>
                                <option value="bed">Tempat Tidur (Bed)</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12" id="FormTambah">
                            <!-- Form Tambah Kelas Dan Ruangan -->
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12" id="NotifikasiTambah">
                            <!-- Notifikasi Tambah Kelas Dan Ruangan -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-rounded">
                        <i class="ti ti-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-secondary btn-rounded" data-dismiss="modal">
                        <i class="ti ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalHapus" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapus">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">
                        <i class="ti ti-alert"></i> Hapus Data Ruangan
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-12" id="FormHapus">
                            <!-- Form Hapus Kelas Dan Ruangan -->
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12" id="NotifikasiHapus">
                            <!-- Notifikasi Hapus Kelas Dan Ruangan -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-rounded">
                        <i class="ti ti-check"></i> Ya, Hapus
                    </button>
                    <button type="button" class="btn btn-secondary btn-rounded" data-dismiss="modal">
                        <i class="ti ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalEdit" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEdit">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">
                        <i class="ti ti-pencil-alt"></i> Edit Data Ruangan
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-12" id="FormEdit">
                            <!-- Form Edit Kelas Dan Ruangan -->
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12" id="NotifikasiEdit">
                            <!-- Notifikasi Edit Kelas Dan Ruangan -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-rounded">
                        <i class="ti ti-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-secondary btn-rounded" data-dismiss="modal">
                        <i class="ti ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>