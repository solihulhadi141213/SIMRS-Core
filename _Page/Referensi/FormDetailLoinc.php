<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap loinc_num
    if(empty($_POST['loinc_num'])){
        echo '<div class="card-body border-0 pb-0">';
        echo '  <div class="row">';
        echo '      <div class="col-md-6 mb-3">';
        echo '          ID Loinc Tidak Boleh Kosong.';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        $loinc_num=$_POST['loinc_num'];
        $component=getDataDetail($Conn,'loinc','loinc_num',$loinc_num,'component');
        $property=getDataDetail($Conn,'loinc','loinc_num',$loinc_num,'property');
        $time_aspct=getDataDetail($Conn,'loinc','loinc_num',$loinc_num,'time_aspct');
        $system=getDataDetail($Conn,'loinc','loinc_num',$loinc_num,'system');
        $scale_typ=getDataDetail($Conn,'loinc','loinc_num',$loinc_num,'scale_typ');
        $method_typ=getDataDetail($Conn,'loinc','loinc_num',$loinc_num,'method_typ');
?>
    <div class="row"> 
        <div class="col-md-4"><dt>Loinc Num</dt></div>
        <div class="col-md-8"><?php echo $loinc_num; ?></div>
    </div>
    <div class="row"> 
        <div class="col-md-4"><dt>Component</dt></div>
        <div class="col-md-8"><?php echo $component; ?></div>
    </div>
    <div class="row"> 
        <div class="col-md-4"><dt>Property</dt></div>
        <div class="col-md-8"><?php echo $property; ?></div>
    </div>
    <div class="row"> 
        <div class="col-md-4"><dt>Time Aspct</dt></div>
        <div class="col-md-8"><?php echo $time_aspct; ?></div>
    </div>
    <div class="row"> 
        <div class="col-md-4"><dt>System</dt></div>
        <div class="col-md-8"><?php echo $system; ?></div>
    </div>
    <div class="row"> 
        <div class="col-md-4"><dt>Scale Typ</dt></div>
        <div class="col-md-8"><?php echo $scale_typ; ?></div>
    </div>
    <div class="row"> 
        <div class="col-md-4"><dt>Method Typ</dt></div>
        <div class="col-md-8"><?php echo $method_typ; ?></div>
    </div>
<?php } ?>