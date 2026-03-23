<!--- Modal Tambah Parameter ---->
<div class="modal fade" id="ModalTambahParameter" tabindex="-1" role="dialog" aria-labelledby="ModalTambahParameter" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahParameter">
                <div class="modal-header bg-primary">
                    <b cass="text-light"><i class="ti ti-plus"></i> Tambah Parameter Laboratorium</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <label for="parameter"><dt>Nama Parameter</dt></label>
                            <input type="text"  class="form-control" id="parameter" name="parameter">
                            <small>Nama Pemeriksaan  Lab</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <label for="kategori_parameter"><dt>Kategori Parameter</dt></label>
                            <input type="text"  class="form-control" id="kategori_parameter" name="kategori_parameter" list="ListKategori">
                            <datalist id="ListKategori">
                                <?php
                                    $QryKategori = mysqli_query($Conn, "SELECT DISTINCT kategori_parameter FROM laboratorium_parameter ORDER BY kategori_parameter ASC");
                                    while ($DataKategori = mysqli_fetch_array($QryKategori)) {
                                        $kategori_parameter= $DataKategori['kategori_parameter'];
                                        echo '<option value="'.$kategori_parameter.'">';
                                    }
                                ?>
                            </datalist>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="tipe_data"><dt>Tipe Data</dt></label>
                            <select name="tipe_data" id="tipe_data" class="form-control">
                                <option value="Number">Number</option>
                                <option value="Text">Text</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="satuan"><dt>Satuan</dt></label>
                            <input type="text"  class="form-control" id="satuan" name="satuan">
                            <small>Satuan Ukur (grm, %, ml, dll)</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="nilai_rujukan"><dt>Nilai Rujukan</dt></label>
                            <input type="text"  class="form-control" id="nilai_rujukan" name="nilai_rujukan">
                            <small>Nilai standar batas normal</small>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="nilai_kritis"><dt>Nilai Kritis</dt></label>
                            <input type="text"  class="form-control" id="nilai_kritis" name="nilai_kritis">
                            <small>Nilai ambang batas dari nilai rujukan</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <label for="keterangan"><dt>Keterangan</dt></label>
                            <textarea name="keterangan" id="keterangan" id="" cols="30" rows="3" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="row" id="ListFormAlternatif">
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <button type="button" class="btn btn-sm btn btn-outline-info btn-block"  id="AddAlternate">
                                <i class="ti ti-plus"></i> Tambah Alternatif
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-4" id="NotifikasiTambahParameter">
                            <span class="text-primary">Pastikan data parameter sudah sesuai</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-primary">
                    <button type="submit" class="btn btn-md btn btn-success">
                        <i class="ti ti-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-md btn btn-secondary" data-dismiss="modal">
                        <i class="ti ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Detail Parameter Lab ---->
<div class="modal fade" id="ModalDetailParameter" tabindex="-1" role="dialog" aria-labelledby="ModalDetailParameter" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <b cass="text-light"><i class="ti ti-info-alt"></i> Detail Parameter Laboratorium</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="FormDetailParameterLaboratorium">
                <!---- Form Detail Laboratorium ----->
            </div>
            <div class="modal-footer bg-info">
                <button type="button" class="btn btn-md btn btn-secondary" data-dismiss="modal">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Edit Parameter Lab ---->
<div class="modal fade" id="ModalEditParameter" tabindex="-1" role="dialog" aria-labelledby="ModalEditParameter" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditParameter">
                <div class="modal-header bg-success">
                    <b cass="text-light"><i class="ti ti-pencil-alt"></i> Edit Parameter Laboratorium</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="FormEditParameterLaboratorium">
                    <!---- Form Edit Laboratorium ----->
                </div>
                <div class="modal-footer bg-success">
                    <button type="submit" class="btn btn-md btn btn-primary">
                        <i class="ti ti-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-md btn btn-secondary" data-dismiss="modal">
                        <i class="ti ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Hapus Parameter Laboratorium ---->
<div class="modal fade" id="ModalHapusParameter" tabindex="-1" role="dialog" aria-labelledby="ModalHapusParameter" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <b cass="text-light">
                    <i class="ti ti-trash"></i> Hapus Parameter
                </b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormHapusParameter">
                <!---- Konfirmasi Hapus Parameter ----->
            </div>
        </div>
    </div>
</div>
<!--- Modal Export Parameter Lab ---->
<div class="modal fade" id="ModalExportParameterLaboratorium" tabindex="-1" role="dialog" aria-labelledby="ModalExportParameterLaboratorium" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="_Page/Laboratorium/ExportParameter.php" method="POST" target="_blank">
                <div class="modal-header bg-dark">
                    <b class="text-white"><i class="ti ti-download"></i> Export Parameter Laboratorium</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <label for="FormatExportParameter">Format</label>
                            <select name="FormatExportParameter" id="FormatExportParameter" class="form-control">
                                <option value="HTML">HTML</option>
                                <option value="Excel">Excel</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="HeaderKop">Tampilkan Header/Kop</label>
                            <select name="HeaderKop" id="HeaderKop" class="form-control">
                                <option value="Tampilkan">Tampilkan</option>
                                <option value="Tidak">Tidak</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            Data Hasil Export Akan Ditampilkan Pada Tab Baru
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-dark">
                    <button type="submit" class="btn btn-md btn btn-primary">
                        <i class="ti ti-download"></i> Export
                    </button>
                    <button type="button" class="btn btn-md btn btn-secondary" data-dismiss="modal">
                        <i class="ti ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Pilih Pasien ---->
<div class="modal fade" id="ModalPilihPasien" tabindex="-1" role="dialog" aria-labelledby="ModalPilihPasien" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-inverse">
                <b cass="text-light"><i class="ti ti-search"></i> Cari Data Pasien</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <form action="javascript:void(0);" id="ProsesCariPasien">
                            <div class="input-group">
                                <input type="text" name="KeywordPasien" id="KeywordPasien" class="form-control" placeholder="RM/Nama/NIK/BPJS">
                                <button type="submit" class="btn btn-outline-secondary">
                                    <i class="ti-search"></i> Cari
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row" id="TabelPasien">
                    <!---- List Data Pasien Dan Pagging ----->
                </div>
            </div>
            <div class="modal-footer bg-inverse">
                <button type="button" class="btn btn-md btn-outline-light" data-dismiss="modal">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Konfirmasi Pilih Pasien---->
<div class="modal fade" id="ModalKonfirmasiPilihPasien" tabindex="-1" role="dialog" aria-labelledby="ModalKonfirmasiPilihPasien" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <b cass="text-light"><i class="ti ti-check-box"></i> Konfirmasi Pilih Pasien</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormKonfirmasiPilihPasien">
                <!---- Form Detail Pasien ----->
            </div>
        </div>
    </div>
</div>
<!--- Modal Pilih Kunjungan ---->
<div class="modal fade" id="ModalPilihKunjungan" tabindex="-1" role="dialog" aria-labelledby="ModalPilihKunjungan" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-inverse">
                <b cass="text-light"><i class="ti ti-search"></i> Cari Data Kunjungan</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row" id="TabelKunjungan">
                    <!---- Tabel Kunjungan ----->
                </div>
            </div>
            <div class="modal-footer bg-inverse">
                <button type="button" class="btn btn-md btn-outline-light" data-dismiss="modal">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Konfirmasi Kunjungan---->
<div class="modal fade" id="ModalKonfirmasiPilihKunjungan" tabindex="-1" role="dialog" aria-labelledby="ModalPilihKunjungan" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <b cass="text-light"><i class="ti ti-check-box"></i> Konfirmasi Pilih Kunjungan</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormKonfirmasiKunjungan">
                <!---- Form Konfirmasi Kunjungan ----->
            </div>
        </div>
    </div>
</div>
<!--- Modal Detail Permintaan Laboratorium---->
<div class="modal fade" id="ModalDetailPermintaanLab" tabindex="-1" role="dialog" aria-labelledby="ModalDetailPermintaanLab" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <b cass="text-light"><i class="ti ti-info-alt"></i> Detail Permintaan Laboratorium</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormDetailPermintaanLab">
                <!---- Form Detail Permintaan Lab----->
            </div>
        </div>
    </div>
</div>
<!--- Modal Hapus Permintaan Laboratorium ---->
<div class="modal fade" id="ModalHapusPermintaan" tabindex="-1" role="dialog" aria-labelledby="ModalHapusPermintaan" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <b cass="text-light">
                    <i class="ti ti-trash"></i> Hapus Permintaan Lab
                </b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormHapusPermintaan">
                <!---- Konfirmasi Hapus Permintaan ----->
            </div>
        </div>
    </div>
</div>
<!--- Modal Konfirmasi Permintaan ---->
<div class="modal fade" id="ModalKonfirmasiPermintaan" tabindex="-1" role="dialog" aria-labelledby="ModalKonfirmasiPermintaan" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesKonfirmasiPermintaan">
                <div class="modal-header bg-danger">
                    <b cass="text-light"><i class="ti ti-check-box"></i> Konfirmasi Permintaan Laboratorium</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="FormKonfirmasiPermintaan">
                    <!---- Form Konfirmasi Permintaan ----->
                </div>
                <div class="modal-footer bg-danger">
                    <button type="submit" class="btn btn-md btn btn-primary">
                        <i class="ti ti-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-md btn btn-secondary" data-dismiss="modal">
                        <i class="ti ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Update Pemeriksaan ---->
<div class="modal fade" id="ModalUpdatePemeriksaan" tabindex="-1" role="dialog" aria-labelledby="ModalUpdatePemeriksaan" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesUpdatePemeriksaan">
                <div class="modal-header bg-success">
                    <b cass="text-light"><i class="ti ti-check-box"></i> Update Informasi Pemeriksaan</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="FormUpdatePemeriksaan">
                    <!---- Form Konfirmasi Permintaan ----->
                </div>
                <div class="modal-footer bg-success">
                    <button type="submit" class="btn btn-md btn btn-primary">
                        <i class="ti ti-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-md btn btn-secondary" data-dismiss="modal">
                        <i class="ti ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Tambah Spesimen ---->
<div class="modal fade" id="ModalTambahSpesiemen" tabindex="-1" role="dialog" aria-labelledby="ModalTambahSpesiemen" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahSpesimen">
                <div class="modal-header bg-primary">
                    <b cass="text-light"><i class="ti ti-plus"></i> Tambah Spesimen</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="FormTambahSpesimen">
                    <!---- Form Tambah Spesimen ----->
                </div>
                <div class="modal-footer bg-primary">
                    <button type="submit" class="btn btn-md btn btn-success">
                        <i class="ti ti-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-md btn btn-secondary" data-dismiss="modal">
                        <i class="ti ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Detail Spesimen ---->
<div class="modal fade" id="ModalDetailSpesimen" tabindex="-1" role="dialog" aria-labelledby="ModalDetailSpesimen" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <b cass="text-light"><i class="ti ti-info-alt"></i> Detail Spesimen</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="FormDetailSpesimen">
                <!---- Form Detail Spesimen ----->
            </div>
            <div class="modal-footer bg-info">
                <button type="button" class="btn btn-md btn btn-secondary" data-dismiss="modal">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Cetak Label Spesimen ---->
<div class="modal fade" id="ModaCetakLabelSpesimen" tabindex="-1" role="dialog" aria-labelledby="ModaCetakLabelSpesimen" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="_Page/Laboratorium/CetakLabelSpesimen.php" method="POST" target="_blank">
                <div class="modal-header bg-dark">
                    <b class="text-white"><i class="ti ti-printer"></i> Cetak Label Spesimen</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="FormCetakLabelSpesimen">
                    <!---- Form Tambah Spesimen ----->
                </div>
                <div class="modal-footer bg-dark">
                    <button type="submit" class="btn btn-md btn btn-primary">
                        <i class="ti ti-printer"></i> Cetak
                    </button>
                    <button type="button" class="btn btn-md btn btn-secondary" data-dismiss="modal">
                        <i class="ti ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Edit Spesimen ---->
<div class="modal fade" id="ModalEditSpesimen" tabindex="-1" role="dialog" aria-labelledby="ModalEditSpesimen" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditSpesimen">
                <div class="modal-header bg-success">
                    <b cass="text-light"><i class="ti ti-pencil-alt"></i> Edit Spesimen</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="FormEditSpesimen">
                    <!---- Form Tambah Spesimen ----->
                </div>
                <div class="modal-footer bg-success">
                    <button type="submit" class="btn btn-md btn btn-primary">
                        <i class="ti ti-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-md btn btn-secondary" data-dismiss="modal">
                        <i class="ti ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Hapus Spesimen ---->
<div class="modal fade" id="ModalHapusSpesimen" tabindex="-1" role="dialog" aria-labelledby="ModalHapusSpesimen" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <b cass="text-light">
                    <i class="ti ti-trash"></i> Hapus Spesimen
                </b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormHapusSpesimen">
                <!---- Konfirmasi Hapus Spesimen ----->
            </div>
        </div>
    </div>
</div>
<!--- Modal Hasil Pemeriksaan ---->
<div class="modal fade" id="ModalTambahHasilPemeriksaan" tabindex="-1" role="dialog" aria-labelledby="ModalTambahHasilPemeriksaan" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahHasilPemeriksaan">
                <div class="modal-header bg-success">
                    <b cass="text-light"><i class="ti ti-pencil-alt"></i> Form Hasil Pemeriksaan</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="FormHasilPemeriksaan">
                    <!---- Form Tambah Hasil Pemeriksaan ----->
                </div>
                <div class="modal-footer bg-success">
                    <button type="submit" class="btn btn-md btn btn-primary">
                        <i class="ti ti-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-md btn btn-secondary" data-dismiss="modal">
                        <i class="ti ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Hapus Hasil Pemeriksaan ---->
<div class="modal fade" id="ModalHapusHasilPemeriksaan" tabindex="-1" role="dialog" aria-labelledby="ModalHapusHasilPemeriksaan" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <b cass="text-light">
                    <i class="ti ti-trash"></i> Hapus Hasil Pemeriksaan
                </b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormHapusHasilPemeriksaan">
                <!---- Konfirmasi Hapus Hasil Pemeriksaan ----->
            </div>
        </div>
    </div>
</div>
<!--- Modal Cetak Hasil Pemeriksaan ---->
<div class="modal fade" id="ModalCetakHasilPemeriksaan" tabindex="-1" role="dialog" aria-labelledby="ModalCetakHasilPemeriksaan" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="_Page/Laboratorium/CetakHasilPemeriksaan.php" method="POST" target="_blank">
                <div class="modal-header bg-dark">
                    <b class="text-white"><i class="ti ti-printer"></i> Cetak Hasil Pemeriksaan</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="FormCetakHasilPemeriksaan">
                    <!---- Form Tambah Spesimen ----->
                </div>
                <div class="modal-footer bg-dark">
                    <button type="submit" class="btn btn-md btn btn-primary">
                        <i class="ti ti-printer"></i> Cetak
                    </button>
                    <button type="button" class="btn btn-md btn btn-secondary" data-dismiss="modal">
                        <i class="ti ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Export Permintaan Laboratorium---->
<div class="modal fade" id="ModalExportPermintaanLab" tabindex="-1" role="dialog" aria-labelledby="ModalExportPermintaanLab" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="_Page/Laboratorium/ExportLaboratorium.php" method="POST" target="_blank">
                <div class="modal-header bg-dark">
                    <b class="text-white"><i class="ti ti-download"></i> Export Data Laboratorium</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label for="periode"><dt>Tipe Periode</dt></label>
                        </div>
                        <div class="col-6 mb-3">
                            <select name="periode" id="periode" class="form-control">
                                <option value="Tahunan">Tahunan</option>
                                <option value="Bulanan">Bulanan</option>
                                <option value="Harian">Harian</option>
                                <option value="Periode">Periode</option>
                            </select>
                        </div>
                    </div>
                    <div id="KeteranganWaktu">
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label for="tahun"><dt>Tahun</dt></label>
                            </div>
                            <div class="col-6 mb-3">
                                <select name="tahun" id="tahun" class="form-control">
                                    <?php
                                        for ($tahun_list = 2010; $tahun_list <= date('Y'); $tahun_list++) {
                                            if($tahun_list==date('Y')){
                                                echo '<option selected value="'.$tahun_list.'">'.$tahun_list.'</option>';
                                            }else{
                                                echo '<option selected value="'.$tahun_list.'">'.$tahun_list.'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label for="format"><dt>Format</dt></label>
                        </div>
                        <div class="col-6 mb-3">
                            <select name="format" id="format" class="form-control">
                                <option value="Excel">Excel</option>
                                <option value="HTML">HTML</option>
                                <option value="PDF">PDF</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-dark">
                    <button type="submit" class="btn btn-md btn btn-primary">
                        <i class="ti ti-download"></i> Export
                    </button>
                    <button type="button" class="btn btn-md btn btn-secondary" data-dismiss="modal">
                        <i class="ti ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>