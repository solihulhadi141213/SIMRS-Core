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
        //Buka Permintaan Konsultasi
        $permintaan_konsultasi=getDataDetail($Conn,"konsultasi",'id_konsultasi',$id_konsultasi,'permintaan_konsultasi');
        if(!empty($permintaan_konsultasi)){
            $JsonPermintaanKonsultasi=json_decode($permintaan_konsultasi, true);
            $diagnosa_kerja=$JsonPermintaanKonsultasi['diagnosa_kerja'];
            $ikhtisar_klinis=$JsonPermintaanKonsultasi['ikhtisar_klinis'];
            $konsul_diminta=$JsonPermintaanKonsultasi['konsul_diminta'];
        }else{
            $diagnosa_kerja="";
            $ikhtisar_klinis="";
            $konsul_diminta="";
        }
        
?>
        <input type="hidden" id="PutIdKonsultasi" name="PutIdKonsultasi" class="form-control" value="<?php echo "$id_konsultasi"; ?>">
        <div class="modal-body">
            <div class="row mb-3">
                <div class="col-md-12">
                    <label for="diagnosa_kerja">Diagnosa Kerja</label>
                    <div id="diagnosa_kerja"><?php echo "$diagnosa_kerja"; ?></div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12">
                    <label for="ikhtisar_klinis">Ikhtisar Klinis</label>
                    <div id="ikhtisar_klinis"><?php echo "$ikhtisar_klinis"; ?></div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12">
                    <label for="konsul_diminta">Konsul Yang Diminta</label>
                    <div id="konsul_diminta"><?php echo "$konsul_diminta"; ?></div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-md-12" id="NotifikasiPermintaanKonsultasi">
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