<?php
    if(empty($_POST['id_akses'])){
        echo '<div class="modal-body">';
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-center text-danger mb-3">';
        echo '          ID Akses Tidak Boleh Kosong!.';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
        echo '<div class="modal-footer bg-danger">';
        echo '  <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"><i class="ti ti-close"></i> Tutup</button>';
        echo '</div>';
    }else{
        $id_akses=$_POST['id_akses'];
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
                    <small class="modal-title my-3" id="NotifikasiHapusAkses">Anda Yakin Ingin Menghapus Data Ini?</small>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer bg-danger">
        <div class="row">
            <div class="col col-md-12 text-center">
                <button type="button" id="KonfirmasiHapusAkses" class="btn btn-sm btn-success"><i class="ti ti-check"></i> Ya, Hapus</button>
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"><i class="ti ti-close"></i> Tidak</button>
            </div>
        </div>
    </div>
<?php } ?>