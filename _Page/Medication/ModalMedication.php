<!--- Modal Filter Obat ---->
<div class="modal fade" id="ModalFilter" tabindex="-1" role="dialog" aria-labelledby="ModalFilter" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="FilterMedication" autocomplete="off">
                <div class="modal-header">
                    <b><i class="icofont-filter"></i> Filter Medication</b> 
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
                                <option value="id_medication">ID Medication</option>
                                <option value="id_akses">Petugas</option>
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
                                <option value="id_medication">ID Medication</option>
                                <option value="id_akses">Petugas</option>
                                <option value="updatetime">Update Time</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="keyword">Kata Kunci</label>
                            <div id="FormKeyword">
                                <input type="text" class="form-control" name="keyword" id="keyword" placeholder="Kata Kunci">
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
<!--- Modal Pilih Obat ---->
<div class="modal fade" id="ModalPilihObat" tabindex="-1" role="dialog" aria-labelledby="ModalPilihObat" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b><i class="ti ti-plus"></i>Tambah Medication</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0);" id="ProsesCariObat">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="input-group">
                                <input type="text" name="keyword_obat" id="keyword_obat" class="form-control" placeholder="Kode/Nama Obat">
                                <button type="submit" class="btn btn-sm btn-secondary">
                                    <i class="ti ti-search"></i> Cari
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
                <div id="TabelPilihObat">

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
<!--- Modal Pilih Obat ---->
<div class="modal fade" id="ModalPilihObat2" tabindex="-1" role="dialog" aria-labelledby="ModalPilihObat2" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b><i class="ti ti-check"></i>Pilih Item Obat</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0);" id="ProsesCariObat2">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="input-group">
                                <input type="text" name="keyword_obat2" id="keyword_obat2" class="form-control" placeholder="Kode/Nama Obat">
                                <button type="submit" class="btn btn-sm btn-secondary">
                                    <i class="ti ti-search"></i> Cari
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
                <div id="TabelPilihObat2">

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
<!-- Modal Pencarian KFA -->
<div class="modal fade" id="ModalPencarianKfa" tabindex="-1" role="dialog" aria-labelledby="ModalPencarianKfa" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-check"></i> Pilih Referensi KFA</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mb-4">
                    <div class="col-md-12">
                        <form action="javascript:void(0);" id="ProsesPencarianKfa">
                            <div class="row">
                                <div class="col-md-12">
                                    Cari referensi KFA
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <input type="hidden" name="PutIdObat" id="PutIdObat">
                                        <input type="text" class="form-control" name="keyword_kfa" id="keyword_kfa" placeholder="Kata Kunci">
                                        <button type="submit" class="btn btn-sm btn-secondary" id="CariKfa">
                                            <i class="ti ti-search"></i> Cari
                                        </button>
                                    </div>
                                    <input type="radio" checked name="product_type" id="product_type1" value="farmasi"> 
                                    <label for="product_type1">Farmasi</label>
                                    <input type="radio" name="product_type" id="product_type2" value="alkes"> 
                                    <label for="product_type2">Alkes</label>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12" id="HasilPencarianKfa">

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary btn-round" data-dismiss="modal" aria-label="Close">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Pencarian KFA2 -->
<div class="modal fade" id="ModalPencarianKfa2" tabindex="-1" role="dialog" aria-labelledby="ModalPencarianKfa2" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-check"></i> Pilih Referensi KFA</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mb-4">
                    <div class="col-md-12">
                        <form action="javascript:void(0);" id="ProsesPencarianKfa2">
                            <div class="row">
                                <div class="col-md-12">
                                    Cari referensi KFA
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <input type="hidden" name="PutIdObat2" id="PutIdObat2">
                                        <input type="text" class="form-control" name="keyword_kfa2" id="keyword_kfa2" placeholder="Kata Kunci">
                                        <button type="submit" class="btn btn-sm btn-secondary" id="CariKfa">
                                            <i class="ti ti-search"></i> Cari
                                        </button>
                                    </div>
                                    <input type="radio" checked name="product_type" id="product_type1_2" value="farmasi"> 
                                    <label for="product_type1_2">Farmasi</label>
                                    <input type="radio" name="product_type" id="product_type2_2" value="alkes"> 
                                    <label for="product_type2_2">Alkes</label>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12" id="HasilPencarianKfa2">

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary btn-round" data-dismiss="modal" aria-label="Close">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Pencarian Organization -->
<div class="modal fade" id="ModalCariOrganization" tabindex="-1" role="dialog" aria-labelledby="ModalCariOrganization" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-search"></i> Pencarian Organization</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mb-4">
                    <div class="col-md-12">
                        <form action="javascript:void(0);" id="ProsesPencarianOrganization">
                            <div class="row">
                                <div class="col-md-12">
                                    Cari Organization
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="keyword_organization" id="keyword_organization" placeholder="Kata Kunci">
                                        <button type="submit" class="btn btn-sm btn-primary" id="CariKfa">
                                            <i class="ti ti-search"></i> Cari
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12" id="HasilPencarianOrganization">

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary btn-round" data-dismiss="modal" aria-label="Close">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Pencarian Medication Form -->
<div class="modal fade" id="ModalCariMedicationForm" tabindex="-1" role="dialog" aria-labelledby="ModalCariMedicationForm" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-check"></i> Pilih Medication Form</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12" id="HasilPencarianMedicationForm">

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary btn-round" data-dismiss="modal" aria-label="Close">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Tambah Ingridient -->
<div class="modal fade" id="ModalTambahIngredient" tabindex="-1" role="dialog" aria-labelledby="ModalTambahIngredient" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahIngridient">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-plus"></i> Tambah Ingredient</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-4"><label for="PutitemCodeableConcept">Kandungan</label></div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="PutitemCodeableConcept" name="PutitemCodeableConcept" list="DataListKfa" placeholder="Kode KFA|Nama Kandungan">
                            <datalist id="DataListKfa">
                                <!-- List KFA Disini -->
                            </datalist>
                            <small>Diisi dengan nama kandungan dari referensi KFA</small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4"><label for="PutisActive">Bahan Aktiv</label></div>
                        <div class="col-md-8">
                            <select name="PutisActive" id="PutisActive" class="form-control">
                                <option value="">Pilih</option>
                                <option value="true">Ya</option>
                                <option value="false">Tidak/Bukan</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4"><label for="PutNumerator">Numerator</label></div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="PutNumeratorValue" name="PutNumeratorValue">
                            <label for="PutNumeratorValue"><small>Nilai/Komposisi</small></label>
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="PutNumeratorCode" name="PutNumeratorCode" list="ListUcum" autocomplete="off">
                            <label for="PutNumeratorCode"><small>Kode Unit/Satuan</small></label>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4"><label for="PutDenominator">Denominator</label></div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="PutDenominatorValue" name="PutDenominatorValue">
                            <label for="PutDenominatorValue"><small>Nilia/Jumlah Sajian</small></label>
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="PutDenominatorCode" name="PutDenominatorCode" list="ListDrugForm" autocomplete="off">
                            <label for="PutDenominatorCode"><small>Kode Unit/Satuan Sajian</small></label>
                            <datalist id="ListUcum">
                                <!-- List Ucum -->
                            </datalist>
                            <datalist id="ListDrugForm">
                                <!-- List Drug Form -->
                            </datalist>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary btn-round">
                        <i class="ti ti-plus"></i> Tambahkan
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary btn-round" data-dismiss="modal" aria-label="Close">
                        <i class="ti ti-close"></i> Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Referensi Ingridient -->
<div class="modal fade" id="ModalDetailIngridient" tabindex="-1" role="dialog" aria-labelledby="ModalDetailIngridient" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-info-alt"></i> Detail Ingridient</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12" id="FormDetailIngridient">

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary btn-round" data-dismiss="modal" aria-label="Close">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Detail  -->
<div class="modal fade" id="ModalDetailMedicationLocal" tabindex="-1" role="dialog" aria-labelledby="ModalDetailMedicationLocal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-info-alt"></i> Detail Medication (Local)</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12" id="FormDetailMedicationLocal">

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary btn-round" data-dismiss="modal" aria-label="Close">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalDetailMedicationSatuSehat" tabindex="-1" role="dialog" aria-labelledby="ModalDetailMedicationSatuSehat" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-info-alt"></i> Detail Medication (Satu Sehat)</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12" id="FormDetailMedicationSatuSehat">

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary btn-round" data-dismiss="modal" aria-label="Close">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalEditMedication" tabindex="-1" role="dialog" aria-labelledby="ModalEditMedication" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-info-alt"></i> Edit Medication</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12" id="FormEditMedication">

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary btn-round" data-dismiss="modal" aria-label="Close">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>