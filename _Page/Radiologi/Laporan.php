<?php
    if(empty($_POST['PeriodeDataExport'])){
        $PeriodeDataExport="Tahunan";
    }else{
        $PeriodeDataExport=$_POST['PeriodeDataExport'];
    }
    if(empty($_POST['TahunData'])){
        $TahunData=date('Y');
    }else{
        $TahunData=$_POST['TahunData'];
    }
    if(empty($_POST['BulanData'])){
        $BulanData=date('m');
    }else{
        $BulanData=$_POST['BulanData'];
    }
    if(empty($_POST['KeywordWaktu'])){
        $KeywordWaktu=date('Y-m-d');
    }else{
        $KeywordWaktu=$_POST['KeywordWaktu'];
    }
    $BulanTahun="$TahunData-$BulanData";
    //Tampilkan Data Berdasarkan Periode
    if($PeriodeDataExport=="Tahunan"){
        $JumlahSemuaRad=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM radiologi WHERE waktu like '%$TahunData%'"));
        $JumlahSelesaiRad=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM radiologi WHERE waktu like '%$TahunData%' AND status_pemeriksaan='Selesai'"));
        $JumlahBelumSelesaiRad=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM radiologi WHERE waktu like '%$TahunData%' AND status_pemeriksaan!='Selesai'"));
        //Menghitung Waktu Rata-rata
        $JumlahSelisih=0;
        $QryRad = mysqli_query($Conn, "SELECT*FROM radiologi WHERE waktu like '%$TahunData%'");
        while ($DataRad = mysqli_fetch_array($QryRad)) {
            if(!empty($DataRad['selesai'])){
                if(!empty($DataRad['waktu'])){
                    $WaktuMulai= $DataRad['waktu'];
                    $WaktuSelesai= $DataRad['selesai'];
                    $awal  = date_create($WaktuMulai);
                    $akhir = date_create($WaktuSelesai); 
                    if(!empty(date_diff($awal,$akhir ))){
                        $diff  = date_diff($awal,$akhir );
                        $Selisih=$diff->i;
                        $JumlahSelisih=$JumlahSelisih+$Selisih;
                    }else{
                        $JumlahSelisih=$JumlahSelisih+0;
                    }
                    
                }else{
                    $JumlahSelisih=$JumlahSelisih+0;
                }
            }else{
                $JumlahSelisih=$JumlahSelisih+0;
            }
        }
        if(!empty($JumlahSemuaRad)){
            $RataRata=$JumlahSelisih/$JumlahSemuaRad;
            $RataRata=round($RataRata,2);
        }else{
            $RataRata=0;
        }
        
    }else{
        if($PeriodeDataExport=="Bulanan"){
            $JumlahSemuaRad=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM radiologi WHERE waktu like '%$BulanTahun%'"));
            $JumlahSelesaiRad=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM radiologi WHERE waktu like '%$BulanTahun%' AND status_pemeriksaan='Selesai'"));
            $JumlahBelumSelesaiRad=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM radiologi WHERE waktu like '%$BulanTahun%' AND status_pemeriksaan!='Selesai'"));
            //Menghitung Waktu Rata-rata
            $JumlahSelisih=0;
            $QryRad = mysqli_query($Conn, "SELECT*FROM radiologi WHERE waktu like '%$BulanTahun%'");
            while ($DataRad = mysqli_fetch_array($QryRad)) {
                $WaktuMulai= $DataRad['waktu'];
                $WaktuSelesai= $DataRad['selesai'];
                $awal  = date_create($WaktuMulai);
                $akhir = date_create($WaktuSelesai); 
                $diff  = date_diff( $awal, $akhir );
                $Selisih=$diff->i;
                $JumlahSelisih=$JumlahSelisih+$Selisih;
            }
            if(!empty($JumlahSemuaRad)){
                $RataRata=$JumlahSelisih/$JumlahSemuaRad;
                $RataRata=round($RataRata,2);
            }else{
                $RataRata=0;
            }
        }else{
            $JumlahSemuaRad=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM radiologi WHERE waktu like '%$KeywordWaktu%'"));
            $JumlahSelesaiRad=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM radiologi WHERE waktu like '%$KeywordWaktu%' AND status_pemeriksaan='Selesai'"));
            $JumlahBelumSelesaiRad=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM radiologi WHERE waktu like '%$KeywordWaktu%' AND status_pemeriksaan!='Selesai'"));
            //Menghitung Waktu Rata-rata
            $JumlahSelisih=0;
            $QryRad = mysqli_query($Conn, "SELECT*FROM radiologi WHERE waktu like '%$KeywordWaktu%'");
            while ($DataRad = mysqli_fetch_array($QryRad)) {
                $WaktuMulai= $DataRad['waktu'];
                $WaktuSelesai= $DataRad['selesai'];
                $awal  = date_create($WaktuMulai);
                $akhir = date_create($WaktuSelesai); 
                $diff  = date_diff( $awal, $akhir );
                $Selisih=$diff->i;
                $JumlahSelisih=$JumlahSelisih+$Selisih;
            }
            if(!empty($JumlahSemuaRad)){
                $RataRata=$JumlahSelisih/$JumlahSemuaRad;
                $RataRata=round($RataRata,2);
            }else{
                $RataRata=0;
            }
        }
    }
?>
<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <div class="card bg-info">
                            <div class="card-body">
                                <h3><i class="icofont-patient-file icofont-2x"></i> <?php echo "$JumlahSemuaRad"; ?></h3>
                                Semua Pelayanan 
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card bg-success">
                            <div class="card-body">
                                <h3><i class="icofont-prescription icofont-2x"></i> <?php echo "$JumlahSelesaiRad"; ?></h3>
                                Pelayanan Selesai
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card bg-facebook">
                            <div class="card-body text-white">
                                <h3><i class="icofont-wall-clock icofont-2x"></i> <?php echo "$RataRata Mn"; ?></h3>
                                Rata-Rata Waktu Layanan
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card bg-c-orenge">
                            <div class="card-body text-white">
                                <h3><i class="icofont-finger-print icofont-2x"></i> <?php echo "$JumlahBelumSelesaiRad"; ?></h3>
                                Belum Terverifikasi
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <form action="index.php?Page=Radiologi&Sub=Laporan" method="POST" id="FormShortLaporan">
                            <input type="hidden" id="GetTahunForm" value="<?php echo "$TahunData"; ?>">
                            <input type="hidden" id="GetBulanForm" value="<?php echo "$BulanData"; ?>">
                            <input type="hidden" id="GetWaktu" value="<?php echo "$KeywordWaktu"; ?>">
                            <div class="card">
                                <div class="card-header">
                                    <dt>
                                        <i class="icofont-settings icofont-2x"></i> Atur Periode Waktu
                                    </dt>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 mb-4">
                                            <label for="PeriodeDataExport">Periode Data</label>
                                            <select name="PeriodeDataExport" id="PeriodeDataExport" class="form-control">
                                                <option <?php if($PeriodeDataExport=="Tahunan"){echo "selected";} ?> value="Tahunan">Tahunan</option>
                                                <option <?php if($PeriodeDataExport=="Bulanan"){echo "selected";} ?> value="Bulanan">Bulanan</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row" id="SwitchKeteranganWaktu">
                                        <div class="col-md-12 mb-4">
                                            <label for="TahunData">
                                                <dt>Tahun Data</dt>
                                            </label>
                                            <select name="TahunData" id="TahunData" class="form-control">
                                                <?php
                                                    for ( $i=2010; $i<=date('Y'); $i++ ){
                                                        if($i==date('Y')){
                                                            echo '<option selected value="'.$i.'">'.$i.'</option>';
                                                        }else{
                                                            echo '<option value="'.$i.'">'.$i.'</option>';
                                                        }
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-md btn-outline-dark btn-block">
                                        Tampilkan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-9 mb-3">
                        <div class="card">
                            <div class="card-header">
                                <dt>
                                    <i class="icofont-chart-growth icofont-2x"></i> Grafik Jumlah Pasien Radiologi
                                </dt>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12" id="GrafikData">

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