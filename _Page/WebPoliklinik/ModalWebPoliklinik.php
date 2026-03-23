<!--- Modal Tambah Poliklinik---->
<div class="modal fade" id="ModalTambahPoliklinik" tabindex="-1" role="dialog" aria-labelledby="ModalTambahPoliklinik" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <b cass="text-light"><i class="ti ti-plus"></i> Tambah Poliklinik</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 mt-3">
                        <dt>
                            <a href="javascript:void(0);" class="text-success" data-toggle="modal" data-target="#ModalTambahPoliklinikSimrs">
                                1. Tambah Dari SIMRS
                            </a>
                        </dt>
                        Tambahkan data poliklinik dari list yang sudah ada di SIMRS
                    </div>
                    <div class="col-md-12 mt-3">
                        <dt>
                            <a href="index.php?Page=WebPoliklinik&Sub=TambahPoliklinik" class="text-success">
                                2. Tambah Manual
                            </a>
                        </dt>
                        Tambahkan data poliklinik secara manual melalui form
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-primary">
                <button type="button" class="btn btn-md btn btn-secondary" data-dismiss="modal">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Tambah Poliklinik MANUAL---->
<div class="modal fade" id="ModalTambahPoliklinikSimrs" tabindex="-1" role="dialog" aria-labelledby="ModalTambahPoliklinikSimrs" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <b cass="text-light"><i class="ti ti-plus"></i> Pilih Poliklinik</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 mt-3">
                        <div class="table table-responsive pre-scrollable">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center"><dt>ADD</dt></th>
                                        <th class="text-center"><dt>NAMA POLIKLINIK</dt></th>
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
                                        <td class="text-center">
                                            <?php 
                                                echo "$no";
                                            ?>
                                        </td>
                                        <td>
                                            <?php 
                                                echo '<dt>';
                                                echo '  <a href="javascript:void(0);" class="text-success" data-toggle="modal" data-target="#ModalAddPoliklinik" data-id="'.$id_poliklinik.'">';
                                                echo '      <i class="ti ti-download"></i> '.$nama.'';
                                                echo '  </a>';
                                                echo '</dt>';
                                                echo "Kode: $kode | Status: $status";
                                            ?>
                                        </td>
                                    </tr>
                                    <?php $no++;} ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-primary">
                <button type="button" class="btn btn-md btn btn-secondary" data-dismiss="modal">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Add Poliklinik---->
<div class="modal fade" id="ModalAddPoliklinik" tabindex="-1" role="dialog" aria-labelledby="ModalAddPoliklinik" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <b cass="text-light"><i class="ti ti-plus"></i> Add Poliklinik</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 mt-3" id="NotifikasiTambahPoliklinikDariSimrs">
                        
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-info">
                <button type="button" class="btn btn-md btn btn-secondary" data-dismiss="modal">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Detail Poliklinik---->
<div class="modal fade" id="ModalDetailPoliklinik" tabindex="-1" role="dialog" aria-labelledby="ModalDetailPoliklinik" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <b cass="text-light"><i class="ti ti-info-alt"></i> Detail Poliklinik</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 mt-3" id="FormDetailPoliklinik">
                        
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-info">
                <button type="button" class="btn btn-md btn btn-secondary" data-dismiss="modal">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Delete Poliklinik ---->
<div class="modal fade" id="ModalHapusPoliklinik" tabindex="-1" role="dialog" aria-labelledby="ModalHapusPoliklinik" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <b cass="text-light">Konfirmasi Hapus Poliklinik</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormHapusPoliklinik">
                <!---- Konfirmasi Hapus Poliklinik ----->
            </div>
        </div>
    </div>
</div>