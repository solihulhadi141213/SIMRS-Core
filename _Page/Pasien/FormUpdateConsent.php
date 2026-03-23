<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Menangkap ID_PATIENT
    if(empty($_POST['id_patient'])){
        echo '<div class="row">';
        echo '<div class="col-md-12 text-center"><span class="text-danger">ID IHS Pasien Tidak Boleh Kosong</span></div>';
        echo '</div>';
    }else{
        $id_patient=$_POST['id_patient'];
?>
    <div class="row mb-3">
        <div class="col-md-4"><label for="patient_id">ID Patient</label></div>
        <div class="col-md-8">
            <input type="text" readonly class="form-control" name="patient_id" id="patient_id" value="<?php echo "$id_patient"; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4"><label for="agent">Agent</label></div>
        <div class="col-md-8">
            <input type="text" readonly class="form-control" name="agent" id="agent" value="<?php echo "$SessionNama"; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4"><label for="action">Action</label></div>
        <div class="col-md-8">
            <select name="action" id="action" class="form-control">
                <option value="">Pilih</option>
                <option value="OPTIN">OPTIN</option>
                <option value="OPTOUT">OPTOUT</option>
            </select>
        </div>
    </div>
<?php } ?>