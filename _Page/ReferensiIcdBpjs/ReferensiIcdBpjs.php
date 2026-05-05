<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="page-header-title">
                    <h5 class="m-b-10">
                        <a href="" class="h5"><i class="bi bi-book"></i> ICD (BPJS)</a>
                    </h5>
                    <p class="m-b-0">Kelola Referensi Diagnosis dan Procedure ICD 9 dan ICD 10 (BPJS)</p>
                </div>
            </div>
            <div class="col-md-4 text-right">
            </div>
        </div>
    </div>
</div>
<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
                
                <!-- DATA -->
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="card w-100">
                            <div class="card-header">
                                <form action="javascript:void(0);" id="ProsesFilterIcdBpjs">
                                    <div class="row">
                                        <div class="col-md-3 mb-2">
                                            <label for="version"><small>Version</small></label>
                                            <select name="version" id="version" class="form-control">
                                                <option value="ICD10">Diagnosis (ICD10)</option>
                                                <option value="ICD9">Procedure (ICD19)</option>
                                            </select>
                                        </div>
                                        <div class="col-md-9 mb-2">
                                            <label for="keyword"><small>Kata Kunci</small></label>
                                            <div class="input-group">
                                                <input type="text" name="keyword" id="keyword" class="form-control" placeholder="Code / Description">
                                                <button type="submit" class="btn btn-sm btn-primary">
                                                    <i class="bi bi-search"></i> Tampilkan
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="card-body">
                                <div class="table table-responsive mb-4">
                                    <table class="table table-hover table-sm">
                                        <thead>
                                            <tr>
                                                <td align="center"><small><b>No</b></small></td>
                                                <td align="left"><small><b>ICD</b></small></td>
                                                <td align="left"><small><b><i>Code</i></b></small></td>
                                                <td align="left"><small><b><i>Description</i></b></small></td>
                                                <td align="center"><small><b>Opsi</b></small></td>
                                            </tr>
                                        </thead>
                                        <tbody id="tabel_icd_bpjs">
                                            <!-- Konten Google Credential Akan Tampil Disini -->
                                            <tr>
                                                <td align="center" colspan="5">
                                                    <small class="text text-muted">No Data</small>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
