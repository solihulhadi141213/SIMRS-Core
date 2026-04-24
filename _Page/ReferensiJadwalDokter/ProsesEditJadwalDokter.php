<?php
    header('Content-Type: application/json');

    date_default_timezone_set('Asia/Jakarta');

    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    $response = [
        'status' => 'error',
        'message' => 'Terjadi kesalahan.'
    ];

    // ==========================
    // VALIDASI SESSION
    // ==========================
    if (empty($SessionIdAkses)) {
        $response['message'] = 'Sesi akses berakhir, silakan login ulang.';
        echo json_encode($response);
        exit;
    }

    // ==========================
    // VALIDASI METHOD
    // ==========================
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $response['message'] = 'Metode request tidak valid.';
        echo json_encode($response);
        exit;
    }

    // ==========================
    // AMBIL DATA
    // ==========================
    $id_jadwal     = $_POST['id_jadwal'] ?? '';
    $id_dokter     = $_POST['id_dokter'] ?? '';
    $id_poliklinik = $_POST['id_poliklinik'] ?? '';
    $hari          = $_POST['hari'] ?? '';
    $jam_mulai     = $_POST['jam_mulai'] ?? '';
    $jam_selesai   = $_POST['jam_selesai'] ?? '';
    $kuota_jkn     = $_POST['kuota_jkn'] ?? 0;
    $kuota_non_jkn = $_POST['kuota_non_jkn'] ?? 0;
    $time_max      = $_POST['time_max'] ?? '';

    // ==========================
    // VALIDASI INPUT
    // ==========================
    if (empty($id_jadwal)) {
        $response['message'] = 'ID jadwal tidak valid.';
        echo json_encode($response);
        exit;
    }

    if (empty($id_dokter)) {
        $response['message'] = 'Dokter wajib dipilih.';
        echo json_encode($response);
        exit;
    }

    if (empty($id_poliklinik)) {
        $response['message'] = 'Poliklinik wajib dipilih.';
        echo json_encode($response);
        exit;
    }

    if (empty($hari)) {
        $response['message'] = 'Hari wajib dipilih.';
        echo json_encode($response);
        exit;
    }

    if (empty($jam_mulai) || empty($jam_selesai)) {
        $response['message'] = 'Jam mulai dan selesai wajib diisi.';
        echo json_encode($response);
        exit;
    }

    if ($jam_mulai >= $jam_selesai) {
        $response['message'] = 'Jam selesai harus lebih besar dari jam mulai.';
        echo json_encode($response);
        exit;
    }

    if (empty($time_max)) {
        $response['message'] = 'Batas waktu pendaftaran wajib dipilih.';
        echo json_encode($response);
        exit;
    }

    // ==========================
    // VALIDASI BENTROK (EXCLUDE DIRI SENDIRI)
    // ==========================
    $cekQuery = "
        SELECT id_jadwal 
        FROM jadwal_dokter 
        WHERE id_dokter = ?
        AND hari = ?
        AND id_jadwal != ?
        AND (
            (jam_mulai < ? AND jam_selesai > ?) OR
            (jam_mulai < ? AND jam_selesai > ?) OR
            (jam_mulai >= ? AND jam_selesai <= ?)
        )
    ";

    $stmtCek = mysqli_prepare($Conn, $cekQuery);

    mysqli_stmt_bind_param(
        $stmtCek,
        "isissssss",
        $id_dokter,
        $hari,
        $id_jadwal,
        $jam_selesai,
        $jam_mulai,
        $jam_mulai,
        $jam_selesai,
        $jam_mulai,
        $jam_selesai
    );

    mysqli_stmt_execute($stmtCek);
    $resultCek = mysqli_stmt_get_result($stmtCek);

    if (mysqli_num_rows($resultCek) > 0) {
        $response['message'] = 'Jadwal bentrok dengan jadwal lain.';
        echo json_encode($response);
        exit;
    }

    // ==========================
    // UPDATE DATA
    // ==========================
    $query = "
        UPDATE jadwal_dokter 
        SET 
            id_dokter = ?,
            id_poliklinik = ?,
            hari = ?,
            jam_mulai = ?,
            jam_selesai = ?,
            kuota_non_jkn = ?,
            kuota_jkn = ?,
            time_max = ?
        WHERE id_jadwal = ?
    ";

    $stmt = mysqli_prepare($Conn, $query);

    if (!$stmt) {
        $response['message'] = 'Gagal menyiapkan query.';
        echo json_encode($response);
        exit;
    }

    mysqli_stmt_bind_param(
        $stmt,
        "iisssiiii",
        $id_dokter,
        $id_poliklinik,
        $hari,
        $jam_mulai,
        $jam_selesai,
        $kuota_non_jkn,
        $kuota_jkn,
        $time_max,
        $id_jadwal
    );

    if (mysqli_stmt_execute($stmt)) {
        $response['status'] = 'success';
        $response['message'] = 'Data berhasil diperbarui.';
    } else {
        $response['message'] = 'Gagal memperbarui data.';
    }

    mysqli_stmt_close($stmt);
    echo json_encode($response);

?>