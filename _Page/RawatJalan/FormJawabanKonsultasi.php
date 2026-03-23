<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap id_konsultasi
    if(empty($_POST['id_konsultasi'])){
        echo '<div class="modal-body">';
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-danger text-center">';
        echo '          ID Konsultasi Tidak Boleh Kosong!';
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
        $id_konsultasi=$_POST['id_konsultasi'];
        //Buka Jawaban Konsultasi
        $jawaban_konsultasi=getDataDetail($Conn,"konsultasi",'id_konsultasi',$id_konsultasi,'jawaban_konsultasi');
        if(!empty($jawaban_konsultasi)){
            $JsonJawabanKonsultasi=json_decode($jawaban_konsultasi, true);
            $penemuan=$JsonJawabanKonsultasi['penemuan'];
            $diagnosa=$JsonJawabanKonsultasi['diagnosa'];
            $saran=$JsonJawabanKonsultasi['saran'];
        }else{
            $penemuan="";
            $diagnosa="";
            $saran="";
        }
        
?>
        <input type="hidden" id="PutIdKonsultasi" name="PutIdKonsultasi" class="form-control" value="<?php echo "$id_konsultasi"; ?>">
        <div class="modal-body">
            <div class="row mb-3">
                <div class="col col-md-4">
                    <label for="tanggal_jawaban">Tanggal</label>
                </div>
                <div class="col col-md-8">
                    <input type="date" name="tanggal_jawaban" id="tanggal_jawaban" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-4">
                    <label for="jam_jawaban">Jam</label>
                </div>
                <div class="col col-md-8">
                    <input type="time" name="jam_jawaban" id="jam_jawaban" class="form-control" value="<?php echo date('H:i'); ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12">
                    <label for="penemuan">Penemuan</label>
                    <div id="penemuan"><?php echo "$penemuan"; ?></div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12">
                    <label for="diagnosa">Diagnosa</label>
                    <div id="diagnosa"><?php echo "$diagnosa"; ?></div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12">
                    <label for="saran">Saran</label>
                    <div id="saran"><?php echo "$saran"; ?></div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-md-12" id="NotifikasiJawabanKonsultasi">
                    <span>
                        Pastikan data yang anda input sudah benar!
                    </span>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-sm btn-primary mr-2">
                <i class="ti-save"></i> Simpan
            </button>
            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                <i class="ti-close"></i> Tutup
            </button>
        </div>
<?php } ?>