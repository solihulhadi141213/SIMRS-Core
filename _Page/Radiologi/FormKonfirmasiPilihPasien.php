<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap id_pasien
    if(empty($_POST['id_pasien'])){
        echo '<div class="modal-body">';
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-center mb-3">';
        echo '         ID Pasien Tidak Boleh Kosong!.';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
        echo '<div class="modal-footer bg-info">';
        echo '  <button type="button" class="btn btn-md btn btn-secondary" data-dismiss="modal">';
        echo '      <i class="ti ti-close"></i> Tutup';
        echo '  </button>';
        echo '</div>';
    }else{
        $id_pasien=$_POST['id_pasien'];
        if(empty(getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'nama'))){
            echo '<div class="modal-body">';
            echo '  <div class="row">';
            echo '      <div class="col-md-12 text-center mb-3">';
            echo '         ID Pasien Tidak Valid!.';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
            echo '<div class="modal-footer bg-info">';
            echo '  <button type="button" class="btn btn-md btn btn-secondary" data-dismiss="modal">';
            echo '      <i class="ti ti-close"></i> Tutup';
            echo '  </button>';
            echo '</div>';
        }else{
            $nama=getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'nama');
?>
    <input type="hidden" name="GetPutName" id="GetPutName" value="<?php echo "$nama"; ?>">
    <input type="hidden" name="GetPutIdPasien" id="GetPutIdPasien" value="<?php echo "$id_pasien"; ?>">
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12 mb-3 mt-4 text-center">
                <h1 class="text-dark"><i class="ti-help-alt"></i></h1>
            </div>
        </div>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12 mb-3 text-center">
                Apakah anda yakin memilih pasien ini?
            </div>
        </div>
    </div>
    <div class="modal-footer bg-info">
        <button type="button" class="btn btn-md btn btn-primary" id="KonfirmasiPilihPasien">
            <i class="ti ti-check"></i> Ya
        </button>
        <button type="button" class="btn btn-md btn btn-secondary" data-dismiss="modal">
            <i class="ti ti-close"></i> Tutup
        </button>
    </div>
<?php }} ?>