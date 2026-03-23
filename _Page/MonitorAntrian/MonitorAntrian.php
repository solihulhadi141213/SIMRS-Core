<?php
    date_default_timezone_set('Asia/Jakarta');
?>
<!-- Page-header start -->
<div class="page-header">
</div>
<!-- Page-header end -->
<div class="pcoded-inner-content">
    <!-- Main-body start -->
    <div class="main-body">
        <div class="page-wrapper">
            <!-- Page-body start -->
            <div class="page-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-block text-center">
                                <h4 class="text-info" id="TimeDate"><dt><?php echo date('d F Y'); ?></dt></h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="card">
                            <div class="card-block text-center">
                                <div class="row align-items-center">
                                    <div class="col-12">
                                        <h4>Nomor Antrian</h4>
                                        <h1 class="display-1" id="TampilkanNomorAntrian">00</h1>
                                    </div>
                                </div>
                                <div class="row align-items-center">
                                    <div class="col-12 mt-5 mb-5">
                                        <h5><dt>Poliklinik:</dt></h5>
                                        <h5 id="TampilkanKodePoli">None</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card">
                            <div class="card-block text-center">
                                <div class="row align-items-center">
                                    <div class="col-12">
                                        <h5><dt>Dokter : </dt></h5>
                                        <h3 id="TampilanNamaDokter">No Data</h3>
                                    </div>
                                </div>
                                <div class="row align-items-center">
                                    <div class="col-12 mt-4">
                                        <h4><dt>Kode Booking:</dt></h4>
                                        <h4 id="TampilkanKodebooking">00000000000</h4>
                                    </div>
                                </div>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Page-body end -->
        </div>
        <div id="styleSelector"> </div>
    </div>
</div>