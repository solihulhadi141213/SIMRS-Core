<div class="row">
    <div class="col-md-3">
        <div class="card">
            <form action="javascript:void(0);" id="CariFilterTransaksi">
                <input type="hidden" name="page" id="page" class="form-control" value="1">
                <div class="card-header">
                    <dt class="card-title">
                        <i class="ti ti-search"></i> Filter & Pencarian
                    </dt>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <select name="batas" id="batas" class="form-control">
                                <option value="5">5</option>
                                <option selected value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                            <small>
                                <label for="batas">Batas Data</label>
                            </small>
                        </div>
                        <div class="col-md-12 mb-2">
                            <select name="OrderBy" id="OrderBy" class="form-control">
                                <option value="">Pilih</option>
                                <option value="id_transaksi">ID Transaksi</option>
                                <option value="kode">Kode</option>
                                <option value="transaksi">Kategori Transaksi</option>
                                <option value="tanggal">Tanggal</option>
                                <option value="nama_akses">Petugas Transaksi</option>
                                <option value="nama_supplier">Nama Supplier</option>
                                <option value="id_pasien">No.RM</option>
                                <option value="nama_pasien">Nama Pasien</option>
                                <option value="id_kunjungan">No.REG</option>
                                <option value="nama_dokter">Nama Dokter</option>
                                <option value="status">Status</option>
                                <option value="kunci">Kunci</option>
                                <option value="catatan">Catatan</option>
                                <option value="updatetime">Updatetime</option>
                            </select>
                            <small>
                                <label for="OrderBy">Dasar Urutan</label>
                            </small>
                        </div>
                        <div class="col-md-12 mb-2">
                            <select name="ShortBy" id="ShortBy" class="form-control">
                                <option value="DESC">Z to A</option>
                                <option value="ASC">A to Z</option>
                            </select>
                            <small>
                                <label for="ShortBy">Mode Urutan</label>
                            </small>
                        </div>
                        <div class="col-md-12 mb-2">
                            <select name="keyword_by" id="keyword_by" class="form-control">
                                <option value="">Pilih</option>
                                <option value="id_transaksi">ID Transaksi</option>
                                <option value="kode">Kode</option>
                                <option value="transaksi">Kategori Transaksi</option>
                                <option value="tanggal">Tanggal</option>
                                <option value="nama_akses">Petugas Transaksi</option>
                                <option value="nama_supplier">Nama Supplier</option>
                                <option value="id_pasien">No.RM</option>
                                <option value="nama_pasien">Nama Pasien</option>
                                <option value="id_kunjungan">No.REG</option>
                                <option value="nama_dokter">Nama Dokter</option>
                                <option value="status">Status</option>
                                <option value="kunci">Kunci</option>
                                <option value="catatan">Catatan</option>
                                <option value="updatetime">Updatetime</option>
                            </select>
                            <small>
                                <label for="keyword_by">Mode Pencarian</label>
                            </small>
                        </div>
                        <div class="col-md-12 mb-2" id="FormKeyword">
                            <input type="text" name="keyword" id="keyword" class="form-control" placeholder="Kata kunci pencarian">
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <button type="submit" class="btn btn-sm btn-dark btn-block btn-round">
                                <i class="ti ti-search"></i> Cari
                            </button>
                        </div>
                        <div class="col-md-12 mb-3">
                            <button type="button" class="btn btn-sm btn-primary btn-block btn-round" data-toggle="modal" data-target="#ModalTambahTransaksi">
                                <i class="ti ti-plus"></i> Tambah Transaksi
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-9">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">
                    <i class="icofont-list"></i> Data Transaksi
                </h4>
            </div>
            <div id="TabelTransaksi">

            </div>
        </div>
    </div>
</div>