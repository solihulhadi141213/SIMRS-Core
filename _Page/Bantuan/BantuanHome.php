<div class="row">
    <div class="col-md-3 mb-3">
        <form action="javascript:void(0);" id="ProsesPencarian">
            <input type="hidden" name="page" id="page" class="form-control">
            <div class="card">
                <div class="card-header">
                    <dt class="card-title">
                        <i class="ti ti-search"></i> Filter & Pencarian
                    </dt>
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
                            <label for="keyword_by">Dasar Pencarian</label>
                            <select name="keyword_by" id="keyword_by" class="form-control">
                                <option value="">Pilih</option>
                                <option value="tanggal">Tanggal Post</option>
                                <option value="judul">Judul</option>
                                <option value="kategori">Kategori Bantuan</option>
                                <option value="status">Status</option>
                                <option value="isi">Isi Bantuan</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12" id="FormKeyword">
                            <label for="keyword">Kata Kunci</label>
                            <input type="text" name="keyword" id="keyword" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-sm btn-block btn-dark btn-round">
                                <i class="ti ti-search"></i> Mulai Pencarian
                            </button>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-sm btn-block btn-primary btn-round" data-toggle="modal" data-target="#ModalTambahbantuan">
                                <i class="ti ti-plus"></i> Buat Bantuan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-9" id="TabelBantuan">

    </div>
</div>