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

    // Validasi id_api_key
    if(empty($_POST['id_api_key'])){
        echo '
            <div class="alert alert-danger text-center">
                <small>ID API Key Tidak Boleh Kosong!</small>
            </div>
        ';
        exit;
    }

    // Buat Variabel Dan Sanitasi
    $id_api_key = validateAndSanitizeInput($_POST['id_api_key']);

    // Buka Data Dengan Prepared Statment
    $sql  = "SELECT * FROM  api_key WHERE id_api_key = ?";
    $stmt = $Conn->prepare($sql);

    // Bind parameter (tipe data integer "i")
    $stmt->bind_param("i", $id_api_key);

    // Eksekusi statement
    $stmt->execute();

    // Ambil hasil query
    $result = $stmt->get_result();
    $DataSettingGeneral = $result->fetch_assoc();

    // Simpan hasil ke variabel
    $api_name         = $DataSettingGeneral['api_name'] ?? null;
    $api_description  = $DataSettingGeneral['api_description'] ?? null;
    $client_id        = $DataSettingGeneral['client_id'] ?? null;
    $expired_duration = $DataSettingGeneral['expired_duration'] ?? null;
    $datetime_creat   = $DataSettingGeneral['datetime_creat'] ?? null;
    $datetime_update  = $DataSettingGeneral['datetime_update'] ?? null;

    // Tutup statement
    $stmt->close();

    // Tampilkan Data
    echo '
        <input type="hidden" name="id_api_key" value="'.$id_api_key.'">
        <div class="row mb-3">
            <div class="col-12">
                <label for="client_id_edit">
                    <small>
                        <i>Client ID</i>
                    </small>
                </label>
                <div class="input-group">
                    <input type="text" class="form-control" name="client_id" id="client_id_edit" value="'.$client_id.'" required>
                    <button class="btn btn-sm btn btn-outline-secondary generate_client_id_edit" type="button" title="Generate Client ID">
                        <i class="bi bi-repeat"></i> Generate
                    </button>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12">
                <label for="client_key_edit">
                    <small>
                        <i>Client Key</i>
                    </small>
                </label>
                <div class="input-group">
                    <input type="text" class="form-control" name="client_key" id="client_key_edit" required>
                    <button class="btn btn-sm btn btn-outline-secondary generate_client_key_edit" type="button" title="Generate Client Key">
                        <i class="bi bi-repeat"></i> Generate
                    </button>
                </div>
            </div>
        </div>
    ';

?>