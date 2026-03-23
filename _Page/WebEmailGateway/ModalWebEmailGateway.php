<!--- Modal Tambah Dokter---->
<div class="modal fade" id="ModalKirimEmail" tabindex="-1" role="dialog" aria-labelledby="ModalKirimEmail" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesKirimEmail">
                <div class="modal-header bg-primary">
                    <b cass="text-light"><i class="ti ti-plus"></i> Coba Kirim Email</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="email_tujuan">Email Tujuan</label>
                            <input type="email" id="email_tujuan" name="email_tujuan" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="nama_tujuan">Nama Penerima</label>
                            <input type="text" id="nama_tujuan" name="nama_tujuan" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="subjek">Subjek Pesan</label>
                            <input type="text" id="subjek" name="subjek" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="pesan">Isi Pesan</label>
                            <textarea name="pesan" id="pesan" cols="30" rows="3" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3" id="NotifikasiKirimEmail">
                            <span class="text-primary">Pastikan anda mengirim pesan ke email yang valid.</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-primary">
                    <button type="submit" class="btn btn-md btn btn-success">
                        <i class="ti ti-arrow-circle-up"></i> Kirim
                    </button>
                    <button type="button" class="btn btn-md btn btn-secondary" data-dismiss="modal">
                        <i class="ti ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>