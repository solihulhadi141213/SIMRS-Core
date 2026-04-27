<?php
    header('Content-Type: application/json');

    // Koneksi & Session
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";

    // ===================== HELPER RESPONSE =====================
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
    $id_icd    = $_POST['id_icd'] ?? '';
    $icd       = $_POST['icd'] ?? '';
    $kode      = trim($_POST['kode'] ?? '');
    $short_des = trim($_POST['short_des'] ?? '');
    $long_des  = trim($_POST['long_des'] ?? '');

    // ===================== VALIDASI DASAR =====================
    if (empty($id_icd) || !is_numeric($id_icd)) {
        response("error", "ID ICD tidak valid.");
    }

    $id_icd = (int)$id_icd;

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

    // ===================== VALIDASI ICD =====================
    $allowed_icd = ['ICD9','ICD10','ICD11'];

    if (!in_array($icd, $allowed_icd)) {
        response("error", "Versi ICD tidak valid.");
    }

    // ===================== VALIDASI PANJANG =====================
    if (strlen($kode) > 100) {
        response("error", "Kode maksimal 100 karakter.");
    }

    if (strlen($short_des) > 250) {
        response("error", "Short Description maksimal 250 karakter.");
    }

    if (strlen($long_des) > 500) {
        response("error", "Long Description maksimal 500 karakter.");
    }

    // ===================== CEK DATA EXIST =====================
    $sql_check_id = "SELECT id_icd FROM icd WHERE id_icd = ? LIMIT 1";
    $stmt = mysqli_prepare($Conn, $sql_check_id);
    mysqli_stmt_bind_param($stmt, "i", $id_icd);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 0) {
        response("error", "Data tidak ditemukan.");
    }
    mysqli_stmt_close($stmt);

    // ===================== CEK DUPLIKAT =====================
    $sql_duplicate = "SELECT id_icd FROM icd WHERE kode = ? AND icd = ? AND id_icd != ? LIMIT 1";
    $stmt = mysqli_prepare($Conn, $sql_duplicate);
    mysqli_stmt_bind_param($stmt, "ssi", $kode, $icd, $id_icd);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        response("error", "Kode ICD sudah digunakan pada versi ini.");
    }
    mysqli_stmt_close($stmt);

    // ===================== UPDATE DATA =====================
    $sql_update = "UPDATE icd SET kode = ?, short_des = ?, long_des = ? WHERE id_icd = ?";
    $stmt = mysqli_prepare($Conn, $sql_update);

    if (!$stmt) {
        response("error", "Gagal mempersiapkan query.");
    }

    mysqli_stmt_bind_param($stmt, "sssi", $kode, $short_des, $long_des, $id_icd);

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        response("success", "Data ICD berhasil diperbarui.");
    } else {
        mysqli_stmt_close($stmt);
        response("error", "Gagal memperbarui data ICD.");
    }
?>