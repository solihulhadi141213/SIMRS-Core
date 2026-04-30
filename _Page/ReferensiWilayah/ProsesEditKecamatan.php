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
        empty($_POST['subdistrict'])
    ) {

        $response["message"] = "Data tidak lengkap.";

        echo json_encode($response);
        exit;
    }

    // ======================================================
    // SANITIZE INPUT
    // ======================================================
    $id_wilayah      = (int) validateAndSanitizeInput($_POST['id_wilayah']);
    $subdistrict_new = trim(validateAndSanitizeInput($_POST['subdistrict']));
    $kode_new        = trim(validateAndSanitizeInput($_POST['kode_mendagri_3'] ?? ''));

    // ======================================================
    // AMBIL DATA LAMA
    // ======================================================
    $query_old = "
        SELECT 
            province,
            regency,
            subdistrict,
            kode_mendagri_3
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

    $province       = $data_old['province'];
    $regency        = $data_old['regency'];
    $subdistrict_old= $data_old['subdistrict'];
    $kode_old       = $data_old['kode_mendagri_3'];

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
            WHERE kode_mendagri_3 = ?
            AND (
                province != ?
                OR regency != ?
                OR subdistrict != ?
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
            "ssss",
            $kode_new,
            $province,
            $regency,
            $subdistrict_old
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
    // UPDATE SEMUA DATA DALAM KECAMATAN
    // ======================================================
    $query_update = "
        UPDATE wilayah SET
            subdistrict     = ?,
            kode_mendagri_3 = ?
        WHERE province   = ?
        AND regency      = ?
        AND subdistrict  = ?
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
        $subdistrict_new,
        $kode_new,
        $province,
        $regency,
        $subdistrict_old
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
        "message" => "Wilayah kecamatan berhasil diupdate."
    ]);
    exit;
?>