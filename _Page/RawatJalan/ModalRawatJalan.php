<!--- Modal Filter Kunjungan---->
<div class="modal fade" id="ModalFilterKunjungan" tabindex="-1" role="dialog" aria-labelledby="ModalFilterKunjungan" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <form action="javascript:void(0);" id="BatasPencarian">
            <div class="modal-content">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-filter"></i> Filter Kunjungan</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <select name="batas" id="batas" class="form-control">
                                <option value="5">5</option>
                                <option selected value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                            <small>Batas</small>
                        </div>
                        <div class="col-md-12 mb-3">
                            <select name="keyword_by" id="keyword_by" class="form-control">
                                <option value="">Pilih</option>
                                <option value="id_kunjungan">No.Kunjungan</option>
                                <option value="id_pasien">No.RM</option>
                                <option value="nama">Nama Pasien</option>
                                <option value="tanggal">Tanggal</option>
                                <option value="nik">NIK</option>
                                <option value="no_bpjs">Nomor Kartu BPJS</option>
                                <option value="tujuan">Tujuan Kunjungan</option>
                                <option value="dokter">Dokter</option>
                                <option value="poliklinik">Poliklinik</option>
                                <option value="pembayaran">Metode Pembayaran</option>
                                <option value="status">Status Kunjungan</option>
                            </select>
                            <small>Keyword By</small>
                        </div>
                        <div class="col-md-12 mb-3">
                            <input type="text" class="form-control" name="keyword" id="keyword" placeholder="Kata Kunci">
                            <small>Pencarian</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="ti-filter"></i> Filter
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<!--- Modal Filter Encounter---->
<div class="modal fade" id="ModalFilterEncounter" tabindex="-1" role="dialog" aria-labelledby="ModalFilterEncounter" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <form action="javascript:void(0);" id="ProsesPencarianEncounter">
            <div class="modal-content">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-search"></i> Pencarian Encounter</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3 sub-title">
                        <div class="col-md-4 mb-3">
                            <select name="DasarPencarianEncounter" id="DasarPencarianEncounter" class="form-control">
                                <option value="ID Encounter">ID Encounter</option>
                                <option value="Subject">Subject/ID IHHS Pasien</option>
                            </select>
                            <label for="DasarPencarianEncounter">
                                <small>Dasar Pencarian</small>
                            </label>
                        </div>
                        <div class="col-md-6 mb-3">
                            <input type="text" class="form-control" name="keyword_encounter" id="keyword_encounter" placeholder="Kata Kunci">
                            <label for="keyword_encounter">
                                <small>Kata Kunci</small>
                            </label>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-sm btn-primary btn-block">
                                <i class="ti-search"></i> Cari
                            </button>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12" id="FormHasilPencarianEncounter">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- ENCOUNTER -->
<div class="modal fade" id="ModalExportKunjungan" tabindex="-1" role="dialog" aria-labelledby="ModalExportKunjungan" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <form action="_Page/RawatJalan/ProsesExportKunjungan.php" method="POST" target="_blank">
            <div class="modal-content">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-filter"></i> Eksport Kunjungan</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="tujuan_kunjungan_export">Tujuan</label>
                        </div>
                        <div class="col-1">:</div>
                        <div class="col-7">
                            <select name="tujuan" id="tujuan_kunjungan_export" class="form-control">
                                <option value="">Semua</option>
                                <option value="Rajal">Rajal</option>
                                <option value="Ranap">Ranap</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="periode_tahun_export">Tahun</label>
                        </div>
                        <div class="col-1">:</div>
                        <div class="col-7">
                            <input type="number" step="1" min="2000" max="<?php echo date('Y'); ?>" class="form-control" name="tahun" id="periode_tahun_export" value="<?php echo date('Y'); ?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="periode_bulan_export">Bulan</label>
                        </div>
                        <div class="col-1">:</div>
                        <div class="col-7">
                            <?php
                                echo '<select name="bulan" id="periode_bulan_export" class="form-control">';
                                $bulan = [
                                    "01" => "Januari", "02" => "Februari", "03" => "Maret",
                                    "04" => "April", "05" => "Mei", "06" => "Juni",
                                    "07" => "Juli", "08" => "Agustus", "09" => "September",
                                    "10" => "Oktober", "11" => "November", "12" => "Desember"
                                ];
                                
                                foreach ($bulan as $key => $nama) {
                                    if($key==date('m')){
                                        echo "<option selected value='$key'>$nama</option>";
                                    }else{
                                        echo "<option value='$key'>$nama</option>";
                                    }
                                }
                                echo '</select>';
                            ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="ti-filter"></i> Export
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<!--- Modal Detail Kunjungan---->
<div class="modal fade" id="ModalDetailInfoKunjungan" tabindex="-1" role="dialog" aria-labelledby="ModalDetailInfoKunjungan" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-info-alt"></i> Detail Kunjungan</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="FormDetailInfoKunjungan">
                <!-- Isi Detail Kunjungan -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Tambah Rajal ---->
<div class="modal fade" id="ModalTambahRajal" tabindex="-1" role="dialog" aria-labelledby="ModalTambahRajal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <b cass="text-light"><i class="icofont-prescription"></i> Pilih Pasien</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="javascript:void(0);" id="PencarianPasien">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="keyword" id="keyword" placeholder="Kata Kunci">
                            <small>Pencarian</small>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-sm btn-outline-secondary"><i class="ti-search"></i> Go</button>
                        </div>
                    </div>
                    <div class="row" >
                        <div class="col-md-12 mb-3 pre-scrollable" id="FormPilihPasien">
                            <!-- Form Pilih Pasien -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-primary">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <button type="button" class="btn btn-md btn-light btn-round mt-2 ml-2" data-dismiss="modal">
                                <i class="ti-close"></i> Tutup
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Pilih Pasien ---->
<div class="modal fade" id="ModalPilihPasien" tabindex="-1" role="dialog" aria-labelledby="ModalPilihPasien" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-inverse">
                <b cass="text-light"><i class="icofont-prescription"></i> Konfirmasi Pilih Pasien</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="KonfirmasiPilihPasien">
                <!---- Konfirmasi Pilih pasien ----->
            </div>
        </div>
    </div>
</div>
<!-- Modal Detail pasien -->
<div class="modal fade" id="ModalDetailPasien" tabindex="-1" role="dialog" aria-labelledby="ModalDetailPasien" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-light"><i class="icofont-prescription"></i> Detail Pasien</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="DetailPasien">
                <!---- Detail Pasien ----->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Detail pasien2 -->
<div class="modal fade" id="ModalDetailPasien2" tabindex="-1" role="dialog" aria-labelledby="ModalDetailPasien2" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-light"><i class="icofont-prescription"></i> Detail Pasien</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="DetailPasien2">
                <!---- Detail Pasien ----->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Detail IHS -->
<div class="modal fade" id="ModalDetailIhs" tabindex="-1" role="dialog" aria-labelledby="ModalDetailIhs" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-light"><i class="icofont-prescription"></i> Detail IHS Pasien</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="FormDetailIhs">
                <!---- Detail IHS Pasien ----->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Cek NIK---->
<div class="modal fade" id="ModalDetailNik" tabindex="-1" role="dialog" aria-labelledby="ModalDetailNik" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b><i class="ti ti-info-alt"></i> Detail NIK Pasien</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="FormDetailNik">
                <!---- Form Detail NIK pasien----->
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-12">
                            <button type="button" class="btn btn-sm btn-secondary mt-2 ml-2" data-dismiss="modal">
                                <i class="ti-close"></i> Tutup
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Detail Pasien BPJS -->
<div class="modal fade" id="ModalDetailBpjs" tabindex="-1" role="dialog" aria-labelledby="ModalDetailBpjs" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b><i class="ti ti-info-alt"></i> Detail BPJS Pasien</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="FormDetailBPJS">
                <!---- Form Detail BPJS pasien----->
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-12">
                            <button type="button" class="btn btn-sm btn-secondary mt-2 ml-2" data-dismiss="modal">
                                <i class="ti-close"></i> Tutup
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalStatusKepesertaanNik" tabindex="-1" role="dialog" aria-labelledby="ModalStatusKepesertaanNik" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-inverse">
                <b cass="text-light"><i class="icofont-prescription"></i> Status Kepesertaan BPJS</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="StatusKepesertaanNik">
                <!---- Status Kepesertaan Berdasarkan No Nik ----->
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalStatusKepesertaanBPJS" tabindex="-1" role="dialog" aria-labelledby="ModalStatusKepesertaanBPJS" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-inverse">
                <b cass="text-light"><i class="icofont-prescription"></i> Status Kepesertaan BPJS</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="StatusKepesertaanBPJS">
                <!---- Modal Status Kepesertaan Berdasarkan No BPJS----->
            </div>
        </div>
    </div>
</div>
<!--- Modal Cari SEP ---->
<div class="modal fade" id="ModalCariSEP" tabindex="-1" role="dialog" aria-labelledby="ModalCariSEP" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-inverse">
                <b cass="text-light"><i class="ti ti-search"></i> Cari Data SEP</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormCariSep">
                <!---- Form Cari Sep ----->
            </div>
        </div>
    </div>
</div>
<!--- Modal Cari Antrian ---->
<div class="modal fade" id="ModalCariAntrian" tabindex="-1" role="dialog" aria-labelledby="ModalCariAntrian" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesPilihIdAntrian">
                <div class="modal-header bg-inverse">
                    <b cass="text-light"><i class="ti ti-search"></i> Cari Antrian</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormCariAntrian">
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalCekIdAntrian" tabindex="-1" role="dialog" aria-labelledby="ModalCekIdAntrian" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-info-alt"></i> Detail Antrian</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="FormDetailAntrian">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal" aria-label="Close">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Cari Sep ---->
<div class="modal fade" id="ModalCariSep" tabindex="-1" role="dialog" aria-labelledby="ModalCariSep" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesPilihSep">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-search"></i> Cari SEP</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <input type="text" class="form-control" id="KeywordNomorKartu" name="KeywordNomorKartu">
                            <small>Nomor Kartu</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <input type="date" class="form-control" id="TanggalAwalPencarianSep" name="TanggalAwalPencarianSep">
                            <small>Periode Awal Pencarian</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <input type="date" class="form-control" id="TanggalAkhirPencarianSep" name="TanggalAkhirPencarianSep">
                            <small>Periode Akhir Pencarian</small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-sm btn-block btn-outline-dark" id="MulaiCariSep">
                                <i class="ti ti-search"></i> Mulai Cari SEP
                            </button>
                        </div>
                    </div>
                    <div id="FormHasilPencarianSep">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal" aria-label="Close">
                        <i class="ti ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalCekNomorSep" tabindex="-1" role="dialog" aria-labelledby="ModalCekNomorSep" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-info-alt"></i> Detail SEP</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="FormCekSep">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal" aria-label="Close">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Cari Rujukan ---->
<div class="modal fade" id="ModalCariRujukan" tabindex="-1" role="dialog" aria-labelledby="ModalCariRujukan" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesPilihRujukan">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-search"></i> Cari Rujukan</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <input type="text" class="form-control" id="KeywordNomorKartu2" name="KeywordNomorKartu2">
                            <small>Nomor Kartu</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <input type="radio" id="SumberRujukan1" name="SumberRujukan" value="Pcare">
                            <label for="SumberRujukan1"><small>PCare</small></label>
                            <input type="radio" id="SumberRujukan2" name="SumberRujukan" value="RS">
                            <label for="SumberRujukan2"><small>Rumah Sakit (RS)</small></label>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-sm btn-block btn-outline-dark" id="MulaiCariRujukan">
                                <i class="ti ti-search"></i> Mulai Cari Rujukan
                            </button>
                        </div>
                    </div>
                    <div id="FormHasilPencarianRujukan">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal" aria-label="Close">
                        <i class="ti ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalDetailRujukanMasukByRujukan" tabindex="-1" role="dialog" aria-labelledby="ModalDetailRujukanMasukByRujukan" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesCariDetailRujukanByRujukan">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-search"></i> Cari Rujukan</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="FormNomorRujukanByRujukan">Nomor Rujukan</label>
                            <input type="text" name="no_rujukan" id="FormNomorRujukanByRujukan" class="form-control">
                            <small>
                                <input checked type="radio" name="TipeRujukanByRujukan" id="TipeRujukanByRujukanPCare" value="PCare">
                                <label for="TipeRujukanByRujukanPCare">PCare</label>
                                <input type="radio" name="TipeRujukanByRujukan" id="TipeRujukanByRujukanRumahSakit" value="Rumah Sakit">
                                <label for="TipeRujukanByRujukanRumahSakit">Rumah Sakit</label>
                            </small>
                        </div>
                    </div>
                    <div class="row mt-3 mb-3">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-sm btn-block btn-primary btn-round">
                                <i class="ti ti-search"></i> Cari
                            </button>
                        </div>
                    </div>
                    <div class="row mt-3 mb-3">
                        <div class="col-md-12" id="FormDetailRujukanMasukByRujukan">

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal" aria-label="Close">
                        <i class="ti ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalDetailRujukanPendaftaranKunjungan" tabindex="-1" role="dialog" aria-labelledby="ModalDetailRujukanPendaftaranKunjungan" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-search"></i> Detail Rujukan</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="DetailRujukanPendaftaranKunjungan">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal" aria-label="Close">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Cari Diagnosa ---->
<div class="modal fade" id="ModalCariDiagnosa" tabindex="-1" role="dialog" aria-labelledby="ModalCariDiagnosa" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-inverse">
                <b cass="text-light"><i class="ti ti-search"></i> Cari Diagnosa</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0);" id="PencarianDiagnosa">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <div class="input-group">
                                <input type="text" class="form-control" name="keyword" id="keyword" placeholder="Nama/Kode Diagnosa">
                                <button type="submit" class="btn btn-sm btn-secondary"><i class="ti-search"></i> Cari</button>
                            </div>
                            <small>
                                Resource Pencarian: 
                                <input checked type="radio" name="ModePencarianDiagnosa" id="ModePencarianDiagnosaSIMRS" Value="SIMRS">
                                <label for="ModePencarianDiagnosaSIMRS">SIMRS</label>
                                <input type="radio" name="ModePencarianDiagnosa" id="ModePencarianDiagnosaBPJS" Value="BPJS">
                                <label for="ModePencarianDiagnosaBPJS">BPJS</label>
                            </small>
                        </div>
                    </div>
                </form>
                <div class="row mb-3">
                    <div class="col-md-12" id="FormCariDiagnosa">
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-inverse">
                <button type="button" class="btn btn-sm btn-default">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalKonfirmasiDiagnosa" tabindex="-1" role="dialog" aria-labelledby="ModalKonfirmasiDiagnosa" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <b cass="text-light"><i class="icofont-prescription"></i> Konfirmasi Pilih Diagnosa</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="KonfirmasiPilihDiagnosa">
                <!---- Konfirmasi Pilih Diagnosa ----->
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalPPKAsal" tabindex="-1" role="dialog" aria-labelledby="ModalPPKAsal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-inverse">
                <b cass="text-light"><i class="ti ti-search"></i> Cari Kode PPK</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0);" id="PencarianPPKAsal">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="input-group">
                                <input type="text" class="form-control" name="keyword" id="keyword" placeholder="Kata Kunci">
                                <button type="submit" class="btn btn-sm btn-secondary"><i class="ti-search"></i> Cari</button>
                            </div>
                            <small>
                                Jenis Faskes : <br>
                                <input checked type="radio" name="JenisFaskes" id="JenisFaskes1" value="1">
                                <label for="JenisFaskes1">Faskes 1</label>
                                <input type="radio" name="JenisFaskes" id="JenisFaskes2" value="2">
                                <label for="JenisFaskes2">Faskes 2</label>
                            </small>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-body" id="FormCariPPKAsal">
                <!---- Form Cari PPK Asal ----->
            </div>
            <div class="modal-footer bg-inverse">
                <button type="button" class="btn btn-sm btn-light mt-2 mr-2" data-dismiss="modal">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalPPKTujuan" tabindex="-1" role="dialog" aria-labelledby="ModalPPKTujuan" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-inverse">
                <b cass="text-light"><i class="ti ti-search"></i> Cari Kode PPK</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0);" id="PencarianPPKTujuan">
                    <div class="row">
                        <div class="col-md-5">
                            <input type="text" class="form-control" name="keyword" id="keyword" placeholder="Kata Kunci">
                            <small>Pencarian</small>
                        </div>
                        <div class="col-md-5">
                            <select name="JenisFaskes" id="JenisFaskes" class="form-control">
                                <option value="1">Faskes 1</option>
                                <option value="2">Faskes 2</option>
                            </select>
                            <small>Kategori Faskes</small>
                        </div>
                        <div class="col-md-2 text-left">
                            <button type="submit" class="btn btn-sm btn-outline-secondary"><i class="ti-search"></i> Go</button>
                        </div>
                    </div>
                </form>
            </div>
            <div id="FormCariPPKTujuan">
                <!---- Form Cari PPK Tujuan ----->
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalKonfirmasiPPK" tabindex="-1" role="dialog" aria-labelledby="ModalKonfirmasiPPK" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-inverse">
                <b cass="text-light"><i class="icofont-prescription"></i> Konfirmasi Pilih PPK</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="KonfirmasiPilihPPK">
                <!---- Konfirmasi Pilih PPK ----->
            </div>
        </div>
    </div>
</div>
<!-- Modal Detail Kunjungan -->
<div class="modal fade" id="ModalDetailKunjungan" tabindex="-1" role="dialog" aria-labelledby="ModalDetailKunjungan" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-inverse">
                <b cass="text-light"><i class="icofont-prescription"></i> Detail Kunjungan Rajal</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="DetailKunjunganRajal">
                <!---- Detail Kunjungan Rajal----->
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalHapusKunjungan" tabindex="-1" role="dialog" aria-labelledby="ModalHapusKunjungan" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <b cass="text-light"><i class="ti ti-trash"></i> Hapus Kunjungan</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="HapusKunjungan">
                <!---- Hapus Kunjungan----->
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalEditKunjungan" tabindex="-1" role="dialog" aria-labelledby="ModalEditKunjungan" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-pencil"></i> Edit Kunjungan</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="KonfirmasiEditKunjungan">
                <!---- Hapus Kunjungan----->
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalBuatSEP" tabindex="-1" role="dialog" aria-labelledby="ModalBuatSEP" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <b cass="text-light"><i class="ti ti-trash"></i> Buat SEP</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="KonfirmasiBuatSep">
                <!---- Buat SEP----->
            </div>
        </div>
    </div>
</div>
<!-- Modal Cek Kepesertaan By Nik -->
<div class="modal fade" id="ModalCekKepesertaanByNik" tabindex="-1" role="dialog" aria-labelledby="ModalCekKepesertaanByNik" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-inverse">
                <b cass="text-light"><i class="icofont-prescription"></i> Status Kepesertaan BPJS</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="CekKepesertaanByNik">
                <!---- Cek Kepesertaan By Nik ----->
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalDetailNik2" tabindex="-1" role="dialog" aria-labelledby="ModalDetailNik2" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-info-alt"></i> Detail NIK Pasien</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="FormDetailNik2">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal" aria-label="Close">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalCekKepesertaanByBpjs" tabindex="-1" role="dialog" aria-labelledby="ModalCekKepesertaanByBpjs" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-inverse">
                <b cass="text-light"><i class="icofont-prescription"></i> Status Kepesertaan BPJS</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="CekKepesertaanByBpjs">
                <!---- Modal Status Kepesertaan Berdasarkan No BPJS----->
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalDetailBpjs2" tabindex="-1" role="dialog" aria-labelledby="ModalDetailBpjs2" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-info-alt"></i> Detail BPJS Pasien</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="FormDetailBPJS2">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal" aria-label="Close">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalDetailSep" tabindex="-1" role="dialog" aria-labelledby="ModalDetailSep" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-inverse">
                <b cass="text-light"><i class="icofont-prescription"></i> Detail Data SEP</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="DetailSep">
                <!---- Modal Detail Sep----->
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalDetailSepBySep" tabindex="-1" role="dialog" aria-labelledby="ModalDetailSepBySep" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="icofont-prescription"></i> Detail SEP</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="FormDetailSepBySep">
                <!---- Modal Detail Sep By SEP----->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalEditSEP" tabindex="-1" role="dialog" aria-labelledby="ModalEditSEP" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <b cass="text-light"><i class="ti ti-pencil-alt"></i> Edit Data SEP</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormEditSep">
                <!---- Modal Edit Sep----->
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalHapusSep" tabindex="-1" role="dialog" aria-labelledby="ModalHapusSep" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <b cass="text-light"><i class="ti ti-trash"></i> Konfirmasi Hapus SEP</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormHapusSep">
                <!---- Modal Hapus Sep----->
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalDataApproval" tabindex="-1" role="dialog" aria-labelledby="ModalDataApproval" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-inverse">
                <b cass="text-light"><i class="icofont-wall-clock"></i> Data Pengajuan Approval</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="DataPengajuanApproval">
                <!---- Form Pengajuan Approval----->
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalPengajuanApproval" tabindex="-1" role="dialog" aria-labelledby="ModalPengajuanApproval" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-inverse">
                <b cass="text-light"><i class="icofont-wall-clock"></i> Pengajuan Approval</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormPengajuanApproval">
                <!---- Form Pengajuan Approval----->
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalHapusApproval" tabindex="-1" role="dialog" aria-labelledby="ModalHapusApproval" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <b cass="text-light"><i class="ti ti-trash"></i> Konfirmasi Hapus Approval</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormHapusApproval">
                <!---- Form Hapus Approval----->
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalApprove" tabindex="-1" role="dialog" aria-labelledby="ModalApprove" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <b cass="text-light"><i class="ti ti-check"></i> Konfirmasi Approval</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormKonfirmasiApproval">
                <!---- Form Hapus Approval----->
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalUpdateTanggalPulang" tabindex="-1" role="dialog" aria-labelledby="ModalApprove" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-inverse">
                <b cass="text-light"><i class="ti ti-check"></i> Update Status Pulang</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormUpdateTanggalPulang">
                <!---- Form Hapus Approval----->
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalInsertRencanaKontrol" tabindex="-1" role="dialog" aria-labelledby="ModalInsertRencanaKontrol" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-inverse">
                <b cass="text-light"><i class="icofont-ui-calendar"></i> Insert Rencana Kontrol</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormRencanaKontrol">
                <!---- Form Insert Rencana Kontrol----->
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalInsertSpri" tabindex="-1" role="dialog" aria-labelledby="ModalInsertSpri" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-inverse">
                <b cass="text-light"><i class="icofont-ui-calendar"></i> Insert SPRI</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormInsertSpri">
                <!---- Form Insert SPRI----->
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalCariSPRI" tabindex="-1" role="dialog" aria-labelledby="ModalCariSPRI" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <b cass="text-light"><i class="icofont-search-document"></i> Pencarian Data Surat Kontrol & SPRI</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormCariSPRI">
                <!---- Form Cari SPRI----->
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalCariSpriSkdpPendaftaranKunjungan" tabindex="-1" role="dialog" aria-labelledby="ModalCariSpriSkdpPendaftaranKunjungan" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="icofont-search-document"></i> Pencarian SKDP/SPRI</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0);" id="ProsesPencarianSpriSkdpKunjungan">
                    <div class="row mb-4">
                        <div class="col-md-12 input-group">
                            <input type="text" id="PutNomorKartu" name="PutNomorKartu" class="form-control">
                            <button type="submit" class="btn btn-sm btn-outline-secondary">
                                <i class="ti ti-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
                <div class="row mb-4">
                    <div class="col-md-12" id="FormCariSpriSkdpPendaftaranKunjungan">
                        <!---- Form Cari SPRI/SKDP Pendaftaran Kunjungan----->
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <di class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-md btn-default">
                            <i class="ti ti-close"></i> Tutup
                        </button>
                    </div>
                </di>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalCekSkdpPendaftaranKunjungan" tabindex="-1" role="dialog" aria-labelledby="ModalCekSkdpPendaftaranKunjungan" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-info-alt"></i> Detail SKDP/SPRI</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="DetailSpriSkdpKunjungan">
                
            </div>
            <div class="modal-footer">
                <di class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-md btn-default">
                            <i class="ti ti-close"></i> Tutup
                        </button>
                    </div>
                </di>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalDetailSpriSkdp" tabindex="-1" role="dialog" aria-labelledby="ModalDetailSpriSkdp" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-info-alt"></i> Detail SKDP/SPRI</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="DetailSpriSkdp">
                
            </div>
            <div class="modal-footer">
                <di class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-md btn-default">
                            <i class="ti ti-close"></i> Tutup
                        </button>
                    </div>
                </di>
            </div>
        </div>
    </div>
</div>
<!-- Modal SEP Internal -->
<div class="modal fade" id="ModalDataSepInternal" tabindex="-1" role="dialog" aria-labelledby="ModalDataSepInternal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <b cass="text-light"><i class="icofont-search-document"></i> Data SEP Internal</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormCariSepInternal">
                <!---- Form Cari SPRI----->
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalHapusSepInternal" tabindex="-1" role="dialog" aria-labelledby="ModalHapusSepInternal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <b cass="text-light"><i class="ti ti-trash"></i> Hapus SEP Internal</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormHapusSeInterna">
                <!---- Form Hapus Sep Internal----->
            </div>
        </div>
    </div>
</div>
<!-- Mencai Supplesi -->
<div class="modal fade" id="ModalCariDataSuplesi" tabindex="-1" role="dialog" aria-labelledby="ModalCariDataSuplesi" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <b cass="text-light"><i class="icofont-search-document"></i> Suplesi & Data Induk Kecelakaan</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-sm btn-inverse mt-2 mr-2" id="CariDataSupplesi">
                            Suplesi Jasa Raharja
                        </button>
                        <button type="button" class="btn btn-sm btn-primary mt-2 mr-2" id="CariDataIndukKecelakaan">
                            Data Induk Kecelakaan
                        </button>
                    </div>
                </div>
            </div>
            <div id="FormCariSuplesi">
                <!---- Form Cari Suplesi----->
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalCariPropinsi" tabindex="-1" role="dialog" aria-labelledby="ModalCariPropinsi" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <b cass="text-light"><i class="ti ti-search"></i> Cari Propinsi</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <di class="row">
                    <div class="col-md-12" id="FormCariPropinsi">
                        <!---- Form Hapus Sep Internal----->
                    </div>
                </di>
            </div>
            <div class="modal-footer">
                <di class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-md btn-default">
                            <i class="ti ti-close"></i> Tutup
                        </button>
                    </div>
                </di>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalAmbilPropinsi" tabindex="-1" role="dialog" aria-labelledby="ModalAmbilPropinsi" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-search"></i> Pilih Propinsi</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <di class="row">
                    <div class="col-md-12" id="KonfirmasiPilihPropinsi">
                        <!---- Form Hapus Sep Internal----->
                    </div>
                </di>
            </div>
            <div class="modal-footer">
                <di class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-md btn-default" id="KonfirmasiPilihPropinsiYa">
                            <i class="ti ti-close"></i> Ya, Betul
                        </button>
                        <button type="button" class="btn btn-md btn-default">
                            <i class="ti ti-close"></i> Tutup
                        </button>
                    </div>
                </di>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModdalCariKabupaten" tabindex="-1" role="dialog" aria-labelledby="ModdalCariKabupaten" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <b cass="text-light"><i class="ti ti-search"></i> Cari Kabupaten</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <di class="row">
                    <div class="col-md-12" id="FormCariKabupaten">
                       
                    </div>
                </di>
            </div>
            <div class="modal-footer">
                <di class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-md btn-default">
                            <i class="ti ti-close"></i> Tutup
                        </button>
                    </div>
                </di>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalAmbilKabupaten" tabindex="-1" role="dialog" aria-labelledby="ModalAmbilKabupaten" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-search"></i> Pilih Kabupaten</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <di class="row">
                    <div class="col-md-12" id="KonfirmasiPilihKabupaten">
                        <!---- Form Hapus Sep Internal----->
                    </div>
                </di>
            </div>
            <div class="modal-footer">
                <di class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-md btn-default" id="KonfirmasiPilihKabupatenYa">
                            <i class="ti ti-close"></i> Ya, Betul
                        </button>
                        <button type="button" class="btn btn-md btn-default" data-dismiss="modal">
                            <i class="ti ti-close"></i> Tutup
                        </button>
                    </div>
                </di>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalcariKecamatan" tabindex="-1" role="dialog" aria-labelledby="ModalcariKecamatan" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <b cass="text-light"><i class="ti ti-search"></i> Cari Kecamatan</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <di class="row">
                    <div class="col-md-12" id="FormCariKecamatan">
                    </div>
                </di>
            </div>
            <div class="modal-footer">
                <di class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-md btn-default" data-dismiss="modal">
                            <i class="ti ti-close"></i> Tutup
                        </button>
                    </div>
                </di>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalAmbilKecamatan" tabindex="-1" role="dialog" aria-labelledby="ModalAmbilKecamatan" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-search"></i> Pilih Kecamatan</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <di class="row">
                    <div class="col-md-12" id="KonfirmasiPilihKecamatan">
                        <!---- Form Hapus Sep Internal----->
                    </div>
                </di>
            </div>
            <div class="modal-footer">
                <di class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-md btn-default" id="KonfirmasiPilihKecamatanYa">
                            <i class="ti ti-close"></i> Ya, Betul
                        </button>
                        <button type="button" class="btn btn-md btn-default" data-dismiss="modal">
                            <i class="ti ti-close"></i> Tutup
                        </button>
                    </div>
                </di>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalCariEncounter" tabindex="-1" role="dialog" aria-labelledby="ModalCariEncounter" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-search"></i> Pencarian Encounter</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <di class="row">
                    <div class="col-md-12" id="FormHasilCariEncounter">
                        <!---- Form Hasil Pencarian Encounter----->
                    </div>
                </di>
            </div>
            <div class="modal-footer">
                <di class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">
                            <i class="ti ti-close"></i> Tutup
                        </button>
                    </div>
                </di>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalTambahEncounter" tabindex="-1" role="dialog" aria-labelledby="ModalTambahEncounter" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <b cass="text-lioght"><i class="ti ti-plus"></i> Tambah Encounter</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormTambahEncounter">
                <!-- Form Tambah Encounter -->
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalDetailEncounter" tabindex="-1" role="dialog" aria-labelledby="ModalDetailEncounter" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-info-alt"></i> Detail Encounter</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <di class="row">
                    <div class="col-md-12" id="FormDetailEncounter">
                        <!---- Form Detail Encounter----->
                    </div>
                </di>
            </div>
            <div class="modal-footer">
                <di class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">
                            <i class="ti ti-close"></i> Tutup
                        </button>
                    </div>
                </di>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalEditEncounter" tabindex="-1" role="dialog" aria-labelledby="ModalEditEncounter" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <b cass="text-lioght"><i class="ti ti-pencil"></i> Edit Encounter</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormEditEncounter">
                <!-- Form Edit Encounter -->
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalUpdateEncounter" tabindex="-1" role="dialog" aria-labelledby="ModalUpdateEncounter" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <b cass="text-lioght"><i class="ti ti-timer"></i> Update Status Encounter</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormUpdateEncounter">
                <!-- Form Edit Encounter -->
            </div>
        </div>
    </div>
</div>
<!-- CONDITION -->
<div class="modal fade" id="ModalTambahCondition" tabindex="-1" role="dialog" aria-labelledby="ModalTambahCondition" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <b cass="text-lioght"><i class="ti ti-plus"></i> Tambah Condition</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormTambahCondition">
                <!-- Form Tambah Condition -->
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalDetailCondition" tabindex="-1" role="dialog" aria-labelledby="ModalDetailCondition" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-info-alt"></i> Detail Condition</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <di class="row">
                    <div class="col-md-12" id="FormDetailCondition">
                        <!---- Form Detail Condition----->
                    </div>
                </di>
            </div>
            <div class="modal-footer">
                <di class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">
                            <i class="ti ti-close"></i> Tutup
                        </button>
                    </div>
                </di>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalEditCondition" tabindex="-1" role="dialog" aria-labelledby="ModalEditCondition" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <b cass="text-lioght"><i class="ti ti-pencil-alt"></i> Edit Condition</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormEditCondition">
                <!-- Form Edit Condition -->
            </div>
        </div>
    </div>
</div>
<!-- OBSERVATION -->
<div class="modal fade" id="ModalTambahObservation" tabindex="-1" role="dialog" aria-labelledby="ModalTambahObservation" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <b cass="text-lioght"><i class="ti ti-plus"></i> Tambah Observation</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormTambahObservation">
                <!-- Form Tambah Observation -->
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalDetailObservation" tabindex="-1" role="dialog" aria-labelledby="ModalDetailObservation" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-info-alt"></i> Detail Observation</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <di class="row">
                    <div class="col-md-12" id="FormDetailObservation">
                        <!---- Form Detail Observation----->
                    </div>
                </di>
            </div>
            <div class="modal-footer">
                <di class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">
                            <i class="ti ti-close"></i> Tutup
                        </button>
                    </div>
                </di>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalEditObservation" tabindex="-1" role="dialog" aria-labelledby="ModalEditObservation" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <b cass="text-lioght"><i class="ti ti-pencil-alt"></i> Edit Observation</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormEditObservation">
                <!-- Form Edit Observation -->
            </div>
        </div>
    </div>
</div>
<!-- COMPOSITION -->
<div class="modal fade" id="ModalTambahComposition" tabindex="-1" role="dialog" aria-labelledby="ModalTambahComposition" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <b cass="text-lioght"><i class="ti ti-plus"></i> Tambah Composition</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormTambahComposition">
                <!-- Form Tambah Composition -->
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalInfoComposition" tabindex="-1" role="dialog" aria-labelledby="ModalInfoComposition" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-info-alt"></i> Detail Composition</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <di class="row">
                    <div class="col-md-12" id="FormInfoComposition">
                        <!---- Form Info Composition----->
                    </div>
                </di>
            </div>
            <div class="modal-footer">
                <di class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">
                            <i class="ti ti-close"></i> Tutup
                        </button>
                    </div>
                </di>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalDetailComposition" tabindex="-1" role="dialog" aria-labelledby="ModalDetailComposition" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-info-alt"></i> Detail Composition</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <di class="row">
                    <div class="col-md-12" id="FormDetailComposition">
                        <!---- Form Detail Composition----->
                    </div>
                </di>
            </div>
            <div class="modal-footer">
                <di class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">
                            <i class="ti ti-close"></i> Tutup
                        </button>
                    </div>
                </di>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalEditComposition" tabindex="-1" role="dialog" aria-labelledby="ModalEditComposition" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <b cass="text-dark"><i class="ti ti-pencil-alt"></i> Edit Composition</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormEditComposition">
                
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalHapusComposition" tabindex="-1" role="dialog" aria-labelledby="ModalHapusComposition" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <b cass="text-light">
                    <i class="ti ti-trash"></i> Hapus Composition
                </b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormHapusComposition">
                <!---- Form Hapus Composition----->
            </div>
        </div>
    </div>
</div>
<!-- PROCEDURE -->
<div class="modal fade" id="ModalTambahProcedur" tabindex="-1" role="dialog" aria-labelledby="ModalTambahProcedur" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <b cass="text-lioght"><i class="ti ti-plus"></i> Tambah Procedure</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormTambahProcedure">
                <!-- Form Tambah Procedure -->
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalDetailProcedure" tabindex="-1" role="dialog" aria-labelledby="ModalDetailProcedure" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-info-alt"></i> Detail Procedure</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <di class="row">
                    <div class="col-md-12" id="FormDetailProcedure">
                        <!---- Form Detail Procedure----->
                    </div>
                </di>
            </div>
            <div class="modal-footer">
                <di class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">
                            <i class="ti ti-close"></i> Tutup
                        </button>
                    </div>
                </di>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalEditProcedure" tabindex="-1" role="dialog" aria-labelledby="ModalEditProcedure" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <b cass="text-dark"><i class="ti ti-pencil-alt"></i> Edit Procedure</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormEditProcedure">
                
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalTambahGeneralConsent" tabindex="-1" role="dialog" aria-labelledby="ModalTambahGeneralConsent" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahGeneralConsent">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-plus"></i> Tambah Lembar General Consent</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="FormTambahGeneralConsent">
                    
                </div>
                <div class="modal-footer">
                    <di class="row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">
                                <i class="ti ti-close"></i> Tutup
                            </button>
                        </div>
                    </di>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalEditGeneralConsent" tabindex="-1" role="dialog" aria-labelledby="ModalEditGeneralConsent" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditGeneralConsent">
                <div class="modal-header">
                    <dt cass="text-dark"><i class="ti ti-pencil"></i> Edit General Consent</dt> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormEditGeneralConsent">
                    
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalHapusGeneralConsent" tabindex="-1" role="dialog" aria-labelledby="ModalHapusGeneralConsent" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusGeneralConsent">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-trash"></i> Hapus General Consent</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormHapusGeneralConsent">
                    
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalCetakGeneralConsent" tabindex="-1" role="dialog" aria-labelledby="ModalCetakGeneralConsent" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="_Page/RawatJalan/ProsesCetakGeneralConsent.php" target="_blank" method="GET">
                <div class="modal-header">
                    <dt cass="text-dark"><i class="ti ti-printer"></i> Cetak General Consent</dt> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormCetakGeneralConsent">
                    
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalTandaTanganGeneralConsent" tabindex="-1" role="dialog" aria-labelledby="ModalTandaTanganGeneralConsent" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <dt cass="text-dark"><i class="ti ti-plus"></i> Tanda Tangan General Consent</dt> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormTandaTanganGeneralConsent">
                
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalTambahPrivasi" tabindex="-1" role="dialog" aria-labelledby="ModalTambahPrivasi" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahPrivasiGeneralConsent">
                <div class="modal-header">
                    <dt cass="text-dark"><i class="ti ti-plus"></i> Tambah Privasi General Consent</dt> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormTambahPrivasiGeneralConsent">
                    
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalEditPrivasi" tabindex="-1" role="dialog" aria-labelledby="ModalEditPrivasi" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditPrivasiGeneralConsent">
                <div class="modal-header">
                    <dt cass="text-dark"><i class="ti ti-pencil"></i> Edit Privasi General Consent</dt> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormEditPrivasiGeneralConsent">
                    
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalHapusPrivasi" tabindex="-1" role="dialog" aria-labelledby="ModalHapusPrivasi" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusPrivasiGeneralConsent">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-trash"></i> Hapus Privasi General Consent</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormHapusPrivasiGeneralConsent">
                    
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalTambahPenerimaInformasi" tabindex="-1" role="dialog" aria-labelledby="ModalTambahPenerimaInformasi" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahPenerimaInformasi">
                <div class="modal-header">
                    <dt cass="text-dark"><i class="ti ti-plus"></i> Tambah Penerima Informasi</dt> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormTambahPenerimaInformasi">
                    
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalEditPenerimaInformasi" tabindex="-1" role="dialog" aria-labelledby="ModalEditPenerimaInformasi" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditPenerimaInformasi">
                <div class="modal-header">
                    <dt cass="text-dark"><i class="ti ti-pencil"></i> Edit Penerima Informasi</dt> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormEditPenerimaInformasi">
                    
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalHapusPenerimaInformasi" tabindex="-1" role="dialog" aria-labelledby="ModalHapusPenerimaInformasi" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusPenerimaInformasiGeneralConsent">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-trash"></i> Hapus Penerima Informasi</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormHapusPenerimaInformasi">
                    
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalTambahTriaseDanIgd" tabindex="-1" role="dialog" aria-labelledby="ModalTambahTriaseDanIgd" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahTriaseDanIgd">
                <div class="modal-header">
                    <dt cass="text-dark"><i class="ti ti-plus"></i> Tambah Informasi Triase Dan IGD</dt> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormTambahTriaseDanIgd">
                    
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalEditTriaseDanIgd" tabindex="-1" role="dialog" aria-labelledby="ModalEditTriaseDanIgd" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditTriaseDanIgd">
                <div class="modal-header">
                    <dt cass="text-dark"><i class="ti ti-pencil"></i> Edit Informasi Triase Dan IGD</dt> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormEditTriaseDanIgd">
                    
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalHapusTriaseIgd" tabindex="-1" role="dialog" aria-labelledby="ModalHapusTriaseIgd" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusTriaseIgd">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-trash"></i> Hapus Triase IGD</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormHapusTriaseIgd">
                    
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalCetakTriaseIgd" tabindex="-1" role="dialog" aria-labelledby="ModalCetakTriaseIgd" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="_Page/RawatJalan/ProsesCetakTriaseIgd.php" target="_blank" method="GET">
                <div class="modal-header">
                    <dt cass="text-dark"><i class="ti ti-printer"></i> Cetak Triase IGD</dt> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormCetakTriaseIgd">
                    
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalTambahAnamnesis" tabindex="-1" role="dialog" aria-labelledby="ModalTambahAnamnesis" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahAnamnesis">
                <div class="modal-header">
                    <dt cass="text-dark"><i class="ti ti-plus"></i> Tambah Anamnesis</dt> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormTambahAnamnesis">
                    
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalEditRichText" tabindex="-1" role="dialog" aria-labelledby="ModalEditRichText" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditRichText">
                <div class="modal-header">
                    <dt cass="text-dark"><i class="ti ti-plus"></i> Ubah Anamnesis</dt> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormRichText">

                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalEditRiwayaAlergi" tabindex="-1" role="dialog" aria-labelledby="ModalEditRiwayaAlergi" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditRiwayaAlergi">
                <div class="modal-header">
                    <dt cass="text-dark"><i class="ti ti-plus"></i> Ubah Anamnesis</dt> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormEditRiwayaAlergi">

                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalEditAnamnesis" tabindex="-1" role="dialog" aria-labelledby="ModalEditAnamnesis" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditAnamnesis">
                <div class="modal-header">
                    <dt cass="text-dark"><i class="ti ti-plus"></i> Ubah Anamnesis</dt> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormEditAnamnesis">

                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalCetakAnamnesis" tabindex="-1" role="dialog" aria-labelledby="ModalCetakAnamnesis" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="_Page/RawatJalan/ProsesCetakAnamnesis.php" target="_blank" method="GET">
                <div class="modal-header">
                    <dt cass="text-dark"><i class="ti ti-printer"></i> Cetak Anamnesis</dt> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormCetakAnamnesis">
                    
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalHapusAnamnesis" tabindex="-1" role="dialog" aria-labelledby="ModalHapusAnamnesis" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusAnamnesis">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-trash"></i> Hapus Anamnesis</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormHapusAnamnesis">
                    
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalEditAnatomi" tabindex="-1" role="dialog" aria-labelledby="ModalEditAnatomi" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditAnatomi">
                <div class="modal-header">
                    <dt cass="text-dark"><i class="ti ti-plus"></i> Ubah Pemeriksaan Anatomi</dt> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormEditAnatomi">

                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalHapusAnatomi" tabindex="-1" role="dialog" aria-labelledby="ModalHapusAnatomi" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusAnatomi">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-trash"></i> Hapus Pemeriksaan Anatomi</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormHapusAnatomi">
                    <!-- Form Hapus Anatomi -->
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalEditPemeriksaanFisikUmum" tabindex="-1" role="dialog" aria-labelledby="ModalEditPemeriksaanFisikUmum" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditPemeriksaanFisikUmum">
                <div class="modal-header">
                    <dt cass="text-dark"><i class="ti ti-pencil"></i> Ubah Pemeriksaan Fisik</dt> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormEditPemeriksaanFisikUmum">

                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalEditTandaVitalPemeriksaanDasar" tabindex="-1" role="dialog" aria-labelledby="ModalEditTandaVitalPemeriksaanDasar" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditTandaVitalPemeriksaanDasar">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-plus"></i> Tanda Vital</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormEditTandaVitalPemeriksaanDasar">
                    
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalTambahPemeriksaanDasar" tabindex="-1" role="dialog" aria-labelledby="ModalTambahPemeriksaanDasar" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahPemeriksaanDasar">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-plus"></i> Tambah Sesi Pemeriksaan Fisik</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormTambahPemeriksaanDasar">
                    
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalEditPemeriksaanDasar" tabindex="-1" role="dialog" aria-labelledby="ModalEditPemeriksaanDasar" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditPemeriksaanDasar">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-pencil"></i> Edit Pemeriksaan Fisik</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormEditPemeriksaanDasar">
                    
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalHapusPemeriksaanDasar" tabindex="-1" role="dialog" aria-labelledby="ModalHapusPemeriksaanDasar" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusPemeriksaanDasar">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-trash"></i> Hapus Pemeriksaan Fisik</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormHapusPemeriksaanDasar">
                    
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalCetakPemeriksaanDasar" tabindex="-1" role="dialog" aria-labelledby="ModalCetakPemeriksaanDasar" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="_Page/RawatJalan/ProsesCetakPemeriksaanFisik.php" method="GET" target="_blank">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-printer"></i> Cetak Pemeriksaan Fisik</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormCetakPemeriksaanDasar">
                    
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalTambahPsikosos" tabindex="-1" role="dialog" aria-labelledby="ModalTambahPsikosos" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahPsikosos">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-plus"></i> Tambah Psiko Sosial</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormTambahPsikosos">
                    
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalEditPsikosos" tabindex="-1" role="dialog" aria-labelledby="ModalEditPsikosos" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditPsikosos">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-pencil-alt"></i> Edit Psiko Sosial</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormEditPsikosos">
                    
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalHapusPsikosos" tabindex="-1" role="dialog" aria-labelledby="ModalHapusPsikosos" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusPsikosos">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-trash"></i> Hapus Psiko Sosial</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormHapusPsikosos">
                    
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalCetakPsikosos" tabindex="-1" role="dialog" aria-labelledby="ModalCetakPsikosos" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="_Page/RawatJalan/ProsesCetakPsikosos.php" method="GET" target="_blank">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-printer"></i> Cetak Psiko Sosial</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormCetakPsikosos">
                    
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalTambahScreening" tabindex="-1" role="dialog" aria-labelledby="ModalTambahScreening" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahScreening">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-plus"></i> Tambah Screening</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormTambahScreening">
                    
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalEditScreening" tabindex="-1" role="dialog" aria-labelledby="ModalEditScreening" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditScreening">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-pencil-alt"></i> Edit Screening</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormEditScreening">
                    
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalHapusScreening" tabindex="-1" role="dialog" aria-labelledby="ModalHapusScreening" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusScreening">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-trash"></i> Hapus Screening</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormHapusScreening">
                    
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalCetakScreening" tabindex="-1" role="dialog" aria-labelledby="ModalCetakScreening" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="_Page/RawatJalan/ProsesCetakScreening.php" method="GET" target="_blank">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-printer"></i> Cetak Screening</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormCetakScreening">
                    
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalTambahDiagnosa" tabindex="-1" role="dialog" aria-labelledby="ModalTambahDiagnosa" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahDiagnosa">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-plus"></i> Tambah Diagnosa</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormTambahDiagnosa">
                    
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalInfoDiagnosa" tabindex="-1" role="dialog" aria-labelledby="ModalInfoDiagnosa" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-info-alt"></i> Info Diagnosa</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="FormInfoDiagnosa">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalEditDiagnosa" tabindex="-1" role="dialog" aria-labelledby="ModalEditDiagnosa" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditDiagnosa">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-pencil-alt"></i> Edit Diagnosa</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormEditDiagnosa">
                    
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalHapusDiagnosa" tabindex="-1" role="dialog" aria-labelledby="ModalHapusDiagnosa" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusDiagnosa">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-trash"></i> Hapus Diagnosa</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormHapusDiagnosa">
                    
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalTambahPersetujuanTindakan" tabindex="-1" role="dialog" aria-labelledby="ModalTambahPersetujuanTindakan" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahPersetujuanTindakan">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-plus"></i> Tambah Persetujuan/Penolakan Tindakan</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormTambahPersetujuanTindakan">
                    
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalEditPersetujuanTindakan" tabindex="-1" role="dialog" aria-labelledby="ModalEditPersetujuanTindakan" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditPersetujuanTindakan">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-pencil-alt"></i> Edit Persetujuan Tindakan</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormEditPersetujuanTindakan">
                    
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalHapusPersetujuanTindakan" tabindex="-1" role="dialog" aria-labelledby="ModalHapusPersetujuanTindakan" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusPersetujuanTindakan">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-trash"></i> Hapus Persetujuan Tindakan</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormHapusPersetujuanTindakan">
                    
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalCetakPersetujuanTindakan" tabindex="-1" role="dialog" aria-labelledby="ModalCetakPersetujuanTindakan" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="_Page/RawatJalan/ProsesCetakPersetujuanTindakan.php" method="GET" target="_blank">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-printer"></i> Cetak Persetujuan Tindakan</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormCetakPersetujuanTindakan">
                    
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalTambahTindakan" tabindex="-1" role="dialog" aria-labelledby="ModalTambahTindakan" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahTindakan">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-plus"></i> Tambah Tindakan</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormTambahTindakan">
                    
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalInfoTindakan" tabindex="-1" role="dialog" aria-labelledby="ModalInfoTindakan" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-info-alt"></i> Info Tindakan</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormInfoTindakan">
                
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalEditTindakan" tabindex="-1" role="dialog" aria-labelledby="ModalEditTindakan" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditTindakan">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-pencil-alt"></i> Edit Tindakan</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormEditTindakan">
                    
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalCetakTindakan" tabindex="-1" role="dialog" aria-labelledby="ModalCetakTindakan" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="_Page/RawatJalan/ProsesCetakTindakan.php" method="GET" target="_blank">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-printer"></i> Cetak Tindakan</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormCetakTindakan">
                    
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalHapusTindakan" tabindex="-1" role="dialog" aria-labelledby="ModalHapusTindakan" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusTindakan">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-trash"></i> Hapus Tindakan</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormHapusTindakan">
                    
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalTambahResep" tabindex="-1" role="dialog" aria-labelledby="ModalTambahResep" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahResep">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-plus"></i> Tambah Resep</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormTambahResep">
                    
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalTambahObatResep" tabindex="-1" role="dialog" aria-labelledby="ModalTambahObatResep" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahObatResep" autocomplete="off">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-plus"></i> Tambah Obat Resep</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormTambahObatResep">
                    
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalInfoObatResep" tabindex="-1" role="dialog" aria-labelledby="ModalInfoObatResep" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-info-alt"></i> Info Resep Obat</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="FormInfoObatResep">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalHapusObatResep" tabindex="-1" role="dialog" aria-labelledby="ModalHapusObatResep" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusObatResep">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-trash"></i> Hapus Obat</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormHapusObatResep">
                    
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalEditObatResep" tabindex="-1" role="dialog" aria-labelledby="ModalEditObatResep" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditObatResep" autocomplete="off">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-pencil-alt"></i> Edit Obat Resep</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormEditObatResep">
                    
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalEditCatatanResep" tabindex="-1" role="dialog" aria-labelledby="ModalEditCatatanResep" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditCatatanResep" autocomplete="off">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-pencil-alt"></i> Edit Catatan Resep</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormEditCatatanResep">
                    
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalPengkajianResep" tabindex="-1" role="dialog" aria-labelledby="ModalPengkajianResep" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesPengkajianResep" autocomplete="off">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-pencil-alt"></i> Edit Pengkajian Resep</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormPengkajianResep">
                    
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalStatusResep" tabindex="-1" role="dialog" aria-labelledby="ModalStatusResep" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesStatusResep" autocomplete="off">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-pencil-alt"></i> Edit Pengkajian Resep</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormStatusResep">
                    
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalEditResep" tabindex="-1" role="dialog" aria-labelledby="ModalEditResep" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditResep">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-pencil"></i> Edit Resep</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormEditResep">
                    
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalHapusResep" tabindex="-1" role="dialog" aria-labelledby="ModalHapusResep" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusResep">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-trash"></i> Hapus Resep</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormHapusResep">
                    
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalCetakResep" tabindex="-1" role="dialog" aria-labelledby="ModalCetakResep" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="_Page/RawatJalan/ProsesCetakResep.php" method="GET" target="_blank">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-printer"></i> Cetak Resep</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormCetakResep">
                    
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalTambahRiwayatObat" tabindex="-1" role="dialog" aria-labelledby="ModalTambahRiwayatObat" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahRiwayatObat" autocomplete="off">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-plus"></i> Tambah Penggunaan Obat</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormTambahRiwayatObat">
                    
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalInfoRiwayatObat" tabindex="-1" role="dialog" aria-labelledby="ModalInfoRiwayatObat" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-info-alt"></i> Info Penggunaan Obat</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="FormInfoRiwayatObat">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalEditRiwayatObat" tabindex="-1" role="dialog" aria-labelledby="ModalEditRiwayatObat" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditRiwayatObat" autocomplete="off">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-pencil-alt"></i> Edit Penggunaan Obat</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormEditRiwayatObat">
                    
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalHapusRiwayatObat" tabindex="-1" role="dialog" aria-labelledby="ModalHapusRiwayatObat" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusRiwayatObat">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-trash"></i> Hapus Resep</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormHapusRiwayatObat">
                    
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalCetakRiwayatObat" tabindex="-1" role="dialog" aria-labelledby="ModalCetakRiwayatObat" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="_Page/RawatJalan/ProsesCetakRiwayatPenggunaanObat.php" method="GET" target="_blank">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-printer"></i> Cetak Penggunaan Obat</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormCetakRiwayatObat">
                    
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalTulisPerencanaanPasien" tabindex="-1" role="dialog" aria-labelledby="ModalTulisPerencanaanPasien" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTulisPerencanaanPasien" autocomplete="off">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-pencil-alt"></i> Catat Perencanaan Pasien</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormTulisPerencanaanPasien">
                    
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalHapusPerencanaan" tabindex="-1" role="dialog" aria-labelledby="ModalHapusPerencanaan" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusPerencanaan">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-trash"></i> Hapus Resep</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormHapusPerencanaan">
                    
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalCetakPerencanaan" tabindex="-1" role="dialog" aria-labelledby="ModalCetakPerencanaan" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="_Page/RawatJalan/ProsesCetakPerencanaan.php" method="GET" target="_blank">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-printer"></i> Cetak Penggunaan Obat</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormCetakPerencanaan">
                    
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalTambahKonsuiltasi" tabindex="-1" role="dialog" aria-labelledby="ModalTambahKonsuiltasi" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahKonsuiltasi" autocomplete="off">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-plus"></i> Tambah Konsultasi</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormTambahKonsuiltasi">
                    
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalPermintaanKonsultasi" tabindex="-1" role="dialog" aria-labelledby="ModalPermintaanKonsultasi" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesPermintaanKonsuiltasi" autocomplete="off">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-pencil"></i> Permintaan Konsultasi</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormPermintaanKonsultasi">
                    
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalJawabanKonsultasi" tabindex="-1" role="dialog" aria-labelledby="ModalJawabanKonsultasi" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesJawabanKonsultasi" autocomplete="off">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-pencil"></i> Jawaban Konsultasi</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormJawabanKonsultasi">
                    
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalHapusKonsultasi" tabindex="-1" role="dialog" aria-labelledby="ModalHapusKonsultasi" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusKonsultasi">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-trash"></i> Hapus Konsultasi</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormHapusKonsultasi">
                    
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalCetakKonsultasi" tabindex="-1" role="dialog" aria-labelledby="ModalCetakKonsultasi" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="_Page/RawatJalan/ProsesCetakKonsultasi.php" method="GET" target="_blank">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-printer"></i> Cetak Penggunaan Obat</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormCetakKonsultasi">
                    
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalEditKonsultasi" tabindex="-1" role="dialog" aria-labelledby="ModalEditKonsultasi" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditKonsultasi" autocomplete="off">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-plus"></i> Edit Konsultasi</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormEditKonsultasi">
                    
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalKelolaEdukasi" tabindex="-1" role="dialog" aria-labelledby="ModalKelolaEdukasi" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-layers"></i> Kelola Edukasi</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormKelolaEdukasi">
                
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalEditEdukasi" tabindex="-1" role="dialog" aria-labelledby="ModalEditEdukasi" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-pencil"></i> Edit Edukasi</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormKonfirmasiEditEdukasi">
                
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalHapusEdukasi" tabindex="-1" role="dialog" aria-labelledby="ModalHapusEdukasi" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusEdukasi">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-trash"></i> Hapus Edukasi</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormHapusEdukasi">
                    
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalCetakEdukasiParsial" tabindex="-1" role="dialog" aria-labelledby="ModalCetakEdukasiParsial" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="_Page/RawatJalan/ProsesCetakEdukasiParsial.php" method="GET" target="_blank">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-printer"></i> Cetak Edukasi Pasien</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormCetakEdukasiParsial">
                    
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalCetakEdukasiAll" tabindex="-1" role="dialog" aria-labelledby="ModalCetakEdukasiAll" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="_Page/RawatJalan/ProsesCetakEdukasiAll.php" method="GET" target="_blank">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-printer"></i> Cetak Edukasi Pasien</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormCetakEdukasiAll">
                    
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalKelolaCppt" tabindex="-1" role="dialog" aria-labelledby="ModalKelolaCppt" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-layers"></i> Kelola CPPT</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormKelolaCppt">
                
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalCariDokter" tabindex="-1" role="dialog" aria-labelledby="ModalCariDokter" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-search"></i> Cari Dokter DPJP</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0);" id="ProsesCariDokter" autocomplete="off">
                    <div class="row">
                        <div class="col-md-12 input-group">
                            <input type="text" id="KeywordPencarianDokterBpjp" name="KeywordPencarianDokterBpjp" class="form-control" placeholder="Nama Dokter">
                            <button type="submit" class="btn btn-sm btn-outline-dark">
                                <i class="ti-search"></i> Cari
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 pre-scrollable">
                            <ol class="list-group list-group-numbered" id="HasilPencarianDokterDpjp">
                            </ol>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                            <i class="ti-close"></i> Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalCariNakesCppt" tabindex="-1" role="dialog" aria-labelledby="ModalCariNakesCppt" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-search"></i> Cari Dokter DPJP</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0);" id="ProsesCariNakes" autocomplete="off">
                    <div class="row">
                        <div class="col-md-12 input-group">
                            <input type="text" id="KeywordCariNakes" name="KeywordCariNakes" class="form-control" placeholder="Kata Kunci">
                            <button type="submit" class="btn btn-sm btn-outline-dark">
                                <i class="ti-search"></i> Cari
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 pre-scrollable">
                            <ol class="list-group list-group-numbered" id="HasilPencarianNakesCppt">
                            </ol>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                            <i class="ti-close"></i> Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalCariReferensiSoap" tabindex="-1" role="dialog" aria-labelledby="ModalCariReferensiSoap" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-search"></i> Referensi SOAP</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body accordion-block" id="FormCariReferensiSoap">
                
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                            <i class="ti-close"></i> Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalHapusCppt" tabindex="-1" role="dialog" aria-labelledby="ModalHapusCppt" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusCppt">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-trash"></i> Hapus Edukasi</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormHapusCppt">
                    
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalCetakCpptParsial" tabindex="-1" role="dialog" aria-labelledby="ModalCetakCpptParsial" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="_Page/RawatJalan/ProsesCetakCpptParsial.php" method="GET" target="_blank">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-printer"></i> Cetak CPPT</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormCetakCpptParsial">
                    <!-- Form Cetak CPPT -->
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalCetakCpptAll" tabindex="-1" role="dialog" aria-labelledby="ModalCetakCpptAll" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="_Page/RawatJalan/ProsesCetakCpptAll.php" method="GET" target="_blank">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-printer"></i> Cetak CPPT</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormCetakCpptAll">
                    <!-- Form Cetak CPPT -->
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalEditCppt" tabindex="-1" role="dialog" aria-labelledby="ModalEditCppt" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-pencil"></i> Edit CPPT</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormEditCppt">
                
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalKelolaOperasi" tabindex="-1" role="dialog" aria-labelledby="ModalKelolaOperasi" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-info"></i> Konfirmasi Kelola Operasi</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormKelolaOperasi"></div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalCariJadwalOperasi" tabindex="-1" role="dialog" aria-labelledby="ModalCariJadwalOperasi" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahIdJadwalOperasi">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-info"></i> Cari Jadwal Operasi</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 pre-scrollable">
                            <ol class="list-group list-group-numbered" id="ListJadwalOperasi">
                                
                            </ol>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="ti ti-plus"></i> Tambahkan
                    </button>
                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">
                        <i class="ti ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalTambahNakesOperasi" tabindex="-1" role="dialog" aria-labelledby="ModalTambahNakesOperasi" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahNakesOperasi">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-plus"></i> Tambah Nakes Operasi</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-4"><label for="kategori_nakes_operasi">Kategori Nakes</label></div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="kategori_nakes_operasi" id="kategori_nakes_operasi" list="ListKategoriNakesOperasi">
                            <datalist id="ListKategoriNakesOperasi">
                                <option value="Dokter Bedah">
                                <option value="Dokter Spesialis">
                                <option value="Dokter Anastesi">
                                <option value="Perawat">
                                <option value="Bidan">
                            </datalist>
                            <small>Dokter, Perawat, Bidan Atau Lainnya</small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4"><label for="nama_nakes_operasi">Nama Nakes</label></div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="nama_nakes_operasi" id="nama_nakes_operasi">
                            <small>Sesuai dengan identitas</small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4"><label for="sip_nakes_operasi">SIP Nakes</label></div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="sip_nakes_operasi" id="sip_nakes_operasi">
                            <small>
                                <span class="text-danger">*</span> Isi Apabila Kategori Nakes Adalah Dokter
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4"><label for="kontak_nakes_operasi">Kontak Nakes</label></div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="kontak_nakes_operasi" id="kontak_nakes_operasi" placeholder="62">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4"><label for="kategori_identitas_nakes_operasi">Kategori Identitas</label></div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="kategori_identitas_nakes_operasi" id="kategori_identitas_nakes_operasi">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4"><label for="nomor_identitas_nakes_operasi">Nomor Identitas</label></div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="nomor_identitas_nakes_operasi" id="nomor_identitas_nakes_operasi">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12" id="NotifikasiTambahNakesOperasi">
                            <span class="text-primary">Pastikan Informasi Nakes Operasi Sudah Lengkap Dan Benar!</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary mr-3">
                        <i class="ti ti-plus"></i> Tambahkan
                    </button>
                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">
                        <i class="ti ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalHapusNakesOperasi" tabindex="-1" role="dialog" aria-labelledby="ModalHapusNakesOperasi" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-trash"></i> Hapus Nakes Operasi</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mt-2 mb-2"> 
                    <div class="col-md-12 text-center">
                        <img src="assets/images/question.gif" alt="" width="70%">
                    </div>
                </div>
                <div class="row mt-2 mb-2"> 
                    <div class="col-md-12 text-center text-danger">
                        <span id="NotifikasiHapusTriaseIgd">
                            Apakah anda yakin akan menghapus nakes pada list ini?
                        </span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-primary mr-3" id="KonfirmasiHapusNakesOperasi">
                    <i class="ti ti-save"></i> Ya, Hapus
                </button>
                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalTambahDiagnosaOperasi" tabindex="-1" role="dialog" aria-labelledby="ModalTambahDiagnosaOperasi" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="PencarianDiagnosaOperasi">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-plus"></i> Tambah Diagnosa Operasi</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-md-4"><label for="kategori_diagnosa">Kategori Diagnosa</label></div>
                        <div class="col-md-8">
                            <ul>
                                <li>
                                    <input type="radio" checked name="kategori_diagnosa" id="kategori_diagnosa1" value="Diagnosa Pre Operatif">
                                    <label for="kategori_diagnosa1">Diagnosa Pre Operatif</label>
                                </li>
                                <li>
                                    <input type="radio" name="kategori_diagnosa" id="kategori_diagnosa2" value="Diagnosa Post Operatif">
                                    <label for="kategori_diagnosa2">Diagnosa Post Operatif</label>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4"><label for="referensi_diagnosa_operasi">Referensi Diagnosa</label></div>
                        <div class="col-md-8">
                            <ul>
                                <li>
                                    <input type="radio" checked name="referensi_diagnosa_operasi" id="referensi_diagnosa_operasi2" value="SIMRS">
                                    <label for="referensi_diagnosa_operasi2">SIMRS</label>
                                </li>
                                <li>
                                    <input type="radio" name="referensi_diagnosa_operasi" id="referensi_diagnosa_operasi1" value="BPJS">
                                    <label for="referensi_diagnosa_operasi1">BPJS</label>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-12 input-group">
                            <input type="text" class="form-control" name="keyword_diagnosa_operasi" id="keyword_diagnosa_operasi" placeholder="Kode/Deskripsi Diagnosa">
                            <button type="submit" class="btn btn-sm btn-outline-secondary">
                                <i class="ti ti-search"></i> Cari
                            </button>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-12 pre-scrollable">
                            <ul class="list-group" id="HasilPencarianDiagnosaOperasi">
                                <li>Silahkan lakukan pencarian diagnosa!</li>
                            </ul>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-12" id="NotifikasiTambahkanDiagnosaOperasi">
                            <span class="text-primary">Pastikan anda sudah memilih diagnosa operasi.</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" id="TambahkanDiagnosaOperasi">
                        <i class="ti ti-plus"></i> Tambahkan
                    </button>
                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">
                        <i class="ti ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalHapusDiagnosaOperasi" tabindex="-1" role="dialog" aria-labelledby="ModalHapusDiagnosaOperasi" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-trash"></i> Hapus Diagnosa Operasi</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mt-2 mb-2"> 
                    <div class="col-md-12 text-center">
                        <img src="assets/images/question.gif" alt="" width="70%">
                    </div>
                </div>
                <div class="row mt-2 mb-2"> 
                    <div class="col-md-12 text-center text-danger">
                        <span>Apakah anda yakin akan menghapus Diagnosa pada list ini?</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-primary mr-3" id="KonfirmasiHapusDiagnosaOperasi">
                    <i class="ti ti-save"></i> Ya, Hapus
                </button>
                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalTambahBodySiteOperasi" tabindex="-1" role="dialog" aria-labelledby="ModalTambahBodySiteOperasi" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahBodySite">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-plus"></i> Tambah Body Site</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="body_site_operasi">Body Site</label>
                            <input type="text" name="body_site_operasi" id="body_site_operasi" list="ListBodySiteOperasi" class="form-control">
                            <small>Referensi Dari Snomed CT</small>
                            <datalist id="ListBodySiteOperasi"></datalist>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="keterangan_body_site">Keterangan</label>
                            <textarea class="form-control" name="keterangan_body_site" id="keterangan_body_site"></textarea>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-12" id="NotifikasiTambahBodySiteOperasi">
                            <span class="text-primary">Pastikan informasi body site sudah sesuai</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="ti ti-plus"></i> Tambahkan
                    </button>
                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">
                        <i class="ti ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalHapusBodySiteOperasi" tabindex="-1" role="dialog" aria-labelledby="ModalHapusBodySiteOperasi" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-trash"></i> Hapus Body Site Operasi</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mt-2 mb-2"> 
                    <div class="col-md-12 text-center">
                        <img src="assets/images/question.gif" alt="" width="70%">
                    </div>
                </div>
                <div class="row mt-2 mb-2"> 
                    <div class="col-md-12 text-center text-danger">
                        <span>Apakah anda yakin akan menghapus body site pada list ini?</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-primary mr-3" id="KonfirmasiHapusBodySiteOperasi">
                    <i class="ti ti-save"></i> Ya, Hapus
                </button>
                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalTambahTindakanOperasi" tabindex="-1" role="dialog" aria-labelledby="ModalTambahTindakanOperasi" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesCariTindakanOperasi">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-plus"></i> Tambah Tindakan Operasi</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-md-4"><label for="referensi_tindakan_operasi">Referensi Tindakan</label></div>
                        <div class="col-md-8">
                            <ul>
                                <li>
                                    <input type="radio" checked name="referensi_tindakan_operasi" id="referensi_tindakan_operasi1" value="SIMRS">
                                    <label for="referensi_tindakan_operasi1">SIMRS</label>
                                </li>
                                <li>
                                    <input type="radio" name="referensi_tindakan_operasi" id="referensi_tindakan_operasi2" value="BPJS">
                                    <label for="referensi_tindakan_operasi2">BPJS</label>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-12 input-group">
                            <input type="text" class="form-control" name="keyword_tindakan_operasi" id="keyword_tindakan_operasi" placeholder="Kode/Deskripsi Tindakan">
                            <button type="submit" class="btn btn-sm btn-outline-secondary">
                                <i class="ti ti-search"></i> Cari
                            </button>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-12 pre-scrollable">
                            <ul class="list-group" id="HasilPencarianTindakanOperasi">
                                <li>Silahkan lakukan pencarian tindakan!</li>
                            </ul>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-12" id="NotifikasiTambahkanTindakanOperasi">
                            <span class="text-primary">Pastikan anda sudah memilih tindakan operasi.</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" id="TambahkanTindakanOperasi">
                        <i class="ti ti-plus"></i> Tambahkan
                    </button>
                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">
                        <i class="ti ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalHapusTindakanOperasi" tabindex="-1" role="dialog" aria-labelledby="ModalHapusTindakanOperasi" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-trash"></i> Hapus Tindakan Operasi</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mt-2 mb-2"> 
                    <div class="col-md-12 text-center">
                        <img src="assets/images/question.gif" alt="" width="70%">
                    </div>
                </div>
                <div class="row mt-2 mb-2"> 
                    <div class="col-md-12 text-center text-danger">
                        <span>Apakah anda yakin akan menghapus tindakan pada list ini?</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-primary mr-3" id="KonfirmasiHapusTindakanOperasi">
                    <i class="ti ti-save"></i> Ya, Hapus
                </button>
                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalTambahInstrumenOperasi" tabindex="-1" role="dialog" aria-labelledby="ModalTambahInstrumenOperasi" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahInstrumenOperasi">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-plus"></i> Tambah Instrumen Operasi</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-md-12">
                            <label for="InstrumenOperasi">Instrumen Operasi</label>
                            <input type="text" class="form-control" name="InstrumenOperasi" id="InstrumenOperasi" placeholder="Nama Instrumen">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="ti ti-plus"></i> Tambahkan
                    </button>
                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">
                        <i class="ti ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalHapusInstrumenOperasi" tabindex="-1" role="dialog" aria-labelledby="ModalHapusInstrumenOperasi" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-trash"></i> Hapus Instrumen Operasi</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mt-2 mb-2"> 
                    <div class="col-md-12 text-center">
                        <img src="assets/images/question.gif" alt="" width="70%">
                    </div>
                </div>
                <div class="row mt-2 mb-2"> 
                    <div class="col-md-12 text-center text-danger">
                        <span>Apakah anda yakin akan menghapus instrumen operasi pada list ini?</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-primary mr-3" id="KonfirmasiHapusInstrumenOperasi">
                    <i class="ti ti-save"></i> Ya, Hapus
                </button>
                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalTambahKeteranganDokter" tabindex="-1" role="dialog" aria-labelledby="ModalTambahKeteranganDokter" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahKeteranganDokter">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-plus"></i> Tambah Keterangan Dokter</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-md-12">
                            <label for="NamaKeteranganDokterOperasi">Nama Dokter</label>
                            <input type="text" name="NamaKeteranganDokterOperasi" id="NamaKeteranganDokterOperasi" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-12">
                            <label for="KeteranganDokterOperasi">Keterangan Dokter</label>
                            <textarea name="KeteranganDokterOperasi" id="KeteranganDokterOperasi" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="ti ti-plus"></i> Tambahkan
                    </button>
                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">
                        <i class="ti ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalHapusKeteranganDokterOperasi" tabindex="-1" role="dialog" aria-labelledby="ModalHapusKeteranganDokterOperasi" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-trash"></i> Hapus Keterangan Dokter</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mt-2 mb-2"> 
                    <div class="col-md-12 text-center">
                        <img src="assets/images/question.gif" alt="" width="70%">
                    </div>
                </div>
                <div class="row mt-2 mb-2"> 
                    <div class="col-md-12 text-center text-danger">
                        <span>Apakah anda yakin akan menghapus keterangan dokter pada list ini?</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-primary mr-3" id="KonfirmasiHapusTindakanDokterOperasi">
                    <i class="ti ti-save"></i> Ya, Hapus
                </button>
                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalHapusOperasi" tabindex="-1" role="dialog" aria-labelledby="ModalHapusOperasi" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusOperasi">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-trash"></i> Hapus Operasi</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormHapusOperasi">
                    <!-- Form Hapus Operasi -->
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalCetakOperasi" tabindex="-1" role="dialog" aria-labelledby="ModalCetakOperasi" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="_Page/RawatJalan/ProsesCetakOperasi.php" method="GET" target="_blank">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-printer"></i> Cetak Operasi</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormCetakOperasi">
                    <!-- Form Cetak Operasi -->
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalKonfirmasiBuatResume" tabindex="-1" role="dialog" aria-labelledby="ModalKonfirmasiBuatResume" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-pencil"></i> Konfirmasi Buat Resume</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormKonfirmasiBuatResume"></div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalCariDokterResume" tabindex="-1" role="dialog" aria-labelledby="ModalCariDokterResume" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-search"></i> Cari Dokter DPJP</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0);" id="ProsesCariDokterResume" autocomplete="off">
                    <div class="row">
                        <div class="col-md-12 input-group">
                            <input type="text" id="KeywordPencarianDokterResume" name="KeywordPencarianDokterResume" class="form-control" placeholder="Nama Dokter">
                            <button type="submit" class="btn btn-sm btn-outline-dark">
                                <i class="ti-search"></i> Cari
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 pre-scrollable">
                            <ol class="list-group list-group-numbered" id="HasilPencarianDokterResume">
                            </ol>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                            <i class="ti-close"></i> Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalCariSuratKontrol" tabindex="-1" role="dialog" aria-labelledby="ModalCariSuratKontrol" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-search"></i> Cari Surat Kontrol</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0);" id="ProsesCariSuratKontrol" autocomplete="off">
                    <div class="row">
                        <div class="col-md-6">
                            <input type="date" id="tanggal_kontrol" name="tanggal_kontrol" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                        </div>
                        <div class="col-md-6 input-group">
                            <input type="text" id="KeywordNomorKartuCariSuratKontrol" name="KeywordNomorKartuCariSuratKontrol" class="form-control">
                            <button type="submit" class="btn btn-sm btn-outline-dark">
                                <i class="ti-search"></i> Cari
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 pre-scrollable" id="HasilPencarianSuratKontrol">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalHapusResume" tabindex="-1" role="dialog" aria-labelledby="ModalHapusResume" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusResume">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-trash"></i> Hapus Resume</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormHapusResume">
                    <!-- Form Hapus Resume -->
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalCetakResume" tabindex="-1" role="dialog" aria-labelledby="ModalCetakResume" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="_Page/RawatJalan/ProsesCetakResume.php" method="GET" target="_blank">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-printer"></i> Cetak Resume</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormCetakResume">
                    <!-- Form Cetak Resume -->
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalKelolaLaboratorium" tabindex="-1" role="dialog" aria-labelledby="ModalKelolaLaboratorium" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-plus"></i> Permintaan Laboratorium</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormPermintaanLaboratorium">
                <!-- Form Permintaan Laboratorium -->
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalDetailPemeriksaanLab" tabindex="-1" role="dialog" aria-labelledby="ModalDetailPemeriksaanLab" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-info-alt"></i> Detail Pemeriksaan Laboratorium</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormDetailPemeriksaanLab">
                <!-- Form Detail Permintaan Laboratorium -->
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalPemeriksaanRadiologi" tabindex="-1" role="dialog" aria-labelledby="ModalPemeriksaanRadiologi" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-plus"></i> Pemeriksaan Radiologi</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormPemeriksaanRadiologi">
                <!-- Form Pemeriksaan Radiologi -->
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalDetailPemeriksaanRadiologi" tabindex="-1" role="dialog" aria-labelledby="ModalDetailPemeriksaanRadiologi" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-info-alt"></i> Detail Pemeriksaan Radiologi</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormDetailPemeriksaanRadiologi">
                <!-- Form Detail Pemeriksaan Radiologi -->
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalKonfirmasiHapusSepDariKunjungan" tabindex="-1" role="dialog" aria-labelledby="ModalKonfirmasiHapusSepDariKunjungan" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusSepDariKunjungan">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-unlink"></i> Hapus SEP Dari Kunjungan</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormHapusSepDariKunjungan">
                    <!-- Form Hapus SEP dari Kunjungan -->
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalKonfirmasiBuatSep" tabindex="-1" role="dialog" aria-labelledby="ModalKonfirmasiBuatSep" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-unlink"></i> Konfirmasi Buat SEP</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormKonfirmasiBuatSep">
                <!-- Form Buat SEP -->
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalKonfirmasiEditSep" tabindex="-1" role="dialog" aria-labelledby="ModalKonfirmasiEditSep" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-pencil"></i> Konfirmasi Edit SEP</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormKonfirmasiEditSep">
                <!-- Form Edit SEP -->
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalKonfirmasiDetailSep" tabindex="-1" role="dialog" aria-labelledby="ModalKonfirmasiDetailSep" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-info-alt"></i> Halaman Detail SEP</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormKonfirmasiDetailSep">
                <!-- Form Konfirmasi Menuju Detail SEP -->
            </div>
        </div>
    </div>
</div>
<!-- ALERGI -->
<div class="modal fade" id="ModalDetailAlergi" tabindex="-1" role="dialog" aria-labelledby="ModalDetailAlergi" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-info-alt"></i> Detail Allergy Intoleranc</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="FormDetailAllergyIntoleranc">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal" aria-label="Close">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalTambahAllergyIntoleranc" tabindex="-1" role="dialog" aria-labelledby="ModalTambahAllergyIntoleranc" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahAllergyIntoleranc">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-plus"></i> Tambah Allergy Intoleranc</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="FormTambahAllergyIntoleranc">

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" id="NotifikasiTambahAllergyIntoleranc">

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="ti ti-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal" aria-label="Close">
                        <i class="ti ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalEditAllergyIntoleranc" tabindex="-1" role="dialog" aria-labelledby="ModalEditAllergyIntoleranc" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditAllergyIntoleranc">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-pencil"></i> Edit Allergy Intoleranc</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="FormEditAllergyIntoleranc">

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" id="NotifikasiEditAllergyIntoleranc">

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="ti ti-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal" aria-label="Close">
                        <i class="ti ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalTambahMedicationRequest" tabindex="-1" role="dialog" aria-labelledby="ModalTambahMedicationRequest" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahMedicationRequest">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-plus"></i> Tambah Medication Request</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="FormTambahMedicationRequest">

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" id="NotifikasiTambahMedicationRequest">

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="ti ti-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal" aria-label="Close">
                        <i class="ti ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalDetailMedication" tabindex="-1" role="dialog" aria-labelledby="ModalDetailMedication" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-info-alt"></i> Detail Medication</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="FormDetailMedication">
                <!-- Detail Medication Disini -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal" aria-label="Close">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalDetailMedicationRequest2" tabindex="-1" role="dialog" aria-labelledby="ModalDetailMedicationRequest2" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-info-alt"></i> Detail Medication Request</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="FormDetailMedicationRequest2">
                <!-- Detail Medication Disini -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal" aria-label="Close">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalEditMedicationRequest" tabindex="-1" role="dialog" aria-labelledby="ModalEditMedicationRequest" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditMedicationRequest">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-pencil"></i> Edit Medication Request</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="FormEditMedicationRequest">

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" id="NotifikasiEditMedicationRequest">

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="ti ti-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal" aria-label="Close">
                        <i class="ti ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalTambahMedicationDispense" tabindex="-1" role="dialog" aria-labelledby="ModalTambahMedicationDispense" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahMedicationDispense">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-plus"></i> Tambah Medication Dispense</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="FormTambahMedicationDispense">

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" id="NotifikasiTambahMedicationDispense">

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="ti ti-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal" aria-label="Close">
                        <i class="ti ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalDetailMedicationDispense" tabindex="-1" role="dialog" aria-labelledby="ModalDetailMedicationDispense" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-info-alt"></i> Detail Medication Dispense</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12" id="FormDetailMedicationDispense">

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal" aria-label="Close">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalEditMedicationDispense" tabindex="-1" role="dialog" aria-labelledby="ModalEditMedicationDispense" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditMedicationDispense">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-pencil"></i> Edit Medication Dispense</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="FormEditMedicationDispense">

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" id="NotifikasiEditMedicationDispense">

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="ti ti-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal" aria-label="Close">
                        <i class="ti ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>