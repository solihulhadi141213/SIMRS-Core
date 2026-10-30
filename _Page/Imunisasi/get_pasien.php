<?php
    header('Content-Type: application/json; charset=utf-8');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";

    if (empty($SessionIdAkses)) {
        echo json_encode(['error' => 'Sesi berakhir. Silakan login kembali.']);
        exit;
    }

    $term = $_GET['term'] ?? '';
    $keyword = is_scalar($term) ? trim((string)$term) : '';
    $page = filter_var($_GET['page'] ?? 1, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
    if ($page === false || $page === null) {
        $page = 1;
    }
    $page = min((int)$page, 100000);
    $pageSize = 20;
    $offset = ($page - 1) * $pageSize;
    $search = '%' . $keyword . '%';

    $stmt = mysqli_prepare(
        $Conn,
        "SELECT id_pasien, nama, nik, no_bpjs, gender, kontak
         FROM pasien
         WHERE status = 'Active'
           AND (? = '' OR nama LIKE ? OR nik LIKE ? OR CAST(id_pasien AS CHAR) LIKE ?)
         ORDER BY nama ASC, id_pasien ASC
         LIMIT ? OFFSET ?"
    );

    if (!$stmt) {
        echo json_encode(['error' => 'Gagal menyiapkan pencarian pasien.']);
        exit;
    }

    $fetchLimit = $pageSize + 1;
    mysqli_stmt_bind_param($stmt, 'ssssii', $keyword, $search, $search, $search, $fetchLimit, $offset);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $patients = [];
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $idPasien = (string)$row['id_pasien'];
            $nama = (string)$row['nama'];
            $patients[] = [
                'id' => $idPasien,
                'id_pasien' => $idPasien,
                'text' => 'No. RM ' . $idPasien . ' — ' . $nama,
                'nama' => $nama,
                'nik' => (string)($row['nik'] ?? ''),
                'no_bpjs' => (string)($row['no_bpjs'] ?? ''),
                'gender' => (string)($row['gender'] ?? ''),
                'kontak' => (string)($row['kontak'] ?? ''),
            ];
        }
    }
    mysqli_stmt_close($stmt);

    $hasMore = count($patients) > $pageSize;
    if ($hasMore) {
        array_pop($patients);
    }

    echo json_encode([
        'results' => $patients,
        'pagination' => ['more' => $hasMore],
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>

