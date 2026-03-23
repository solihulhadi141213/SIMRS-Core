<!--- Modal Tambah Slider/Hero ---->
<div class="modal fade" id="ModalTambahSlider" tabindex="-1" role="dialog" aria-labelledby="ModalTambahSlider" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahSlider">
                <div class="modal-header bg-primary">
                    <b cass="text-light"><i class="ti ti-plus"></i> Tambah Slider/Hero</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mt-3">
                            <label for="hero_title">Judul Slider</label>
                            <input type="text" name="hero_title" id="hero_title" class="form-control" value="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-3">
                            <label for="hero_button">Text Tombol</label>
                            <input type="text" name="hero_button" id="hero_button" class="form-control" value="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-3">
                            <label for="hero_url">URL Tombol</label>
                            <input type="text" name="hero_url" id="hero_url" class="form-control" value="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-3">
                            <label for="hero_img">Image File</label>
                            <input type="file" name="hero_img" id="hero_img" class="form-control" value="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-3">
                            <label for="hero_deskripsi">Deskripsi</label>
                            <textarea name="hero_deskripsi" id="" cols="30" rows="3" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-3" id="NotifikasiTambahSlider">
                            <span class="text-primary">
                                Pastikan data Slider/Hero sudah benar.
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
<!--- Modal Edit Slider/Hero ---->
<div class="modal fade" id="ModalEditSlider" tabindex="-1" role="dialog" aria-labelledby="ModalEditSlider" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditSlider">
                <div class="modal-header bg-primary">
                    <b cass="text-light"><i class="ti ti-plus"></i> Edit Slider/Hero</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="FormEditSlider">
                    
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
<!--- Modal Delete Slider/Hero ---->
<div class="modal fade" id="ModalHapustSlider" tabindex="-1" role="dialog" aria-labelledby="ModalHapusService" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <b cass="text-light">Konfirmasi Hapus Slider/Hero</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormHapusSlider">
                <!---- Konfirmasi Hapus Slider/Hero ----->
            </div>
        </div>
    </div>
</div>