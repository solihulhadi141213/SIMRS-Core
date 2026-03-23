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
                <a href="index.php?Page=Rujukan&Sub=RujukanInternal" class="btn btn-md btn-primary btn-round mr-2 mt-2">
                    <i class="icofont-database"></i> Internal
                </a>
                <a href="index.php?Page=Rujukan&Sub=RujukanBpjs" class="btn btn-md btn-primary btn-round mr-2 mt-2">
                    <i class="icofont-share"></i> BPJS
                </a>
                <a href="index.php?Page=Rujukan&Sub=RujukanKhusus" class="btn btn-md btn-inverse btn-round mr-2 mt-2">
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
                                <form action="javascript:void(0);" id="ProsesPencarianRujukanKhusus" autocomplete="off">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <select name="bulan" id="bulan" class="form-control">
                                                <option value="1">Januari</option>
                                                <option value="2">Februari</option>
                                                <option value="3">Maret</option>
                                                <option value="4">April</option>
                                                <option value="5">Mei</option>
                                                <option value="6">Juni</option>
                                                <option value="7">Juli</option>
                                                <option value="8">Agustus</option>
                                                <option value="9">September</option>
                                                <option value="10">Oktober</option>
                                                <option value="11">November</option>
                                                <option value="12">Desember</option>
                                            </select>
                                            <small>Bulan</small>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="number" min="2019" max="<?php echo date('Y'); ?>" class="form-control" name="tahun" id="tahun">
                                            <small>Tahun</small>
                                        </div>
                                        
                                        <div class="col-md-3">
                                            <button type="submit" class="btn btn-sm btn-outline-secondary mb-2 mr-2"><i class="ti-search"></i> Cari</button>
                                            <a href="index.php?Page=Rujukan&Sub=BuatRujukanKhusus" class="btn btn-sm btn-outline-secondary mb-2 mr-2">
                                                <i class="ti-plus"></i> Rujukan Khusus
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="card-body" id="MenampilkanTabelRujukanKhusus">
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