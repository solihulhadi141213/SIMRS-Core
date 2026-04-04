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
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="ti-search"></i> Cari
                    </button>
                    <button type="button" class="btn btn-sm btn-inverse ms-2" data-bs-dismiss="modal" aria-label="Close">
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
                <button type="button" class="btn btn-sm btn-inverse ms-2" data-bs-dismiss="modal" aria-label="Close">
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
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="ti-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-sm btn-inverse ms-2" data-bs-dismiss="modal" aria-label="Close">
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
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="ti-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-sm btn-inverse ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--- Modal Kirim Laporan Pengguna--->
<div class="modal fade" id="ModalKirimLaporanPengguna" tabindex="-1" aria-labelledby="ModalKirimLaporanPenggunaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesKirimLaporanPengguna">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="icofont-paper-plane"></i> Kirim Laporan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="judul"><dt>Judul Laporan</dt></label>
                            <input type="text" name="judul" id="judul" class="form-control">
                            <small>Sertakan Judul Maksimal 100 Karakter</small>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="laporan"><dt>Isi Laporan</dt></label>
                            <textarea name="laporan" id="laporan" cols="30" rows="3" class="form-control"></textarea>
                        </div>
                        <div class="col-md-12 mb-3" id="NotifikasiKirimLaporanPengguna">
                            <span class="text-primary">Pastikan Laporan Dijelaskan Secara Rinci Dan Jelas</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="ti-save"></i> Kirim
                    </button>
                    <button type="button" class="btn btn-sm btn-inverse ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--- Modal Detail Laporan Pengguna--->
<div class="modal fade" id="ModalDetailLaporanPengguna" tabindex="-1" aria-labelledby="ModalDetailLaporanPenggunaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title"><i class="ti ti-info-alt"></i> Detail Laporan Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="FormDetailLaporanPengguna">
                <!---- Form Ganti Password---->
            </div>
            <div class="modal-footer bg-info">
                    <button type="button" class="btn btn-sm btn-inverse ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
        </div>
    </div>
</div>
