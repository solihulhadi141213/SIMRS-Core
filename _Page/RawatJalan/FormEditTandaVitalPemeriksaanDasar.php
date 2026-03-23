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
        $id_kunjungan=$_POST['id_kunjungan'];
        //Buka Detail Tanda Vital
        $tanda_vital=getDataDetail($Conn,"pemeriksaan_fisik",'id_kunjungan',$id_kunjungan,'tanda_vital');
        //Decode Json
        if(!empty($tanda_vital)){
            $JsonTndaVital =json_decode($tanda_vital, true);
            if(!empty($JsonTndaVital['denyut_jantung'])){
                $denyut_jantung =$JsonTndaVital['denyut_jantung'];
            }else{
                $denyut_jantung ="";
            }
            if(!empty($JsonTndaVital['pernapasan'])){
                $pernapasan =$JsonTndaVital['pernapasan'];
            }else{
                $pernapasan ="";
            }
            if(!empty($JsonTndaVital['sistole'])){
                $sistole =$JsonTndaVital['sistole'];
            }else{
                $sistole ="";
            }
            if(!empty($JsonTndaVital['diastole'])){
                $diastole =$JsonTndaVital['diastole'];
            }else{
                $diastole ="";
            }
            if(!empty($JsonTndaVital['suhu'])){
                $suhu =$JsonTndaVital['suhu'];
            }else{
                $suhu ="";
            }
            if(!empty($JsonTndaVital['SpO2'])){
                $SpO2 =$JsonTndaVital['SpO2'];
            }else{
                $SpO2 ="";
            }
            if(!empty($JsonTndaVital['tinggi_badan'])){
                $tinggi_badan =$JsonTndaVital['tinggi_badan'];
            }else{
                $tinggi_badan ="";
            }
            if(!empty($JsonTndaVital['berat_badan'])){
                $berat_badan =$JsonTndaVital['berat_badan'];
            }else{
                $berat_badan ="";
            }
        }else{
            $JsonTndaVital ="";
            $denyut_jantung ="";
            $pernapasan ="";
            $sistole ="";
            $diastole ="";
            $suhu ="";
            $SpO2 ="";
            $tinggi_badan ="";
            $berat_badan ="";
        }
        
?>
    <input type="hidden" name="IdKunjunganTandaVital" id="IdKunjunganTandaVital" value="<?php echo $id_kunjungan; ?>">
    <div class="modal-body">
        <div class="row mb-4">
            <div class="col-md-4 mb-2">
                <label for="denyut_jantung">1. Denyut Jantung</label>
            </div>
            <div class="col-md-8 mb-2">
                <input type="number" min="0" step="0.01" id="denyut_jantung" name="denyut_jantung" class="form-control" value="<?php  echo "$denyut_jantung";?>">
                <small>Unit/Satuan: X/Menit</small>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-4 mb-2">
                <label for="pernapasan">2. Pernapasan</label>
            </div>
            <div class="col-md-8 mb-2">
                <input type="number" min="0" step="0.01" id="pernapasan" name="pernapasan" class="form-control" value="<?php  echo "$pernapasan";?>">
                <small>Unit/Satuan: X/Menit</small>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-4 mb-2">
                <label for="sistole">3. TD (Sistole)</label>
            </div>
            <div class="col-md-8 mb-2">
                <input type="number" min="0" id="sistole" name="sistole" class="form-control" value="<?php  echo "$sistole";?>">
                <small>Unit/Satuan: /mmHg</small>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-4 mb-2">
                <label for="diastole">4. TD (Diastole)</label>
            </div>
            <div class="col-md-8 mb-2">
                <input type="number" min="0" id="diastole" name="diastole" class="form-control" value="<?php  echo "$diastole";?>">
                <small>Unit/Satuan: /mmHg</small>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-4 mb-2">
                <label for="suhu">5. Suhu</label>
            </div>
            <div class="col-md-8 mb-2">
                <input type="number" min="0" id="suhu" name="suhu" class="form-control" value="<?php  echo "$suhu";?>">
                <small>Unit/Satuan: &#176;C</small>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-4 mb-2">
                <label for="SpO2">6. SpO2</label>
            </div>
            <div class="col-md-8 mb-2">
                <input type="number" min="0" id="SpO2" name="SpO2" class="form-control" value="<?php  echo "$SpO2";?>">
                <small>Unit/Satuan: %</small>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-4 mb-2">
                <label for="tinggi_badan">7. Tinggi Badan</label>
            </div>
            <div class="col-md-8 mb-2">
                <input type="number" min="0.00" step="0.01" id="tinggi_badan" name="tinggi_badan" class="form-control" value="<?php  echo "$tinggi_badan";?>">
                <small>Unit/Satuan: Cm</small>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-4 mb-2">
                <label for="berat_badan">8. Berat Badan</label>
            </div>
            <div class="col-md-8 mb-2">
                <input type="number" min="0.00" step="0.01" id="berat_badan" name="berat_badan" class="form-control" value="<?php  echo "$berat_badan";?>">
                <small>Unit/Satuan: Kg</small>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-12 mb-2" id="NotifikasiEditTandaVital">
                <span class="text-primary">Pastikan data yang anda input sudah sesuai.</span>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-sm btn-primary mr-3">
            <i class="ti ti-save"></i> Simpan
        </button>
        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">
            <i class="ti ti-close"></i> Tutup
        </button>
    </div>
<?php } ?>