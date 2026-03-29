<?php
    if(empty($SessionGambar)){
        $LinkGambar="avatar-blank.jpg";
    }else{
        $LinkGambar="user/$SessionGambar";
    }
    if(!empty($_GET['Page'])){
        $Page=$_GET['Page'];
    }else{
        $Page="";
    }
    if(!empty($_GET['Sub'])){
        $Sub=$_GET['Sub'];
    }else{
        $Sub="";
    }
?>
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
            <li class="pcoded-hasmenu <?php if($Page=="Akses"){echo 'active pcoded-trigger';} ?>">
                <a href="javascript:void(0)" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti ti-user"></i></span>
                    <span class="pcoded-mtext"  data-i18n="nav.basic-components.main">Aksesibilitas</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="<?php if($Sub=="ReferensiFitur"){echo 'active';} ?>">
                        <a href="index.php?Page=Akses&Sub=ReferensiFitur" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Referensi Fitur</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Sub=="EntitasAkses"||$Sub=="TambahEntitasAkses"||$Sub=="DetailEntitas"||$Sub=="EditEntitas"){echo 'active';} ?>">
                        <a href="index.php?Page=Akses&Sub=EntitasAkses" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Entitas Akses</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Sub=="PengajuanAkses"||$Sub=="DetailPengajuanAkses"){echo 'active';} ?>">
                        <a href="index.php?Page=Akses&Sub=PengajuanAkses" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.breadcrumbs">Pengajuan Akses</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Sub=="AksesUser"||$Sub=="DetailAkses"){echo 'active';} ?>">
                        <a href="index.php?Page=Akses&Sub=AksesUser" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.breadcrumbs">Akses User</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="pcoded-hasmenu <?php if($Page=="MonitorAntrian"||$Page=="MonitorRuangan"||$Page=="Log"||$Page=="LaporanPengguna"){echo 'active pcoded-trigger';} ?>">
                <a href="javascript:void(0)" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="icofont-monitor"></i></span>
                    <span class="pcoded-mtext"  data-i18n="nav.basic-components.main">Monitoring</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="<?php if($Page=="MonitorAntrian"){echo 'active';} ?>">
                        <a href="index.php?Page=MonitorAntrian" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Monitor Antrian</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Page=="MonitorRuangan"){echo 'active';} ?>">
                        <a href="index.php?Page=MonitorRuangan" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.breadcrumbs">Monitor Ruangan</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Page=="Log"){echo 'active';} ?>">
                        <a href="index.php?Page=Log" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.breadcrumbs">Log Aktivitas</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Page=="LaporanPengguna"){echo 'active';} ?>">
                        <a href="index.php?Page=LaporanPengguna" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.breadcrumbs">Laporan Pengguna</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="pcoded-hasmenu <?php if($Page=="Radix"||$Page=="Analyza"||$Page=="Setting"||$Page=="SettingBridging"||$Sub=="Email"||$Page=="SettingProfile"||$Page=="Personalisasi"||$Page=="SettingPercetakan"||$Page=="Api"){echo 'active pcoded-trigger';} ?>">
                <a href="javascript:void(0)" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="icofont-settings-alt"></i></span>
                    <span class="pcoded-mtext"  data-i18n="nav.basic-components.main">Pengaturan</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="<?php if($Sub=="SettingProfile"){echo 'active';} ?>">
                        <a href="index.php?Page=Setting&Sub=SettingProfile" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.breadcrumbs">
                                Profile Faskes 
                                <span class="text text-success">
                                    <i class="icofont-check-circled"></i>
                                </span>
                            </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Page=="SettingPercetakan"){echo 'active';} ?>">
                        <a href="index.php?Page=SettingPercetakan" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.breadcrumbs">Percetakan</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Sub=="SettingBridging"){echo 'active';} ?>">
                        <a href="index.php?Page=Setting&Sub=SettingBridging" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.breadcrumbs">
                                Bridging BPJS 
                                <span class="text text-success">
                                    <i class="icofont-check-circled"></i>
                                </span>
                            </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Page=="SettingBridging"){echo 'active';} ?>">
                        <a href="index.php?Page=SettingBridging" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.breadcrumbs">Bridging</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Sub=="SatuSehat"){echo 'active';} ?>">
                        <a href="index.php?Page=Setting&Sub=SatuSehat" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.breadcrumbs">
                                Satu Sehat 
                                <span class="text text-success">
                                    <i class="icofont-check-circled"></i>
                                </span>
                            </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Sub=="SirsOnline"){echo 'active';} ?>">
                        <a href="index.php?Page=Setting&Sub=SirsOnline" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.breadcrumbs">
                                SIRS Online 
                                <span class="text text-success">
                                    <i class="icofont-check-circled"></i>
                                </span>
                            </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Sub=="Sisrute"){echo 'active';} ?>">
                        <a href="index.php?Page=Setting&Sub=Sisrute" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.breadcrumbs">
                                SISRUTE 
                                <span class="text text-danger">
                                    <i class="ti ti-close"></i>
                                </span>
                            </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Sub=="Email"){echo 'active';} ?>">
                        <a href="index.php?Page=Setting&Sub=Email" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.breadcrumbs">Email Gateway</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Page=="Api"){echo 'active';} ?>">
                        <a href="index.php?Page=Api" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.breadcrumbs">API Key</span>
                            <span class="text text-success">
                                <i class="icofont-check-circled"></i>
                            </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Page=="Radix"){echo 'active';} ?>">
                        <a href="index.php?Page=Radix" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.breadcrumbs">Radix</span>
                            <span class="text text-success">
                                <i class="icofont-check-circled"></i>
                            </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Page=="Analyza"){echo 'active';} ?>">
                        <a href="index.php?Page=Analyza" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.breadcrumbs">Analyza </span>
                            <span class="text text-success">
                                <i class="icofont-check-circled"></i>
                            </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="pcoded-hasmenu <?php if($Page=="Referensi"||$Page=="Poliklinik"||$Page=="Dokter"||$Page=="JadwalDokter"||$Page=="Wilayah"||$Page=="KelasRuangan"||$Page=="KelasRuangan2"||$Page=="Diagnosa"||$Page=="Alergi"||$Page=="Kfa"){echo 'active pcoded-trigger';} ?>">
                <a href="javascript:void(0)" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-bookmark-alt"></i> </span>
                    <span class="pcoded-mtext"  data-i18n="nav.basic-components.main">Referensi</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="<?php if($Sub=="Organization"||$Sub=="DetailOrganizationSimrs"||$Sub=="DetailOrganizationSatuSehat"){echo 'active';} ?>">
                        <a href="index.php?Page=Referensi&Sub=Organization" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.breadcrumbs">
                                Organization 
                                <span class="text text-success">
                                    <i class="icofont-check-circled"></i>
                                </span>
                            </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Sub=="Location"){echo 'active';} ?>">
                        <a href="index.php?Page=Referensi&Sub=Location" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.breadcrumbs">
                                Location 
                                <span class="text text-success">
                                    <i class="icofont-check-circled"></i>
                                </span>
                            </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Sub=="Practitioner"){echo 'active';} ?>">
                        <a href="index.php?Page=Referensi&Sub=Practitioner" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.breadcrumbs">
                                Practitioner
                                <span class="text text-success">
                                    <i class="icofont-check-circled"></i>
                                </span>
                            </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Page=="Poliklinik"){echo 'active';} ?>">
                        <a href="index.php?Page=Poliklinik" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.breadcrumbs">Poliklinik</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Page=="Dokter"){echo 'active';} ?>">
                        <a href="index.php?Page=Dokter" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.breadcrumbs">Dokter</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Page=="KelasRuangan"){echo 'active';} ?>">
                        <a href="index.php?Page=KelasRuangan" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.breadcrumbs">Kelas-Ruangan</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Page=="KelasRuangan2"){echo 'active';} ?>">
                        <a href="index.php?Page=KelasRuangan2" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.breadcrumbs">Kelas-Ruangan (V2)</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Page=="JadwalDokter"){echo 'active';} ?>">
                        <a href="index.php?Page=JadwalDokter" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.breadcrumbs">Jadwal Praktek</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Sub=="Mendagri"){echo 'active';} ?>">
                        <a href="index.php?Page=Wilayah&Sub=Mendagri" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.breadcrumbs">
                                Wilayah (Mendagri) 
                                <span class="text text-success">
                                    <i class="icofont-check-circled"></i>
                                </span>
                            </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Sub=="BPJS"){echo 'active';} ?>">
                        <a href="index.php?Page=Wilayah&Sub=BPJS" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.breadcrumbs">Wilayah (BPJS)</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Sub=="Internal"){echo 'active';} ?>">
                        <a href="index.php?Page=Wilayah&Sub=Internal" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.breadcrumbs">
                                Wilayah (SIMRS) 
                            </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Sub=="DiagnosaBPJS"){echo 'active';} ?>">
                        <a href="index.php?Page=Diagnosa&Sub=DiagnosaBPJS" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.breadcrumbs">
                                Diagnosa (BPJS)
                            </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Sub=="DiagnosaSimrs"){echo 'active';} ?>">
                        <a href="index.php?Page=Diagnosa&Sub=DiagnosaSimrs" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.breadcrumbs">
                                Diagnosa (SIMRS)
                            </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Sub=="Loinc"){echo 'active';} ?>">
                        <a href="index.php?Page=Referensi&Sub=Loinc" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.breadcrumbs">
                                Loinc 
                                <span class="text text-success">
                                    <i class="icofont-check-circled"></i>
                                </span>
                            </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Sub=="Snomed"){echo 'active';} ?>">
                        <a href="index.php?Page=Referensi&Sub=Snomed" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.breadcrumbs">
                                Snomed 
                                <span class="text text-success">
                                    <i class="icofont-check-circled"></i>
                                </span>
                            </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Page=="Alergi"){echo 'active';} ?>">
                        <a href="index.php?Page=Alergi" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.breadcrumbs">
                                Alergi 
                                <span class="text text-success">
                                    <i class="icofont-check-circled"></i>
                                </span>
                            </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Page=="Kfa"){echo 'active';} ?>">
                        <a href="index.php?Page=Kfa" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.breadcrumbs">
                                KFA 
                                <span class="text text-success">
                                    <i class="icofont-check-circled"></i>
                                </span>
                            </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
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
                    <li class="<?php if($Page=="JadwalOperasi"){echo 'active';} ?>">
                        <a href="index.php?Page=JadwalOperasi" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.breadcrumbs">
                                Jadwal Operasi 
                                <span class="text text-success">
                                    <i class="icofont-check-circled"></i>
                                </span>
                            </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Page=="sep"){echo 'active';} ?>">
                        <a href="index.php?Page=sep" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti ti-user"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">SEP</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Page=="Approval"){echo 'active';} ?>">
                        <a href="index.php?Page=Approval" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti ti-user"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">
                                Approval 
                                <span class="text text-success">
                                    <i class="icofont-check-circled"></i>
                                </span>
                            </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Page=="Rujukan"){echo 'active';} ?>">
                        <a href="index.php?Page=Rujukan" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti ti-user"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Rujukan</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Page=="SuratKontrol"){echo 'active';} ?>">
                        <a href="index.php?Page=SuratKontrol" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti ti-user"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">SPRI/SKDP</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Page=="Fingerprint"){echo 'active';} ?>">
                        <a href="index.php?Page=Fingerprint" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti ti-user"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Fingerprint</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Page=="Monitoring"){echo 'active';} ?>">
                        <a href="index.php?Page=Monitoring" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti ti-user"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Monitoring</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Page=="MonitoringBaru"){echo 'active';} ?>">
                        <a href="index.php?Page=MonitoringBaru" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti ti-user"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">
                                Laporan 
                                <span class="text text-success">
                                    <i class="icofont-check-circled"></i>
                                </span>
                            </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <!-- <li class="<?php if($Page=="Signature"){echo 'active';} ?>">
                        <a href="index.php?Page=Signature" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti ti-user"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Signature</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li> -->
                </ul>
            </li>
            <li class="pcoded-hasmenu <?php if($Page=="Obat"||$Page=="Medication"||$Page=="StokOpename"||$Page=="ObatStorage"||$Page=="ExpiredLimit"||$Page=="TransaksiObat"||$Page=="Resep"){echo 'active pcoded-trigger';} ?>">
                <a href="javascript:void(0)" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="fa fa-medkit"></i></span>
                    <span class="pcoded-mtext"  data-i18n="nav.basic-components.main">Farmasi</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="<?php if($Page=="Obat"){echo 'active';} ?>">
                        <a href="index.php?Page=Obat" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti ti-user"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Obat & Alkes</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Page=="Medication"){echo 'active';} ?>">
                        <a href="index.php?Page=Medication" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti ti-user"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">
                                Medication
                                <span class="text text-success">
                                    <i class="icofont-check-circled"></i>
                                </span>
                            </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Page=="ObatStorage"){echo 'active';} ?>">
                        <a href="index.php?Page=ObatStorage" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.breadcrumbs">Penyimpanan</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Page=="StokOpename"){echo 'active';} ?>">
                        <a href="index.php?Page=StokOpename" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.breadcrumbs">Stok Opename</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Page=="Resep"){echo 'active';} ?>">
                        <a href="index.php?Page=Resep" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.breadcrumbs">Resep</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Page=="ExpiredLimit"){echo 'active';} ?>">
                        <a href="index.php?Page=ExpiredLimit" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.breadcrumbs">Expired & Limit</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="pcoded-hasmenu <?php if($Page=="Laboratorium"){echo 'active pcoded-trigger';} ?>">
                <a href="javascript:void(0)" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="icofont-laboratory"></i></span>
                    <span class="pcoded-mtext"  data-i18n="nav.basic-components.main">Laboratorium</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="<?php if($Sub=="ReferensiLab"){echo 'active';} ?>">
                        <a href="index.php?Page=Laboratorium&Sub=ReferensiLab" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.breadcrumbs">Referensi</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Sub=="TambahPermintaanLab"){echo 'active';} ?>">
                        <a href="index.php?Page=Laboratorium&Sub=TambahPermintaanLab" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti ti-user"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Permintaan Lab</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Sub=="PermintaanLab"||$Sub=="EditPermintaanLab"||$Sub=="DetailPermintaanLab"){echo 'active';} ?>">
                        <a href="index.php?Page=Laboratorium&Sub=PermintaanLab" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti ti-user"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Data Laboratorium</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Sub=="LaporanLab"){echo 'active';} ?>">
                        <a href="index.php?Page=Laboratorium&Sub=LaporanLab" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti ti-user"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Laporan Laboratorium</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="<?php if($Page=="Laboratorium2"){echo 'active';} ?>">
                <a href="index.php?Page=Laboratorium2" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="icofont-laboratory"></i></span>
                    <span class="pcoded-mtext" data-i18n="nav.dash.main">
                        Laboratorium V.2
                        <span class="text text-success">
                            <i class="icofont-check-circled"></i>
                        </span>
                    </span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
            <li class="pcoded-hasmenu <?php if($Page=="Radiologi"){echo 'active pcoded-trigger';} ?>">
                <a href="javascript:void(0)" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="icofont-xray"></i></span>
                    <span class="pcoded-mtext"  data-i18n="nav.basic-components.main">Radiologi</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="<?php if($Sub=="TambahRadiologi"){echo 'active';} ?>">
                        <a href="index.php?Page=Radiologi&Sub=TambahRadiologi" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti ti-user"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Pendaftaran Radiologi</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Page=="Radiologi"&&$Sub==""){echo 'active';} ?>">
                        <a href="index.php?Page=Radiologi" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.breadcrumbs">Data Radiologi</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="pcoded-hasmenu <?php if($Page=="PersediaanFarmasi"||$Page=="Persediaan"||$Page=="Kas"||$Page=="TarifTindakan"||$Page=="Supplier"||$Page=="AkunPerkiraan"||$Page=="Transaksi"||$Page=="Jurnal"||$Page=="BukuBesar"||$Page=="NeracaSaldo"||$Page=="Anggaran"){echo 'active pcoded-trigger';} ?>">
                <a href="javascript:void(0)" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="fa fa-money"></i></span>
                    <span class="pcoded-mtext"  data-i18n="nav.basic-components.main">Keuangan</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="<?php if($Page=="TarifTindakan"){echo 'active';} ?>">
                        <a href="index.php?Page=TarifTindakan" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.breadcrumbs">Tarif/Tindakan</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Page=="Supplier"){echo 'active';} ?>">
                        <a href="index.php?Page=Supplier" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.breadcrumbs">Supplier</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Page=="AkunPerkiraan"){echo 'active';} ?>">
                        <a href="index.php?Page=AkunPerkiraan" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.breadcrumbs">Akun Perkiraan</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Page=="Transaksi"){echo 'active';} ?>">
                        <a href="index.php?Page=Transaksi" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.breadcrumbs">Transaksi</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Page=="Jurnal"){echo 'active';} ?>">
                        <a href="index.php?Page=Jurnal" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.breadcrumbs">Jurnal</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Page=="BukuBesar"){echo 'active';} ?>">
                        <a href="index.php?Page=BukuBesar" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.breadcrumbs">Buku Besar</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Page=="NeracaSaldo"){echo 'active';} ?>">
                        <a href="index.php?Page=NeracaSaldo" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.breadcrumbs">Neraca Saldo</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Page=="Persediaan"){echo 'active';} ?>">
                        <a href="index.php?Page=Persediaan" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.breadcrumbs">Persediaan</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Page=="PersediaanFarmasi"){echo 'active';} ?>">
                        <a href="index.php?Page=PersediaanFarmasi" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.breadcrumbs">Persediaan Farmasi</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Page=="Kas"){echo 'active';} ?>">
                        <a href="index.php?Page=Kas" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.breadcrumbs">KAS</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="pcoded-hasmenu <?php if($Page=="WebSetting"||$Page=="WebTentang"||$Page=="WebSambutan"||$Page=="WebMetaTag"||$Page=="WebSlider"||$Page=="WebFAQ"||$Page=="WebMedsos"||$Page=="WebSo"||$Page=="WebArtikel"||$Page=="WebEvent"||$Page=="WebArsip"||$Page=="WebDokter"||$Page=="WebPoliklinik"||$Page=="WebRuangRawat"||$Page=="WebUnit"||$Page=="WebTestimoni"||$Page=="WebEmailGateway"||$Page=="WebLoker"||$Page=="WebBantuan"||$Page=="WebHubungiAdmin"||$Page=="WebSiteMap"||$Page=="WebMonitoring"||$Page=="WebFooter"||$Page=="WebLaman"||$Page=="WebAksesPasien"||$Page=="WebKunjungan"){echo 'active pcoded-trigger';} ?>">
                <a href="javascript:void(0)" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="icofont-globe"></i></span>
                    <span class="pcoded-mtext"  data-i18n="nav.basic-components.main">Website</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="<?php if($Page=="WebSetting"){echo 'active bg-default';} ?>">
                        <a href="index.php?Page=WebSetting" class="waves-effect waves-dark">
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Setting</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Page=="WebEvent"){echo 'active bg-default';} ?>">
                        <a href="index.php?Page=WebEvent" class="waves-effect waves-dark">
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Album Event</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Page=="WebArsip"){echo 'active bg-default';} ?>">
                        <a href="index.php?Page=WebArsip" class="waves-effect waves-dark">
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Arsip</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Page=="WebArtikel"){echo 'active bg-default';} ?>">
                        <a href="index.php?Page=WebArtikel" class="waves-effect waves-dark">
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Artikel</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Page=="WebBantuan"){echo 'active bg-default';} ?>">
                        <a href="index.php?Page=WebBantuan" class="waves-effect waves-dark">
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Bantuan Web</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Page=="WebFAQ"){echo 'active bg-default';} ?>">
                        <a href="index.php?Page=WebFAQ" class="waves-effect waves-dark">
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">FAQ</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Page=="WebFooter"){echo 'active bg-default';} ?>">
                        <a href="index.php?Page=WebFooter" class="waves-effect waves-dark">
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Footer Menu</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Page=="WebSlider"){echo 'active bg-default' ;} ?>">
                        <a href="index.php?Page=WebSlider" class="waves-effect waves-dark">
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Hero/Slider</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Page=="WebHubungiAdmin"){echo 'active bg-default';} ?>">
                        <a href="index.php?Page=WebHubungiAdmin" class="waves-effect waves-dark">
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Hubungi Admin</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Page=="WebLaman"){echo 'active bg-default';} ?>">
                        <a href="index.php?Page=WebLaman" class="waves-effect waves-dark">
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Laman Mandiri</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Page=="WebLoker"){echo 'active bg-default';} ?>">
                        <a href="index.php?Page=WebLoker" class="waves-effect waves-dark">
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Lowongan Kerja</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Page=="WebMedsos"){echo 'active bg-default';} ?>">
                        <a href="index.php?Page=WebMedsos" class="waves-effect waves-dark">
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Medsos</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Page=="WebMetaTag"){echo 'active bg-default';} ?>">
                        <a href="index.php?Page=WebMetaTag" class="waves-effect waves-dark">
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Meta Tag</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Page=="WebAksesPasien"){echo 'active bg-default';} ?>">
                        <a href="index.php?Page=WebAksesPasien" class="waves-effect waves-dark">
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Pendaftaran Akun</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Page=="WebKunjungan"){echo 'active bg-default';} ?>">
                        <a href="index.php?Page=WebKunjungan" class="waves-effect waves-dark">
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Pendaftaran Kunjungan</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Page=="WebDokter"){echo 'active bg-default';} ?>">
                        <a href="index.php?Page=WebDokter" class="waves-effect waves-dark">
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Referensi Dokter</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Page=="WebPoliklinik"){echo 'active bg-default';} ?>">
                        <a href="index.php?Page=WebPoliklinik" class="waves-effect waves-dark">
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Referensi Poliklinik</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Page=="WebRuangRawat"){echo 'active bg-default';} ?>">
                        <a href="index.php?Page=WebRuangRawat" class="waves-effect waves-dark">
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Referensi Ruangan</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Page=="WebSambutan"){echo 'active bg-default';} ?>">
                        <a href="index.php?Page=WebSambutan" class="waves-effect waves-dark">
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Sambutan Direktur</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Page=="WebEmailGateway"){echo 'active bg-default';} ?>">
                        <a href="index.php?Page=WebEmailGateway" class="waves-effect waves-dark">
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Setting Email</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Page=="WebTentang"){echo 'active bg-default';} ?>">
                        <a href="index.php?Page=WebTentang" class="waves-effect waves-dark">
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Setting Tentang</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    
                    <li class="<?php if($Page=="WebSiteMap"){echo 'active bg-default';} ?>">
                        <a href="index.php?Page=WebSiteMap" class="waves-effect waves-dark">
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Site Map</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Page=="WebSo"){echo 'active bg-default';} ?>">
                        <a href="index.php?Page=WebSo" class="waves-effect waves-dark">
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Struktur Organisasi</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Page=="WebTestimoni"){echo 'active bg-default';} ?>">
                        <a href="index.php?Page=WebTestimoni" class="waves-effect waves-dark">
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Testimoni</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Page=="WebUnit"){echo 'active bg-default';} ?>">
                        <a href="index.php?Page=WebUnit" class="waves-effect waves-dark">
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Unit/Instalasi</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Page=="WebMonitoring"){echo 'active bg-default';} ?>">
                        <a href="index.php?Page=WebMonitoring" class="waves-effect waves-dark">
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Web Monitoring</span>
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
                    <li class="<?php if($Sub=="DataSdm"){echo 'active bg-default';} ?>">
                        <a href="index.php?Page=SirsOnline&Sub=DataSdm" class="waves-effect waves-dark">
                            <span class="pcoded-micon"></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Nakes/SDM</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="<?php if($Sub=="PcrNakes"){echo 'active bg-default';} ?>">
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
            <li class="pcoded-hasmenu">
                <a href="javascript:void(0)" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti ti-direction"></i></span>
                    <span class="pcoded-mtext"  data-i18n="nav.basic-components.main">SISRUTE</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="">
                        <a href="index.php?Page=Sisrute&Sub=Referensi" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti ti-user"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Referensi</span>
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
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Top Diagnosa</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="pcoded-hasmenu">
                <a href="javascript:void(0)" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti ti-server"></i></span>
                    <span class="pcoded-mtext"  data-i18n="nav.basic-components.main">Database</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="">
                        <a href="index.php?Page=DatabasePasien" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti ti-user"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Pasien</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="">
                        <a href="index.php?Page=DatabaseKunjungan" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti ti-user"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Kunjungan</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="">
                        <a href="index.php?Page=DatabaseAntrian" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti ti-user"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Antrian</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="">
                        <a href="index.php?Page=DatabaseTarif" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti ti-user"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Tarif Tindakan</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="">
                        <a href="index.php?Page=DatabaseObat" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti ti-user"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Obat</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="<?php if($Page=="Bantuan"){echo 'active';} ?>">
                <a href="index.php?Page=Bantuan" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="icofont-question-circle"></i><b>D</b></span>
                    <span class="pcoded-mtext" data-i18n="nav.dash.main">Bantuan</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
            <li class="text-center mb-3">
                <span class="text-center mb-3">
                    Hallo
                </span>
            </li>
        </ul>

        <div class="text-center mb-3">
            <div class="main-menu-footer">
                <span class="text-center mb-3">
                    Hallo
                </span>
            </div>
        </div>
    </div>