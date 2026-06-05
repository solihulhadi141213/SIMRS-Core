<!-- Filter Data -->
<div class="modal fade" id="ModalFilter" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesFilter" autocomplete="off">
                <input type="hidden" name="page_filter" id="page_filter" value="1">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-funnel"></i> Filter Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="batas">
                                <small>Limit</small>
                            </label>
                        </div>
                        <div class="col-8">
                            <select name="batas" id="batas" class="form-control">
                                <option value="5">5</option>
                                <option selected value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                                <option value="250">250</option>
                                <option value="500">500</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="OrderBy">
                                <small>Dasar Urutan</small>
                            </label>
                        </div>
                        <div class="col-8">
                            <select name="OrderBy" id="OrderBy" class="form-control">
                                <option value="">Pilih</option>
                                <option value="category_name">Kategori</option>
                                <option value="observation_name">Nama Pemeriksaan</option>
                                <option value="unit_name">Satuan (Unit)</option>
                                <option value="result_type">Result Tipe</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="ShortBy">
                                <small>Tipe Urutan</small>
                            </label>
                        </div>
                        <div class="col-8">
                            <select name="ShortBy" id="ShortBy" class="form-control">
                                <option value="ASC">A To Z</option>
                                <option selected value="DESC">Z To A</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="keyword_by">
                                <small>Dasar Pencarian</small>
                            </label>
                        </div>
                        <div class="col-8">
                            <select name="keyword_by" id="keyword_by" class="form-control">
                                <option value="">Pilih</option>
                                <option value="category_name">Kategori</option>
                                <option value="observation_name">Nama Pemeriksaan</option>
                                <option value="unit_name">Satuan (Unit)</option>
                                <option value="result_type">Result Tipe</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="keyword_form">
                                <small>Kata Kunci</small>
                            </label>
                        </div>
                        <div class="col-8" id="FormFilter">
                            <input type="text" name="keyword" id="keyword_form" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-rounded">
                        <i class="bi bi-check"></i> Tampilkan
                    </button>
                    <button type="button" class="btn btn-secondary btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal Tambah -->
<div class="modal fade" id="ModalTambah" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambah" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-plus"></i> Tambah Referensi Observasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form_category mb-3">
                        <div class="row mb-2">
                            <div class="col-12">
                                <small><b>A. Kategori Observasi</b></small>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><label for="category_name"><small>Kategori Observasi</small></label></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-7">
                                <select name="category_name" id="category_name" class="form-control" required>
                                    <option value="">Pilih</option>
                                    <option value="Riwayat Sosial">Riwayat Sosial (Social History)</option>
                                    <option value="Tanda Vital">Tanda Vital (Vital Signs)</option>
                                    <option value="Pencitraan Medis">Pencitraan Medis (Imaging)</option>
                                    <option value="Laboratorium">Laboratorium (Laboratory)</option>
                                    <option value="Tindakan Medis">Tindakan Medis (Procedure)</option>
                                    <option value="Asesmen">Asesmen (Survey)</option>
                                    <option value="Pemeriksaan Fisik">Pemeriksaan Fisik (Exam)</option>
                                    <option value="Response Terapi">Response Terapi (Therapy)</option>
                                    <option value="Aktivitas">Aktivitas (Activity)</option>
                                    <option value="Gejala">Gejala (Symptom)</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><label for="category_code"><small><i>Code</i></small></label></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-7">
                                <input type="text" name="category_code" id="category_code" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><label for="category_display"><small><i>Display</i></small></label></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-7">
                                <input type="text" name="category_display" id="category_display" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><label for="category_system"><small><i>System</i></small></label></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-7">
                                <input type="text" name="category_system" id="category_system" class="form-control" value="http://terminology.hl7.org/CodeSystem/observation-category">
                            </div>
                        </div>
                    </div>
                    
                    <div class="form_observation mb-3">
                        <div class="row mb-2">
                            <div class="col-12">
                                <small><b>B. Nama/Jenis Observasi</b></small>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><label for="observation_name"><small>Nama Observasi</small></label></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-7">
                                <input type="text" name="observation_name" id="observation_name" class="form-control" required>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><label for="observation_code"><small><i>Code</i></small></label></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-7">
                                <input type="text" name="observation_code" id="observation_code" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><label for="observation_display"><small><i>Display</i></small></label></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-7">
                                <input type="text" name="observation_display" id="observation_display" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><label for="observation_system"><small><i>System</i></small></label></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-7">
                                <input type="text" name="observation_system" id="observation_system" class="form-control" value="http://loinc.org">
                            </div>
                        </div>
                    </div>

                    <div class="form_result_type mb-3">
                        <div class="row mb-2">
                            <div class="col-12">
                                <small><b>D. Tipe Hasil (<i>Result Type</i>)</b></small>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><label for="result_type"><small><i>Result Type</i></small></label></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-7">
                                <select name="result_type" id="result_type" class="form-control" required>
                                    <option value="">Pilih</option>
                                    <option value="Numeric">Numeric</option>
                                    <option value="Decimal">Decimal</option>
                                    <option value="Coded">Coded</option>
                                    <option value="Text">Text</option>
                                    <option value="Boolean">Boolean</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form_result_coded mb-3">
                        <div class="row mb-2">
                            <div class="col-12">
                                <small><b>C. Alternatif Jawaban (<i>Coded</i>)</b></small>
                            </div>
                        </div>
                        <div class="row mb-2 mt-3">
                            <div class="col-12">
                                <button type="button" class="btn btn-sm btn-info w-100" id="TambahCoded">
                                    <i class="bi bi-plus"></i> Tambah
                                </button>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-12">
                                <div id="WrapperResultCoded">
                                    <!-- Form Coded akan muncul disini -->
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form_satuan_unit mb-3">
                        <div class="row mb-2">
                            <div class="col-12">
                                <small><b>C. Satuan (<i>Unit</i>)</b></small>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><label for="unit_name"><small>Satuan (Unit)</small></label></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-7">
                                <select name="unit_name" id="unit_name" class="form-control">
                                    <option value="">Pilih</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><label for="unit_code"><small><i>Code</i></small></label></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-7">
                                <input type="text" name="unit_code" id="unit_code" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><label for="unit_display"><small><i>Display</i></small></label></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-7">
                                <input type="text" name="unit_display" id="unit_display" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><label for="unit_system"><small><i>System</i></small></label></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-7">
                                <input type="text" name="unit_system" id="unit_system" class="form-control" value="http://unitsofmeasure.org">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" id="NotifikasiTambah">
                            <!-- Notifikasi Tambah -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-rounded" id="ButtonTambah">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-secondary btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--- Modal Detail --->
<div class="modal fade" id="ModalDetail" tabindex="-1" aria-labelledby="ModalDetail" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title_detail">
                    <i class="bi bi-info-circle"></i> Detail Tindakan
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
                <div class="row">
                    <div class="col-12" id="FormDetail">
                        <!-- Form Detail Akan Muncul Disini -->
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-inverse ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="ModalEdit" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEdit" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-pencil"></i> Edit Referensi Observasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12" id="FormEdit">
                            <!-- Form Edit -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" id="NotifikasiEdit">
                            <!-- Notifikasi Edit -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-rounded" id="ButtonEdit">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-secondary btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--- Modal Hapus --->
<div class="modal fade" id="ModalHapus" tabindex="-1" aria-labelledby="ModalHapus" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesHapus" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-trash"></i> Hapus Referensi Observation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                   
                    <div class="row">
                        <div class="col-12" id="FormHapus">
                           <!-- Form Hapus Akan Muncul Disini -->
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12" id="NotifikasiHapus">
                           <!-- Notifikasi Hapus  Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary" id="ButtonHapus">
                        <i class="bi bi-check"></i> Hapus Referensi
                    </button>
                    <button type="button" class="btn btn-md btn-inverse ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>