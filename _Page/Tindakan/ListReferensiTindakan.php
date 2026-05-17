<?php
    header('Content-Type: application/json');

    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";

    $search = $_POST['search'] ?? '';
    $page   = (int)($_POST['page'] ?? 1);

    $limit  = 20;
    $offset = ($page - 1) * $limit;

    $searchLike = "%$search%";

    $sql = "
        SELECT *
        FROM tindakan_referensi
        WHERE 
            nama_tindakan LIKE ?
        ORDER BY nama_tindakan ASC
        LIMIT ?, ?
    ";

    $stmt = $Conn->prepare($sql);
    $stmt->bind_param("sii", $searchLike, $offset, $limit);
    $stmt->execute();

    $result = $stmt->get_result();

    $results = [];

    while ($row = $result->fetch_assoc()) {

        $results[] = [
            'id'                    => $row['id_tindakan_referensi'],
            'text'                  => $row['id_tindakan_referensi'].' - '.$row['nama_tindakan'],

            'kategori_tindakan'     => $row['kategori_tindakan_display'],
            'nama_tindakan'         => $row['nama_tindakan_display'],
            'lokasi_tubuh'          => $row['lokasi_tubuh_display'],

            'icd9_code'             => $row['icd9_code'],
            'icd9_description'      => $row['icd9_description'],
            'icd9_text'             => $row['icd9_code'].' - '.$row['icd9_description']
        ];
    }

    // cek more
    $countSql = "
        SELECT COUNT(*) as total
        FROM tindakan_referensi
        WHERE nama_tindakan LIKE ?
    ";

    $countStmt = $Conn->prepare($countSql);
    $countStmt->bind_param("s", $searchLike);
    $countStmt->execute();

    $countResult = $countStmt->get_result()->fetch_assoc();

    $more = ($offset + $limit) < $countResult['total'];

    echo json_encode([
        'results' => $results,
        'pagination' => [
            'more' => $more
        ]
    ]);
?>