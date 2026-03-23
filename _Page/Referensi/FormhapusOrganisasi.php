<?php
    if(empty($_POST['id_referensi_organisasi'])){
        echo '<div class="modal-body">';
        echo '  <div class="row">';
        echo '      <div class="col col-md-12 text-center text-danger">';
        echo '          ID Organisasi Tidak Boleh Kosong!';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
        echo '<div class="modal-footer bg-danger">';
        echo '  <button type="button" class="btn btn-sm btn-inverse" data-dismiss="modal">';
        echo '      <i class="ti ti-close"></i> Tutup';
        echo '  </button>';
        echo '</div>';
    }else{
        $id_referensi_organisasi=$_POST['id_referensi_organisasi'];
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
                    <span class="text-dark" id="NotifikasiHapusOrganisasi">
                        Anda Yakin Ingin Menghapus Organisasi Ini?
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer bg-danger">
        <div class="row">
            <div class="col col-md-12 text-center">
                <button type="button" id="KonfirmasiHapusOrganisasi" class="btn btn-sm btn-primary">
                    <i class="ti ti-check"></i> Ya, Hapus
                </button>
                <button type="button" class="btn btn-sm btn-inverse" data-dismiss="modal">
                    <i class="ti ti-close"></i>Tidak
                </button>
            </div>
        </div>
    </div>
<?php } ?>