<div class="dashboard-view">
    <div class="page-header dashboard-page-header">
        <div class="dashboard-heading">
            <a href="index.php" class="dashboard-title-link">
                <h4 class="mb-0"><i class="bi bi-grid" aria-hidden="true"></i> Dashboard</h4>
            </a>
            <p class="mb-0">Ringkasan data dan informasi faskes</p>
        </div>
        <nav aria-label="Breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="index.php">Beranda</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
        </nav>
    </div>

    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="row g-3 dashboard-content">
                    <div class="col-12 col-xl-9">
                        <div class="row g-3">
                            <div class="col-12 col-lg-6">
                                <?php
                                    $dashboardLogoName = basename((string) ($logo ?? ''));
                                    $dashboardLogoPath = 'assets/img/logo/no-image.jpg';
                                    if ($dashboardLogoName !== '') {
                                        if (is_file(__DIR__ . '/../../assets/img/logo/' . $dashboardLogoName)) {
                                            $dashboardLogoPath = 'assets/img/logo/' . rawurlencode($dashboardLogoName);
                                        } elseif (is_file(__DIR__ . '/../../assets/images/' . $dashboardLogoName)) {
                                            $dashboardLogoPath = 'assets/images/' . rawurlencode($dashboardLogoName);
                                        }
                                    }
                                ?>
                                <section class="card dashboard-faskes-card h-100" aria-labelledby="dashboardFaskesTitle">
                                    <div class="card-body">
                                        <div class="dashboard-faskes-brand">
                                            <img class="dashboard-faskes-logo" src="<?php echo htmlspecialchars($dashboardLogoPath, ENT_QUOTES, 'UTF-8'); ?>" alt="Logo <?php echo htmlspecialchars($hospital_name ?? 'rumah sakit', ENT_QUOTES, 'UTF-8'); ?>">
                                            <div>
                                                <h5 id="dashboardFaskesTitle" class="mb-1"><?php echo htmlspecialchars($hospital_name ?? 'Nama Faskes', ENT_QUOTES, 'UTF-8'); ?></h5>
                                                <p class="mb-0"><?php echo htmlspecialchars($hospital_address ?? '', ENT_QUOTES, 'UTF-8'); ?></p>
                                            </div>
                                        </div>
                                        <div class="dashboard-faskes-details">
                                            <div class="dashboard-faskes-detail">
                                                <span>Direktur / Manajer</span>
                                                <span><?php echo htmlspecialchars($hospital_manager ?? '-', ENT_QUOTES, 'UTF-8'); ?></span>
                                            </div>
                                            <div class="dashboard-faskes-detail">
                                                <span>Kode Faskes</span>
                                                <span><?php echo htmlspecialchars($hospital_code ?? '-', ENT_QUOTES, 'UTF-8'); ?></span>
                                            </div>
                                            <div class="dashboard-faskes-detail">
                                                <span>Email</span>
                                                <span><?php echo htmlspecialchars($hospital_email ?? '-', ENT_QUOTES, 'UTF-8'); ?></span>
                                            </div>
                                            <div class="dashboard-faskes-detail">
                                                <span>No.Telepon</span>
                                                <span><?php echo htmlspecialchars($hospital_contact ?? '-', ENT_QUOTES, 'UTF-8'); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>

                            <div class="col-12 col-lg-6">
                                <div class="row g-3 dashboard-donuts">
                                    <div class="col-12 col-sm-6">
                                        <section class="card dashboard-chart-card h-100" aria-labelledby="kategoriPelayananTitle">
                                            <div class="card-body">
                                                <h6 id="kategoriPelayananTitle" class="dashboard-card-title">Kategori Pelayanan</h6>
                                                <div id="ChartKategoriPelayanan" class="dashboard-donut-chart" role="img" aria-label="Grafik kategori pelayanan"></div>
                                            </div>
                                        </section>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <section class="card dashboard-chart-card h-100" aria-labelledby="pembiayaanTitle">
                                            <div class="card-body">
                                                <h6 id="pembiayaanTitle" class="dashboard-card-title">Pembiayaan</h6>
                                                <div id="ChartPembiayaan" class="dashboard-donut-chart" role="img" aria-label="Grafik pembiayaan kunjungan"></div>
                                            </div>
                                        </section>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6 col-md-3">
                                <section class="card dashboard-stat-card h-100">
                                    <div class="card-body">
                                        <span class="dashboard-stat-icon"><i class="bi bi-person-badge" aria-hidden="true"></i></span>
                                        <p class="mb-0">Jumlah Tenaga Dokter</p>
                                        <strong id="jumlah_dokter" aria-live="polite">Memuat...</strong>
                                    </div>
                                </section>
                            </div>
                            <div class="col-6 col-md-3">
                                <section class="card dashboard-stat-card h-100">
                                    <div class="card-body">
                                        <span class="dashboard-stat-icon"><i class="bi bi-hospital" aria-hidden="true"></i></span>
                                        <p class="mb-0">Jumlah Poliklinik</p>
                                        <strong id="jumlah_poliklinik" aria-live="polite">Memuat...</strong>
                                    </div>
                                </section>
                            </div>
                            <div class="col-6 col-md-3">
                                <section class="card dashboard-stat-card h-100">
                                    <div class="card-body">
                                        <span class="dashboard-stat-icon"><i class="bi bi-building" aria-hidden="true"></i></span>
                                        <p class="mb-0">Jumlah Tempat Tidur</p>
                                        <strong id="jumlah_bed" aria-live="polite">Memuat...</strong>
                                    </div>
                                </section>
                            </div>
                            <div class="col-6 col-md-3">
                                <section class="card dashboard-stat-card h-100">
                                    <div class="card-body">
                                        <span class="dashboard-stat-icon"><i class="bi bi-people" aria-hidden="true"></i></span>
                                        <p class="mb-0">Jumlah Data Pasien</p>
                                        <strong id="jumlah_pasien" aria-live="polite">Memuat...</strong>
                                    </div>
                                </section>
                            </div>

                            <div class="col-12">
                                <section class="card dashboard-visits-card" aria-labelledby="dashboardVisitsTitle">
                                    <div class="card-header">
                                        <div>
                                            <h5 id="dashboardVisitsTitle" class="mb-1">Grafik Kunjungan Pasien</h5>
                                            <p id="dashboardVisitsPeriod" class="mb-0">Tahun ini</p>
                                        </div>
                                        <button type="button" class="btn btn-outline-primary btn-sm ganti_periode_grafik" data-bs-toggle="modal" data-bs-target="#ModalFilterPeriodeGrafik">
                                            <i class="bi bi-calendar3 me-1" aria-hidden="true"></i> Periode
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div id="ChartKunjungan" class="dashboard-visits-chart" role="img" aria-label="Grafik jumlah kunjungan pasien"></div>
                                        <div id="GrafikPasien" class="dashboard-chart-error" role="status" aria-live="polite"></div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-xl-3">
                        <section class="card dashboard-existing-card h-100" aria-labelledby="pasienExistingTitle">
                            <div class="card-header">
                                <div>
                                    <h5 id="pasienExistingTitle" class="mb-1">Pasien Existing</h5>
                                    <p class="mb-0">Kunjungan terbaru yang terdaftar</p>
                                </div>
                            </div>
                            <div class="dashboard-existing-list" id="PasienExistingList" aria-live="polite" aria-busy="false">
                                <p class="dashboard-existing-message">Memuat kunjungan...</p>
                            </div>
                            <div id="LoadingPasienExisting" class="dashboard-existing-loading" role="status" aria-live="polite"></div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
