<?php
    header('Content-Type: application/json; charset=utf-8');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";

    if (empty($SessionIdAkses)) {
        echo json_encode(['error' => 'Sesi berakhir. Silakan login kembali.']);
        exit;
    }

    $id_pasien = (int)($_GET['id_pasien'] ?? $_POST['id_pasien'] ?? 0);

    if ($id_pasien <= 0) {
        echo json_encode(['results' => []]);
        exit;
    }

    $stmt = mysqli_prepare(
        $Conn,
        "SELECT id_kunjungan, datetime_daftar, jenis_kunjungan, poliklinik, dokter
         FROM kunjungan
         WHERE id_pasien = ?
         ORDER BY datetime_daftar DESC, id_kunjungan DESC
         LIMIT 50"
    );

    if (!$stmt) {
        echo json_encode(['error' => 'Gagal menyiapkan query kunjungan.']);
        exit;
    }

    mysqli_stmt_bind_param($stmt, "i", $id_pasien);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $rows = [];
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $idKunjungan = (string)$row['id_kunjungan'];
            $tanggal = !empty($row['datetime_daftar']) ? date('d/m/Y H:i', strtotime((string)$row['datetime_daftar'])) : '-';
            $jenis = (string)($row['jenis_kunjungan'] ?? '-');
            $poli = (string)($row['poliklinik'] ?? '');
            $dokter = (string)($row['dokter'] ?? '');
            $text = 'Kunjungan #' . $idKunjungan . ' - ' . $tanggal . ' - ' . $jenis;
            $rows[] = [
                'id' => $idKunjungan,
                'id_kunjungan' => $idKunjungan,
                'text' => $text,
                'tanggal_kunjungan' => $tanggal,
                'jenis_kunjungan' => $jenis,
                'poliklinik' => $poli,
                'dokter' => $dokter,
            ];
        }
    }

    mysqli_stmt_close($stmt);

    echo json_encode(['results' => $rows], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>

