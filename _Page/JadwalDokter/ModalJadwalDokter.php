<!--- Modal Tambah Jadwal Dokter ---->
<div class="modal fade" id="ModalTambahJadwal" tabindex="-1" role="dialog" aria-labelledby="ModalTambahJadwal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <b cass="text-light">
                    <dt><i class="ti-plus"></i> Tambah Jadwal Dokter</dt>
                </b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormTambahJadwal">

            </div>
            <!---- Form Tambah jadwal Dokter Disini ------>
        </div>
    </div>
</div>

<!--- Modal Edit Jadwal Dokter ---->
<div class="modal fade" id="ModalEditJadwalDokter" tabindex="-1" role="dialog" aria-labelledby="ModalEditJadwalDokter" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <b cass="text-light">
                    <dt><i class="ti ti-pencil-alt"></i> Edit Jadwal Dokter</dt>
                </b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormEditJadwal">

            </div>
            <!---- Form Edit jadwal Dokter Disini ------>
        </div>
    </div>
</div>
<!--- Modal Delete Jadwal Dokter ---->
<div class="modal fade" id="ModalDeleteJadwalDokter" tabindex="-1" role="dialog" aria-labelledby="ModalDeleteJadwalDokter" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <b cass="text-light">
                    <dt><i class="ti ti-trash"></i> Edit Jadwal Dokter</dt>
                </b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="FormDeleteJadwalDokter">

            </div>
            <!---- Form Delete jadwal Dokter Disini ------>
        </div>
    </div>
</div>
<!--- Modal Data HFIS ---->
<div class="modal fade" id="ModalDataHfis" tabindex="-1" role="dialog" aria-labelledby="ModalDataHfis" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <b cass="text-light">
                    <dt><i class="ti ti-new-window"></i> Jadwal Dokter HFIS</dt>
                </b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0);" id="ProsesPencarianJadwalHfis">
                    <div class="row">
                        <div class="col-md-6">
                            <select name="kode_poli" id="kode_poli" class="form-control">
                                <option value="">Pilih</option>
                                <?php
                                    //Buka data poli
                                    $query = mysqli_query($Conn, "SELECT*FROM poliklinik");
                                    while ($data = mysqli_fetch_array($query)) {
                                        $id_poliklinik= $data['id_poliklinik'];
                                        $nama= $data['nama'];
                                        $koordinator= $data['koordinator'];
                                        $deskripsi= $data['deskripsi'];
                                        $kode= $data['kode'];
                                        $status= $data['status'];
                                        echo '<option value="'.$kode.'">'.$nama.'</option>';
                                    }
                                ?>
                            </select>
                            <small for="">Kode Poli</small>
                        </div>
                        <div class="col-md-3">
                            <input type="date" name="tanggal" id="TanggalPencarianHfis" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                            <small>Tanggal</small>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-sm btn-primary btn-block">
                                <i class="ti ti-search"></i> Tampilkan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div id="FormDataHfis">

            </div>
        </div>
    </div>
</div>
<!--- Modal Update to HFIS ---->
<div class="modal fade" id="ModalUpdateToHfis" tabindex="-1" role="dialog" aria-labelledby="ModalUpdateToHfis" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <b cass="text-light">
                    <dt><i class="ti ti-reload"></i> Update Jadwal Dokter HFIS</dt>
                </b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0);" id="ProsesTampilkanDataUntukUpdate">
                    <div class="row">
                        <div class="col-md-5">
                            <select name="id_poliklinik" id="id_poliklinik" class="form-control">
                                <option value="">Pilih</option>
                                <?php
                                    //Buka data poli
                                    $query = mysqli_query($Conn, "SELECT*FROM poliklinik");
                                    while ($data = mysqli_fetch_array($query)) {
                                        $id_poliklinik= $data['id_poliklinik'];
                                        $nama= $data['nama'];
                                        $koordinator= $data['koordinator'];
                                        $deskripsi= $data['deskripsi'];
                                        $kode= $data['kode'];
                                        $status= $data['status'];
                                        echo '<option value="'.$id_poliklinik.'">'.$nama.'</option>';
                                    }
                                ?>
                            </select>
                            <small for="">Kode Poli</small>
                        </div>
                        <div class="col-md-5">
                            <select name="id_dokter" id="id_dokter" class="form-control">
                                <option value="">Pilih</option>
                                <?php
                                    //Buka data poli
                                    $query = mysqli_query($Conn, "SELECT*FROM dokter");
                                    while ($data = mysqli_fetch_array($query)) {
                                        $id_dokter= $data['id_dokter'];
                                        $nama= $data['nama'];
                                        echo '<option value="'.$id_dokter.'">'.$nama.'</option>';
                                    }
                                ?>
                            </select>
                            <small for="">Kode Dokter</small>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-sm btn-primary btn-block">
                                <i class="ti ti-arrow-circle-down"></i> Tampilkan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 text-center" id="TampilkanDataUntukUpdate">
                        Belum ada data yang akan di update!
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-primary btn-block" id="ProsesUpdateDataHfis">
                    <i class="ti ti-reload"></i> Update
                </button>
            </div>
        </div>
    </div>
</div>