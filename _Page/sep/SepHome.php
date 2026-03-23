<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="row">
                    <div class="col-xl-4 col-md-12">
                        <div class="card mb-2">
                            <div class="card-body">
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-sm btn-primary btn-block" data-toggle="modal" data-target="#ModalBuatSep">
                                        <i class="ti-plus text-white"></i> Buat SEP
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-2">
                            <div class="card-header">
                                <h4>
                                    <i class="icofont-search-document"></i> Pencarian SEP
                                </h4>
                            </div>
                            <div class="card-body">
                                <form action="javascript:void(0);" id="ProsesPencarianSep">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="tanggal_sep">Tanggal SEP</label>
                                            <input type="date" name="tanggal_sep" id="tanggal_sep" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label for="jenis_pelayanan">Jenis Pelayanan</label>
                                            <select name="jenis_pelayanan" id="jenis_pelayanan" class="form-control">
                                                <option value="1">Rawat Inap</option>
                                                <option value="2">Rawat Jalan</option>
                                            </select>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <button type="submit" class="btn btn-sm btn-outline-secondary btn-block"><i class="ti-search"></i> Mulai Cari</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card mb-2">
                            <div class="card-body">
                                <form action="javascript:void(0);" id="ProsesPencarianNomorSep">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            Pencarian Berdasarkan Nomor SEP
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="input-group">
                                                <input type="text" name="KeywordNomorSep" id="KeywordNomorSep" class="form-control">
                                                <button type="submit" class="btn btn-sm btn-dark">
                                                    <i class="ti-search"></i> Cari
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8 col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>
                                    <i class="icofont-patient-file"></i> List Data SEP
                                </h4>
                            </div>
                            <div id="MenampilkanTabelSep">
                                <!--  Menampilkan SEP -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>