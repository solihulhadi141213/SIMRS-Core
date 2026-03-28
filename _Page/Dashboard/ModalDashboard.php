<!--- Modal Konfirmasi Ijin Akses ---->
<div class="modal fade" id="ModalKonfirmasiIjinAksesBerkas" tabindex="-1" role="dialog" aria-labelledby="ModalKonfirmasiIjinAksesBerkas" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <b cass="text-light"><i class="ti-bell"></i> Permintaan Akses Berkas</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormPermintaanAksesBerkas">
                <!---- Form Permintaan Akses Berkas disini ----->
            </div>
        </div>
    </div>
</div>
<!--- Modal Verifikasi Surat Menyurat ---->
<div class="modal fade" id="ModalVerifikasiSurat" tabindex="-1" role="dialog" aria-labelledby="ModalVerifikasiSurat" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <b cass="text-light"><i class="ti-file"></i> Verifikasi Surat</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="DetailVerifikasiSuratNotifikasi">
                <!---- Notifikasi Verifikasi Surat ------->
            </div>
        </div>
    </div>
</div>
<!---Modal Ringkasan Guru---->
<div class="modal fade" id="ModalRingkasanGuru" tabindex="-1" role="dialog" aria-labelledby="ModalRingkasanGuru" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-inverse">
                <b cass="text-light"><i class="ti-file"></i> Ringkasan Data Guru</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="RingkasanDataGuru">
                <!---- Ringkasan Data Guru ------->
            </div>
        </div>
    </div>
</div>
<!---Modal Cetak Ringkasan Guru---->
<div class="modal fade" id="ModalCetakRingkasanGuru" tabindex="-1" role="dialog" aria-labelledby="ModalCetakRingkasanGuru" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <b cass="text-light"><i class="ti-file"></i> Cetak Ringkasan Data Guru</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormCetakRingkasanGuru">
                <!---- Form Cetak Ringkasan Data Guru ------->
            </div>
        </div>
    </div>
</div>
<!---Modal Dashboard Antrian---->
<div class="modal fade" id="ModalDashboardAntiran" tabindex="-1" role="dialog" aria-labelledby="ModalDashboardAntiran" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-inverse">
                <b cass="text-light"><i class="ti-file"></i> Ringkasan Data Surat Menyurat</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="javascript:void(0);" method="POST" id="ProsesDashboardAntrianOnline" autocomplete="off">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="">Mode Data</label>
                            <select name="mode" id="mode" class="form-control">
                                <option value="">pilih</option>
                                <option value="Harian">Harian</option>
                                <option value="Bulanan">Bulanan</option>
                            </select>
                        </div>
                    </div>
                    <div id="FormLanjutan">
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            Silahkan pilih mode data dan keterangan waktu
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-inverse">
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-md btn-primary mr-2 mt-2" id="TampilkanDataAntrian">
                                <i class="ti-file"></i> Tampilkan
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
