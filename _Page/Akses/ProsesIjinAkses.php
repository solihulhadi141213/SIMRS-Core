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
$submittedFeatures = $_POST['id_akses_fitur'] ?? null;
if (!$idAkses || !is_array($submittedFeatures) || !$submittedFeatures) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Pengguna dan minimal satu fitur wajib dipilih.'], JSON_UNESCAPED_UNICODE);
    exit;
}

$featureIds = [];
foreach ($submittedFeatures as $featureId) {
    if (!is_int($featureId) && !is_string($featureId)) {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'Data fitur tidak valid.'], JSON_UNESCAPED_UNICODE);
        exit;
    }
    $featureId = filter_var($featureId, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
    if (!$featureId) {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'Data fitur tidak valid.'], JSON_UNESCAPED_UNICODE);
        exit;
    }
    $featureIds[] = (int) $featureId;
}
$featureIds = array_values(array_unique($featureIds));

$transactionStarted = false;
try {
    if (!$Conn->begin_transaction()) {
        throw new RuntimeException('Gagal memulai pembaruan izin akses.');
    }
    $transactionStarted = true;

    $stmtCheck = $Conn->prepare('SELECT id_akses FROM akses WHERE id_akses = ? FOR UPDATE');
    if (!$stmtCheck) {
        throw new RuntimeException('Gagal menyiapkan validasi pengguna.');
    }
    $stmtCheck->bind_param('i', $idAkses);
    if (!$stmtCheck->execute()) {
        $stmtCheck->close();
        throw new RuntimeException('Gagal memvalidasi pengguna.');
    }
    $userExists = $stmtCheck->get_result()->num_rows === 1;
    $stmtCheck->close();
    if (!$userExists) {
        throw new InvalidArgumentException('Data akses tidak ditemukan.');
    }

    // Pastikan seluruh fitur yang dikirim benar-benar terdaftar sebelum izin lama dihapus.
    $stmtFeature = $Conn->prepare('SELECT id_akses_fitur FROM akses_fitur WHERE id_akses_fitur = ?');
    if (!$stmtFeature) {
        throw new RuntimeException('Gagal menyiapkan validasi fitur akses.');
    }
    foreach ($featureIds as $featureId) {
        $stmtFeature->bind_param('i', $featureId);
        if (!$stmtFeature->execute()) {
            $stmtFeature->close();
            throw new RuntimeException('Gagal memvalidasi fitur akses.');
        }
        $featureExists = $stmtFeature->get_result()->num_rows === 1;
        if (!$featureExists) {
            $stmtFeature->close();
            throw new InvalidArgumentException('Salah satu fitur akses tidak ditemukan.');
        }
    }
    $stmtFeature->close();

    $stmtDelete = $Conn->prepare('DELETE FROM akses_acc WHERE id_akses = ?');
    if (!$stmtDelete) {
        throw new RuntimeException('Gagal menyiapkan penghapusan izin akses lama.');
    }
    $stmtDelete->bind_param('i', $idAkses);
    if (!$stmtDelete->execute()) {
        $stmtDelete->close();
        throw new RuntimeException('Gagal menghapus izin akses lama.');
    }
    $stmtDelete->close();

    $stmtInsert = $Conn->prepare('INSERT INTO akses_acc (id_akses, id_akses_fitur) VALUES (?, ?)');
    if (!$stmtInsert) {
        throw new RuntimeException('Gagal menyiapkan izin akses baru.');
    }
    foreach ($featureIds as $featureId) {
        $stmtInsert->bind_param('ii', $idAkses, $featureId);
        if (!$stmtInsert->execute()) {
            $stmtInsert->close();
            throw new RuntimeException('Gagal menyimpan izin akses baru.');
        }
    }
    $stmtInsert->close();

    aksesWriteAuditLog($Conn, (int) $SessionIdAkses, (string) $SessionNama, 'Memperbarui izin akses pengguna', [
        'id_akses' => $idAkses,
        'jumlah_fitur' => count($featureIds),
    ]);
    if (!$Conn->commit()) {
        throw new RuntimeException('Gagal menyelesaikan pembaruan izin akses.');
    }
    $transactionStarted = false;
    echo json_encode(['status' => 'success', 'message' => 'Izin akses berhasil diperbarui.'], JSON_UNESCAPED_UNICODE);
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
    error_log('Akses izin: ' . $error->getMessage());
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Izin akses gagal diperbarui.'], JSON_UNESCAPED_UNICODE);
}
