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

    // Validasi id_setting_google
    if(empty($_POST['id_setting_google'])){
        echo '
            <div class="alert alert-danger text-center">
                <small>ID Setting Google Tidak Boleh Kosong!</small>
            </div>
        ';
        exit;
    }

    // Buat Variabel Dan Sanitasi
    $id_setting_google = validateAndSanitizeInput($_POST['id_setting_google']);

    // Buka Data Dengan Prepared Statment
    $sql  = "SELECT * FROM  setting_google WHERE id_setting_google = ?";
    $stmt = $Conn->prepare($sql);

    // Bind parameter (tipe data integer "i")
    $stmt->bind_param("i", $id_setting_google);

    // Eksekusi statement
    $stmt->execute();

    // Ambil hasil query
    $result = $stmt->get_result();
    $DataSettingGeneral = $result->fetch_assoc();

    // Simpan hasil ke variabel
    $credential_env = $DataSettingGeneral['credential_env'] ?? null;
    $client_id      = $DataSettingGeneral['client_id'] ?? null;
    $client_secret  = $DataSettingGeneral['client_secret'] ?? null;
    $status         = $DataSettingGeneral['status'] ?? null;

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
        <input type="hidden" name="id_setting_google" value="'.$id_setting_google.'">
        <div class="row mb-3">
            <div class="col-12">
                <label for="credential_env_edit"><small>Nama Kredensial</small></label>
                <input type="text" name="credential_env" id="credential_env_edit" class="form-control" value="'.$credential_env.'" placeholder="Contoh : Development" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12">
                <label for="client_id_edit"><small><i>Client ID</i></small></label>
                <input type="text" name="client_id" id="client_id_edit" class="form-control" value="'.$client_id.'" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12">
                <label for="client_secret_edit"><small><i>Client Secret</i></small></label>
                <input type="text" name="client_secret" id="client_secret_edit" class="form-control" value="'.$client_secret.'" required>
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