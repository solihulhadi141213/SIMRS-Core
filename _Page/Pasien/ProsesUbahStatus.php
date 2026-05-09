<?php
    // Header JSON
    header('Content-Type: application/json');

    // Connection, Function & Session
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // =========================================================
    // VALIDASI SESSION
    // =========================================================
    if (empty($SessionIdAkses)) {
        echo json_encode([
            "status"  => "error",
            "message" => "Sesi akses sudah berakhir! Silahkan login ulang."
        ]);
        exit;
    }

    // =========================================================
    // VALIDASI INPUT
    // =========================================================
    if (empty($_POST['id_pasien'])) {
        echo json_encode([
            "status"  => "error",
            "message" => "ID Pasien tidak boleh kosong!"
        ]);
        exit;
    }

    if (empty($_POST['status_pasien'])) {
        echo json_encode([
            "status"  => "error",
            "message" => "Status pasien tidak boleh kosong!"
        ]);
        exit;
    }

    // =========================================================
    // SANITASI INPUT
    // =========================================================
    $id_pasien     = validateAndSanitizeInput($_POST['id_pasien']);
    $status_pasien = validateAndSanitizeInput($_POST['status_pasien']);

    // =========================================================
    // VALIDASI STATUS
    // =========================================================
    $allowed_status = ['Active', 'Inactive', 'Deceased'];

    if (!in_array($status_pasien, $allowed_status)) {
        echo json_encode([
            "status"  => "error",
            "message" => "Status pasien tidak valid!"
        ]);
        exit;
    }

    // =========================================================
    // CEK DATA PASIEN
    // =========================================================
    $query_check = "
        SELECT id_pasien
        FROM pasien
        WHERE id_pasien = ?
        LIMIT 1
    ";

    $stmt_check = mysqli_prepare($Conn, $query_check);

    if (!$stmt_check) {
        echo json_encode([
            "status"  => "error",
            "message" => "Gagal prepare query cek pasien : " . mysqli_error($Conn)
        ]);
        exit;
    }

    mysqli_stmt_bind_param($stmt_check, "i", $id_pasien);

    if (!mysqli_stmt_execute($stmt_check)) {
        echo json_encode([
            "status"  => "error",
            "message" => "Gagal execute query cek pasien : " . mysqli_stmt_error($stmt_check)
        ]);
        exit;
    }

    $result_check = mysqli_stmt_get_result($stmt_check);

    if (mysqli_num_rows($result_check) == 0) {
        echo json_encode([
            "status"  => "error",
            "message" => "Data pasien tidak ditemukan!"
        ]);
        exit;
    }

    mysqli_stmt_close($stmt_check);

    // =========================================================
    // UPDATE STATUS PASIEN
    // =========================================================
    $updated_at = date('Y-m-d H:i:s');

    $query_update = "
        UPDATE pasien
        SET 
            status = ?,
            updated_at = ?
        WHERE id_pasien = ?
    ";

    $stmt_update = mysqli_prepare($Conn, $query_update);

    if (!$stmt_update) {
        echo json_encode([
            "status"  => "error",
            "message" => "Gagal prepare update : " . mysqli_error($Conn)
        ]);
        exit;
    }

    mysqli_stmt_bind_param(
        $stmt_update,
        "ssi",
        $status_pasien,
        $updated_at,
        $id_pasien
    );

    if (!mysqli_stmt_execute($stmt_update)) {
        echo json_encode([
            "status"  => "error",
            "message" => "Gagal update status pasien : " . mysqli_stmt_error($stmt_update)
        ]);
        exit;
    }

    mysqli_stmt_close($stmt_update);

    // =========================================================
    // RESPONSE SUCCESS
    // =========================================================
    echo json_encode([
        "status"  => "success",
        "message" => "Status pasien berhasil diperbarui."
    ]);
?>