
<?php
    // Content Type
    header('Content-Type: application/json; charset=utf-8');

    date_default_timezone_set('Asia/Jakarta');

    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // Fungsi response JSON
    function SendResponse($status, $message)
    {
        echo json_encode([
            'status'  => $status,
            'message' => $message
        ], JSON_UNESCAPED_UNICODE);

        exit;
    }

    // Validasi sesi
    if (empty($SessionIdAkses)) {
        SendResponse('error', 'Sesi akses berakhir, silakan login ulang.');
    }

    // Validasi metode request
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        SendResponse('error', 'Metode request tidak valid.');
    }

    // Validasi ID poliklinik
    $id_poliklinik = (int) ($_POST['id_poliklinik'] ?? 0);

    if ($id_poliklinik <= 0) {
        SendResponse('error', 'ID poliklinik tidak valid.');
    }

    // Ambil data lama sekaligus validasi keberadaan data
    $stmtData = mysqli_prepare(
        $Conn,
        "SELECT poliklinik, kode
        FROM poliklinik
        WHERE id_poliklinik = ?
        LIMIT 1"
    );

    if (!$stmtData) {
        SendResponse('error', 'Gagal menyiapkan query validasi data.');
    }

    mysqli_stmt_bind_param($stmtData, "i", $id_poliklinik);
    mysqli_stmt_execute($stmtData);

    $resultData = mysqli_stmt_get_result($stmtData);
    $dataLama = mysqli_fetch_assoc($resultData);

    mysqli_stmt_close($stmtData);

    if (!$dataLama) {
        SendResponse('error', 'Data poliklinik tidak ditemukan.');
    }

    // Proses hapus data
    $stmtDelete = mysqli_prepare(
        $Conn,
        "DELETE FROM poliklinik
        WHERE id_poliklinik = ?"
    );

    if (!$stmtDelete) {
        SendResponse('error', 'Gagal menyiapkan query hapus data.');
    }

    mysqli_stmt_bind_param($stmtDelete, "i", $id_poliklinik);

    if (!mysqli_stmt_execute($stmtDelete)) {
        mysqli_stmt_close($stmtDelete);
        SendResponse('error', 'Gagal menghapus data poliklinik.');
    }

    $affectedRows = mysqli_stmt_affected_rows($stmtDelete);

    mysqli_stmt_close($stmtDelete);

    if ($affectedRows <= 0) {
        SendResponse('error', 'Data poliklinik gagal dihapus.');
    }

    // Simpan log
    SaveLog(
        $Conn,
        (int) $SessionIdAkses,
        (string) $SessionNama,
        'Hapus Referensi Poliklinik',
        [
            'id_poliklinik' => $id_poliklinik,
            'poliklinik'    => $dataLama['poliklinik'],
            'kode'          => $dataLama['kode']
        ]
    );

    // Response berhasil
    SendResponse('success', 'Data poliklinik berhasil dihapus.');
