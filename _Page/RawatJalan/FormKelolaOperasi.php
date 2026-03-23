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
        $tanggal=date('Y-m-d');
        $jam=date('H:i');
        $id_kunjungan=$_POST['id_kunjungan'];
        $_SESSION['UrlBacOperasi']='index.php?Page=RawatJalan&Sub=DetailKunjungan&id='.$id_kunjungan.'';
?>
    <div class="modal-body">
        <div class="row mb-3">
            <div class="col-md-12 mb-2">
                Untuk menambahkan mengelola informasi operasi maka anda akan diarahkan pada halaman mandiri Pengelolaan operasi. 
                Gunakan tab baru agar mempermudah anda dalam pengelolaan data tersebut.
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <a href="index.php?Page=RawatJalan&Sub=Operasi&id=<?php echo $id_kunjungan; ?>" class="btn btn-sm btn-primary mr-3">
            <i class="ti ti-check-box"></i> Ya, Lanjutkan
        </a>
        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">
            <i class="ti ti-close"></i> Tutup
        </button>
    </div>
<?php } ?>