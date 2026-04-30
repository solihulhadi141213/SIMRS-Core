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
    // DEFAULT RESPONSE
    // ======================================================
    $response = [
        "status"  => "error",
        "message" => "Terjadi kesalahan."
    ];

    // ======================================================
    // VALIDASI SESSION
    // ======================================================
    if (empty($SessionIdAkses)) {

        $response["message"] = "Sesi akses sudah berakhir.";

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
    // VALIDASI INPUT
    // ======================================================
    if (
        empty($_POST['id_wilayah']) ||
        empty($_POST['regency']) ||
        empty($_POST['tipe_level2'])
    ) {

        $response["message"] = "Data tidak lengkap.";

        echo json_encode($response);
        exit;
    }

    // ======================================================
    // SANITIZE INPUT
    // ======================================================
    $id_wilayah       = (int) validateAndSanitizeInput($_POST['id_wilayah']);
    $regency_new      = trim(validateAndSanitizeInput($_POST['regency']));
    $tipe_level2_new  = trim(validateAndSanitizeInput($_POST['tipe_level2']));
    $kode_new         = trim(validateAndSanitizeInput($_POST['kode_mendagri_2'] ?? ''));

    // ======================================================
    // VALIDASI TIPE
    // ======================================================
    $allowed_tipe = ['Kabupaten', 'Kota'];

    if (!in_array($tipe_level2_new, $allowed_tipe)) {

        $response["message"] = "Tipe kabupaten/kota tidak valid.";

        echo json_encode($response);
        exit;
    }

    // ======================================================
    // AMBIL DATA LAMA
    // ======================================================
    $query_old = "
        SELECT 
            province,
            regency,
            tipe_level2,
            kode_mendagri_2
        FROM wilayah
        WHERE id_wilayah = ?
        LIMIT 1
    ";

    $stmt_old = mysqli_prepare($Conn, $query_old);

    if (!$stmt_old) {

        $response["message"] = "Gagal mempersiapkan query.";

        echo json_encode($response);
        exit;
    }

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

    $province      = $data_old['province'];
    $regency_old   = $data_old['regency'];
    $kode_old      = $data_old['kode_mendagri_2'];

    // ======================================================
    // VALIDASI DUPLIKASI KODE
    // ======================================================
    if (
        !empty($kode_new) &&
        $kode_new != $kode_old
    ) {

        $query_check = "
            SELECT id_wilayah
            FROM wilayah
            WHERE kode_mendagri_2 = ?
            AND (
                province != ?
                OR regency != ?
            )
            LIMIT 1
        ";

        $stmt_check = mysqli_prepare($Conn, $query_check);

        if (!$stmt_check) {

            $response["message"] = "Gagal validasi duplikasi.";

            echo json_encode($response);
            exit;
        }

        mysqli_stmt_bind_param(
            $stmt_check,
            "sss",
            $kode_new,
            $province,
            $regency_old
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

    // ======================================================
    // UPDATE DATA
    // ======================================================
    $query_update = "
        UPDATE wilayah SET
            regency         = ?,
            tipe_level2     = ?,
            kode_mendagri_2 = ?
        WHERE province = ?
        AND regency = ?
    ";

    $stmt_update = mysqli_prepare($Conn, $query_update);

    if (!$stmt_update) {

        $response["message"] = "Gagal mempersiapkan query update.";

        echo json_encode($response);
        exit;
    }

    mysqli_stmt_bind_param(
        $stmt_update,
        "sssss",
        $regency_new,
        $tipe_level2_new,
        $kode_new,
        $province,
        $regency_old
    );

    if (!mysqli_stmt_execute($stmt_update)) {

        mysqli_stmt_close($stmt_update);

        $response["message"] = "Gagal mengupdate data.";

        echo json_encode($response);
        exit;
    }

    mysqli_stmt_close($stmt_update);

    // ======================================================
    // SUCCESS
    // ======================================================
    echo json_encode([
        "status"  => "success",
        "message" => "Wilayah kabupaten/kota berhasil diupdate."
    ]);
    exit;
?>