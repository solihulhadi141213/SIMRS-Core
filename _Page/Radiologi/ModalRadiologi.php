<!--- Modal Filter ---->
<div class="modal fade" id="ModalFilter" tabindex="-1" role="dialog" aria-labelledby="ModalFilter" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesCariDataKunjunganPasien">
                <input type="hidden" name="page" id="page_rad" value="1">
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
                                <option value="id_radiologi">ID Radiologi</option>
                                <option value="accession_number">Accession Number</option>
                                <option value="id_pasien">No. RM</option>
                                <option value="nama_pasien">Nama Pasien</option>
                                <option value="priority">Perioritas</option>
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
                                <option value="id_radiologi">ID Radiologi</option>
                                <option value="accession_number">Accession Number</option>
                                <option value="id_pasien">No. RM</option>
                                <option value="nama_pasien">Nama Pasien</option>
                                <option value="priority">Perioritas</option>
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
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b><i class="ti ti-info-alt"></i> Detail Radiologi</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 mb-3" id="FormDetail">
                        <!-- Detail Permintaan Radiologi Akan Muncul Disini -->
                         <div class="alert alert-info text-center">Mengambil Data ..</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-dark" data-dismiss="modal">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>

        </div>
    </div>
</div>

<!--- Modal Hapus ---->
<div class="modal fade" id="ModalHapus" tabindex="-1" role="dialog" aria-labelledby="ModalHapus" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapus">
                <div class="modal-header">
                    <b><i class="ti ti-trash"></i> Hapus / Batalkan Pemeriksaan</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-2" id="FormHapus">
                            <!-- Detail Permintaan Radiologi Akan Muncul Disini -->
                            <div class="alert alert-info text-center">Mengambil Data ..</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-2" id="NotifikasiHapus">
                            <!-- Notifikasi Hapus Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary" id="ButtonHapus">
                        <i class="ti ti-check"></i> Ya, Hapus
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
<div class="modal fade" id="ModalPilihDataKunjungan" tabindex="-1" role="dialog" aria-labelledby="ModalPilihDataKunjungan" aria-hidden="true">
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
                        <form action="javascript:void(0);" id="ProsesCariDataKunjunganPasien">
                            <div class="input-group">
                                <input type="hidden" name="page_kunjungan" id="page_kunjungan" value="1">
                                <input type="text" name="keyword_kunjungan" id="keyword_kunjungan" class="form-control" placeholder="Cari Nama/Rm pasien">
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
                                
                                    <tbody id="ListDataKunjunganUntukDipilih">
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
                    <button type="button" class="btn btn-sm btn-outline-dark" id="btn_prev">
                        <i class="ti ti-angle-left"></i>
                    </button>

                    <button type="button" disabled class="btn btn-sm btn-outline-dark" id="page_info">
                        0/0
                    </button>

                    <button type="button" class="btn btn-sm btn-outline-dark" id="btn_next">
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

<!--- Modal Permintaan Pemeriksaan ---->
<div class="modal fade" id="ModalPilihPermintaanPemeriksaan" tabindex="-1" role="dialog" aria-labelledby="ModalPilihPermintaanPemeriksaan" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b><i class="ti ti-search"></i> Cari Referensi Pemeriksaan</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <form action="javascript:void(0);" id="ProsesCariPermintaanPemeriksaan">
                            <div class="input-group">
                                <input type="hidden" name="page_pemeriksaan" id="page_pemeriksaan" value="1">
                                <input type="hidden" name="modality" id="modality" value="1">
                                <input type="text" name="keyword_pemeriksaan" id="keyword_pemeriksaan" class="form-control" placeholder="Cari Referensi Pemeriksaan">
                                <button type="submit" class="btn btn-outline-secondary">
                                    <i class="ti-search"></i> Cari
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div id="WrapperTabelPemeriksaan" style="position:relative;">
                            <div class="table table-responsive">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <td><dt>No</dt></td>
                                            <td><dt>Pemeriksaan</dt></td>
                                            <td><dt><i>Body Site</i></dt></td>
                                            <td><dt><i>Mod</i></dt></td>
                                        </tr>
                                    </thead>
                                
                                    <tbody id="ListDataPemeriksaan">
                                        <!-- List Data Pemeriksaan Akan Muncul Disini -->
                                        <tr>
                                            <td colspan="4" class="text-center">Loading...</td>
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
                    <button type="button" class="btn btn-sm btn-outline-dark" id="btn_prev_pemeriksaan">
                        <i class="ti ti-angle-left"></i>
                    </button>

                    <button type="button" disabled class="btn btn-sm btn-outline-dark" id="page_info_pemeriksaan">
                        0/0
                    </button>

                    <button type="button" class="btn btn-sm btn-outline-dark" id="btn_next_pemeriksaan">
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

<!--- Modal Klinis ---->
<div class="modal fade" id="ModalKlinis" tabindex="-1" role="dialog" aria-labelledby="ModalKlinis" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b><i class="ti ti-search"></i> Cari Klinis Pasien</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <form action="javascript:void(0);" id="ProsesCariKlinis">
                            <div class="input-group">
                                <input type="hidden" name="page_klinis" id="page_klinis" value="1">
                                <input type="text" name="keyword_klinis" id="keyword_klinis" class="form-control" placeholder="Cari Referensi Klinis">
                                <button type="submit" class="btn btn-outline-secondary">
                                    <i class="ti-search"></i> Cari
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div id="WrapperTabelKlinis" style="position:relative;">
                            <div class="table table-responsive">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <td><dt>No</dt></td>
                                            <td><dt>Klinis</dt></td>
                                            <td><dt><i>Code</i></dt></td>
                                            <td><dt><i>Display</i></dt></td>
                                            <td><dt><i>Category</i></dt></td>
                                        </tr>
                                    </thead>
                                
                                    <tbody id="ListKlinis">
                                        <!-- List Data Klinis Akan Muncul Disini -->
                                        <tr>
                                            <td colspan="5" class="text-center">Loading...</td>
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
                    <button type="button" class="btn btn-sm btn-outline-dark" id="btn_prev_klinis">
                        <i class="ti ti-angle-left"></i>
                    </button>

                    <button type="button" disabled class="btn btn-sm btn-outline-dark" id="page_info_klinis">
                        0/0
                    </button>

                    <button type="button" class="btn btn-sm btn-outline-dark" id="btn_next_klinis">
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
