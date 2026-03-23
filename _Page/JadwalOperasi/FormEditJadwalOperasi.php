<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap id_operasi
    if(empty($_POST['id_operasi'])){
        $id_operasi=$_POST['id_operasi'];
        echo '<div class="modal-body">';
        echo '  <div class="row">';
        echo '      <div class="col-md-12 mb-3 text-danger text-center">';
        echo '          Data ID Jadwal Tidak Boleh Kosong.';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
        echo '<div class="modal-footer bg-success">';
        echo '  <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">';
        echo '      <i class="ti ti-close"></i> Tutup';
        echo '  </button>';
        echo '</div>';
    }else{
        $id_operasi=$_POST['id_operasi'];
        $id_kunjungan=getDataDetail($Conn,"operasi",'id_jadwal_operasi',$id_operasi,'id_kunjungan');
        if(!empty($id_kunjungan)){
            echo '<div class="modal-body">';
            echo '  <div class="row mt-3 mb-3">';
            echo '      <div class="col col-md-12 text-center">';
            echo '          <span class="text-danger">';
            echo '              <img src="assets/images/warningicon.png" width="70%">';
            echo '          </span>';
            echo '      </div>';
            echo '  </div>';
            echo '  <div class="row">';
            echo '      <div class="col-md-12 mb-3 text-danger text-center">';
            echo '          Jadwal operasi tidak bisa diubah karena sudah dibuatkan laporannya.';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
            echo '<div class="modal-footer bg-success">';
            echo '  <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">';
            echo '      <i class="ti ti-close"></i> Tutup';
            echo '  </button>';
            echo '</div>';
        }else{
?>
    <div class="modal-body">
        <div class="row">
            <div class="col col-md-12 text-center mb-3">
                <span class="modal-icon display-2-lg">
                    <img src="assets/images/question.gif" width="70%">
                </span>
            </div>
            <div class="col-md-12 text-center mb-3">
                Apakah anda yakin akan melakukan perubahan informasi jadwal operasi?
            </div>
        </div>
    </div>
    <div class="modal-footer bg-success">
        <a href="index.php?Page=JadwalOperasi&Sub=EditJadwalOperasi&id=<?php echo $id_operasi; ?>" class="btn btn-sm btn-primary">
            Lanjutkan <i class="ti ti-arrow-circle-right"></i>
        </a>
        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
            <i class="ti ti-close"></i> Tutup
        </button>
    </div>
<?php }} ?>