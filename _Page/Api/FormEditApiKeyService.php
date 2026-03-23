<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap id_akses
    if(empty($_POST['id_api_access'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center text-danger">';
        echo '      ID API Service Key Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_api_access=$_POST['id_api_access'];
        $api_name=getDataDetail($Conn,'api_access','id_api_access',$id_api_access,'api_name');
        $api_description=getDataDetail($Conn,'api_access','id_api_access',$id_api_access,'api_description');
        $client_id=getDataDetail($Conn,'api_access','id_api_access',$id_api_access,'client_id');
        $client_key=getDataDetail($Conn,'api_access','id_api_access',$id_api_access,'client_key');
        $token=getDataDetail($Conn,'api_access','id_api_access',$id_api_access,'token');
        $expired_duration=getDataDetail($Conn,'api_access','id_api_access',$id_api_access,'expired_duration');
?>
    <input type="hidden" name="id_api_access" value="<?php echo "$id_api_access"; ?>">
    <div class="row mb-3">
        <div class="col-md-12">
            <label for="api_name_edit">Nama API Key</label>
            <input type="text" name="api_name" id="api_name_edit" class="form-control" value="<?php echo "$api_name"; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <label for="api_description_edit">Deskripsi</label>
            <textarea name="api_description" id="api_description_edit" class="form-control"><?php echo "$api_description"; ?></textarea>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <label for="client_id_edit">Client ID</label>
            <div class="input-group">
                <input type="text" name="client_id" id="client_id_edit" class="form-control client_id" value="<?php echo "$client_id"; ?>">
                <button type="button" class="btn btn-sm btn-outline-dark" id="GenerateClientIdEdit">
                    <i class="ti ti-reload"></i> Generate
                </button>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <label for="client_key_edit">Client Key</label>
            <div class="input-group">
                <input type="text" name="client_key" id="client_key_edit" class="form-control client_key" value="<?php echo "$client_key"; ?>">
                <button type="button" class="btn btn-sm btn-outline-dark" id="GenerateClientKeyEdit">
                    <i class="ti ti-reload"></i> Generate
                </button>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <label for="expired_duration_edit">Durasi Expired</label>
            <input type="number" min="0" name="expired_duration" id="expired_duration_edit" class="form-control" value="<?php echo "$expired_duration"; ?>">
            <small>Dalam satuan Milisecond</small>
        </div>
    </div>
<?php } ?>