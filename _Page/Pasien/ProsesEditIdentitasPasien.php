<?php
    // =========================================================
    // HEADER JSON
    // =========================================================
    header('Content-Type: application/json');

    // =========================================================
    // CONNECTION, FUNCTION & SESSION
    // =========================================================
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // =========================================================
    // RESPONSE DEFAULT
    // =========================================================
    $response = [
        "status"  => "error",
        "message" => "Terjadi kesalahan."
    ];

    // =========================================================
    // VALIDASI SESSION
    // =========================================================
    if (empty($SessionIdAkses)) {

        $response["message"] = "Sesi akses sudah berakhir. Silahkan login ulang!";

        echo json_encode($response);
        exit;
    }

    // =========================================================
    // VALIDASI ID PASIEN
    // =========================================================
    if (empty($_POST['id_pasien'])) {

        $response["message"] = "ID Pasien tidak boleh kosong!";

        echo json_encode($response);
        exit;
    }

    // =========================================================
    // VALIDASI FIELD
    // =========================================================
    if (empty($_POST['field'])) {

        $response["message"] = "Nama field tidak boleh kosong!";

        echo json_encode($response);
        exit;
    }

    // =========================================================
    // SANITASI INPUT
    // =========================================================
    $id_pasien   = validateAndSanitizeInput($_POST['id_pasien'] ?? '');
    $field       = validateAndSanitizeInput($_POST['field'] ?? '');
    $value_field = validateAndSanitizeInput($_POST['value_field'] ?? '');

    // =========================================================
    // VALIDASI FIELD YANG DIIZINKAN
    // =========================================================
    $allowed_fields = ['nik', 'no_bpjs', 'id_ihs'];

    if (!in_array($field, $allowed_fields)) {

        $response["message"] = "Field tidak diizinkan!";

        echo json_encode($response);
        exit;
    }

    // =========================================================
    // VALIDASI PASIEN EXIST
    // =========================================================
    $checkPasien = mysqli_prepare($Conn, "
        SELECT id_pasien
        FROM pasien
        WHERE id_pasien = ?
        LIMIT 1
    ");

    mysqli_stmt_bind_param($checkPasien, "i", $id_pasien);

    mysqli_stmt_execute($checkPasien);

    $resultPasien = mysqli_stmt_get_result($checkPasien);

    if (mysqli_num_rows($resultPasien) == 0) {

        $response["message"] = "Data pasien tidak ditemukan!";

        echo json_encode($response);
        exit;
    }

    mysqli_stmt_close($checkPasien);

    // =========================================================
    // VALIDASI DUPLIKAT NIK
    // =========================================================
    if ($field == "nik") {

        if (!empty($value_field)) {

            $checkNik = mysqli_prepare($Conn, "
                SELECT id_pasien
                FROM pasien
                WHERE nik = ?
                AND id_pasien != ?
                LIMIT 1
            ");

            mysqli_stmt_bind_param(
                $checkNik,
                "si",
                $value_field,
                $id_pasien
            );

            mysqli_stmt_execute($checkNik);

            $resultNik = mysqli_stmt_get_result($checkNik);

            if (mysqli_num_rows($resultNik) > 0) {

                $rowNik = mysqli_fetch_assoc($resultNik);

                $response["message"] =
                    "NIK sudah digunakan pasien lain dengan No.RM ".$rowNik['id_pasien'];

                echo json_encode($response);
                exit;
            }

            mysqli_stmt_close($checkNik);
        }
    }

    // =========================================================
    // VALIDASI DUPLIKAT BPJS
    // =========================================================
    if ($field == "no_bpjs") {

        if (!empty($value_field)) {

            $checkBpjs = mysqli_prepare($Conn, "
                SELECT id_pasien
                FROM pasien
                WHERE no_bpjs = ?
                AND id_pasien != ?
                LIMIT 1
            ");

            mysqli_stmt_bind_param(
                $checkBpjs,
                "si",
                $value_field,
                $id_pasien
            );

            mysqli_stmt_execute($checkBpjs);

            $resultBpjs = mysqli_stmt_get_result($checkBpjs);

            if (mysqli_num_rows($resultBpjs) > 0) {

                $rowBpjs = mysqli_fetch_assoc($resultBpjs);

                $response["message"] =
                    "No.BPJS sudah digunakan pasien lain dengan No.RM ".$rowBpjs['id_pasien'];

                echo json_encode($response);
                exit;
            }

            mysqli_stmt_close($checkBpjs);
        }
    }

    // =========================================================
    // VALIDASI DUPLIKAT IHS
    // =========================================================
    if ($field == "id_ihs") {

        if (!empty($value_field)) {

            $checkIhs = mysqli_prepare($Conn, "
                SELECT id_pasien
                FROM pasien
                WHERE id_ihs = ?
                AND id_pasien != ?
                LIMIT 1
            ");

            mysqli_stmt_bind_param(
                $checkIhs,
                "si",
                $value_field,
                $id_pasien
            );

            mysqli_stmt_execute($checkIhs);

            $resultIhs = mysqli_stmt_get_result($checkIhs);

            if (mysqli_num_rows($resultIhs) > 0) {

                $rowIhs = mysqli_fetch_assoc($resultIhs);

                $response["message"] =
                    "ID IHS sudah digunakan pasien lain dengan No.RM ".$rowIhs['id_pasien'];

                echo json_encode($response);
                exit;
            }

            mysqli_stmt_close($checkIhs);
        }
    }

    // =========================================================
    // UPDATE DATA
    // =========================================================
    $allowedFieldSql = mysqli_real_escape_string($Conn, $field);

    $query = "
        UPDATE pasien
        SET 
            $allowedFieldSql = ?,
            updated_at = NOW()
        WHERE id_pasien = ?
    ";

    $stmtUpdate = mysqli_prepare($Conn, $query);

    if (!$stmtUpdate) {

        $response["message"] = "Terjadi kesalahan saat prepare query update.";

        echo json_encode($response);
        exit;
    }

    mysqli_stmt_bind_param(
        $stmtUpdate,
        "si",
        $value_field,
        $id_pasien
    );

    $execute = mysqli_stmt_execute($stmtUpdate);

    if (!$execute) {

        $response["message"] = "Gagal update data pasien.";

        echo json_encode($response);
        exit;
    }

    mysqli_stmt_close($stmtUpdate);

    // =========================================================
    // SUCCESS
    // =========================================================
    $response = [
        "status"  => "success",
        "message" => "Edit identitas pasien berhasil."
    ];

    echo json_encode($response);
?>