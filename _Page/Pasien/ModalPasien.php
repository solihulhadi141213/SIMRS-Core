<!--- Modal Konfirmasi Tambah Pasien ---->
<div class="modal fade" id="ModalKonfirmasiTambahPasien" tabindex="-1" role="dialog" aria-labelledby="ModalKonfirmasiTambahPasien" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <b cass="text-light"><i class="icofont-prescription"></i> Tambah Pasien Baru</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <h4>Keterangan</h4>
                        Sebelum anda menambah data pasien baru, pastikan pasien tersebut belum memiliki Nomor RM (Belum Pernah Terdaftar Sebelumnya). 
                        Persiapkan berkas pasien seperti KTP atau KK untuk kelengkapan data NIK.
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-primary">
                <a href="index.php?Page=Pasien&Sub=TambahPasien" type="button" class="btn btn-sm btn-success">
                    <i class="ti ti-check-box"></i> Lanjutkan Pendaftaran
                </a>
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Tambah Pasien ---->
<div class="modal fade" id="ModalTambahPasien" tabindex="-1" role="dialog" aria-labelledby="ModalTambahPasien" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <b cass="text-light"><i class="icofont-prescription"></i> Tambah Pasien Baru</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormTambahPasien">
                <!---- Form Tambah Pasien ----->
            </div>
        </div>
    </div>
</div>
<!--- Modal Detail Pasien ---->
<div class="modal fade" id="ModalDetailPasien" tabindex="-1" role="dialog" aria-labelledby="ModalDetailPasien" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-inverse">
                <b cass="text-light"><i class="icofont-patient-file"></i> Detail pasien</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormDetailPasien">
                <!---- Form Detail Pasien ----->
            </div>
        </div>
    </div>
</div>
<!--- Modal Edit Pasien ---->
<div class="modal fade" id="ModalEditPasien" tabindex="-1" role="dialog" aria-labelledby="ModalEditPasien" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <b cass="text-light"><i class="icofont-edit"></i> Edit pasien</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormEditPasien">
                <!---- Form Edit Pasien ----->
            </div>
        </div>
    </div>
</div>
<!--- Modal Konfirmasi Edit Pasien ---->
<div class="modal fade" id="ModalKonfirmasiEditPasien" tabindex="-1" role="dialog" aria-labelledby="ModalKonfirmasiEditPasien" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <b cass="text-light"><i class="icofont-edit"></i> Edit Pasien</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormKonfirmasiEditPasien">
                <!---- Form Konfirmasi Edit Pasien ----->
            </div>
        </div>
    </div>
</div>
<!--- Modal Hapus Pasien ---->
<div class="modal fade" id="ModalHapusPasien" tabindex="-1" role="dialog" aria-labelledby="ModalHapusPasien" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusPasien">
                <div class="modal-header bg-danger">
                    <b cass="card-title text-light"><i class="icofont-trash"></i> Konfirmasi Hapus pasien</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12" id="FormHapusPasien">
                            <!---- Form Hapus Pasien ----->
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12" id="NotifikasiHapusPasien">
                            <!---- Notifikasi Hapus Pasien ----->
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-danger">
                    <button type="submit" class="btn btn-md btn-inverse" id="ButtonHapusPasien">
                        <i class="ti-check-box"></i> Ya, Hapus
                    </button>
                    <button type="button" class="btn btn-md btn-light" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Filter Tabel ---->
<div class="modal fade" id="ModalFilterTabel" tabindex="-1" role="dialog" aria-labelledby="ModalFilterTabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b><i class="icofont-filter"></i> Filter Tabel</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormFilterTabel">
                <!---- Form Filter Tabel ----->
            </div>
        </div>
    </div>
</div>
<!--- Modal Export Pasien ---->
<div class="modal fade" id="ModalExportPasien" tabindex="-1" role="dialog" aria-labelledby="ModalExportPasien" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b><i class="ti-export"></i> Export Data Pasien</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormExportPasien">
                <!---- Form Filter Tabel ----->
            </div>
        </div>
    </div>
</div>
<!--- Modal Pencarian Pasien BPJS ---->
<div class="modal fade" id="ModalPencarianPasienBPJS" tabindex="-1" role="dialog" aria-labelledby="ModalPencarianPasienBPJS" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-inverse">
                <b><i class="ti-search"></i> Pencarian Pasien (BPJS)</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="FormHasilPencarianPasienBpjs">
                <!---- Form Hasil Pencarian Pasien BPJS ----->
            </div>
            <div class="modal-footer bg-inverse">
                <div class="row">
                    <div class="col-md-12">
                            <button type="button" class="btn btn-sm btn-light mt-2 ml-2" data-dismiss="modal">
                                <i class="ti-close"></i> Tutup
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--- Modal Pencarian Pasien Satu Sehat ---->
<div class="modal fade" id="ModalPencarianpasienSatuSehat" tabindex="-1" role="dialog" aria-labelledby="ModalPencarianpasienSatuSehat" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-inverse">
                <b><i class="ti-search"></i> Pencarian Pasien (Satu Sehat)</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="FormHasilPencarianPasienSatuSehat">
                <!---- Form Hasil Pencarian Pasien BPJS ----->
            </div>
            <div class="modal-footer bg-inverse">
                <div class="row">
                    <div class="col-md-12">
                            <button type="button" class="btn btn-sm btn-light mt-2 ml-2" data-dismiss="modal">
                                <i class="ti-close"></i> Tutup
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--- Modal Cek Status Pasien BPJS ---->
<div class="modal fade" id="ModalCekNikBpjs" tabindex="-1" role="dialog" aria-labelledby="ModalCekNikBpjs" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-inverse">
                <b><i class="ti-search"></i> Cek Status Pasien (BPJS)</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="FormCekNikBpjs">
                <!---- Form Cek Nik Bpjs ----->
            </div>
            <div class="modal-footer bg-inverse">
                <div class="row">
                    <div class="col-md-12">
                            <button type="button" class="btn btn-sm btn-light mt-2 ml-2" data-dismiss="modal">
                                <i class="ti-close"></i> Tutup
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--- Modal Cek Status Pasien BPJS (Noka)---->
<div class="modal fade" id="ModalCekNokaBpjs" tabindex="-1" role="dialog" aria-labelledby="ModalCekNokaBpjs" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-inverse">
                <b><i class="ti-search"></i> Cek Status Pasien (BPJS)</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="FormCekNokaBpjs">
                <!---- Form Cek Noka Bpjs ----->
            </div>
            <div class="modal-footer bg-inverse">
                <div class="row">
                    <div class="col-md-12">
                            <button type="button" class="btn btn-sm btn-light mt-2 ml-2" data-dismiss="modal">
                                <i class="ti-close"></i> Tutup
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--- Modal Cek NIK (Satu Sehat)---->
<div class="modal fade" id="ModalCekNikSatuSehat" tabindex="-1" role="dialog" aria-labelledby="ModalCekNikSatuSehat" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-inverse">
                <b><i class="ti-search"></i> Cek NIK Pasien (Satu Sehat)</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="FormCekNikSatuSehat">
                <!---- Form Cek NIK Satu Sehat ----->
            </div>
            <div class="modal-footer bg-inverse">
                <div class="row">
                    <div class="col-md-12">
                            <button type="button" class="btn btn-sm btn-light mt-2 ml-2" data-dismiss="modal">
                                <i class="ti-close"></i> Tutup
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--- Modal Cek IHS---->
<div class="modal fade" id="ModalCekIhs" tabindex="-1" role="dialog" aria-labelledby="ModalCekIhs" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-inverse">
                <b><i class="ti-search"></i> Cek IHS Pasien (Satu Sehat)</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="FormCekIhs">
                <!---- Form Cek NIK Satu Sehat ----->
            </div>
            <div class="modal-footer bg-inverse">
                <div class="row">
                    <div class="col-md-12">
                            <button type="button" class="btn btn-sm btn-light mt-2 ml-2" data-dismiss="modal">
                                <i class="ti-close"></i> Tutup
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--- Modal Creat IHS---->
<div class="modal fade" id="ModalCreatIhs" tabindex="-1" role="dialog" aria-labelledby="ModalCreatIhs" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <b><i class="ti-plus"></i> Buat IHS Pasien</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormCreatIhs">
                <!---- Form Creat IHS ----->
            </div>
        </div>
    </div>
</div>
<!--- Modal Hapus Foto Pasien ---->
<div class="modal fade" id="ModalHapusFoto" tabindex="-1" role="dialog" aria-labelledby="ModalHapusFoto" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <b cass="text-light"><i class="icofont-trash"></i> Konfirmasi Hapus Foto</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormHapusFoto">
                <!---- Form Hapus Foto ----->
            </div>
        </div>
    </div>
</div>
<!--- Modal Konfirmasi Tambah Kunjungan ---->
<div class="modal fade" id="ModalKonfirmasiBuatKunjungan" tabindex="-1" role="dialog" aria-labelledby="ModalKonfirmasiBuatKunjungan" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <b cass="text-light"><i class="icofont-question-circle"></i> Konfirmasi Tambah Kunjungan</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormKonfirmasiTambahKunjungan">
                <!---- Form Konfirmasi Tambah Kunjungan ----->
            </div>
        </div>
    </div>
</div>
<!--- Modal Cek IHS---->
<div class="modal fade" id="ModalDetailIhs" tabindex="-1" role="dialog" aria-labelledby="ModalDetailIhs" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-inverse">
                <b><i class="ti ti-info-alt"></i> Detail IHS</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="FormDetailIHS">
                <!---- Form Detail IHS pasien----->
            </div>
            <div class="modal-footer bg-inverse">
                <div class="row">
                    <div class="col-md-12">
                            <button type="button" class="btn btn-sm btn-light mt-2 ml-2" data-dismiss="modal">
                                <i class="ti-close"></i> Tutup
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--- Modal Cek NIK---->
<div class="modal fade" id="ModalDetailNik" tabindex="-1" role="dialog" aria-labelledby="ModalDetailNik" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-inverse">
                <b><i class="ti ti-info-alt"></i> Detail NIK Pasien</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="FormDetailNik">
                <!---- Form Detail NIK pasien----->
            </div>
            <div class="modal-footer bg-inverse">
                <div class="row">
                    <div class="col-md-12">
                            <button type="button" class="btn btn-sm btn-light mt-2 ml-2" data-dismiss="modal">
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
            <div class="modal-header bg-inverse">
                <b><i class="ti ti-info-alt"></i> Detail BPJS Pasien</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="FormDetailBPJS">
                <!---- Form Detail BPJS pasien----->
            </div>
            <div class="modal-footer bg-inverse">
                <div class="row">
                    <div class="col-md-12">
                            <button type="button" class="btn btn-sm btn-light mt-2 ml-2" data-dismiss="modal">
                                <i class="ti-close"></i> Tutup
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Detail Kunjungan Pasien -->
<div class="modal fade" id="ModalDetailKunjungan" tabindex="-1" role="dialog" aria-labelledby="ModalDetailKunjungan" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-inverse">
                <b><i class="ti ti-info-alt"></i> Detail Kunjungan Pasien</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormDetailKunjungan">
                <!---- Form Detail Kunjungan Pasien----->
            </div>
        </div>
    </div>
</div>
<!--- Modal Detail SEP ---->
<div class="modal fade" id="ModalDetailSep" tabindex="-1" role="dialog" aria-labelledby="ModalDetailSep" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-info-alt"></i> Detail SEP</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row" >
                    <div class="col-md-12 mb-3" id="FormDetailSep">
                        
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
<!--- Modal Update Consent ---->
<div class="modal fade" id="ModalUpdateConsent" tabindex="-1" role="dialog" aria-labelledby="ModalUpdateConsent" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesUpdateConsent">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-reload"></i> Update Consent</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="FormUpdateConsent">
                        <!-- Form Disini -->
                    </div>
                    <div class="row" >
                        <div class="col-md-12 mb-3" id="NotifikasiUpdateConsent">
                            Pastikan Data Informasi Consent Yang Anda Kirim Sudah Sesuai
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary btn-round">
                        <i class="ti ti-save"></i> Simpan Update
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary btn-round" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>