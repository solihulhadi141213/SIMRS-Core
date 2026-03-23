<div class="card-body border-0 pb-0">
    <form action="_Page/Pasien/ProsesExportPasien.php" method="POST" target="_blank">
        <div class="row">
            <div class="col-md-12 mb-3 form-group form-primary">
                <select name="short_by" id="short_by" class="form-control" required>
                    <option value="">--Short By--</option>
                    <option value="ASC">A to Z</option>
                    <option value="DESC">Z to A</option>
                </select>
                <small>Format Urutan</small>
            </div>
            <div class="col-md-12 mb-3 form-group form-primary">
                <select name="order_by" id="order_by" class="form-control" required>
                    <option value="">--Order By--</option>
                    <option value="tanggal_daftar">Tanggal Daftar</option>
                    <option value="nik ">NIK</option>
                    <option value="no_bpjs ">No.BPJS</option>
                    <option value="nama">Nama</option>
                    <option value="gender">Gender</option>
                    <option value="kontak">Kontak</option>
                    <option value="status">Status</option>
                </select>
                <small>Format Urutan</small>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3 form-group form-primary">
                <select name="format_by" id="format_by" class="form-control" required>
                    <option value="">--Format By--</option>
                    <option value="PDF">PDF</option>
                    <option value="HTML">HTML</option>
                    <option value="Excel">Excel</option>
                </select>
                <small>Cetak Data</small>
            </div>
            <div class="col-md-12 mb-3 form-group form-primary">
                <input type="text" name="keyword" id="keyword" class="form-control">
                <small>Kata Kunci</small>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3">
                <div id="NotifikasiTambahSiswa">
                    <small class="text-primary"><b>Keterangan :</b> Data Hasil Filter Akan Ditampilkan pada Halaman Baru.</small>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3">
                <div>
                    <button type="submit" id="TampilkanDataSiswa" class="btn btn-md btn-outline-primary"><i class="ti-arrow-circle-down"></i> Tampilkan</button>
                    <button type="reset" class="btn btn-md btn-outline-warning" id="KembaliKeProfile"><i class="ti-reload"></i> Reset</button>
                </div>
            </div>
        </div>
    </form>
</div>