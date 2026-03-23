<?php
    if(!empty($_POST['id_akses_pengajuan'])){
        $id_akses_pengajuan=$_POST['id_akses_pengajuan'];
?>
    <div class="modal-body">
        <div class="row">
                <div class="col col-md-12 text-center">
                    <span class="modal-icon display-2-lg">
                        <img src="assets/images/question.gif" width="70%">
                    </span>
                </div>
            </div>
            <div class="row">
                <div class="col col-md-12 text-center mb-3">
                    <small class="modal-title my-3" id="NotifikasiHapusPengajuanAkses">Anda Yakin Ingin Menghapus Data Ini?</small>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer bg-danger">
        <div class="row">
            <div class="col col-md-12 text-center">
                <button type="button" id="KonfirmasiHapusPengajuanAkses" class="btn btn-sm btn-success"><i class="ti ti-check"></i> Ya, Hapus</button>
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"><i class="ti ti-close"></i> Tidak</button>
            </div>
        </div>
    </div>
<?php } ?>