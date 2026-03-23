<!--- Modal Filter Antrian---->
<div class="modal fade" id="ModalFilterAntrian" tabindex="-1" role="dialog" aria-labelledby="ModalFilterAntrian" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesFilterAntrian">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-filter"></i> Filter Antrian</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="batas">Data</label>
                            <select name="batas" id="batas" class="form-control">
                                <option value="5">5</option>
                                <option selected value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="keyword_by">Dasar Pencarian</label>
                            <select name="keyword_by" id="keyword_by" class="form-control">
                                <option selected value="">All</option>
                                <option value="kodebooking">Kode Booking</option>
                                <option value="id_pasien">NO.RM</option>
                                <option value="id_kunjungan">ID.Kunjungan</option>
                                <option value="nama_pasien">Nama Pasien</option>
                                <option value="nomorkartu">Nomor BPJS</option>
                                <option value="nik">NIK</option>
                                <option value="kodepoli">Poliklinik</option>
                                <option value="tanggal_daftar">Tanggal Daftar</option>
                                <option value="tanggal_kunjungan">Tanggal Kunjungan</option>
                            </select>
                        </div>
                        <div class="col-md-12 mb-3" id="FormKeyword">
                            <label for="keyword">Kata Kunci</label>
                            <input type="text" name="keyword" id="keyword" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary mt-2 ml-2">
                        <i class="ti-search"></i> Cari
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary mt-2 ml-2" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Add Booking Antrian---->
<div class="modal fade" id="ModalAddAntrian" tabindex="-1" role="dialog" aria-labelledby="ModalAddAntrian" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesAddAntrian">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-plus"></i> Creat Antrian (SIRS Online)</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="FormAddAntrianSirsOnline">
                        <!-- Form Add Antrian SIRS Online Disini -->
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <dt>Keterangan :</dt>
                        </div>
                        <div class="col-md-8 mb-3" id="NotifikasiProsesAddAntrian">
                            Pastikan data antrian yang anda input sudah benar!
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary mt-2 ml-2">
                        <i class="ti-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary mt-2 ml-2" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Detail Booking Antrian---->
<div class="modal fade" id="ModalDetailAntrian" tabindex="-1" role="dialog" aria-labelledby="ModalDetailAntrian" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-info-alt"></i> Detail Antrian (SIMRS)</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="FormDetailAntrian">
                    <!-- Form Detail Antrian Disini -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary mt-2 ml-2" data-dismiss="modal">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Update Booking Antrian SIRS Online---->
<div class="modal fade" id="ModalUpdateAntrianSirsOnline" tabindex="-1" role="dialog" aria-labelledby="ModalUpdateAntrianSirsOnline" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesUpdateAntrianSirsOnline">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-plus"></i> Update Antrian (SIRS Online)</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="FormUpdateAntrianSirsOnline">
                        <!-- Form Update Antrian SIRS Online Disini -->
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <dt>Keterangan :</dt>
                        </div>
                        <div class="col-md-8 mb-3" id="NotifikasiUpdateAntrianSirsOnline">
                            Pastikan data antrian yang anda input sudah benar!
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary mt-2 ml-2">
                        <i class="ti-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary mt-2 ml-2" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Detail Antrian SIRS Online---->
<div class="modal fade" id="ModalDetailAntrianSirsOnline" tabindex="-1" role="dialog" aria-labelledby="ModalDetailAntrianSirsOnline" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-plus"></i> Detail Antrian (SIRS Online)</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="FormDetailAntrianSirsOnline">
                    <!-- Form Detail Antrian SIRS Online Disini -->
                </div>
                <form action="javascript:void(0);" id="ProsesUpdateTaskIdAntianSubmit">
                    <div class="row">
                        <div class="col-md-12" id="FormUpdateTaskIdAntian">

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-sm btn-block btn-outline-dark">
                                Update Task ID
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary mt-2 ml-2" data-dismiss="modal">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>