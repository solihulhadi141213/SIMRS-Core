<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap id_referensi_alergi
    if(empty($_POST['id_referensi_alergi'])){
        echo '<div class="card-body border-0 pb-0">';
        echo '  <div class="row">';
        echo '      <div class="col-md-6 mb-3">';
        echo '          ID Loinc Tidak Boleh Kosong.';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_referensi_alergi=$_POST['id_referensi_alergi'];
        $code=getDataDetail($Conn,'referensi_alergi','id_referensi_alergi',$id_referensi_alergi,'code');
        $display=getDataDetail($Conn,'referensi_alergi','id_referensi_alergi',$id_referensi_alergi,'display');
        $sumber=getDataDetail($Conn,'referensi_alergi','id_referensi_alergi',$id_referensi_alergi,'sumber');
?>
    <input type="hidden" name="id_referensi_alergi" value="<?php echo "$id_referensi_alergi"; ?>">
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="code">Code</label>
        </div>
        <div class="col-md-8">
            <input type="text" name="code" id="code" class="form-control" placeholder="Ex: AL000043" value="<?php echo "$code"; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="display">Display</label>
        </div>
        <div class="col-md-8">
            <input type="text" name="display" id="display" class="form-control" placeholder="Ex: Debu Rumah" value="<?php echo "$display"; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="sumber">Sumber</label>
        </div>
        <div class="col-md-8">
            <input type="text" name="sumber" id="sumber" class="form-control" placeholder="http://terminology.kemkes.go.id/CodeSystem/clinical-term" value="<?php echo "$sumber"; ?>">
        </div>
    </div>
<?php } ?>