<?php
header('Content-Type: application/json; charset=utf-8');
include "../../_Config/Connection.php";
include "../../_Config/Session.php";

function observasiDeleteResponse(string $status, string $message): void
{
    echo json_encode(
        ['status' => $status, 'message' => $message],
        JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE
    );
    exit;
}

class ObservasiDeleteRequestException extends RuntimeException
{
}

if (empty($SessionIdAkses)) {
    observasiDeleteResponse('error', 'Sesi akses berakhir. Silakan login kembali.');
}
if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    observasiDeleteResponse('error', 'Metode request tidak valid.');
}

$idObservation = filter_var(
    $_POST['id_observation'] ?? null,
    FILTER_VALIDATE_INT,
    ['options' => ['min_range' => 1]]
);
if ($idObservation === false || $idObservation === null) {
    observasiDeleteResponse('error', 'ID observasi tidak valid.');
}
if (($_POST['pernyataan_petugas_penghapus'] ?? '') !== '1') {
    observasiDeleteResponse('error', 'Pernyataan persetujuan penghapusan wajib dicentang.');
}

$transactionStarted = false;
try {
    $idObservation = (int) $idObservation;
    if (!mysqli_begin_transaction($Conn)) {
        throw new RuntimeException('Gagal memulai transaksi penghapusan.');
    }
    $transactionStarted = true;

    $stmtSelect = $Conn->prepare('SELECT * FROM observation WHERE id_observation = ? FOR UPDATE');
    if (!$stmtSelect) {
        throw new RuntimeException('Gagal menyiapkan data observasi untuk dihapus.');
    }
    $stmtSelect->bind_param('i', $idObservation);
    if (!$stmtSelect->execute()) {
        throw new RuntimeException('Gagal mengambil data observasi.');
    }
    $observation = $stmtSelect->get_result()->fetch_assoc();
    $stmtSelect->close();
    if (!$observation) {
        throw new ObservasiDeleteRequestException('Data observasi tidak ditemukan atau sudah dihapus.');
    }

    $metadata = json_encode($observation, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    if ($metadata === false) {
        throw new RuntimeException('Gagal membuat arsip data observasi.');
    }

    $datetimeLog = (new DateTimeImmutable('now', new DateTimeZone('UTC')))->format('Y-m-d H:i:s');
    $petugasId = (int) $SessionIdAkses;
    $petugasNama = (string) $SessionNama;
    $titleLog = 'Hapus Data Observasi ' . $idObservation;

    $stmtLog = $Conn->prepare(
        'INSERT INTO log (id_akses, datetime_log, nama_petugas, title_log, metadata_log)
         VALUES (?, ?, ?, ?, ?)'
    );
    if (!$stmtLog) {
        throw new RuntimeException('Gagal menyiapkan arsip penghapusan observasi.');
    }
    $stmtLog->bind_param('issss', $petugasId, $datetimeLog, $petugasNama, $titleLog, $metadata);
    if (!$stmtLog->execute()) {
        throw new RuntimeException('Gagal menyimpan arsip penghapusan observasi.');
    }
    $stmtLog->close();

    $stmtDelete = $Conn->prepare('DELETE FROM observation WHERE id_observation = ? LIMIT 1');
    if (!$stmtDelete) {
        throw new RuntimeException('Gagal menyiapkan penghapusan data observasi.');
    }
    $stmtDelete->bind_param('i', $idObservation);
    if (!$stmtDelete->execute() || $stmtDelete->affected_rows !== 1) {
        throw new RuntimeException('Data observasi gagal dihapus.');
    }
    $stmtDelete->close();

    if (!mysqli_commit($Conn)) {
        throw new RuntimeException('Gagal menyelesaikan transaksi penghapusan.');
    }
    $transactionStarted = false;
    observasiDeleteResponse('success', 'Data observasi berhasil dihapus.');
} catch (ObservasiDeleteRequestException $exception) {
    if ($transactionStarted) {
        mysqli_rollback($Conn);
    }
    observasiDeleteResponse('error', $exception->getMessage());
} catch (Throwable $exception) {
    if ($transactionStarted) {
        mysqli_rollback($Conn);
    }
    error_log('Observasi hapus: gagal menghapus data: ' . $exception->getMessage());
    observasiDeleteResponse('error', 'Gagal menghapus data observasi. Silakan coba lagi.');
}
?>
