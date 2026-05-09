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
            "message" => "Sesi akses sudah berakhir. Silahkan login ulang."
        ]);
        exit;
    }

    // =========================================================
    // AMBIL & SANITASI INPUT
    // =========================================================
    $id_pasien_manual   = !empty($_POST['id_pasien_manual']) ? 1 : 0;
    $pasien_anak        = !empty($_POST['pasien_anak']) ? 1 : 0;

    $id_pasien          = validateAndSanitizeInput($_POST['id_pasien'] ?? '');
    $id_pasien_relasi   = validateAndSanitizeInput($_POST['id_pasien_relasi'] ?? '');

    $nik                = validateAndSanitizeInput($_POST['nik'] ?? '');
    $id_ihs             = validateAndSanitizeInput($_POST['id_ihs'] ?? '');
    $no_bpjs            = validateAndSanitizeInput($_POST['no_bpjs'] ?? '');

    $nama               = validateAndSanitizeInput($_POST['nama'] ?? '');
    $gender             = validateAndSanitizeInput($_POST['gender'] ?? '');

    $tempat_lahir       = validateAndSanitizeInput($_POST['tempat_lahir'] ?? '');
    $tanggal_lahir      = validateAndSanitizeInput($_POST['tanggal_lahir'] ?? '');

    $province           = validateAndSanitizeInput($_POST['province'] ?? '');
    $regency            = validateAndSanitizeInput($_POST['regency'] ?? '');
    $subdistrict        = validateAndSanitizeInput($_POST['subdistrict'] ?? '');
    $village            = validateAndSanitizeInput($_POST['village'] ?? '');
    $street             = validateAndSanitizeInput($_POST['street'] ?? '');
    $postal_code        = validateAndSanitizeInput($_POST['postal_code'] ?? '');

    $kontak             = validateAndSanitizeInput($_POST['kontak'] ?? '');

    $golongan_darah     = validateAndSanitizeInput($_POST['golongan_darah'] ?? '');
    $pernikahan         = validateAndSanitizeInput($_POST['pernikahan'] ?? '');
    $pekerjaan          = validateAndSanitizeInput($_POST['pekerjaan'] ?? '');

    $registered_date    = validateAndSanitizeInput($_POST['registered_date'] ?? '');
    $registered_time    = validateAndSanitizeInput($_POST['registered_time'] ?? '');

    // =========================================================
    // VALIDASI MANDATORY
    // =========================================================
    if (empty($nama)) {
        echo json_encode([
            "status"  => "error",
            "message" => "Nama pasien tidak boleh kosong."
        ]);
        exit;
    }

    if (empty($gender)) {
        echo json_encode([
            "status"  => "error",
            "message" => "Gender/Jenis kelamin pasien wajib dipilih."
        ]);
        exit;
    }

    if (empty($registered_date)) {
        echo json_encode([
            "status"  => "error",
            "message" => "Tanggal pendaftaran wajib diisi."
        ]);
        exit;
    }

    if (empty($registered_time)) {
        echo json_encode([
            "status"  => "error",
            "message" => "Jam pendaftaran wajib diisi."
        ]);
        exit;
    }

    // =========================================================
    // VALIDASI NO RM MANUAL
    // =========================================================
    if ($id_pasien_manual == 1) {

        if (empty($id_pasien)) {
            echo json_encode([
                "status"  => "error",
                "message" => "No.RM wajib diisi karena menggunakan input manual."
            ]);
            exit;
        }

        // Cek duplicate No.RM
        $stmt = mysqli_prepare($Conn, "
            SELECT id_pasien 
            FROM pasien 
            WHERE id_pasien = ?
            LIMIT 1
        ");

        mysqli_stmt_bind_param($stmt, "s", $id_pasien);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            echo json_encode([
                "status"  => "error",
                "message" => "No.RM '$id_pasien' sudah digunakan pasien lain."
            ]);
            exit;
        }

        mysqli_stmt_close($stmt);
    }

    // =========================================================
    // VALIDASI PASIEN ANAK
    // =========================================================
    if ($pasien_anak == 1) {

        if (empty($id_pasien_relasi)) {
            echo json_encode([
                "status"  => "error",
                "message" => "No.RM relasi/ibu wajib dipilih untuk pasien anak."
            ]);
            exit;
        }

        // Validasi pasien relasi ada
        $stmt = mysqli_prepare($Conn, "
            SELECT id_pasien 
            FROM pasien
            WHERE id_pasien = ?
            LIMIT 1
        ");

        mysqli_stmt_bind_param($stmt, "s", $id_pasien_relasi);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) == 0) {
            echo json_encode([
                "status"  => "error",
                "message" => "No.RM relasi/ibu tidak ditemukan atau tidak valid."
            ]);
            exit;
        }

        mysqli_stmt_close($stmt);
    }

    // =========================================================
    // VALIDASI DUPLIKAT NIK
    // =========================================================
    if (!empty($nik)) {

        $stmt = mysqli_prepare($Conn, "
            SELECT id_pasien 
            FROM pasien
            WHERE nik = ?
            LIMIT 1
        ");

        mysqli_stmt_bind_param($stmt, "s", $nik);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            echo json_encode([
                "status"  => "error",
                "message" => "NIK '$nik' sudah terdaftar pada pasien lain."
            ]);
            exit;
        }

        mysqli_stmt_close($stmt);
    }

    // =========================================================
    // VALIDASI DUPLIKAT ID IHS
    // =========================================================
    if (!empty($id_ihs)) {

        $stmt = mysqli_prepare($Conn, "
            SELECT id_pasien
            FROM pasien
            WHERE id_ihs = ?
            LIMIT 1
        ");

        mysqli_stmt_bind_param($stmt, "s", $id_ihs);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            echo json_encode([
                "status"  => "error",
                "message" => "ID IHS '$id_ihs' sudah digunakan pasien lain."
            ]);
            exit;
        }

        mysqli_stmt_close($stmt);
    }

    // =========================================================
    // VALIDASI DUPLIKAT BPJS
    // =========================================================
    if (!empty($no_bpjs)) {

        $stmt = mysqli_prepare($Conn, "
            SELECT id_pasien
            FROM pasien
            WHERE no_bpjs = ?
            LIMIT 1
        ");

        mysqli_stmt_bind_param($stmt, "s", $no_bpjs);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            echo json_encode([
                "status"  => "error",
                "message" => "Nomor BPJS '$no_bpjs' sudah digunakan pasien lain."
            ]);
            exit;
        }

        mysqli_stmt_close($stmt);
    }

    // =========================================================
    // FORMAT DATETIME
    // =========================================================
    $registered_at = $registered_date . ' ' . $registered_time . ':00';
    $updated_at    = date('Y-m-d H:i:s');

    // =========================================================
    // STATUS DEFAULT
    // =========================================================
    $status = "Active";

    // =========================================================
    // INSERT DATA PASIEN
    // =========================================================
    if ($id_pasien_manual == 1) {

        $query = "
            INSERT INTO pasien (
                id_pasien,
                id_ihs,
                nik,
                no_bpjs,
                nama,
                gender,
                tempat_lahir,
                tanggal_lahir,
                province,
                regency,
                subdistrict,
                village,
                street,
                postal_code,
                kontak,
                golongan_darah,
                pernikahan,
                pekerjaan,
                status,
                id_pasien_relasi,
                id_akses,
                petugas_pendaftaran,
                registered_at,
                updated_at
            ) VALUES (
                ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?
            )
        ";

        $stmt = mysqli_prepare($Conn, $query);

        mysqli_stmt_bind_param(
            $stmt,
            "ssssssssssssssssssssssss",
            $id_pasien,
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
            $status,
            $id_pasien_relasi,
            $SessionIdAkses,
            $SessionNama,
            $registered_at,
            $updated_at
        );

    } else {

        $query = "
            INSERT INTO pasien (
                id_ihs,
                nik,
                no_bpjs,
                nama,
                gender,
                tempat_lahir,
                tanggal_lahir,
                province,
                regency,
                subdistrict,
                village,
                street,
                postal_code,
                kontak,
                golongan_darah,
                pernikahan,
                pekerjaan,
                status,
                id_pasien_relasi,
                id_akses,
                petugas_pendaftaran,
                registered_at,
                updated_at
            ) VALUES (
                ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?
            )
        ";

        $stmt = mysqli_prepare($Conn, $query);

        mysqli_stmt_bind_param(
            $stmt,
            "ssssssssssssssssssiisss",
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
            $status,
            $id_pasien_relasi,
            $SessionIdAkses,
            $SessionNama,
            $registered_at,
            $updated_at
        );
    }

    // =========================================================
    // EKSEKUSI INSERT
    // =========================================================
    if (!$stmt) {
        echo json_encode([
            "status"  => "error",
            "message" => "Terjadi kesalahan pada prepare statement."
        ]);
        exit;
    }

    $execute = mysqli_stmt_execute($stmt);

    if (!$execute) {
        echo json_encode([
            "status"  => "error",
            "message" => "Terjadi kesalahan saat menyimpan data pasien : " . mysqli_stmt_error($stmt)
        ]);
        exit;
    }

    mysqli_stmt_close($stmt);

    // =========================================================
    // SUCCESS RESPONSE
    // =========================================================
    echo json_encode([
        "status"  => "success",
        "message" => "Data pasien berhasil disimpan."
    ]);
    exit;
?>