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
    if (
        empty($_POST['id_wilayah']) ||
        empty($_POST['province'])
    ) {

        $response["message"] = "Data tidak lengkap.";

        echo json_encode($response);
        exit;
    }

    // SANITIZE
    $id_wilayah      = (int) validateAndSanitizeInput($_POST['id_wilayah']);
    $province_new    = trim(validateAndSanitizeInput($_POST['province']));
    $kode_new        = trim(validateAndSanitizeInput($_POST['kode_mendagri_1'] ?? ''));

    // DATA LAMA
    $query_old = "
        SELECT 
            province,
            kode_mendagri_1
        FROM wilayah
        WHERE id_wilayah = ?
        LIMIT 1
    ";

    $stmt_old = mysqli_prepare($Conn, $query_old);

    mysqli_stmt_bind_param($stmt_old, "i", $id_wilayah);

    mysqli_stmt_execute($stmt_old);

    $result_old = mysqli_stmt_get_result($stmt_old);

    if (!$result_old || mysqli_num_rows($result_old) == 0) {

        mysqli_stmt_close($stmt_old);

        $response["message"] = "Data wilayah tidak ditemukan.";

        echo json_encode($response);
        exit;
    }

    $data_old = mysqli_fetch_assoc($result_old);

    mysqli_stmt_close($stmt_old);

    $province_old = $data_old['province'];
    $kode_old     = $data_old['kode_mendagri_1'];

    // VALIDASI DUPLIKASI
    if (
        !empty($kode_new) &&
        $kode_new != $kode_old
    ) {

        $query_check = "
            SELECT id_wilayah
            FROM wilayah
            WHERE kode_mendagri_1 = ?
            AND province != ?
            LIMIT 1
        ";

        $stmt_check = mysqli_prepare($Conn, $query_check);

        mysqli_stmt_bind_param(
            $stmt_check,
            "ss",
            $kode_new,
            $province_old
        );

        mysqli_stmt_execute($stmt_check);

        $result_check = mysqli_stmt_get_result($stmt_check);

        if ($result_check && mysqli_num_rows($result_check) > 0) {

            mysqli_stmt_close($stmt_check);

            $response["message"] = "Kode Mendagri sudah digunakan.";

            echo json_encode($response);
            exit;
        }

        mysqli_stmt_close($stmt_check);
    }

    // UPDATE
    $query_update = "
        UPDATE wilayah SET
            province = ?,
            kode_mendagri_1 = ?
        WHERE province = ?
    ";

    $stmt_update = mysqli_prepare($Conn, $query_update);

    mysqli_stmt_bind_param(
        $stmt_update,
        "sss",
        $province_new,
        $kode_new,
        $province_old
    );

    if (!mysqli_stmt_execute($stmt_update)) {

        mysqli_stmt_close($stmt_update);

        $response["message"] = "Gagal mengupdate data.";

        echo json_encode($response);
        exit;
    }

    mysqli_stmt_close($stmt_update);

    echo json_encode([
        "status"  => "success",
        "message" => "Wilayah provinsi berhasil diupdate."
    ]);
    exit;
?>