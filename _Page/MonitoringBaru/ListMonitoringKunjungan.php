<?php
    date_default_timezone_set('UTC');
    include "../../_Config/Connection.php";
    include "../../_Config/SettingBridging.php";
    include "../../_Config/SimrsFunction.php";
    include "../../vendor/autoload.php";
    if(empty($_POST['KunjunganPeriodeAwal'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center text-danger">Periode Awal Pencarian Belum Diisi!</div>';
        echo '</div>';
    }else{
        if(empty($_POST['KunjunganPeriodeAkhir'])){
            echo '<div class="row">';
            echo '  <div class="col-md-12 text-center text-danger">Periode Akhir Pencarian Belum Diisi!</div>';
            echo '</div>';
        }else{
            if(empty($_POST['JenisPelayanan'])){
                echo '<div class="row">';
                echo '  <div class="col-md-12 text-center text-danger">Periode Akhir Pencarian Belum Diisi!</div>';
                echo '</div>';
            }else{
                $PeriodeAwal=$_POST['KunjunganPeriodeAwal'];
                $PeriodeAkhir=$_POST['KunjunganPeriodeAkhir'];
                $JenisPelayanan=$_POST['JenisPelayanan'];
                $timestamp_awal = strtotime($PeriodeAwal);
                $timestamp_akhir = strtotime($PeriodeAkhir);
                if($timestamp_akhir<=$timestamp_awal){
                    echo '<div class="row">';
                    echo '  <div class="col-md-12 text-center text-danger">Periode Data Pencarian Tidak Valid!</div>';
                    echo '</div>';
                }else{
                    $no=1;
                    for ($current_timestamp = $timestamp_awal; $current_timestamp <= $timestamp_akhir; $current_timestamp += 86400) {
                        $tanggal_perulangan = date('Y-m-d', $current_timestamp);
                        $LabelTanggal = date('d/m/Y', $current_timestamp);
    ?>
                        <div class="accordion-panel">
                            <div class="accordion-heading" role="tab" id="HeadingKunjungan<?php echo $no;?>">
                                <h3 class="card-title accordion-title">
                                    <a class="accordion-msg waves-effect waves-dark scale_active collapsed" data-toggle="collapse" data-parent="#accordionKunjungan" href="#CollapseKunjungan<?php echo $no;?>" aria-expanded="false" aria-controls="CollapseKunjungan<?php echo $no;?>">
                                        <dt><?php echo "$no. Tanggal $LabelTanggal";?> <span id="PutJumlah<?php echo $no;?>"></span></dt>
                                    </a>
                                </h3>
                            </div>
                            <div id="CollapseKunjungan<?php echo $no;?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="HeadingKunjungan<?php echo $no;?>">
                                <div class="accordion-content accordion-desc">
                                    <!-- Lis Berdasarkan Jenis Pelayanan -->
                                    <?php include "../../_Page/MonitoringBaru/ListMonitoringKunjunganRanapRajal.php"; ?>
                                </div>
                            </div>
                        </div>
<?php
                        $no++;
                    }
                }
            }
        }
    }
?>