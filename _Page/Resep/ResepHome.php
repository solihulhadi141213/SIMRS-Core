<div class="row">
    <div class="col-md-3">
        <div class="card">
            <form action="javascript:void(0);" id="PencarianResep">
                <div class="card-header">
                    <dt>
                        <i class="ti ti-search"></i> Cari Resep
                    </dt>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <select name="batas" id="batas" class="form-control">
                                <option value="6">6</option>
                                <option selected value="9">9</option>
                                <option value="18">18</option>
                                <option value="36">36</option>
                            </select>
                            <label for="batas"><small>Batas Data</small></label>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <select name="keyword_by" id="keyword_by" class="form-control">
                                <option value="">Pilih</option>
                                <option value="id_pasien">No.RM</option>
                                <option value="id_kunjungan">No.Reg</option>
                                <option value="nama_pasien">Nama Pasien</option>
                                <option value="nama_dokter">Dokter</option>
                                <option value="tanggal_resep">Tanggal</option>
                                <option value="status">Status</option>
                            </select>
                            <label for="keyword_by"><small>Mode Pencarian</small></label>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12" id="FormKeyword">
                            <input type="text" name="keyword" id="keyword" class="form-control">
                            <label for="keyword"><small>Kata Kunci</small></label>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-sm btn-block btn-primary btn-round">
                                <i class="ti ti-search"></i> Mulai Pencarian
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-9" id="TabelResep">
        <!-- Menampilkan Data Resep Disini -->
    </div>
</div>