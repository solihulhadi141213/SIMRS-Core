
<!--- Modal Filter Nakes Terinfeksi---->
<div class="modal fade" id="ModalFilterNakes" tabindex="-1" role="dialog" aria-labelledby="ModalFilterNakes" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesFilterNakes">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-filter"></i> Filter Nakes</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="batas">Data</label>
                            <select name="batas" id="batas" class="form-control">
                                <option value="5">5</option>
                                <option selected value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="keyword_by">Dasar Pencarian</label>
                            <select name="keyword_by" id="keyword_by_nakes" class="form-control">
                                <option value="">All</option>
                                <option value="id_nakes">ID Nakes</option>
                                <option value="ihs">IHS</option>
                                <option value="nik">NIK</option>
                                <option value="nama">Nama</option>
                                <option value="kategori">Kategori</option>
                                <option value="referensi_sdm">Referensi SDM</option>
                                <option value="id_akses">Petugas</option>
                            </select>
                        </div>
                        <div class="col-md-12 mb-3" id="FormKeywordNakes">
                            <label for="keyword">Kata Kunci</label>
                            <input type="text" name="keyword" id="keyword" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary mt-2 ml-2">
                        <i class="ti-search"></i> Cari
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary mt-2 ml-2" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Pilih Practitioner ---->
<div class="modal fade" id="ModalPilihPractitioner" tabindex="-1" role="dialog" aria-labelledby="ModalPilihPractitioner" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <dt cass="text-dark"><i class="ti ti-user"></i> Pilih Practitioner</dt> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form action="javascript:void(0);" id="ProsesCariPractitioner">
                            <div class="input-group">
                                <input type="text" class="form-control" name="keyword_practitioner" id="keyword_practitioner" placeholder="Kata Kunci">
                                <button type="submit" class="btn btn-sm btn-info">
                                    <i class="ti ti-search"></i> Cari
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12" id="ListDataPractitioner">
                        <!-- Menampilkan Data Practitioner -->
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary mt-2 ml-2" data-dismiss="modal">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Pilih Dokter ---->
<div class="modal fade" id="ModalPilihDokter" tabindex="-1" role="dialog" aria-labelledby="ModalPilihDokter" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <dt cass="text-dark"><i class="ti ti-user"></i> Pilih Referensi Dokter</dt> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form action="javascript:void(0);" id="ProsesCariReferensiDokter">
                            <div class="input-group">
                                <input type="text" class="form-control" name="keyword_dokter" id="keyword_dokter" placeholder="Kata Kunci">
                                <button type="submit" class="btn btn-sm btn-info">
                                    <i class="ti ti-search"></i> Cari
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12" id="ListDataDokter">
                        <!-- Menampilkan Data Dokter -->
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary mt-2 ml-2" data-dismiss="modal">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Tambah SDM ---->
<div class="modal fade" id="ModalTambahNakes" tabindex="-1" role="dialog" aria-labelledby="ModalTambahNakes" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahNakes">
                <div class="modal-header">
                    <dt cass="text-dark"><i class="ti ti-plus"></i> Tambah Nakes/SDM</dt> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="FormTambahNakes">
                        <!-- Menampilkan Form Tambah Nakes Disini -->
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <dt>Keterangan :</dt>
                        </div>
                        <div class="col-md-8" id="NotifikasiTambahNakes">
                            Pastikan data Nakes yang anda input sudah benar.
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary mt-2 ml-2">
                        <i class="ti-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary mt-2 ml-2" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Detail SDM ---->
<div class="modal fade" id="ModalDetailNakes" tabindex="-1" role="dialog" aria-labelledby="ModalDetailNakes" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <dt cass="text-dark"><i class="ti ti-info-alt"></i> Detail Nakes/SDM</dt> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="FormDetailNakes">
                    <!-- Menampilkan Form Detail Nakes Disini -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary mt-2 ml-2" data-dismiss="modal">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Edit SDM ---->
<div class="modal fade" id="ModalEditnakes" tabindex="-1" role="dialog" aria-labelledby="ModalEditnakes" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEdithNakes">
                <div class="modal-header">
                    <dt cass="text-dark"><i class="ti ti-pencil"></i> Edit Nakes/SDM</dt> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="FormEditNakes">
                        <!-- Menampilkan Form Tambah Nakes Disini -->
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <dt>Keterangan :</dt>
                        </div>
                        <div class="col-md-8" id="NotifikasiEditNakes">
                            Pastikan data Nakes yang anda ubah sudah benar.
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary mt-2 ml-2">
                        <i class="ti-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary mt-2 ml-2" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Hapus SDM---->
<div class="modal fade" id="ModalHapusNakes" tabindex="-1" role="dialog" aria-labelledby="ModalHapusNakes" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusNakes">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-trash"></i> Hapus Nakes</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="FormHapusNakes">
                    <!-- Form Hapus Nakes Disini -->
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary mt-2 ml-2">
                        <i class="ti-check"></i> Ya, Hapus
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary mt-2 ml-2" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Creat SDM---->
<div class="modal fade" id="ModalCreatSdm" tabindex="-1" role="dialog" aria-labelledby="ModalCreatSdm" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesCreatSdm">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-plus"></i> Tambah Data SDM</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="FormCreatSdm">
                        <!-- Form Creat Nakes Disini -->
                    </div>
                    <div class="row">
                        <div class="col-md-4"><dt>Keterangan : </dt></div>
                        <div class="col-md-8" id="NotifikasiCreatSdm">Pastikan data nakes yang anda input sudah sesuai</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary mt-2 ml-2">
                        <i class="ti-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary mt-2 ml-2" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Update SDM---->
<div class="modal fade" id="ModalUpdateSdm" tabindex="-1" role="dialog" aria-labelledby="ModalUpdateSdm" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesUpdateSdm">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-reload"></i> Update Data SDM</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="FormUpdateSdm">
                        <!-- Form Creat Nakes Disini -->
                    </div>
                    <div class="row">
                        <div class="col-md-4"><dt>Keterangan : </dt></div>
                        <div class="col-md-8" id="NotifikasiUpdateSdm">Pastikan data nakes yang anda input sudah sesuai</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary mt-2 ml-2">
                        <i class="ti-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary mt-2 ml-2" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Tambah Hasil PCR Nakes ---->
<div class="modal fade" id="ModalTambahHasilPcrNakes" tabindex="-1" role="dialog" aria-labelledby="ModalTambahHasilPcrNakes" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahHasilPcrNakes">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-plus"></i> Tambah Hasil PCR Nakes</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" >
                    <div id="FormTambahHasilPcrNakes"></div>
                    <div class="row">
                        <div class="col-md-12 mb-3" id="NotifikasiTambahHasilPcrNakes">
                            Pastikan data hasil PCR Nakes yang anda input sudah benar.
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary mt-2 ml-2">
                        <i class="ti-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary mt-2 ml-2" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Detail Hasil PCR Nakes ---->
<div class="modal fade" id="ModalDetailHasilPcrNakes" tabindex="-1" role="dialog" aria-labelledby="ModalDetailHasilPcrNakes" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-info"></i> Detail Hasil PCR Nakes</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="DetailHasilPcrNakes">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary mt-2 ml-2" data-dismiss="modal">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Edit Hasil PCR Nakes ---->
<div class="modal fade" id="ModalEditHasilPcrNakes" tabindex="-1" role="dialog" aria-labelledby="ModalEditHasilPcrNakes" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditHasilPcrNakes">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-pencil"></i> Edit Hasil PCR Nakes</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="FormEditHasilPcrNakes">
                    
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary mt-2 ml-2">
                        <i class="ti-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary mt-2 ml-2" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Hapus Hasil PCR Nakes---->
<div class="modal fade" id="ModalHapusHasilPcrNakes" tabindex="-1" role="dialog" aria-labelledby="ModalHapusHasilPcrNakes" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusHasilPcrNakes">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-trash"></i> Hapus PCR Nakes</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="FormHapusHasilPcrNakes">
                    <!-- Form Hapus Hasil PCR Nakes Disini -->
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary mt-2 ml-2">
                        <i class="ti-check"></i> Ya, Hapus
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary mt-2 ml-2" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Laporan PCR Nakes ---->
<div class="modal fade" id="ModalLaporanPcrNakes" tabindex="-1" role="dialog" aria-labelledby="ModalLaporanPcrNakes" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesLaporanPcrNakes">
                <div class="modal-header bg-inverse">
                    <b cass="text-light"><i class="ti ti-search"></i> Laporan PCR Nakes</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-9 mb-3">
                            <input type="date" name="TanggalLaporanPcrNakes" id="TanggalLaporanPcrNakes" class="form-control">
                            <label for="TanggalLaporanPcrNakes"><small>Tanggal Laporan</small></label>
                        </div>
                        <div class="col-md-3 mb-3">
                            <button type="button" class="btn btn-block btn-sm btn-primary" id="ProsesFilterLaporanPcrNakes">
                                <i class="ti-search"></i> Tampilkan
                            </button>
                        </div>
                    </div>
                    <div id="HasilFilterLaporanPcrNakes">
                        <div class="row">
                            <div class="col-md-12 text-center text-danger">
                                Belum Ada Data Laporan Yang Ditampilkan
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-inverse">
                    <button type="submit" class="btn btn-sm btn-primary mt-2 ml-2">
                        <i class="ti-save"></i> Kirim Laporan
                    </button>
                    <button type="button" class="btn btn-sm btn-light mt-2 ml-2" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Lihat PCR Nakes ---->
<div class="modal fade" id="ModalPcrNakesSirsOnline" tabindex="-1" role="dialog" aria-labelledby="ModalPcrNakesSirsOnline" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-inverse">
                <b cass="text-light"><i class="ti ti-search"></i> PCR Nakes SIRS Online</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0);" id="PencarianPcrNakes">
                    <div class="row">
                        <div class="col-md-9 mb-3">
                            <input type="date" name="tanggal" id="tanggal" class="form-control">
                            <label for="tanggal"><small>Tanggal Laporan</small></label>
                        </div>
                        <div class="col-md-3 mb-3">
                            <button type="submit" class="btn btn-block btn-sm btn-primary">
                                <i class="ti-search"></i> Tampilkan
                            </button>
                        </div>
                    </div>
                </form>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center"><dt>No</dt></th>
                                        <th class="text-center"><dt>Tanggal</dt></th>
                                        <th class="text-center"><dt>Nakes</dt></th>
                                        <th class="text-center"><dt>PCR</dt></th>
                                        <th class="text-center"><dt>Hasil</dt></th>
                                        <th class="text-center"><dt>Updatetime</dt></th>
                                    </tr>
                                </thead>
                                <tbody id="TabelPcrNakesSirsOnline">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-inverse">
                <button type="button" class="btn btn-sm btn-light mt-2 ml-2" data-dismiss="modal">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Tambah PCR Nakes ---->
<div class="modal fade" id="ModalTambahPcrNakes" tabindex="-1" role="dialog" aria-labelledby="ModalTambahPcrNakes" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="PencarianPcrNakes">
                <div class="modal-header bg-inverse">
                    <b cass="text-light"><i class="ti ti-plus"></i> Tambah PCR Nakes</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            Untuk membuat laporan PCR Nakes, anda akan diarahkan ke halaman form.<br>
                            <dt>Apakah anda yakin akan mengakses halaman tersebut?</dt>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-inverse">
                    <a href="index.php?Page=SirsOnline&Sub=FormTambahPcrNakes" class="btn btn-md btn-primary mt-2 ml-2">
                        <i class="ti-check"></i> Ya, Buka Form
                    </a>
                    <button type="button" class="btn btn-md btn-light mt-2 ml-2" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Detail PCR Nakes ---->
<div class="modal fade" id="ModalDetailPcrNakes" tabindex="-1" role="dialog" aria-labelledby="ModalDetailPcrNakes" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-info-alt"></i> Detail PCR Nakes</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="DetailPcrNakes">
                <!-- Data Detail PCR Nakes Disini -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-light mt-2 ml-2" data-dismiss="modal">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Detail PCR Nakes Sirs Online ---->
<div class="modal fade" id="ModalDetailPcrNakesSirsOnline" tabindex="-1" role="dialog" aria-labelledby="ModalDetailPcrNakesSirsOnline" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-info-alt"></i> Detail PCR Nakes SIRS Online</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="DetailPcrNakesSirsOnline">
                <!-- Data Detail PCR Nakes Disini -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary mt-2 ml-2" data-dismiss="modal">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Edit PCR Nakes ---->
<div class="modal fade" id="ModalEditPcrNakes" tabindex="-1" role="dialog" aria-labelledby="ModalDetailPcrNakes" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditPcrNakes">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-pencil"></i> Detail PCR Nakes</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="FormEditPcrNakes">
                    <!-- Form Edit PCR Nakes Disini -->
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary mt-2 ml-2">
                        <i class="ti-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-sm btn-light mt-2 ml-2" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Edit PCR Nakes SIRS Online---->
<div class="modal fade" id="ModalEditPcrNakesSirsOnline" tabindex="-1" role="dialog" aria-labelledby="ModalEditPcrNakesSirsOnline" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditPcrNakesSirsOnline">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-pencil"></i> Edit PCR Nakes SIRS Online</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="FormEditPcrNakesSirsOnline">
                    <!-- Form Edit PCR Nakes Disini -->
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary mt-2 ml-2">
                        <i class="ti-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-sm btn-light mt-2 ml-2" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Hapus PCR Nakes---->
<div class="modal fade" id="ModalHapusPcrNakes" tabindex="-1" role="dialog" aria-labelledby="ModalHapusPcrNakes" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusPcrNakes">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-pencil"></i> Hapus PCR Nakes</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="FormHapusPcrNakes">
                    <!-- Form Hapus PCR Nakes Disini -->
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary mt-2 ml-2">
                        <i class="ti-check"></i> Ya, Hapus
                    </button>
                    <button type="button" class="btn btn-sm btn-light mt-2 ml-2" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Copy PCR Nakes---->
<div class="modal fade" id="ModalCopyPcrNakes" tabindex="-1" role="dialog" aria-labelledby="ModalCopyPcrNakes" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesCopyPcrNakes">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-clipboard"></i> Copy Data PCR Nakes</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="FormCopyPcrNakes">
                    <!-- Form Copy PCR Nakes Disini -->
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary mt-2 ml-2">
                        <i class="ti-check"></i> Ya, Copy
                    </button>
                    <button type="button" class="btn btn-sm btn-light mt-2 ml-2" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Pilih Dokter ---->
<div class="modal fade" id="ModalPilihNakesUntukPcr" tabindex="-1" role="dialog" aria-labelledby="ModalPilihNakesUntukPcr" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <dt cass="text-dark"><i class="ti ti-user"></i> Pilih Nakes</dt> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form action="javascript:void(0);" id="ProsesCariNakesUntukPcr">
                            <div class="input-group">
                                <input type="text" class="form-control" name="keyword_nakes_untuk_pcr" id="keyword_nakes_untuk_pcr" placeholder="Kata Kunci">
                                <button type="submit" class="btn btn-sm btn-info">
                                    <i class="ti ti-search"></i> Cari
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12" id="TabelNakesUntukPcr">
                        <!-- Menampilkan Data Dokter -->
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary mt-2 ml-2" data-dismiss="modal">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>