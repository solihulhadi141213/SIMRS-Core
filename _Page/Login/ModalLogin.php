<!-- Modal Pengajuan Akses -->
<div class="modal fade" id="ModalPengajuanAkses" tabindex="-1" aria-labelledby="ModalPengajuanAkses" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesPengajuanAkses" autocomplete="off" enctype="multipart/form-data">
                <input type="hidden" name="id_captcha" id="id_captcha_pengajuan_akses">
                <!-- Header -->
                <div class="modal-header text-dark">
                    <h5 class="modal-title">
                        <i class="icofont icofont-paper-plane"></i> Lembar Pengajuan Akses
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Body -->
                <div class="modal-body p-4">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="nama">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="nik">Nomor KTP/NIK</label>
                            <input type="text" class="form-control" id="nik" name="nik" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="kontak">Nomor Kontak</label>
                            <input type="text" class="form-control" id="kontak" name="kontak" placeholder="62" required>
                            <small class="text-muted">Gunakan nomor kontak yang valid, untuk mempermudah admin menghubungi anda menghubungi anda.</small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="email">Alamat Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="email@domain.com" required>
                            <small class="text-muted">Informasi kredensial akses akan di kirim ke email anda</small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="alamat">Alamat Tinggal</label>
                            <textarea name="alamat" id="alamat" class="form-control" cols="30" rows="3" maxlength="200" required></textarea>
                            <small class="text-muted">
                                <small class="text-muted" id="jumlah_karakter_alamat">(0 / 200)</small>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="deskripsi">
                                Kebutuhan Akses
                            </label>
                            <textarea name="deskripsi" id="deskripsi" class="form-control" cols="30" rows="3" maxlength="200" required></textarea>
                            <small class="text-muted">
                                <small class="text-muted" id="jumlah_karakter_deskripsi">(0 / 200)</small>
                            </small>
                            <br>
                            <small class="text-muted">
                                Jelaskan kepada kami, entitas akses apa yang anda butuhkan. Atau, jelaskan fitur yang anda butuhkan untuk dapat digunakan.
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="email">Pas Foto</label>
                            <input type="file" class="form-control" id="foto" name="foto" required>
                            <small class="text-muted">Gunakan foto jelas diri anda dengan format JPG, JPEG, GIF atau PNG (maksimal 2 mb)</small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 text-center">
                            <img src="" alt="captcha" width="100%" id="CaptchaPengajuanAkses" /><br>
                            <a href="javascript:void(0);" id="ReloadCaptchaPengajuanAkses" class="text-danger text-decoration-none">
                                <i class="ti ti-reload"></i> Reload Captcha
                            </a>
                        </div>
                        <div class="col-md-6">
                            <label for="captcha">Masukan Kode Captcha</label>
                            <input type="text" class="form-control" id="captcha_pengajuan_akses" name="captcha" required>
                            <small class="text-muted">Masukan kode captcha dari gambar di atas</small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                           <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="pernyataan_persetujuan" name="pernyataan_persetujuan" value="Setuju" checked>
                                <label for="pernyataan_persetujuan">
                                    <small class="text-muted">
                                        Dengan ini saya menyatakan dengan sesungguhnya bahwa semua informasi yang disampaikan dalam seluruh 
                                        dokumen serta lampiran-lampirannya ini adalah benar dan kesatuan yang tidak dapat dipisahkan. 
                                        Apabila diketemukan dan/atau dibuktikan adanya penipuan/pemalsuan atas informasi yang kami sampaikan, 
                                        maka kami bersedia dikenakan dan menerima penerapan sanksi.
                                    </small>
                                </label>
                           </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" id="NotifikasiPengajuanAkses">
                            <!-- Notifikasi Pengajuan Akses -->
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-md btn-round" id="button_kirim_pengajuan">
                        <i class="icofont icofont-paper-plane"></i> Kirim Pengajuan
                    </button>
                    <button type="button" class="btn btn-dark btn-md btn-round" data-bs-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Reset Password -->
<div class="modal fade" id="ModalResetPassword" tabindex="-1" aria-labelledby="ModalResetPassword" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesResetPassword" autocomplete="off" enctype="multipart/form-data">
                
            <!-- Header -->
                <div class="modal-header text-dark">
                    <h5 class="modal-title">
                        <i class="bi bi-shield-lock"></i> Reset Password
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Body -->
                <div class="modal-body p-4">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="email_anda">Masukan Email Anda</label>
                            <input type="email" class="form-control" id="email_anda" name="email" required>
                            <small>
                                Setelah tautan dikirim, silahkan periksa <i>Inbox</i> pada email anda.
                            </small>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12" id="NotifikasiResetPassword">
                            <!-- Notifikasi Pengajuan Akses -->
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-md btn-round" id="button_kirim_tautan">
                        <i class="bi bi-send"></i> Kirim Tautan
                    </button>
                    <button type="button" class="btn btn-dark btn-md btn-round" data-bs-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>