<?php
    // Header JSON
    header('Content-Type: application/json');

    // Connection, Function & Session
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // Response Default
    $response = [
        "status"  => "error",
        "message" => "Terjadi kesalahan."
    ];

    // Validasi Session
    if (empty($SessionIdAkses)) {
        $response["message"] = "Sesi akses sudah berakhir. Silahkan login ulang!";
        echo json_encode($response);
        exit;
    }

    // Validasi ID Pasien
    if (empty($_POST['id_pasien'])) {
        $response["message"] = "ID Pasien tidak boleh kosong!";
        echo json_encode($response);
        exit;
    }

    // Sanitasi Input
    $id_pasien      = validateAndSanitizeInput($_POST['id_pasien']);
    $id_ihs         = validateAndSanitizeInput($_POST['id_ihs'] ?? '');
    $nik            = validateAndSanitizeInput($_POST['nik'] ?? '');
    $no_bpjs        = validateAndSanitizeInput($_POST['no_bpjs'] ?? '');
    $nama           = validateAndSanitizeInput($_POST['nama'] ?? '');
    $gender         = validateAndSanitizeInput($_POST['gender'] ?? '');
    $tempat_lahir   = validateAndSanitizeInput($_POST['tempat_lahir'] ?? '');
    $tanggal_lahir  = validateAndSanitizeInput($_POST['tanggal_lahir'] ?? '');
    $province       = validateAndSanitizeInput($_POST['province'] ?? '');
    $regency        = validateAndSanitizeInput($_POST['regency'] ?? '');
    $subdistrict    = validateAndSanitizeInput($_POST['subdistrict'] ?? '');
    $village        = validateAndSanitizeInput($_POST['village'] ?? '');
    $street         = validateAndSanitizeInput($_POST['street'] ?? '');
    $postal_code    = validateAndSanitizeInput($_POST['postal_code'] ?? '');
    $kontak         = validateAndSanitizeInput($_POST['kontak'] ?? '');
    $golongan_darah = validateAndSanitizeInput($_POST['golongan_darah'] ?? '');
    $pernikahan     = validateAndSanitizeInput($_POST['pernikahan'] ?? '');
    $pekerjaan      = validateAndSanitizeInput($_POST['pekerjaan'] ?? '');

    // Validasi Nama
    if (empty($nama)) {
        $response["message"] = "Nama pasien tidak boleh kosong!";
        echo json_encode($response);
        exit;
    }

    // =========================================================
    // VALIDASI DUPLIKAT NIK
    // =========================================================
    if (!empty($nik)) {

        $checkNik = mysqli_prepare($Conn, "
            SELECT id_pasien 
            FROM pasien 
            WHERE nik = ? 
            AND id_pasien != ?
            LIMIT 1
        ");

        mysqli_stmt_bind_param($checkNik, "si", $nik, $id_pasien);
        mysqli_stmt_execute($checkNik);
        $resultNik = mysqli_stmt_get_result($checkNik);

        if (mysqli_num_rows($resultNik) > 0) {

            $rowNik = mysqli_fetch_assoc($resultNik);

            $response["message"] = "NIK sudah digunakan pasien lain dengan No.RM ".$rowNik['id_pasien'];
            echo json_encode($response);
            exit;
        }
    }

    // =========================================================
    // VALIDASI DUPLIKAT BPJS
    // =========================================================
    if (!empty($no_bpjs)) {

        $checkBpjs = mysqli_prepare($Conn, "
            SELECT id_pasien 
            FROM pasien 
            WHERE no_bpjs = ? 
            AND id_pasien != ?
            LIMIT 1
        ");

        mysqli_stmt_bind_param($checkBpjs, "si", $no_bpjs, $id_pasien);
        mysqli_stmt_execute($checkBpjs);
        $resultBpjs = mysqli_stmt_get_result($checkBpjs);

        if (mysqli_num_rows($resultBpjs) > 0) {

            $rowBpjs = mysqli_fetch_assoc($resultBpjs);

            $response["message"] = "No.BPJS sudah digunakan pasien lain dengan No.RM ".$rowBpjs['id_pasien'];
            echo json_encode($response);
            exit;
        }
    }

    // =========================================================
    // VALIDASI DUPLIKAT IHS
    // =========================================================
    if (!empty($id_ihs)) {

        $checkIhs = mysqli_prepare($Conn, "
            SELECT id_pasien 
            FROM pasien 
            WHERE id_ihs = ? 
            AND id_pasien != ?
            LIMIT 1
        ");

        mysqli_stmt_bind_param($checkIhs, "si", $id_ihs, $id_pasien);
        mysqli_stmt_execute($checkIhs);
        $resultIhs = mysqli_stmt_get_result($checkIhs);

        if (mysqli_num_rows($resultIhs) > 0) {

            $rowIhs = mysqli_fetch_assoc($resultIhs);

            $response["message"] = "ID IHS sudah digunakan pasien lain dengan No.RM ".$rowIhs['id_pasien'];
            echo json_encode($response);
            exit;
        }
    }

    // Waktu Update
    $updated_at = date('Y-m-d H:i:s');

    // =========================================================
    // UPDATE DATA PASIEN
    // =========================================================
    $query = "
        UPDATE pasien SET
            id_ihs         = ?,
            nik            = ?,
            no_bpjs        = ?,
            nama           = ?,
            gender         = ?,
            tempat_lahir   = ?,
            tanggal_lahir  = ?,
            province       = ?,
            regency        = ?,
            subdistrict    = ?,
            village        = ?,
            street         = ?,
            postal_code    = ?,
            kontak         = ?,
            golongan_darah = ?,
            pernikahan     = ?,
            pekerjaan      = ?,
            updated_at     = ?
        WHERE id_pasien = ?
        LIMIT 1
    ";

    $stmt = mysqli_prepare($Conn, $query);

    // Debug Prepare
    if (!$stmt) {

        $response["message"] = "Gagal prepare query : ".mysqli_error($Conn);
        echo json_encode($response);
        exit;
    }

    mysqli_stmt_bind_param(
        $stmt,
        "ssssssssssssssssssi",
        $id_ihs,
        $nik,
        $no_bpjs,
        $nama,
        $gender,
        $tempat_lahir,
        $tanggal_lahir,
        $province,
        $regency,
        $subdistrict,
        $village,
        $street,
        $postal_code,
        $kontak,
        $golongan_darah,
        $pernikahan,
        $pekerjaan,
        $updated_at,
        $id_pasien
    );

    // Execute
    if (!mysqli_stmt_execute($stmt)) {

        $response["message"] = "Gagal update data pasien : ".mysqli_stmt_error($stmt);
        echo json_encode($response);
        exit;
    }

    // Success
    $response = [
        "status"  => "success",
        "message" => "Edit data pasien berhasil"
    ];

    echo json_encode($response);

    mysqli_stmt_close($stmt);
?>