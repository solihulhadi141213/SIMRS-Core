<?php
//Desiossion Akses
$StatusAkses=GetStatusAccess($Conn,$SessionIdAkses,'8prgG5vbhC');
if($StatusAkses!=="Yes"){
    include "_Page/UnPage/ErrorPage.php";
}else{
    if(empty($_GET['Sub'])){
        $Sub="";
    }else{
        $Sub=$_GET['Sub'];
    }
?>
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">
                        <a href="" class="h5">
                            <i class="icofont-hospital"></i> Kelas & Ruangan v2
                        </a>
                    </h5>
                    <p class="m-b-0">Kelola data ketersediaan tempat tidur, ruangan dan kelas.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-8">
                        <a href="javascript:void(0);" class="label_kategori label label-primary" data-id="kelas" id="label_for_kelas">Kelas</a>
                        <a href="javascript:void(0);" class="label_kategori label label-inverse-info" data-id="ruangan" id="label_for_ruangan">Ruangan</a>
                        <a href="javascript:void(0);" class="label_kategori label label-inverse-info" data-id="bed" id="label_for_bed">Tempat Tidur</a>
                    </div>
                    <div class="col-4 text-right icon-btn">
                        <button type="button" class="btn btn-sm btn-icon btn-outline-dark" data-toggle="modal" data-target="#ModalFilter" title="Filter Data">
                            <i class="ti ti-filter"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-icon btn-outline-dark" data-toggle="modal" data-target="#ModalTambah" title="Filter Data">
                            <i class="ti ti-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th><dt>No</dt></th>
                                <th><dt>Kategori</dt></th>
                                <th><dt>Kode</dt></th>
                                <th><dt>Kelas</dt></th>
                                <th><dt>Ruangan</dt></th>
                                <th><dt>Bed</dt></th>
                                <th><dt>L</dt></th>
                                <th><dt>P</dt></th>
                                <th><dt>L & P</dt></th>
                                <th><dt>Terisi</dt></th>
                                <th><dt>Status</dt></th>
                                <th><dt>Opsi</dt></th>
                            </tr>
                        </thead>
                        <tbody id="TabelKelas">
                            <tr>
                                <td class="text-center" colspan="13">
                                    <small>No Data</small>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-6">
                        <small id="data_count">
                            Count : 0 
                        </small>
                    </div>
                    <div class="col-6 text-right icon-btn">
                        <button type="button" class="btn btn-sm btn-outline-info btn-icon" id="prev_button">
                            <i class="ti ti-arrow-left"></i>
                        </button>
                        <button type="button" disabled class="btn btn-md btn-outline-info btn-round" id="page_info">
                            0 / 0
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-info btn-icon" id="next_button">
                            <i class="ti ti-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    }
?>