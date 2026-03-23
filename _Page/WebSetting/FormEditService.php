<?php
    //Koneksi
    include "../../_Config/Connection.php";
    if(empty($_POST['id_setting_service'])){
        echo "ID Service Tidak Boleh Kosong!";
    }else{
        $id_setting_service=$_POST['id_setting_service'];
        //Buka Detail service
        $QryWebService = mysqli_query($Conn,"SELECT * FROM setting_service WHERE id_setting_service='$id_setting_service'")or die(mysqli_error($Conn));
        $DataWebService = mysqli_fetch_array($QryWebService);
        $id_setting_service= $DataWebService['id_setting_service'];
        $service_name= $DataWebService['service_name'];
        $service_category= $DataWebService['service_category'];
        $url_service= $DataWebService['url_service'];
        $last_update= $DataWebService['last_update'];
?>
    <input type="hidden" name="id_setting_service" id="id_setting_service" value="<?php echo "$id_setting_service"; ?>">
    <div class="row">
        <div class="col-md-12 mt-3">
            <label for="service_name">Nama Service</label>
            <input type="text" name="service_name" id="service_name" class="form-control" value="<?php echo "$service_name"; ?>">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mt-3">
            <label for="service_category">Kategori</label>
            <input type="text" name="service_category" id="service_category_edit" class="form-control" value="<?php echo "$service_category"; ?>">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mt-3">
            <label for="url_service">URL Service</label>
            <input type="text" name="url_service" id="url_service" class="form-control" value="<?php echo "$url_service"; ?>">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mt-3" id="NotifikasiEditService">
            <span class="text-primary">
                Pastikan Service yang input sudah benar.
            </span>
        </div>
    </div>
<?PHP } ?>