<?php
    // =========================================================
    // ERROR REPORTING
    // =========================================================
    error_reporting(0);
    ini_set('display_errors', 0);
    ob_start();

    // =========================================================
    // CONNECTION
    // =========================================================
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // =========================================================
    // HELPER
    // =========================================================
    function referensiImunisasiExportStop(string $message, int $status = 400): void
    {
        if (ob_get_length()) {
            ob_end_clean();
        }
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['jumlah' => 0, 'error' => $message]);
        exit;
    }

    // =========================================================
    // VALIDASI SESSION
    // =========================================================
    if (empty($SessionIdAkses)) {
        referensiImunisasiExportStop('Sesi akses berakhir. Silakan login kembali.', 401);
    }

    // =========================================================
    // VALIDASI METHOD
    // =========================================================
    if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
        referensiImunisasiExportStop('Metode request tidak valid.', 405);
    }

    // =========================================================
    // TANGKAP INPUT
    // =========================================================
    $mode        = (string) ($_POST['mode'] ?? '');
    $periodeData = (string) ($_POST['periode_data'] ?? 'Semua');

    // =========================================================
    // BUILD WHERE (berdasarkan datetime_creat)
    // =========================================================
    $where  = [];
    $params = [];
    $types  = '';

    if ($periodeData === 'Tahun') {
        $tahun = trim((string) ($_POST['tahun'] ?? ''));
        if ($tahun === '' || !preg_match('/^\d{4}$/', $tahun)) {
            referensiImunisasiExportStop('Tahun tidak valid.');
        }
        $where[]  = 'YEAR(datetime_creat) = ?';
        $params[] = (int) $tahun;
        $types   .= 'i';
    } elseif ($periodeData === 'Bulan') {
        $tahun = trim((string) ($_POST['tahun'] ?? ''));
        $bulan = trim((string) ($_POST['bulan'] ?? ''));
        if ($tahun === '' || !preg_match('/^\d{4}$/', $tahun)) {
            referensiImunisasiExportStop('Tahun tidak valid.');
        }
        if ($bulan === '' || !preg_match('/^(0[1-9]|1[0-2])$/', $bulan)) {
            referensiImunisasiExportStop('Bulan tidak valid.');
        }
        $where[]  = 'YEAR(datetime_creat) = ? AND MONTH(datetime_creat) = ?';
        $params[] = (int) $tahun;
        $params[] = (int) $bulan;
        $types   .= 'ii';
    } elseif ($periodeData === 'Periodik') {
        $awal  = trim((string) ($_POST['periode_awal'] ?? ''));
        $akhir = trim((string) ($_POST['periode_akhir'] ?? ''));
        $dAwal  = DateTime::createFromFormat('Y-m-d', $awal);
        $dAkhir = DateTime::createFromFormat('Y-m-d', $akhir);
        if (!$dAwal || $dAwal->format('Y-m-d') !== $awal || !$dAkhir || $dAkhir->format('Y-m-d') !== $akhir) {
            referensiImunisasiExportStop('Format periode tidak valid.');
        }
        if ($dAwal > $dAkhir) {
            referensiImunisasiExportStop('Periode awal tidak boleh lebih besar dari periode akhir.');
        }
        $where[]  = 'DATE(datetime_creat) >= ? AND DATE(datetime_creat) <= ?';
        $params[] = $awal;
        $params[] = $akhir;
        $types   .= 'ss';
    } elseif ($periodeData !== 'Semua') {
        referensiImunisasiExportStop('Periode data tidak valid.');
    }

    $whereSql = $where ? 'WHERE ' . implode(' AND ', $where) : '';

    // =========================================================
    // MODE COUNT (AJAX)
    // =========================================================
    if ($mode !== 'count') {
        referensiImunisasiExportStop('Mode tidak valid.');
    }

    if (ob_get_length()) {
        ob_end_clean();
    }
    header('Content-Type: application/json; charset=utf-8');

    $sql  = "SELECT COUNT(*) AS total FROM imunisasi_referensi " . $whereSql;
    $stmt = mysqli_prepare($Conn, $sql);
    if (!$stmt) {
        echo json_encode(['jumlah' => 0, 'error' => mysqli_error($Conn)]);
        exit;
    }
    if ($types !== '') {
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }
    if (!mysqli_stmt_execute($stmt)) {
        echo json_encode(['jumlah' => 0, 'error' => mysqli_stmt_error($stmt)]);
        mysqli_stmt_close($stmt);
        exit;
    }
    $result = mysqli_stmt_get_result($stmt);
    $row    = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    echo json_encode(['jumlah' => (int) ($row['total'] ?? 0)]);
    exit;
?>
