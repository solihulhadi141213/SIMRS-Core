<?php
    header('Content-Type: application/json');

    // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";

    // =============================================
    // VALIDASI SESSION
    // =============================================
    if (empty($SessionIdAkses)) {
        echo json_encode([
            "status"  => "error",
            "message" => "Sesi login sudah berakhir."
        ]);
        exit;
    }

    // =============================================
    // FUNCTION VALIDATE
    // =============================================
    function validate($data){
        return htmlspecialchars(trim($data));
    }

    // =============================================
    // AMBIL DATA
    // =============================================
    $id_kunjungan = validate($_POST['id_kunjungan'] ?? '');
    $status       = validate($_POST['status'] ?? '');
    $from         = validate($_POST['from'] ?? '');

    // =============================================
    // VALIDASI
    // =============================================
    if (empty($id_kunjungan)) {
        echo json_encode([
            "status"  => "error",
            "message" => "ID Kunjungan tidak boleh kosong."
        ]);
        exit;
    }

    if (empty($status)) {
        echo json_encode([
            "status"  => "error",
            "message" => "Status kunjungan wajib dipilih."
        ]);
        exit;
    }

    // =============================================
    // VALIDASI STATUS
    // =============================================
    $allowed_status = ['Terdaftar', 'Dilayani', 'Selesai', 'Batal', 'Meninggal'];

    if (!in_array($status, $allowed_status)) {
        echo json_encode([
            "status"  => "error",
            "message" => "Status kunjungan tidak valid."
        ]);
        exit;
    }

    // =============================================
    // VALIDASI DATA KUNJUNGAN
    // =============================================
    $check = mysqli_prepare($Conn, "
        SELECT id_kunjungan 
        FROM kunjungan 
        WHERE id_kunjungan = ?
    ");

    mysqli_stmt_bind_param($check, "i", $id_kunjungan);
    mysqli_stmt_execute($check);

    $result = mysqli_stmt_get_result($check);

    if (mysqli_num_rows($result) == 0) {
        echo json_encode([
            "status"  => "error",
            "message" => "Data kunjungan tidak ditemukan."
        ]);
        exit;
    }

    mysqli_stmt_close($check);

    $datetime_pelayanan = null;

    if ($status == "Dilayani") {
        $datetime_pelayanan = (new DateTime('now', new DateTimeZone('UTC')))->format('Y-m-d H:i:s');
    }

    // =============================================
    // DATETIME SELESAI
    // =============================================
    $datetime_selesai = null;

    if ($status == "Selesai" || $status == "Meninggal") {
        $datetime_selesai = (new DateTime('now', new DateTimeZone('UTC')))->format('Y-m-d H:i:s');
    }

    // =============================================
    // UPDATE STATUS
    // =============================================
    $updates = ["status = ?"];
    $params  = [$status];
    $types   = "s";

    if ($datetime_pelayanan !== null) {
        $updates[] = "datetime_pelayanan = ?";
        $params[]  = $datetime_pelayanan;
        $types    .= "s";
    }

    if ($datetime_selesai !== null) {
        $updates[] = "datetime_selesai = ?";
        $params[]  = $datetime_selesai;
        $types    .= "s";
    }

    $params[] = $id_kunjungan;
    $types   .= "i";

    $query = "UPDATE kunjungan SET " . implode(", ", $updates) . " WHERE id_kunjungan = ?";

    $stmt = mysqli_prepare($Conn, $query);

    if (!$stmt) {
        echo json_encode([
            "status"  => "error",
            "message" => mysqli_error($Conn)
        ]);
        exit;
    }

    mysqli_stmt_bind_param($stmt, $types, ...$params);

    // =============================================
    // EKSEKUSI
    // =============================================
    if (mysqli_stmt_execute($stmt)) {

        echo json_encode([
            "status"  => "success",
            "message" => "Status kunjungan berhasil diperbaharui.",
            "form"    => $from
        ]);

    } else {

        echo json_encode([
            "status"  => "error",
            "message" => mysqli_stmt_error($stmt)
        ]);
    }

    mysqli_stmt_close($stmt);
?>