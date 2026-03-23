<!--- Modal Export Referensi ---->
<div class="modal fade" id="ModalExportReferensi" tabindex="-1" role="dialog" aria-labelledby="ModalExportReferensi" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="_Page/Akses/ProsesEksportReferensi.php" method="POST" target="_blank">
                <div class="modal-header bg-inverse">
                    <b cass="text-light"><i class="ti ti-export"></i> Eksport Referensi</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-3 text-center">
                            <h1 class="ti ti-download"></h1>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="format"><dt>Format Data</dt></label>
                            <select name="format_eksport_referensi" id="format_eksport_referensi" class="form-control">
                                <option value="">Pilih</option>
                                <option value="HTML">HTML</option>
                                <option value="PDF">PDF</option>
                                <option value="Excel">Excel</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <input type="checkbox" id="TampilkanKop" name="TampilkanKop" value="Ya">
                            <label for="TampilkanKop">Tampilkan Kop Surat?</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-inverse">
                    <button type="submit" class="btn btn-md btn-primary mt-2 ml-2">
                        <i class="ti-download"></i> Export
                    </button>
                    <button type="button" class="btn btn-md btn-light mt-2 ml-2" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Tambah Referensi ---->
<div class="modal fade" id="ModalTambahReferensi" tabindex="-1" role="dialog" aria-labelledby="ModalTambahReferensi" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahReferensi" autocomplete="off">
                <div class="modal-header bg-primary">
                    <b cass="text-light"><i class="ti ti-plus"></i> Form Tambah Referensi</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="nama_fitur">Nama Fitur</label>
                            <input type="text" class="form-control" id="nama_fitur" name="nama_fitur">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="kategori">Kategori Fitur</label>
                            <input type="text" class="form-control" id="kategori" name="kategori" list="ListKategori">
                            <datalist id="ListKategori">
                                <?php
                                    $QryKategori = mysqli_query($Conn, "SELECT DISTINCT kategori FROM akses_ref ORDER BY kategori ASC");
                                    while ($Datakategori = mysqli_fetch_array($QryKategori)) {
                                        $KategoriList= $Datakategori['kategori'];
                                        echo '<option value="'.$KategoriList.'">';
                                    }
                                ?>
                            </datalist>
                            <small>Klik 2 kali untuk melihat datalist kategori yang sudah ada</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="kode">Kode Fitur</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="kode" name="kode">
                                <button type="button" class="btn btn-sm btn-secondary" id="GenerateKodeFitur" title="Generate Kode">
                                    <i class="ti ti-reload"></i>
                                </button>
                            </div>
                            
                            <small>Maksimal 15 karakter huruf & angka</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="keterangan">Keterangan Singkat</label>
                            <textarea name="keterangan" id="keterangan" cols="30" rows="3" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3" id="NotifikasiTambahReferensi">
                            <span class="text-primary">Pastikan Referensi Fitur Yang Anda Input Sudah Sesuai</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-primary">
                    <button type="submit" class="btn btn-md btn-inverse mt-2 ml-2">
                        <i class="ti-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-md btn-light mt-2 ml-2" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Detail Referensi Fitur Akses ---->
<div class="modal fade" id="ModalDetailReferensiFitur" tabindex="-1" role="dialog" aria-labelledby="ModalDetailReferensiFitur" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <b cass="text-light"><i class="ti ti-info-alt"></i> Detail Referensi Fitur</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormDetailReferensiFitur">
                <!---- Form Detail Referensi Fitur ----->
            </div>
        </div>
    </div>
</div>
<!--- Modal Edit Referensi Fitur Akses ---->
<div class="modal fade" id="ModalEditReferensiFitur" tabindex="-1" role="dialog" aria-labelledby="ModalEditReferensiFitur" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesEditReferensiAkses" autocomplete="off">
                <div class="modal-header bg-success">
                    <b cass="text-light"><i class="ti ti-pencil-alt"></i> Form Edit Referensi</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body border-0 pb-0">
                    <div id="FormEditReferensiAkses">
                        <!---- Form Edit Referensi Akses ----->
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3" id="NotifikasiEditReferensiAkses">
                            <span class="text-primary">Pastikan Referensi Fitur Yang Anda Input Sudah Sesuai</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-success">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <div>
                                <button type="submit" class="btn btn-md btn-primary mt-2 ml-2">
                                    <i class="ti-save"></i> Simpan
                                </button>
                                <button type="button" class="btn btn-md btn-light mt-2 ml-2" data-dismiss="modal">
                                    <i class="ti-close"></i> Tutup
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Hapus Referensi Akses---->
<div class="modal fade" id="ModalHapusReferensiAkses" tabindex="-1" role="dialog" aria-labelledby="ModalHapusReferensiAkses" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesHapusReferensiAkses" autocomplete="off">
                <div class="modal-header bg-danger">
                    <b cass="text-light">Konfirmasi Hapus Referensi</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="FormHapusReferensi">
                        <!---- Konfirmasi Hapus Referensi Akses ----->
                    </div>
                    <div class="row">
                        <div class="col col-md-12 text-center mb-3" id="NotifikasiHapusReferensi">
                            
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-danger">
                    <div class="row">
                        <div class="col col-md-12 text-center">
                            <button type="submit" id="KonfirmasiHapusReferensi" class="btn btn-sm btn-success">
                                <i class="ti ti-check"></i> Ya Hapus
                            </button>
                            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                                <i class="ti ti-close"></i> Tidak
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Detail Entitas Akses ---->
<div class="modal fade" id="ModalDetailEntitas" tabindex="-1" role="dialog" aria-labelledby="ModalDetailEntitas" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <b cass="text-light"><i class="ti ti-info-alt"></i> Detail Entitas Fitur</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormDetailEntitas">
                <!---- Form Detail Referensi Fitur ----->
            </div>
        </div>
    </div>
</div>
<!--- Modal Hapus Entitas Akses---->
<div class="modal fade" id="ModalHapusEntitas" tabindex="-1" role="dialog" aria-labelledby="ModalHapusEntitas" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <b cass="text-light">Konfirmasi Hapus Entitas</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormHapusEntitas">
                <!---- Konfirmasi Hapus Entitas Akses ----->
            </div>
        </div>
    </div>
</div>
<!--- Modal Pengajuan Akses ---->
<div class="modal fade" id="ModalPengajuanAkses" tabindex="-1" role="dialog" aria-labelledby="ModalPengajuanAkses" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <b cass="text-light"><i class="ti ti-pencil-alt2"></i> Pengajuan Akses</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        Untuk versi ini, penambahan data akses harus disertai dengan pangajuan akses yang dikirim oleh user terlebih dulu.
                        Berikut ini adalah tahapan penambahan data akses yang perlu diketahui.
                        <ol>
                            <li>
                                Pengajuan akses oleh user melalui halaman pengajuan akses dengan mengisi formulir pengajuan.
                            </li>
                            <li>
                                Admin/Petugas yang berwenang akan memperoleh notifikasi atas pengajuan tersebut.
                            </li>
                            <li>
                                Admin/Petugas yang berwenang melakukan verifikasi pengajuan berdasarkan kepentingan akses.
                            </li>
                            <li>
                                Admin/Petugas melakukan aproval dan mengisi parameter password.
                            </li>
                            <li>
                                Sistem mengirimkan status aproval akses melalui email (Optional).
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-primary">
                <a href="PengajuanAkses.php" target="_blank" class="btn btn-md btn-inverse mt-2 ml-2">
                    Menuju Halaman Pengajuan <i class="ti ti-angle-right"></i>
                </a>
                <button type="button" class="btn btn-md btn-light mt-2 ml-2" data-dismiss="modal">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Detail Pengajuan Akses ---->
<div class="modal fade" id="ModalDetailPengajuanAkses" tabindex="-1" role="dialog" aria-labelledby="ModalDetailPengajuanAkses" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <b cass="text-light"><i class="ti ti-info-alt"></i> Detail Pengajuan Akses</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormDetailPengajuanAkses">
                <!---- Form Detail Pengajuan Akses ----->
            </div>
        </div>
    </div>
</div>
<!--- Modal Detail Pengajuan Akses2 ---->
<div class="modal fade" id="ModalDetailPengajuanAkses2" tabindex="-1" role="dialog" aria-labelledby="ModalDetailPengajuanAkses2" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <b cass="text-light"><i class="ti ti-info-alt"></i> Detail Pengajuan Akses</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormDetailPengajuanAkses2">
                <!---- Form Detail Pengajuan Akses ----->
            </div>
        </div>
    </div>
</div>
<!--- Modal Tampilkan Foto Pengajuan ---->
<div class="modal fade" id="ModalTampilkanFotoPengajuan" tabindex="-1" role="dialog" aria-labelledby="ModalTampilkanFotoPengajuan" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-light"></b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="moda-body" id="FormTampilkanFotoPengajuan">
                <!---- Form Detail Pengajuan Akses ----->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-secondary" data-dismiss="modal">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Tampilkan Foto User ---->
<div class="modal fade" id="ModalTampilkanFotoUser" tabindex="-1" role="dialog" aria-labelledby="ModalTampilkanFotoUser" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-light"></b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="moda-body" id="FormTampilkanFotoUser">
                <!---- Form Detail Pengajuan Akses ----->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-secondary" data-dismiss="modal">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Hapus Pengajuan Akses ---->
<div class="modal fade" id="ModalHapusPengajuanAkses" tabindex="-1" role="dialog" aria-labelledby="ModalHapusPengajuanAkses" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <b cass="text-light">Konfirmasi Hapus Pengajuan</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormHapusPengajuanAkses">
                <!---- Konfirmasi Hapus Pengajuan Akses----->
            </div>
        </div>
    </div>
</div>
<!--- Modal Hapus Pengajuan Akses2 ---->
<div class="modal fade" id="ModalHapusPengajuanAkses2" tabindex="-1" role="dialog" aria-labelledby="ModalHapusPengajuanAkses2" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <b cass="text-light">Konfirmasi Hapus Pengajuan</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormHapusPengajuanAkses2">
                <!---- Konfirmasi Hapus Pengajuan Akses2----->
            </div>
        </div>
    </div>
</div>
<!--- Modal Terima Pengajuan Akses ---->
<div class="modal fade" id="ModalTerimaPengajuan" tabindex="-1" role="dialog" aria-labelledby="ModalTerimaPengajuan" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <b cass="text-light"><i class="ti ti-check"></i> Terima Pengajuan Akses</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormTerimaPengajuanAkses">
                <!---- Form Terima Pengajuan Akses ----->
            </div>
        </div>
    </div>
</div>
<!--- Modal Tolak Pengajuan Akses ---->
<div class="modal fade" id="ModalTolakPengajuan" tabindex="-1" role="dialog" aria-labelledby="ModalTolakPengajuan" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <b cass="text-light"><i class="ti ti-close"></i> Tolak Pengajuan Akses</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormTolakPengajuan">
                <!---- Form Tolak Pengajuan Akses ----->
            </div>
        </div>
    </div>
</div>
<!--- Modal Hapus Akses ---->
<div class="modal fade" id="ModalHapusAkses" tabindex="-1" role="dialog" aria-labelledby="ModalHapusAkses" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <b cass="text-light"><i class="ti ti-trash"></i> Hapus Akses</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormHapusAkses">
                <!---- Konfirmasi Hapus Akses ----->
            </div>
        </div>
    </div>
</div>
<!--- Modal Ubah Password ---->
<div class="modal fade" id="ModalUbahPassword" tabindex="-1" role="dialog" aria-labelledby="ModalUbahPassword" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-inverse">
                <b cass="text-light"><i class="ti ti-key"></i> Ubah Password</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormUbahPassword">
                <!---- Form Ubah Password ----->
            </div>
        </div>
    </div>
</div>
<!--- Modal Tambah akses ---->
<div class="modal fade" id="ModalTambahtAkses" tabindex="-1" role="dialog" aria-labelledby="ModalTambahtAkses" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <b cass="text-light"><i class="ti ti-plus"></i> Form Tambah Akses</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormTambahAkses">
                <!---- Form Tambah Akses ----->
            </div>
        </div>
    </div>
</div>
<!--- Modal Detail akses ---->
<div class="modal fade" id="ModalDetailAkses" tabindex="-1" role="dialog" aria-labelledby="ModalDetailAkses" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <b cass="text-light"><i class="ti ti-user"></i> Detail Data Akses</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormDetailAkses">
                <!---- Form Edit Akses ----->
            </div>
        </div>
    </div>
</div>
<!--- Modal edit akses ---->
<div class="modal fade" id="ModalEditAkses" tabindex="-1" role="dialog" aria-labelledby="ModalEditAkses" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-inverse">
                <b cass="text-light"><i class="ti ti-pencil-alt"></i> Form Edit Akses</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormEditAkses">
                <!---- Form Edit Akses ----->
            </div>
        </div>
    </div>
</div>
<!--- Modal edit Password ---->
<div class="modal fade" id="ModalEditPassword" tabindex="-1" role="dialog" aria-labelledby="ModalEditPassword" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-inverse">
                <b cass="text-light"><i class="ti ti-lock"></i> Edit Password</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormEditPassword">
                <!---- Form Edit Password ----->
            </div>
        </div>
    </div>
</div>
<!--- Modal Delete Akses ---->
<div class="modal fade" id="ModalDeleteAkses" tabindex="-1" role="dialog" aria-labelledby="ModalDeleteAkses" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <b cass="text-light">Konfirmasi Hapus Akses</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormDeleteAkses">
                <!---- Konfirmasi Delete Akses ----->
            </div>
        </div>
    </div>
</div>
<!--- Modal Setting Akses ---->
<div class="modal fade" id="ModalSettingAkses" tabindex="-1" role="dialog" aria-labelledby="ModalSettingAkses" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content" id="FormSettingAkses">
        <!----- Form Setting Akses ------>
        </div>
    </div>
</div>
<!--- Modal Filter Tabel---->
<div class="modal fade" id="ModalFilterTabel" tabindex="-1" role="dialog" aria-labelledby="ModalFilterTabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <b cass="text-light"><i class="ti-search"></i> Filter Tabel Akses</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormFilterTabel">
                <!---- Form Filter Tabel Siswa ----->
            </div>
        </div>
    </div>
</div>
<!--- Modal Export Akses ---->
<div class="modal fade" id="ModalExportAkses" tabindex="-1" role="dialog" aria-labelledby="ModalExportAkses" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <form action="_Page/Akses/ProsesEksportAkses.php" method="POST" target="_blank">
                <div class="modal-header bg-inverse">
                    <b cass="text-light"><i class="ti ti-export"></i> Eksport Akses</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-3 text-center">
                            <h1 class="ti ti-download"></h1>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="format"><dt>Format Data</dt></label>
                            <select name="format_eksport_akses" id="format_eksport_akses" class="form-control">
                                <option value="">Pilih</option>
                                <option value="HTML">HTML</option>
                                <option value="PDF">PDF</option>
                                <option value="Excel">Excel</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <input type="checkbox" id="TampilkanKop2" name="TampilkanKop" value="Ya">
                            <label for="TampilkanKop2">Tampilkan Kop Surat?</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-inverse">
                    <button type="submit" class="btn btn-md btn-primary mt-2 ml-2">
                        <i class="ti-download"></i> Export
                    </button>
                    <button type="button" class="btn btn-md btn-light mt-2 ml-2" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--- Modal Export Log Akses ---->
<div class="modal fade" id="ModalEksportLogAkses" tabindex="-1" role="dialog" aria-labelledby="ModalEksportLogAkses" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="_Page/Akses/ProsesExportLogAkses.php" method="POST" target="_blank">
                <div class="modal-header bg-inverse">
                    <b cass="text-light"><i class="ti ti-export"></i> Eksport Log Akses</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="FormEksportLogAkses">
                </div>
                <div class="modal-footer bg-inverse">
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="ti-download"></i> Export
                    </button>
                    <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Rekap Log Akses ---->
<div class="modal fade" id="ModalRekapLogAkses" tabindex="-1" role="dialog" aria-labelledby="ModalRekapLogAkses" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTampilkanGrafik">
                <div class="modal-header bg-inverse">
                    <b cass="text-light"><i class="ti ti-bar-chart"></i> Rekap Log Akses</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="FormShortGrafik">
                    
                </div>
                <div class="modal-body" id="MenampilkanGrafikLog">

                </div>
                <div class="modal-footer bg-inverse">
                    <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>