<!--- Modal Filter Obat ---->
<div class="modal fade" id="ModalFilterObat" tabindex="-1" role="dialog" aria-labelledby="ModalFilterObat" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="BatasPencarian" autocomplete="off">
                <div class="modal-header">
                    <b><i class="icofont-filter"></i> Filter Data Obat</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="batas">Batas Data</label>
                            <select name="batas" id="batas" class="form-control">
                                <option value="5">5</option>
                                <option selected value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="OrderBy">Urutkan Berdasarkan</label>
                            <select name="OrderBy" id="OrderBy" class="form-control">
                                <option value="">Pilih</option>
                                <option value="id_obat">ID Obat/Alkes</option>
                                <option value="kode">Kode</option>
                                <option value="nama">Nama/Merek</option>
                                <option value="kelompok">Kelompok</option>
                                <option value="kategori">Kategori</option>
                                <option value="tanggal">Tanggal Input</option>
                                <option value="updatetime">Update Time</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="ShortBy">Mode Urutan</label>
                            <select name="ShortBy" id="ShortBy" class="form-control">
                                <option value="DESC">DESC</option>
                                <option value="ASC">ASC</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="keyword_by">Dasar Pencarian</label>
                            <select name="keyword_by" id="keyword_by" class="form-control">
                                <option value="">Pilih</option>
                                <option value="id_obat">ID Obat/Alkes</option>
                                <option value="kode">Kode</option>
                                <option value="nama">Nama/Merek</option>
                                <option value="kelompok">Kelompok</option>
                                <option value="kategori">Kategori</option>
                                <option value="tanggal">Tanggal Input</option>
                                <option value="updatetime">Update Time</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="keyword">Kata Kunci</label>
                            <div id="FormKeyword">
                                <input type="text" class="form-control" name="keyword" id="keyword" placeholder="Kode, Nama , Kategori, Satuan">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary btn-round">
                        <i class="ti ti-filter"></i> Filter
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary btn-round" data-dismiss="modal">
                        <i class="ti ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Kategori Harga ---->
<div class="modal fade" id="ModalKategoriHarga" tabindex="-1" role="dialog" aria-labelledby="ModalKategoriHarga" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b><i class="icofont-tags"></i> Kategori Harga Obat</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-12">
                        <button class="btn btn-sm btn-block btn-outline-primary btn-round" data-toggle="modal" data-target="#ModalTambahKategoriHarga" title="Tambah Kategori Harga">
                            <i class="ti ti-plus"></i> Tambah Kategori
                        </button>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <ol class="list-group list-group-numbered" id="ListKategori">
                            <!-- <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Subheading</div>
                                    Content for list item
                                </div>
                                <span class="badge bg-primary rounded-pill">14</span>
                            </li> -->
                        </ol>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary btn-round" data-dismiss="modal">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Tambah Kategori Harga ---->
<div class="modal fade" id="ModalTambahKategoriHarga" tabindex="-1" role="dialog" aria-labelledby="ModalTambahKategoriHarga" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahKategoriHarga">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-plus"></i> Form Tambah Kategori Harga</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="kategori_harga">Kategori Harga</label>
                            <input type="text" name="kategori_harga" id="kategori_harga" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="keterangan">Keterangan</label>
                            <textarea name="keterangan" id="keterangan" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12" id="NotifikasiTambahKategoriHarga">
                            <span class="text-primary">Pastikan informasi kategori obat yang anda input sudah benar!</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary btn-round">
                        <i class="ti-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary btn-round" data-toggle="modal" data-target="#ModalKategoriHarga">
                        <i class="ti ti-angle-left"></i> Kembali
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Edit Kategori Harga ---->
<div class="modal fade" id="ModalEditKategoriHarga" tabindex="-1" role="dialog" aria-labelledby="ModalEditKategoriHarga" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditKategoriHarga">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-pencil"></i> Edit Kategori Harga</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="FormEditKategoriHarga">
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12" id="NotifikasiEditKategoriHarga">
                            <span class="text-primary">Pastikan informasi kategori obat yang anda input sudah benar!</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary btn-round">
                        <i class="ti-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary btn-round" data-toggle="modal" data-target="#ModalKategoriHarga">
                        <i class="ti ti-angle-left"></i> Kembali
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Hapus Kategori Obat ---->
<div class="modal fade" id="ModalHapusKategoriHarga" tabindex="-1" role="dialog" aria-labelledby="ModalHapusKategoriHarga" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusKategoriHarga">
                <div class="modal-header bg-danger">
                    <b cass="text-light"><i class="ti ti-trash"></i> Hapus kategori Harga</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormHapusKategoriHarga">
                    <!---- Form Hapus Kategori Harga ----->
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Tambah Obat ---->
<div class="modal fade" id="ModalTambahObat" tabindex="-1" role="dialog" aria-labelledby="ModalTambahObat" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahObat" autocomplete="off">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-plus"></i> Tambah Obat/Alkes</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="kode">Kode</label>
                        </div>
                        <div class="col-md-8">
                            <div class="input-group">
                                <input type="text" name="kode" id="kode" class="form-control" required>
                                <button type="button" class="btn btn-sm btn-outline-secondary" title="Generate Kode Baru" id="GenerateKodeObatBaru">
                                    <i class="ti ti-reload"></i>
                                </button>
                            </div>
                            <small>
                                <i>Apabila anda memilih melakukan genertae kode, maka sistem akan membutakan kode 16 digit angka acak</i>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="nama_obat">Nama/Merek</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="nama_obat" id="nama_obat" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="kelompok">Kelompok</label>
                        </div>
                        <div class="col-md-8">
                            <select name="kelompok" id="kelompok" class="form-control">
                                <option value="Obat">Obat</option>
                                <option value="Alkes">Alkes</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="kategori">Kategori</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="kategori" id="kategori" list="DataListKategori" class="form-control" required>
                            <datalist id="DataListKategori">
                                <option value="a">
                                <?php
                                    $QryKategori=mysqli_query($Conn, "SELECT DISTINCT kategori FROM obat")or die(mysqli_error($Conn));
                                    while($HasilKategori=mysqli_fetch_array($QryKategori)){
                                        echo '<option value="'.$HasilKategori['kategori'].'">';
                                    }
                                ?>
                            </datalist>
                            <small>Informasi/keterangan group data obat</small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="satuan">Satuan</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="satuan" id="satuan" list="DataListSatuan" class="form-control">
                            <datalist id="DataListSatuan">
                                <option value="a">
                                <?php
                                    $QrySatuan=mysqli_query($Conn, "SELECT DISTINCT satuan FROM obat")or die(mysqli_error($Conn));
                                    while($HasilSatuan=mysqli_fetch_array($QrySatuan)){
                                        echo '<option value="'.$HasilSatuan['satuan'].'">';
                                    }
                                ?>
                            </datalist>
                            <small>
                                Untuk mempermudah penggunaan fitur multi satuan, kami merekomendasikan menggunakan satuan terkecil yang digunakan.
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="isi">Isi/Kemasan</label>
                        </div>
                        <div class="col-md-8">
                            <input type="number" min="0" step="1" name="isi" id="isi" class="form-control" value="1">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="stok">Stok</label>
                        </div>
                        <div class="col-md-8">
                            <input type="number" min="0" step="1" name="stok" id="stok" class="form-control" value="0">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="stok_min">Stok Minimum</label>
                        </div>
                        <div class="col-md-8">
                            <input type="number" min="0" step="1" name="stok_min" id="stok_min" class="form-control" value="0">
                            <small>Ketika stok berada di ambang stok minimum maka sistem akan memberikan informasi.</small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="harga">Harga Beli</label>
                        </div>
                        <div class="col-md-8">
                            <input type="number" min="0" step="1" name="harga" id="harga" class="form-control" value="0">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="">Multi Harga</label>
                        </div>
                        <div class="col-md-8" id="MutliHarga">
                            
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="keterangan">Keterangan/Catatan</label>
                        </div>
                        <div class="col-md-8">
                            <textarea name="keterangan" id="keterangan" class="form-control"></textarea>
                            <small>Sertakan catatan/keterangan penting</small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <dt class="text-primary">Keterangan:</dt>
                        </div>
                        <div class="col-md-8" id="NotifikasiTambahObat">
                            <span class="text-primary">Pastikan Data Yang Anda Input Sudah Sesuai</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="ti ti-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--- Modal Detail Obat ---->
<div class="modal fade" id="ModalDetailObat" tabindex="-1" role="dialog" aria-labelledby="ModalTambahObat" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-info-alt"></i> Detail Obat/Alkes</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="FormDetailObat">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary btn-round" data-dismiss="modal">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Edit Obat ---->
<div class="modal fade" id="ModalEditObat" tabindex="-1" role="dialog" aria-labelledby="ModalEditObat" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditObat" autocomplete="off">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-pencil"></i> Edit Obat</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="FormEditObat"></div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <dt class="text-primary">Keterangan:</dt>
                        </div>
                        <div class="col-md-8" id="NotifikasiEditObat">
                            <span class="text-primary">Pastikan Data Yang Anda Input Sudah Sesuai</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary btn-round">
                        <i class="ti ti-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary btn-round" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Delete Obat ---->
<div class="modal fade" id="ModalHapusObat" tabindex="-1" role="dialog" aria-labelledby="ModalHapusObat" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-trash"></i> Delete Obat</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="FormHapusObat">
                <!---- Form Delete Obat ----->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary btn-round" data-dismiss="modal">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Pilih Medication Ingridient -->
<div class="modal fade" id="ModalPilihRacikan" tabindex="-1" role="dialog" aria-labelledby="ModalPilihRacikan" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-plus"></i> Tambah Medication</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="FormPilihRacikan">
                <!-- Form Pilih Racikan -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary btn-round" data-dismiss="modal" aria-label="Close">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Medication -->
<div class="modal fade" id="ModalTambahMedication" tabindex="-1" role="dialog" aria-labelledby="ModalTambahMedication" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahMedication">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-plus"></i> Tambah Medication</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="FormTambahMedication">

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" id="NotifikasiTambahMedication">

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary btn-round">
                        <i class="ti ti-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary btn-round" data-dismiss="modal" aria-label="Close">
                        <i class="ti ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- ModalTambah  Multi Satuan ---->
<div class="modal fade" id="ModalTambahSatuanMulti" tabindex="-1" role="dialog" aria-labelledby="ModalTambahSatuanMulti" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahSatuanMulti">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-plus"></i> Multi Satuan Obat</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="FormTambahSatuanMulti">
                        <!---- Form Tambah Multi Satuan ----->
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <dt class="text-primary">Keterangan : </dt>
                        </div>
                        <div class="col-md-8" id="NotifikasiTambahSatuanMulti">
                            <span class="text-primary">Pastikan Data Yang Anda Input Sudah Sesuai</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary btn-round">
                        <i class="ti-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary btn-round" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Edit Multi Satuan ---->
<div class="modal fade" id="ModalEditSatuanMulti" tabindex="-1" role="dialog" aria-labelledby="ModalEditSatuanMulti" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditSatuanMulti">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-pencil-alt"></i> Multi Satuan Obat</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="FormEditSatuanMulti">
                        <!---- Form Tambah Multi Satuan ----->
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <dt class="text-primary">Keterangan : </dt>
                        </div>
                        <div class="col-md-8" id="NotifikasiEditSatuanMulti">
                            <span class="text-primary">Pastikan Data Yang Anda Input Sudah Sesuai</span>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-sm btn-primary btn-round btn-block">
                                <i class="ti-save"></i> Simpan Perubahan
                            </button>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-sm btn-outline-danger btn-round btn-block" id="KonfirmasiHapusSatuanMulti">
                                <i class="ti-trash"></i> Hapus Satuan
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary btn-round" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Posisi Obat ---->
<div class="modal fade" id="ModalPosisiObat" tabindex="-1" role="dialog" aria-labelledby="ModalPosisiObat" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesPosisiObat">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-pencil-alt"></i> Posisi Penyimpanan Obat</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="FormPosisiObat">
                        <!---- Form Posisi Obat ----->
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <dt class="text-primary">Keterangan : </dt>
                        </div>
                        <div class="col-md-8" id="NotifikasiPosisiObat">
                            <span class="text-primary">Pastikan Data Yang Anda Input Sudah Sesuai</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary btn-round">
                        <i class="ti-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary btn-round" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Multi Harga ---->
<div class="modal fade" id="ModalMultiHarga" tabindex="-1" role="dialog" aria-labelledby="ModalMultiHarga" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-inverse">
                <b cass="text-light"><i class="icofont-price"></i> Multi Satuan Obat</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormTambahMultiHarga">
                <!---- Form Tambah Multi Harga ----->
            </div>
        </div>
    </div>
</div>
<!--- Modal Tambah Batch & Expire ---->
<div class="modal fade" id="ModalTambahExpiredDate" tabindex="-1" role="dialog" aria-labelledby="ModalTambahExpiredDate" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahExpiredDate">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-calendar"></i> Tambah Expired Date</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="FormTambahExpiredDate">
                        <!---- Form Tambah Expired Date ----->
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <dt class="text-primary">Keterangan : </dt>
                        </div>
                        <div class="col-md-8" id="NotifikasiExpiredDate">
                            <span class="text-primary">Pastikan Data Yang Anda Input Sudah Sesuai</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary btn-round">
                        <i class="ti-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary btn-round" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Edit Batch & Expire ---->
<div class="modal fade" id="ModalEditExpiredDate" tabindex="-1" role="dialog" aria-labelledby="ModalEditExpiredDate" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditExpiredDate">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-calendar"></i> Edit Expired Date</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="FormEditExpiredDate">
                        <!---- Form Edit Expired Date ----->
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <dt class="text-primary">Keterangan : </dt>
                        </div>
                        <div class="col-md-8" id="NotifikasiEditExpiredDate">
                            <span class="text-primary">Pastikan Data Yang Anda Input Sudah Sesuai</span>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-sm btn-block btn-primary btn-round">
                                <i class="ti-save"></i> Simpan
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-sm btn-block btn-outline-danger btn-round" id="ClickHapusExpiredDate">
                                <i class="ti-trash"></i> Hapus
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary btn-round" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal History Transaksi---->
<div class="modal fade" id="ModalHistoryTransaksi" tabindex="-1" role="dialog" aria-labelledby="ModalHistoryTransaksi" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <b cass="text-light"><i class="icofont-history"></i> History Transaksi Obat</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="DataHistoryTransaksiObat">
                <!---- Data History Transaksi Obat ----->
            </div>
        </div>
    </div>
</div>
<!--- Modal Filter Obat---->

<!--- Modal Export Obat---->
<div class="modal fade" id="ModalExportObat" tabindex="-1" role="dialog" aria-labelledby="ModalExportObat" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="_Page/Obat/ExportObat.php" method="POST" target="_blank">
                <div class="modal-header bg-info">
                    <b class="text-light"><i class="icofont-file-alt"></i> Export Data Obat</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="FormExportObat">
                    <!---- Form Filter Obat ----->
                </div>
                <div class="modal-footer bg-info">
                    <button type="submit" class="btn btn-md btn-primary">
                        <i class="icofont-check-circled"></i> Export
                    </button>
                    <button type="button" class="btn btn-md btn-light" data-dismiss="modal">
                        <i class="ti ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Import Obat---->
<div class="modal fade" id="ModalImportObat" tabindex="-1" role="dialog" aria-labelledby="ModalImportObat" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesImportObat">
                <div class="modal-header bg-info">
                    <b class="text-light"><i class="icofont-file-alt"></i> Import Data Obat</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="FormImportObat">
                    <!-- Form Import Obat -->
                </div>
                <div class="modal-footer bg-info">
                    <button type="submit" class="btn btn-md btn-primary">
                        <i class="icofont-check-circled"></i> Import
                    </button>
                    <button type="button" class="btn btn-md btn-light" data-dismiss="modal">
                        <i class="ti ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Update Obat Parsial---->
<div class="modal fade" id="ModalUpdateObatParsial" tabindex="-1" role="dialog" aria-labelledby="ModalUpdateObatParsial" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesUpdateObatParsial">
                <div class="modal-header bg-success">
                    <b class="text-light"><i class="icofont-edit"></i> Update Data Obat</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table table-responsive">
                                <table class="table table-bordered table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center"><dt>No</dt></th>
                                            <th class="text-center"><dt>Kode</dt></th>
                                            <th class="text-center"><dt>Kelompok</dt></th>
                                            <th class="text-center"><dt>Kategori</dt></th>
                                            <th class="text-center"><dt>Min</dt></th>
                                            <th class="text-center"><dt>Option</dt></th>
                                        </tr>
                                    </thead>
                                    <tbody id="TabelUpdateObatParsial">
                                        <tr>
                                            <td class="text-center" colspan="6">
                                                <span class="text-danger">Tidak Ada Data yang Dipilih</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-3 mb-3">
                            Silahkan isi parameter yang ingin diubah
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <label for="KelompokParsial">Kelompok</label>
                            <input type="text" disabled name="KelompokParsial" id="KelompokParsial" class="form-control" list="ListKelompok">
                            <datalist id="ListKelompok">
                                <option value="Obat">
                                <option value="Alkes">
                            </datalist>
                            <small>
                                <input type="checkbox" name="aktifkan_kelompok" id="aktifkan_kelompok" value="Ya"> 
                                <label for="aktifkan_kelompok">Update Kelompok</label>
                            </small>
                        </div>
                        <div class="col-md-3">
                            <label for="KategoriParsial">Kategori</label>
                            <input type="text" disabled name="KategoriParsial" id="KategoriParsial" class="form-control" list="ListKategori">
                            <datalist id="ListKategori">
                                <?php
                                    //Tampilkan data
                                    $QryKategori=mysqli_query($Conn, "SELECT DISTINCT kategori FROM obat")or die(mysqli_error($Conn));
                                    while($HasilKategori=mysqli_fetch_array($QryKategori)){
                                        echo "<option value='$HasilKategori[kategori]'>$HasilKategori[kategori]</option>";
                                    }
                                ?>
                            </datalist>
                            <small>
                                <input type="checkbox" name="aktifkan_kategori" id="aktifkan_kategori" value="Ya"> 
                                <label for="aktifkan_kategori">Update kategori</label>
                            </small>
                        </div>
                        <div class="col-md-3">
                            <label for="SatuanParsial">Satuan</label>
                            <input type="text" disabled name="SatuanParsial" id="SatuanParsial" class="form-control" list="ListSatuan">
                            <datalist id="ListSatuan">
                                <?php
                                    //Tampilkan data satuan
                                    $QrySatuan=mysqli_query($Conn, "SELECT DISTINCT satuan FROM obat")or die(mysqli_error($Conn));
                                    while($HasilSatuan=mysqli_fetch_array($QrySatuan)){
                                        echo "<option value='$HasilSatuan[satuan]'>$HasilSatuan[satuan]</option>";
                                    }
                                ?>
                            </datalist>
                            <small>
                                <input type="checkbox" name="aktifkan_satuan" id="aktifkan_satuan" value="Ya"> 
                                <label for="aktifkan_satuan">Update Satuan</label>
                            </small>
                        </div>
                        <div class="col-md-3">
                            <label for="stok_minimum">Stok Minimum</label>
                            <input type="number" disabled name="stok_minimum" id="stok_minimum" class="form-control">
                            <small>
                                <input type="checkbox" name="aktifkan_stok_minimum" id="aktifkan_stok_minimum" value="Ya"> 
                                <label for="aktifkan_stok_minimum">Update Stok Minimum</label>
                            </small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-success">
                    <button type="submit" class="btn btn-sm btn-primary btn-round">
                        <i class="icofont-check-circled"></i> Update Parsial
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary btn-round" data-dismiss="modal">
                        <i class="ti ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Hapus Obat Parsial---->
<div class="modal fade" id="ModalHapusObatParsial" tabindex="-1" role="dialog" aria-labelledby="ModalHapusObatParsial" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusParsial">
                <div class="modal-header bg-danger">
                    <b class="text-light"><i class="icofont-trash"></i> Hapus Data Obat</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 pre-scrollable">
                            <div class="table table-responsive">
                                <table class="table table-bordered table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center"><dt>No</dt></th>
                                            <th class="text-center"><dt>Kode</dt></th>
                                            <th class="text-center"><dt>Obat</dt></th>
                                            <th class="text-center"><dt>Kategori</dt></th>
                                            <th class="text-center"><dt>Min</dt></th>
                                            <th class="text-center"><dt>Option</dt></th>
                                        </tr>
                                    </thead>
                                    <tbody id="TabelHapusObatParsial">
                                        <tr>
                                            <td class="text-center" colspan="6">
                                                <span class="text-danger">Tidak Ada Data yang Dipilih</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-danger">
                    <button type="submit" class="btn btn-md btn-outline-dark">
                        <i class="icofont-trash"></i> Hapus Data
                    </button>
                    <button type="button" class="btn btn-md btn-light" data-dismiss="modal">
                        <i class="ti ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Cetak Bar Code Obat Parsial---->
<div class="modal fade" id="ModalCetakParsial" tabindex="-1" role="dialog" aria-labelledby="ModalCetakParsial" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="_Page/Obat/ProsesCetakBarcodeParsial.php" target="_blank" method="POST">
                <div class="modal-header bg-primary">
                    <b class="text-light"><i class="icofont-trash"></i> Cetak Barcode Obat</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 pre-scrollable">
                            <div class="table table-responsive">
                                <table class="table table-bordered table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center"><dt>No</dt></th>
                                            <th class="text-center"><dt>Kode</dt></th>
                                            <th class="text-center"><dt>Obat</dt></th>
                                            <th class="text-center"><dt>Kategori</dt></th>
                                            <th class="text-center"><dt>Min</dt></th>
                                            <th class="text-center"><dt>Option</dt></th>
                                        </tr>
                                    </thead>
                                    <tbody id="TabelCetakBarcodeParsial">
                                        <tr>
                                            <td class="text-center" colspan="6">
                                                <span class="text-danger">Tidak Ada Data yang Dipilih</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="format_barcode">Format</label>
                            <select name="format_barcode" id="format_barcode" class="form-control">
                                <option value="HTML">HTML</option>
                                <option value="PDF">PDF</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="tampilkan_harga">Tampilkan Harga?</label>
                            <select name="tampilkan_harga" id="tampilkan_harga" class="form-control">
                                <option value="Ya">Ya, Tampilkan</option>
                                <option value="Tidak">Tidak</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-primary">
                    <button type="submit" class="btn btn-md btn-outline-dark">
                        <i class="icofont-printer"></i> Cetak Data
                    </button>
                    <button type="button" class="btn btn-md btn-light" data-dismiss="modal">
                        <i class="ti ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Edit Obat Berhasil ---->
<div class="modal fade" id="ModalEditObatBerhasil" tabindex="-1" role="dialog" aria-labelledby="ModalEditObatBerhasil" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h3 class="text-success">Berhasil!!</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-center mb-2">
                        Update Data Obat Berhasil
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-center mb-2">
                        <button type="button" class="btn btn-md btn-secondary btn-round mt-2 ml-2" data-dismiss="modal">
                            <i class="ti-close"></i> Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--- Modal Tambah Multi Harga Berhasil ---->
<div class="modal fade" id="ModalTambahMultiHargaBerhasil" tabindex="-1" role="dialog" aria-labelledby="ModalTambahMultiHargaBerhasil" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h3 class="text-success">Berhasil!!</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-center mb-2">
                        Update Data Obat Berhasil
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-center mb-2">
                        <button type="button" class="btn btn-md btn-secondary btn-round mt-2 ml-2" data-dismiss="modal">
                            <i class="ti-close"></i> Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>