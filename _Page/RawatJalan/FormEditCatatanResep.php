<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['id_resep'])){
        echo '<div class="modal-body">';
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-center text-danger">';
        echo '          ID Resep Tidak Boleh Kosong!';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
        echo '<div class="modal-footer">';
        echo '  <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">';
        echo '      <i class="ti ti-close"></i> Tutup';
        echo '  </div>';
        echo '</div>';
    }else{
        $GetIdResep=$_POST['id_resep'];
        $catatan=getDataDetail($Conn,"resep",'id_resep',$GetIdResep,'catatan');
?>
        <input type="hidden" name="id_resep" id="GetIdResep" class="form-control" value="<?php echo "$GetIdResep"; ?>">
        <div class="modal-body">
            <div class="row mb-4">
                <div class="col-md-12">
                    <textarea name="CatatanResep" id="CatatanResep"><?php echo "$catatan"; ?></textarea>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12" id="NotifikasiEditCatatanResep">
                    <span class="text-primary">Pastikan informasi sudah terisi dengan lengkap dan benar.</span>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-sm btn-primary mr-3">
                <i class="ti ti-save"></i> Simpan
            </button>
            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">
                <i class="ti ti-close"></i> Tutup
            </button>
        </div>
<?php } ?>