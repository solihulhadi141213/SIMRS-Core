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
        $label_status = '<span class="text text-success">Aktif</span>';
    }else{
        $label_status = '<span class="text text-danger">No Aktif</span>';
    }

    // Tutup statement
    $stmt->close();

    // Tampilkan Data
    echo '
        <div class="row mb-2">
            <div class="col-4"><small>Email Gateway</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text text-muted">'.$email_gateway.'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Password</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text text-muted">'.$password_gateway.'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>URL Provider</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text text-muted">'.$url_provider.'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Port gateway</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text text-muted">'.$port_gateway.'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Nama Pengirim</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text text-muted">'.$nama_pengirim.'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>URL Service</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text text-muted">'.$url_service.'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Status</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text">'.$label_status.'</small></div>
        </div>
    ';

?>