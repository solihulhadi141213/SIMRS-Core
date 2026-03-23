<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">
                        <a href="" class="h5"><i class="ti ti-bag"></i> Tambah Lowongan Kerja</a>
                    </h5>
                    <p class="m-b-0">Tambah data lowongan kerja</p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="row">
                    <div class="col-xl-12 col-md-12">
                        <form action="javascript:void(0);" id="ProsesTambahLoker">
                            <div class="card table-card">
                                <div class="card-header border-info">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <dt>Form Tambah Lowongan Kerja</dt>
                                        </div>
                                        <div class="col-md-2">
                                            <a href="index.php?Page=WebLoker" class="btn btn-sm btn-block btn-secondary">
                                                <i class="ti ti-angle-left"></i> Kembali
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3 mb-3">
                                            <label for="tanggal_expired">Tanggal Berakhir</label>
                                            <input type="date" name="tanggal_expired" id="tanggal_expired" class="form-control">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="jam_expired">Jam Berakhir</label>
                                            <input type="time" name="jam_expired" id="jam_expired" class="form-control">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="jumlah_loker">Jumlah</label>
                                            <input type="number" name="jumlah_loker" id="jumlah_loker" class="form-control">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="status_loker">Status Loker</label>
                                            <select name="status_loker" id="status_loker" class="form-control">
                                                <option value="Active">Active</option>
                                                <option value="Closed">Closed</option>
                                                <option value="Expired">Expired</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="posisi_jabatan">Posisi/Jabatan</label>
                                            <input type="text" name="posisi_jabatan" id="posisi_jabatan" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="deskripsi_loker">Deskripsi Loker</label>
                                            <textarea name="deskripsi_loker" id="deskripsi_loker" cols="30" rows="4" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col col-md-12 mb-3">
                                            <span class="text-primary" id="NotifikasiTambahLoker">Pastikan semua data lowongan sudah terisi dengan benar</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-md btn-primary" id="KlikProsesTambahLoker">
                                        <i class="ti ti-save"></i> Simpan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>