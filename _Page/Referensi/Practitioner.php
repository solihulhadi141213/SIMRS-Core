<?php
    $StatusAkses=GetStatusAccess($Conn,$SessionIdAkses,'8rM1HUERv2');
    if($StatusAkses=="Yes"){
?>
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <div class="card mb-2">
                                <form action="javascript:void(0);" id="ProsesPencarianPractitionerSimrs">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h4><i class="ti ti-search"></i> Pencarian Practitioner (SIMRS)</h4>
                                                Cari Data Practitioner Pada Database SIMRS
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <select name="batas_practitioner" id="batas_practitioner" class="form-control">
                                                    <option value="5">5</option>
                                                    <option selected value="10">10</option>
                                                    <option value="25">25</option>
                                                    <option value="50">50</option>
                                                    <option value="100">100</option>
                                                </select>
                                                <small>Batas</small>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <select name="keyword_by_practitioner" id="keyword_by_practitioner" class="form-control">
                                                    <option value="">Pilih</option>
                                                    <option value="kategori">Kategori</option>
                                                    <option value="id_ihs_practitioner">ID IHS Practitioner</option>
                                                    <option value="nik">NIK</option>
                                                    <option value="nama">Nama</option>
                                                    <option value="gender">Gender</option>
                                                    <option value="tanggal_lahir">Tanggal Lahir</option>
                                                    <option value="email">Email</option>
                                                    <option value="status">Status</option>
                                                </select>
                                                <small>Kategori Pencarian</small>
                                            </div>
                                        </div>
                                        <div class="row" id="FormPencarianPractitionerSimrs">
                                            <div class="col-md-12 mb-3">
                                                <input type="text" class="form-control" name="keyword_practitioner" id="keyword_practitioner" placeholder="Kata Kunci">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <button type="submit" class="btn btn-sm btn-secondary btn-block">
                                                    <i class="ti-search"></i> Mulai Pencarian
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <button type="button" class="btn btn-sm btn-primary btn-block"  data-toggle="modal" data-target="#ModalTambahPractitioner">
                                                    <i class="ti-plus"></i> Tambah Practitioner
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="card mb-2">
                                <form action="javascript:void(0);" id="ProsesPencarianPractitioner">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h4><i class="ti ti-search"></i> Practitioner (Satu Sehat)</h4>
                                                Cari Data Practitioner Pada Database Satu Sehat
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <select name="kategori_pencarian_practitioner" id="kategori_pencarian_practitioner" class="form-control">
                                                    <option value="">Pilih</option>
                                                    <option value="NIK">Berdasarkan NIK</option>
                                                    <option value="Identitas">Identitas</option>
                                                    <option value="id_practitioner">ID Practitioner</option>
                                                </select>
                                                <small>Kategori Pencarian</small>
                                            </div>
                                        </div>
                                        <div class="row" id="FormPencarianPractitioner">
                                            <div class="col-md-12 mb-3">
                                                <input type="text" class="form-control" name="keyword" id="keyword" placeholder="Kata Kunci">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <button type="button" class="btn btn-sm btn-secondary btn-block"  data-toggle="modal" data-target="#ModalPencarianPractitionerSatuSehat">
                                                    <i class="ti-search"></i> Mulai Pencarian
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <h4><i class="icofont-doctor"></i> Practitioner (SIMRS)</h4>
                                            Berikut ini adalah daftar practitioner yang sudah terdaftar pada database SIMRS.
                                        </div>
                                    </div>
                                </div>
                                <div id="TabelPractitionerSimrs">
                                    <!-- Data Practitioner Simrs Ditampilkan Disini -->
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