
    <div class="sidebar_toggle">
        <a href="javascrip:void(0);">
            <i class="icon-close icons"></i>
        </a>
    </div>

    <div class="pcoded-inner-navbar main-menu scroll-container">
        <div class="">
            <div class="main-menu-header">
                <img class="img-80 img-radius" src="assets/images/<?php echo "$logo"; ?>" alt="User-Profile-Image">
                <div class="user-details">
                    <span id="more-details"><?php echo "$hospital_name";?></span>
                </div>
            </div>
        </div>
        
        <div class="pcoded-navigation-label" data-i18n="nav.category.navigation">Menu Utama</div>

        <ul class="pcoded-item pcoded-left-item mb-3">
            <li class="<?php if($Page==""){echo 'active';} ?>">
                <a href="index.php" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-dashboard"></i><b>D</b></span>
                    <span class="pcoded-mtext" data-i18n="nav.dash.main">Dashboard</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
            
            
            <li class="pcoded-hasmenu 
            <?php 
                if(
                    $Page=="Setting"||
                    $Page=="ApiKey"||
                    $Page=="EmailGateway"||
                    $Page=="GoogleCredential"||
                    $Page=="AksesFitur"||
                    $Page=="AksesEntitas"||
                    $Page=="Akses"||
                    $Page=="AksesPengajuan"||
                    $Page=="Api" || 
                    $Page=="SettingBpjs" || 
                    $Page=="SettingSatuSehat" || 
                    $Page=="SettingSirsOnline" || 
                    $Page=="LaporanKesalahan"
                )
                {
                    echo 'active pcoded-trigger';
                } 
            ?>
            ">
                <a href="javascript:void(0)" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="icofont-settings-alt"></i></span>
                    <span class="pcoded-mtext"  data-i18n="nav.basic-components.main">Pengaturan</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="<?php if($Page=="Setting"){echo 'active';} ?>">
                        <a href="index.php?Page=Setting" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.breadcrumbs">
                                Pengaturan Umum 
                            </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>

                    <li class="<?php if($Page=="ApiKey"){echo 'active';} ?>">
                        <a href="index.php?Page=ApiKey" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.breadcrumbs">
                                API Key
                            </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>

                    <li class="<?php if($Page=="EmailGateway"){echo 'active';} ?>">
                        <a href="index.php?Page=EmailGateway" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.breadcrumbs">
                                Email Gateway
                            </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>

                    <li class="<?php if($Page=="GoogleCredential"){echo 'active';} ?>">
                        <a href="index.php?Page=GoogleCredential" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.breadcrumbs">
                                Google Credential
                            </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>


                    <li class="pcoded-hasmenu 
                        <?php 
                            if($Page=="AksesFitur" || $Page=="AksesEntitas" || $Page=="Akses" || $Page=="AksesPengajuan"){
                                echo 'active pcoded-trigger';
                            } 
                        ?>"
                    >
                        <a href="javascript:void(0)" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">
                                Aksesibilitas
                            </span>
                            <span class="pcoded-mcaret"></span>
                        </a>

                        <ul class="pcoded-submenu">
                            <li class="<?php if($Page=="AksesFitur"){echo 'active';} ?>">
                                <a href="index.php?Page=AksesFitur" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="ti-angle-double-right"></i></span>
                                    <span class="pcoded-mtext">
                                        Fitur Aplikasi
                                    </span>
                                </a>
                            </li>

                            <li class="<?php if($Page=="AksesEntitas"){echo 'active';} ?>">
                                <a href="index.php?Page=AksesEntitas" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="ti-angle-double-right"></i></span>
                                    <span class="pcoded-mtext">
                                        Entitas Akses
                                    </span>
                                </a>
                            </li>

                            <li class="<?php if($Page=="Akses"){echo 'active';} ?>">
                                <a href="index.php?Page=Akses" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="ti-angle-double-right"></i></span>
                                    <span class="pcoded-mtext">
                                        Akun Pengguna
                                    </span>
                                </a>
                            </li>

                            <li class="<?php if($Page=="AksesPengajuan"){echo 'active';} ?>">
                                <a href="index.php?Page=AksesPengajuan" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="ti-angle-double-right"></i></span>
                                    <span class="pcoded-mtext">
                                        Pengajuan Akses
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="pcoded-hasmenu 
                        <?php 
                            if($Page=="SettingBpjs" || $Page=="SettingSatuSehat" || $Page=="SettingSirsOnline" || $Page=="ModeKontras"){
                                echo 'active pcoded-trigger';
                            } 
                        ?>"
                    >
                        <a href="javascript:void(0)" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="bi bi-share"></i></span>
                            <span class="pcoded-mtext">
                                Integrasi
                            </span>
                            <span class="pcoded-mcaret"></span>
                        </a>

                        <ul class="pcoded-submenu">
                            <li class="<?php if($Page=="SettingBpjs"){echo 'active';} ?>">
                                <a href="index.php?Page=SettingBpjs" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="ti-angle-double-right"></i></span>
                                    <span class="pcoded-mtext">Bridging BPJS </span>
                                </a>
                            </li>

                            <li class="<?php if($Page=="SettingSatuSehat"){echo 'active';} ?>">
                                <a href="index.php?Page=SettingSatuSehat" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="ti-angle-double-right"></i></span>
                                    <span class="pcoded-mtext">SATUSEHAT</span>
                                </a>
                            </li>

                            <li class="<?php if($Page=="SettingSirsOnline"){echo 'active';} ?>">
                                <a href="index.php?Page=SettingSirsOnline" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="ti-angle-double-right"></i></span>
                                    <span class="pcoded-mtext">SIRS Online</span>
                                </a>
                            </li>

                            <li class="<?php if($Page=="SettingRadix"){echo 'active';} ?>">
                                <a href="index.php?Page=SettingRadix" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="ti-angle-double-right"></i></span>
                                    <span class="pcoded-mtext">Radix</span>
                                </a>
                            </li>

                            <li class="<?php if($Page=="SettingAnalyza"){echo 'active';} ?>">
                                <a href="index.php?Page=SettingAnalyza" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="ti-angle-double-right"></i></span>
                                    <span class="pcoded-mtext">Analyza</span>
                                </a>
                            </li>

                            <li class="<?php if($Page=="SettingSifarma"){echo 'active';} ?>">
                                <a href="index.php?Page=SettingSifarma" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="ti-angle-double-right"></i></span>
                                    <span class="pcoded-mtext">Sifarma</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="<?php if($Page=="LaporanKesalahan"){echo 'active';} ?>">
                        <a href="index.php?Page=LaporanKesalahan" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.breadcrumbs">
                                Laporan Kesalahan
                            </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>

                </ul>
            </li>
            <li class="pcoded-hasmenu 
                <?php 
                    if(
                        $Page=="Referensi"||
                        $Page=="Poliklinik"||
                        $Page=="Dokter"||
                        $Page=="JadwalDokter"||
                        $Page=="Wilayah"||
                        $Page=="KelasRuangan"||
                        $Page=="KelasRuangan2"||
                        $Page=="Diagnosa"||
                        $Page=="Alergi"||
                        $Page=="Kfa"
                    )
                    {
                        echo 'active pcoded-trigger';
                    } 
                ?>
            ">
                <a href="javascript:void(0)" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-bookmark-alt"></i> </span>
                    <span class="pcoded-mtext"  data-i18n="nav.basic-components.main">Referensi</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    
                    <li class="pcoded-hasmenu 
                        <?php 
                            if($Page=="Aksesibilitas" || $Page=="Tema" || $Page=="Font" || $Page=="ModeKontras"){
                                echo 'active pcoded-trigger';
                            } 
                        ?>"
                    >
                        <a href="javascript:void(0)" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="bi bi-share"></i></span>
                            <span class="pcoded-mtext">
                                Referensi Lokal
                            </span>
                            <span class="pcoded-mcaret"></span>
                        </a>

                        <ul class="pcoded-submenu">
                            <li class="<?php if($Page=="AksesFitur"){echo 'active';} ?>">
                                <a href="index.php?Page=AksesFitur" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="ti-angle-double-right"></i></span>
                                    <span class="pcoded-mtext">Poliklinik</span>
                                </a>
                            </li>

                            <li class="<?php if($Page=="AksesEntitas"){echo 'active';} ?>">
                                <a href="index.php?Page=AksesEntitas" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="ti-angle-double-right"></i></span>
                                    <span class="pcoded-mtext">Dokter</span>
                                </a>
                            </li>

                            <li class="<?php if($Page=="Akses"){echo 'active';} ?>">
                                <a href="index.php?Page=Akses" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="ti-angle-double-right"></i></span>
                                    <span class="pcoded-mtext">Jadwal Praktek</span>
                                </a>
                            </li>

                            <li class="<?php if($Page=="AksesPengajuan"){echo 'active';} ?>">
                                <a href="index.php?Page=AksesPengajuan" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="ti-angle-double-right"></i></span>
                                    <span class="pcoded-mtext">Ruang Rawat</span>
                                </a>
                            </li>

                            <li class="<?php if($Page=="Analyza"){echo 'active';} ?>">
                                <a href="index.php?Page=AksesPengajuan" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="ti-angle-double-right"></i></span>
                                    <span class="pcoded-mtext">ICD</span>
                                </a>
                            </li>

                            <li class="<?php if($Page=="AksesPengajuan"){echo 'active';} ?>">
                                <a href="index.php?Page=AksesPengajuan" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="ti-angle-double-right"></i></span>
                                    <span class="pcoded-mtext">Wilayah</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="pcoded-hasmenu 
                        <?php 
                            if($Page=="Aksesibilitas" || $Page=="Tema" || $Page=="Font" || $Page=="ModeKontras"){
                                echo 'active pcoded-trigger';
                            } 
                        ?>"
                    >
                        <a href="javascript:void(0)" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="bi bi-share"></i></span>
                            <span class="pcoded-mtext">
                                BPJS
                            </span>
                            <span class="pcoded-mcaret"></span>
                        </a>

                        <ul class="pcoded-submenu">
                            <li class="<?php if($Page=="AksesFitur"){echo 'active';} ?>">
                                <a href="index.php?Page=AksesFitur" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="ti-angle-double-right"></i></span>
                                    <span class="pcoded-mtext">Wilayah</span>
                                </a>
                            </li>

                            <li class="<?php if($Page=="AksesEntitas"){echo 'active';} ?>">
                                <a href="index.php?Page=AksesEntitas" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="ti-angle-double-right"></i></span>
                                    <span class="pcoded-mtext">ICD</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="pcoded-hasmenu 
                        <?php 
                            if($Page=="Aksesibilitas" || $Page=="Tema" || $Page=="Font" || $Page=="ModeKontras"){
                                echo 'active pcoded-trigger';
                            } 
                        ?>"
                    >
                        <a href="javascript:void(0)" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="bi bi-share"></i></span>
                            <span class="pcoded-mtext">
                                SATUSEHAT
                            </span>
                            <span class="pcoded-mcaret"></span>
                        </a>

                        <ul class="pcoded-submenu">
                            <li class="<?php if($Page=="AksesFitur"){echo 'active';} ?>">
                                <a href="index.php?Page=AksesFitur" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="ti-angle-double-right"></i></span>
                                    <span class="pcoded-mtext">Organization</span>
                                </a>
                            </li>

                            <li class="<?php if($Page=="AksesEntitas"){echo 'active';} ?>">
                                <a href="index.php?Page=AksesEntitas" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="ti-angle-double-right"></i></span>
                                    <span class="pcoded-mtext">Location</span>
                                </a>
                            </li>

                            <li class="<?php if($Page=="AksesEntitas"){echo 'active';} ?>">
                                <a href="index.php?Page=AksesEntitas" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="ti-angle-double-right"></i></span>
                                    <span class="pcoded-mtext">Practitioner</span>
                                </a>
                            </li>

                            <li class="<?php if($Page=="AksesEntitas"){echo 'active';} ?>">
                                <a href="index.php?Page=AksesEntitas" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="ti-angle-double-right"></i></span>
                                    <span class="pcoded-mtext">Loinc</span>
                                </a>
                            </li>

                            <li class="<?php if($Page=="AksesEntitas"){echo 'active';} ?>">
                                <a href="index.php?Page=AksesEntitas" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="ti-angle-double-right"></i></span>
                                    <span class="pcoded-mtext">Snomed</span>
                                </a>
                            </li>

                            <li class="<?php if($Page=="AksesEntitas"){echo 'active';} ?>">
                                <a href="index.php?Page=AksesEntitas" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="ti-angle-double-right"></i></span>
                                    <span class="pcoded-mtext">KFA</span>
                                </a>
                            </li>

                        </ul>
                    </li>

                </ul>
            </li>
            <li class="pcoded-hasmenu <?php if($Page=="Antrian"||$Page=="DashboardAntrol"||$Page=="AntrianPanggil"){echo 'active pcoded-trigger';} ?>">
                <a href="javascript:void(0)" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="icofont-ticket"></i></span>
                    <span class="pcoded-mtext"  data-i18n="nav.basic-components.main">Antrian</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="<?php if($Page=="Antrian"){echo 'active';} ?>">
                        <a href="index.php?Page=Antrian" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti ti-user"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Daftar Antrian</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Page=="DashboardAntrol"){echo 'active';} ?>">
                        <a href="index.php?Page=DashboardAntrol" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti ti-user"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Monitoring Antrian</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Page=="AntrianPanggil"){echo 'active';} ?>">
                        <a href="index.php?Page=AntrianPanggil" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti ti-user"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">
                                Antrian Panggil 
                                <span class="text text-success">
                                    <i class="icofont-check-circled"></i>
                                </span>
                            </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="pcoded-hasmenu <?php if($Page=="Pasien"||$Page=="Rujukan"||$Page=="RawatJalan"||$Page=="SuratKontrol"||$Page=="Approval"||$Page=="RujukBalik"||$Page=="Fingerprint"||$Page=="Monitoring"||$Page=="MonitoringBaru"||$Page=="JadwalOperasi"||$Page=="Signature"||$Page=="sep"){echo 'active pcoded-trigger';} ?>">
                <a href="javascript:void(0)" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-id-badge"></i></span>
                    <span class="pcoded-mtext"  data-i18n="nav.basic-components.main">Rekam Medis</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="<?php if($Page=="Pasien"){echo 'active';} ?>">
                        <a href="index.php?Page=Pasien" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti ti-user"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Pasien</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Page=="RawatJalan"){echo 'active';} ?>">
                        <a href="index.php?Page=RawatJalan" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.breadcrumbs">Kunjungan</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Page=="Antrian"){echo 'active';} ?>">
                        <a href="index.php?Page=RawatJalan" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.breadcrumbs">Antrian</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="pcoded-hasmenu <?php if($Page=="Obat"||$Page=="Medication"||$Page=="StokOpename"||$Page=="ObatStorage"||$Page=="ExpiredLimit"||$Page=="TransaksiObat"||$Page=="Resep"){echo 'active pcoded-trigger';} ?>">
                <a href="javascript:void(0)" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="fa fa-medkit"></i></span>
                    <span class="pcoded-mtext"  data-i18n="nav.basic-components.main">Penunjang Medis</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="<?php if($Page=="Obat"){echo 'active';} ?>">
                        <a href="index.php?Page=Obat" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">
                                Farmasi / Apotek
                            </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Page=="Obat"){echo 'active';} ?>">
                        <a href="index.php?Page=Obat" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">
                                Radiologi
                            </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Page=="Obat"){echo 'active';} ?>">
                        <a href="index.php?Page=Obat" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">
                                Laboratorium
                            </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Page=="Obat"){echo 'active';} ?>">
                        <a href="index.php?Page=Obat" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">
                                Fisioterapi
                            </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Page=="Obat"){echo 'active';} ?>">
                        <a href="index.php?Page=Obat" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">
                                Hemodialisa
                            </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Page=="Obat"){echo 'active';} ?>">
                        <a href="index.php?Page=Obat" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">
                                Operasi
                            </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="pcoded-hasmenu <?php if($Page=="SEP"||$Page=="Rujukan"||$Page=="SpriSkdp"){echo 'active pcoded-trigger';} ?>">
                <a href="javascript:void(0)" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="bi bi-card-checklist"></i></span>
                    <span class="pcoded-mtext"  data-i18n="nav.basic-components.main">BPJS Kesehatan</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="<?php if($Page=="SEP"){echo 'active bg-default';} ?>">
                        <a href="index.php?Page=SEP" class="waves-effect waves-dark">
                            <span class="pcoded-micon"></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">SEP</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Page=="Rujukan"){echo 'active bg-default';} ?>">
                        <a href="index.php?Page=Rujukan" class="waves-effect waves-dark">
                            <span class="pcoded-micon"></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Rujukan</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                     <li class="<?php if($Page=="SpriSkdp"){echo 'active bg-default';} ?>">
                        <a href="index.php?Page=SpriSkdp" class="waves-effect waves-dark">
                            <span class="pcoded-micon"></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">SPRI / SKDP</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="pcoded-hasmenu <?php if($Page=="SirsOnline"||$Page=="SirsOnlineTempatTidur"||$Page=="SirsOnlineAlkes"||$Page=="SirsOnlineAntrian"||$Page=="PasienShk"||$Page=="SirsOnlineOksigen"||$Page=="SirsOnlineNakesTerinfeksi"){echo 'active pcoded-trigger';} ?>">
                <a href="javascript:void(0)" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti ti-comment-alt"></i></span>
                    <span class="pcoded-mtext"  data-i18n="nav.basic-components.main">SIRS Online</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="<?php if($Page=="SirsOnlineTempatTidur"){echo 'active bg-default';} ?>">
                        <a href="index.php?Page=SirsOnlineTempatTidur" class="waves-effect waves-dark">
                            <span class="pcoded-micon"></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Tempat Tidur</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Page=="DataSdm"){echo 'active bg-default';} ?>">
                        <a href="index.php?Page=SirsOnline&Sub=DataSdm" class="waves-effect waves-dark">
                            <span class="pcoded-micon"></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Nakes/SDM</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Page=="PcrNakes"){echo 'active bg-default';} ?>">
                        <a href="index.php?Page=SirsOnline&Sub=PcrNakes" class="waves-effect waves-dark">
                            <span class="pcoded-micon"></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">PCR Nakes</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Page=="SirsOnlineNakesTerinfeksi"){echo 'active bg-default';} ?>">
                        <a href="index.php?Page=SirsOnlineNakesTerinfeksi" class="waves-effect waves-dark">
                            <span class="pcoded-micon"></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Nakes Terinfeksi</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Page=="SirsOnlineAlkes"){echo 'active bg-default';} ?>">
                        <a href="index.php?Page=SirsOnlineAlkes" class="waves-effect waves-dark">
                            <span class="pcoded-micon"></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Alkes</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Page=="SirsOnlineOksigen"){echo 'active bg-default';} ?>">
                        <a href="index.php?Page=SirsOnlineOksigen" class="waves-effect waves-dark">
                            <span class="pcoded-micon"></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Oksigen</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Page=="PasienShk"){echo 'active bg-default';} ?>">
                        <a href="index.php?Page=PasienShk" class="waves-effect waves-dark">
                            <span class="pcoded-micon"></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Pasien SHK</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Page=="SirsOnlineAntrian"){echo 'active bg-default';} ?>">
                        <a href="index.php?Page=SirsOnlineAntrian" class="waves-effect waves-dark">
                            <span class="pcoded-micon"></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Antrian</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="pcoded-hasmenu <?php if($Page=="TopDiagnosa"){echo 'active pcoded-trigger';} ?>">
                <a href="javascript:void(0)" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti ti-files"></i></span>
                    <span class="pcoded-mtext"  data-i18n="nav.basic-components.main">Laporan</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="<?php if($Page=="TopDiagnosa"){echo 'active bg-default';} ?>">
                        <a href="index.php?Page=TopDiagnosa" class="waves-effect waves-dark">
                            <span class="pcoded-micon"></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Demografi Pasien</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>

                    <li class="<?php if($Page=="TopDiagnosa"){echo 'active bg-default';} ?>">
                        <a href="index.php?Page=TopDiagnosa" class="waves-effect waves-dark">
                            <span class="pcoded-micon"></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Demografi Kunjungan</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>

                    <li class="<?php if($Page=="TopDiagnosa"){echo 'active bg-default';} ?>">
                        <a href="index.php?Page=TopDiagnosa" class="waves-effect waves-dark">
                            <span class="pcoded-micon"></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Rawat Inap</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>

                    <li class="<?php if($Page=="TopDiagnosa"){echo 'active bg-default';} ?>">
                        <a href="index.php?Page=TopDiagnosa" class="waves-effect waves-dark">
                            <span class="pcoded-micon"></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Rawat Jalan</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>

                    <li class="<?php if($Page=="TopDiagnosa"){echo 'active bg-default';} ?>">
                        <a href="index.php?Page=TopDiagnosa" class="waves-effect waves-dark">
                            <span class="pcoded-micon"></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Top Diagnosa</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>

                    <li class="<?php if($Page=="TopDiagnosa"){echo 'active bg-default';} ?>">
                        <a href="index.php?Page=TopDiagnosa" class="waves-effect waves-dark">
                            <span class="pcoded-micon"></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Top Wilayah</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    
                </ul>
            </li>
            <li class="<?php if($Page=="Migrasi"){echo 'active';} ?>">
                <a href="index.php?Page=Migrasi" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="bi bi-database"></i><b>D</b></span>
                    <span class="pcoded-mtext" data-i18n="nav.dash.main">Migrasi</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
            <li class="<?php if($Page=="Bantuan"){echo 'active';} ?>">
                <a href="index.php?Page=Bantuan" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="icofont-question-circle"></i><b>D</b></span>
                    <span class="pcoded-mtext" data-i18n="nav.dash.main">Bantuan</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
        </ul>

        <div class="text-center mb-3">
            <div class="main-menu-footer">
                <span class="text-center mb-3">
                   
                </span>
            </div>
        </div>
    </div>