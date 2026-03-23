
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header border-bottom-inverse">
                <div class="row">
                    <div class="col-md-12 text-center mb-2">
                        <h4 class="card-title">
                            <i class="icofont-drug-pack"></i> Lokasi Penyimpanan
                        </h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-2">
                        <button class="btn btn-sm btn-block btn-round btn-primary" data-toggle="modal" data-target="#ModalTambahStorage" title="Tambah Lokasi Penyimpanan">
                            <i class="ti-plus text-white"></i> Tambah Penyimpanan
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body" id="TableObatStorage">
                
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header border-bottom-inverse">
                <div class="row">
                    <div class="col-md-12 text-center mb-2">
                        <h4 class="card-title">
                            <i class="ti ti-truck"></i> Riwayat Transfer Barang
                        </h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-2">
                        <a href="javascript:void(0);" data-toggle="modal" data-target="#ModalKonfirmasiKeHalamanTransfer" class="btn btn-sm btn-round btn-block btn-success" title="Pemindahan barang antar penyimpanan">
                            <i class="ti ti-plus"></i> Tambah Transfer Barang
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="javascript:void(0);" id="ProsesPencarianRiwayatTransfer">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <select name="BatasTransfer" id="BatasTransfer" class="form-control">
                                <option value="5">5</option>
                                <option selected value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                            <small>Batas</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <select name="KeywordByTransfer" id="KeywordByTransfer" class="form-control">
                                <option value="">Pilih</option>
                                <option value="kode">Kode Obat/Alkes</option>
                                <option value="nama">Nama Obat/Alkes</option>
                                <option value="tanggal">Tanggal</option>
                            </select>
                            <small>Mode Pencarian</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 input-group mb-3">
                            <input type="text" name="KeywordTransfer" id="KeywordTransfer" class="form-control">
                            <button type="submit" class="btn btn-sm btn-dark">
                                <i class="ti ti-search"></i> Cari
                            </button>
                        </div>
                    </div>
                </form>
                <div id="TabelTransfer">

                </div>
            </div>
            <div class="card-footer"></div>
        </div>
    </div>
</div>
