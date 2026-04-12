<?php
    date_default_timezone_set('Asia/Jakarta');
    header('Content-Type: application/json');

    // Connection
    include "../../_Config/Connection.php";

    // Function
    include "../../_Config/SimrsFunction.php";

    // Session
    include "../../_Config/Session.php";

    // Response default
    $response = [
        "status" => "error",
        "message" => "Terjadi kesalahan"
    ];

    // Validasi sesi
    if (empty($SessionIdAkses)) {
        $response["message"] = "Sesi akses berakhir, silahkan login ulang.";
        echo json_encode($response);
        exit;
    }

    // Validasi form
    if (
        empty($_POST['id_api_key']) ||
        empty($_POST['api_name']) ||
        empty($_POST['api_description']) ||
        empty($_POST['expired_duration'])
    ) {
        $response["message"] = "Semua field wajib diisi.";
        echo json_encode($response);
        exit;
    }

    // Sanitasi input
    $id_api_key        = validateAndSanitizeInput($_POST['id_api_key']);
    $api_name          = validateAndSanitizeInput($_POST['api_name']);
    $api_description   = validateAndSanitizeInput($_POST['api_description']);
    $expired_duration  = validateAndSanitizeInput($_POST['expired_duration']);
    $datetime_update   = date('Y-m-d H:i:s');

    // Validasi angka durasi
    $allowed_duration = [1, 6, 12, 24];
    if (!in_array((int)$expired_duration, $allowed_duration)) {
        $response["message"] = "Expired duration tidak valid.";
        echo json_encode($response);
        exit;
    }

    // Update database
    $sql = "UPDATE api_key 
            SET 
                api_name = ?, 
                api_description = ?, 
                expired_duration = ?, 
                datetime_update = ?
            WHERE id_api_key = ?";

    $stmt = $Conn->prepare($sql);

    if (!$stmt) {
        $response["message"] = "Gagal prepare statement.";
        echo json_encode($response);
        exit;
    }

    $stmt->bind_param(
        "ssisi",
        $api_name,
        $api_description,
        $expired_duration,
        $datetime_update,
        $id_api_key
    );

    if ($stmt->execute()) {
        $response = [
            "status" => "success",
            "message" => "Data API Key berhasil diperbaharui."
        ];
    } else {
        $response["message"] = "Gagal memperbaharui data.";
    }

    $stmt->close();

    echo json_encode($response);
?>