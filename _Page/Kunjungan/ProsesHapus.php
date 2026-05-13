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
    $from         = validate($_POST['from'] ?? '');

    // =============================================
    // VALIDASI
    // =============================================
    if (empty($id_kunjungan)) {
        echo json_encode([
            "status"  => "error",
            "message" => "ID kunjungan tidak boleh kosong."
        ]);
        exit;
    }

    // =============================================
    // VALIDASI DATA KUNJUNGAN
    // =============================================
    $check = mysqli_prepare($Conn, "
        SELECT 
            id_kunjungan,
            status
        FROM kunjungan
        WHERE id_kunjungan = ?
    ");

    if (!$check) {
        echo json_encode([
            "status"  => "error",
            "message" => mysqli_error($Conn)
        ]);
        exit;
    }

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

    $data_kunjungan = mysqli_fetch_assoc($result);

    mysqli_stmt_close($check);

    // =============================================
    // OPTIONAL VALIDASI STATUS
    // =============================================
    // Jika ingin hanya boleh hapus status tertentu
    /*
    if ($data_kunjungan['status'] == 'Selesai') {
        echo json_encode([
            "status"  => "error",
            "message" => "Kunjungan yang sudah selesai tidak dapat dihapus."
        ]);
        exit;
    }
    */

    // =============================================
    // HAPUS DATA
    // =============================================
    $query = "DELETE FROM kunjungan WHERE id_kunjungan = ?";

    $stmt = mysqli_prepare($Conn, $query);

    if (!$stmt) {
        echo json_encode([
            "status"  => "error",
            "message" => mysqli_error($Conn)
        ]);
        exit;
    }

    mysqli_stmt_bind_param($stmt, "i", $id_kunjungan);

    // =============================================
    // EKSEKUSI
    // =============================================
    if (mysqli_stmt_execute($stmt)) {

        echo json_encode([
            "status"  => "success",
            "message" => "Data kunjungan berhasil dihapus.",
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