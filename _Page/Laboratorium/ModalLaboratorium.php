<!-- Filter Data -->
<div class="modal fade" id="ModalFilter" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesFilter" autocomplete="off">
                <input type="hidden" name="page" id="page_filter" value="1">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-funnel"></i> Filter Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="limit">
                                <small>Batas/Limit</small>
                            </label>
                        </div>
                        <div class="col-8">
                            <select name="limit" id="limit" class="form-control">
                                <option value="5">5</option>
                                <option selected value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                                <option value="250">250</option>
                                <option value="500">500</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="order_by">
                                <small>Order By</small>
                            </label>
                        </div>
                        <div class="col-8">
                            <select name="order_by" id="order_by" class="form-control">
                                <option value="">Pilih</option>
                                <option value="id_pasien">No.RM</option>
                                <option value="nama">Nama Pasien</option>
                                <option value="prioritas">Prioritas</option>
                                <option value="datetime_diminta">Tanggal Permintaan</option>
                                <option value="nama_dokter_pengirim">Dokter Pengirim</option>
                                <option value="priority">Perioritas</option>
                                <option value="status">Status</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="short_by">
                                <small>Short By</small>
                            </label>
                        </div>
                        <div class="col-8">
                            <select name="short_by" id="short_by" class="form-control">
                                <option value="ASC">A To Z</option>
                                <option selected value="DESC">Z To A</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="keyword_by">
                                <small>Dasar Pencarian</small>
                            </label>
                        </div>
                        <div class="col-8">
                            <select name="keyword_by" id="keyword_by" class="form-control">
                               <option value="">Pilih</option>
                                <option value="id_pasien">No.RM</option>
                                <option value="nama">Nama Pasien</option>
                                <option value="prioritas">Prioritas</option>
                                <option value="datetime_diminta">Tanggal Permintaan</option>
                                <option value="nama_dokter_pengirim">Dokter Pengirim</option>
                                <option value="priority">Perioritas</option>
                                <option value="status">Status</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="keyword_form">
                                <small>Kata Kunci</small>
                            </label>
                        </div>
                        <div class="col-8" id="FormFilter">
                            <input type="text" name="keyword" id="keyword_form" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-rounded">
                        <i class="bi bi-check"></i> Tampilkan
                    </button>
                    <button type="button" class="btn btn-secondary btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--- Modal Pasien --->
<div class="modal fade" id="ModalPasien" tabindex="-1" aria-labelledby="ModalPasien" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-list"></i> Pilih Pasien</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
                <div class="row mb-3">
                    <div class="col-12">
                        <form action="javascript:void(0);" id="PencarianPasien" autocomplete="off">
                            <input type="hidden" name="page" id="page_pasien" value="1">
                            <div class="input-group">
                                <input type="text" name="keyword" id="keyword_pasien" class="form-control" placeholder="Cari Pasien">
                                <button type="submit" class="btn btn-md btn-primary">
                                    <i class="bi bi-search"></i> Cari
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="table table-responsive">
                            <table class="table table-hover table-sm">
                                <thead>
                                    <tr>
                                        <th><b><small>No</small></b></th>
                                        <th><b><small>RM</small></b></th>
                                        <th><b><small>Nama</small></b></th>
                                        <th><b><small>Gender</small></b></th>
                                        <th><b><small>Tgl.Lahir</small></b></th>
                                        <th><b><small>IHS</small></b></th>
                                    </tr>
                                </thead>
                                <tbody id="tabel_pasien">
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            <small class="text-muted">No Data</small>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                   <div class="col-6">
                        <small id="page_info_pasien">Page 1 Of 1</small>
                    </div>
                    <div class="col-6 text-end icon-btn">
                        <button type="button" class="btn btn-sm btn-icon btn-outline-secondary" id="prev_button_pasien">
                            <i class="bi bi-chevron-left"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-icon btn-outline-secondary" id="next_button_pasien">
                            <i class="bi bi-chevron-right"></i>
                        </button>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-inverse ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!--- Modal Kunjungan --->
<div class="modal fade" id="ModalKunjungan" tabindex="-1" aria-labelledby="ModalKunjungan" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-list"></i> Pilih Kunjungan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form action="javascript:void(0);" id="FilterKunjungan" autocomplete="off">
                    <input type="hidden" name="page" id="page_kunjungan" value="1">
                    <input type="hidden" name="id_pasien" id="put_id_pasien" value="">
                </form>
                
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="table table-responsive">
                            <table class="table table-hover table-sm">
                                <thead>
                                    <tr>
                                        <th><b><small>No</small></b></th>
                                        <th><b><small>Tanggal</small></b></th>
                                        <th><b><small>REG</small></b></th>
                                        <th><b><small>Tujuan</small></b></th>
                                        <th><b><small>Pembayaran</small></b></th>
                                        <th><b><small>Poli/Ruangan</small></b></th>
                                        <th><b><small>ID Encounter</small></b></th>
                                    </tr>
                                </thead>
                                <tbody id="tabel_kunjungan">
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            <small class="text-muted">No Data</small>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                   <div class="col-6">
                        <small id="page_info_kunjungan">Page 1 Of 1</small>
                    </div>
                    <div class="col-6 text-end icon-btn">
                        <button type="button" class="btn btn-sm btn-icon btn-outline-secondary" id="prev_button_kunjungan">
                            <i class="bi bi-chevron-left"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-icon btn-outline-secondary" id="next_button_kunjungan">
                            <i class="bi bi-chevron-right"></i>
                        </button>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-inverse ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!--- Modal Dokter --->
<div class="modal fade" id="ModalDokter" tabindex="-1" aria-labelledby="ModalDokter" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-list"></i> Pilih Dokter</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form action="javascript:void(0);" id="PencarianDokter" autocomplete="off">
                    <input type="hidden" name="page" id="page_dokter" value="1">
                    <div class="input-group">
                        <input type="text" name="keyword" id="keyword_dokter" class="form-control" placeholder="Cari Dokter">
                        <button type="submit" class="btn btn-md btn-primary">
                            <i class="bi bi-search"></i> Cari
                        </button>
                    </div>
                </form>
                
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="table table-responsive">
                            <table class="table table-hover table-sm">
                                <thead>
                                    <tr>
                                        <th><b><small>No</small></b></th>
                                        <th><b><small>Nama Dokter</small></b></th>
                                        <th><b><small>Kode</small></b></th>
                                        <th><b><small>ID IHS</small></b></th>
                                    </tr>
                                </thead>
                                <tbody id="tabel_dokter">
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            <small class="text-muted">No Data</small>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                   <div class="col-6">
                        <small id="page_info_dokter">Page 1 Of 1</small>
                    </div>
                    <div class="col-6 text-end icon-btn">
                        <button type="button" class="btn btn-sm btn-icon btn-outline-secondary" id="prev_button_dokter">
                            <i class="bi bi-chevron-left"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-icon btn-outline-secondary" id="next_button_dokter">
                            <i class="bi bi-chevron-right"></i>
                        </button>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-inverse ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!--- Modal Diagnosis --->
<div class="modal fade" id="ModalDiagnosis" tabindex="-1" aria-labelledby="ModalDiagnosis" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-list"></i> Pilih Diagnosis</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form action="javascript:void(0);" id="PencarianDiagnosis" autocomplete="off">
                    <input type="hidden" name="page" id="page_diagnosis" value="1">
                    <div class="input-group">
                        <input type="text" name="keyword" id="keyword_diagnosis" class="form-control" placeholder="Cari Diagnosis">
                        <button type="submit" class="btn btn-md btn-primary">
                            <i class="bi bi-search"></i> Cari
                        </button>
                    </div>
                </form>
                
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="table table-responsive">
                            <table class="table table-hover table-sm">
                                <thead>
                                    <tr>
                                        <th><b><small>No</small></b></th>
                                        <th><b><small>Kode</small></b></th>
                                        <th><b><small>Ind</small></b></th>
                                        <th><b><small>Eng</small></b></th>
                                    </tr>
                                </thead>
                                <tbody id="tabel_diagnosis">
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            <small class="text-muted">No Data</small>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                   <div class="col-6">
                        <small id="page_info_diagnosis">Page 1 Of 1</small>
                    </div>
                    <div class="col-6 text-end icon-btn">
                        <button type="button" class="btn btn-sm btn-icon btn-outline-secondary" id="prev_button_diagnosis">
                            <i class="bi bi-chevron-left"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-icon btn-outline-secondary" id="next_button_diagnosis">
                            <i class="bi bi-chevron-right"></i>
                        </button>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-inverse ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!--- Modal Detail Laboratorium --->
<div class="modal fade" id="ModalDetail" tabindex="-1" aria-labelledby="ModalDetail" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-info-circle"></i> Detail Laboratorium</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
                <div class="row">
                    <div class="col-12" id="FormDetail">
                        <!-- Form Detail Akan Muncul Disini -->
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-inverse ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>