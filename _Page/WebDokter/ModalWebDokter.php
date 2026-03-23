<!--- Modal Tambah Dokter---->
<div class="modal fade" id="ModalTambahDokter" tabindex="-1" role="dialog" aria-labelledby="ModalTambahDokter" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <b cass="text-light"><i class="ti ti-plus"></i> Tambah Dokter</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 mt-3">
                        <dt>
                            <a href="javascript:void(0);" class="text-success" data-toggle="modal" data-target="#ModalTambahDokterSimrs">
                                1. Tambah Dari SIMRS
                            </a>
                        </dt>
                        Tambahkan data dokter dari referensi yang sudah ada di SIMRS
                    </div>
                    <div class="col-md-12 mt-3">
                        <dt>
                            <a href="javascript:void(0);" class="text-success" data-toggle="modal" data-target="#ModalTambahDokterDeh">
                                2. Tambah Manual
                            </a>
                        </dt>
                        Tambahkan data dokter secara manual melalui form
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
<!--- Modal Tambah Dokter SIMRS---->
<div class="modal fade" id="ModalTambahDokterSimrs" tabindex="-1" role="dialog" aria-labelledby="ModalTambahDokterSimrs" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <b cass="text-light"><i class="ti ti-plus"></i> Pilih Dokter</b> 
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
                                        <th class="text-center"><dt>Opt</dt></th>
                                        <th class="text-center"><dt>Nama Dokter</dt></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $no=1;
                                        $query = mysqli_query($Conn, "SELECT*FROM dokter");
                                        while ($data = mysqli_fetch_array($query)) {
                                            $id_dokter= $data['id_dokter'];
                                            $nama= $data['nama'];
                                            $kode= $data['kode'];
                                            $kategori= $data['kategori'];
                                            $status= $data['status'];
                                            //Cek apakah ada 
                                            $url=urlServiceInline('List Dokter');
                                            $keyword_by="kode";
                                            $short="ASC";
                                            $order="id_dokter";
                                            $JumlahDokterWeb=jumlahDataCount($api_key,$url,$keyword_by,$kode,$short,$order);
                                            if(empty($JumlahDokterWeb)){
                                                $StatusAda="Belum Ada Di Web";
                                            }else{
                                                $StatusAda="Sudah Ada";
                                            }
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
                                                echo '  <a href="javascript:void(0);" class="text-success" data-toggle="modal" data-target="#ModalTambahDokterDeh" data-id="'.$id_dokter.'">';
                                                echo '      <i class="ti ti-download"></i> '.$nama.'';
                                                echo '  </a>';
                                                echo '</dt>';
                                                echo "Kode: $kode | Status: $status<br>";
                                                echo "Ketersediaan Data: $StatusAda";
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
<!--- Modal Detail Dokter---->
<div class="modal fade" id="ModalDetailDokter" tabindex="-1" role="dialog" aria-labelledby="ModalDetailDokter" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <b cass="text-light"><i class="ti ti-info-alt"></i> Detail Dokter</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="FormDetailDokter">
            </div>
            <div class="modal-footer bg-info">
                <button type="button" class="btn btn-md btn btn-secondary" data-dismiss="modal">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Delete Dokter ---->
<div class="modal fade" id="ModalHapusDokter" tabindex="-1" role="dialog" aria-labelledby="ModalHapusDokter" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <b cass="text-light">Konfirmasi Hapus Dokter</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormHapusDokter">
                <!---- Konfirmasi Hapus Dokter ----->
            </div>
        </div>
    </div>
</div>
<!--- Modal Tambah Dokter---->
<div class="modal fade" id="ModalTambahDokterDeh" tabindex="-1" role="dialog" aria-labelledby="ModalTambahDokterDeh" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahDokterDeh">
                <div class="modal-header bg-primary">
                    <b cass="text-light"><i class="ti ti-plus"></i> Tambah Dokter</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="FormTambahDokterDeh">

                </div>
                <div class="modal-footer bg-primary">
                    <button type="submit" class="btn btn-md btn btn-success">
                        <i class="ti ti-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-md btn btn-secondary" data-dismiss="modal">
                        <i class="ti ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Tambah Dokter---->
<div class="modal fade" id="ModalEditDokter" tabindex="-1" role="dialog" aria-labelledby="ModalEditDokter" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditDokter">
                <div class="modal-header bg-info">
                    <b cass="text-light"><i class="ti ti-pencil"></i> Edit Dokter</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="FormEditDokter">

                </div>
                <div class="modal-footer bg-info">
                    <button type="submit" class="btn btn-md btn btn-success">
                        <i class="ti ti-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-md btn btn-secondary" data-dismiss="modal">
                        <i class="ti ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal List Jadwal Dokter SIMRS---->
<div class="modal fade" id="ModalListJadwalSimrs" tabindex="-1" role="dialog" aria-labelledby="ModalListJadwalSimrs" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesSetJadwalSimrs">
                <div class="modal-header bg-info">
                    <b cass="text-light"><i class="ti ti-timer"></i> List Jadwal Dokter</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="ListJadwalDokterSimrs">
                </div>
                <div class="modal-footer bg-info">
                    <button type="button" class="btn btn-md btn btn-secondary" data-dismiss="modal">
                        <i class="ti ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Tambah Jadwal Dokter Manual---->
<div class="modal fade" id="ModalTambahJadwalManual" tabindex="-1" role="dialog" aria-labelledby="ModalTambahJadwalManual" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTmabahJadwalmanual">
                <div class="modal-header bg-success">
                    <b cass="text-light"><i class="ti ti-plus"></i> Tambah Jadwal Manual</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="FormTambahJadwalManual">
                </div>
                <div class="modal-footer bg-success">
                    <button type="submit" class="btn btn-md btn btn-primary">
                        <i class="ti ti-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-md btn btn-secondary" data-dismiss="modal">
                        <i class="ti ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Hapus Jadwal ---->
<div class="modal fade" id="ModalHapusJadwal" tabindex="-1" role="dialog" aria-labelledby="ModalHapusJadwal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <b cass="text-light">Konfirmasi Hapus Jadwal</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormHapusJadwal">
                <!---- Konfirmasi Hapus Jadwal ----->
            </div>
        </div>
    </div>
</div>
<!--- Modal Edit Jadwal Dokter---->
<div class="modal fade" id="ModalEditJadwal" tabindex="-1" role="dialog" aria-labelledby="ModalEditJadwal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditJadwalDokter">
                <div class="modal-header bg-success">
                    <b cass="text-light"><i class="ti ti-plus"></i> Edit Jadwal Dokter</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="FormEditJadwalDokter">
                </div>
                <div class="modal-footer bg-success">
                    <button type="submit" class="btn btn-md btn btn-primary">
                        <i class="ti ti-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-md btn btn-secondary" data-dismiss="modal">
                        <i class="ti ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>