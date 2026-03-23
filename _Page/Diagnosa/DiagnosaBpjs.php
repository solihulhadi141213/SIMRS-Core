<?php
    $StatusAkses=GetStatusAccess($Conn,$SessionIdAkses,'Y0Z0rA6w74');
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
                                            <h4><i class="ti ti-search"></i> Pencarian Diagnosa (BPJS)</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <form action="javascript:void(0);" id="BatasPencarianDiagnosaBpjs">
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <select name="kategori" id="kategori" class="form-control">
                                                    <option value="Diagnosa">Diagnosa</option>
                                                    <option value="Procedur">Procedur</option>
                                                </select>
                                                <small>Kategori Pencarian</small>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <input type="text" class="form-control" name="keyword" id="keyword" placeholder="Kata Kunci">
                                                <small>
                                                    Masukan kode atau nama diagnosa/procedur
                                                </small>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <button type="submit" class="btn btn-sm btn-secondary btn-block">
                                                    <i class="ti ti-search"></i> Mulai Pencarian
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
                                            <h4><i class="fa fa-book"></i> Diagnosa (BPJS)</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body" id="MenampilkanDataBpjs">
                                    <div class="row">
                                        <div class="col-md-12 text-center text-danger mb-3">
                                            Belum Ada Hasil Pencarian Yang Ditampilkan
                                        </div>
                                    </div>
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