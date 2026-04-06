<?php
    // Header JSON
    header('Content-Type: application/json');

    // Zona waktu
    date_default_timezone_set('Asia/Jakarta');

    // Include file
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";

    // Validasi session login
    if (empty($SessionIdAkses)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Sesi login telah berakhir. Silakan login ulang.'
        ]);
        exit;
    }

    // Validasi input
    if (empty($_POST['password1'])) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Password baru tidak boleh kosong.'
        ]);
        exit;
    }

    if (empty($_POST['password2'])) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Ulangi password tidak boleh kosong.'
        ]);
        exit;
    }

    $password1 = trim($_POST['password1']);
    $password2 = trim($_POST['password2']);

    $panjangPassword = strlen($password1);

    // Validasi panjang password
    if ($panjangPassword < 6 || $panjangPassword > 20) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Password harus 6–20 karakter.'
        ]);
        exit;
    }

    // Validasi kesamaan password
    if ($password1 !== $password2) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Password yang anda masukan tidak sama.'
        ]);
        exit;
    }

    // Hash password baru (AMAN)
    $passwordHash = password_hash($password1, PASSWORD_DEFAULT);

    // Update database dengan prepared statement
    $stmt = mysqli_prepare(
        $Conn,
        "UPDATE akses 
         SET password = ?
         WHERE id_akses = ?"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "si",
        $passwordHash,
        $SessionIdAkses
    );

    $update = mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    if ($update) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Password berhasil diperbarui.'
        ]);
        exit;
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Gagal memperbarui password.'
        ]);
        exit;
    }
?>