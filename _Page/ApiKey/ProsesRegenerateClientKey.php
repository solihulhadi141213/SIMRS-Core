<?php
    date_default_timezone_set('Asia/Jakarta');
    header('Content-Type: application/json');

    // Connection
    include "../../_Config/Connection.php";

    // Simrs Function
    include "../../_Config/SimrsFunction.php";

    // Session
    include "../../_Config/Session.php";

    // Default response
    $response = [
        "status" => "error",
        "message" => "Terjadi kesalahan"
    ];

    // ==================================================
    // VALIDASI SESSION
    // ==================================================
    if (empty($SessionIdAkses)) {
        $response["message"] = "Sesi akses sudah berakhir. Silakan login ulang.";
        echo json_encode($response);
        exit;
    }

    // ==================================================
    // VALIDASI FORM
    // ==================================================
    if (
        empty($_POST['id_api_key']) ||
        empty($_POST['client_id']) ||
        empty($_POST['client_key'])
    ) {
        $response["message"] = "Semua field wajib diisi.";
        echo json_encode($response);
        exit;
    }

    // ==================================================
    // SANITASI INPUT
    // ==================================================
    $id_api_key      = validateAndSanitizeInput($_POST['id_api_key']);
    $client_id       = validateAndSanitizeInput($_POST['client_id']);
    $client_key_raw  = trim($_POST['client_key']);
    $datetime_update = date('Y-m-d H:i:s');

    // ==================================================
    // HASH CLIENT KEY
    // ==================================================
    $client_key_hash = password_hash($client_key_raw, PASSWORD_DEFAULT);

    // ==================================================
    // UPDATE DATABASE
    // ==================================================
    $sql = "UPDATE api_key 
            SET 
                client_id = ?, 
                client_key = ?, 
                datetime_update = ?
            WHERE id_api_key = ?";

    $stmt = $Conn->prepare($sql);

    if (!$stmt) {
        $response["message"] = "Gagal prepare statement.";
        echo json_encode($response);
        exit;
    }

    $stmt->bind_param(
        "sssi",
        $client_id,
        $client_key_hash,
        $datetime_update,
        $id_api_key
    );

    if ($stmt->execute()) {
        $response = [
            "status" => "success",
            "message" => "Client Key berhasil diperbarui."
        ];
    } else {
        $response["message"] = "Gagal memperbarui Client Key.";
    }

    $stmt->close();

    echo json_encode($response);
?>