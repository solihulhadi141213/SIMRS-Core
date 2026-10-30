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
        "SELECT id_praktisi, nama_praktisi, tipe_praktisi, profesi_praktisi, id_dokter
         FROM praktisi
         WHERE (? = '' OR nama_praktisi LIKE ? OR profesi_praktisi LIKE ? OR tipe_praktisi LIKE ?)
         ORDER BY nama_praktisi ASC
         LIMIT 50"
    );

    if (!$stmt) {
        echo json_encode(['error' => 'Gagal menyiapkan query praktisi.']);
        exit;
    }

    mysqli_stmt_bind_param($stmt, 'ssss', $keyword, $search, $search, $search);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $rows = [];
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $id = (string)$row['id_praktisi'];
            $nama = (string)($row['nama_praktisi'] ?? '');
            $profesi = (string)($row['profesi_praktisi'] ?? '');
            $tipe = (string)($row['tipe_praktisi'] ?? '');
            $text = $nama;
            if ($profesi !== '') {
                $text .= ' - ' . $profesi;
            }
            $rows[] = [
                'id' => $id,
                'text' => $text,
                'id_praktisi' => $id,
                'nama_praktisi' => $nama,
                'tipe_praktisi' => $tipe,
                'profesi_praktisi' => $profesi,
                'id_dokter' => (string)($row['id_dokter'] ?? ''),
            ];
        }
    }

    mysqli_stmt_close($stmt);

    echo json_encode(['results' => $rows], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>

