<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap id_kunjungan
    if(empty($_POST['id_kunjungan'])){
        echo '<div class="modal-body border-0 pb-0 mb-4">';
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-danger text-center mb-3">';
        echo '          Id Kunjungan Tidak Boleh Kosong.';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
        echo '<div class="modal-footer">';
        echo '  <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">';
        echo '      <i class="ti ti-close"></i> Tutup';
        echo '  </button>';
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
    <div class="modal-body border-0 pb-0 mb-4">
        <div class="row mt-2 mb-2"> 
            <div class="col-md-12 text-center">
                <img src="assets/images/question.gif" alt="" width="70%">
            </div>
        </div>
        <div class="row mt-2 mb-2"> 
            <div class="col-md-12 text-center text-danger">
                <span id="NotifikasiHapusOperasi">
                    Apakah anda yakin akan menghapus data ini?
                </span>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-sm btn-success mr-3">
            <i class="ti-check-box"></i> Ya, Hapus
        </button>
        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">
            <i class="ti ti-close"></i> Tutup
        </button>
    </div>
<?php }} ?>