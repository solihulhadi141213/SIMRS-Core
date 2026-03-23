<?php
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['id_operasi'])){
        echo '<div class="row">';
        echo '  <div class="col col-md-12 text-center">';
        echo '      <span class="text-danger">';
        echo '          ID Operasi Tidak Boleh Kosong!';
        echo '      </span>';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_operasi=$_POST['id_operasi'];
        //Cek apakah memiliki laporan operasi
        $IdLaporanOperasi=getDataDetail($Conn,'operasi','id_jadwal_operasi',$id_operasi,'id_jadwal_operasi');
        if(!empty($IdLaporanOperasi)){
            echo '<div class="row mt-3 mb-3">';
            echo '  <div class="col col-md-12 text-center">';
            echo '      <span class="text-danger">';
            echo '          <img src="assets/images/warningicon.png" width="70%">';
            echo '      </span>';
            echo '  </div>';
            echo '</div>';
            echo '<div class="row mb-3">';
            echo '  <div class="col col-md-12 text-center">';
            echo '      <span class="text-danger">';
            echo '          Jadwal operasi tidak bisa dihapus!<br>';
            echo '          Hal ini sesuai kebijakan bahwa data jadwal operasi mungkin saja terhubung dengan laporan status operasi.';
            echo '      </span>';
            echo '  </div>';
            echo '</div>';
        }else{
?>
    <input type="hidden" name="id_operasi" value="<?php echo "$id_operasi"; ?>">
    <div class="row">
        <div class="col col-md-12 text-center">
            <span class="modal-icon display-2-lg">
                <img src="assets/images/question.gif" width="70%">
            </span>
        </div>
    </div>
    <div class="row">
        <div class="col col-md-12 text-center mb-3">
            <small class="modal-title my-3" id="NotifikasiHapusJadwalOperasi">Anda Yakin Ingin Menghapus Data Ini?</small>
        </div>
    </div>
<?php }} ?>