<?php
    ob_start();
    header('Content-Type: application/json; charset=utf-8');
    error_reporting(E_ALL);
    ini_set('display_errors', 0);

    // Zona waktu
    date_default_timezone_set('Asia/Jakarta');

    try {
        // Include file
        include "../../_Config/Connection.php";
        include "../../_Config/Session.php";
        include "../../_Config/SimrsFunction.php";

        // Validasi session login
        if (empty($SessionIdAkses)) {
            throw new Exception('Sesi login telah berakhir. Silakan login ulang.');
        }

        // Validasi input
        $id_akses_laporan = isset($_POST['id_akses_laporan'])
            ? (int) $_POST['id_akses_laporan']
            : 0;

        if ($id_akses_laporan <= 0) {
            throw new Exception('ID Laporan tidak boleh kosong.');
        }

        // Pastikan laporan milik user yang sedang login
        $stmtSelect = mysqli_prepare(
            $Conn,
            "SELECT id_akses 
             FROM akses_laporan 
             WHERE id_akses_laporan = ? 
             LIMIT 1"
        );

        if (!$stmtSelect) {
            throw new Exception(mysqli_error($Conn));
        }

        mysqli_stmt_bind_param($stmtSelect, "i", $id_akses_laporan);
        mysqli_stmt_execute($stmtSelect);
        $resultSelect = mysqli_stmt_get_result($stmtSelect);
        $dataLaporan  = mysqli_fetch_array($resultSelect, MYSQLI_ASSOC);
        mysqli_stmt_close($stmtSelect);

        if (empty($dataLaporan['id_akses'])) {
            throw new Exception('Data laporan tidak ditemukan.');
        }

        if ((int)$dataLaporan['id_akses'] !== (int)$SessionIdAkses) {
            throw new Exception('Anda tidak berhak menghapus laporan ini.');
        }

        // Hapus data dengan prepared statement
        $stmtDelete = mysqli_prepare(
            $Conn,
            "DELETE FROM akses_laporan 
             WHERE id_akses_laporan = ? 
             AND id_akses = ?"
        );

        if (!$stmtDelete) {
            throw new Exception(mysqli_error($Conn));
        }

        mysqli_stmt_bind_param(
            $stmtDelete,
            "ii",
            $id_akses_laporan,
            $SessionIdAkses
        );

        mysqli_stmt_execute($stmtDelete);

        if (mysqli_stmt_affected_rows($stmtDelete) < 1) {
            mysqli_stmt_close($stmtDelete);
            throw new Exception('Laporan gagal dihapus.');
        }

        mysqli_stmt_close($stmtDelete);

        ob_clean();
        echo json_encode([
            'status'  => 'success',
            'message' => 'Laporan berhasil dihapus.'
        ]);
        exit;

    } catch (Exception $e) {
        ob_clean();
        echo json_encode([
            'status'  => 'error',
            'message' => $e->getMessage()
        ]);
        exit;
    }
?>
