<?php
    header('Content-Type: application/json; charset=utf-8');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";

    if (empty($SessionIdAkses)) {
        echo json_encode(['error' => 'Sesi berakhir. Silakan login kembali.']);
        exit;
    }

    $term = $_GET['term'] ?? $_POST['term'] ?? '';
    $keyword = is_scalar($term) ? trim((string)$term) : '';

    $search = '%' . $keyword . '%';

    $stmt = mysqli_prepare(
        $Conn,
        "SELECT id_imunisasi_referensi, nama_vaksin, kode_cvx, kode_kemenkes, status
         FROM imunisasi_referensi
         WHERE status = 1
           AND (? = '' OR nama_vaksin LIKE ? OR kode_cvx LIKE ? OR kode_kemenkes LIKE ?)
         ORDER BY nama_vaksin ASC
         LIMIT 50"
    );

    if (!$stmt) {
        echo json_encode(['error' => 'Gagal menyiapkan query referensi imunisasi.']);
        exit;
    }

    mysqli_stmt_bind_param($stmt, 'ssss', $keyword, $search, $search, $search);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $rows = [];
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $id = (string)$row['id_imunisasi_referensi'];
            $nama = (string)($row['nama_vaksin'] ?? '');
            $rows[] = [
                'id' => $id,
                'text' => $nama,
                'nama_vaksin' => $nama,
                'kode_cvx' => (string)($row['kode_cvx'] ?? ''),
                'kode_kemenkes' => (string)($row['kode_kemenkes'] ?? ''),
            ];
        }
    }

    mysqli_stmt_close($stmt);

    echo json_encode(['results' => $rows], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>

