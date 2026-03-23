<?php
    $StatusAkses=GetStatusAccess($Conn,$SessionIdAkses,'OzuT2lskAZ');
    if($StatusAkses=="Yes"){
?>
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">
                            <a href="" class="h5">
                                <i class="ti-shield"></i> Log Aktivitas User
                            </a>
                        </h5>
                        <p class="m-b-0">Kelola dan pantau log aktivitas user</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="ti-bar-chart"></i> Grafik Aktivitas
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <div id="GrafikAktivitas">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card table-card">
                                <div class="card-header">
                                    <form action="javascript:void(0);" id="BatasPencarian" autocomplete="off">
                                        <div class="row">
                                            <div class="col-md-2 mb-3">
                                                <select name="batas" id="batas" class="form-control">
                                                    <option value="5">5</option>
                                                    <option selected value="10">10</option>
                                                    <option value="25">25</option>
                                                    <option value="50">50</option>
                                                    <option value="100">100</option>
                                                </select>
                                                <small>Jumlah Tampilan</small>
                                            </div>
                                            <div class="col-md-2 mb-3">
                                                <select name="keyword_by" id="keyword_by" class="form-control">
                                                    <option value="">Pilih</option>
                                                    <option value="waktu">Tanggal/Waktu</option>
                                                    <option value="nama">Nama User</option>
                                                    <option value="nama_log">Keterangan Log</option>
                                                    <option value="kategori">Kategori</option>
                                                </select>
                                                <small>Mode Pencarian</small>
                                            </div>
                                            <div class="col-md-5  mb-3">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="keyword" id="keyword" list="ListKeyword" placeholder="Kata Kunci">
                                                    <datalist id="ListKeyword"></datalist>
                                                    <button type="submit" class="btn btn-sm btn-secondary">
                                                        <i class="ti-search"></i> Cari
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-md-3  mb-3">
                                                <button type="button" class="btn btn-sm btn-info btn-block" data-toggle="modal" data-target="#ModalCetakLog">
                                                    <i class="ti-files"></i> Export
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div id="MenampilkanTabelLog">
                                    <!----  Menampilkan Tabel Log---->
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
        include "_Page/UnPage/ErrorPage.php";
    }
?>