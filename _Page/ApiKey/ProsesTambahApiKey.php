<?php
    // Header JSON
    header('Content-Type: application/json');

    // Zona waktu
    date_default_timezone_set('Asia/Jakarta');

    // Connection
    include "../../_Config/Connection.php";

    // Simrs Function
    include "../../_Config/SimrsFunction.php";

    // Session
    include "../../_Config/Session.php";

    // ==================================================
    // 1. VALIDASI SESI AKSES
    // ==================================================
    if (empty($SessionIdAkses)) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Sesi akses sudah berakhir, silakan login ulang.'
        ]);
        exit;
    }

    // ==================================================
    // 2. AMBIL DATA POST
    // ==================================================
    $api_name         = trim($_POST['api_name'] ?? '');
    $api_description  = trim($_POST['api_description'] ?? '');
    $client_id        = trim($_POST['client_id'] ?? '');
    $client_key       = trim($_POST['client_key'] ?? '');
    $expired_duration = trim($_POST['expired_duration'] ?? '');

    // ==================================================
    // 3. VALIDASI FORM MANDATORY
    // ==================================================
    if (
        empty($api_name) ||
        empty($api_description) ||
        empty($client_id) ||
        empty($client_key) ||
        empty($expired_duration)
    ) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Semua field wajib harus diisi.'
        ]);
        exit;
    }

    // ==================================================
    // 4. VALIDASI JUMLAH KARAKTER
    // ==================================================
    if (strlen($api_name) > 250) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Nama API maksimal 250 karakter.'
        ]);
        exit;
    }

    if (strlen($api_description) > 1000) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Deskripsi maksimal 1000 karakter.'
        ]);
        exit;
    }

    if (strlen($client_id) > 250) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Client ID maksimal 250 karakter.'
        ]);
        exit;
    }

    if (strlen($client_key) > 1000) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Client Key terlalu panjang.'
        ]);
        exit;
    }

    // Validasi expired duration angka
    if (!is_numeric($expired_duration)) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Expired duration harus berupa angka.'
        ]);
        exit;
    }

    // ==================================================
    // 5. DATETIME CREATE & UPDATE
    // ==================================================
    $datetime_now = date('Y-m-d H:i:s');

    // ==================================================
    // 6. INSERT DATA
    // ==================================================
    $client_key = password_hash($client_key, PASSWORD_DEFAULT);
    $stmt = $Conn->prepare("
        INSERT INTO api_key (
            api_name,
            api_description,
            client_id,
            client_key,
            expired_duration,
            datetime_creat,
            datetime_update
        ) VALUES (?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->bind_param(
        "ssssiss",
        $api_name,
        $api_description,
        $client_id,
        $client_key,
        $expired_duration,
        $datetime_now,
        $datetime_now
    );

    $execute = $stmt->execute();

    // ==================================================
    // 7. RESPONSE
    // ==================================================
    if ($execute) {
        echo json_encode([
            'status'  => 'success',
            'message' => 'API Key berhasil ditambahkan.'
        ]);
    } else {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Gagal menyimpan data API Key.'
        ]);
    }

    $stmt->close();
?>