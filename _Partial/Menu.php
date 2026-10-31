    <div class="sidebar_toggle">
        <button type="button" class="sidebar-close" data-layout-toggle="sidebar" aria-label="Tutup menu">
            <i class="bi bi-x-lg" aria-hidden="true"></i>
        </button>
    </div>

    <div class="pcoded-inner-navbar main-menu scroll-container">
        <div>
            <div class="main-menu-header">
                <?php
                    $menuLogoName = basename((string) ($logo ?? ''));
                    $menuLogoPath = 'assets/img/logo/no-image.jpg';
                    if ($menuLogoName !== '') {
                        if (is_file(__DIR__ . '/../assets/img/logo/' . $menuLogoName)) {
                            $menuLogoPath = 'assets/img/logo/' . rawurlencode($menuLogoName);
                        } elseif (is_file(__DIR__ . '/../assets/images/' . $menuLogoName)) {
                            $menuLogoPath = 'assets/images/' . rawurlencode($menuLogoName);
                        } elseif (is_file(__DIR__ . '/../_File/Setting/' . $menuLogoName)) {
                            $menuLogoPath = '_File/Setting/' . rawurlencode($menuLogoName);
                        }
                    }
                ?>
                <img class="img-80 img-radius" src="<?php echo htmlspecialchars($menuLogoPath, ENT_QUOTES, 'UTF-8'); ?>" alt="Logo Faskes">
                <div class="user-details">
                    <span id="more-details"><?php echo htmlspecialchars((string) $hospital_name, ENT_QUOTES, 'UTF-8'); ?></span>
                </div>
            </div>
        </div>

        <?php
            $menuSections = [
                [
                    'label' => 'Menu Utama',
                    'items' => [
                        ['label' => 'Dashboard', 'icon' => 'bi-grid', 'url' => 'index.php', 'pages' => ['', 'Dashboard']],
                        ['label' => 'Antrian', 'icon' => 'bi-ticket-perforated', 'url' => 'index.php?Page=Antrian', 'page' => 'Antrian'],
                        ['label' => 'Pasien', 'icon' => 'bi-people', 'url' => 'index.php?Page=Pasien', 'page' => 'Pasien'],
                        ['label' => 'Kunjungan', 'icon' => 'bi-clipboard2-pulse', 'url' => 'index.php?Page=Kunjungan', 'page' => 'Kunjungan'],
                        ['label' => 'Jadwal Dokter', 'icon' => 'bi-calendar', 'url' => 'index.php?Page=ReferensiJadwalDokter', 'page' => 'ReferensiJadwalDokter'],
                    ],
                ],
                [
                    'label' => 'Master Data',
                    'items' => [
                        [
                            'label' => 'Rekam Medis',
                            'icon' => 'bi-clipboard2-check',
                            'children' => [
                                ['label' => 'General Consent', 'url' => 'index.php?Page=GeneralConsent', 'page' => 'GeneralConsent'],
                                ['label' => 'Observasi', 'url' => 'index.php?Page=Observasi', 'page' => 'Observasi'],
                                ['label' => 'Diagnosis', 'url' => 'index.php?Page=Diagnosis', 'page' => 'Diagnosis'],
                                ['label' => 'Tindakan', 'url' => 'index.php?Page=Tindakan', 'page' => 'Tindakan'],
                                ['label' => 'Alergi', 'url' => 'index.php?Page=Alergi', 'page' => 'Alergi'],
                                ['label' => 'Imunisasi', 'url' => 'index.php?Page=Imunisasi', 'page' => 'Imunisasi'],
                                ['label' => 'Episode Perawatan', 'url' => 'index.php?Page=EpisodePerawatan', 'page' => 'EpisodePerawatan'],
                                ['label' => 'Rencana Perawatan', 'url' => 'index.php?Page=RencanaPerawatan', 'page' => 'RencanaPerawatan'],
                                ['label' => 'Laboratorium', 'url' => 'index.php?Page=Laboratorium', 'page' => 'Laboratorium'],
                                ['label' => 'Radiologi', 'url' => 'index.php?Page=Radiologi', 'page' => 'Radiologi'],
                                ['label' => 'Fisioterapi', 'url' => 'index.php?Page=Fisioterapi', 'page' => 'Fisioterapi'],
                                ['label' => 'Hemodialisa', 'url' => 'index.php?Page=Hemodialisa', 'page' => 'Hemodialisa'],
                                ['label' => 'Operasi', 'url' => 'index.php?Page=Operasi', 'page' => 'Operasi'],
                                ['label' => 'Peresepan', 'url' => 'index.php?Page=Peresepan', 'page' => 'Peresepan'],
                                ['label' => 'Resume', 'url' => 'index.php?Page=Resume', 'page' => 'Resume'],
                            ],
                        ],
                        [
                            'label' => 'Referensi Lokal',
                            'icon' => 'bi-journal-medical',
                            'children' => [
                                ['label' => 'Poliklinik', 'url' => 'index.php?Page=ReferensiPoliklinik', 'page' => 'ReferensiPoliklinik'],
                                ['label' => 'Dokter', 'url' => 'index.php?Page=ReferensiDokter', 'page' => 'ReferensiDokter'],
                                ['label' => 'Tenaga Medis', 'url' => 'index.php?Page=ReferensiPraktisi', 'page' => 'ReferensiPraktisi'],
                                ['label' => 'Ruang Rawat', 'url' => 'index.php?Page=ReferensiRuangRawat', 'page' => 'ReferensiRuangRawat'],
                                ['label' => 'ICD', 'url' => 'index.php?Page=ReferensiIcd', 'page' => 'ReferensiIcd'],
                                ['label' => 'Body Site', 'url' => 'index.php?Page=ReferensiBodySite', 'page' => 'ReferensiBodySite'],
                                ['label' => 'Procedure', 'url' => 'index.php?Page=ReferensiTindakan', 'page' => 'ReferensiTindakan'],
                                ['label' => 'Alergen', 'url' => 'index.php?Page=ReferensiAlergen', 'page' => 'ReferensiAlergen'],
                                ['label' => 'Observation', 'url' => 'index.php?Page=ReferensiObservation', 'page' => 'ReferensiObservation'],
                                ['label' => 'Imunisasi/Vaksin', 'url' => 'index.php?Page=ReferensiImunisasi', 'page' => 'ReferensiImunisasi'],
                                ['label' => 'Wilayah', 'url' => 'index.php?Page=ReferensiWilayah', 'page' => 'ReferensiWilayah'],
                            ],
                        ],
                    ],
                ],
                [
                    'label' => 'Laporan & Monitoring',
                    'items' => [
                        [
                            'label' => 'Indikator Pelayanan',
                            'icon' => 'bi-file-earmark',
                            'children' => [
                                ['label' => 'Demografi', 'url' => 'index.php?Page=Demografi', 'page' => 'Demografi'],
                                ['label' => 'Rawat Jalan', 'url' => 'index.php?Page=LaporanRajal', 'page' => 'LaporanRajal'],
                                ['label' => 'Rawat Inap', 'url' => 'index.php?Page=LaporanRanap', 'page' => 'LaporanRanap'],
                            ],
                        ],
                        [
                            'label' => 'Log SATUSEHAT',
                            'icon' => 'bi-file-earmark',
                            'children' => [
                                ['label' => 'Encounter', 'url' => 'index.php?Page=Encounter', 'page' => 'Encounter'],
                                ['label' => 'Condition', 'url' => 'index.php?Page=Condition', 'page' => 'Condition'],
                                ['label' => 'Observation', 'url' => 'index.php?Page=Observation', 'page' => 'Observation'],
                                ['label' => 'Procedure', 'url' => 'index.php?Page=Procedure', 'page' => 'Procedure'],
                            ],
                        ],
                    ],
                ],
                [
                    'label' => 'System',
                    'items' => [
                        [
                            'label' => 'Pengaturan',
                            'icon' => 'bi-gear',
                            'children' => [
                                ['label' => 'Pengaturan Umum', 'url' => 'index.php?Page=Setting', 'page' => 'Setting'],
                                ['label' => 'API Key', 'url' => 'index.php?Page=ApiKey', 'page' => 'ApiKey'],
                                ['label' => 'Email Gateway', 'url' => 'index.php?Page=EmailGateway', 'page' => 'EmailGateway'],
                                ['label' => 'Google Credential', 'url' => 'index.php?Page=GoogleCredential', 'page' => 'GoogleCredential'],
                            ],
                        ],
                        [
                            'label' => 'Aksesibilitas',
                            'icon' => 'bi-person',
                            'children' => [
                                ['label' => 'Fitur Aplikasi', 'url' => 'index.php?Page=AksesFitur', 'page' => 'AksesFitur'],
                                ['label' => 'Entitas Akses', 'url' => 'index.php?Page=AksesEntitas', 'page' => 'AksesEntitas'],
                                ['label' => 'Akun Akses', 'url' => 'index.php?Page=Akses', 'page' => 'Akses'],
                                ['label' => 'Pengajuan Akses', 'url' => 'index.php?Page=AksesPengajuan', 'page' => 'AksesPengajuan'],
                            ],
                        ],
                        [
                            'label' => 'Integrasi',
                            'icon' => 'bi-diagram-3',
                            'children' => [
                                ['label' => 'Bridging BPJS', 'url' => 'index.php?Page=SettingBpjs', 'page' => 'SettingBpjs'],
                                ['label' => 'SATUSEHAT', 'url' => 'index.php?Page=SettingSatuSehat', 'page' => 'SettingSatuSehat'],
                                ['label' => 'SIRS Online', 'url' => 'index.php?Page=SettingSirsOnline', 'page' => 'SettingSirsOnline'],
                                ['label' => 'Radix', 'url' => 'index.php?Page=SettingRadix', 'page' => 'SettingRadix'],
                                ['label' => 'Analyza', 'url' => 'index.php?Page=SettingAnalyza', 'page' => 'SettingAnalyza'],
                                ['label' => 'Sifarma', 'url' => 'index.php?Page=SettingSifarma', 'page' => 'SettingSifarma'],
                            ],
                        ],
                        ['label' => 'Migrasi', 'icon' => 'bi-database', 'url' => 'index.php?Page=Migrasi', 'page' => 'Migrasi'],
                        ['label' => 'Log', 'icon' => 'bi-record', 'url' => 'index.php?Page=Log', 'page' => 'Log'],
                        ['label' => 'Dokumentasi', 'icon' => 'bi-bookmark', 'url' => 'index.php?Page=Dokumentasi', 'page' => 'Dokumentasi'],
                    ],
                ],
                [
                    'label' => 'Lainnya',
                    'items' => [
                        ['label' => 'Bantuan', 'icon' => 'bi-question-circle', 'url' => 'index.php?Page=Bantuan', 'page' => 'Bantuan'],
                        [
                            'label' => 'Logout',
                            'icon' => 'bi-box-arrow-right',
                            'url' => 'javascript:void(0);',
                            'attributes' => 'data-bs-toggle="modal" data-bs-target="#ModalLogout"',
                        ],
                    ],
                ],
            ];

            foreach ($menuSections as $section) {
                echo '<div class="pcoded-navigation-label" data-i18n="nav.category.navigation">' . htmlspecialchars($section['label'], ENT_QUOTES, 'UTF-8') . '</div>';
                echo '<ul class="pcoded-item pcoded-left-item mb-3">';

                foreach ($section['items'] as $item) {
                    $hasChildren = isset($item['children']);
                    $itemPages = $hasChildren
                        ? array_column($item['children'], 'page')
                        : ($item['pages'] ?? [$item['page'] ?? null]);
                    $isActive = in_array($Page, $itemPages, true);

                    if ($hasChildren) {
                        echo '<li class="pcoded-hasmenu' . ($isActive ? ' active pcoded-trigger' : '') . '">';
                    } else {
                        echo '<li class="' . ($isActive ? 'active' : '') . '">';
                    }
                    echo '<a href="' . htmlspecialchars($item['url'] ?? 'javascript:void(0)', ENT_QUOTES, 'UTF-8') . '" class="waves-effect waves-dark" ' . ($item['attributes'] ?? '') . '>';
                    echo '<span class="pcoded-micon"><i class="bi ' . htmlspecialchars($item['icon'], ENT_QUOTES, 'UTF-8') . '"></i></span>';
                    echo '<span class="pcoded-mtext">' . htmlspecialchars($item['label'], ENT_QUOTES, 'UTF-8') . '</span>';
                    echo '<span class="pcoded-mcaret"></span>';
                    echo '</a>';

                    if ($hasChildren) {
                        echo '<ul class="pcoded-submenu">';
                        foreach ($item['children'] as $child) {
                            $childActive = $Page === $child['page'];
                            echo '<li class="' . ($childActive ? 'active bg-default' : '') . '">';
                            echo '<a href="' . htmlspecialchars($child['url'], ENT_QUOTES, 'UTF-8') . '" class="waves-effect waves-dark">';
                            echo '<span class="pcoded-micon"><i class="bi bi-dot"></i></span>';
                            echo '<span class="pcoded-mtext">' . htmlspecialchars($child['label'], ENT_QUOTES, 'UTF-8') . '</span>';
                            echo '<span class="pcoded-mcaret"></span>';
                            echo '</a></li>';
                        }
                        echo '</ul>';
                    }

                    echo '</li>';
                }

                echo '</ul>';
            }
        ?>

        <div class="text-center mb-3">
            <div class="main-menu-footer">
                <span class="text-center mb-3"></span>
            </div>
        </div>
    </div>
