<?php
    //Desiossion Akses
    $StatusAkses=GetStatusAccess($Conn,$SessionIdAkses,'9OjkuMqbsG');
    if($StatusAkses=="Yes"){
        $JumlahLaporan=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM laporan_pengguna"));
        $JumlahResponse=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM laporan_pengguna WHERE response!=''"));
?>
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">
                            <a href="" class="h5"><i class="icofont-envelope"></i> Laporan Pengguna</a>
                        </h5>
                        <p class="m-b-0">Kelola laporan pengguna dan berikan segera response atas keluhan tersebut.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <form action="javascript:void(0);" id="ProsesPencarianLaporanPengguna">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-block bg-c-blue">
                                                <div class="row align-items-center">
                                                    <div class="col-8">
                                                        <h4 class="text-light"><?php echo "$JumlahLaporan";?></h4>
                                                        <h6 class="text-light m-b-0">Semua Laporan</h6>
                                                    </div>
                                                    <div class="col-4 text-right text-light">
                                                        <i class="icofont-envelope icofont-3x"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-block bg-success">
                                                <div class="row align-items-center">
                                                    <div class="col-8">
                                                        <h4 class="text-light"><?php echo "$JumlahResponse";?></h4>
                                                        <h6 class="text-light m-b-0">Response</h6>
                                                    </div>
                                                    <div class="col-4 text-right text-light">
                                                        <i class="icofont-airplane icofont-3x"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-md-12 text-center">
                                                <div class="card-title">
                                                    <h4><i class="ti ti-search"></i> Cari Laporan Pengguna</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mt-3">
                                            <div class="col-md-6 mb-3">
                                                <select name="BatasData" id="BatasData" class="form-control">
                                                    <option value="5">5</option>
                                                    <option selected value="10">10</option>
                                                    <option value="25">25</option>
                                                    <option value="50">50</option>
                                                    <option value="100">100</option>
                                                </select>
                                                <small>Batas Tampilan Data</small>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <select name="KeywordBy" id="KeywordBy" class="form-control">
                                                    <option value="">Pilih</option>
                                                    <option value="nama">Nama Pengirim</option>
                                                    <option value="tanggal">Tanggal Dikirim</option>
                                                    <option value="judul">Judul Laporan</option>
                                                    <option value="response">Response Laporan</option>
                                                </select>
                                                <small>Mode Pencarian</small>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <input type="text" name="Keyword" id="Keyword" class="form-control">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <button type="submit" class="btn btn-sm btn-dark btn-block btn-round">
                                                    <i class="ti ti-search"></i> Cari
                                                </button>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <button type="button" class="btn btn-sm btn-success btn-block btn-round">
                                                    <i class="ti ti-download"></i> Cetak/Export
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-md-12 text-center">
                                                <div class="card-title">
                                                    <h4><i class="ti ti-email"></i> Daftar Laporan Pengguna</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="TabelLaporanPengguna"></div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php
    }else{
        include "_Page/UnPage/ErrorPage.php";
    }
?>
