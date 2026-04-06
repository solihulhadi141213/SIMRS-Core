<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">
                        <a href="index.php?Page=Profile" class="h5">
                            <i class="bi bi-person-circle"></i> My Profile
                        </a>
                    </h5>
                    <p class="m-b-0">Kelola informasi akses, identitas dan riwayat aktivitas anda</p>
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
                    <div class="col-md-4 mb-3 d-flex">
                        <div class="card w-100">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-12 text-center">
                                        <h4>
                                            <i class="bi bi-person-circle"></i> Profil Pengguna
                                        </h4>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body" id="content_my_profile">
                                <!-- Konten Profil Saya Akan Tampil Disini -->
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3 d-flex">
                        <div class="card w-100">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-6">
                                        <span class="card-title"># Ijin Akses</span>
                                    </div>
                                    <div class="col-6 text-right icon-btn">
                                        <button type="button" class="btn btn-sm btn-icon btn-secondary modal_filter_ijin_akses">
                                            <i class="bi bi-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table table-responsive">
                                    <table class="table table-hover table-sm">
                                        <thead>
                                            <tr>
                                                <td align="center">No</td>
                                                <td align="center">Kategori Fitur</td>
                                                <td align="center">Rules</td>
                                            </tr>
                                        </thead>
                                        <tbody id="tabel_ijin_akses">
                                            <!-- Konten Ijin Akses Akan Tampil Disini -->
                                            <tr>
                                                <td align="center" colspan="3">
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
                                        <small class="text-secondary" id="page_info_ijin_akses">0 / 0</small>
                                    </div>
                                    <div class="col-6 text-right icon-btn">
                                        <button type="button" class="btn btn-sm btn-icon btn-outline-secondary" id="prev_btn_ijin_akses">
                                            <i class="bi bi-chevron-left"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-icon btn-outline-secondary" id="next_btn_ijin_akses">
                                            <i class="bi bi-chevron-right"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3 d-flex">
                        <div class="card w-100">
                            <div class="card-header border-0">
                                <div class="row">
                                    <div class="col-12 text-center">
                                        <h4>
                                            <i class="bi bi-send"></i> Laporan Kesalahan
                                        </h4>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="alert alert-warning d-flex align-items-center">
                                            <small>
                                                Apabila anda menemukan kesalahan pada aplikasi dan memerlukan tindak lanjut cepat dari admin, silahkan isi form berikut ini.
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <button type="button" class="btn btn-md btn-primary w-100 btn-round kirim_laporan_pengguna">
                                            <i class="bi bi-plus"></i> Kirim Laporan Kesalahan
                                        </button>
                                    </div>
                                </div>
                                <input type="hidden" name="page" id="page_laporan_kesalahan">
                                <div class="row">
                                    <div class="col-12" id="TabelLaporanKesalahan">
                                        <!-- Konten Riwayat Laporan Akan Tampil Disini -->
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-6">
                                        <small class="text-secondary" id="page_info_laporan_kesalahan">0 / 0</small>
                                    </div>
                                    <div class="col-6 text-right icon-btn">
                                        <button type="button" class="btn btn-sm btn-icon btn-outline-secondary" id="prev_btn_laporan_kesalahan">
                                            <i class="bi bi-chevron-left"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-icon btn-outline-secondary" id="next_btn_laporan_kesalahan">
                                            <i class="bi bi-chevron-right"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 mb-3 d-flex">
                        <div class="card w-100">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-12 text-center">
                                        <h4 class="card-title">
                                            <i class="bi bi-graph-up"></i> Ringkasan Aktivitas
                                        </h4>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body" id="content_ringkasan_aktivitas">
                                <!-- Konten Ringkasan Aktivitas Akan Tampil Disini -->
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 mb-3 d-flex">
                        <div class="card w-100">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-12 text-center">
                                        <h4 class="card-title">
                                            <i class="bi bi-graph-up"></i> Grafik Aktivitas
                                        </h4>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body" id="grafik_aktivitas">
                                <!-- Grafik Aktivitas Akan Tampil Disini -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
