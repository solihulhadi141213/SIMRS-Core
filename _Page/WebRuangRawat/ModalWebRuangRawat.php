<!--- Modal Tambah Ruang Rawat Manual---->
<div class="modal fade" id="ModalTambahRuangRawat" tabindex="-1" role="dialog" aria-labelledby="ModalTambahRuangRawat" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahRuangRawat">
                <div class="modal-header bg-primary">
                    <b cass="text-light"><i class="ti ti-plus"></i> Tambah Ruang Rawat</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="ruang_rawat">Ruang Rawat</label>
                            <input type="text" class="form-control" name="ruang_rawat" id="ruang_rawat">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="kelas">Kelas</label>
                            <input type="text" class="form-control" name="kelas" id="kelas">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="kode">Kode</label>
                            <input type="text" class="form-control" name="kode" id="kode">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="kapasitas">Kapasitas</label>
                            <input type="text" class="form-control" name="kapasitas" id="kapasitas">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="pasien">Pasien</label>
                            <input type="text" class="form-control" name="pasien" id="pasien">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="">Pilih</option>
                                <option value="Aktif">Aktif</option>
                                <option value="Non Aktif">Non Aktif</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3" id="NotifikasiTambahRuangan">
                            <span class="test-primary">Pastikan Data Ruangan Yang Anda Input Sudah Benar</span>
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
<!--- Modal Edit Ruang Rawat Manual---->
<div class="modal fade" id="ModalEditRuangRawat" tabindex="-1" role="dialog" aria-labelledby="ModalEditRuangRawat" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditRuangRawat">
                <div class="modal-header bg-success">
                    <b cass="text-light"><i class="ti ti-pencil"></i> Edit Ruang Rawat</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="FormEditRuangRawat">
                    
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
<!--- Modal Sinkronisasi Simrs---->
<div class="modal fade" id="ModalSinkronkanDariSimrs" tabindex="-1" role="dialog" aria-labelledby="ModalSinkronkanDariSimrs" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <b cass="text-light"><i class="ti ti-reload"></i> Sinkronisasi Ruang Rawat</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 mt-3" id="FormSinkronisasiRuangRawat">
                        
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-3">
                        <dt>Keterangan :</dt>
                        Ketika anda memulai proses maka sistem akan menghapus data pada web kemudian menyimpan data baru.
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-success">
                <button type="button" class="btn btn-md btn btn-primary" id="MulaiProsesSinkronisasiRuangan">
                    <i class="ti ti-check"></i> Mulai Proses
                </button>
                <button type="button" class="btn btn-md btn btn-secondary" data-dismiss="modal">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Hapus Ruang Rawat ---->
<div class="modal fade" id="ModalHapusRuangRawat" tabindex="-1" role="dialog" aria-labelledby="ModalHapusRuangRawat" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <b cass="text-light">Hapus Ruang Rawat</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormHapusRuang">
                <!---- Konfirmasi Hapus Ruang Rawat ----->
            </div>
        </div>
    </div>
</div>