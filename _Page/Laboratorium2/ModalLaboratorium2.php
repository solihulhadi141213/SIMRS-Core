<!--- Modal Filter ---->
<div class="modal fade" id="ModalFilter" tabindex="-1" role="dialog" aria-labelledby="ModalFilter" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesFilter">
                <input type="hidden" name="page" id="page_lab" value="1">
                <input type="hidden" name="total_page" id="total_page" value="">
                <div class="modal-header">
                    <b><i class="ti ti-filter"></i> Filter</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-12 mb-3">
                            <label for="batas">Batas/Limit</label>
                            <select name="batas" id="batas" class="form-control">
                                <option value="10">10</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                                <option value="200">200</option>
                            </select>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="short_by">Short By</label>
                            <select name="short_by" id="short_by" class="form-control">
                                <option value="">Pilih</option>
                                <option value="id_laboratorium">ID Laboratorium</option>
                                <option value="id_pasien">No. RM</option>
                                <option value="nama_pasien">Nama Pasien</option>
                                <option value="unit">Asal Kiriman</option>
                                <option value="pembayaran">Pembayaran</option>
                                <option value="priority">Perioritas</option>
                                <option value="status">Status</option>
                                <option value="datetime_diminta">Tanggal</option>
                            </select>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="order_by">Order By</label>
                            <select name="order_by" id="order_by" class="form-control">
                                <option value="ASC">ASC</option>
                                <option selected value="DESC">DESC</option>
                            </select>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="keyword_by">Keyword By</label>
                            <select name="keyword_by" id="keyword_by" class="form-control">
                                <option value="">Pilih</option>
                                <option value="id_laboratorium">ID Laboratorium</option>
                                <option value="id_pasien">No. RM</option>
                                <option value="nama_pasien">Nama Pasien</option>
                                <option value="unit">Asal Kiriman</option>
                                <option value="pembayaran">Pembayaran</option>
                                <option value="priority">Perioritas</option>
                                <option value="status">Status</option>
                                <option value="datetime_diminta">Tanggal</option>
                            </select>
                        </div>
                        <div class="col-12 mb-3" id="FormKeyword">
                            <label for="keyword">Kata Kunci</label>
                            <input type="text" name="keyword" id="keyword" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="ti ti-check"></i> Tampilkan
                    </button>
                    <button type="button" class="btn btn-sm btn-dark" data-dismiss="modal">
                        <i class="ti ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--- Modal Detail ---->
<div class="modal fade" id="ModalDetail" tabindex="-1" role="dialog" aria-labelledby="ModalDetail" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
           <form action="javascript:void(0);" id="ProsesTampilkanDetailLaboratoium">
                <div class="modal-header bg-info">
                    <dt><i class="ti ti-info-alt"></i> Detail Pemeriksaan Laboratorium</dt> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-3 pre-scrollable" id="FormDetail">
                            <!-- Detail Permintaan Laboratorium Akan Muncul Disini -->
                            <div class="alert alert-info text-center">Mengambil Data ..</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-info">
                    <button type="submit" class="btn btn-sm btn-primary">
                        Lihat Selengkapnya <i class="ti ti-angle-right"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-dark" data-dismiss="modal">
                        <i class="ti ti-close"></i> Tutup
                    </button>
                </div>
           </form>
        </div>
    </div>
</div>

<!--- Modal Pilih Pasien ---->
<div class="modal fade" id="ModalKunjunganPasien" tabindex="-1" role="dialog" aria-labelledby="ModalKunjunganPasien" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b><i class="ti ti-search"></i> Cari Kunjungan Pasien</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <form action="javascript:void(0);" id="FilterKunjunganPasien">
                            <div class="input-group">
                                <input type="hidden" name="page" id="page_kunjungan" value="1">
                                <input type="text" name="keyword" id="keyword_kunjungan" class="form-control" placeholder="Cari Nama/Rm pasien">
                                <button type="submit" class="btn btn-outline-secondary">
                                    <i class="ti-search"></i> Cari
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div id="WrapperTabelKunjungan" style="position:relative;">
                            <div class="table table-responsive">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <td><dt>No</dt></td>
                                            <td><dt>RM</dt></td>
                                            <td><dt>Nama</dt></td>
                                            <td><dt>Tanggal</dt></td>
                                            <td><dt>Kunjungan</dt></td>
                                        </tr>
                                    </thead>
                                
                                    <tbody id="ListKunjungan">
                                        <!-- List Data Kunjungan Akan Muncul Disini -->
                                        <tr>
                                            <td colspan="5" class="text-center">No Data</td>
                                        </tr>
                                    </tbody>
                                    
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-between align-items-center">

                <!-- Pagination -->
                <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-outline-dark" id="btn_prev_kunjungan">
                        <i class="ti ti-angle-left"></i>
                    </button>

                    <button type="button" disabled class="btn btn-sm btn-outline-dark" id="page_info_kunjungan">
                        0/0
                    </button>

                    <button type="button" class="btn btn-sm btn-outline-dark" id="btn_next_kunjungan">
                        <i class="ti ti-angle-right"></i>
                    </button>
                </div>

                <!-- Close -->
                <button type="button" class="btn btn-sm btn-dark" data-dismiss="modal">
                    <i class="ti ti-close"></i> Tutup
                </button>

            </div>

        </div>
    </div>
</div>

<!--- Modal cari Diagnosa ---->
<div class="modal fade" id="ModalDiagnosa" tabindex="-1" role="dialog" aria-labelledby="ModalDiagnosa" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b><i class="ti ti-search"></i> Cari Diagnosa</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <form action="javascript:void(0);" id="FilterDiagnosa">
                            <div class="input-group">
                                <input type="hidden" name="page" id="page_diagnosa" value="1">
                                <input type="text" name="keyword" id="keyword_diagnosa" class="form-control" placeholder="Cari Nama/Rm pasien">
                                <button type="submit" class="btn btn-outline-secondary">
                                    <i class="ti-search"></i> Cari
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div id="WrapperTabelKunjungan" style="position:relative;">
                            <div class="table table-responsive">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <td><dt>No</dt></td>
                                            <td><dt>Kode</dt></td>
                                            <td><dt>Diagnosa</dt></td>
                                            <td><dt>ICD</dt></td>
                                            <td><dt>Resource</dt></td>
                                        </tr>
                                    </thead>
                                
                                    <tbody id="TabelDiagnosa">
                                        <!-- List Data Kunjungan Akan Muncul Disini -->
                                        <tr>
                                            <td colspan="5" class="text-center">No Data</td>
                                        </tr>
                                    </tbody>
                                    
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-between align-items-center">

                <!-- Pagination -->
                <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-outline-dark" id="btn_prev_diagnosa">
                        <i class="ti ti-angle-left"></i>
                    </button>

                    <button type="button" disabled class="btn btn-sm btn-outline-dark" id="page_info_diagnosa">
                        0/0
                    </button>

                    <button type="button" class="btn btn-sm btn-outline-dark" id="btn_next_diagnosa">
                        <i class="ti ti-angle-right"></i>
                    </button>
                </div>

                <!-- Close -->
                <button type="button" class="btn btn-sm btn-dark" data-dismiss="modal">
                    <i class="ti ti-close"></i> Tutup
                </button>

            </div>

        </div>
    </div>
</div>

<!--- Modal Tambah Rincian ---->
<div class="modal fade" id="ModalTambahRincian" tabindex="-1" role="dialog" aria-labelledby="ModalTambahRincian" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahRincian">
                <div class="modal-header bg-dark">
                    <dt class="text-white"><i class="ti ti-plus"></i> Tambah Rincian</dt> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12  pre-scrollable" id="FormTambahRincian">
                            <!-- Form Tambah Rincian Akan Muncul Disini -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" id="NotifikasiTambahRincian">
                            <!-- Notifikasi Tambah Rincian Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-dark">
                    <button type="button" class="btn btn-sm btn-info kembali_ke_detail">
                        <i class="ti ti-angle-left"></i>
                    </button>
                    <button type="submit" class="btn btn-sm btn-primary" id="tombol_tambah_rincian">
                        <i class="ti ti-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Hapus Rincian ---->
<div class="modal fade" id="ModalHapusRincian" tabindex="-1" role="dialog" aria-labelledby="ModalHapusRincian" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusRincian">
                <div class="modal-header">
                    <dt><i class="ti ti-trash"></i> Hapus Rincian</dt> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="FormHapusRincian">
                            <!-- Form Hapus Rincian Akan Muncul Disini -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" id="NotifikasiHapusRincian">
                            <!-- Notifikasi Hapus Rincian Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary" id="tombol_hapus_rincian">
                        <i class="ti ti-check"></i> Ya Hapus
                    </button>
                    <button type="button" class="btn btn-sm btn-dark kembali_ke_detail">
                        <i class="ti ti-close"></i> Tidak
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Edit Pemeriksaan ---->
<div class="modal fade" id="ModalEditPemeriksaan" tabindex="-1" role="dialog" aria-labelledby="ModalEditPemeriksaan" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditPemeriksaan">
                <div class="modal-header bg-dark">
                    <dt class="text-white"><i class="ti ti-plus"></i> Ubah Permintaan Pemeriksaan</dt> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="FormEditPemeriksaan">
                            <!-- Form Edit Pemeriksaan Akan Muncul Disini -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" id="NotifikasiEditPemeriksaan">
                            <!-- Notifikasi Edit Pemeriksaan Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-dark">
                    <button type="submit" class="btn btn-sm btn-primary" id="tombol_edit_pemeriksaan">
                        <i class="ti ti-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">
                        <i class="ti ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Hapus Pemeriksaan ---->
<div class="modal fade" id="ModalHapusPemeriksaan" tabindex="-1" role="dialog" aria-labelledby="ModalHapusPemeriksaan" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusPemeriksaan">
                <div class="modal-header">
                    <dt><i class="ti ti-trash"></i> Hapus Pemeriksaan</dt> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="FormHapusPemeriksaan">
                            <!-- Form Hapus Pemeriksaan Akan Muncul Disini -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" id="NotifikasiHapusPemeriksaan">
                            <!-- Notifikasi Hapus Pemeriksaan Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary" id="tombol_hapus_pemeriksaan">
                        <i class="ti ti-check"></i> Ya Hapus
                    </button>
                    <button type="button" class="btn btn-sm btn-dark" data-dismiss="modal">
                        <i class="ti ti-close"></i> Tidak
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Cetak Pemeriksaan ---->
<div class="modal fade" id="ModalCetakPemeriksaan" tabindex="-1" role="dialog" aria-labelledby="ModalCetakPemeriksaan" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="_Page/Laboratorium2/CetakPermintaanPemeriksaan.php" method="GET" target="_blank">
                <div class="modal-header">
                    <dt><i class="ti ti-printer"></i> Cetak Permintaan Pemeriksaan</dt> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="FormCetakPemeriksaan">
                            <!-- Form Hapus Pemeriksaan Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="ti ti-check"></i> Cetak
                    </button>
                    <button type="button" class="btn btn-sm btn-dark" data-dismiss="modal">
                        <i class="ti ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>