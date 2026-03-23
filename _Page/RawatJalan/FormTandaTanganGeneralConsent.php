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
        if(empty($_POST['kategori'])){
            echo '<div class="modal-body">';
            echo '  <div class="row">';
            echo '      <div class="col-md-12 text-center text-danger">';
            echo '          Kategori Tidak Boleh Kosong!';
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
            $kategori=$_POST['kategori'];
?>
    <div class="modal-body">
        <div class="row mb-3">
            <div class="col-md-12 mb-2">
                Untuk menandatangani dokumen ini, anda akan diarahkan ke halaman form tanda tangan general consent.
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <a href="index.php?Page=RawatJalan&Sub=TandaTanganGeneralConsent&id_kunjungan=<?php echo $id_kunjungan;?>&kategori=<?php echo $kategori;?>" class="btn btn-sm btn-primary mr-3">
            <i class="ti ti-arrow-circle-right"></i> Lanjutkan
        </a>
        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">
            <i class="ti ti-close"></i> Tutup
        </button>
    </div>
<?php }} ?>