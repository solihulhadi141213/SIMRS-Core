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
        echo '          Data Kunjungan Tidak Boleh Kosong!';
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
        if(empty($_POST['NamaData'])){
            echo '<div class="modal-body">';
            echo '  <div class="row">';
            echo '      <div class="col-md-12 text-danger text-center">';
            echo '          Nama Data Tidak Boleh Kosong!';
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
            $NamaData=$_POST['NamaData'];
            $NamaDataList = array(
                'keluhan_utama' => 'Keluhan Utama',
                'riwayat_pengobatan' => 'Riwayat Pengobatan',
                'habitus_kebiasaan' => 'Habitus Kebiasaan',
                'riwayat_penyakit_sekarang' => 'Riwayat Penyakit Sekarang',
                'riwayat_penyakit_dahulu' => 'Riwayat Penyakit Dahulu',
            );
            $LabelData=$NamaDataList[$NamaData];
            if($NamaData=="keluhan_utama"){
                $IsiText=getDataDetail($Conn,"anamnesis",'id_kunjungan',$id_kunjungan,'keluhan_utama');
            }else{
                if($NamaData=="riwayat_pengobatan"){
                    $IsiText=getDataDetail($Conn,"anamnesis",'id_kunjungan',$id_kunjungan,'riwayat_pengobatan');
                }else{
                    if($NamaData=="habitus_kebiasaan"){
                        $IsiText=getDataDetail($Conn,"anamnesis",'id_kunjungan',$id_kunjungan,'habitus_kebiasaan');
                    }else{
                        if($NamaData=="riwayat_penyakit_sekarang"){
                            $GetRiwayatPenyakit=getDataDetail($Conn,"anamnesis",'id_kunjungan',$id_kunjungan,'riwayat_penyakit');
                            $JsonRiwayatPenyakit =json_decode($GetRiwayatPenyakit, true);
                            $IsiText=$JsonRiwayatPenyakit['sekarang'];
                        }else{
                            if($NamaData=="riwayat_penyakit_dahulu"){
                                $GetRiwayatPenyakit=getDataDetail($Conn,"anamnesis",'id_kunjungan',$id_kunjungan,'riwayat_penyakit');
                                $JsonRiwayatPenyakit =json_decode($GetRiwayatPenyakit, true);
                                $IsiText=$JsonRiwayatPenyakit['dahulu'];
                            }else{
                                
                            }
                        }
                    }
                }
            }
?>
        <input type="hidden" id="PutIdKunjungan" name="PutIdKunjungan" class="form-control" value="<?php echo "$id_kunjungan"; ?>">
        <input type="hidden" id="NamaData" name="NamaData" class="form-control" value="<?php echo "$NamaData"; ?>">
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    Nama Data : <?php echo "$LabelData"; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label for="RichText">Input Text</label>
                    <div id="RichText"><?php echo "$IsiText"; ?></div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-md-12" id="NotifikasiSimpanRichText">
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
<?php }} ?>