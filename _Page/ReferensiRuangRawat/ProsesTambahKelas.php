<?php
    header('Content-Type: application/json');

    date_default_timezone_set('Asia/Jakarta');

    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // ==============================
    // DEFAULT RESPONSE
    // ==============================
    $response = [
        'status'  => 'error',
        'message' => 'Terjadi kesalahan'
    ];

    // ==============================
    // VALIDASI SESSION
    // ==============================
    if (empty($SessionIdAkses)) {
        $response['message'] = 'Sesi akses berakhir! Silakan login ulang!';
        echo json_encode($response);
        exit;
    }

    // ==============================
    // AMBIL INPUT
    // ==============================
    $kode_kelas = trim($_POST['kode_kelas'] ?? '');
    $kelas      = trim($_POST['kelas'] ?? '');
    $status     = isset($_POST['status']) ? 1 : 0;

    // ==============================
    // VALIDASI WAJIB
    // ==============================
    if ($kode_kelas === '') {
        $response['message'] = 'Kode kelas tidak boleh kosong!';
        echo json_encode($response);
        exit;
    }

    if ($kelas === '') {
        $response['message'] = 'Nama kelas tidak boleh kosong!';
        echo json_encode($response);
        exit;
    }

    // ==============================
    // VALIDASI DUPLIKAT NAMA KELAS
    // ==============================
    $stmt = mysqli_prepare($Conn, "
        SELECT COUNT(*) as total 
        FROM rr_kelas_rawat 
        WHERE LOWER(kelas) = LOWER(?)
    ");

    mysqli_stmt_bind_param($stmt, "s", $kelas);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $row    = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if ($row['total'] > 0) {
        $response['message'] = 'Nama kelas sudah digunakan!';
        echo json_encode($response);
        exit;
    }

    // ==============================
    // INSERT DATA
    // ==============================
    $updatetime = date('Y-m-d H:i:s');

    $stmt = mysqli_prepare($Conn, "
        INSERT INTO rr_kelas_rawat (
            kode_kelas,
            kelas,
            status,
            updatetime
        ) VALUES (?, ?, ?, ?)
    ");

    if (!$stmt) {
        $response['message'] = 'Gagal menyiapkan query insert!';
        echo json_encode($response);
        exit;
    }

    mysqli_stmt_bind_param($stmt, "ssis", $kode_kelas, $kelas, $status, $updatetime);

    $execute = mysqli_stmt_execute($stmt);

    if ($execute) {
        $response['status']  = 'success';
        $response['message'] = 'Data berhasil disimpan';
    } else {
        $response['message'] = 'Gagal menyimpan data';
    }

    mysqli_stmt_close($stmt);

    // ==============================
    echo json_encode($response);