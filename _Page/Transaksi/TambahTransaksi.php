    <div class="row">
        <div class="col-md-12">
            <form action="javascript:void(0);" id="FormInformasiTransaksi">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-9 mb-2">
                                <h4 class="card-title">
                                    <i class="ti ti-plus"></i> Tambah Transaksi
                                </h4>
                            </div>
                            <div class="col-md-3">
                                <a href="index.php?Page=Transaksi" class="btn btn-sm btn-dark btn-round btn-block">
                                    <i class="ti ti-arrow-circle-left"></i> Kembali
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3 sub-title">
                            <div class="col-md-12"><dt><i class="ti ti-info-alt"></i> Informasi Transaksi</dt></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3"><label for="PutJenisTransaksi">Jenis Transaksi</label></div>
                            <div class="col-md-9">
                                <select name="transaksi" id="PutJenisTransaksi" class="form-control">
                                    <option value="">Pilih</option>
                                    <option value="Pemasukan">Pemasukan</option>
                                    <option value="Pengeluaran">Pengeluaran</option>
                                    <option value="Pembelian">Pembelian</option>
                                </select>
                                <small>Pilih Jenis Transaksi Sesuai Tujuan Transaksi Yang Berlangsung</small>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3"><label for="PutKode">Kode Transaksi</label></div>
                            <div class="col-md-9">
                                <input type="text" name="kode" id="PutKode" class="form-control">
                                <small>Kode transaksi akan digenerate otomatis setalah anda memilih jenis transaksi</small>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3 mb-2"><label for="tanggal">Tanggal & Jam</label></div>
                            <div class="col-md-5 mb-2">
                                <input type="date" name="tanggal" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                                <small>Tanggal (YYYY/mm/dd)</small>
                            </div>
                            <div class="col-md-4 mb-2">
                                <input type="time" name="jam" class="form-control" value="<?php echo date('H:i'); ?>">
                                <small>Jam (HH:ii)</small>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3"><label for="LabelTransaksi">Label/Group/Kategori</label></div>
                            <div class="col-md-9">
                                <input type="text" name="label" id="LabelTransaksi" class="form-control" list="DataListLabel">
                                <datalist id="DataListLabel"></datalist>
                                <small>** Hanya apabila transaksi terhubung dalam satu group/label tertentu</small>
                            </div>
                        </div>
                        <div class="row mb-3 sub-title">
                            <div class="col-md-12">
                                <dt><i class="ti ti-user"></i> Subjek Transaksi</dt>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3"><label for="PutIdPasien">No.RM/Pasien</label></div>
                            <div class="col-md-9">
                                <select name="id_pasien" id="PutIdPasien" class="form-control" data-toggle="modal" data-target="#ModalListPasien">
                                    <option value="">Pilih</option>
                                </select>
                                <a href="javascript:voif(0);" data-toggle="modal" data-target="#ModalInfoPasien" class="text-info">
                                    <small><i class="ti ti-info-alt"></i> Lihat Detail Pasien</small>
                                </a>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3"><label for="PutIdKunjungan">No.REG/Kunjungan</label></div>
                            <div class="col-md-9">
                                <select name="id_kunjungan" id="PutIdKunjungan" class="form-control" data-toggle="modal" data-target="#ModalListKunjungan">
                                    <option value="">Pilih</option>
                                </select>
                                <a href="javascript:voif(0);" data-toggle="modal" data-target="#ModalInfoKunjungan"  class="text-info">
                                    <small><i class="ti ti-info-alt"></i> Lihat Kunjungan</small>
                                </a>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3"><label for="PutIdDokter">Dokter</label></div>
                            <div class="col-md-9">
                                <select name="id_dokter" id="PutIdDokter" class="form-control" data-toggle="modal" data-target="#ModalListDokter">
                                    <option value="">Pilih</option>
                                </select>
                                <small>
                                    ** Ketika transaksi berhubungan dengan layanan atau kegiatan dokter, DPJP atau lainnya.
                                </small>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3"><label for="PutIdSupplier">Supplier</label></div>
                            <div class="col-md-9">
                                <select name="id_supplier" id="PutIdSupplier" class="form-control" data-toggle="modal" data-target="#ModalListSupplier">
                                    <option value="">Pilih</option>
                                </select>
                                <small>
                                    ** Ketika transaksi berhubungan dengan supplier atau ritel saat pembelian barang.
                                </small>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3"><label for="karyawan">Karyawan</label></div>
                            <div class="col-md-9">
                                <input type="text" name="karywan" id="karyawan" class="form-control" list="DataListKaryawan">
                                <datalist id="DataListKaryawan"></datalist>
                                <small>** Hanya apabila transaksi berkaitan dengan karyawan tertentu</small>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="card-title">
                                <i class="icofont-table"></i> Cari Data Obat, Alkes Atau Tindakan
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="javascript:void(0);" id="FormCariDataObat">
                        <div class="row mb-3 sub-title">
                            <div class="col-md-4">
                                <select name="ObatAtauTindakan" id="ObatAtauTindakan" class="form-control">
                                    <option value="">Pilih</option>
                                    <option value="Obat">Obat/Alkes</option>
                                    <option value="Tindakan">Tindakan</option>
                                </select>
                                <small>
                                    <label for="ObatAtauTindakan">Obat Atau Tindakan?</label>
                                </small>
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="KeywordObatAtauTindakan" id="KeywordObatAtauTindakan" class="form-control">
                                <small>
                                    <label for="KeywordObatAtauTindakan">Keyword Pencarian</label>
                                </small>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-sm btn-block btn-secondary" id="TampilkanDataObatTindakan">
                                    <i class="ti ti-search"></i> Tampilkan
                                </button>
                            </div>
                        </div>
                    </form>
                    <div id="TabelObatAtauTindakan"></div>
                </div>
            </div>
            <form action="javascript:void(0);" id="FormRincianTransaksi">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="card-title">
                                    <i class="icofont-list"></i> Rincian Transaksi
                                </h4>
                            </div>
                            <div class="col-md-3">
                                <button type="button" class="btn btn-sm btn-dark btn-round btn-block" id="ReloadRincianTransaksi" title="Riload Rincian">
                                    <i class="ti ti-reload"></i> Reload
                                </button>
                            </div>
                            <div class="col-md-3">
                                <button type="button" class="btn btn-sm btn-info btn-round btn-block" data-toggle="modal" data-target="#ModalTambahRincianManual" title="Tambah Rincian Manual">
                                    <i class="ti ti-plus"></i> Tambah Rincian
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row sub-title mb-3">
                            <div class="col-md-12">
                                <dt>
                                    <i class="ti ti-list"></i> Uraian
                                </dt>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12" id="TabelRincianTransaksi"></div>
                        </div>
                    </div>
                </div>
            </form>
            <form action="javascript:void(0);" id="FormSimpanTransaksi">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            <i class="ti ti-save"></i> Simpan Transaksi
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-4"><label for="status">STATUS TRANSAKSI</label></div>
                            <div class="col-md-8">
                                <select name="status" id="status" class="form-control">
                                    <option value="">Pilih</option>
                                    <option value="Lunas">Lunas</option>
                                    <option value="Kredit">Kredit</option>
                                    <option value="Tidak Valid">Tidak Valid</option>
                                    <option value="Menunggu">Menunggu</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4"><label for="status">KUNCI TRANSAKSI</label></div>
                            <div class="col-md-8">
                                <select name="kunci" id="kunci" class="form-control">
                                    <option value="">Pilih</option>
                                    <option value="No">No</option>
                                    <option value="Ya">Ya</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4"><label for="catatan">KETERANGAN/CATATAN</label></div>
                            <div class="col-md-8">
                                <input type="text" name="catatan" id="catatan" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4"></div>
                            <div class="col-md-8">
                                <ul>
                                    <li>
                                        <input type="radio" checked name="setelah_simpan" id="setelah_simpan1" value="Ke Detail Transaksi"> 
                                        <label for="setelah_simpan1">Simpan dan masuk ke detail transaksi</label>
                                    </li>
                                    <li>
                                        <input type="radio" name="setelah_simpan" id="setelah_simpan2" value="Ke List Transaksi"> 
                                        <label for="setelah_simpan2">Simpan dan kembali ke list/daftar transaksi</label>
                                    </li>
                                </ul>
                                
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4"></div>
                            <div class="col-md-8">
                                Pastikan informasi transaksi yang anda input sudah sesuai
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-md btn-primary btn-block btn-round">
                            <i class="ti ti-save"></i> Simpan Transaksi
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</form>