<?php
    include "_Config/SimrsFunction.php";
    include "_Config/WebFunction.php";
    date_default_timezone_set('Asia/Jakarta');
    //jumlah User
    $JumlahPasien = mysqli_num_rows(mysqli_query($Conn, "SELECT id_pasien FROM pasien"));
    $JumlahPasien = "" . number_format($JumlahPasien,0,',','.');
    $JumlahKunjungan = mysqli_num_rows(mysqli_query($Conn, "SELECT id_kunjungan FROM kunjungan_utama"));
    $JumlahKunjungan = "" . number_format($JumlahKunjungan,0,',','.');
    $JumlahAntrian = mysqli_num_rows(mysqli_query($Conn, "SELECT id_antrian FROM antrian WHERE status='Terdaftar'"));
    $JumlahAntrian = "" . number_format($JumlahAntrian,0,',','.');
    $JumlahDokter = mysqli_num_rows(mysqli_query($Conn, "SELECT id_dokter FROM dokter WHERE status='Aktiv'"));
    $JumlahPoliklinik = mysqli_num_rows(mysqli_query($Conn, "SELECT id_poliklinik FROM poliklinik"));
    //Informasi Lainnya
    $JumlahBed = mysqli_num_rows(mysqli_query($Conn, "SELECT id_ruang_rawat FROM ruang_rawat WHERE kategori='bed'"));
    $JumlahBed = "" . number_format($JumlahBed,0,',','.');
    $JumlahObat = mysqli_num_rows(mysqli_query($Conn, "SELECT id_obat FROM obat"));
    $JumlahObat = "" . number_format($JumlahObat,0,',','.');
    $JumlahAkses = mysqli_num_rows(mysqli_query($Conn, "SELECT id_akses FROM akses"));
    $JumlahAkses = "" . number_format($JumlahAkses,0,',','.');
    $JumlahLaboratorium = mysqli_num_rows(mysqli_query($Conn, "SELECT id_lab FROM laboratorium_pemeriksaan"));
    $JumlahLaboratorium = "" . number_format($JumlahLaboratorium,0,',','.');
    $JumlahRadiologi = mysqli_num_rows(mysqli_query($Conn, "SELECT id_rad FROM radiologi"));
    $JumlahRadiologi = "" . number_format($JumlahRadiologi,0,',','.');
    //Menangkap Data
    if(!empty($_POST['KategoriGrafik'])){
        $KategoriGrafik=$_POST['KategoriGrafik'];
    }else{
        $KategoriGrafik="";
    }
    if(!empty($_POST['tahun'])){
        $GetTahun=$_POST['tahun'];
    }else{
        $GetTahun="";
    }
    if(!empty($_POST['bulan'])){
        $GetBulan=$_POST['bulan'];
    }else{
        $GetBulan="";
    }
?>
<!-- Page-header start -->
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <a href="" class="text-white">
                        <h5 class="m-b-10" id="step1">Dashboard</h5>
                    </a>
                    <p class="m-b-0" id="step2">Ringkasan Data dan Informasi Faskes</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Page-header end -->
<div class="pcoded-inner-content">
    <!-- Main-body start -->
    <div class="main-body">
        <div class="page-wrapper">
            <!-- Page-body start -->
            <div class="page-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-block bg-c-blue">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h4 class="text-light"><?php echo "$JumlahPasien";?></h4>
                                        <h6 class="text-light m-b-0">Pasien</h6>
                                    </div>
                                    <div class="col-4 text-right text-light">
                                        <i class="icofont-patient-file icofont-3x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-block bg-c-orenge">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h4 class="text-light"><?php echo "$JumlahKunjungan";?></h4>
                                        <h6 class="text-light m-b-0">Kunjungan</h6>
                                    </div>
                                    <div class="col-4 text-right text-light">
                                        <i class="icofont-ambulance-cross icofont-3x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-block bg-amazon">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h4 class="text-light"><?php echo "$JumlahDokter";?></h4>
                                        <h6 class="text-light m-b-0">Dokter</h6>
                                    </div>
                                    <div class="col-4 text-right text-light">
                                        <i class="icofont-doctor-alt icofont-3x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-block bg-success">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h4 class="text-light"><?php echo "$JumlahPoliklinik";?></h4>
                                        <h6 class="text-light m-b-0">Poliklinik</h6>
                                    </div>
                                    <div class="col-4 text-right text-light">
                                        <i class="icofont-stethoscope-alt icofont-3x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-block bg-info">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h4 class="text-light"><?php echo "$JumlahBed";?></h4>
                                        <h6 class="text-light m-b-0">Tempat Tidur</h6>
                                    </div>
                                    <div class="col-4 text-right text-light">
                                        <i class="icofont-patient-bed icofont-3x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-block bg-youtube">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h4 class="text-light"><?php echo "$JumlahLaboratorium";?></h4>
                                        <h6 class="text-light m-b-0">Laboratorium</h6>
                                    </div>
                                    <div class="col-4 text-right text-light">
                                        <i class="icofont-test-tube icofont-3x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-block bg-c-lite-green">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h4 class="text-light"><?php echo "$JumlahObat";?></h4>
                                        <h6 class="text-light m-b-0">Item Obat</h6>
                                    </div>
                                    <div class="col-4 text-right text-light">
                                        <i class="icofont-pills icofont-3x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-block bg-instagram">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h4 class="text-light"><?php echo "$JumlahRadiologi";?></h4>
                                        <h6 class="text-light m-b-0">Radiologi</h6>
                                    </div>
                                    <div class="col-4 text-right text-light">
                                        <i class="icofont-xray icofont-3x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <h4><i class="icofont-chart-histogram"></i> Grafik Kunjungan Pasien</h4>
                                        </div>
                                        <div class="col-md-2 text-right">
                                            <a href="javascript:void(0);" id="PetunjukGrafik">
                                                <i class="ti ti-help-alt"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body" id="Grafic_Card">
                                    <form action="index.php" method="POST">
                                        <div class="row mb-4" id="FormFilterGrafik">
                                            <div class="col-md-3">
                                                <select name="KategoriGrafik" id="KategoriGrafik" class="form-control">
                                                    <option <?php if($KategoriGrafik=="Tahunan"){echo "selected";} ?> value="Tahunan">Tahunan</option>
                                                    <option <?php if($KategoriGrafik=="Bulanan"){echo "selected";} ?> value="Bulanan">Bulanan</option>
                                                </select>
                                                <small>Kategori</small>
                                            </div>
                                            <div class="col-md-3">
                                                <select name="tahun" id="tahun" class="form-control">
                                                    <?php
                                                        if(empty($GetTahun)){
                                                            $TahunSekarang=date('Y');
                                                        }else{
                                                            $TahunSekarang=$GetTahun;
                                                        }
                                                        for ($i=2017; $i<=$TahunSekarang; $i++ ){
                                                            if($TahunSekarang==$i){
                                                                echo '<option selected value="'.$i.'">'.$i.'</option>';
                                                            }else{
                                                                echo '<option value="'.$i.'">'.$i.'</option>';
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                                <small>Tahun</small>
                                            </div>
                                            <div class="col-md-3">
                                                <select name="bulan" id="bulan" class="form-control">
                                                    <?php
                                                        if(empty($GetBulan)){
                                                            $BulanSekarang=date('m');
                                                        }else{
                                                            $BulanSekarang=$GetBulan;
                                                        }
                                                        for ($i=1; $i<=12; $i++ ){
                                                            //ZeroPadding
                                                            $Bulan=sprintf("%02d", $i);
                                                            if($i==1){
                                                                $NamaBulan="Januari";
                                                            }else{
                                                                if($i==2){
                                                                    $NamaBulan="Februari";
                                                                }else{
                                                                    if($i==3){
                                                                        $NamaBulan="Maret";
                                                                    }else{
                                                                        if($i==4){
                                                                            $NamaBulan="April";
                                                                        }else{
                                                                            if($i==5){
                                                                                $NamaBulan="Mei";
                                                                            }else{
                                                                                if($i==6){
                                                                                    $NamaBulan="Juni";
                                                                                }else{
                                                                                    if($i==7){
                                                                                        $NamaBulan="Juli";
                                                                                    }else{
                                                                                        if($i==8){
                                                                                            $NamaBulan="Agustus";
                                                                                        }else{
                                                                                            if($i==9){
                                                                                                $NamaBulan="September";
                                                                                            }else{
                                                                                                if($i==10){
                                                                                                    $NamaBulan="Oktober";
                                                                                                }else{
                                                                                                    if($i==11){
                                                                                                        $NamaBulan="November";
                                                                                                    }else{
                                                                                                        if($i==12){
                                                                                                            $NamaBulan="Desember";
                                                                                                        }else{
                                                                                                            $NamaBulan="$i";
                                                                                                        }
                                                                                                    }
                                                                                                }
                                                                                            }
                                                                                        }
                                                                                    }
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                            if($Bulan==$BulanSekarang){
                                                                echo '<option selected value="'.$Bulan.'">'.$NamaBulan.'</option>';
                                                            }else{
                                                                echo '<option value="'.$Bulan.'">'.$NamaBulan.'</option>';
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                                <small>Bulan</small>
                                            </div>
                                            <div class="col-md-3">
                                                <button type="submit" class="btn btn-md btn-outline-dark btn-block">
                                                    <i class="ti-arrow-circle-down"></i> Tampilkan
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="row">
                                        <div class="col-md-12" id="GrafikPasien">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="card ">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-10">
                                        <h4><i class="icofont-connection"></i> Koneksi</h4>
                                    </div>
                                    <div class="col-md-2 text-right">
                                        <a href="javascript:void(0);" id="ReloadConnection" class="text-info">
                                            <i class="ti ti-reload"></i> Reload Connection
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row mb-2 sub-title">
                                    <div class="col-md-6">Satu Sehat</div>
                                    <div class="col-md-6 text-right" id="KoneksiSatuSehat"></div>
                                </div>
                                <div class="row mb-2 sub-title">
                                    <div class="col-md-6">Bridging BPJS</div>
                                    <div class="col-md-6 text-right" id="KoneksiBridging"></div>
                                </div>
                                <div class="row mb-2 sub-title">
                                    <div class="col-md-6">Website</div>
                                    <div class="col-md-6 text-right" id="KoneksiWebsite"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>