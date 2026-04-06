<?php
    ob_start();
    header('Content-Type: application/json; charset=utf-8');

    error_reporting(E_ALL);
    ini_set('display_errors', 0);

    date_default_timezone_set('Asia/Jakarta');

    try {
        include "../../_Config/Connection.php";
        include "../../_Config/SimrsFunction.php";
        include "../../_Config/Session.php";

        if (empty($SessionIdAkses)) {
            throw new Exception('Sesi login telah berakhir. Silakan login ulang.');
        }

        $judul_laporan  = trim($_POST['judul_laporan'] ?? '');
        $isi_laporan    = trim($_POST['isi_laporan'] ?? '');
        $status_laporan = trim($_POST['status_laporan'] ?? '');

        if ($judul_laporan === '') {
            throw new Exception('Judul laporan tidak boleh kosong.');
        }

        if (trim(strip_tags($isi_laporan)) === '') {
            throw new Exception('Isi laporan tidak boleh kosong.');
        }

        $allowed_status = ['Draft', 'Terkirim'];

        if (!in_array($status_laporan, $allowed_status)) {
            throw new Exception('Status laporan tidak valid.');
        }

        $id_akses = (int)$SessionIdAkses;
        $tanggal  = date('Y-m-d H:i:s');

        $stmt = mysqli_prepare(
            $Conn,
            "INSERT INTO akses_laporan 
            (
                id_akses,
                tanggal,
                judul,
                laporan,
                status
            ) 
            VALUES (?, ?, ?, ?, ?)"
        );

        if (!$stmt) {
            throw new Exception(mysqli_error($Conn));
        }

        mysqli_stmt_bind_param(
            $stmt,
            "issss",
            $id_akses,
            $tanggal,
            $judul_laporan,
            $isi_laporan,
            $status_laporan
        );

        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception(mysqli_stmt_error($stmt));
        }

        mysqli_stmt_close($stmt);

        ob_clean();
        echo json_encode([
            'status' => 'success',
            'message' => 'Laporan berhasil disimpan.'
        ]);
        exit;

    } catch (Exception $e) {

        ob_clean();
        echo json_encode([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
        exit;
    }
?>