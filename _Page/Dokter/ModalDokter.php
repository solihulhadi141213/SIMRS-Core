<!--- Modal Tambah Dokter ---->
<div class="modal fade" id="ModalTambahDokter" tabindex="-1" role="dialog" aria-labelledby="ModalTambahDokter" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahDokter" autocomplete="off">
                <div class="modal-header">
                    <h4 cass="modal-title">
                        <i class="icofont-doctor"></i> Tambah Dokter & Profesional Kesehatan
                    </h4> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="kode"><dt>Kode</dt></label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="kode" id="kode" class="form-control" required>
                            <small>Kode sesuai HAFIS atau bisa sesuai standar faskes</small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="id_ihs_practitioner"><dt>ID IHS</dt></label>
                        </div>
                        <div class="col-md-8">
                            <select name="id_ihs_practitioner" id="id_ihs_practitioner" class="form-control">
                                <option value="">Pilih</option>
                                <?php
                                    $query = mysqli_query($Conn, "SELECT*FROM referensi_practitioner ORDER BY nama ASC");
                                    while ($data = mysqli_fetch_array($query)) {
                                        $id_ihs_practitioner= $data['id_ihs_practitioner'];
                                        $kategori= $data['kategori'];
                                        $NamaPractitioner= $data['nama'];
                                        echo '<option value="'.$id_ihs_practitioner.'">'.$NamaPractitioner.'</option>';
                                    }
                                ?>
                            </select>
                            <small>ID practitioner yang sesuai dengan platform satu sehat atau SISDMK (Apabila Ada)</small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="nama"><dt>Nama Lengkap</dt></label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="nama" id="nama" class="form-control" required>
                            <small>Nama lengkap diikuti gelar</small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="kategori"><dt>Spesialis/Profesi</dt></label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="kategori" id="kategori" class="form-control" required>
                            <small>
                                Ex : Spesialis Anak, Spesialis Penyakit Dalam, Radiografer, Analis Laboratorium
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="kategori_identitas"><dt>Kategori Identitas</dt></label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="kategori_identitas" id="kategori_identitas" class="form-control" required>
                            <small>Ex: KTP, KK, Passport Dll.</small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="no_identitas"><dt>Nomor Identitas</dt></label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="no_identitas" id="no_identitas" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="alamat"><dt>Alamat</dt></label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="alamat" id="alamat" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="kontak"><dt>Nomor Kontak (HP)</dt></label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="kontak" id="kontak" class="form-control" placeholder="62">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="email"><dt>Alamat Email</dt></label>
                        </div>
                        <div class="col-md-8">
                            <input type="email" name="email" id="email" class="form-control" placeholder="email@domain.com">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="SIP"><dt>SIP/Nomor Registrasi</dt></label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="SIP" id="SIP" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="foto"><dt>Foto</dt></label>
                        </div>
                        <div class="col-md-8">
                            <input type="file" name="foto" id="foto" class="form-control">
                            <small>Maksimal file 2 mb (jpg, jpeg, png, gif)</small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="status"><dt>Status</dt></label>
                        </div>
                        <div class="col-md-8">
                            <select id="status" name="status" class="form-control" required>
                                <option value="Aktiv">Aktiv</option>
                                <option value="Non-Aktiv">Non-Aktiv</option>
                                <option value="Cuti">Cuti</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <dt>Keterangan</dt>
                        </div>
                        <div class="col-md-8" id="NotifikasiTambahDokter"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row mb-2">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-sm btn-primary btn-round mr-3">
                                <i class="ti ti-save"></i> Simpan
                            </button>
                            <button type="button" class="btn btn-sm btn-secondary btn-round" data-dismiss="modal">
                                <i class="ti-close"></i> Tutup
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Detail Dokter ---->
<div class="modal fade" id="ModalDetailDokter" tabindex="-1" role="dialog" aria-labelledby="ModalDetailDokter" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 cass="modal-title text-dark">
                    <i class="ti ti-info-alt"></i> Detail Dokter & Profesional Kesehatan
                </h4> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="FormDetailDokter">
                    <!---- Form Detail Dokter ----->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary btn-round" data-dismiss="modal">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Edit Dokter ---->
<div class="modal fade" id="ModalEditDokter" tabindex="-1" role="dialog" aria-labelledby="ModalEditDokter" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditDokter" autocomplete="off">
                <div class="modal-header">
                    <h4 class="modal-title">
                        <i class="icofont-edit"></i> Edit Dokter & Profesional Kesehatan
                    </h4> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="FormEditDokter"><!---- Form Edit Dokter -----></div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <dt>Keterangan</dt>
                        </div>
                        <div class="col-md-8" id="NotifikasiEditDokter"><!-- NotifikasiEditDokter --></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-sm btn-primary btn-round mr-3">
                                <i class="ti ti-save"></i> Simpan
                            </button>
                            <button type="button" class="btn btn-sm btn-secondary btn-round" data-dismiss="modal">
                                <i class="ti-close"></i> Tutup
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Hapus Dokter ---->
<div class="modal fade" id="ModalHapusDokter" tabindex="-1" role="dialog" aria-labelledby="ModalHapusDokter" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusDokter">
                <div class="modal-header bg-danger">
                    <b cass="text-light"><i class="icofont-trash"></i> Konfirmasi Hapus Dokter</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="FormHapusDokter">
                        <!-- Form hapus Dokter Disini -->
                    </div>
                    <div class="row mt-2 mb-2"> 
                        <div class="col-md-12 text-center" id="NotifikasiHapusDokter">
                            <!-- Notifikasi Hapus Data Dokter -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-danger">
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <button type="submit" class="btn btn-sm btn-primary mr-2">
                                <i class="ti-check-box"></i> Ya, Hapus
                            </button>
                            <button type="button" class="btn btn-sm btn-dark" data-dismiss="modal">
                                <i class="ti-close"></i> Tidak
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal jadwal Dokter ---->
<div class="modal fade" id="ModalJadwalDokter" tabindex="-1" role="dialog" aria-labelledby="ModalJadwalDokter" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 cass="modal-title text-dark">
                    <i class="ti ti-calendar"></i> Jadwal Praktek
                </h4> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="FormJadwalPraktek">
                    <!---- Form Jadwal Praktek ----->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary btn-round" data-dismiss="modal">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Riwayat Pelayanan Kunjungan Pasien ---->
<div class="modal fade" id="ModalHistoryDokter" tabindex="-1" role="dialog" aria-labelledby="ModalHistoryDokter" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 cass="modal-title text-dark">
                    <i class="icofont-history"></i> Riwayat Pelayanan Kunjungan
                </h4> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0);" id="BatasKunjungan">
                    <input type="hidden" class="form-control" name="id_dokter" id="PutIdDokterKunjungan">
                    <div class="row mb-3">
                        <div class="col-md-12 input-group">
                            <input type="text" class="form-control" name="keyword_kunjungan" id="keyword_kunjungan" placeholder="No.Rm/Reg/Pasien">
                            <button type="submit" class="btn btn-sm btn-outline-secondary">
                                <i class="ti ti-search"></i> Cari
                            </button>
                        </div>
                    </div>
                </form>
                <div id="FormHistoryDokter">
                    <!---- Form Riwayat Kunjungan ----->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary btn-round" data-dismiss="modal">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Data Hfis ---->
<div class="modal fade" id="ModalDataHfis" tabindex="-1" role="dialog" aria-labelledby="ModalDataHfis" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4>
                    <i class="ti ti-new-window"></i> Referensi Dokter HFIS
                </h4> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="FormDataHfis">
                    <!----Form Data Hafis----->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-round" data-dismiss="modal">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Detail IHS Dokter ---->
<div class="modal fade" id="ModalIhsDokter" tabindex="-1" role="dialog" aria-labelledby="ModalIhsDokter" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4>
                    <i class="ti ti-info-alt"></i> Detail ID Practitioner
                </h4> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="FormIhsDokter">
                    <!----Form IHS Dokter ----->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-round" data-dismiss="modal">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
