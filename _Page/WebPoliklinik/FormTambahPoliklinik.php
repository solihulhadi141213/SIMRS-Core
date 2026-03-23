<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">
                        <a href="index.php?Page=WebPoliklinik" class="h5"><i class="ti ti-view-grid"></i> Poliklinik</a>
                    </h5>
                    <p class="m-b-0">Kelola data Poliklinik halaman website</p>
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
                        <form action="javascript:void(0);" id="ProsesTambahPoliklinik">
                            <div class="card table-card">
                                <div class="card-header border-info">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <dt>Form Tambah Poliklinik</dt>
                                        </div>
                                        <div class="col-md-2">
                                            <a href="index.php?Page=WebPoliklinik" class="btn btn-md btn-block btn-secondary">
                                                <i class="ti ti-angle-left"></i> Kembali
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 mt-3">
                                            <label for="nama">Nama Poliklinik</label>
                                            <input type="text" name="nama" id="nama" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mt-3">
                                            <label for="deskripsi">Deskripsi</label>
                                            <textarea name="deskripsi" id="deskripsi" cols="30" rows="10"></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mt-3">
                                            <label for="kode">Kode Poli</label>
                                            <input type="text" name="kode" id="kode" class="form-control">
                                        </div>
                                        <div class="col-md-6 mt-3">
                                            <label for="status">Kode Poli</label>
                                            <select name="status" id="status" class="form-control">
                                                <option value="Aktif">Aktif</option>
                                                <option value="None">None</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col col-md-12 mb-3">
                                            <span class="text-primary" id="NotifikasiTambahPoliklinik">Pastikan semua data poliklinik sudah terisi dengan benar</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-md btn-primary" id="KlikProsesTambahPoliklinik">
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