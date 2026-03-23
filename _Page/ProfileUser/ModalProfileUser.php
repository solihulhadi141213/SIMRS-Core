<!--- Modal Edit Profile ---->
<div class="modal fade" id="ModalEditProfile" tabindex="-1" role="dialog" aria-labelledby="ModalEditProfile" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <b cass="text-light"><i class="ti-user"></i> Edit Profile</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormEditProfile">
                <!---- Form Edit Profile----->
            </div>
        </div>
    </div>
</div>
<!--- Modal Ganti Password---->
<div class="modal fade" id="ModalGantiPassword" tabindex="-1" role="dialog" aria-labelledby="ModalGantiPassword" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <b cass="text-light"><i class="ti-lock"></i> Ganti Password</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormGantiPassword">
                <!---- Form Ganti Password---->
            </div>
        </div>
    </div>
</div>
<!--- Modal Ganti Foto---->
<div class="modal fade" id="ModalEditFoto" tabindex="-1" role="dialog" aria-labelledby="ModalEditFoto" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <b cass="text-light"><i class="ti-lock"></i> Ganti Foto Profile</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormGantiFoto">
                <!---- Form Ganti Password---->
            </div>
        </div>
    </div>
</div>
<!--- Modal Kirim Laporan Pengguna---->
<div class="modal fade" id="ModalKirimLaporanPengguna" tabindex="-1" role="dialog" aria-labelledby="ModalKirimLaporanPengguna" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesKirimLaporanPengguna">
                <div class="modal-header bg-primary">
                    <b cass="text-light"><i class="icofont-paper-plane"></i> Kirim Laporan</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
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
                <div class="modal-footer bg-primary">
                    <button type="submit" class="btn btn-sm btn-inverse">
                        <i class="ti-save"></i> Kirim
                    </button>
                    <button type="button" class="btn btn-sm btn-white ml-2" data-dismiss="modal" aria-label="Close">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Detail Laporan Pengguna---->
<div class="modal fade" id="ModalDetailLaporanPengguna" tabindex="-1" role="dialog" aria-labelledby="ModalDetailLaporanPengguna" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <b cass="text-light"><i class="ti ti-info-alt"></i> Detail Laporan Pengguna</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="FormDetailLaporanPengguna">
                <!---- Form Ganti Password---->
            </div>
            <div class="modal-footer bg-info">
                    <button type="button" class="btn btn-sm btn-white ml-2" data-dismiss="modal" aria-label="Close">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
        </div>
    </div>
</div>