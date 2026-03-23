<?php
    include "_Config/Connection.php";
?>
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="page-header-title">
                    <h5 class="m-b-10"><a href="index.php?Page=Poliklinik" class="h5"><i class="icofont-icu"></i> Poliklinik</a></h5>
                    <p class="m-b-0">Kelola Data Poliklinik, Kode Poli dan Gambaran Pelayanan Poliklinik</p>
                </div>
            </div>
            <div class="col-md-4 text-right">
                <a href="index.php?Page=Poliklinik&Sub=TambahPoliklinik" class="btn btn-md btn-inverse mr-2 mt-2">
                    <i class="ti-plus text-white"></i> Tambah Poliklinik
                </a>
                <a href="index.php?Page=Poliklinik&Sub=HFIS" class="btn btn-md btn-primary mr-2 mt-2" data-toggle="modal" data-target="#ModalPoliklinikHfis">
                    <i class="ti ti-new-window text-white"></i> HFIS
                </a>
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
                            <div class="card-header bg-info">
                                <h class="text-light">
                                    <dt>
                                        <i class="ti ti-check-box"></i>
                                        Data Poliklinik Terdaftar Di Internal Database
                                    </dt>
                                </h>
                            </div>
                            <div class="card-body">
                                <div class="table table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="text-center"><dt>No</dt></th>
                                                <th class="text-center"><dt>Kode</dt></th>
                                                <th class="text-center"><dt>Nama Poliklinik</dt></th>
                                                <th class="text-center"><dt>Aksi</dt></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $no=1;
                                                $query = mysqli_query($Conn, "SELECT*FROM poliklinik");
                                                while ($data = mysqli_fetch_array($query)) {
                                                    $id_poliklinik= $data['id_poliklinik'];
                                                    $nama= $data['nama'];
                                                    $koordinator= $data['koordinator'];
                                                    $deskripsi= $data['deskripsi'];
                                                    $kode= $data['kode'];
                                                    $status= $data['status'];
                                            ?>
                                            <tr>
                                                <td><?php echo "$no";?></td>
                                                <td><?php echo "$kode";?></td>
                                                <td><?php echo "$nama";?></td>
                                                <td class="text-center">
                                                    <div class="btn-group dropdown-split-inverse">
                                                        <button type="button" class="btn btn-sm btn-inverse dropdown-toggle dropdown-toggle-split waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="OptionButton">
                                                            <i class="ti ti-settings"></i>
                                                        </button>
                                                        <div class="dropdown-menu" x-placement="top-start" style="position: absolute; transform: translate3d(107px, -2px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                            <a href="index.php?Page=Poliklinik&Sub=DetailPoliklinik&id=<?php echo "$id_poliklinik";?>"  class="dropdown-item waves-effect waves-light">
                                                                <i class="ti ti-folder"></i> Detail
                                                            </a>
                                                            <div class="dropdown-divider"></div>
                                                            <a href="index.php?Page=Poliklinik&Sub=EditPoliklinik&id=<?php echo "$id_poliklinik";?>" class="dropdown-item waves-effect waves-light">
                                                                <i class="ti-pencil"></i> Edit
                                                            </a>
                                                            <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item waves-effect waves-light" href="javascript:void(0);" data-toggle="modal" data-target="#ModalDeletePoliklinik" data-id="<?php echo $id_poliklinik;?>">
                                                                <i class="ti-trash"></i> Hapus
                                                            </a>
                                                            <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item waves-effect waves-light" href="javascript:void(0);" data-toggle="modal" data-target="#ModalHistoriPendidikan" data-id="<?php echo $id_poliklinik;?>">
                                                                <i class="icofont-doctor-alt"></i> Dokter/Ahli
                                                            </a>
                                                            <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item waves-effect waves-light" href="javascript:void(0);" data-toggle="modal" data-target="#ModalHistoriPendidikan" data-id="<?php echo $id_poliklinik;?>">
                                                                <i class="icofont-prescription"></i> Jadwal Poli
                                                            </a>
                                                            <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item waves-effect waves-light" href="javascript:void(0);" data-toggle="modal" data-target="#ModalHistoriPendidikan" data-id="<?php echo $id_poliklinik;?>">
                                                                <i class="ti-medall"></i> Log Kunjungan
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php $no++;} ?>
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