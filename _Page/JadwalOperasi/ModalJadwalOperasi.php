<!--- Modal cari data pasien ---->
<div class="modal fade" id="ModalCaripasien" tabindex="-1" role="dialog" aria-labelledby="ModalCaripasien" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-search"></i> Cari Pasien</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0);" id="ProsesPencarianPasien">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="input-group">
                                <input type="text" name="KeywordPasien" id="KeywordPasien" class="form-control" placeholder="Nomor RM / Nama Pasien">
                                <button type="submit" class="btn btn-sm btn-primary">
                                    <i class="ti ti-search"></i> Cari
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
                <div id="FormHasilPencarianPasien"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-dark btn-round" data-dismiss="modal">
                    <i class="fa fa-times"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Detail Jadwal Operasi ---->
<div class="modal fade" id="ModalDetailJadwalOperasi" tabindex="-1" role="dialog" aria-labelledby="ModalDetailJadwalOperasi" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-info-alt"></i> Detail Jadwal Operasi</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="FormDetailJadwalOperasi">
                <!---- Form Detail Jadwal Oeprasi ----->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary btn-round" data-dismiss="modal">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Laporan Operasi ---->
<div class="modal fade" id="ModalLaporanOperasi" tabindex="-1" role="dialog" aria-labelledby="ModalLaporanOperasi" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-clipboard"></i> Laporan Operasi</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="FormLaporanOperasi">
                <!---- Form Laporan Operasi ----->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary btn-round" data-dismiss="modal">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Update Status Jadwal Operasi ---->
<div class="modal fade" id="ModalUpdateStatusJadwal" tabindex="-1" role="dialog" aria-labelledby="ModalUpdateStatusJadwal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesUpdateStatusJadwal">
                <div class="modal-header bg-info">
                    <b cass="text-light"><i class="ti ti-reload"></i> Update Jadwal Operasi</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="FormUpdateStatusJadwal">
                    <!---- Form Delete Jadwal Oeprasi ----->
                </div>
                <div class="modal-footer bg-info">
                    <button type="submit" class="btn btn-sm btn-success">
                        <i class="ti ti-check"></i> Simapn
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                        <i class="fa fa-times"></i> Tidak
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Delete Jadwal Operasi ---->
<div class="modal fade" id="ModalHapusJadwalOperasi" tabindex="-1" role="dialog" aria-labelledby="ModalHapusJadwalOperasi" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusJadwalOperasi">
                <div class="modal-header bg-danger">
                    <b cass="text-light"><i class="icofont-ui-delete"></i> Hapus Jadwal Operasi</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormDeleteJadwalOperasi">
                    <!---- Form Delete Jadwal Oeprasi ----->
                </div>
                <div class="modal-footer bg-danger">
                    <button type="submit" class="btn btn-sm btn-success">
                        <i class="ti ti-check"></i> Ya, Hapus
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                        <i class="fa fa-times"></i> Tidak
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Selesai Jadwal Operasi ---->
<div class="modal fade" id="ModalOperasiSelesai" tabindex="-1" role="dialog" aria-labelledby="ModalOperasiSelesai" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <b cass="text-light"><i class="icofont-check-circled"></i> Jadwal Operasi Selesai</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormSelesaiJadwalOperasi">
                <!---- Form Selesai Jadwal Oeprasi ----->
            </div>
        </div>
    </div>
</div>
<!--- Modal Undo Jadwal Operasi ---->
<div class="modal fade" id="ModalUndoOperasi" tabindex="-1" role="dialog" aria-labelledby="ModalUndoOperasi" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <b cass="text-light"><i class="icofont-undo"></i> Undo Jadwal Operasi</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormUndoJadwalOperasi">
                <!---- Form Undo Jadwal Oeprasi ----->
            </div>
        </div>
    </div>
</div>
<!--- Modal Tambah Jadwal Operasi ---->
<div class="modal fade" id="ModalTambahJadwal" tabindex="-1" role="dialog" aria-labelledby="ModalTambahJadwal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <b cass="text-light"><i class="icofont-edit"></i> Tambah Jadwal Operasi</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormTambahJadwalOperasi">
                <!---- Form Tambah Jadwal Oeprasi ----->
            </div>
        </div>
    </div>
</div>
<!--- Modal Edit Jadwal Operasi ---->
<div class="modal fade" id="ModalEditJadwalOperasi" tabindex="-1" role="dialog" aria-labelledby="ModalEditJadwalOperasi" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <b cass="text-light"><i class="icofont-edit"></i> Edit Jadwal Operasi</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormEditJadwalOperasi">
                <!---- Form Edit Jadwal Oeprasi ----->
            </div>
        </div>
    </div>
</div>

<!-- Modal pilih Pasien -->
<div class="modal fade" id="ModalPilihPasien" tabindex="-1" role="dialog" aria-labelledby="ModalPilihPasien" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body" class="pre-scrollable">
                <div id="KonfirmasiPilihPasien">
                    <!---- Konfirmasi Pilih Pasien----->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal pilih Poli -->
<div class="modal fade" id="ModalPilihPoli" tabindex="-1" role="dialog" aria-labelledby="ModalPilihPoli" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body bg-primary">
                <form action="javascript:void(0);" id="CariPoli">
                    <div class="row">
                        <div class="col-md-8">
                            <input type="text" name="keyword_poli" id="keyword_poli" class="form-control" placeholder="Kode/Nama Poli">
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-sm btn-block btn-inverse btn-round">
                                <i class="ti ti-search"></i> Cari
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-body" class="pre-scrollable">
                <div id="FormDataPoli">
                    <!---- Form Tambah Jadwal Oeprasi ----->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal pilih Poli -->
<div class="modal fade" id="ModalKonfirmasiPoli" tabindex="-1" role="dialog" aria-labelledby="ModalKonfirmasiPoli" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body" class="pre-scrollable">
                <div id="KonfirmasiPilihPoli">
                    <!---- Konfirmasi Pilih Poli----->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Pencarian Tindakan Operasi -->
<div class="modal fade" id="ModalPencarianTindakan" tabindex="-1" role="dialog" aria-labelledby="ModalPencarianTindakan" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-search"></i> Cari Tindakan</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0);" id="ProsesPencarianTindakan">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="input-group">
                                <input type="text" name="keyword_tindakan" id="keyword_tindakan" class="form-control" placeholder="Kode/Nama Tindakan">
                                <button type="submit" class="btn btn-sm btn-secondary">
                                    <i class="ti ti-search"></i> Cari
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            Sumber Referensi:<br>
                            <input type="radio" name="ReferensiPencarian" id="ReferensiPencarianSimrs" value="SIMRS"> <label for="ReferensiPencarianSimrs">SIMRS</label> 
                            <input type="radio" name="ReferensiPencarian" id="ReferensiPencarianBpjs" value="BPJS"> <label for="ReferensiPencarianBpjs">BPJS</label>
                        </div>
                    </div>
                </form>
                <div class="row">
                    <div class="col-md-12 pre-scrollable">
                        <ol class="list-group" id="ListHasilPencarianTindakan">
                            
                        </ol>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-dark btn-round" data-dismiss="modal">
                    <i class="fa fa-times"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Detail Pasien ---->
<div class="modal fade" id="ModalDetailPasien" tabindex="-1" role="dialog" aria-labelledby="ModalDetailPasien" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="icofont-patient-file"></i> Detail pasien</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="FormDetailPasien">
                <!---- Form Detail Pasien ----->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-dark btn-round" data-dismiss="modal">
                    <i class="fa fa-times"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>