<?php
    // Mendapatkan tanggal saat ini
    $today = date('Y-m-d');
    // Menggunakan fungsi date untuk mendapatkan tahun dan bulan saat ini
    $year = date('Y');
    $month = date('m');
    // Membuat tanggal awal bulan ini dengan mengganti tanggal menjadi 01
    $firstDayOfMonth = date('Y-m-d', strtotime("$year-$month-01"));
    if(empty($_GET['KategoriMonitoring'])){
        $KategoriMonitoring="";
    }else{
        $KategoriMonitoring=$_GET['KategoriMonitoring'];
    }
?>

<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="row">
                    <div class="col-xl-4 col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">
                                    <i class="ti ti-menu"></i> Monitoring
                                </h4>
                            </div>
                            <div class="card-block accordion-block">
                                <div id="accordion" role="tablist" aria-multiselectable="true">
                                    <div class="accordion-panel active">
                                        <div class="accordion-heading" role="tab" id="headingOne">
                                            <h3 class="card-title accordion-title">
                                                <a class="accordion-msg waves-effect waves-dark scale_active collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                                    A. Monitoring Bridging BPJS
                                                </a>
                                            </h3>
                                        </div>
                                        <div id="collapseOne" class="panel-collapse in collapse <?php if($KategoriMonitoring=="MonitoringKunjungan"||$KategoriMonitoring=="MonitoringKlaim"||$KategoriMonitoring=="MonitoringRujukanKeluar"||$KategoriMonitoring=="MonitoringLpk"){echo "show";} ?>" role="tabpanel" aria-labelledby="headingOne" style="">
                                            <div class="accordion-content accordion-desc">
                                                <ul class="list-group list-group-flush">
                                                    <li class="list-group-item">
                                                        <a href="index.php?Page=MonitoringBaru&KategoriMonitoring=MonitoringKunjungan" class="<?php if($KategoriMonitoring==""||$KategoriMonitoring=="MonitoringKunjungan"){echo "text-primary";} ?>">A.1. Kunjungan SEP</a>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <a href="index.php?Page=MonitoringBaru&KategoriMonitoring=MonitoringKlaim" class="<?php if($KategoriMonitoring=="MonitoringKlaim"){echo "text-primary";} ?>">A.2. Klaim Pasien</a>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <a href="index.php?Page=MonitoringBaru&KategoriMonitoring=MonitoringRujukanKeluar" class="<?php if($KategoriMonitoring=="MonitoringRujukanKeluar"){echo "text-primary";} ?>">A.3. Rujukan Keluar</a>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <a href="index.php?Page=MonitoringBaru&KategoriMonitoring=MonitoringLpk" class="<?php if($KategoriMonitoring=="MonitoringLpk"){echo "text-primary";} ?>">A.4. Lembar Pengajuan Klaim</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="accordion-heading" role="tab" id="headingTwo">
                                            <h3 class="card-title accordion-title">
                                                <a class="accordion-msg waves-effect waves-dark scale_active collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                    B. Indikator Pelayanan SIMRS
                                                </a>
                                            </h3>
                                        </div>
                                        <div id="collapseTwo" class="panel-collapse in collapse" role="tabpanel" aria-labelledby="headingTwo" style="">
                                            <div class="accordion-content accordion-desc">
                                                <ul class="list-group list-group-flush">
                                                    <li class="list-group-item">
                                                        <a href="">Pasien Baru</a>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <a href="">Kunjungan Pasien</a>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <a href="">Indikator Pelayanan</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8 col-md-8">
                        <?php
                            if(empty($_GET['KategoriMonitoring'])){
                                include "_Page/MonitoringBaru/MonitoringKunjungan.php";
                            }else{
                                $KategoriMonitoring=$_GET['KategoriMonitoring'];
                                if($KategoriMonitoring=="MonitoringKunjungan"){
                                    include "_Page/MonitoringBaru/MonitoringKunjungan.php";
                                }else{
                                    if($KategoriMonitoring=="MonitoringKlaim"){
                                        include "_Page/MonitoringBaru/MonitoringKlaim.php";
                                    }else{
                                        if($KategoriMonitoring=="MonitoringRujukanKeluar"){
                                            include "_Page/MonitoringBaru/MonitoringRujukanKeluar.php";
                                        }else{
                                            if($KategoriMonitoring=="MonitoringLpk"){
                                                include "_Page/MonitoringBaru/MonitoringLpk.php";
                                            }else{
            
                                            }
                                        }
                                    }
                                }
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>