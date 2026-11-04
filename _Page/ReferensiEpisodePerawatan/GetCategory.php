<?php
    header('Content-Type: application/json');

    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";

    $data = [];

    if (empty($SessionIdAkses)) {
        echo json_encode($data);
        exit;
    }

    $keyword = trim($_POST['q'] ?? '');

    $sql = "
        SELECT DISTINCT episode_category
        FROM episode_perawatan_kode
        WHERE episode_category IS NOT NULL
        AND episode_category != ''
        AND episode_category LIKE ?
        ORDER BY episode_category ASC
        LIMIT 50
    ";

    $stmt = mysqli_prepare($Conn, $sql);
    if (!$stmt) {
        echo json_encode($data);
        exit;
    }

    $search = "%" . $keyword . "%";
    mysqli_stmt_bind_param($stmt, "s", $search);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($result)) {
        $kategori = trim($row['episode_category'] ?? '');
        if ($kategori === '') {
            continue;
        }

        $data[] = [
            'id' => $kategori,
            'text' => $kategori
        ];
    }

    mysqli_stmt_close($stmt);

    echo json_encode($data);
?>