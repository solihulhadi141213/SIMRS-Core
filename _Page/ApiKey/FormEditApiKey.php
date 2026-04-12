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

    if($expired_duration==1){
        $select_duration_1 = "selected";
        $select_duration_2 = "";
        $select_duration_3 = "";
        $select_duration_4 = "";
    }else{
        if($expired_duration==6){
            $select_duration_1 = "";
            $select_duration_2 = "selected";
            $select_duration_3 = "";
            $select_duration_4 = "";
        }else{
            if($expired_duration==12){
                $select_duration_1 = "";
                $select_duration_2 = "";
                $select_duration_3 = "selected";
                $select_duration_4 = "";
            }else{
                if($expired_duration==24){
                    $select_duration_1 = "";
                    $select_duration_2 = "";
                    $select_duration_3 = "";
                    $select_duration_4 = "selected";
                }else{
                    $select_duration_1 = "";
                    $select_duration_2 = "";
                    $select_duration_3 = "";
                    $select_duration_4 = "";
                }
            }
        }
    }

    // Tutup statement
    $stmt->close();

    // Tampilkan Data
    echo '
        <input type="hidden" name="id_api_key" value="'.$id_api_key.'">
        <div class="row mb-3">
            <div class="col-12">
                <label for="api_name_edit"><small>Nama API Key</small></label>
                <input type="text" name="api_name" id="api_name_edit" class="form-control" required placeholder="Contoh : Aplikasi Radiologi, Aplikasi LMS" value="'.$api_name.'">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12">
                <label for="api_description_edit"><small>Deskripsi</small></label>
                <textarea name="api_description" id="api_description_edit" required class="form-control">'.$api_description.'</textarea>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12">
                <label for="expired_duration_edit"><small>
                    <small><i>Expired Duration</i></small>
                </small></label>
                <select name="expired_duration" id="expired_duration_edit" class="form-control" required>
                    <option value="">Pilih</option>
                    <option '.$select_duration_1.' value="1">1 Jam</option>
                    <option '.$select_duration_2.' value="6">6 Jam</option>
                    <option '.$select_duration_3.' value="12">12 Jam</option>
                    <option '.$select_duration_4.' value="24">24 Jam</option>
                </select>
            </div>
        </div>
    ';

?>