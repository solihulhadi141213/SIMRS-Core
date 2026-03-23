<form action="javascript:void(0);" method="POST" id="ProsesTambahAkses">
    <div class="modal-body border-0 pb-0">
        <div class="row">
            <div class="col-md-6 mb-3">
                <div>
                    <label for="first_name">Nama Lengkap</label>
                    <input type="text" class="form-control" id="nama" name="nama" required>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div>
                    <label for="last_name">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="alamatemail@domain.com" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <div>
                    <label for="first_name">No.Kontak</label>
                    <input type="number" min="0" class="form-control" id="kontak" name="kontak" required>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div>
                    <label for="first_name">Hak Akses</label>
                    <input type="text" class="form-control" id="akses" name="akses" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3">
                <div>
                    <label for="first_name">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <div>
                    <label for="first_name">Password</label>
                    <input type="password" class="form-control" id="password1" name="password1" required>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div>
                    <label for="first_name">Ulangi Password</label>
                    <input type="password" class="form-control" id="password2" name="password2" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3">
                <div>
                    <label for="first_name">Photo</label>
                    <input type="file" class="form-control" id="gambar" name="gambar">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3">
                <div id="NotifikasiTambahAkses">
                    <small class="text-primary"><b>Keterangan :</b> Isi data akses pada form dengan benar.</small>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer bg-primary">
        <div class="row">
            <div class="col-md-12 mb-3">
                <div>
                    <button type="submit" class="btn btn-md btn-inverse mt-2 ml-2">
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