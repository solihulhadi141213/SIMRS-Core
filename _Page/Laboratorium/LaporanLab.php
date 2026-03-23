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
        $JumlahLayanan=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM laboratorium_permintaan WHERE tanggal like '%$TahunData%'"));
        $JumlahDiterima=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM laboratorium_permintaan WHERE tanggal like '%$TahunData%' AND (status!='Ditolak') AND (status!='Pending')"));
        $JumlahDitolak=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM laboratorium_permintaan WHERE tanggal like '%$TahunData%' AND status='Ditolak'"));
        //Menghitung Waktu Rata-rata
        $JumlahSelisih=0;
        $JumlahData=0;
        $QryRad = mysqli_query($Conn, "SELECT*FROM laboratorium_permintaan WHERE (tanggal like '%$TahunData%') AND (status='Selesai')");
        while ($DataRad = mysqli_fetch_array($QryRad)) {
            $id_permintaan= $DataRad['id_permintaan'];
            if(!empty($DataRad['tanggal'])){
                $Mulai= $DataRad['tanggal'];
                $Selesai=getDataDetail($Conn,'laboratorium_pemeriksaan','id_permintaan',$id_permintaan,'hasil_diserahkan');
                if(!empty($Selesai)){
                    $awal  = strtotime($Mulai);
                    $akhir = strtotime($Selesai);
                    $diff  = $akhir - $awal;
                    $DurasiJam   = $diff / ( 60 * 60);
                    $DurasiMenit   = $DurasiJam * 60;
                    $JumlahSelisih=$JumlahSelisih+$DurasiMenit;
                    $JumlahData=$JumlahData+1;
                }else{
                    $JumlahSelisih=$JumlahSelisih+0;
                    $JumlahData=$JumlahData+0;
                }
            }else{
                $JumlahSelisih=$JumlahSelisih+0;
                $JumlahData=$JumlahData+0;
            }
        }
        if(!empty($JumlahSelisih)){
            $RataRata=$JumlahSelisih/$JumlahData;
            $RataRata=round($RataRata);
        }else{
            $RataRata=0;
        }
    }else{
        if($PeriodeDataExport=="Bulanan"){
            $JumlahLayanan=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM laboratorium_permintaan WHERE tanggal like '%$BulanTahun%'"));
            $JumlahDiterima=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM laboratorium_permintaan WHERE (tanggal like '%$BulanTahun%') AND (status!='Ditolak')"));
            $JumlahDitolak=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM laboratorium_permintaan WHERE tanggal like '%$BulanTahun%' AND status='Ditolak'"));
            //Menghitung Waktu Rata-rata
            $JumlahSelisih=0;
            $JumlahData=0;
            $QryRad = mysqli_query($Conn, "SELECT*FROM laboratorium_permintaan WHERE (tanggal like '%$BulanTahun%') AND (status='Selesai')");
            while ($DataRad = mysqli_fetch_array($QryRad)) {
                $id_permintaan= $DataRad['id_permintaan'];
                $status= $DataRad['status'];
                if(!empty($DataRad['tanggal'])){
                    $Mulai= $DataRad['tanggal'];
                    $Selesai=getDataDetail($Conn,'laboratorium_pemeriksaan','id_permintaan',$id_permintaan,'hasil_diserahkan');
                    if(!empty($Selesai)){
                        $awal  = strtotime($Mulai);
                        $akhir = strtotime($Selesai);
                        $diff  = $akhir - $awal;
                        $DurasiJam   = $diff / ( 60 * 60);
                        $DurasiMenit   = $DurasiJam * 60;
                        $JumlahSelisih=$JumlahSelisih+$DurasiMenit;
                        $JumlahData=$JumlahData+1;
                    }else{
                        $JumlahSelisih=$JumlahSelisih+0;
                        $JumlahData=$JumlahData+0;
                    }
                }else{
                    $JumlahSelisih=$JumlahSelisih+0;
                    $JumlahData=$JumlahData+0;
                }
            }
            if(!empty($JumlahSelisih)){
                $RataRata=$JumlahSelisih/$JumlahData;
                $RataRata=round($RataRata);
            }else{
                $RataRata=0;
            }
        }else{
            $JumlahLayanan=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM laboratorium_permintaan WHERE tanggal like '%$KeywordWaktu%'"));
            $JumlahDiterima=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM laboratorium_permintaan WHERE tanggal (like '%$KeywordWaktu%') AND (status!='Ditolak')"));
            $JumlahDitolak=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM laboratorium_permintaan WHERE tanggal like '%$KeywordWaktu%' AND status='Ditolak'"));
            //Menghitung Waktu Rata-rata
            $JumlahSelisih=0;
            $JumlahData=0;
            $QryRad = mysqli_query($Conn, "SELECT*FROM laboratorium_permintaan WHERE (tanggal like '%$KeywordWaktu%') AND (status='Selesai')");
            while ($DataRad = mysqli_fetch_array($QryRad)) {
                $id_permintaan= $DataRad['id_permintaan'];
                if(!empty($DataRad['tanggal'])){
                    $Mulai= $DataRad['tanggal'];
                    $Selesai=getDataDetail($Conn,'laboratorium_pemeriksaan','id_permintaan',$id_permintaan,'hasil_diserahkan');
                    if(!empty($Selesai)){
                        $awal  = strtotime($Mulai);
                        $akhir = strtotime($Selesai);
                        $diff  = $akhir - $awal;
                        $DurasiJam   = $diff / ( 60 * 60);
                        $DurasiMenit   = $DurasiJam * 60;
                        $JumlahSelisih=$JumlahSelisih+$DurasiMenit;
                        $JumlahData=$JumlahData+1;
                    }else{
                        $JumlahSelisih=$JumlahSelisih+0;
                        $JumlahData=$JumlahData+0;
                    }
                }else{
                    $JumlahSelisih=$JumlahSelisih+0;
                    $JumlahData=$JumlahData+0;
                }
            }
            if(!empty($JumlahSelisih)){
                $RataRata=$JumlahSelisih/$JumlahData;
                $RataRata=round($RataRata);
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
                                <h3><i class="icofont-patient-file icofont-2x"></i> <?php echo "$JumlahLayanan"; ?></h3>
                                Semua Pelayanan 
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card bg-success">
                            <div class="card-body">
                                <h3><i class="icofont-prescription icofont-2x"></i> <?php echo "$JumlahDiterima"; ?></h3>
                                Pelayanan Diterima
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card bg-c-orenge">
                            <div class="card-body text-white">
                                <h3><i class="icofont-close icofont-2x"></i> <?php echo "$JumlahDitolak"; ?></h3>
                                Layanan Ditolak
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
                    
                </div>
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <form action="index.php?Page=Laboratorium&Sub=LaporanLab" method="POST" id="FormShortLaporan">
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
                                    <i class="icofont-chart-growth icofont-2x"></i> Grafik Jumlah Pasien Laboratorium
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