<?php
    date_default_timezone_set('Asia/Jakarta');

    header('Content-Type: application/json');

    // Koneksi, Session, Function
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";

    function respond($status, $message){
        echo json_encode([
            'status' => $status,
            'message' => $message
        ]);
        exit;
    }

    // Validasi method
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        respond('error', 'Invalid request method');
    }

    // Ambil input
    $email  = trim($_POST['email'] ?? '');
    $kontak = trim($_POST['kontak'] ?? '');

    // Validasi
    if ($email === '') {
        respond('error', 'Email tidak boleh kosong');
    }
    if ($kontak === '') {
        respond('error', 'Nomor kontak tidak boleh kosong');
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        respond('error', 'Format email tidak valid');
    }

    if (strlen($email) > 200) {
        respond('error', 'Email maksimal 200 karakter');
    }
    if (strlen($kontak) > 20) {
        respond('error', 'Kontak maksimal 20 karakter');
    }

    // Ambil email lama
    $stmtOld = mysqli_prepare($Conn, "SELECT email FROM akses WHERE id_akses = ?");
    if (!$stmtOld) {
        respond('error', 'Query gagal (stmtOld)');
    }

    mysqli_stmt_bind_param($stmtOld, 's', $SessionIdAkses);
    mysqli_stmt_execute($stmtOld);
    mysqli_stmt_bind_result($stmtOld, $EmailLama);
    mysqli_stmt_fetch($stmtOld);
    mysqli_stmt_close($stmtOld);

    if (!$EmailLama) {
        respond('error', 'Data akses tidak ditemukan');
    }

    // Cek email duplicate
    if ($email !== $EmailLama) {
        $stmtCheck = mysqli_prepare($Conn, "SELECT COUNT(*) FROM akses WHERE email = ?");
        if (!$stmtCheck) {
            respond('error', 'Query gagal (stmtCheck)');
        }

        mysqli_stmt_bind_param($stmtCheck, 's', $email);
        mysqli_stmt_execute($stmtCheck);
        mysqli_stmt_bind_result($stmtCheck, $countEmail);
        mysqli_stmt_fetch($stmtCheck);
        mysqli_stmt_close($stmtCheck);

        if ($countEmail > 0) {
            respond('error', 'Email sudah digunakan user lain');
        }
    }

    // Update
    $stmtUpdate = mysqli_prepare($Conn, "UPDATE akses SET email = ?, kontak = ? WHERE id_akses = ?");
    if (!$stmtUpdate) {
        respond('error', 'Query gagal (update)');
    }

    mysqli_stmt_bind_param($stmtUpdate, 'sss', $email, $kontak, $SessionIdAkses);

    if (!mysqli_stmt_execute($stmtUpdate)) {
        mysqli_stmt_close($stmtUpdate);
        respond('error', 'Gagal update data');
    }

    mysqli_stmt_close($stmtUpdate);

    // Success
    respond('success', 'Profile berhasil diperbarui');