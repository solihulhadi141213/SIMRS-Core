<?php
// Menghapus antrean beserta riwayat status, lalu mencatat aktivitas penghapusan.
header('Content-Type: application/json; charset=utf-8');
include "../../_Config/Connection.php";
include "../../_Config/Session.php";

/** Mengirim respons JSON error dengan status HTTP yang sesuai lalu menghentikan proses. */
function antrianDeleteJsonError(string $message, int $statusCode = 400): void
{
    http_response_code($statusCode);
    echo json_encode(['status' => 'error', 'message' => $message], JSON_UNESCAPED_UNICODE);
    exit;
}

// Validasi sesi dan metode request sebelum menerima instruksi penghapusan.
if (empty($SessionIdAkses)) {
    antrianDeleteJsonError('Sesi berakhir. Silakan login kembali.', 401);
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    antrianDeleteJsonError('Metode request tidak valid.', 405);
}
$idAntrian = (int) ($_POST['id_antrian'] ?? 0);
if (!$idAntrian) {
    antrianDeleteJsonError('ID antrian tidak valid.');
}
// Pastikan persetujuan yang ditampilkan pada modal juga dikirim ke server.
if (empty($_POST['pernyataan_petugas_penghapus_antrian'])) {
    antrianDeleteJsonError('Checklist pernyataan petugas wajib dicentang.');
}

// Hapus riwayat dan antrean dalam satu transaksi agar kegagalan dapat dibatalkan.
if (!mysqli_begin_transaction($Conn)) {
    antrianDeleteJsonError('Gagal memulai penghapusan antrian.', 500);
}
$utcNow = (new DateTimeImmutable('now', new DateTimeZone('UTC')))->format('Y-m-d H:i:s');
$stmtLog = mysqli_prepare($Conn, "DELETE FROM antrian_log WHERE id_antrian = ?");
$stmtQueue = mysqli_prepare($Conn, "DELETE FROM antrian WHERE id_antrian = ?");
if (!$stmtLog || !$stmtQueue) {
    if ($stmtLog) {
        mysqli_stmt_close($stmtLog);
    }
    if ($stmtQueue) {
        mysqli_stmt_close($stmtQueue);
    }
    mysqli_rollback($Conn);
    antrianDeleteJsonError('Gagal menyiapkan penghapusan antrian.', 500);
}
mysqli_stmt_bind_param($stmtLog, 'i', $idAntrian);
mysqli_stmt_bind_param($stmtQueue, 'i', $idAntrian);
if (!mysqli_stmt_execute($stmtLog) || !mysqli_stmt_execute($stmtQueue)) {
    mysqli_stmt_close($stmtLog);
    mysqli_stmt_close($stmtQueue);
    mysqli_rollback($Conn);
    antrianDeleteJsonError('Gagal menghapus data antrian.', 500);
}
$deleted = mysqli_stmt_affected_rows($stmtQueue);
mysqli_stmt_close($stmtLog);
mysqli_stmt_close($stmtQueue);
if ($deleted !== 1) {
    mysqli_rollback($Conn);
    antrianDeleteJsonError('Data antrian tidak ditemukan.', 404);
}
// Simpan jejak aktivitas pada log utama sebelum transaksi dinyatakan berhasil.
$logTitle = 'Menghapus data antrian';
$logMetadata = json_encode(['id_antrian' => $idAntrian], JSON_UNESCAPED_UNICODE);
$stmtAudit = mysqli_prepare(
    $Conn,
    "INSERT INTO log (id_akses, datetime_log, nama_petugas, title_log, metadata_log)
     VALUES (?, ?, ?, ?, ?)"
);
if (!$stmtAudit || $logMetadata === false) {
    if ($stmtAudit) {
        mysqli_stmt_close($stmtAudit);
    }
    mysqli_rollback($Conn);
    antrianDeleteJsonError('Gagal menyiapkan pencatatan penghapusan antrian.', 500);
}
mysqli_stmt_bind_param($stmtAudit, 'issss', $SessionIdAkses, $utcNow, $SessionNama, $logTitle, $logMetadata);
if (!mysqli_stmt_execute($stmtAudit)) {
    mysqli_stmt_close($stmtAudit);
    mysqli_rollback($Conn);
    antrianDeleteJsonError('Gagal mencatat aktivitas penghapusan antrian.', 500);
}
mysqli_stmt_close($stmtAudit);
if (!mysqli_commit($Conn)) {
    mysqli_rollback($Conn);
    antrianDeleteJsonError('Gagal menyelesaikan penghapusan antrian.', 500);
}
echo json_encode(['status' => 'success', 'message' => 'Data antrian berhasil dihapus.'], JSON_UNESCAPED_UNICODE);
?>
