<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="page-header-title">
                    <h5 class="m-b-10">
                        <a href="" class="h5"><i class="bi bi-calendar"></i> Jadwal Dokter</a>
                    </h5>
                    <p class="m-b-0">Kelola Jadwal Praktek Dokter</p>
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
                <div class="row mb-2">
                    <div class="col-12" id="show_error_notification">
                        <!-- Apabila Ada Kesalahan Pada Saat Menghiutng Data Jadwal Per Hari Maka Akan Ditampilkan Disini -->
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-2 text-right">
                                        <button type="button" class="btn btn-sm btn-outline-secondary m-1 rounded-2 w-100"  data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-three-dots"></i> HFIZ
                                        </button>
                                        <ul class="dropdown-menu shadow">
                                            <li>
                                                <a href="javascript:void(0);" class="dropdown-item modal_jadwal_hfiz">
                                                    <i class="bi bi-info-circle"></i> Lihat Jadwal HFIZ
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);" class="dropdown-item modal_update_jadwal_hfiz">
                                                    <i class="bi bi-send"></i> Update Jadwal HFIZ
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-10">
                                        <button type="button" class="btn btn-sm btn-outline-secondary m-1 rounded-2 pilih_hari" id="button_senin" data-id="Senin">
                                            Senin
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary m-1 rounded-2 pilih_hari" id="button_selasa" data-id="Selasa">
                                            Selasa
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary m-1 rounded-2 pilih_hari" id="button_rabu" data-id="Rabu">
                                            Rabu
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary m-1 rounded-2 pilih_hari" id="button_kamis" data-id="Kamis">
                                            Kamis
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary m-1 rounded-2 pilih_hari" id="button_jumat" data-id="Jumat">
                                            Jumat
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary m-1 rounded-2 pilih_hari" id="button_sabtu" data-id="Sabtu">
                                            Sabtu
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary m-1 rounded-2 pilih_hari" id="button_minggu" data-id="Minggu">
                                            Minggu
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- DATA -->
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="card w-100">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-12 text-end icon-btn">
                                        <button type="button" class="btn btn-md btn-icon btn-primary" data-bs-toggle="modal" data-bs-target="#ModalTambahJadwal" title="Tambah Jadwal Dokter">
                                            <i class="bi bi-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table table-responsive">
                                    <table class="table table-hover table-sm">
                                        <thead>
                                            <tr>
                                                <td align="center"><small><b>No</b></small></td>
                                                <td align="left"><small><b>Dokter</b></small></td>
                                                <td align="left"><small><b>Poliklinik</b></small></td>
                                                <td align="left"><small><b>Mulai</b></small></td>
                                                <td align="left"><small><b>Selesai</b></small></td>
                                                <td align="left"><small><b>BPJS</b></small></td>
                                                <td align="left"><small><b>Umum</b></small></td>
                                                <td align="center"><small><b>Status</b></small></td>
                                                <td align="center"><small><b>Opsi</b></small></td>
                                            </tr>
                                        </thead>
                                        <tbody id="tabel_jadwal_dokter">
                                            <!-- Konten Google Credential Akan Tampil Disini -->
                                            <tr>
                                                <td align="center" colspan="8">
                                                    <small class="text text-muted">No Data</small>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-12">
                                        <small id="page_info">Data : 0 Record</small>
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
