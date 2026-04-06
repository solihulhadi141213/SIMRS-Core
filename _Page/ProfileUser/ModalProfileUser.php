<!--- Modal Filter Ijin Akses --->
<div class="modal fade" id="ModalFilterIjinAkses" tabindex="-1" aria-labelledby="ModalFilterIjinAkses" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesFilterIjinAkses" autocomplete="off">
                <input type="hidden" name="page" id="page_ijin_akses" value="1">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-filter"></i> Cari Kategori Fitur</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-12" id="form_filter_ijin_akses">
                            <label for="keyword_ijin_akses">Kata Kunci (<i>Keyword</i>)</label>
                            <input type="text" name="keyword" id="keyword_ijin_akses" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary">
                        <i class="ti-search"></i> Cari
                    </button>
                    <button type="button" class="btn btn-md btn-inverse ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--- Modal List Ijin Akses --->
<div class="modal fade" id="ModalListIjinAkses" tabindex="-1" aria-labelledby="ModalListIjinAkses" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title">
                    <i class="bi bi-list-check"></i> List Ijin Akses
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-12" id="FormListIjinAkses">
                        <!-- Form List Ijin Akses -->
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-md btn-inverse ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!--- Modal Edit Profile --->
<div class="modal fade" id="ModalEditProfile" tabindex="-1" aria-labelledby="ModalEditProfileLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesEditProfile" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-pencil"></i> Edit Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12" id="FormEditProfile">
                            <!---- Form Edit Profile----->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" id="NotifikasiEditProfile">
                            <!---- Notifikasi Edit Profile----->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary">
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

<!--- Modal Ganti Password--->
<div class="modal fade" id="ModalGantiPassword" tabindex="-1" aria-labelledby="ModalGantiPasswordLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesGantiPassword" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-lock"></i> Ubah Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12" id="FormGantiPassword">
                            <!---- Form Edit Profile----->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" id="NotifikasiGantiPassword">
                            <!---- Notifikasi Edit Profile----->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary" id="button_ganti_password">
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

<!--- Modal Ganti Foto--->
<div class="modal fade" id="ModalEditFoto" tabindex="-1" aria-labelledby="ModalEditFotoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesGantiFoto" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-image"></i> Ganti Foto Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12" id="FormGantiFoto">
                            <!---- Form Ganti Foto----->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" id="NotifikasiGantiFoto">
                            <!---- Notifikasi Ganti Foto----->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary">
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

<!--- Modal Kirim Laporan Pengguna--->
<div class="modal fade" id="ModalLaporanPengguna" tabindex="-1" aria-labelledby="ModalLaporanPengguna" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesLaporanPengguna">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="icofont-paper-plane"></i> Laporan Pengguna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="judul_laporan"><small>Judul Laporan</small></label>
                            <input type="text" name="judul_laporan" id="judul_laporan" class="form-control" placeholder="Contoh : Tidak Bisa Login">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label><small>Isi Laporan</small></label>
                            <div id="isi_laporan_editor" style="height: 250px;"></div>
                            <input type="hidden" name="isi_laporan" id="isi_laporan">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <small>Status Laporan</small>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status_laporan" id="status_laporan_1" value="Draft">
                                <label class="form-check-label" for="status_laporan_1">
                                   <small class="text text-muted">Simpan Sebagai Draft</small>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status_laporan" id="status_laporan_2" value="Terkirim">
                                <label class="form-check-label" for="status_laporan_2">
                                    <small class="text text-muted">Langsung Kirim Laporan</small>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" id="NotifikasiLaporanPengguna">
                            <!-- Notifikasi Laporan Pengguna -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary" id="ButtonLaporanPengguna">
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

<!--- Modal Detail Laporan Pengguna--->
<div class="modal fade" id="ModalDetailLaporanKesalahan" tabindex="-1" aria-labelledby="ModalDetailLaporanKesalahan" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-info-circle"></i> Detail Laporan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12" id="FormDetailLaporanKesalahan">
                        <!-- Form Detail Laporan Pengguna -->
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

<!--- Modal Edit Laporan Pengguna--->
<div class="modal fade" id="ModalEditLaporanPengguna" tabindex="-1" aria-labelledby="ModalEditLaporanPengguna" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditLaporanPengguna">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-pencil"></i> Edit Laporan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-12" id="FormEditLaporanPengguna">
                           <!-- Form Akan Muncul Disini -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" id="NotifikasiEditLaporanPengguna">
                            <!-- Notifikasi Laporan Pengguna -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary" id="ButtonEditLaporanPengguna">
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

<!--- Modal Hapus Laporan Pengguna--->
<div class="modal fade" id="ModalHapusLaporanPengguna" tabindex="-1" aria-labelledby="ModalHapusLaporanPengguna" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesHapusLaporanPengguna" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-trash"></i> Hapus Laporan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12" id="FormHapusLaporanPengguna">
                            <!---- Form Muncul Disini----->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" id="NotifikasiHapusLaporanPengguna">
                            <!---- Notifikasi Muncul Disini----->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary" id="button_hapus_laporan_pengguna">
                        <i class="ti-check"></i> Ya, Hapus
                    </button>
                    <button type="button" class="btn btn-md btn-inverse ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
