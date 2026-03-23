<?php
    //Desiossion Akses
    $StatusAkses=GetStatusAccess($Conn,$SessionIdAkses,'APzGdlAT7w');
    if($StatusAkses=="Yes"){
        include "_Config/SimrsFunction.php";
        include "_Config/FungsiSirsOnline.php";
        //Buka Pengaturan SIRS Online
        $x_id_rs=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','id_rs');
        $url_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','url_sirs_online');
        $password_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','password_sirs_online');
?>
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-xl-3 col-md-3 mb-3">
                            <div class="card mb-2">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <h4>
                                                <i class="icofont-search-document"></i> PCR Nakes
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <form action="javascript:void(0);" id="BatasDataPcrNakes">
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label for="keyword_by"><small>Dasar Pencarian</small></label>
                                                <select name="keyword_by" id="keyword_by" class="form-control">
                                                    <option value="">Pilih</option>
                                                    <option value="nama_nakes">Nama Nakes</option>
                                                    <option value="tanggal">Tanggal</option>
                                                    <option value="kategori_nakes">Kategori Nakes</option>
                                                    <option value="hasil_pcr">Hasil PCR</option>
                                                    <option value="id_akses">Petugas Entry</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 mb-3" id="FormKataKunci">
                                                <label for="keyword"><small>Kata Kunci</small></label>
                                                <input type="text" name="keyword" id="keyword" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <button type="submit" class="btn btn-sm btn-secondary btn-block">
                                                    <i class="ti-search"></i> Cari
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <button type="button" class="btn btn-block btn-sm btn-primary" data-toggle="modal" data-target="#ModalPilihNakesUntukPcr">
                                                    <i class="ti ti-plus"></i> Tambah
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <button type="button" class="btn btn-block btn-sm btn-info" data-toggle="modal" data-target="#ModalLaporanPcrNakes">
                                                    <i class="ti ti-clipboard"></i> Laporan
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="card mb-2">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <h4>
                                                <i class="icofont-search-document"></i> SIRS Online
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <form action="javascript:void(0);" id="PencarianPcrNakes">
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <input type="date" name="tanggal" id="tanggal" class="form-control">
                                                <label for="tanggal"><small>Tanggal Laporan</small></label>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <button type="submit" class="btn btn-block btn-sm btn-secondary">
                                                    <i class="ti-search"></i> Tampilkan
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-9 col-md-9 mb-3">
                            <div class="card mb-2">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <h4>
                                                <i class="ti ti-view-grid"></i> Data PCR Nakes
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                                <div id="MenampilkanDataPcrnakes"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
    }else{
        include "_Page/UnPage/ErrorPageSub.php";
    }
?>