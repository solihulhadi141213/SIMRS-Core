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
        "SELECT id_body_site, body_site_category, body_site_nama, body_site_display, body_site_code, body_site_system
         FROM body_site
         WHERE (? = '' OR body_site_category LIKE ? OR body_site_nama LIKE ? OR body_site_display LIKE ? OR body_site_code LIKE ? OR body_site_system LIKE ?)
         ORDER BY body_site_nama ASC
         LIMIT 50"
    );

    if (!$stmt) {
        echo json_encode(['error' => 'Gagal menyiapkan query body site.']);
        exit;
    }

    mysqli_stmt_bind_param($stmt, 'ssssss', $keyword, $search, $search, $search, $search, $search);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $rows = [];
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $id = (string)$row['id_body_site'];
            $nama = (string)($row['body_site_nama'] ?? '');
            $rows[] = [
                'id' => $id,
                'text' => $nama,
                'body_site_category' => (string)($row['body_site_category'] ?? ''),
                'body_site_nama' => $nama,
                'body_site_display' => (string)($row['body_site_display'] ?? ''),
                'body_site_code' => (string)($row['body_site_code'] ?? ''),
                'body_site_system' => (string)($row['body_site_system'] ?? ''),
            ];
        }
    }

    mysqli_stmt_close($stmt);

    echo json_encode(['results' => $rows], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>

