<?php
    $StatusAkses=GetStatusAccess($Conn,$SessionIdAkses,'b8P9QhEMQE');
    if($StatusAkses=="Yes"){
?>
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <h4><i class="ti ti-search"></i> Pencarian Diagnosa (SIMRS)</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <form action="javascript:void(0);" id="BatasPencarianSimrs">
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <select name="batas" id="batas" class="form-control">
                                                    <option value="5">5</option>
                                                    <option selected value="10">10</option>
                                                    <option value="25">25</option>
                                                    <option value="50">50</option>
                                                    <option value="100">100</option>
                                                </select>
                                                <small>Batas Data</small>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <select name="version" id="version" class="form-control">
                                                    <option value="">Semua</option>
                                                    <option value="ICD10">ICD10</option>
                                                    <option value="ICD9">ICD9</option>
                                                </select>
                                                <small>Versi ICD</small>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <input type="text" class="form-control" name="keyword" id="keyword" placeholder="Kata Kunci">
                                                <small>Kata Kunci</small>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <button type="submit" class="btn btn-sm btn-secondary btn-block">
                                                    <i class="ti ti-search"></i> Mulai Pencarian
                                                </button>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <button type="button" class="btn btn-sm btn-primary btn-block" data-toggle="modal" data-target="#ModalTambahDiagnosa">
                                                    <i class="ti-plus text-white"></i> Tambah Diagnosa
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <h4><i class="fa fa-book"></i> Diagnosa (SIMRS)</h4>
                                        </div>
                                    </div>
                                </div>
                                <div id="MenampilkanDataDiagnosa">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php 
    }else{
        include "_Page/UnPage/ErrorPageSub.php";
    }
?>