<?php
    header('Content-Type: application/json');

    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";

    function response($status, $message){
        echo json_encode([
            "status" => $status,
            "message" => $message
        ]);
        exit;
    }

    // Validasi session
    if (empty($SessionIdAkses)) {
        response("error", "Sesi berakhir.");
    }

    // Validasi input
    if (empty($_POST['id_icd']) || !is_numeric($_POST['id_icd'])) {
        response("error", "ID tidak valid.");
    }

    $id_icd = (int) $_POST['id_icd'];

    // Cek data ada
    $sql = "SELECT id_icd FROM icd WHERE id_icd = ?";
    $stmt = mysqli_prepare($Conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id_icd);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 0) {
        response("error", "Data tidak ditemukan.");
    }
    mysqli_stmt_close($stmt);

    // Hapus data (hard delete)
    $sql_delete = "DELETE FROM icd WHERE id_icd = ?";
    $stmt = mysqli_prepare($Conn, $sql_delete);
    mysqli_stmt_bind_param($stmt, "i", $id_icd);

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        response("success", "Data berhasil dihapus.");
    } else {
        mysqli_stmt_close($stmt);
        response("error", "Gagal menghapus data.");
    }
?>