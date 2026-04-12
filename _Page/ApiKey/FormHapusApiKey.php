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
        <div class="row mb-2">
            <div class="col-4"><small>Nama API</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text text-muted">'.$api_name.'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Deskripsi</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text text-muted">'.$api_description.'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small><i>Client ID</i></small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <small class="d-inline-flex px-1 py-1 text-muted bg-info-subtle border border-info-subtle rounded-2">
                    '.$client_id.'
                </small>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small><i>Expired Duration</i></small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text text-muted">'.$expired_duration.' Hour</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small><i>Datetime Creat</i></small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text text-muted">'.date('d/m/Y', strtotime($datetime_creat)).'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small><i>Datetime Update</i></small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text text-muted">'.date('d/m/Y', strtotime($datetime_update)).'</small></div>
        </div>
        <div class="row mt-3">
            <div class="col-12 text-center">
                <div class="alert alert-warning">
                    <b>PENTING!</b><br>
                    <small>Menghapus API Key akan menyebabkan client tidak dapat menggunakan resource yang ada .</small><br>
                    <small><b>Apakah Anda Yakin Akan Menghapus Data Tersebut?</b></small>

                </div>
            </div>
        </div>
    ';

?>