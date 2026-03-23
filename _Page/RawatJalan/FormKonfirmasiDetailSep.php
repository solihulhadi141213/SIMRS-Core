<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap id_kunjungan
    if(empty($_POST['sep'])){
        echo '<div class="modal-body">';
        echo '  <div class="row">';
        echo '      <div class="col-md-6 mb-3">';
        echo '          Nomor SEP Tidak Dapat didefinisikan.';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
        echo '<div class="modal-footer">';
        echo '  <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">';
        echo '      <i class="ti ti-close"></i> Tutup';
        echo '  </div>';
        echo '</div>';
    }else{
        $sep=$_POST['sep'];
        $id_kunjungan=getDataDetail($Conn,"kunjungan_utama",'sep',$sep,'id_kunjungan');
        $_SESSION['UrlBackDetailSep']="index.php?Page=RawatJalan&Sub=DetailKunjungan&id=$id_kunjungan";
?>
    <div class="modal-body">
        <div class="row mt-2 mb-2"> 
            <div class="col-md-12 text-center">
                <img src="assets/images/question.gif" alt="" width="70%">
            </div>
        </div>
        <div class="row mt-2 mb-2"> 
            <div class="col-md-12 text-center text-danger">
                Untuk melihat data SEP secara lengkap, anda akan diarahkan pada halaman detail SEP.<br>
                Silahkan lanjutkan untuk masuk ke halaman tersebut.
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <a href="index.php?Page=sep&Sub=DetailSep&sep=<?php echo $sep;?>" class="btn btn-sm btn-success mr-3">
            <i class="ti-check-box"></i> Ya, Lanjutkan
        </a>
        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">
            <i class="ti ti-close"></i> Tutup
        </button>
    </div>
<?php } ?>