<!--- Modal Filter ---->
<div class="modal fade" id="ModalFilterAlergi" tabindex="-1" role="dialog" aria-labelledby="ModalFilterAlergi" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="FilterReferensiAlergi">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-filter"></i> Filter Referensi Alergi</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="batas">Batas</label>
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
                            <label for="OrderBy">Dasar Urutan</label>
                            <select name="OrderBy" id="OrderBy" class="form-control">
                                <option value="">Pilih</option>
                                <option selected value="id_referensi_alergi">ID</option>
                                <option value="code">Kode</option>
                                <option value="display">Display</option>
                                <option value="sumber">Sumber</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="ShortBy">Mode Urutan</label>
                            <select name="ShortBy" id="ShortBy" class="form-control">
                                <option value="">Pilih</option>
                                <option value="ASC">ASC</option>
                                <option selected value="DESC">DESC</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="keyword_by">Dasar Pencarian</label>
                            <select name="keyword_by" id="keyword_by" class="form-control">
                                <option value="">Pilih</option>
                                <option value="code">Kode</option>
                                <option value="display">Display</option>
                                <option value="sumber">Sumber</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12" id="FormKataKunci">
                            <label for="keyword">Kata Kunci</label>
                            <input type="text" class="form-control" name="keyword" id="keyword" placeholder="Kata Kunci">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="ti-search"></i> Tampilkan
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Tambah Alergi ---->
<div class="modal fade" id="ModalTambahhAlergi" tabindex="-1" role="dialog" aria-labelledby="ModalTambahhAlergi" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahAlergi">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-info-alt"></i> Tambah Referensi Alergi</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="FormTambahAlergi">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="code">Code</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="code" id="code" class="form-control" placeholder="Ex: AL000043">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="display">Display</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="display" id="display" class="form-control" placeholder="Ex: Debu Rumah">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="sumber">Sumber</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="sumber" id="sumber" class="form-control" placeholder="http://terminology.kemkes.go.id/CodeSystem/clinical-term">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12" id="NotifikasiTambahAlergi">
                            Pastikan data alergi yang anda input sudah benar!
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="ti-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Detail Alergi ---->
<div class="modal fade" id="ModalDetailAlergi" tabindex="-1" role="dialog" aria-labelledby="ModalExportReferensi" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-info-alt"></i> Detail Referensi Alergi</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="FormDetailAlergi">
                <!-- Form Detail Alergi -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Edit Alergi ---->
<div class="modal fade" id="ModalEditAlergi" tabindex="-1" role="dialog" aria-labelledby="ModalEditAlergi" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditAlergi">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-pencil"></i> Edit Alergi</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="FormEditAlergi">
                        <!-- Form Edit Alergi Disini -->
                    </div>
                    <div class="row">
                        <div class="col-md-12" id="NotifikasiEditAlergi">
                            Pastikan data alergi yang anda input sudah benar!
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary mr-2">
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
<!--- Modal Hapus Alergi ---->
<div class="modal fade" id="ModalHapusAlergi" tabindex="-1" role="dialog" aria-labelledby="ModalHapusAlergi" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusAlergi">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-trash"></i> Hapus Alergi</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 text-center" id="FormHapusAlergi">
                            Apakah Anda Yakin Akan Menghapus Data Ini?
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary mr-2">
                        <i class="ti ti-check"></i> Ya, Hapus
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Edit Alergi ---->
<div class="modal fade" id="ModalEditAlergi" tabindex="-1" role="dialog" aria-labelledby="ModalEditAlergi" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditAlergi">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-pencil"></i> Edit Alergi</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="FormEditAlergi">
                        <!-- Form Edit Alergi Disini -->
                    </div>
                    <div class="row">
                        <div class="col-md-12" id="NotifikasiEditAlergi">
                            Pastikan data alergi yang anda input sudah benar!
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary mr-2">
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
<!--- Modal Import Alergi ---->
<div class="modal fade" id="ModalImportAlergi" tabindex="-1" role="dialog" aria-labelledby="ModalImportAlergi" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesImportAlergi" enctype="multipart/form-data">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-import"></i> Import Data Alergi</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <ol>
                                <li>
                                    Download tamplate file excel untuk mengisi data referensi alergi 
                                    <a href="_Page/Alergi/template.xlsx" class="text-info">berikut ini</a>
                                </li>
                                <li>
                                    Simpan file dalam format CSV
                                </li>
                                <li>
                                    <label for="file_import">Pilih File CSV tersebut disini</label>
                                    <input type="file" name="file_import" id="file_import" class="form-control">
                                </li>
                                <li>
                                    Pilih tombol 'Mulai Import'
                                </li>
                                <li id="NotifikasiImportAlergi">
                                    Tunggu sampai proses selesai
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary mr-2">
                        <i class="ti ti-import"></i> Mulai Import
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>