<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-4">
                <div class="page-header-title">
                    <h5 class="m-b-10">
                        <a href="index.php?Page=Rujukan" class="h5">
                            <i class="icofont-letter"></i> Rujukan Pasien
                        </a>
                    </h5>
                    <p class="m-b-0">Kelola Data Rujukan Pasien</p>
                </div>
            </div>
            <div class="col-md-8 text-right">
                <a href="index.php?Page=Rujukan" class="btn btn-md btn-primary btn-round mr-2 mt-2">
                    <i class="ti ti-info text-white"></i> Info
                </a>
                <a href="index.php?Page=Rujukan&Sub=RujukanInternal" class="btn btn-md btn-inverse btn-round mr-2 mt-2">
                    <i class="icofont-database"></i> Internal
                </a>
                <a href="index.php?Page=Rujukan&Sub=RujukanBpjs" class="btn btn-md btn-primary btn-round mr-2 mt-2">
                    <i class="icofont-share"></i> BPJS
                </a>
                <a href="index.php?Page=Rujukan&Sub=RujukanKhusus" class="btn btn-md btn-primary btn-round mr-2 mt-2">
                    <i class="icofont-star"></i> Khusus
                </a>
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
                                <form action="javascript:void(0);" id="BatasPencarian">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <input type="number" min="1" class="form-control" name="batas" id="batas" value="10">
                                            <small>Batas</small>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" name="keyword" id="keyword" placeholder="Kata Kunci">
                                            <small>Pencarian</small>
                                        </div>
                                        <div class="col-md-6">
                                            <button type="submit" class="btn btn-sm btn-outline-secondary mb-2 mr-2"><i class="ti-search"></i> Cari</button>
                                            <a href="index.php?Page=Rujukan&Sub=BuatRujukan" class="btn btn-sm btn-outline-secondary mb-2 mr-2"><i class="ti-plus"></i> buat Rujukan</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div id="MenampilkanTabelRujukanInternal">
                                <!--  menampilkan data Rujukan disini -->
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