<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap id_rad
    if(empty($_POST['id_rad'])){
        echo '<div class="modal-body">';
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-danger text-center">';
        echo '          ID Radiologi Tidak Boleh Kosong!';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
        echo '<div class="modal-footer">';
        echo '  <div class="row">';
        echo '      <div class="col-md-12">';
        echo '          <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">';
        echo '              <i class="ti-close"></i> Tutup';
        echo '          </button>';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_rad=$_POST['id_rad'];
        $id_rad=getDataDetail($Conn,"radiologi",'id_rad',$id_rad,'id_rad');
        if(empty($id_rad)){
            echo '<div class="modal-body">';
            echo '  <div class="row">';
            echo '      <div class="col-md-12 text-danger text-center">';
            echo '          ID Radiologi Tidak Valid!';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
            echo '<div class="modal-footer">';
            echo '  <div class="row">';
            echo '      <div class="col-md-12">';
            echo '          <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">';
            echo '              <i class="ti-close"></i> Tutup';
            echo '          </button>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
?>
        <div class="modal-body">
            <div class="row mb-3">
                <div class="col-md-12">
                    Untuk detail pemeriksaan radiologi, ditampilkan pada halaman kusus pengelolaan data radiologi. Silahkan lanjutkan untuk konfirmasi masuk ke halaman tersebut.
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="index.php?Page=Radiologi&Sub=DetailRadiologi&id=<?php echo "$id_rad"; ?>" class="btn btn-sm btn-primary mr-2">
                <i class="ti ti-more"></i> Lihat Detail Selengkapnya
            </a>
            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                <i class="ti-close"></i> Tutup
            </button>
        </div>
<?php }} ?>