<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap conceptId
    if(empty($_POST['conceptId'])){
        echo '<div class="card-body border-0 pb-0">';
        echo '  <div class="row">';
        echo '      <div class="col-md-6 mb-3">';
        echo '          ID Snomed Tidak Dapat didefinisikan.';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        $conceptId=$_POST['conceptId'];
        $term=getDataDetail($Conn,'snomed','conceptId',$conceptId,'term');
        $languageCode=getDataDetail($Conn,'snomed','conceptId',$conceptId,'languageCode');
        $Definisi=getDataDetail($Conn,'snomed_definition','conceptId',$conceptId,'term');
?>
    <div class="row"> 
        <div class="col-md-4"><dt>ID Snomed</dt></div>
        <div class="col-md-8"><?php echo $conceptId; ?></div>
    </div>
    <div class="row"> 
        <div class="col-md-4"><dt>Bahasa</dt></div>
        <div class="col-md-8"><?php echo $languageCode; ?></div>
    </div>
    <div class="row"> 
        <div class="col-md-4"><dt>Deskripsi</dt></div>
        <div class="col-md-8"><?php echo $term; ?></div>
    </div>
    <div class="row"> 
        <div class="col-md-4"><dt>Definisi</dt></div>
        <div class="col-md-8"><?php echo $Definisi; ?></div>
    </div>
<?php } ?>