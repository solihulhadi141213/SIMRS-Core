<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">
                        <a href="" class="h5">
                            <i class="ti ti-pencil"></i>Tambahkan Signature
                        </a>
                    </h5>
                    <p class="m-b-0">Tambahkan Tanda Tangan Berdasarkan ID Dokumen</p>
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
                    <div class="col-xl-12 col-md-12">
                        <div class="card table-card">
                            <div class="card-header border-info">
                                <b>Form Tambah Signature</b>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="signature">Tanda Tangan Disini</label>
                                        <canvas id="signature-pad" class="signature-pad" width="100%">

                                        </canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="button" class="btn btn-success" id="change-color">
                                    Change Color
                                </button>
            
                                <!-- tombol undo  -->
                                <button type="button" class="btn btn-dark" id="undo">
                                    <span class="fas fa-undo"></span>
                                    Undo
                                </button>
            
                                <!-- tombol hapus tanda tangan  -->
                                <button type="button" class="btn btn-danger" id="clear">
                                    <span class="fas fa-eraser"></span>
                                    Clear
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="styleSelector">

        </div>
    </div>
</div>