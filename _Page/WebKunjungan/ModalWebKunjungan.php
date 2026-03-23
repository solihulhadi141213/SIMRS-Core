<!--- Modal List Pasien---->
<div class="modal fade" id="ModalListPasienWeb" tabindex="-1" role="dialog" aria-labelledby="ModalListPasienWeb" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <b cass="text-light"><i class="ti ti-list"></i> Pilih Pasien Web</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form action="javascript:void(0);" id="ProsesCariPasien">
                            <div class="input-group">
                                <input type="text" class="form-control" id="KeywordPasien" name="KeywordPasien" placeholder="Nama/ID">
                                <button type="submit" class="btn btn-md btn btn-secondary">
                                    <i class="ti ti-search"></i> Cari
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row" id="ListPasien">
                    
                </div>
            </div>
            <div class="modal-footer bg-primary">
                <button type="button" class="btn btn-md btn btn-secondary" data-dismiss="modal">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Detail Kunjungan---->
<div class="modal fade" id="ModalDetailKunjungan" tabindex="-1" role="dialog" aria-labelledby="ModalDetailKunjungan" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <b cass="text-light"><i class="ti ti-info-alt"></i> Detail Pendaftaran Kunjungan Web</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="FormDetailKunjungan">
            </div>
            <div class="modal-footer bg-info">
                <button type="button" class="btn btn-md btn btn-secondary" data-dismiss="modal">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Hapus Kunjungan ---->
<div class="modal fade" id="ModalHapusKunjungan" tabindex="-1" role="dialog" aria-labelledby="ModalHapusKunjungan" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <b cass="text-light">Konfirmasi Hapus Kunjungan</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormHapusKunjungan">
                <!---- Konfirmasi Hapus Kunjungan ----->
            </div>
        </div>
    </div>
</div>
<!--- Modal Add Antrian---->
<div class="modal fade" id="ModalAddToAntrian" tabindex="-1" role="dialog" aria-labelledby="ModalAddToAntrian" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <b cass="text-light"><i class="ti ti-plus"></i> Tambahkan Ke Antrian</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormAddToAntrian">
            </div>
        </div>
    </div>
</div>
<!--- Modal Riwayat Task ID---->
<div class="modal fade" id="ModalRiwayatTaskId" tabindex="-1" role="dialog" aria-labelledby="ModalRiwayatTaskId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-secondary">
                <dt class="text-light"><i class="ti ti-alarm-clock"></i> Riwayat Task ID</dt> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="FormRiwayatTaskId">
            </div>
            <div class="modal-footer bg-secondary">
                <button type="button" class="btn btn-md btn btn-outline-light" data-dismiss="modal">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Hapus Antrian ---->
<div class="modal fade" id="ModalHapusAntrian" tabindex="-1" role="dialog" aria-labelledby="ModalHapusAntrian" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <b cass="text-light">Konfirmasi Hapus Antrian</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormHapusAntrian">
                <!---- Konfirmasi Hapus Antrian ----->
            </div>
        </div>
    </div>
</div>
<!--- Modal Detail Pasien---->
<div class="modal fade" id="ModalDetailPasien" tabindex="-1" role="dialog" aria-labelledby="ModalDetailPasien" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <b cass="text-light"><i class="ti ti-info-alt"></i> Detail Akun Pasien</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="FormDetailpasien">
            </div>
            <div class="modal-footer bg-info">
                <button type="button" class="btn btn-md btn btn-secondary" data-dismiss="modal">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Detail Rm---->
<div class="modal fade" id="ModalDetailRm" tabindex="-1" role="dialog" aria-labelledby="ModalDetailRm" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <b cass="text-light"><i class="ti ti-info-alt"></i> Detail RM Pasien</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="FormDetailRm">
            </div>
            <div class="modal-footer bg-info">
                <button type="button" class="btn btn-md btn btn-secondary" data-dismiss="modal">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>