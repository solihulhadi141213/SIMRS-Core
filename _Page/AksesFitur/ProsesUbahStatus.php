<?php
    // Header JSON
    header('Content-Type: application/json');

    // Timezone
    date_default_timezone_set('Asia/Jakarta');

    // Connection
    include "../../_Config/Connection.php";

    // Function
    include "../../_Config/SimrsFunction.php";

    // Session
    include "../../_Config/Session.php";
    
    // RESPONSE HELPER
    function jsonResponse($success, $message)
    {
        echo json_encode([
            'success' => $success,
            'message' => $message
        ]);
        exit;
    }

    // VALIDASI SESSION
    if (empty($SessionIdAkses)) {
        jsonResponse(false, 'Sesi login berakhir, silahkan login ulang');
    }

    // VALIDASI INPUT
    $id_akses = $_POST['id_akses'] ?? '';
    $id_akses_fitur = $_POST['id_akses_fitur'] ?? '';
    $status = $_POST['status'] ?? '';

    if (empty($id_akses)) {
        jsonResponse(false, 'ID akses tidak boleh kosong');
    }

    if (empty($id_akses_fitur)) {
        jsonResponse(false, 'ID akses fitur tidak boleh kosong');
    }

    if (!in_array($status, ['add', 'remove'])) {
        jsonResponse(false, 'Status tidak valid');
    }

    // CEK DUPLIKAT
    $stmtCheck = $Conn->prepare("
        SELECT id_akses_acc 
        FROM akses_acc 
        WHERE id_akses = ? 
        AND id_akses_fitur = ?
    ");
    $stmtCheck->bind_param("ii", $id_akses, $id_akses_fitur);
    $stmtCheck->execute();
    $resultCheck = $stmtCheck->get_result();
    $exist = $resultCheck->num_rows;
    $stmtCheck->close();


    // REMOVE
    if ($status == 'remove') {

        if ($exist == 0) {
            jsonResponse(false, 'Data akses tidak ditemukan');
        }

        $stmtDelete = $Conn->prepare("
            DELETE FROM akses_acc 
            WHERE id_akses = ? 
            AND id_akses_fitur = ?
        ");
        $stmtDelete->bind_param("ii", $id_akses, $id_akses_fitur);

        if ($stmtDelete->execute()) {
            jsonResponse(true, 'Ijin akses berhasil dihapus');
        } else {
            jsonResponse(false, 'Gagal menghapus ijin akses');
        }
    }


    // ADD
    if ($status == 'add') {

        // ANTISIPASI DUPLIKAT
        if ($exist > 0) {
            jsonResponse(false, 'Ijin akses sudah ada');
        }

        $stmtInsert = $Conn->prepare("
            INSERT INTO akses_acc (
                id_akses,
                id_akses_fitur
            ) VALUES (?, ?)
        ");
        $stmtInsert->bind_param("ii", $id_akses, $id_akses_fitur);

        if ($stmtInsert->execute()) {
            jsonResponse(true, 'Ijin akses berhasil ditambahkan');
        } else {
            jsonResponse(false, 'Gagal menambahkan ijin akses');
        }
    }
?>