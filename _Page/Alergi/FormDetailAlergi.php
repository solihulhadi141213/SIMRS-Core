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
    <div class="row mb-3"> 
        <div class="col-md-4"><dt>ID</dt></div>
        <div class="col-md-8 text-right"><?php echo $id_referensi_alergi; ?></div>
    </div>
    <div class="row mb-3"> 
        <div class="col-md-4"><dt>Code</dt></div>
        <div class="col-md-8 text-right"><?php echo $code; ?></div>
    </div>
    <div class="row mb-3"> 
        <div class="col-md-4"><dt>Display</dt></div>
        <div class="col-md-8 text-right"><?php echo $display; ?></div>
    </div>
    <div class="row mb-3"> 
        <div class="col-md-4"><dt>Referensi</dt></div>
        <div class="col-md-8 text-right"><small><?php echo $sumber; ?></small></div>
    </div>
    <div class="row mb-3"> 
        <div class="col-md-6 mb-2">
            <button type="button" class="btn btn-sm btn-block btn-outline-secondary" data-toggle="modal" data-target="#ModalEditAlergi" data-id="<?php echo "$id_referensi_alergi"; ?>">
                <i class="ti ti-pencil"></i> Edit
            </button>
        </div>
        <div class="col-md-6 mb-2">
            <button type="button" class="btn btn-sm btn-block btn-outline-secondary" data-toggle="modal" data-target="#ModalHapusAlergi" data-id="<?php echo "$id_referensi_alergi"; ?>">
                <i class="ti ti-trash"></i> Hapus
            </button>
        </div>
    </div>
<?php } ?>