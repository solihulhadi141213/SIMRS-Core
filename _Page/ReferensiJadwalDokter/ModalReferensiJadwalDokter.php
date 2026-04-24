<!--- Modal Tambah Jadwal Dokter --->
<div class="modal fade" id="ModalTambahJadwal" tabindex="-1" aria-labelledby="ModalTambahJadwal" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesTambahJadwal" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-plus"></i> Tambah Jadwal Dokter</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="id_dokter"><small>Dokter</small></label>
                            <select name="id_dokter" id="id_dokter" class="form-control">
                                <option value="">Pilih</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="id_poliklinik"><small>Poliklinik</small></label>
                            <select name="id_poliklinik" id="id_poliklinik" class="form-control">
                                <option value="">Pilih</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="hari"><small>Hari</small></label>
                            <input type="text" readonly class="form-control" name="hari" id="hari">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="jam_mulai"><small>Jam Mulai</small></label>
                            <input type="time" name="jam_mulai" id="jam_mulai" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="jam_selesai"><small>Jam Selesai</small></label>
                            <input type="time" name="jam_selesai" id="jam_selesai" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="kuota_jkn"><small>Kuota Pasien BPJS</small></label>
                            <input type="number" min="0" name="kuota_jkn" id="kuota_jkn" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="kuota_non_jkn"><small>Kuota Pasien Umum</small></label>
                            <input type="number" min="0" name="kuota_non_jkn" id="kuota_non_jkn" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="time_max"><small>Batas Waktu Pendaftaran</small></label>
                            <select name="time_max" id="time_max" class="form-control">
                                <option value="">Pilih</option>
                                <option value="60">1 Jam</option>
                                <option value="360">6 Jam</option>
                                <option value="720">12 Jam</option>
                                <option value="1440">24 jam</option>
                                <option value="2880">2 hari</option>
                                <option value="4320">3 hari</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12" id="NotifikasiTambahJadwal">
                           <!-- Notifikasi Tambah SIRS Online Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary" id="ButtonTambahJadwal">
                        <i class="ti-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-md btn-inverse ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--- Modal Detail Jadwal Dokter --->
<div class="modal fade" id="ModalDetailJadwal" tabindex="-1" aria-labelledby="ModalDetailJadwal" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-info-circle"></i> Detail Jadwal Dokter
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
                <div class="row">
                    <div class="col-12" id="FormDetailJadwal">
                        <!-- Form Detail Akan Muncul Disini -->
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-inverse ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!--- Modal Edit Jadwal Dokter --->
<div class="modal fade" id="ModalEditJadwalDokter" tabindex="-1" aria-labelledby="ModalEditJadwalDokter" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesEditJadwalDokter" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-pencil"></i> Edit Jadwal Dokter</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <div class="row">
                        <div class="col-12" id="FormEditJadwalDokter">
                           <!-- Form Edit Jadwal Dokter Akan Muncul Disini -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" id="NotifikasiEditJadwalDokter">
                           <!-- Notifikasi Edit Jadwal Dokter Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary" id="ButtonEditJadwalDokter">
                        <i class="ti-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-md btn-inverse ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--- Modal Hapus Jadwal Dokter --->
<div class="modal fade" id="ModalHapusJadwalDokter" tabindex="-1" aria-labelledby="ModalHapusJadwalDokter" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesHapusJadwalDokter" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-trash"></i> Hapus Jadwal Dokter</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <div class="row">
                        <div class="col-12" id="FormHapusJadwalDokter">
                            <!-- Form Hapus Akan Muncul Disini -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" id="NotifikasiHapusJadwalDokter">
                            <!-- Notifikasi Hapus Akan Muncul Disini -->
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary" id="ButtonHapusJadwalDokter">
                        <i class="bi bi-check"></i> Ya, Hapus
                    </button>
                    <button type="button" class="btn btn-md btn-inverse ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--- Modal Jadwal Hfiz --->
<div class="modal fade" id="ModalJadwalHfiz" tabindex="-1" aria-labelledby="ModalJadwalHfiz" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-list"></i> Jadwal HFIZ
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0);" id="ProsesJadwalHfiz">
                    
                    <div class="row mb-2">
                        <div class="col-md-6 mb-2">
                            <label for="kode_poli">Poliklinik</label>
                            <select name="id_poliklinik" id="kode_poli" class="form-control">
                                <option value="">Pilih</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="tanggal_praktek">Tanggal Praktek</label>
                            <input type="date" name="tanggal_praktek" id="tanggal_praktek" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <button type="submit" class="btn btn-md btn-primary w-100 rounded-2">
                                <i class="bi bi-search"></i> Cari jadwal
                            </button>
                        </div>
                    </div>
                </form>
                <div class="row mb-3 mt-3">
                    <div class="col-12" id="FormJadwalHfiz">
                        <!-- Data HFIZ akan Muncul Disini -->
                        <div class="alert alert-warning text-center">
                           <small>Berikut ini adalah jadwal yang ditampilkan pada aplikasi HFIZ.<br> Pilih Poliklinik dan tanggal praktek terlebih dulu.</small>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-inverse ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!--- Modal Update Jadwal Hfiz --->
<div class="modal fade" id="ModalUpdateJadwalHfiz" tabindex="-1" aria-labelledby="ModalUpdateJadwalHfiz" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesUpdateJadwalHfiz">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-send"></i> Update Jadwal HFIZ
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-md-6 mb-2">
                            <label for="poliklinik_update">Poliklinik</label>
                            <select name="id_poliklinik" id="poliklinik_update" class="form-control">
                                <option value="">Pilih</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="dokter_update">Dokter</label>
                            <select name="id_dokter" id="dokter_update" class="form-control">
                                <option value="">Pilih</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3 mt-3">
                        <div class="col-12">
                            <button type="button" class="btn btn-md btn-outline-secondary w-100 rounded-2" id="show_jadwal">
                                <i class="bi bi-chevron-down"></i> Tampilkan Jadwal
                            </button>
                        </div>
                    </div>
                    
                    <div class="row mb-3 mt-3">
                        <div class="col-12" id="DataUpdateJadwalHfiz">
                            <!-- Data Jadwal akan Muncul Disini -->
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-12" id="NotifikasiUpdateJadwalHfiz">
                            <!-- Notifikasi Proses Akan Muncul Disini -->
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary ms-2" id="ButtonUpdateJadwalHfiz">
                        <i class="bi bi-save"></i> Update Jadwal
                    </button>
                    <button type="button" class="btn btn-md btn-inverse ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>