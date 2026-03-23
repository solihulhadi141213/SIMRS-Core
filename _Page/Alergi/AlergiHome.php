<?php
    $StatusAkses=GetStatusAccess($Conn,$SessionIdAkses,'ZBUYol0ySM');
    if($StatusAkses=="Yes"){
?>
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <h4><i class="icofont-dna-alt-1"></i> Alergi</h4>
                                            Referensi code system alergi dari berbagai sumber referensi.
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <button type="button" class="btn btn-sm btn-block btn-secondary" data-toggle="modal" data-target="#ModalFilterAlergi">
                                                <i class="ti-filter"></i> Filter
                                            </button>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <button type="button" class="btn btn-sm btn-block btn-primary" data-toggle="modal" data-target="#ModalTambahhAlergi">
                                                <i class="ti ti-plus"></i> Tambah
                                            </button>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <button type="button" class="btn btn-sm btn-block btn-success" data-toggle="modal" data-target="#ModalImportAlergi">
                                                <i class="ti ti-import"></i> Import
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div id="TabelAlergi">
                                    
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