<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <div class="card">
                            <form action="javascript:void(0);" id="BatasPencarian">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h4><i class="ti ti-search"></i> Pencarian Pasien</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <select class="form-control" name="batas" id="batas">
                                                <option value="5">5</option>
                                                <option selected value="10">10</option>
                                                <option value="25">25</option>
                                                <option value="50">50</option>
                                                <option value="100">100</option>
                                            </select>
                                            <small>Batas</small>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <select class="form-control" name="keyword_by" id="keyword_by">
                                                <option value="">Pilih</option>
                                                <option value="id_pasien">No.RM</option>
                                                <option value="id_ihs">ID IHS</option>
                                                <option value="tanggal_daftar">Tanggal Daftar</option>
                                                <option value="nik">NIK</option>
                                                <option value="no_bpjs">No.BPJS</option>
                                                <option value="nama">Nama Pasien</option>
                                                <option value="gender">Gender</option>
                                                <option value="propinsi">Provinsi</option>
                                                <option value="kabupaten">Kabupaten</option>
                                                <option value="kecamatan">Kecamatan</option>
                                                <option value="desa">Desa/Kelurahan</option>
                                                <option value="alamat">RT/RW</option>
                                                <option value="kontak">Kontak</option>
                                                <option value="status">Status</option>
                                            </select>
                                            <small>Keyword By</small>
                                        </div>
                                        <div class="col-md-12 mb-3" id="FormKeywordPasien">
                                            <input type="text" class="form-control" name="keyword" id="keyword" placeholder="Kata Kunci">
                                            <small>Keyword</small>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <button type="submit" class="btn btn-sm btn-outline-secondary btn-block">
                                                <i class="ti-search"></i> Mulai Pencarian
                                            </button>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <button class="btn btn-sm btn-inverse btn-block" data-toggle="modal" data-target="#ModalExportPasien">
                                                <i class="ti-export text-white"></i> Export
                                            </button>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <button type="button" class="btn btn-sm btn-primary btn-block" data-toggle="modal" data-target="#ModalKonfirmasiTambahPasien">
                                                <i class="ti-plus text-white"></i> Tambah Pasien Baru
                                            </button>
                                        </div>
                                        <!-- <div class="col-md-12 mb-3">
                                            <button class="btn btn-sm btn-success btn-block" data-toggle="modal" data-target="#ModalTambahPasien">
                                                <i class="ti-plus text-white"></i> Tambah Pasien Baru
                                            </button>
                                        </div> -->
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card">
                            <form action="javascript:void(0);" id="PencarianPasienBpjs">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h4><i class="ti ti-search"></i> Pencarian Peserta BPJS</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <select class="form-control" name="DasarPencarianPasienBpjs" id="DasarPencarianPasienBpjs">
                                                <option selected value="NIK">NIK</option>
                                                <option value="Nomor Kartu">Nomor Kartu</option>
                                            </select>
                                            <small>Dasar Pencarian</small>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <input type="text" class="form-control" name="keyword" id="keyword" placeholder="Kata Kunci">
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <button type="button" class="btn btn-sm btn-outline-secondary btn-block" data-toggle="modal" data-target="#ModalPencarianPasienBPJS">
                                                <i class="ti-search"></i> Mulai Pencarian
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card">
                            <form action="javascript:void(0);" id="PencarianPasienSatuSehat">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h4><i class="ti ti-search"></i> Pencarian Pasien (Satu Sehat)</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <select class="form-control" name="DasarPencarianPasienSatuSehat" id="DasarPencarianPasienSatuSehat">
                                                <option selected value="">Pilih</option>
                                                <option value="NIK">NIK</option>
                                                <option value="NIK Ibu">NIK Ibu</option>
                                                <option value="Nama Pasien">Nama Pasien</option>
                                                <option value="ID Pasien">ID Pasien</option>
                                            </select>
                                            <small>Dasar Pencarian</small>
                                        </div>
                                    </div>
                                    <div class="row" id="FormLanjutanPasienSatuSehat">
                                            
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-sm btn-outline-secondary btn-block" data-toggle="modal" data-target="#ModalPencarianpasienSatuSehat">
                                        <i class="ti-search"></i> Mulai Pencarian
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-9  mb-3">
                        <div class="card">
                            <div class="card-header">
                                <h4><i class="ti ti-align-left"></i> Data Pasien</h4>
                            </div>
                            <div id="MenampilkanTabelPasien">
                                <!--  menampilkan data Pasien disini -->
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>