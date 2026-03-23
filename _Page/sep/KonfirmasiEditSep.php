<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap sep
    if(empty($_POST['sep'])){
        echo '<div class="modal-body">';
        echo '  <div class="row">';
        echo '      <div class="col-md-12 mb-3 text-center text-danger">';
        echo '          SEP Tidak Boleh Kosong.';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
        echo '<div class="modal-footer">';
        echo '  <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">';
        echo '      <i class="ti ti-close"></i> Tutup';
        echo '  </div>';
        echo '</div>';
    }else{
        if(empty($_POST['GetUrlBackDetailSep'])){
            echo '<div class="modal-body">';
            echo '  <div class="row">';
            echo '      <div class="col-md-12 mb-3 text-center text-danger">';
            echo '          URL Back Tidak Boleh Kosong.';
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
            $GetUrlBackDetailSep="index.php?Page=sep&Sub=DetailSep&sep=$sep";
            $id_kunjungan=getDataDetail($Conn,"kunjungan_utama",'sep',$sep,'id_kunjungan');
            $_SESSION['UrlBackSep']=$GetUrlBackDetailSep;
            if(empty($id_kunjungan)){
                echo '<div class="modal-body">';
                echo '  <div class="row">';
                echo '      <div class="col-md-12 mb-3 text-center text-danger">';
                echo '          SEP Tersebut Belum Terdaftar Pada Data Kunjungan. Untuk merubah data SEP ini hanya bisa dilakukan pada platform lain (Vclaim).';
                echo '      </div>';
                echo '  </div>';
                echo '</div>';
                echo '<div class="modal-footer">';
                echo '  <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">';
                echo '      <i class="ti ti-close"></i> Tutup';
                echo '  </div>';
                echo '</div>';
            }else{
?>
    <div class="modal-body">
        <div class="row mt-2 mb-2"> 
            <div class="col-md-12 text-center">
                <img src="assets/images/question.gif" alt="" width="70%">
            </div>
        </div>
        <div class="row mt-2 mb-2"> 
            <div class="col-md-12">
                Untuk merubah data anda akan diarahkan pada halaman form SEP. Silahkan lanjutkan untuk melakukan perubahan data SEP.
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <a href="index.php?Page=sep&Sub=BuatSep&id_kunjungan=<?php echo "$id_kunjungan"; ?>" class="btn btn-sm btn-success mr-3">
            <i class="ti-check-box"></i> Ya, Lanjutkan
        </a>
        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">
            <i class="ti ti-close"></i> Tutup
        </button>
    </div>
<?php }}} ?>