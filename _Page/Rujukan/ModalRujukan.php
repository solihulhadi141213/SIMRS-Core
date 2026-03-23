<!--- Modal Cari SEP ---->
<div class="modal fade" id="ModalCariSep" tabindex="-1" role="dialog" aria-labelledby="ModalCariSep" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <b cass="text-light"><i class="icofont-search-document"></i> Pencarian SEP</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0);" method="post" id="ProsesPencarianSep">
                    <div class="row">
                        <div class="col-md-6">
                            <input type="text" name="keyword" id="keyword" class="form-control form-control-round" placeholder="Cari...">
                        </div>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-sm btn-secondary btn-round">
                                <i class="icofont-search-2"></i> Cari
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12" id="FormPencarianSEP">
                        <!---- Form Pencarian SEP ----->
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-primary">
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-md btn-round btn-danger" data-dismiss="modal">
                            <i class="ti ti-close"></i> Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalPilihSep" tabindex="-1" role="dialog" aria-labelledby="ModalPilihSep" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="icofont-prescription"></i> Konfirmasi Pilih SEP</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="KonfirmasiPilihSep">
                <!---- Konfirmasi Pilih Sep ----->
            </div>
        </div>
    </div>
</div>
<!--- Modal Cari PPK ---->
<div class="modal fade" id="ModalCariPpk" tabindex="-1" role="dialog" aria-labelledby="ModalCariPpk" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <b cass="text-light"><i class="icofont-search-document"></i> Pencarian PPK Rujukan</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0);" method="post" id="ProsesPencarianPpk" autocomplete="off">
                    <div class="row">
                        <div class="col-md-6">
                            <input type="text" name="keyword" id="keyword" class="form-control form-control-round" placeholder="Cari...">
                        </div>
                        <div class="col-md-6">
                            <select name="JenisFaskes" id="JenisFaskes" class="form-control">
                                <option value="1">Faskes 1</option>
                                <option value="2">Faskes 2/RS</option>
                            </select>
                        </div>
                        <div class="col-md-12 mt-3">
                            <button type="submit" class="btn btn-sm btn-block btn-secondary btn-round">
                                <i class="icofont-search-2"></i> Cari
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12" id="FormPencarianPpk">
                        Belum Ada Data Yang Dapat Ditampilkan
                        <!---- Form Pencarian Ppk ----->
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-primary">
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-md btn-round btn-danger" data-dismiss="modal">
                            <i class="ti ti-close"></i> Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalKonfirmasiPPK" tabindex="-1" role="dialog" aria-labelledby="ModalKonfirmasiPPK" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="icofont-prescription"></i> Konfirmasi Pilih PPK</b> 
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
<!--- Modal Cari Diagnosa ---->
<div class="modal fade" id="ModalCariDiagnosa" tabindex="-1" role="dialog" aria-labelledby="ModalCariDiagnosa" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <b cass="text-light"><i class="icofont-search-document"></i> Pencarian Diagnosa</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0);" method="post" id="PencarianDiagnosa" autocomplete="off">
                    <div class="row">
                        <div class="col-md-8 mt-3">
                            <input type="text" name="keyword" id="keyword" class="form-control form-control-round" placeholder="Cari...">
                        </div>
                        <div class="col-md-4 mt-3">
                            <button type="submit" class="btn btn-sm btn-block btn-secondary btn-round">
                                <i class="icofont-search-2"></i> Cari
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 mt-3" id="FormPencarianDiagnosa">
                        Belum Ada Data Yang Dapat Ditampilkan
                        <!---- Form Pencarian Ppk ----->
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-primary">
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-md btn-round btn-danger" data-dismiss="modal">
                            <i class="ti ti-close"></i> Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalKonfirmasiDiagnosa" tabindex="-1" role="dialog" aria-labelledby="ModalKonfirmasiDiagnosa" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="icofont-prescription"></i> Konfirmasi Pilih Diagnosa</b> 
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
<!--- Modal Cari Poli Rujukan ---->
<div class="modal fade" id="ModalCariPoli" tabindex="-1" role="dialog" aria-labelledby="ModalCariPoli" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <b cass="text-light"><i class="icofont-search-document"></i> Pencarian Poli/Spesialistik</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4 mt-3">
                        <button type="button" class="btn btn-sm btn-block btn-secondary btn-round mr-2" id="PilihPoliklinik">
                            Poliklinik
                        </button>
                    </div>
                    <div class="col-md-4 mt-3">
                        <button type="button" class="btn btn-sm btn-block btn-secondary btn-round mr-2" id="PilihSpesialistik">
                            Spesialistik
                        </button>
                    </div>
                    <div class="col-md-4 mt-3">
                        <button type="button" class="btn btn-sm btn-block btn-secondary btn-round mr-2" id="PilihSarana">
                            Sarana
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div id="FormPencarianPoli">
                    <!---- Form Pencarian Poli ----->
                </div>
                <div class="row">
                    <div class="col-md-12 text-center mt-3" id="HasilPencarianPoli">
                        <span class="text-danger">Belum Ada Data Yang Dapat Ditampilkan</span>
                        <!---- Hasil Pencarian Poli ----->
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-primary">
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-md btn-round btn-danger" data-dismiss="modal">
                            <i class="ti ti-close"></i> Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalKonfirmasiPoli" tabindex="-1" role="dialog" aria-labelledby="ModalKonfirmasiPoli" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="icofont-prescription"></i> Konfirmasi Pilih Poli</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="KonfirmasiPilihPoli">
                <!---- Konfirmasi Pilih Poli ----->
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalDetailRujukanInternal" tabindex="-1" role="dialog" aria-labelledby="ModalDetailRujukanInternal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <b cass="text-light"><i class="icofont-prescription"></i> Detail Rujukan Internal</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormDetailRujukanInternal">
                <!---- Form Detail Rujukan Internal ----->
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalKonfirmasiEditRujukan" tabindex="-1" role="dialog" aria-labelledby="ModalKonfirmasiEditRujukan" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="icofont-prescription"></i> Konfirmasi Edit Rujukan</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="KonfirmasiEditRujukan">
                <!---- Konfirmasi Edit Rujukan ----->
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalKonfirmasiHapusRujukan" tabindex="-1" role="dialog" aria-labelledby="ModalKonfirmasiHapusRujukan" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <b cass="text-light"><i class="ti ti-trash"></i> Konfirmasi Hapus Rujukan</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="KonfirmasiHapusRujukan">
                <!---- Konfirmasi Hapus Rujukan ----->
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalCariDiagnosaProcedur" tabindex="-1" role="dialog" aria-labelledby="ModalCariDiagnosaProcedur" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <b cass="text-light"><i class="icofont-search-2"></i> Cari Diagnosa/Procedur</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormPencarianDiagnosaProcedur">
                <!---- Form Detail Rujukan Internal ----->
            </div>
        </div>
    </div>
</div>