<?php
    //Desiossion Akses
    $StatusAkses=GetStatusAccess($Conn,$SessionIdAkses,'kLOT1iidNU');
    if($StatusAkses=="Yes"){
        $JumlahLaporan=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM laporan_pengguna"));
        $JumlahResponse=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM laporan_pengguna WHERE response!=''"));
        date_default_timezone_set('Asia/Jakarta');
        //Jumlah Semua Antrian
        $JumlahSemuaAntrian=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM antrian"));
        $JumlahSemuaAntrian = "" . number_format($JumlahSemuaAntrian,0,',','.');
        //Jumlah Antrian Selesai
        $JumlahAntrianSelesai=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM antrian WHERE status='selesai'"));
        $JumlahAntrianSelesai = "" . number_format($JumlahAntrianSelesai,0,',','.');
        //Jumlah Antrian WS BPJS
        $JumlahAntrianWsBpjs=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM antrian WHERE ws_bpjs='1'"));
        $JumlahAntrianWsBpjs = "" . number_format($JumlahAntrianWsBpjs,0,',','.');
        //Jumlah Antrian Tanpa Kunjungan
        $JumlahAntrianTanpaKunjungan=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM antrian WHERE id_kunjungan=''"));
        $JumlahAntrianTanpaKunjungan = "" . number_format($JumlahAntrianTanpaKunjungan,0,',','.');
?>
<!-- Page-header start -->
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="page-header-title">
                    <h5 class="m-b-10"><i class="icofont-ticket"></i> Monitoring Antrian</h5>
                    <p class="m-b-0">Rekapitulasi Kinerja Antrian</p>
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
                    <div class="col col-lg-3 col-md-6 col-sm-12">
                        <div class="card">
                            <div class="card-block bg-c-blue">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h4 class="text-light"><?php echo "$JumlahSemuaAntrian";?></h4>
                                        <h6 class="text-light m-b-0">Semua Antrian</h6>
                                        <a href="javascript:void(0);" class="text-light" data-toggle="modal" data-target="#ModalInformasiSemuaAntrian">
                                            <small><i class="ti ti-info-alt"></i> Lihat Ini Apa</small>
                                        </a>
                                    </div>
                                    <div class="col-4 text-right text-light">
                                        <i class="icofont-ticket icofont-3x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col col-lg-3 col-md-6 col-sm-12">
                        <div class="card">
                            <div class="card-block bg-success">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h4 class="text-light"><?php echo "$JumlahAntrianSelesai";?></h4>
                                        <h6 class="text-light m-b-0">Antrian Selesai</h6>
                                        <a href="javascript:void(0);" class="text-light" data-toggle="modal" data-target="#ModalInformasiAntrianSelesai">
                                            <small><i class="ti ti-info-alt"></i> Lihat Ini Apa</small>
                                        </a>
                                    </div>
                                    <div class="col-4 text-right text-light">
                                        <i class="icofont-tick-boxed icofont-3x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col col-lg-3 col-md-6 col-sm-12">
                        <div class="card">
                            <div class="card-block bg-info">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h4 class="text-light"><?php echo "$JumlahAntrianWsBpjs";?></h4>
                                        <h6 class="text-light m-b-0">WS BPJS</h6>
                                        <a href="javascript:void(0);" class="text-light" data-toggle="modal" data-target="#ModalInformasiAntrianWsBpjs">
                                            <small><i class="ti ti-info-alt"></i> Lihat Ini Apa</small>
                                        </a>
                                    </div>
                                    <div class="col-4 text-right text-light">
                                        <i class="icofont-cloud-upload icofont-3x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col col-lg-3 col-md-6 col-sm-12">
                        <div class="card">
                            <div class="card-block bg-danger">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h4 class="text-light"><?php echo "$JumlahAntrianTanpaKunjungan";?></h4>
                                        <h6 class="text-light m-b-0">Tanpa Kunjungan</h6>
                                        <a href="javascript:void(0);" class="text-light" data-toggle="modal" data-target="#ModalInformasiAntrianTanpaKunjungan">
                                            <small><i class="ti ti-info-alt"></i> Lihat Ini Apa</small>
                                        </a>
                                    </div>
                                    <div class="col-4 text-right text-light">
                                        <i class="icofont-warning icofont-3x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-3 col-md-3">
                        <div class="card">
                            <form action="javascript:void(0);" method="POST" id="ProsesDashboardAntrianOnline" autocomplete="off">
                                <div class="card-header">
                                    <dt class="card-title">
                                        <i class="ti ti-search"></i> Monitoring Antrol
                                    </dt>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-4">
                                        <div class="col-md-12">
                                            <label for="">Mode Data</label>
                                            <select name="mode" id="mode" class="form-control">
                                                <option value="">pilih</option>
                                                <option value="Harian">Harian</option>
                                                <option selected value="Bulanan">Bulanan</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-md-12">
                                            <label for="waktu">Waktu</label>
                                            <select name="waktu" id="waktu" class="form-control">
                                                <option value="rs">Rumah Sakit</option>
                                                <option value="server">Server BPJS</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div id="FormLanjutan">
                                        <?php
                                            echo '<div class="row mb-4">';
                                            echo '  <div class="col-md-12">';
                                            echo '      <label for="">Bulan</label>';
                                            echo '      <input type="month" name="bulan" id="bulan" class="form-control" value="'.date('m').'">';
                                            echo '  </div>';
                                            echo '</div>';
                                            echo '<div class="row mb-4">';
                                            echo '  <div class="col-md-12">';
                                            echo '      <label for="">Tahun</label>';
                                            echo '      <input type="year" name="tahun" id="tahun" class="form-control" value="'.date('Y').'">';
                                            echo '  </div>';
                                            echo '</div>';
                                        ?>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-md btn-primary btn-block">
                                                <i class="ti-search"></i> Tampilkan
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-xl-9 col-md-9">
                        <div class="card">
                            <div class="card-header">
                                <dt class="card-title">
                                    Dashboard Antrian Online
                                </dt>
                            </div>
                            <div class="card-body" id="HasilDashboardAntrian">
                                <div class="row">
                                    <div class="col-md-12">
                                        <span class="text-info">
                                            Belum ada data yang bisa ditampilkan!
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <?php
                                    echo '<small>';
                                    echo "<dt>Keterangan :</dt>";
                                    echo "a) Waktu Task 1 = Waktu tunggu admisi dalam detik <br>";
                                    echo "b) Waktu Task 2 = Waktu layan admisi dalam detik  <br>";
                                    echo "c) Waktu Task 3 = Waktu tunggu poli dalam detik   <br>";
                                    echo "d) Waktu Task 4 = Waktu layan poli dalam detik    <br>";
                                    echo "e) Waktu Task 5 = Waktu tunggu farmasi dalam detik<br>";
                                    echo "g) Insertdate = Waktu pengambilan data, timestamp dalam milisecond <br>";
                                    echo "h) Waktu server adalah data waktu (task 1-6) yang dicatat oleh server BPJS Kesehatan setelah RS mengimkan data, sedangkan waktu rs adalah data waktu (task 1-6) yang dikirimkan oleh RS <br>";
                                    echo '</small>';
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    }else{
        include "_Page/UnPage/ErrorPage.php";
    }
?>