<!--- Modal Detail Resep---->
<div class="modal fade" id="ModalDetailResep" tabindex="-1" role="dialog" aria-labelledby="ModalDetailResep" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-info-alt"></i> Detail Resep</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="FormDetailResep">
                <!-- Isi Detail Resep -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary btn-round" data-dismiss="modal">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Detail Pasien---->
<div class="modal fade" id="ModalDetailPasien" tabindex="-1" role="dialog" aria-labelledby="ModalDetailPasien" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-info-alt"></i> Detail Pasien</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12" id="FormDetailPasien">>
                        <!-- Isi Detail Pasien -->
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12" id="TombolDetailPasien">
                        <!-- Isi Tombol Detail Pasien -->
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary btn-round" data-dismiss="modal">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Detail Kunjungan---->
<div class="modal fade" id="ModalDetailKunjungan" tabindex="-1" role="dialog" aria-labelledby="ModalDetailKunjungan" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-info-alt"></i> Detail Kunjungan</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12" id="FormDetailKunjungan">>
                        <!-- Isi Detail Kunjungan -->
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12" id="TombolDetailKunjungan">
                        <!-- Isi Tombol Detail Kunjungan -->
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary btn-round" data-dismiss="modal">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Cetak Resep---->
<div class="modal fade" id="ModalCetakResep" tabindex="-1" role="dialog" aria-labelledby="ModalCetakResep" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="_Page/RawatJalan/ProsesCetakResep.php" target="_blank">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-printer"></i> Cetak Resep</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="FormCetakResep">
                            <!-- Isi Form Cetak Resep -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary btn-round">
                        <i class="ti-printer"></i> Cetak
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary btn-round" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Cetak Etiket---->
<div class="modal fade" id="ModalCetakEtiket" tabindex="-1" role="dialog" aria-labelledby="ModalCetakEtiket" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="_Page/Resep/ProsesCetakEtiket.php" target="_blank">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-printer"></i> Cetak Etiket</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="FormCetakEtiket">
                            <!-- Isi Form Cetak Etiket -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary btn-round">
                        <i class="ti-printer"></i> Cetak
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary btn-round" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>