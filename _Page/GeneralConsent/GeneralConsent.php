<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="page-header-title">
                    <h5 class="m-b-10">
                        <a href="" class="h5"><i class="bi bi-file-earmark-medical"></i> <i>General Consent</i></a>
                    </h5>
                    <p class="m-b-0"><i>General Consent</i> adalah persetujuan umum yang diberikan oleh pasien atau keluarga pasien kepada fasilitas pelayanan kesehatan sebelum dilakukan pelayanan medis maupun administratif.</p>
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
                
                <!-- TABEL VIEW -->
                <div id="table_view">
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="card w-100">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-6">
                                            <b><i>General Consent</i> - Kunjungan</b>
                                        </div>
                                        <div class="col-6 text-end icon-btn">
                                            <button type="button" class="btn btn-md btn-icon btn-outline-dark" data-bs-toggle="modal" data-bs-target="#ModalDownload" title="Download Diagnosis">
                                                <i class="bi bi-download"></i>
                                            </button>
                                            <button type="button" class="btn btn-md btn-icon btn-outline-primary" data-bs-toggle="modal" data-bs-target="#ModalFilter" title="Filter Data">
                                                <i class="bi bi-filter"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle">
                                            <thead>
                                                <tr>
                                                    <td align="center" class="align-middle"><small><b>No</b></small></td>
                                                    <td align="left" class="align-middle"><small><b>Nama</b></small></td>
                                                    <td align="left" class="align-middle"><small><b>RM</b></small></td>
                                                    <td align="left" class="align-middle"><small><b>Tanggal</b></small></td>
                                                    <td align="left" class="align-middle"><small><b>Tujuan</b></small></td>
                                                    <td align="left" class="align-middle"><small><b>Poli</b></small></td>
                                                    <td align="left" class="align-middle"><small><b>Kelas</b></small></td>
                                                    <td align="center"><small><b>General Consent</b></small></td>
                                                    <td align="center"><small><b><i>ID Consent</i></b></small></td>
                                                </tr>
                                            </thead>
                                            <tbody id="tabel_general_consent">
                                                <!-- Baris Tabel Akan Tampil Disini -->
                                                <tr>
                                                    <td align="center" colspan="9">
                                                        <small class="text text-muted">No Data</small>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-6">
                                            <small id="page_info">0 / 0</small>
                                        </div>
                                        <div class="col-6 text-end icon-btn">
                                            <button type="button" class="btn btn-sm btn-icon btn-outline-secondary" id="previous_page">
                                                <i class="bi bi-chevron-left"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-icon btn-outline-secondary" id="next_page">
                                                <i class="bi bi-chevron-right"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Form View -->
                <div id="form_view">
                    <div class="row mb-3">
                        <div class="col-12">
                            
                            <form action="javascript:void(0);" id="ProsesTambahGeneralConsent">
                                <div class="card w-100">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-8">
                                                <b class="card-title">
                                                    <i class="bi bi-plus"></i> Form <i>General Consent</i>
                                                </b>
                                            </div>
                                            <div class="col-4 text-end icon-btn">
                                                <button type="button" class="btn btn-md btn-icon btn-dark button_kembali" title="Kembali">
                                                    <i class="bi bi-chevron-left"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        
                                        <div class="row mb-3">
                                            <div class="col-12" id="FormTambahGeneralConsent">
                                                <!-- Form Tambah General Consent Akan Muncul Disini -->
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-12" id="NotifikasiTambahGeneralConsent">
                                                <!-- Notifikasi Tambah General Consent Akan Muncul Disini -->
                                            </div>
                                        </div>

                                    </div>
                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-md btn-primary rounded-2 w-100">
                                                    <i class="bi bi-save"></i> Simpan
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Detail View -->
                <div id="detail_view">
                    <div class="row mb-3">
                        <div class="col-12">
                            <form action="javascript:void(0);" id="ProsesCetakGeneralConsent">
                                <div class="card w-100">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-8">
                                                <b class="card-title">
                                                    <i class="bi bi-info-circle"></i> Detail <i>General Consent</i>
                                                </b>
                                            </div>
                                            <div class="col-4 text-end icon-btn">
                                                <button type="button" class="btn btn-md btn-icon btn-dark button_kembali" title="Kembali">
                                                    <i class="bi bi-chevron-left"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        
                                        <div class="row mb-3">
                                            <div class="col-12" id="FormDetailGeneralConsent">
                                                <!-- Form Tambah General Consent Akan Muncul Disini -->
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-md btn-primary rounded-2">
                                                    <i class="bi bi-printer"></i> Cetak
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>
