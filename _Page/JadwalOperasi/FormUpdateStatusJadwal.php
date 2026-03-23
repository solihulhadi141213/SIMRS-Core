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
        $terlaksana=getDataDetail($Conn,"jadwal_operasi",'id_operasi',$id_operasi,'terlaksana');
?>
        <input type="hidden" name="id_operasi" value="<?php echo $id_operasi; ?>">
        <div class="row">
            <div class="col col-md-12 mb-3">
                <label for="">Status Pelaksanaan Operasi</label>
                <ul>
                    <li>
                        <input type="radio" <?php if($terlaksana==0){echo "checked";} ?> name="terlaksana" id="terlaksana0" value="0">
                        <label for="terlaksana0">Belum terlaksana</label>
                    </li>
                    <li>
                        <input type="radio" <?php if($terlaksana==1){echo "checked";} ?> name="terlaksana" id="terlaksana1" value="1">
                        <label for="terlaksana1">Sudah terlaksana</label>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col col-md-12 mb-3" id="NotifikasiUpdateJadwalOperasi">
                <span class="text-perimary">Pastikan status jadwal operasi sudah sesuai.</span>
            </div>
        </div>
<?php } ?>