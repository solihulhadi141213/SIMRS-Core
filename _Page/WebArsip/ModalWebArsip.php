<!--- Modal Tambah Arsip ---->
<div class="modal fade" id="ModalTambahArsip" tabindex="-1" role="dialog" aria-labelledby="ModalTambahArsip" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahArsip">
                <div class="modal-header bg-primary">
                    <b cass="text-light"><i class="ti ti-plus"></i> Tambah Arsip</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mt-3">
                            <label for="judul">Judul Arsip</label>
                            <input type="text" name="judul" id="judul" class="form-control" value="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mt-3">
                            <label for="tanggal">Tanggal</label>
                            <input type="date" name="tanggal" id="tanggal" class="form-control" value="">
                        </div>
                        <div class="col-md-6 mt-3">
                            <label for="kategori">Kategori</label>
                            <input type="text" name="kategori" id="kategori" class="form-control" value="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-3">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" cols="30" rows="3" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-3">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="Publish">Publish</option>
                                <option value="Draft">Draft</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-3">
                            <label for="file_arsip">File Arsip</label>
                            <input type="file" name="file_arsip" id="file_arsip" class="form-control" value="">
                            <small>File maksimal 2 mb (jpg, jpeg, png, gif, pdf)</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-3" id="NotifikasiTambahArsip">
                            <span class="text-primary">
                                Pastikan data Medsos sudah benar.
                            </span>
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
<!--- Modal Detail Arsip ---->
<div class="modal fade" id="ModalDetailArsip" tabindex="-1" role="dialog" aria-labelledby="ModalDetailArsip" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <b cass="text-light"><i class="ti ti-info"></i> Detail Arsip</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pre-scrollable" id="FormDetailArsip">
                
            </div>
            <div class="modal-footer bg-info">
                <button type="button" class="btn btn-md btn btn-secondary" data-dismiss="modal">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Edit Arsip ---->
<div class="modal fade" id="ModalEditArsip" tabindex="-1" role="dialog" aria-labelledby="ModalEditArsip" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditArsip">
                <div class="modal-header bg-primary">
                    <b cass="text-light"><i class="ti ti-pencil"></i> Edit Arsip</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="FormEditArsip">
                    
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
<!--- Modal Hapus Arsip ---->
<div class="modal fade" id="ModalHapusArsip" tabindex="-1" role="dialog" aria-labelledby="ModalHapusArsip" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <b cass="text-light">Konfirmasi Hapus Arsip</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormHapusArsip">
                <!---- Konfirmasi Hapus Arsip ----->
            </div>
        </div>
    </div>
</div>