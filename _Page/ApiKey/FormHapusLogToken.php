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

     // Hitung Log Token
    $log_token = mysqli_num_rows(mysqli_query($Conn, "SELECT id_api_token FROM api_token WHERE id_api_key='$id_api_key'"));
    if ($log_token >= 1000000) {
        $log_token_show = round($log_token / 1000000, 1) . ' M';
    } elseif ($log_token >= 1000) {
        $log_token_show = round($log_token / 1000, 1) . ' K';
    } else {
        $log_token_show = $log_token;
    }

    // Tutup statement
    $stmt->close();

    // Tampilkan Data
    echo '
        <input type="hidden" name="id_api_key" value="'.$id_api_key.'">
        <div class="row mb-3">
            <div class="col-12 text-center">
                <h3>'.$log_token_show.'</h3>
                <small>Record</small>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12 text-center">
                <div class="alert alert-warning">
                    <b>PENTING!</b><br>
                    <small>Menghapus Riwayat Token API Key Mungkin Akan Menghentikan Ijin Akses Service Dalam Waktu Bersamaan.</small><br>
                    <small><b>Apakah Anda Yakin Akan Menghapus Data Tersebut?</b></small>

                </div>
            </div>
        </div>
    ';

?>