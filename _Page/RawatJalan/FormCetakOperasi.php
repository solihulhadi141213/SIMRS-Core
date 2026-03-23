<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['id_kunjungan'])){
        echo '<div class="modal-body">';
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-center text-danger">';
        echo '          ID Kunjungan Tidak Boleh Kosong!';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
        echo '<div class="modal-footer">';
        echo '  <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">';
        echo '      <i class="ti ti-close"></i> Tutup';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_kunjungan=$_POST['id_kunjungan'];
        $id_operasi=getDataDetail($Conn,"operasi",'id_kunjungan',$id_kunjungan,'id_operasi');
        if(empty($id_operasi)){
            echo '<div class="modal-body border-0 pb-0 mb-4">';
            echo '  <div class="row">';
            echo '      <div class="col-md-12 mb-3 text-danger text-center">';
            echo '          Belum Ada Data Operasi Untuk Kunjungan Ini.';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
            echo '<div class="modal-footer">';
            echo '  <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">';
            echo '      <i class="ti ti-close"></i> Tutup';
            echo '  </button>';
            echo '</div>';
        }else{
?>
    <input type="hidden" name="id_kunjungan" id="id_kunjungan" class="form-control" value="<?php echo "$id_kunjungan"; ?>">
    <div class="modal-body">
        <div class="row mb-3">
            <div class="col-md-12 mb-2">
                Silahkan lakukan pengaturan mode cetak yang anda inginkan.
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
<?php }} ?>