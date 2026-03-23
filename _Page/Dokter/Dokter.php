<?php
    date_default_timezone_set('Asia/Jakarta');
    //memangil setting akses
    // include "_Config/SettingAkses.php";
    //Desiossion Akses
    $StatusAkses=GetStatusAccess($Conn,$SessionIdAkses,'aYURuzwwnQ');
    if($StatusAkses=="Yes"){
?>
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">
                            <a href="" class="h5">
                                <i class="icofont-doctor-alt"></i> Dokter & Spesialis
                            </a>
                        </h5>
                        <p class="m-b-0">Kelola Data Dokter/Spesialistik, Profesi Ahli, Kode DPJP dan Spesialistik</p>
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
                        <div class="col-md-3">
                            <form action="javascript:void(0);" id="BatasPencarian">
                                <input type="hidden" id="page" name="page">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">
                                            <i class="ti ti-search"></i> Filter & Cari
                                        </h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <select name="batas" id="batas" class="form-control">
                                                    <option value="5">5</option>
                                                    <option selected value="10">10</option>
                                                    <option value="25">25</option>
                                                    <option value="50">50</option>
                                                    <option value="100">100</option>
                                                </select>
                                                <small>Batas/Halaman</small>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <select name="OrderBy" id="OrderBy" class="form-control">
                                                    <option value="">Pilih</option>
                                                    <option selected value="id_dokter">ID</option>
                                                    <option value="kode">Kode</option>
                                                    <option value="nama">Nama</option>
                                                    <option value="kategori">Kategori</option>
                                                    <option value="alamat">Alamat</option>
                                                    <option value="kontak">Kontak</option>
                                                    <option value="email">Email</option>
                                                    <option value="SIP">SIP</option>
                                                    <option value="status">Status</option>
                                                </select>
                                                <small>Dasar Urutan</small>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <select name="ShortBy" id="ShortBy" class="form-control">
                                                    <option value="ASC">A to Z</option>
                                                    <option selected value="DESC">Z to A</option>
                                                </select>
                                                <small>Mode Urutan</small>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <select name="keyword_by" id="keyword_by" class="form-control">
                                                    <option value="">Pilih</option>
                                                    <option value="kode">Kode</option>
                                                    <option value="nama">Nama</option>
                                                    <option value="kategori">Kategori</option>
                                                    <option value="alamat">Alamat</option>
                                                    <option value="kontak">Kontak</option>
                                                    <option value="email">Email</option>
                                                    <option value="SIP">SIP</option>
                                                    <option value="status">Status</option>
                                                </select>
                                                <small>Mode Pencarian</small>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-12" id="FormKeyword">
                                                <input type="text" class="form-control" name="keyword" id="keyword" placeholder="Kata Kunci">
                                                <small>Kata Kunci</small>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-sm btn-outline-secondary btn-block btn-round"> 
                                                    <i class="ti-search"></i> Cari
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <button type="button" class="btn btn-sm btn-primary btn-block btn-round" data-toggle="modal" data-target="#ModalTambahDokter"> 
                                                    <i class="ti-plus text-white"></i> Tambah Dokter
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <button type="button" class="btn btn-sm btn-info btn-block btn-round" data-toggle="modal" data-target="#ModalDataHfis"> 
                                                    <i class="ti ti-new-window text-white"></i> Referensi HFIS
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-9">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">
                                        <i class="icofont-doctor-alt"></i> Data Dokter & Spesialis
                                    </h4>
                                </div>
                                <div id="MenampilkanTabelDokter">
                                    <!--  menampilkan data Dokter disini -->
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