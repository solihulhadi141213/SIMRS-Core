<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['id_edukasi'])){
        echo '<div class="modal-body">';
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-center text-danger">';
        echo '          ID Edukasi Tidak Boleh Kosong!';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
        echo '<div class="modal-footer">';
        echo '  <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">';
        echo '      <i class="ti ti-close"></i> Tutup';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_edukasi=$_POST['id_edukasi'];
?>
    <input type="hidden" name="id_edukasi" id="id_edukasi" class="form-control" value="<?php echo "$id_edukasi"; ?>">
    <div class="modal-body">
        <div class="row mb-3">
            <div class="col-md-12 mb-2">
                Berikut ini adalah parameter mode cetak untuk data edukasi secara parsial. Silahkan lakukan pengaturan mode cetak yang anda inginkan.
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12 mb-2">
                Format Cetak?<br>
                <input type="radio" id="FormatCetakPdf" name="FormatCetak" value="PDF">
                <label for="FormatCetakPdf"><small>PDF</small></label>
                <input type="radio" id="FormatCetakHtml" name="FormatCetak" value="HTML">
                <label for="FormatCetakHtml"><small>HTML</small></label>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12 mb-2">
                Tamplikan Header?<br>
                <input type="radio" id="TampilkanHeaderYa" name="TampilkanHeader" value="Ya">
                <label for="TampilkanHeaderYa"><small>Ya, Tampilkan</small></label>
                <input type="radio" id="TampilkanHeaderTidak" name="TampilkanHeader" value="Tidak">
                <label for="TampilkanHeaderTidak"><small>Tidak</small></label>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-sm btn-primary mr-3">
            <i class="ti ti-printer"></i> Cetak
        </button>
        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">
            <i class="ti ti-close"></i> Tutup
        </button>
    </div>
<?php } ?>