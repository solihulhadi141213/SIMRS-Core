<div class="row">
    <div class="col-md-3">
        <form action="javascript:void(0);" id="BatasPencarian" autocomplete="off" class="mb-3">
            <input type="hidden" name="page" id="page">
            <div class="card">
                <div class="card-header border-bottom-inverse">
                    <h4 class="card-title">
                        <i class="ti-search"></i> Pencarian Data
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="batas">Batas Data</label>
                            <select name="batas" id="batas" class="form-control">
                                <option value="5">5</option>
                                <option selected value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="OrderBy">Urutkan Berdasarkan</label>
                            <select name="OrderBy" id="OrderBy" class="form-control">
                                <option value="">Pilih</option>
                                <option value="id_tarif">ID Tarif/Tindakan</option>
                                <option value="nama">Nama Tarif/Tindakan</option>
                                <option value="kategori">Kategori</option>
                                <option value="tarif">Tarif</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="ShortBy">Mode Urutan</label>
                            <select name="ShortBy" id="ShortBy" class="form-control">
                                <option value="DESC">DESC</option>
                                <option value="ASC">ASC</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="keyword_by">Dasar Pencarian</label>
                            <select name="keyword_by" id="keyword_by" class="form-control">
                                <option value="">Pilih</option>
                                <option value="id_tarif">ID Tarif/Tindakan</option>
                                <option value="nama">Nama Tarif/Tindakan</option>
                                <option value="kategori">Kategori</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="keyword">Kata Kunci</label>
                            <div id="FormKeyword">
                                <input type="text" class="form-control" name="keyword" id="keyword" list="keyword_list" placeholder="ID, Nama , Kategori">
                                <datalist id="keyword_list"></datalist>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-sm btn-block btn-dark btn-round">
                        <i class="ti-search"></i> Mulai Cari
                    </button>
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-9">
        <div class="card table-card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-9 mb-2">
                        <h4 class="card-title">
                            <i class="icofont-list"></i> List Tarif & Tindakan
                        </h4>
                    </div>
                    <div class="col-md-3 mb-2">
                        <button class="btn btn-sm btn-block btn-primary btn-round" data-toggle="modal" data-target="#ModalTambahTarifTindakan" title="Tambah Item Tarif Dan Tindakan Baru">
                            <i class="ti-plus text-white"></i> Tambah Tarif
                        </button>
                    </div>
                </div>
            </div>
            <div id="MenampilkanTabelTarifTindakan">
                <!--  Menampilkan Tabel Tarif dan Tindakan disini -->
            </div>
        </div>
    </div>
</div>