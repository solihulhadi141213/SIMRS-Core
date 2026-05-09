<?php
    // Header JSON
    header('Content-Type: application/json');

    // Connection
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";

    // Validasi ID Pasien
    if (empty($_POST['id_pasien'])) {
        echo json_encode([
            "status"  => "error",
            "message" => "ID pasien tidak boleh kosong"
        ]);
        exit;
    }

    // Sanitasi
    $id_pasien = validateAndSanitizeInput($_POST['id_pasien']);

    // Query Pasien
    $stmt = mysqli_prepare($Conn, "
        SELECT
            id_pasien,
            nama,
            province,
            regency,
            subdistrict,
            village,
            street,
            postal_code,
            kontak
        FROM pasien
        WHERE id_pasien = ?
        LIMIT 1
    ");

    mysqli_stmt_bind_param($stmt, "s", $id_pasien);

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    // Validasi Data
    if (mysqli_num_rows($result) == 0) {

        echo json_encode([
            "status"  => "error",
            "message" => "Data pasien tidak ditemukan"
        ]);
        exit;
    }

    // Fetch
    $row = mysqli_fetch_assoc($result);

    // Response
    echo json_encode([
        "status"   => "success",
        "message"  => "Data pasien ditemukan",
        "metadata" => $row
    ]);
    exit;
?>