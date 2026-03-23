<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="row">
                    <div class="col-xl-3 col-md-3">
                        <form action="javascript:void(0);" id="ProsesFilterPasienShk">
                            <div class="card mb-2">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <h4 id="TitleHalaman">
                                                <i class="ti ti-filter"></i> Filter & Pencarian
                                            </h4>
                                        </div>
                                    </div>
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
                                                <option value="">ALL</option>
                                                <option value="id_shk">ID SHK</option>
                                                <option value="id_pasien_ibu">NO.RM Ibu</option>
                                                <option value="id_pasien_anak">NO.RM Anak</option>
                                                <option value="nama_ibu">Nama Ibu</option>
                                                <option value="nama_anak">Nama Anak</option>
                                                <option value="nik_ibu">NIK Ibu</option>
                                                <option value="nik_anak">NIK Anak</option>
                                                <option value="tgllahir">Tanggal Lahir</option>
                                                <option value="gender_anak">Gender Anak</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-12" id="FormFilter">
                                            <label for="keyword">Kata Kunci</label>
                                            <input type="text" name="keyword" id="keyword" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <button type="submit" class="btn btn-md btn-block btn-info">
                                                <i class="ti ti-search"></i> Cari
                                            </button>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <button type="button" class="btn btn-md btn-block btn-primary" data-toggle="modal" data-target="#ModalTambahPasienShk">
                                                <i class="ti ti-plus"></i> Tambah Pasien SHK
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-xl-9 col-md-9">
                        <div class="card mb-2">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <h4 id="TitleHalaman">
                                            <i class="ti ti-server"></i> Pasian SHK
                                        </h4>
                                    </div>
                                </div>
                            </div>
                            <div id="MenampilkanTabelPasienShk">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>