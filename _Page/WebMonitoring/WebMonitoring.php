<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">
                        <a href="" class="h5"><i class="ti ti-bar-chart"></i> Web Monitoring</a>
                    </h5>
                    <p class="m-b-0">Lihat Performa Website Berdasarkan Visitor</p>
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
                    <div class="col-xl-12 col-md-12">
                        <div class="card table-card">
                            <div class="card-header border-info">
                                <form action="_Page/WebMonitoring/CetakWebMonitoring.php" method="POST" target="_blank" id="FormMonitoring">
                                    <div class="row">
                                        <div class="col-md-2 mb-3">
                                            <select name="periode" id="periode" class="form-control">
                                                <option value="Tahunan">Tahunan</option>
                                                <option value="Bulanan">Bulanan</option>
                                            </select>
                                            <small>Batas</small>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <select name="tahun" id="tahun" class="form-control">
                                                <option value="">Pilih</option>
                                                <?php
                                                    $TahunSekarang=date('Y');
                                                    $a=2010;
                                                    $b=$TahunSekarang;
                                                    for ( $i =$a; $i<=$b; $i++ ){
                                                        if($i==$TahunSekarang){
                                                            echo '<option selected value="'.$i.'">'.$i.'</option>';
                                                        }else{
                                                            echo '<option value="'.$i.'">'.$i.'</option>';
                                                        }
                                                    }
                                                ?>
                                            </select>
                                            <small>Tahun</small>
                                        </div>
                                        <div class="col-md-3 mb-3" id="FormBulan">
                                            <input readonly type="text" id="bulan" name="bulan" class="form-control">
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <button type="button" class="btn btn-sm btn-block btn-secondary" id="TombolTampilkan">
                                                <i class="ti-search"></i> Tampilkan
                                            </button>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <button type="submit" class="btn btn-sm btn-block btn-primary">
                                                <i class="ti-printer"></i> Cetak
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <div id="TampilkanGrafik">

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-3" id="TampilkanTabel">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="styleSelector">

        </div>
    </div>
</div>