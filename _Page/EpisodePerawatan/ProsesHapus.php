<?php
    // ==========================================
    // ProsesHapus.php - Hapus Episode Perawatan
    // ==========================================

    header("Content-Type: application/json; charset=utf-8");

    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    /**
     * Fungsi Response JSON
     */
    function ResponseHapus($status, $message, $id_episode_perawatan = null)
    {
        echo json_encode([
            "status"               => $status,
            "message"              => $message,
            "id_episode_perawatan" => $id_episode_perawatan
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    /**
     * 1. Validasi Sesi Login
     */
    if (empty($SessionIdAkses)) {
        ResponseHapus("error", "Sesi akses sudah berakhir, silakan login ulang.");
    }

    /**
     * 2. Validasi Metode Request (Harus POST)
     */
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        ResponseHapus("error", "Metode request tidak valid.");
    }

    /**
     * 3. Validasi ID Episode Perawatan
     */
    if (empty($_POST['id_episode_perawatan']) || !ctype_digit($_POST['id_episode_perawatan'])) {
        ResponseHapus("error", "ID Episode Perawatan tidak valid atau kosong.");
    }

    $id_episode_perawatan = (int) $_POST['id_episode_perawatan'];

    /**
     * 4. Cek Keberadaan Data di Database Sebelum Dihapus
     */
    $stmtCheck = mysqli_prepare($Conn, "SELECT id_episode_perawatan, kode_episode_perawatan, id_pasien FROM episode_perawatan WHERE id_episode_perawatan = ? LIMIT 1");
    if (!$stmtCheck) {
        ResponseHapus("error", "Gagal mempersiapkan query cek data.");
    }

    mysqli_stmt_bind_param($stmtCheck, "i", $id_episode_perawatan);
    mysqli_stmt_execute($stmtCheck);
    $resultCheck = mysqli_stmt_get_result($stmtCheck);
    $dataEpisode = mysqli_fetch_assoc($resultCheck);
    mysqli_stmt_close($stmtCheck);

    if (!$dataEpisode) {
        ResponseHapus("error", "Data episode perawatan tidak ditemukan atau sudah dihapus sebelumnya.");
    }

    /**
     * 5. Eksekusi Query Hapus Menggunakan Prepared Statement
     */
    $stmtDelete = mysqli_prepare($Conn, "DELETE FROM episode_perawatan WHERE id_episode_perawatan = ?");
    if (!$stmtDelete) {
        ResponseHapus("error", "Gagal mempersiapkan query hapus data.");
    }

    mysqli_stmt_bind_param($stmtDelete, "i", $id_episode_perawatan);

    if (!mysqli_stmt_execute($stmtDelete)) {
        $errorMsg = mysqli_stmt_error($stmtDelete);
        mysqli_stmt_close($stmtDelete);
        error_log("Hapus Episode Perawatan Error: " . $errorMsg);
        ResponseHapus("error", "Gagal menghapus data episode perawatan dari database.");
    }

    mysqli_stmt_close($stmtDelete);

    /**
     * 6. Catat Aktivitas ke Log Sistem Menggunakan SaveLog
     */
    SaveLog(
        $Conn,
        $SessionIdAkses,
        $SessionNama,
        "Hapus Episode Perawatan",
        "Episode Perawatan",
        [
            "id_episode_perawatan"   => $id_episode_perawatan,
            "kode_episode_perawatan" => $dataEpisode['kode_episode_perawatan'],
            "id_pasien"              => $dataEpisode['id_pasien']
        ]
    );

    /**
     * 7. Kirim Respons Sukses
     */
    ResponseHapus(
        "success",
        "Data episode perawatan berhasil dihapus.",
        $id_episode_perawatan
    );
?>