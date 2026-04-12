<?php
    date_default_timezone_set('Asia/Jakarta');

    // Connection
    include "../../_Config/Connection.php";

    // Simrs Function
    include "../../_Config/SimrsFunction.php";

    // Session
    include "../../_Config/Session.php";

    // Validasi Session
    if (empty($SessionIdAkses)) {
        echo '
            <div class="alert alert-danger text-center">
                <small>Sesi Akses Sudah Berakhir! Silahkan Login Ulang!</small>
            </div>
        ';
        exit;
    }

    // Validasi id_setting_email_gateway
    if(empty($_POST['id_setting_email_gateway'])){
        echo '
            <div class="alert alert-danger text-center">
                <small>ID Email Gateway Tidak Boleh Kosong!</small>
            </div>
        ';
        exit;
    }

    // Buat Variabel Dan Sanitasi
    $id_setting_email_gateway = validateAndSanitizeInput($_POST['id_setting_email_gateway']);

    // Buka Data Dengan Prepared Statment
    $sql  = "SELECT * FROM  setting_email_gateway WHERE id_setting_email_gateway = ?";
    $stmt = $Conn->prepare($sql);

    // Bind parameter (tipe data integer "i")
    $stmt->bind_param("i", $id_setting_email_gateway);

    // Eksekusi statement
    $stmt->execute();

    // Ambil hasil query
    $result = $stmt->get_result();
    $DataSettingGeneral = $result->fetch_assoc();

    // Simpan hasil ke variabel
    $email_gateway    = $DataSettingGeneral['email_gateway'] ?? null;
    $password_gateway = $DataSettingGeneral['password_gateway'] ?? null;
    $url_provider     = $DataSettingGeneral['url_provider'] ?? null;
    $port_gateway     = $DataSettingGeneral['port_gateway'] ?? null;
    $nama_pengirim    = $DataSettingGeneral['nama_pengirim'] ?? null;
    $url_service      = $DataSettingGeneral['url_service'] ?? null;
    $status           = $DataSettingGeneral['status'] ?? null;

    // Routing Status
    if($status==1){
        $label_status = 'checked';
    }else{
        $label_status = '';
    }

    // Tutup statement
    $stmt->close();

    // Tampilkan Data
    echo '
        <input type="hidden" name="id_setting_email_gateway" value="'.$id_setting_email_gateway.'">
        <div class="row mb-3">
            <div class="col-12">
                <label for="email_gateway_edit"><small>Email Gateway</small></label>
                <input type="email" name="email_gateway" id="email_gateway_edit" class="form-control" value="'.$email_gateway.'" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12">
                <label for="password_gateway_edit"><small>Password Email</small></label>
                <input type="text" name="password_gateway" id="password_gateway_edit" class="form-control" value="'.$password_gateway.'" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12">
                <label for="url_provider_edit"><small>URL Provider</small></label>
                <input type="text" name="url_provider" id="url_provider_edit" class="form-control" value="'.$url_provider.'" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12">
                <label for="port_gateway_edit"><small>Port Gateway</small></label>
                <input type="text" name="port_gateway" id="port_gateway_edit" class="form-control" value="'.$port_gateway.'" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12">
                <label for="nama_pengirim_edit"><small>Nama Pengirim</small></label>
                <input type="text" name="nama_pengirim" id="nama_pengirim_edit" class="form-control" value="'.$nama_pengirim.'" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12">
                <label for="url_service_edit"><small>URL Service</small></label>
                <input type="url" name="url_service" id="url_service_edit" class="form-control" value="'.$url_service.'" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12">
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" id="status_edit" name="status" value="1" '.$label_status.'>
                    <label class="form-check-label" for="status_edit">
                        <small>Aktifkan Profil Pengaturan Ini</small>
                    </label>
                </div>
            </div>
        </div>
    ';

?>