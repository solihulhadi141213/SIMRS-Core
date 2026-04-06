<?php
    date_default_timezone_set('Asia/Jakarta');

    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // Validasi session
    if (empty($SessionIdAkses)) {
        echo '<div class="alert alert-danger">Sesi login berakhir. Silakan login ulang.</div>';
        exit;
    }

    // Validasi input
    if (
        empty($_POST['id_akses_laporan']) ||
        empty($_POST['judul_laporan']) ||
        empty($_POST['isi_laporan']) ||
        empty($_POST['status_laporan'])
    ) {
        echo '<div class="alert alert-danger">Semua field wajib diisi.</div>';
        exit;
    }

    // Tangkap data
    $id_akses_laporan = $_POST['id_akses_laporan'];
    $judul            = trim($_POST['judul_laporan']);
    $laporan          = trim($_POST['isi_laporan']);
    $status           = trim($_POST['status_laporan']);

    // Validasi status
    $allowed_status = ['Draft', 'Terkirim'];

    if (!in_array($status, $allowed_status)) {
        echo '<div class="alert alert-danger">Status tidak valid.</div>';
        exit;
    }

    // Update data
    $query = "
        UPDATE akses_laporan 
        SET judul = ?, laporan = ?, status = ?
        WHERE id_akses_laporan = ? 
        AND id_akses = ?
    ";

    $stmt = mysqli_prepare($Conn, $query);

    mysqli_stmt_bind_param(
        $stmt,
        "sssii",
        $judul,
        $laporan,
        $status,
        $id_akses_laporan,
        $SessionIdAkses
    );

    if (mysqli_stmt_execute($stmt)) {
        echo '
            <div class="alert alert-success success">
                Data laporan berhasil diperbarui.
            </div>
        ';
    } else {
        echo '
            <div class="alert alert-danger">
                Gagal memperbarui data laporan.
            </div>
        ';
    }

    mysqli_stmt_close($stmt);
?>