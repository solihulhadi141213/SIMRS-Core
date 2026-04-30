<?php
    date_default_timezone_set('Asia/Jakarta');

    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    header('Content-Type: application/json');

    $response = [
        "status"  => "error",
        "message" => "Terjadi kesalahan."
    ];

    // VALIDASI SESSION
    if (empty($SessionIdAkses)) {

        $response["message"] = "Sesi akses sudah berakhir.";

        echo json_encode($response);
        exit;
    }

    // VALIDASI METHOD
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

        $response["message"] = "Metode request tidak valid.";

        echo json_encode($response);
        exit;
    }

    // VALIDASI INPUT
    if (empty($_POST['id_wilayah'])) {

        $response["message"] = "ID wilayah tidak boleh kosong.";

        echo json_encode($response);
        exit;
    }

    // SANITIZE
    $id_wilayah = (int) validateAndSanitizeInput($_POST['id_wilayah']);

    // AMBIL DATA
    $query_data = "
        SELECT province
        FROM wilayah
        WHERE id_wilayah = ?
        LIMIT 1
    ";

    $stmt_data = mysqli_prepare($Conn, $query_data);

    mysqli_stmt_bind_param($stmt_data, "i", $id_wilayah);

    mysqli_stmt_execute($stmt_data);

    $result_data = mysqli_stmt_get_result($stmt_data);

    if (!$result_data || mysqli_num_rows($result_data) == 0) {

        mysqli_stmt_close($stmt_data);

        $response["message"] = "Data wilayah tidak ditemukan.";

        echo json_encode($response);
        exit;
    }

    $data = mysqli_fetch_assoc($result_data);

    mysqli_stmt_close($stmt_data);

    $province = $data['province'];

    // DELETE
    $query_delete = "
        DELETE FROM wilayah
        WHERE province = ?
    ";

    $stmt_delete = mysqli_prepare($Conn, $query_delete);

    mysqli_stmt_bind_param(
        $stmt_delete,
        "s",
        $province
    );

    if (!mysqli_stmt_execute($stmt_delete)) {

        mysqli_stmt_close($stmt_delete);

        $response["message"] = "Gagal menghapus data.";

        echo json_encode($response);
        exit;
    }

    mysqli_stmt_close($stmt_delete);

    echo json_encode([
        "status"  => "success",
        "message" => "Wilayah provinsi berhasil dihapus."
    ]);
    exit;
?>