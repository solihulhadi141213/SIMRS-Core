<!-- Filter Periode Grafik -->
<div class="modal fade" id="ModalFilterPeriodeGrafik" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesFilterPeriodeGrafik" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">
                        <i class="bi bi-calendar"></i> Periode Data
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="periode">Periode</label>
                            <select name="periode" id="periode" class="form-control">
                                <option value="">Pilih</option>
                                <option value="Tahunan">Tahunan</option>
                                <option value="Bulanan">Bulanan</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="tahun">Tahun</label>
                            <select name="tahun" id="tahun" class="form-control">
                                <option value="">Pilih</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="bulan">Bulan</label>
                            <select name="bulan" id="bulan" class="form-control">
                                <option value="">Pilih</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary btn-rounded">
                        <i class="bi bi-save"></i> Tampilkan
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Filter Pasien Existing -->
<div class="modal fade" id="ModalPasienExisting" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesFilterPasienExisting" autocomplete="off">
                <input type="hidden" name="page" id="page" value="1">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">
                        <i class="bi bi-filter"></i> Filter Data
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-5">
                            <label for="limit">Batas</label>
                        </div>
                        <div class="col-1">:</div>
                        <div class="col-6">
                            <select name="limit" id="limit" class="form-control">
                                <option value="10">10</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5">
                            <label for="keyword">Kata Kunci</label>
                        </div>
                        <div class="col-1">:</div>
                        <div class="col-6">
                            <input type="text" name="keyword" id="keyword" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary btn-rounded">
                        <i class="bi bi-filter"></i> Tampilkan
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!---Modal Dashboard Antrian---->
<div class="modal fade" id="ModalDashboardAntiran" tabindex="-1" role="dialog" aria-labelledby="ModalDashboardAntiran" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-inverse">
                <b cass="text-light"><i class="ti-file"></i> Ringkasan Data Surat Menyurat</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="javascript:void(0);" method="POST" id="ProsesDashboardAntrianOnline" autocomplete="off">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="">Mode Data</label>
                            <select name="mode" id="mode" class="form-control">
                                <option value="">pilih</option>
                                <option value="Harian">Harian</option>
                                <option value="Bulanan">Bulanan</option>
                            </select>
                        </div>
                    </div>
                    <div id="FormLanjutan">
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            Silahkan pilih mode data dan keterangan waktu
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-inverse">
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-md btn-primary mr-2 mt-2" id="TampilkanDataAntrian">
                                <i class="ti-file"></i> Tampilkan
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
