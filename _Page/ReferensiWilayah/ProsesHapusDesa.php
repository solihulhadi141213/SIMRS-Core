<?php
    // ======================================================
    // TIME ZONE
    // ======================================================
    date_default_timezone_set('Asia/Jakarta');

    // ======================================================
    // CONNECTION, FUNCTION & SESSION
    // ======================================================
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // ======================================================
    // HEADER JSON
    // ======================================================
    header('Content-Type: application/json');

    // ======================================================
    // RESPONSE DEFAULT
    // ======================================================
    $response = [
        "status"  => "error",
        "message" => "Terjadi kesalahan."
    ];

    // ======================================================
    // VALIDASI SESSION
    // ======================================================
    if (empty($SessionIdAkses)) {

        $response["message"] = "Sesi akses sudah berakhir, silakan login ulang.";

        echo json_encode($response);
        exit;
    }

    // ======================================================
    // VALIDASI METHOD
    // ======================================================
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

        $response["message"] = "Metode request tidak valid.";

        echo json_encode($response);
        exit;
    }

    // ======================================================
    // VALIDASI ID WILAYAH
    // ======================================================
    if (empty($_POST['id_wilayah'])) {

        $response["message"] = "ID wilayah tidak boleh kosong.";

        echo json_encode($response);
        exit;
    }

    // ======================================================
    // SANITIZE INPUT
    // ======================================================
    $id_wilayah = (int) validateAndSanitizeInput($_POST['id_wilayah']);

    // ======================================================
    // VALIDASI DATA WILAYAH
    // ======================================================
    $query_check = "
        SELECT 
            id_wilayah
        FROM wilayah
        WHERE id_wilayah = ?
        LIMIT 1
    ";

    $stmt_check = mysqli_prepare($Conn, $query_check);

    if (!$stmt_check) {

        $response["message"] = "Gagal mempersiapkan query validasi.";

        echo json_encode($response);
        exit;
    }

    mysqli_stmt_bind_param($stmt_check, "i", $id_wilayah);

    if (!mysqli_stmt_execute($stmt_check)) {

        mysqli_stmt_close($stmt_check);

        $response["message"] = "Gagal mengeksekusi query validasi.";

        echo json_encode($response);
        exit;
    }

    $result_check = mysqli_stmt_get_result($stmt_check);

    if (!$result_check || mysqli_num_rows($result_check) == 0) {

        mysqli_stmt_close($stmt_check);

        $response["message"] = "Data wilayah tidak ditemukan.";

        echo json_encode($response);
        exit;
    }

    mysqli_stmt_close($stmt_check);

    // ======================================================
    // DELETE DATA
    // ======================================================
    $query_delete = "
        DELETE FROM wilayah
        WHERE id_wilayah = ?
    ";

    $stmt_delete = mysqli_prepare($Conn, $query_delete);

    if (!$stmt_delete) {

        $response["message"] = "Gagal mempersiapkan query hapus.";

        echo json_encode($response);
        exit;
    }

    mysqli_stmt_bind_param($stmt_delete, "i", $id_wilayah);

    if (!mysqli_stmt_execute($stmt_delete)) {

        mysqli_stmt_close($stmt_delete);

        $response["message"] = "Gagal menghapus data wilayah.";

        echo json_encode($response);
        exit;
    }

    mysqli_stmt_close($stmt_delete);

    // ======================================================
    // SUCCESS RESPONSE
    // ======================================================
    $response = [
        "status"  => "success",
        "message" => "Data wilayah berhasil dihapus."
    ];

    echo json_encode($response);
    exit;
?>