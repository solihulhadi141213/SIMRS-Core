<?php
header('Content-Type: text/html; charset=utf-8');
include "../../_Config/Connection.php";
include "../../_Config/Session.php";

function observasiExportFormMessage(string $message, int $status = 200, string $type = 'danger'): void
{
    http_response_code($status);
    echo '<div class="alert alert-' . htmlspecialchars($type, ENT_QUOTES, 'UTF-8') . ' mb-0">'
        . htmlspecialchars($message, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8')
        . '</div>';
    exit;
}

if (empty($SessionIdAkses)) {
    observasiExportFormMessage('Sesi akses berakhir. Silakan login kembali.', 401);
}
if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'GET') {
    observasiExportFormMessage('Metode request tidak valid.', 405);
}

// Prepared Statement: hitung observasi yang tersedia untuk ekspor.
$countStmt = mysqli_prepare($Conn, 'SELECT COUNT(*) AS total FROM observation');
if (!$countStmt || !mysqli_stmt_execute($countStmt)) {
    error_log('Observasi export: gagal menghitung data: ' . mysqli_error($Conn));
    observasiExportFormMessage('Gagal menghitung data observasi.', 500);
}
$countResult = mysqli_stmt_get_result($countStmt);
$total = (int) (mysqli_fetch_assoc($countResult)['total'] ?? 0);
mysqli_free_result($countResult);
?>
<div data-export-count="<?php echo $total; ?>">
    <?php if ($total < 1): ?>
        <div class="alert alert-info mb-0">
            <i class="bi bi-info-circle me-1"></i> Belum ada data observasi yang dapat diekspor.
        </div>
    <?php else: ?>
        <div class="alert alert-info">
            Sistem akan mengekspor <b><?php echo number_format($total, 0, ',', '.'); ?> data observasi</b> ke file Excel.
        </div>
        <input type="hidden" name="expected_count" value="<?php echo $total; ?>">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="ConfirmExportObservation" name="confirm_export" value="1" required>
            <label class="form-check-label" for="ConfirmExportObservation">
                Saya yakin dan menyetujui export seluruh data observasi.
            </label>
        </div>
    <?php endif; ?>
</div>
