<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">
                        <a href="" class="h5"><i class="ti ti-text"></i> Artikel</a>
                    </h5>
                    <p class="m-b-0">Kelola data Artikel halaman website</p>
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
                        <form action="javascript:void(0);" id="ProsesTambahArtikel">
                            <div class="card table-card">
                                <div class="card-header border-info">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <dt>Form Tambah Artikel</dt>
                                        </div>
                                        <div class="col-md-2">
                                            <a href="index.php?Page=WebArtikel" class="btn btn-sm btn-block btn-secondary">
                                                <i class="ti ti-angle-left"></i> Kembali
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="artikel_judul">Judul Artikel</label>
                                            <input type="text" name="artikel_judul" id="artikel_judul" class="form-control">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="artikel_kategori">Kategori</label>
                                            <input type="text" name="artikel_kategori" id="artikel_kategori" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="artikel_tanggal">Tanggal</label>
                                            <input type="date" name="artikel_tanggal" id="artikel_tanggal" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="artikel_jam">Jam</label>
                                            <input type="time" name="artikel_jam" id="artikel_jam" class="form-control" value="<?php echo date('H:i'); ?>">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="artikel_penulis">Author</label>
                                            <input type="text" name="artikel_penulis" id="artikel_penulis" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="artikel_ringkasan">Ringkasan</label>
                                            <input type="text" name="artikel_ringkasan" id="artikel_ringkasan" class="form-control" value="">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="artikel_isi">Isi Artikel</label>
                                            <textarea name="artikel_isi" id="artikel_isi" cols="30" rows="4" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="artikel_status">Status Artikel</label>
                                            <select name="artikel_status" id="artikel_status" class="form-control">
                                                <option value="Draft">Draft</option>
                                                <option value="Publish">Publish</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col col-md-12 mb-3">
                                            <span class="text-primary" id="NotifikasiTambahArtikel">Pastikan semua data Artikel sudah terisi dengan benar</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-md btn-primary" id="KlikProsesTambahArtikel">
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