<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">
                        <a href="index.php?Page=WebEvent&Sub=TambahEvent" class="h5">
                            <i class="ti ti-image"></i> Tambah Album Event
                        </a>
                    </h5>
                    <p class="m-b-0">Tambah informasi album event pada website</p>
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
                        <form action="javascript:void(0);" id="ProsesTambahAlbumEvent">
                            <div class="card table-card">
                                <div class="card-header border-info">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <dt>Form Tambah Album Event</dt>
                                        </div>
                                        <div class="col-md-2">
                                            <a href="index.php?Page=WebEvent" class="btn btn-sm btn-block btn-secondary">
                                                <i class="ti ti-angle-left"></i> Kembali
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="nama_event">Nama/Judul Event</label>
                                            <input type="text" name="nama_event" id="nama_event" class="form-control">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="kategori_event">Kategori</label>
                                            <input type="text" name="kategori_event" id="kategori_event" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 mb-3">
                                            <label for="tanggal_event">Tanggal</label>
                                            <input type="date" name="tanggal_event" id="tanggal_event" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="jam_event">Jam</label>
                                            <input type="time" name="jam_event" id="jam_event" class="form-control" value="<?php echo date('H:i'); ?>">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="poster_event">Poster/Foto</label>
                                            <input type="file" name="poster_event" id="poster_event" class="form-control">
                                            <small>
                                                Kami menyarankan untuk menggunakan file foto dengan ukuran yang seragam. Saran kami menggunakan format JPG untuk dukurangn file base 64
                                            </small>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="deskripsi_event">Deskripsi Event</label>
                                            <textarea name="deskripsi_event" id="deskripsi_event" cols="30" rows="4" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col col-md-12 mb-3">
                                            <span class="text-primary" id="NotifikasiTambahEvent">Pastikan semua data event sudah terisi dengan benar</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-md btn-primary" id="KlikProsesTambahAlbumEvent">
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