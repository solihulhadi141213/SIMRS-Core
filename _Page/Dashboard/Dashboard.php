<!-- Page-header start -->
<div class="page-header">
    <div class="page-block">
        <div class="row">
            <div class="col-md-12">
                <a href="" class="text-decoration-none text-white">
                    <h4 class="m-b-10 mb-2" id="step1">Dashboard</h4>
                </a>
                <p class="m-b-0 mb-0 text-white" id="step2">
                    Ringkasan Data dan Informasi Faskes
                </p>
            </div>
        </div>
    </div>
</div>
<!-- Page-header end -->

<div class="pcoded-inner-content">
    <!-- Main-body start -->
    <div class="main-body">
        <div class="page-wrapper">

            <!-- DASHBOARD CARD -->
            <div class="row mb-3">
                <div class="col-xl-3 col-lg-6 col-md-6 mb-3">
                    <div class="card stat-card">
                        <div class="card-body d-flex align-items-center">
                            
                            <!-- ICON -->
                            <div class="stat-icon bg-primary">
                                <i class="bi bi-people"></i>
                            </div>

                            <!-- TEXT -->
                            <div class="ms-3">
                                <h4 class="mb-0 fw-bold" id="jumlah_pasien">0</h4>
                                <small class="text-muted">Jumlah Pasien</small>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 mb-3">
                    <div class="card stat-card">
                        <div class="card-body d-flex align-items-center">
                            
                            <!-- ICON -->
                            <div class="stat-icon bg-info">
                                <i class="bi bi-people"></i>
                            </div>

                            <!-- TEXT -->
                            <div class="ms-3">
                                <h4 class="mb-0 fw-bold" id="jumlah_kunjungan">0</h4>
                                <small class="text-muted">Jumlah Kunjungan</small>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 mb-3">
                    <div class="card stat-card">
                        <div class="card-body d-flex align-items-center">
                            
                            <!-- ICON -->
                            <div class="stat-icon bg-dark">
                                <i class="bi bi-people"></i>
                            </div>

                            <!-- TEXT -->
                            <div class="ms-3">
                                <h4 class="mb-0 fw-bold" id="jumlah_poliklinik">0</h4>
                                <small class="text-muted">Poliklinik</small>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 mb-3">
                    <div class="card stat-card">
                        <div class="card-body d-flex align-items-center">
                            
                            <!-- ICON -->
                            <div class="stat-icon bg-success">
                                <i class="bi bi-people"></i>
                            </div>

                            <!-- TEXT -->
                            <div class="ms-3">
                                <h4 class="mb-0 fw-bold" id="jumlah_bed">0</h4>
                                <small class="text-muted">Tempat Tidur</small>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row d-flex align-items-stretch">

                <!-- PROFIL FASKES -->
                <div class="col-xl-4 col-lg-12 col-md-12 mb-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-12 text-center">
                                    <img class="img-80 img-radius" src="assets/images/<?php echo "$logo"; ?>" alt="User-Profile-Image">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12 text-center border-1 border-bottom border-bottom-default p-4">
                                    <h3>
                                        <?php echo "$hospital_name";?>
                                    </h3>
                                    <span><?php echo "$hospital_address";?></span><br>
                                    <small class="text text-muted">
                                        <i class="bi bi-envelope"></i> <?php echo "$hospital_email";?>
                                    </small>
                                </div>
                            </div>
                            <div class="row mb-2 mt-3">
                                <div class="col-5"><small>Kontak</small></div>
                                <div class="col-1"><small>:</small></div>
                                <div class="col-6"><small class="text text-muted"><?php echo "$hospital_contact";?></small></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-5"><small>Kode Faskes</small></div>
                                <div class="col-1"><small>:</small></div>
                                <div class="col-6"><small class="text text-muted"><?php echo "$hospital_code";?></small></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-5"><small>Manajer / Direktur</small></div>
                                <div class="col-1"><small>:</small></div>
                                <div class="col-6"><small class="text text-muted"><?php echo "$hospital_manager";?></small></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-5"><small>Nama Aplikasi</small></div>
                                <div class="col-1"><small>:</small></div>
                                <div class="col-6"><small class="text text-muted"><?php echo "$aplication_name";?></small></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-5"><small>Author</small></div>
                                <div class="col-1"><small>:</small></div>
                                <div class="col-6"><small class="text text-muted"><?php echo "$aplication_author";?></small></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-5"><small>Base URL</small></div>
                                <div class="col-1"><small>:</small></div>
                                <div class="col-6"><small class="text text-muted"><?php echo "$base_url";?></small></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- GRAFIK -->
                <div class="col-xl-8 col-lg-12 col-md-12 mb-3">
                    <div class="card h-100">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-12 text-end">
                                    <div class="icon icon-btn">
                                        <button type="button" class="btn btn-md btn-outline-secondary btn-icon ganti_periode_grafik">
                                            <i class="bi bi-filter"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body" id="GrafikPasien">
                            <!-- Menampilkan Grafik -->
                        </div>
                    </div>
                </div>

            </div>

            <div class="row d-flex align-items-stretch">
                <div class="col-xl-8">
                    <div class="card h-100">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-10">
                                    <b class="card-title"># Pasien Belum Pulang <i>(Existing)</i></b>
                                </div>
                                <div class="col-2 text-right icon-btn">
                                    <button type="button" class="btn btn-md btn-outline-secondary btn-icon filter_pasien_existing">
                                        <i class="bi bi-filter"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <di class="table table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <td class="text-center"><b>No</b></td>
                                            <td class="text-center"><b>RM</b></td>
                                            <td class="text-center"><b>Nama</b></td>
                                            <td class="text-center"><b>Tanggal</b></td>
                                            <td class="text-center"><b>Kujungan</b></td>
                                        </tr>
                                    </thead>
                                    <tbody id="TabelPasienExisting">
                                        <tr>
                                            <td colspan="7" class="text-center">
                                                <small>No Data</small>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </di>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-6">
                                    <small id="page_info">Page 0 Of 0 </small>
                                </div>
                                <div class="col-6 text-right icon-btn">
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
                <div class="col-xl-4">
                    <div class="card h-100">
                        <div class="card-header">
                            <b class="card-title"># Aplikasi Terhubung Lainnya</b>
                        </div>
                        <div class="card-body">
                            <div class="list-group">

                                <a href="https://satusehat.kemkes.go.id/platform" target="_blank" class="list-group-item list-group-item-action" aria-current="true">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1 text-primary">SATUSEHAT</h5>
                                    </div>
                                    <p class="mb-1">
                                       <small>
                                            Platform penghubung berbagai sistem informasi kesehatan melalui standardisasi dan integrasi rekam medis elektronik (RME)
                                       </small>
                                    </p>
                                </a>
                                <a href="https://sirs.kemkes.go.id" target="_blank" class="list-group-item list-group-item-action" aria-current="true">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1 text-primary">SIRS Online</h5>
                                    </div>
                                    <p class="mb-1">
                                       <small>
                                            SIRS Online adalah sistem informasi pelaporan berbasis web dari fasilitas kesehatan kepada 
                                            Kementerian Kesehatan untuk mengumpulkan, mengolah, dan menyajikan data Rumah Sakit di Indonesia secara real-time
                                       </small>
                                    </p>
                                </a>
                                <a href="http://182.253.36.132/rms" target="_blank" class="list-group-item list-group-item-action" aria-current="true">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1 text-primary">Radix</h5>
                                    </div>
                                    <p class="mb-1">
                                       <small>
                                            Radix adalah aplikasi **Radiology Management System (RMS)** yang dirancang untuk membantu pengelolaan layanan radiologi 
                                            secara terintegrasi, aman, dan efisien. Aplikasi ini mendukung koneksi dengan berbagai sistem eksternal seperti **SIMRS**, 
                                            **SATU SEHAT**, dan **PACS**, sehingga memudahkan pertukaran data klinis dan operasional radiologi.
                                       </small>
                                    </p>
                                </a>
                                <a href="http://localhost/Analyza" target="_blank" class="list-group-item list-group-item-action" aria-current="true">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1 text-primary">Analyza</h5>
                                    </div>
                                    <p class="mb-1">
                                       <small>
                                            Analyza adalah Aplikasi microservice berbasis web untuk pelayanan laboratorium pada SIMRS rumah sakit. 
                                       </small>
                                    </p>
                                </a>
                                <a href="http://localhost/Analyza" target="_blank" class="list-group-item list-group-item-action" aria-current="true">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1 text-primary">Email Gateway</h5>
                                    </div>
                                    <p class="mb-1">
                                       <small>
                                            Email Gateway adalah API service yang memudahkan pengiriman Email melalui SMTP 
                                       </small>
                                    </p>
                                </a>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            
        </div>
    </div>
</div>