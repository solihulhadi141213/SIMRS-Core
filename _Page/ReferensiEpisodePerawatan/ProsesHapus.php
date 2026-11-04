<?php
    header('Content-Type: application/json; charset=utf-8');
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    if (empty($SessionIdAkses)) {
        echo json_encode(['status' => 'error', 'message' => 'Sesi akses berakhir. Silakan login kembali.'], JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE);
        exit;
    }
    if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
        echo json_encode(['status' => 'error', 'message' => 'Metode request tidak valid.'], JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE);
        exit;
    }

    $id_episode_perawatan_kode = filter_var(
        $_POST['id_episode_perawatan_kode'] ?? null,
        FILTER_VALIDATE_INT,
        ['options' => ['min_range' => 1]]
    );
    if ($id_episode_perawatan_kode === false || $id_episode_perawatan_kode === null) {
        echo json_encode(['status' => 'error', 'message' => 'ID Episode Perawatan tidak valid.'], JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE);
        exit;
    }

    $transactionStarted = false;
    try {
        $id_episode_perawatan_kode = (int) $id_episode_perawatan_kode;
        if (!mysqli_begin_transaction($Conn)) {
            throw new RuntimeException('Gagal memulai transaksi penghapusan.');
        }
        $transactionStarted = true;

        $stmtSelect = $Conn->prepare('SELECT * FROM episode_perawatan_kode WHERE id_episode_perawatan_kode = ? FOR UPDATE');
        if (!$stmtSelect) {
            throw new RuntimeException('Gagal menyiapkan data episode perawatan untuk dihapus.');
        }
        $stmtSelect->bind_param('i', $id_episode_perawatan_kode);
        if (!$stmtSelect->execute()) {
            throw new RuntimeException('Gagal mengambil data episode perawatan.');
        }
        $episode = $stmtSelect->get_result()->fetch_assoc();
        $stmtSelect->close();
        if (!$episode) {
            throw new RuntimeException('Data episode perawatan tidak ditemukan atau sudah dihapus.');
        }

        $metadata = json_encode($episode, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        if ($metadata === false) {
            throw new RuntimeException('Gagal membuat arsip data episode perawatan.');
        }

        $datetimeLog = (new DateTimeImmutable('now', new DateTimeZone('UTC')))->format('Y-m-d H:i:s');
        $petugasId = (int) $SessionIdAkses;
        $petugasNama = (string) $SessionNama;
        $titleLog = 'Hapus Episode Perawatan ID: ' . $id_episode_perawatan_kode;

        // SESUDAH (Dipecah ke dalam variabel agar bisa dipass by reference)
        $categoryLog = 'Episode Perawatan';

        $stmtLog = $Conn->prepare(
            'INSERT INTO log (id_akses, datetime_log, nama_petugas, title_log, category_log, metadata_log)
            VALUES (?, ?, ?, ?, ?, ?)'
        );
        if (!$stmtLog) {
            throw new RuntimeException('Gagal menyiapkan arsip penghapusan episode perawatan.');
        }

        $stmtLog->bind_param(
            'isssss', 
            $petugasId, 
            $datetimeLog, 
            $petugasNama, 
            $titleLog, 
            $categoryLog, // Menggunakan variabel
            $metadata     // Menggunakan variabel
        );
        if (!$stmtLog->execute()) {
            throw new RuntimeException('Gagal menyimpan arsip penghapusan episode perawatan.');
        }
        $stmtLog->close();

        // Eksekusi Hapus Data
        $stmtDelete = $Conn->prepare('DELETE FROM episode_perawatan_kode WHERE id_episode_perawatan_kode = ? LIMIT 1');
        if (!$stmtDelete) {
            throw new RuntimeException('Gagal menyiapkan penghapusan data episode perawatan.');
        }
        $stmtDelete->bind_param('i', $id_episode_perawatan_kode);
        if (!$stmtDelete->execute() || $stmtDelete->affected_rows !== 1) {
            throw new RuntimeException('Data episode perawatan gagal dihapus.');
        }
        $stmtDelete->close();

        if (!mysqli_commit($Conn)) {
            throw new RuntimeException('Gagal menyelesaikan transaksi penghapusan.');
        }
        $transactionStarted = false;

        echo json_encode(['status' => 'success', 'message' => 'Data episode perawatan berhasil dihapus.'], JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE);

    } catch (RuntimeException $exception) {
        if ($transactionStarted) {
            mysqli_rollback($Conn);
        }
        error_log('EpisodePerawatan hapus: gagal menghapus data: ' . $exception->getMessage());
        // Tampilkan pesan error spesifik agar Anda tahu letak kesalahannya saat debugging
        echo json_encode(['status' => 'error', 'message' => $exception->getMessage()], JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE);
    } catch (Throwable $exception) {
        if ($transactionStarted) {
            mysqli_rollback($Conn);
        }
        error_log('EpisodePerawatan hapus: gagal menghapus data: ' . $exception->getMessage());
        echo json_encode(['status' => 'error', 'message' => $exception->getMessage()], JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE);
    }
?>