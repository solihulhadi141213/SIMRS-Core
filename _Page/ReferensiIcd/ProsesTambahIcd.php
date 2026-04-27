<?php
    header('Content-Type: application/json');

    // Koneksi, Function dan Session
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // ===================== RESPONSE TEMPLATE =====================
    function response($status, $message){
        echo json_encode([
            "status"  => $status,
            "message" => $message
        ]);
        exit;
    }

    // ===================== VALIDASI SESSION =====================
    if (empty($SessionIdAkses)) {
        response("error", "Sesi akses berakhir, silahkan login ulang.");
    }

    // ===================== AMBIL DATA =====================
    $icd       = $_POST['icd'] ?? '';
    $kode      = trim($_POST['kode'] ?? '');
    $short_des = trim($_POST['short_des'] ?? '');
    $long_des  = trim($_POST['long_des'] ?? '');

    // ===================== VALIDASI MANDATORY =====================
    if (empty($icd)) {
        response("error", "Versi ICD tidak boleh kosong.");
    }

    if (empty($kode)) {
        response("error", "Kode ICD tidak boleh kosong.");
    }

    if (empty($short_des)) {
        response("error", "Short Description tidak boleh kosong.");
    }

    if (empty($long_des)) {
        response("error", "Long Description tidak boleh kosong.");
    }

    // ===================== VALIDASI ENUM ICD =====================
    $allowed_icd = ['ICD9','ICD10','ICD11'];

    if (!in_array($icd, $allowed_icd)) {
        response("error", "Versi ICD tidak valid.");
    }

    // ===================== VALIDASI PANJANG KARAKTER =====================
    if (strlen($kode) > 100) {
        response("error", "Kode maksimal 100 karakter.");
    }

    if (strlen($short_des) > 250) {
        response("error", "Short Description maksimal 250 karakter.");
    }

    if (strlen($long_des) > 500) {
        response("error", "Long Description maksimal 500 karakter.");
    }

    // ===================== VALIDASI DUPLIKAT =====================
    $sql_check = "SELECT id_icd FROM icd WHERE kode = ? AND icd = ? LIMIT 1";
    $stmt = mysqli_prepare($Conn, $sql_check);
    mysqli_stmt_bind_param($stmt, "ss", $kode, $icd);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        response("error", "Kode ICD sudah terdaftar untuk versi ini.");
    }

    mysqli_stmt_close($stmt);

    // ===================== INSERT DATA =====================
    $sql_insert = "INSERT INTO icd (kode, long_des, short_des, icd) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($Conn, $sql_insert);

    if (!$stmt) {
        response("error", "Gagal mempersiapkan query.");
    }

    mysqli_stmt_bind_param($stmt, "ssss", $kode, $long_des, $short_des, $icd);

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        response("success", "Data ICD berhasil ditambahkan.");
    } else {
        mysqli_stmt_close($stmt);
        response("error", "Gagal menyimpan data ICD.");
    }
?>