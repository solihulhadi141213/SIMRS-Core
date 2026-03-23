<!--- Modal Lihat Foto---->
<div class="modal fade" id="ModalLihatFoto" tabindex="-1" role="dialog" aria-labelledby="ModalLihatFoto" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesSimpanFoto">
                <div class="modal-header bg-info">
                    <b cass="text-light"><i class="ti ti-image"></i> Foto</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mt-3 text-center">
                            <img src="<?php echo $foto;?>" alt="" width="100%">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-3">
                            <input type="file" id="foto" name="foto" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-3" id="NotifikasiSimpanFoto">
                            <small class="test-primary">Pastikan file foto memiliki format yang didukung (maksimal 2 mb)</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-info">
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