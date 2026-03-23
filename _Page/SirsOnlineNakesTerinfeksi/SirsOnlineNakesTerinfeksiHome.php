<?php
    //Desiossion Akses
    $StatusAkses=GetStatusAccess($Conn,$SessionIdAkses,'4kimCMM1sk');
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
                        <div class="col-xl-12 col-md-12 mb-3">
                            <div class="card mb-2">
                                <div class="card-block accordion-block">
                                    <div id="accordion" role="tablist" aria-multiselectable="true">
                                        <div class="accordion-panel active">
                                            <div class="accordion-heading" role="tab" id="headingOne">
                                                <h3 class="card-title accordion-title">
                                                    <a class="accordion-msg waves-effect waves-dark scale_active collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                                        <dt>A. Master Nakes Terinfeksi</dt>
                                                    </a>
                                                </h3>
                                            </div>
                                            <div id="collapseOne" class="panel-collapse in collapse show" role="tabpanel" aria-labelledby="headingOne" style="">
                                                <div class="accordion-content accordion-desc">
                                                    <div class="row mt-3 mb-3">
                                                        <div class="col-md-2 mb-2">
                                                            <button type="button" class="btn btn-block btn-sm btn-secondary" data-toggle="modal" data-target="#ModalFilterNakesTerinfeksi">
                                                                <i class="ti ti-filter"></i> Filter/Cari
                                                            </button>
                                                        </div>
                                                        <div class="col-md-2 mb-2">
                                                            <button type="button" class="btn btn-block btn-sm btn-primary" data-toggle="modal" data-target="#ModalPilihPcrNakes">
                                                                <i class="ti ti-plus"></i> Tambah
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div id="MenampilkanTabelNakesTerinfeksi">

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-heading" role="tab" id="headingTwo">
                                                <h3 class="card-title accordion-title">
                                                    <a class="accordion-msg waves-effect waves-dark scale_active collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                        <dt>B. Rekap Laporan Nakes Terinfeksi</dt>
                                                    </a>
                                                </h3>
                                            </div>
                                            <div id="collapseTwo" class="panel-collapse in collapse" role="tabpanel" aria-labelledby="headingTwo" style="">
                                                <div class="accordion-content accordion-desc">
                                                    <div class="row mb-3">
                                                        <div class="col-md-12">
                                                            1. Pilih Tanggal Periode Rekapitulasi
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-md-4">
                                                            <form action="javascript:void(0);" id="ProsesFilterRekap">
                                                                <div class="input-group">
                                                                    <input type="date" name="TanggalRekapitulasi" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                                                                    <button type="submit" class="btn btn-sm btn-primary">
                                                                        <i class="ti ti-search"></i> Tampilkan
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-md-12">
                                                            2. Periksa Kembali Data Rekapitulasi Nakes Terinfeksi
                                                        </div>
                                                    </div>
                                                    <form action="javascript:void(0);" id="ProsesRekapNakesTerinfeksi">
                                                        <div class="row mb-3">
                                                            <div class="col-md-12 text-center">
                                                                <div class="table table-responsive">
                                                                    <table class="table table-bordered table-hover">
                                                                        <thead>
                                                                            <tr>
                                                                                <th class="text-center" valign="middle" rowspan="2"><dt>No</dt></th>
                                                                                <th class="text-center" valign="middle" rowspan="2"><dt>Kategori</dt></th>
                                                                                <th class="text-center" valign="middle" rowspan="2"><dt>Jumlah</dt></th>
                                                                                <th class="text-center" colspan="4"><dt>Status</dt></th>
                                                                            </tr>
                                                                            <tr>
                                                                                <th class="text-center"><dt>Sembuh</dt></th>
                                                                                <th class="text-center"><dt>Isoman</dt></th>
                                                                                <th class="text-center"><dt>Dirawat</dt></th>
                                                                                <th class="text-center"><dt>Meninggal</dt></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody id="MenampilkanRekapitulasiNakesTerinfeksi">
                                                                            <!-- Konten Di sini -->
                                                                            <tr>
                                                                                <td class="text-center" colspan="7">Silahkan pilih tanggal terlebih dulu kemudian tampilkan</td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-md-12">
                                                                3. Simpan Laporan Ke SIRS Online
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <button type="submit" class="btn btn-sm btn-primary">
                                                                    <i class="ti ti-save"></i> Simpan Laporan
                                                                </button>
                                                            </div>
                                                            <div class="col-md-6" id="NotifikasiRekapNakesTerinfeksi">
                                                                
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="accordion-heading" role="tab" id="headingFour">
                                                <h3 class="card-title accordion-title">
                                                    <a class="accordion-msg waves-effect waves-dark scale_active collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                                        <dt>C. Log Laporan Nakes Terinfeksi</dt>
                                                    </a>
                                                </h3>
                                            </div>
                                            <div id="collapseFour" class="panel-collapse in collapse" role="tabpanel" aria-labelledby="headingFour" style="">
                                                <div class="accordion-content accordion-desc">
                                                    <div class="row mb-3">
                                                        <div class="col-md-4">
                                                            <form action="javascript:void(0);" id="ProsesTampilkanLogNakesTerinfeksiSirsOnline">
                                                                <div class="input-group">
                                                                    <input type="date" name="PeriodeLogNakesTerinfeksi" class="form-control" value="">
                                                                    <button type="submit" class="btn btn-sm btn-primary">
                                                                        <i class="ti ti-filter"></i> Filter
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <div id="MenampilkanTabelLogNakesTerinfeksi">
                                                        <!-- Konten Di sini -->
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-heading" role="tab" id="headingTree">
                                                <h3 class="card-title accordion-title">
                                                    <a class="accordion-msg waves-effect waves-dark scale_active collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTree" aria-expanded="false" aria-controls="collapseTree">
                                                        <dt>D. Nakes Terinfeksi (SIRS Online)</dt>
                                                    </a>
                                                </h3>
                                            </div>
                                            <div id="collapseTree" class="panel-collapse in collapse" role="tabpanel" aria-labelledby="headingTree" style="">
                                                <div class="accordion-content accordion-desc">
                                                    <div class="row mb-3">
                                                        <div class="col-md-4">
                                                            <form action="javascript:void(0);" id="ProsesTampilkanNakesTerinfeksiSirsOnline">
                                                                <div class="input-group">
                                                                    <input type="date" name="PeriodeTanggal" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                                                                    <button type="submit" class="btn btn-sm btn-primary">
                                                                        <i class="ti ti-search"></i> Tampilkan
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-md-12 text-center">
                                                            <div class="table table-responsive">
                                                                <table class="table table-bordered table-hover">
                                                                    <thead>
                                                                        <tr>
                                                                            <th class="text-center" valign="middle" rowspan="2"><dt>No</dt></th>
                                                                            <th class="text-center" valign="middle" rowspan="2"><dt>Kategori</dt></th>
                                                                            <th class="text-center" valign="middle" rowspan="2"><dt>Jumlah</dt></th>
                                                                            <th class="text-center" colspan="4"><dt>Status</dt></th>
                                                                        </tr>
                                                                        <tr>
                                                                            <th class="text-center"><dt>Sembuh</dt></th>
                                                                            <th class="text-center"><dt>Isoman</dt></th>
                                                                            <th class="text-center"><dt>Dirawat</dt></th>
                                                                            <th class="text-center"><dt>Meninggal</dt></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="MenampilkanNakesTerinfeksiSirsOnline">
                                                                        <!-- Konten Di sini -->
                                                                        <tr>
                                                                            <td class="text-center" colspan="7">Silahkan pilih tanggal terlebih dulu kemudian tampilkan</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
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