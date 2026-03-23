<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="row mb-3">
                    <div class="col-md-8 mb-3"></div>
                    <div class="col-md-2 mb-3">
                        <button type="button" class="btn btn-sm btn-block btn-secondary" data-toggle="modal" data-target="#ModalFilter" title="Filter Data Radiologi">
                            <i class="ti ti-filter"></i> Filter
                        </button>
                    </div>
                    <div class="col-md-2 mb-3">
                        <a href="index.php?Page=Radiologi&Sub=TambahRadiologi" class="btn btn-sm btn-block btn-primary" title="Tambah Pendaftaran Radiologi">
                            <i class="ti-plus text-white"></i> Tambah
                        </a>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12" id="ListRadiologi">
                        <!-- Data Radiologi Akan Muncul Disini -->
                         <div class="alert alert-danger text-center">
                            Load Data From Server ..
                         </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 text-center">
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-dark" id="prev_rad">
                                <i class="ti ti-angle-left"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-dark" id="page_info_rad">
                                0 / 0
                            </button>
                            <button type="button" class="btn btn-sm btn-dark" id="next_rad">
                                <i class="ti ti-angle-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>