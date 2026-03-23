<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap id_rad
    if(empty($_POST['id_rad'])){
        echo '  <div class="modal-body">';
        echo '      <div class="row">';
        echo '          <div class="col-md-12 text-center text-danger">';
        echo '              ID Radiologi Tidak Boleh Kosong!.';
        echo '          </div>';
        echo '      </div>';
        echo '  </div>';
        echo '  <div class="modal-footer bg-inverse">';
        echo '      <button type="button" class="btn btn-md btn-secondary" data-dismiss="modal">';
        echo '          <i class="ti ti-close"></i> Tutup';
        echo '      </button>';
        echo '  </div>';
    }else{
        $id_rad=$_POST['id_rad'];
?>
    <form action="_Page/Radiologi/Cetak.php" method="GET" target="_blank">
        <input type="hidden" id="id" name="id" value="<?php echo "$id_rad"; ?>">
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12 mb-4">
                    <label for="CetakHeader">Cetak Header?</label>
                    <select name="CetakHeader" id="CetakHeader" class="form-control">
                        <option value="Tidak">Tidak</option>
                        <option value="Yes">Ya</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-4">
                    <label for="CetakLampiran">Cetak Bersama Lampiran?</label>
                    <select name="CetakLampiran" id="CetakLampiran" class="form-control">
                        <option value="Tidak">Tidak</option>
                        <option value="Yes">Ya</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="modal-footer bg-inverse">
            <button type="submit" class="btn btn-md btn-primary">
                <i class="ti ti-printer"></i> Cetak
            </button>
            <button type="button" class="btn btn-md btn-secondary" data-dismiss="modal">
                <i class="ti ti-close"></i> Tutup
            </button>
        </div>
    </form>
<?php } ?>