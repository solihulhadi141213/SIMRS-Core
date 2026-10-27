<?php
header('Content-Type: application/json; charset=UTF-8');

include "../../_Config/Connection.php";
include "../../_Config/Session.php";
include "AksesHelper.php";

if (empty($SessionIdAkses)) {
    http_response_code(401);
    echo json_encode(['status' => 'error', 'message' => 'Sesi berakhir.'], JSON_UNESCAPED_UNICODE);
    exit;
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Metode request tidak valid.'], JSON_UNESCAPED_UNICODE);
    exit;
}

$idAkses = filter_var($_POST['id_akses'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
if (!$idAkses) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'ID akses tidak valid.'], JSON_UNESCAPED_UNICODE);
    exit;
}

$transactionStarted = false;
try {
    if (!$Conn->begin_transaction()) {
        throw new RuntimeException('Gagal memulai penghapusan data akses.');
    }
    $transactionStarted = true;

    $stmt = $Conn->prepare('SELECT gambar FROM akses WHERE id_akses = ? FOR UPDATE');
    if (!$stmt) {
        throw new RuntimeException('Gagal menyiapkan data akses.');
    }
    $stmt->bind_param('i', $idAkses);
    if (!$stmt->execute()) {
        $stmt->close();
        throw new RuntimeException('Gagal memuat data akses.');
    }
    $data = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    if (!$data) {
        throw new InvalidArgumentException('Data akses tidak ditemukan.');
    }

    $stmtDelete = $Conn->prepare('DELETE FROM akses WHERE id_akses = ?');
    if (!$stmtDelete) {
        throw new RuntimeException('Gagal menyiapkan penghapusan data akses.');
    }
    $stmtDelete->bind_param('i', $idAkses);
    if (!$stmtDelete->execute() || $stmtDelete->affected_rows !== 1) {
        $stmtDelete->close();
        throw new RuntimeException('Gagal menghapus data akses.');
    }
    $stmtDelete->close();

    aksesWriteAuditLog($Conn, (int) $SessionIdAkses, (string) $SessionNama, 'Menghapus akses pengguna', [
        'id_akses' => $idAkses,
    ]);
    if (!$Conn->commit()) {
        throw new RuntimeException('Gagal menyelesaikan penghapusan data akses.');
    }
    $transactionStarted = false;

    aksesRemoveImage((string) ($data['gambar'] ?? ''));
    echo json_encode(['status' => 'success', 'message' => 'Data berhasil dihapus.'], JSON_UNESCAPED_UNICODE);
} catch (InvalidArgumentException $error) {
    if ($transactionStarted) {
        $Conn->rollback();
    }
    http_response_code(404);
    echo json_encode(['status' => 'error', 'message' => $error->getMessage()], JSON_UNESCAPED_UNICODE);
} catch (Throwable $error) {
    if ($transactionStarted) {
        $Conn->rollback();
    }
    error_log('Akses hapus: ' . $error->getMessage());
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Data akses gagal dihapus.'], JSON_UNESCAPED_UNICODE);
}
