<?php
    //Desiossion Akses
    $StatusAkses=GetStatusAccess($Conn,$SessionIdAkses,'p4TSzoYi1p');
    if($StatusAkses=="Yes"){
?>
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">
                            <a href="" class="h5"><i class="icofont-book-alt"></i> Akun Perkiraan</a>
                        </h5>
                        <p class="m-b-0">
                            Halaman ini digunakan untuk mengelola data akun perkiraan saldo normal.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <form action="javascript:void(0);" id="BatasPencarian">
                                        <input type="hidden" name="page" id="page">
                                        <div class="row">
                                            <div class="col-md-4 mb-2">
                                                <h4 class="card-title">
                                                    <i class="icofont-ui-file"></i> List Akun Perkiraan
                                                </h4>
                                            </div>
                                            <div class="col-md-2">
                                                <select name="batas" id="batas" class="form-control">
                                                    <option value="5">5</option>
                                                    <option selected value="10">10</option>
                                                    <option value="25">25</option>
                                                    <option value="50">50</option>
                                                    <option value="100">100</option>
                                                </select>
                                                <small>Batas</small>
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="keyword" id="keyword" placeholder="Kode/Nama Akun Perkiraan">
                                                    <button type="submit" class="btn btn-sm btn-secondary">
                                                        <i class="ti ti-search"></i> Cari
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-md-2 mb-2">
                                                <button type="button" class="btn btn-primary btn-sm btn-block"  data-toggle="modal" data-target="#ModalTambahAkunPerkiraan">
                                                    <i class="ti ti-plus"></i> Akun Utama
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div id="MenampilkanTabelAkunPerkiraan"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
    }else{
        include "_Page/UnPage/ErrorPage.php";
    }
?>