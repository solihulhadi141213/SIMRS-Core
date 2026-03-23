<script>
    
</script>
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-4">
                <div class="page-header-title">
                    <h5 class="m-b-10">
                        <a href="index.php?Page=Rujukan" class="h5">
                            <i class="icofont-letter"></i> Rujukan Pasien
                        </a>
                    </h5>
                    <p class="m-b-0">Kelola Data Rujukan Pasien</p>
                </div>
            </div>
            <div class="col-md-8 text-right">
                <a href="index.php?Page=Rujukan" class="btn btn-md btn-primary btn-round mr-2 mt-2">
                    <i class="ti ti-info text-white"></i> Info
                </a>
                <a href="index.php?Page=Rujukan&Sub=RujukanInternal" class="btn btn-md btn-primary btn-round mr-2 mt-2">
                    <i class="icofont-database"></i> Internal
                </a>
                <a href="index.php?Page=Rujukan&Sub=RujukanBpjs" class="btn btn-md btn-primary btn-round mr-2 mt-2">
                    <i class="icofont-share"></i> BPJS
                </a>
                <a href="index.php?Page=Rujukan&Sub=RujukanKhusus" class="btn btn-md btn-inverse btn-round mr-2 mt-2">
                    <i class="icofont-star"></i> Khusus
                </a>
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
                            <form action="javascript:void(0);" id="ProsesBuatRujukanKhusus" autocomplete="off">
                                <div class="card-header border-info">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h4>
                                                <i class="icofont-file-document"></i> Form Buat Rujukan Khusus
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3 mt-3">
                                            <input type="text" class="form-control" name="NoRujukan" id="NoRujukan" data-toggle="modal" data-target="#ModalCariRujukan">
                                            <small><dt>No.Rujukan</dt></small>
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <select name="kategori" id="kategori" class="form-control">
                                                <option value="Diagnosa Primer">Diagnosa Primer</option>
                                                <option value="Diagnosa Sekunder">Diagnosa Sekunder</option>
                                                <option value="Procedure">Procedure</option>
                                            </select>
                                            <small><dt>Kategori</dt></small>
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <input type="text" class="form-control" name="kode" id="kode" data-toggle="modal" data-target="#ModalCariDiagnosaProcedur">
                                            <small id="NotifikasiTambahDiagnosaSekarang"><dt>Kode Diagnosa/Procedur</dt></small>
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <button type="button" class="btn btn-sm btn-outline-primary" id="ClickTambahDiagnosaSekarang">
                                                <i class="ti ti-plus"></i> Add
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-primary" id="ClickTampilkanDiagnosaDanProcedur">
                                                <i class="ti ti-angle-double-down"></i> View
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mt-3" id="NotifikasiBuatRujukan">
                                            <div class="table table-responsive pre-scrollable">
                                                <table class="table table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <td class="text-center"><dt>No</dt></td>
                                                            <td class="text-center"><dt>Kategori</dt></td>
                                                            <td class="text-center"><dt>Kode</dt></td>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="TampilkanDataDiagnosaDanProcedur">
                                                        <tr>
                                                            <td class="text-center text-danger" colspan="3">
                                                                <dt>Keterangan</dt>
                                                                Pastikan data rujukan yang anda buat sudah sesuai!
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mt-3" id="NotifikasiBuatRujukanKhusus">
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-grd-primary btn-round mt-2 mr-2">
                                                <i class="icofont-send-mail"></i> Buat Rujukan
                                            </button>
                                            <button type="submit" class="btn btn-grd-warning btn-round mt-2 mr-2">
                                                <i class="ti ti-reload"></i> Reset
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="styleSelector">

        </div>
    </div>
</div>
