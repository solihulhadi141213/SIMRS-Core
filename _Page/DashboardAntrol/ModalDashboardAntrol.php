<!--- Modal Konfirmasi Ijin Akses ---->
<div class="modal fade" id="ModalInformasiSemuaAntrian" tabindex="-1" role="dialog" aria-labelledby="ModalInformasiSemuaAntrian" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-light"><i class="ti-info-alt"></i> Informasi</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        Nilai yang tertera pada kolom ini adalah jumlah semua antrian yang terdaftar pada database SIMRS
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn btn-secondary" data-dismiss="modal">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Informasi Antrian Selesai ---->
<div class="modal fade" id="ModalInformasiAntrianSelesai" tabindex="-1" role="dialog" aria-labelledby="ModalInformasiAntrianSelesai" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-light"><i class="ti-info-alt"></i> Informasi</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        Nilai yang tertera pada kolom ini adalah informasi jumlah antrian yang sudah selesai. 
                        Dapat diasumsikan juga sebagai jumlah pasien yang sudah pulang.
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn btn-secondary" data-dismiss="modal">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Informasi Antrian Ws BPJS ---->
<div class="modal fade" id="ModalInformasiAntrianWsBpjs" tabindex="-1" role="dialog" aria-labelledby="ModalInformasiAntrianWsBpjs" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-light"><i class="ti-info-alt"></i> Informasi</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        Nilai yang tertera pada kolom ini adalah informasi jumlah antrian yang terintegrasi dengan service BPJS. 
                        Ketika antrian ini dibuat, data antrian juga dikirmkan ke service BPJS.
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn btn-secondary" data-dismiss="modal">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Informasi Antrian Tanpa Kunjungan ---->
<div class="modal fade" id="ModalInformasiAntrianTanpaKunjungan" tabindex="-1" role="dialog" aria-labelledby="ModalInformasiAntrianTanpaKunjungan" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-light"><i class="ti-info-alt"></i> Informasi</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        Nilai yang tertera pada kolom ini adalah informasi jumlah antrian yang belum dibuatkan data kunjungannya. 
                        Hal ini dapat disebabkan karena diantara pasien yang sudah mendaftar telah membatalkan antriannya.
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn btn-secondary" data-dismiss="modal">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>