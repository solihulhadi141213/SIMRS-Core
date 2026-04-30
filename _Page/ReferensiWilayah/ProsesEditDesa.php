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
    // VALIDASI INPUT WAJIB
    // ======================================================
    if (
        empty($_POST['id_wilayah']) ||
        empty($_POST['tipe_level4']) ||
        empty($_POST['village'])
    ) {

        $response["message"] = "Data yang dikirim tidak lengkap.";

        echo json_encode($response);
        exit;
    }

    // ======================================================
    // SANITIZE INPUT
    // ======================================================
    $id_wilayah       = (int) validateAndSanitizeInput($_POST['id_wilayah']);
    $tipe_level4      = validateAndSanitizeInput($_POST['tipe_level4']);
    $village          = trim(validateAndSanitizeInput($_POST['village']));
    $kode_mendagri_4  = trim(validateAndSanitizeInput($_POST['kode_mendagri_4'] ?? ''));

    // ======================================================
    // VALIDASI TIPE LEVEL 4
    // ======================================================
    $allowed_tipe = ['Desa', 'Kelurahan'];

    if (!in_array($tipe_level4, $allowed_tipe)) {

        $response["message"] = "Tipe desa / kelurahan tidak valid.";

        echo json_encode($response);
        exit;
    }

    // ======================================================
    // VALIDASI DATA WILAYAH
    // ======================================================
    $query_old = "
        SELECT 
            kode_mendagri_4
        FROM wilayah
        WHERE id_wilayah = ?
        LIMIT 1
    ";

    $stmt_old = mysqli_prepare($Conn, $query_old);

    if (!$stmt_old) {

        $response["message"] = "Gagal mempersiapkan query data.";

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

    $old_kode_mendagri_4 = $data_old['kode_mendagri_4'];

    // ======================================================
    // VALIDASI DUPLIKASI KODE MENDAGRI
    // HANYA JIKA KODE DIUBAH
    // ======================================================
    if (
        !empty($kode_mendagri_4) &&
        $kode_mendagri_4 != $old_kode_mendagri_4
    ) {

        $query_check = "
            SELECT 
                id_wilayah
            FROM wilayah
            WHERE kode_mendagri_4 = ?
            AND id_wilayah != ?
            LIMIT 1
        ";

        $stmt_check = mysqli_prepare($Conn, $query_check);

        if (!$stmt_check) {

            $response["message"] = "Gagal mempersiapkan validasi duplikasi.";

            echo json_encode($response);
            exit;
        }

        mysqli_stmt_bind_param(
            $stmt_check,
            "si",
            $kode_mendagri_4,
            $id_wilayah
        );

        mysqli_stmt_execute($stmt_check);

        $result_check = mysqli_stmt_get_result($stmt_check);

        if ($result_check && mysqli_num_rows($result_check) > 0) {

            mysqli_stmt_close($stmt_check);

            $response["message"] = "Kode Mendagri sudah digunakan pada wilayah lain.";

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
            tipe_level4    = ?,
            village         = ?,
            kode_mendagri_4 = ?
        WHERE id_wilayah = ?
    ";

    $stmt_update = mysqli_prepare($Conn, $query_update);

    if (!$stmt_update) {

        $response["message"] = "Gagal mempersiapkan query update.";

        echo json_encode($response);
        exit;
    }

    mysqli_stmt_bind_param(
        $stmt_update,
        "sssi",
        $tipe_level4,
        $village,
        $kode_mendagri_4,
        $id_wilayah
    );

    $execute = mysqli_stmt_execute($stmt_update);

    if (!$execute) {

        mysqli_stmt_close($stmt_update);

        $response["message"] = "Gagal menyimpan perubahan data.";

        echo json_encode($response);
        exit;
    }

    mysqli_stmt_close($stmt_update);

    // ======================================================
    // SUCCESS RESPONSE
    // ======================================================
    $response = [
        "status"  => "success",
        "message" => "Edit wilayah berhasil."
    ];

    echo json_encode($response);
    exit;
?>