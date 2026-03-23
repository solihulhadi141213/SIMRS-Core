<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap id_kunjungan
    if(empty($_POST['id_kunjungan'])){
        echo '<div class="modal-body">';
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-danger text-center">';
        echo '          ID Kunjungan Tidak Boleh Kosong!';
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
        $id_kunjungan=$_POST['id_kunjungan'];
        $_SESSION['UrlBackLab']="index.php?Page=RawatJalan&Sub=DetailKunjungan&id=$id_kunjungan";
?>
        <div class="modal-body">
            <div class="row mb-3">
                <div class="col-md-12">
                    Untuk melakukan pemeriksaan laboratorium maka anda harus mengajukan permintaan pemeriksaan terlebih dulu.
                    Silahkan lanjutkan untuk masuk ke halaman form permintaan pemeriksaan laboratorium.
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="index.php?Page=Laboratorium&Sub=TambahPermintaanLab&id_kunjungan=<?php echo "$id_kunjungan"; ?>" class="btn btn-sm btn-primary mr-2">
                <i class="ti ti-arrow-circle-right"></i> Lanjutkan
            </a>
            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                <i class="ti-close"></i> Tutup
            </button>
        </div>
<?php } ?>